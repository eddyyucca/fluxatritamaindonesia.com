<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Billing\App\Models\Client;
use Modules\Billing\App\Models\AppProposal;
use Modules\Billing\App\Models\AppProposalItem;

class AppProposalController extends Controller
{
    private const DEFAULT_TNC = "**Masa Pengerjaan**\nPengerjaan dimulai setelah DP 50% diterima. Estimasi pengerjaan bergantung pada kompleksitas dan kesepakatan.\n\n**Pembayaran**\nDP sebesar 50% dibayarkan di awal. Pelunasan dilakukan setelah sistem selesai dan siap diserahterimakan.\n\n**Support & Garansi**\nKlien mendapatkan support untuk bantuan penggunaan dan perbaikan kendala pada modul yang telah disepakati. Support tidak termasuk penambahan fitur baru.\n\n**Penyesuaian Fitur**\nGaransi penyesuaian fitur berlaku selama 3 bulan setelah serah terima, selama masih berkaitan dengan modul yang telah disepakati.\n\n**Hosting & Domain**\nHosting dan domain termasuk untuk tahun pertama, lalu diperpanjang setiap tahun dengan biaya perpanjangan yang disepakati bersama.\n\n**Kesepakatan**\nSetiap perubahan atau penambahan fitur wajib disepakati terlebih dahulu. Fitur tambahan di luar ruang lingkup awal dapat dikenakan biaya tambahan.";

    public function index()
    {
        $user = Auth::user();

        $proposals = $user->isDirector()
            ? AppProposal::with(['client', 'creator'])->latest()->get()
            : AppProposal::where('created_by', $user->id)->with(['client', 'creator'])->latest()->get();

        return view('billing::app_proposals.index', compact('user', 'proposals'));
    }

