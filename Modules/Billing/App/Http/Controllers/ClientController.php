<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Billing\App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $clients = $user->isDirector()
            ? Client::with('creator')->latest()->get()
            : Client::where('created_by', $user->id)->with('creator')->latest()->get();

        return view('billing::clients.index', compact('user', 'clients'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('billing::clients.create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city'    => ['nullable', 'string', 'max:100'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
        ]);

        $data['created_by'] = Auth::id();
        Client::create($data);

        return redirect()->route('billing.clients.index')
            ->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client)
    {
        $user = Auth::user();
        $this->authorizeAccess($client, $user);
        return view('billing::clients.create', compact('user', 'client'));
    }

    public function update(Request $request, Client $client)
    {
        $this->authorizeAccess($client, Auth::user());

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city'    => ['nullable', 'string', 'max:100'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
        ]);

        $client->update($data);

        return redirect()->route('billing.clients.index')
            ->with('success', 'Data klien berhasil diperbarui.');
    }

    public function destroy(Client $client)
    {
        $this->authorizeAccess($client, Auth::user());
        $client->delete();

        return redirect()->route('billing.clients.index')
            ->with('success', 'Klien berhasil dihapus.');
    }

    private function authorizeAccess(Client $client, $user): void
    {
        if (!$user->isDirector() && $client->created_by !== $user->id) {
            abort(403);
        }
    }
}
