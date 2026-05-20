<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Billing\App\Models\Client;
use Modules\Billing\App\Models\Invoice;
use Modules\Billing\App\Models\InvoiceItem;
use Modules\Billing\App\Models\Quotation;

class InvoiceController extends Controller
{
    private const DEFAULT_TNC = "**Masa Pengerjaan**\nPengerjaan dimulai setelah DP 50% diterima. Estimasi pengerjaan adalah 2 minggu sejak DP dan data/materi lengkap diterima.\n\n**Pembayaran**\nDP sebesar 50% dibayarkan di awal. Pelunasan dilakukan setelah sistem selesai dan siap diserahterimakan.\n\n**Support & Garansi**\nKlien mendapatkan support selamanya untuk bantuan penggunaan dan perbaikan kendala pada modul yang telah disepakati. Support tidak termasuk penambahan fitur baru.\n\n**Penyesuaian Fitur**\nGaransi penyesuaian fitur berlaku selama 3 bulan setelah serah terima, selama masih berkaitan dengan modul yang telah disepakati.\n\n**Hosting, Domain & Email**\nHosting, domain, dan email termasuk untuk tahun pertama, lalu diperpanjang setiap tahun dengan biaya perpanjangan yang disepakati bersama.\n\n**Kesepakatan**\nSetiap perubahan atau penambahan fitur wajib disepakati terlebih dahulu. Fitur tambahan di luar ruang lingkup awal dapat dikenakan biaya tambahan.";

    public function index()
    {
        $user = Auth::user();

        $invoices = $user->isDirector()
            ? Invoice::with(['client', 'creator'])->latest()->get()
            : Invoice::where('created_by', $user->id)->with(['client', 'creator'])->latest()->get();

        return view('billing::invoices.index', compact('user', 'invoices'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $quotations = $user->isDirector()
            ? Quotation::where('status', 'approved')->with('client')->orderBy('quotation_number')->get()
            : Quotation::where('created_by', $user->id)->where('status', 'approved')
                ->with('client')->orderBy('quotation_number')->get();

        $fromQuotation = null;
        if ($request->filled('from_quotation')) {
            $fromQuotation = Quotation::with(['client', 'items'])
                ->findOrFail($request->from_quotation);
        }

        $defaultTnc = self::DEFAULT_TNC;
        return view('billing::invoices.create', compact('user', 'clients', 'quotations', 'fromQuotation', 'defaultTnc'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'quotation_id'        => ['nullable', 'exists:quotations,id'],
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'notes'               => ['nullable', 'string'],
            'invoice_date'        => ['required', 'date'],
            'due_date'            => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
        ]);

        $invoice = Invoice::create([
            'client_id'            => $data['client_id'],
            'quotation_id'         => $data['quotation_id'] ?? null,
            'created_by'           => Auth::id(),
            'title'                => $data['title'],
            'description'          => $data['description'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'notes'                => $data['notes'] ?? null,
            'invoice_date'         => $data['invoice_date'],
            'due_date'             => $data['due_date'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
            'status'               => 'draft',
        ]);

        foreach ($data['items'] as $item) {
            $amount = $item['quantity'] * $item['unit_price'];
            InvoiceItem::create([
                'invoice_id'  => $invoice->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'amount'      => $amount,
            ]);
        }

        $invoice->load('items');
        $invoice->calculateTotals();
        $invoice->save();

        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        $this->authorizeView($invoice, $user);
        $invoice->load(['client', 'creator', 'approver', 'items', 'quotation']);

        return view('billing::invoices.show', compact('user', 'invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $user = Auth::user();
        $this->authorizeEdit($invoice, $user);

        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $quotations = $user->isDirector()
            ? Quotation::where('status', 'approved')->with('client')->orderBy('quotation_number')->get()
            : Quotation::where('created_by', $user->id)->where('status', 'approved')
                ->with('client')->orderBy('quotation_number')->get();

        $invoice->load('items');
        return view('billing::invoices.create', compact('user', 'clients', 'quotations', 'invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorizeEdit($invoice, Auth::user());

        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'quotation_id'        => ['nullable', 'exists:quotations,id'],
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'notes'               => ['nullable', 'string'],
            'invoice_date'        => ['required', 'date'],
            'due_date'            => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
        ]);

        $invoice->update([
            'client_id'            => $data['client_id'],
            'quotation_id'         => $data['quotation_id'] ?? null,
            'title'                => $data['title'],
            'description'          => $data['description'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'notes'                => $data['notes'] ?? null,
            'invoice_date'         => $data['invoice_date'],
            'due_date'             => $data['due_date'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
        ]);

        $invoice->items()->delete();
        foreach ($data['items'] as $item) {
            $amount = $item['quantity'] * $item['unit_price'];
            InvoiceItem::create([
                'invoice_id'  => $invoice->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'amount'      => $amount,
            ]);
        }

        $invoice->load('items');
        $invoice->calculateTotals();
        $invoice->save();

        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice berhasil diperbarui.');
    }

    public function submit(Invoice $invoice)
    {
        $this->authorizeEdit($invoice, Auth::user());

        if ($invoice->status !== 'draft') {
            return back()->with('error', 'Hanya invoice draft yang bisa diajukan.');
        }

        $invoice->update(['status' => 'pending_approval']);
        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice berhasil diajukan untuk persetujuan Director.');
    }

    public function approve(Invoice $invoice)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $invoice->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice berhasil disetujui dan siap diterbitkan.');
    }

    public function reject(Invoice $invoice)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $invoice->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice telah ditolak.');
    }

    public function markPaid(Invoice $invoice)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        if ($invoice->status !== 'approved') {
            return back()->with('error', 'Hanya invoice yang disetujui yang bisa ditandai lunas.');
        }

        $invoice->update(['status' => 'paid']);
        return redirect()->route('billing.invoices.show', $invoice)
            ->with('success', 'Invoice ditandai sebagai Lunas.');
    }

    public function destroy(Invoice $invoice)
    {
        $this->authorizeEdit($invoice, Auth::user());
        $invoice->delete();

        return redirect()->route('billing.invoices.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }

    private function authorizeView(Invoice $inv, $user): void
    {
        if (!$user->isDirector() && $inv->created_by !== $user->id) {
            abort(403);
        }
    }

    private function authorizeEdit(Invoice $inv, $user): void
    {
        if (!$user->isDirector() && $inv->created_by !== $user->id) {
            abort(403);
        }
        if (!in_array($inv->status, ['draft']) && !$user->isDirector()) {
            abort(403, 'Invoice yang sudah diajukan tidak dapat diedit.');
        }
    }
}
