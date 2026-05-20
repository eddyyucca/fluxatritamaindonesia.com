<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Billing\App\Models\Client;
use Modules\Billing\App\Models\Quotation;
use Modules\Billing\App\Models\QuotationItem;

class QuotationController extends Controller
{
    private const DEFAULT_TNC = "**Masa Pengerjaan**\nPengerjaan dimulai setelah DP 50% diterima. Estimasi pengerjaan adalah 2 minggu sejak DP dan data/materi lengkap diterima.\n\n**Pembayaran**\nDP sebesar 50% dibayarkan di awal. Pelunasan dilakukan setelah sistem selesai dan siap diserahterimakan.\n\n**Support & Garansi**\nKlien mendapatkan support selamanya untuk bantuan penggunaan dan perbaikan kendala pada modul yang telah disepakati. Support tidak termasuk penambahan fitur baru.\n\n**Penyesuaian Fitur**\nGaransi penyesuaian fitur berlaku selama 3 bulan setelah serah terima, selama masih berkaitan dengan modul yang telah disepakati.\n\n**Hosting, Domain & Email**\nHosting, domain, dan email termasuk untuk tahun pertama, lalu diperpanjang setiap tahun dengan biaya perpanjangan yang disepakati bersama.\n\n**Kesepakatan**\nSetiap perubahan atau penambahan fitur wajib disepakati terlebih dahulu. Fitur tambahan di luar ruang lingkup awal dapat dikenakan biaya tambahan.";

    public function index()
    {
        $user = Auth::user();

        $quotations = $user->isDirector()
            ? Quotation::with(['client', 'creator'])->latest()->get()
            : Quotation::where('created_by', $user->id)->with(['client', 'creator'])->latest()->get();

        return view('billing::quotations.index', compact('user', 'quotations'));
    }

    public function create()
    {
        $user    = Auth::user();
        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $defaultTnc = self::DEFAULT_TNC;
        return view('billing::quotations.create', compact('user', 'clients', 'defaultTnc'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'notes'               => ['nullable', 'string'],
            'valid_until'         => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
        ]);

        $quotation = Quotation::create([
            'client_id'            => $data['client_id'],
            'created_by'           => Auth::id(),
            'title'                => $data['title'],
            'description'          => $data['description'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'notes'                => $data['notes'] ?? null,
            'valid_until'          => $data['valid_until'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
            'status'               => 'draft',
        ]);

        foreach ($data['items'] as $item) {
            $amount = $item['quantity'] * $item['unit_price'];
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'description'  => $item['description'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'amount'       => $amount,
            ]);
        }

        $quotation->load('items');
        $quotation->calculateTotals();
        $quotation->save();

        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation berhasil dibuat.');
    }

    public function show(Quotation $quotation)
    {
        $user = Auth::user();
        $this->authorizeView($quotation, $user);
        $quotation->load(['client', 'creator', 'approver', 'items']);

        return view('billing::quotations.show', compact('user', 'quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $user = Auth::user();
        $this->authorizeEdit($quotation, $user);

        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $quotation->load('items');
        return view('billing::quotations.create', compact('user', 'clients', 'quotation'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $this->authorizeEdit($quotation, Auth::user());

        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'notes'               => ['nullable', 'string'],
            'valid_until'         => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string'],
            'items.*.quantity'    => ['required', 'integer', 'min:1'],
            'items.*.unit_price'  => ['required', 'numeric', 'min:0'],
        ]);

        $quotation->update([
            'client_id'            => $data['client_id'],
            'title'                => $data['title'],
            'description'          => $data['description'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'notes'                => $data['notes'] ?? null,
            'valid_until'          => $data['valid_until'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
            // Jika sebelumnya sudah diajukan/disetujui, revisi wajib approval ulang
            'status'               => 'draft',
            'approved_by'          => null,
            'approved_at'          => null,
            'director_notes'       => null,
        ]);

        $quotation->items()->delete();
        foreach ($data['items'] as $item) {
            $amount = $item['quantity'] * $item['unit_price'];
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'description'  => $item['description'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'amount'       => $amount,
            ]);
        }

        $quotation->load('items');
        $quotation->calculateTotals();
        $quotation->save();

        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation berhasil diperbarui. Status dikembalikan ke Draft — ajukan kembali untuk persetujuan.');
    }

    public function submit(Quotation $quotation)
    {
        $this->authorizeEdit($quotation, Auth::user());

        if ($quotation->status !== 'draft') {
            return back()->with('error', 'Hanya quotation draft yang bisa diajukan.');
        }

        $quotation->update(['status' => 'sent']);
        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation berhasil diajukan untuk persetujuan.');
    }

    public function approve(Request $request, Quotation $quotation)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $request->validate(['director_notes' => ['nullable', 'string', 'max:1000']]);

        $quotation->update([
            'status'         => 'approved',
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'director_notes' => $request->director_notes,
        ]);

        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation berhasil disetujui.');
    }

    public function reject(Request $request, Quotation $quotation)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $request->validate(['director_notes' => ['nullable', 'string', 'max:1000']]);

        $quotation->update([
            'status'         => 'rejected',
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'director_notes' => $request->director_notes,
        ]);

        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation telah ditolak.');
    }

    public function revert(Quotation $quotation)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        if (!in_array($quotation->status, ['sent', 'approved', 'rejected'])) {
            return back()->with('error', 'Quotation ini tidak bisa dikembalikan ke draft.');
        }

        $quotation->update([
            'status'      => 'draft',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->route('billing.quotations.show', $quotation)
            ->with('success', 'Quotation berhasil dikembalikan ke Draft untuk diedit ulang.');
    }

    public function destroy(Quotation $quotation)
    {
        $user = Auth::user();
        $this->authorizeEdit($quotation, $user);
        $quotation->delete();

        return redirect()->route('billing.quotations.index')
            ->with('success', 'Quotation berhasil dihapus.');
    }

    private function authorizeView(Quotation $q, $user): void
    {
        if (!$user->isDirector() && $q->created_by !== $user->id) {
            abort(403);
        }
    }

    private function authorizeEdit(Quotation $q, $user): void
    {
        if (!$user->isDirector() && $q->created_by !== $user->id) {
            abort(403);
        }
        // Non-director can only edit drafts
        if (!in_array($q->status, ['draft']) && !$user->isDirector()) {
            abort(403, 'Quotation yang sudah diajukan tidak dapat diedit.');
        }
    }
}
