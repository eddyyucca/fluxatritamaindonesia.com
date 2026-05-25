<?php

namespace Modules\License\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\License\Models\License;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::orderBy('expiry_date', 'asc')->get();
        return view('license::index', compact('licenses'));
    }

    public function create()
    {
        $clients = DB::table('clients')->get();
        return view('license::create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'billing_cycle' => 'required',
            'start_date' => 'required|date',
            'price' => 'required|numeric',
        ]);

        License::create($request->all());

        return redirect()->route('license.index')->with('success', 'Lisensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $license = License::findOrFail($id);
        $clients = DB::table('clients')->get();
        return view('license::edit', compact('license', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $license = License::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'billing_cycle' => 'required',
            'start_date' => 'required|date',
            'price' => 'required|numeric',
        ]);

        $license->update($request->all());

        return redirect()->route('license.index')->with('success', 'Lisensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        License::findOrFail($id)->delete();
        return redirect()->route('license.index')->with('success', 'Lisensi berhasil dihapus.');
    }
}