    public function create()
    {
        $user    = Auth::user();
        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $defaultTnc = self::DEFAULT_TNC;
        return view('billing::app_proposals.create', compact('user', 'clients', 'defaultTnc'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'cover_title'         => ['required', 'string', 'max:255'],
            'cover_subtitle'      => ['nullable', 'string', 'max:255'],
            'introduction'        => ['nullable', 'string'],
            'scope_of_work'       => ['nullable', 'string'],
            'technology_stack'    => ['nullable', 'string'],
            'timeline_notes'      => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'valid_until'         => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.item_name'   => ['required', 'string'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.amount'      => ['required', 'numeric', 'min:0'],
        ]);

        $proposal = AppProposal::create([
            'client_id'            => $data['client_id'],
            'created_by'           => Auth::id(),
            'cover_title'          => $data['cover_title'],
            'cover_subtitle'       => $data['cover_subtitle'] ?? null,
            'introduction'         => $data['introduction'] ?? null,
            'scope_of_work'        => $data['scope_of_work'] ?? null,
            'technology_stack'     => $data['technology_stack'] ?? null,
            'timeline_notes'       => $data['timeline_notes'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'valid_until'          => $data['valid_until'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
            'status'               => 'draft',
        ]);

        foreach ($data['items'] as $item) {
            AppProposalItem::create([
                'app_proposal_id' => $proposal->id,
                'item_name'       => $item['item_name'],
                'description'     => $item['description'] ?? null,
                'amount'          => $item['amount'],
            ]);
        }

        $proposal->load('items');
        $proposal->calculateTotals();
        $proposal->save();

        return redirect()->route('billing.app_proposals.show', $proposal)
            ->with('success', 'Proposal Aplikasi berhasil dibuat.');
    }

    public function show(AppProposal $app_proposal)
    {
        $user = Auth::user();
        $this->authorizeView($app_proposal, $user);
        $app_proposal->load(['client', 'creator', 'approver', 'items']);

        return view('billing::app_proposals.show', compact('user', 'app_proposal'));
    }

    public function edit(AppProposal $app_proposal)
    {
        $user = Auth::user();
        $this->authorizeEdit($app_proposal, $user);

        $clients = $user->isDirector()
            ? Client::orderBy('name')->get()
            : Client::where('created_by', $user->id)->orderBy('name')->get();

        $app_proposal->load('items');
        return view('billing::app_proposals.create', compact('user', 'clients', 'app_proposal'));
    }

    public function update(Request $request, AppProposal $app_proposal)
    {
        $this->authorizeEdit($app_proposal, Auth::user());

        $data = $request->validate([
            'client_id'           => ['required', 'exists:clients,id'],
            'cover_title'         => ['required', 'string', 'max:255'],
            'cover_subtitle'      => ['nullable', 'string', 'max:255'],
            'introduction'        => ['nullable', 'string'],
            'scope_of_work'       => ['nullable', 'string'],
            'technology_stack'    => ['nullable', 'string'],
            'timeline_notes'      => ['nullable', 'string'],
            'terms_and_conditions'=> ['nullable', 'string'],
            'valid_until'         => ['nullable', 'date'],
            'pt_profit_percent'   => ['required', 'numeric', 'min:0', 'max:100'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.item_name'   => ['required', 'string'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.amount'      => ['required', 'numeric', 'min:0'],
        ]);

        $app_proposal->update([
            'client_id'            => $data['client_id'],
            'cover_title'          => $data['cover_title'],
            'cover_subtitle'       => $data['cover_subtitle'] ?? null,
            'introduction'         => $data['introduction'] ?? null,
            'scope_of_work'        => $data['scope_of_work'] ?? null,
            'technology_stack'     => $data['technology_stack'] ?? null,
            'timeline_notes'       => $data['timeline_notes'] ?? null,
            'terms_and_conditions' => $data['terms_and_conditions'] ?? null,
            'valid_until'          => $data['valid_until'] ?? null,
            'pt_profit_percent'    => $data['pt_profit_percent'],
            'status'               => 'draft',
            'approved_by'          => null,
            'approved_at'          => null,
            'director_notes'       => null,
        ]);

        $app_proposal->items()->delete();
        foreach ($data['items'] as $item) {
            AppProposalItem::create([
                'app_proposal_id' => $app_proposal->id,
                'item_name'       => $item['item_name'],
                'description'     => $item['description'] ?? null,
                'amount'          => $item['amount'],
            ]);
        }

        $app_proposal->load('items');
        $app_proposal->calculateTotals();
        $app_proposal->save();

        return redirect()->route('billing.app_proposals.show', $app_proposal)
            ->with('success', 'Proposal Aplikasi berhasil diperbarui. Status dikembalikan ke Draft.');
    }

    public function submit(AppProposal $app_proposal)
    {
        $this->authorizeEdit($app_proposal, Auth::user());

        if ($app_proposal->status !== 'draft') {
            return back()->with('error', 'Hanya proposal draft yang bisa diajukan.');
        }

        $app_proposal->update(['status' => 'sent']);
        return redirect()->route('billing.app_proposals.show', $app_proposal)
            ->with('success', 'Proposal berhasil diajukan untuk persetujuan.');
    }

    public function approve(Request $request, AppProposal $app_proposal)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $request->validate(['director_notes' => ['nullable', 'string', 'max:1000']]);

        $app_proposal->update([
            'status'         => 'approved',
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'director_notes' => $request->director_notes,
        ]);

        return redirect()->route('billing.app_proposals.show', $app_proposal)
            ->with('success', 'Proposal berhasil disetujui.');
    }

    public function reject(Request $request, AppProposal $app_proposal)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $request->validate(['director_notes' => ['nullable', 'string', 'max:1000']]);

        $app_proposal->update([
            'status'         => 'rejected',
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'director_notes' => $request->director_notes,
        ]);

        return redirect()->route('billing.app_proposals.show', $app_proposal)
            ->with('success', 'Proposal telah ditolak.');
    }

    public function revert(AppProposal $app_proposal)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        if (!in_array($app_proposal->status, ['sent', 'approved', 'rejected'])) {
            return back()->with('error', 'Proposal ini tidak bisa dikembalikan ke draft.');
        }

        $app_proposal->update([
            'status'      => 'draft',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->route('billing.app_proposals.show', $app_proposal)
            ->with('success', 'Proposal berhasil dikembalikan ke Draft untuk diedit ulang.');
    }

    public function destroy(AppProposal $app_proposal)
    {
        $user = Auth::user();
        $this->authorizeEdit($app_proposal, $user);
        $app_proposal->delete();

        return redirect()->route('billing.app_proposals.index')
            ->with('success', 'Proposal Aplikasi berhasil dihapus.');
    }

    private function authorizeView(AppProposal $p, $user): void
    {
        if (!$user->isDirector() && $p->created_by !== $user->id) {
            abort(403);
        }
    }

    private function authorizeEdit(AppProposal $p, $user): void
    {
        if (!$user->isDirector() && $p->created_by !== $user->id) {
            abort(403);
        }
        if (!in_array($p->status, ['draft']) && !$user->isDirector()) {
            abort(403, 'Proposal yang sudah diajukan tidak dapat diedit.');
        }
    }
}
