<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Billing\App\Models\Invoice;
use Modules\Billing\App\Models\Quotation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isDirector()) {
            $stats = $this->directorStats();
        } else {
            $stats = $this->userStats($user);
        }

        $recentQuotations = $user->isDirector()
            ? Quotation::with(['client', 'creator'])->latest()->take(5)->get()
            : Quotation::where('created_by', $user->id)->with('client')->latest()->take(5)->get();

        $recentInvoices = $user->isDirector()
            ? Invoice::with(['client', 'creator'])->latest()->take(5)->get()
            : Invoice::where('created_by', $user->id)->with('client')->latest()->take(5)->get();

        return view('dashboard::index', compact('user', 'stats', 'recentQuotations', 'recentInvoices'));
    }

    public function users()
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $users = User::where('role', '!=', 'candidate')->latest()->get();
        return view('dashboard::users', compact('users'));
    }

    public function createUser()
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }
        return view('dashboard::user-form');
    }

    public function storeUser(Request $request)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'role'     => ['required', 'in:director,admin,staff,hr,finance,user'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $randomPassword = \Illuminate\Support\Str::random(10);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($randomPassword),
            'role'     => $data['role'],
            'position' => $data['position'] ?? null,
            'must_change_password' => true,
        ]);

        return redirect()->route('dashboard.users')
            ->with('success', "Pengguna berhasil ditambahkan. Password sementara: {$randomPassword}");
    }

    public function editUser(\App\Models\User $user)
    {
        if (!Auth::user()->isDirector()) abort(403);
        $positions = \App\Models\Position::active()->orderBy('name')->get();
        // Ambil data atasan (yang bukan user ini sendiri)
        $supervisors = \App\Models\User::where('id', '!=', $user->id)
            ->where('role', '!=', 'candidate')
            ->orderBy('name')->get();
        return view('dashboard::user-edit', compact('user', 'positions', 'supervisors'));
    }

    public function updateUser(Request $request, \App\Models\User $user)
    {
        if (!Auth::user()->isDirector()) abort(403);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'     => ['required', 'in:director,admin,staff,hr,finance,user'],
            'position' => ['nullable', 'string', 'max:100'],
            'org_level' => ['nullable', 'integer', 'min:1', 'max:5'],
            'parent_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['min:8']]);
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            $data['must_change_password'] = true; // force change if director resets it
        }

        $user->update($data);

        return redirect()->route('dashboard.users')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function organization()
    {
        // Get all users with their subordinates recursively to build the tree
        // It's often easier to get all and build tree in memory or view for small numbers
        $users = User::where('role', '!=', 'candidate')->get();
        // The top level users (no parent)
        $topLevelUsers = User::whereNull('parent_id')->where('role', '!=', 'candidate')->orderBy('org_level')->get();
        return view('dashboard::organization', compact('users', 'topLevelUsers'));
    }

    public function editOrganization()
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $users = User::where('role', '!=', 'candidate')->get();
        return view('dashboard::organization-edit', compact('users'));
    }

    public function updateOrganization(Request $request)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $data = $request->validate([
            'org_data' => ['required', 'array'],
            'org_data.*.user_id' => ['required', 'exists:users,id'],
            'org_data.*.parent_id' => ['nullable', 'exists:users,id'],
            'org_data.*.org_level' => ['nullable', 'integer'],
        ]);

        foreach ($data['org_data'] as $item) {
            // Prevent user from being their own parent
            if ($item['user_id'] == $item['parent_id']) {
                $item['parent_id'] = null;
            }

            User::where('id', $item['user_id'])->update([
                'parent_id' => $item['parent_id'] ?? null,
                'org_level' => $item['org_level'] ?? null,
            ]);
        }

        return redirect()->route('dashboard.organization')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function positions()
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }
        $positions = Position::orderBy('name')->get();
        return view('dashboard::positions', compact('positions'));
    }

    public function storePosition(Request $request)
    {
        if (!Auth::user()->isDirector()) abort(403);
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:positions,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        Position::create($data);
        return redirect()->route('dashboard.positions')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function updatePosition(Request $request, Position $position)
    {
        if (!Auth::user()->isDirector()) abort(403);
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:positions,name,' . $position->id],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active'   => ['boolean'],
        ]);
        $position->update($data);
        return redirect()->route('dashboard.positions')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroyPosition(Position $position)
    {
        if (!Auth::user()->isDirector()) abort(403);
        $position->delete();
        return redirect()->route('dashboard.positions')->with('success', 'Jabatan berhasil dihapus.');
    }

    private function directorStats(): array
    {
        $thisMonth = now()->startOfMonth();

        return [
            'total_quotations'      => Quotation::count(),
            'pending_quotations'    => Quotation::where('status', 'sent')->count(),
            'total_invoices'        => Invoice::count(),
            'pending_invoices'      => Invoice::where('status', 'pending_approval')->count(),
            'paid_invoices'         => Invoice::where('status', 'paid')->count(),
            'total_revenue'         => Invoice::where('status', 'paid')->sum('total'),
            'pt_profit_total'       => Invoice::where('status', 'paid')->sum('pt_profit_amount'),
            'monthly_revenue'       => Invoice::where('status', 'paid')->where('updated_at', '>=', $thisMonth)->sum('total'),
            'monthly_pt_profit'     => Invoice::where('status', 'paid')->where('updated_at', '>=', $thisMonth)->sum('pt_profit_amount'),
            'total_staff'           => User::where('role', 'user')->count(),
            'total_clients'         => \Modules\Billing\App\Models\Client::count(),
        ];
    }

    private function userStats(User $user): array
    {
        $thisMonth = now()->startOfMonth();

        return [
            'my_quotations'         => Quotation::where('created_by', $user->id)->count(),
            'my_pending_quotations' => Quotation::where('created_by', $user->id)->where('status', 'sent')->count(),
            'my_invoices'           => Invoice::where('created_by', $user->id)->count(),
            'my_pending_invoices'   => Invoice::where('created_by', $user->id)->where('status', 'pending_approval')->count(),
            'my_paid_invoices'      => Invoice::where('created_by', $user->id)->where('status', 'paid')->count(),
            'my_total_revenue'      => Invoice::where('created_by', $user->id)->where('status', 'paid')->sum('total'),
            'my_user_amount'        => Invoice::where('created_by', $user->id)->where('status', 'paid')->sum('user_amount'),
            'my_pt_deduction'       => Invoice::where('created_by', $user->id)->where('status', 'paid')->sum('pt_profit_amount'),
            'my_monthly_revenue'    => Invoice::where('created_by', $user->id)->where('status', 'paid')->where('updated_at', '>=', $thisMonth)->sum('total'),
            'my_monthly_share'      => Invoice::where('created_by', $user->id)->where('status', 'paid')->where('updated_at', '>=', $thisMonth)->sum('user_amount'),
        ];
    }
}
