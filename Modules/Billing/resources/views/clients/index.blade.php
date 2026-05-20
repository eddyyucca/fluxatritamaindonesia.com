@extends('layouts.portal')
@section('title', 'Klien')
@section('page-title', 'Manajemen Klien')

@section('topbar-actions')
    <a href="{{ route('billing.clients.create') }}" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Klien
    </a>
@endsection

@section('content')
<div class="mt-4">
    <div class="card overflow-hidden">
        <div class="p-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-building text-blue-400"></i>
                Daftar Klien <span class="text-slate-500 font-normal">({{ $clients->count() }})</span>
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5 text-slate-500 text-xs">
                        <th class="text-left px-4 py-3 font-medium">Nama</th>
                        <th class="text-left px-4 py-3 font-medium">Kota</th>
                        <th class="text-left px-4 py-3 font-medium">Email / Telepon</th>
                        @if(Auth::user()->isDirector())
                        <th class="text-left px-4 py-3 font-medium">Dibuat oleh</th>
                        @endif
                        <th class="text-left px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($clients as $client)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <p class="text-white font-medium">{{ $client->name }}</p>
                            @if($client->address)
                                <p class="text-slate-500 text-xs mt-0.5">{{ Str::limit($client->address, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-400">{{ $client->city ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <p class="text-slate-300 text-xs">{{ $client->email ?? '—' }}</p>
                            <p class="text-slate-500 text-xs">{{ $client->phone ?? '' }}</p>
                        </td>
                        @if(Auth::user()->isDirector())
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $client->creator->name ?? '—' }}</td>
                        @endif
                        <td class="px-4 py-3 text-slate-500 text-xs">{{ $client->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('billing.clients.edit', $client) }}"
                                   class="text-blue-400 hover:text-blue-300 text-xs px-2 py-1 rounded hover:bg-blue-500/10 transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form method="POST" action="{{ route('billing.clients.destroy', $client) }}"
                                      onsubmit="return confirm('Hapus klien ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-xs px-2 py-1 rounded hover:bg-red-500/10 transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-building text-3xl mb-3 block opacity-30"></i>
                            Belum ada data klien.
                            <a href="{{ route('billing.clients.create') }}" class="text-blue-400 ml-1 hover:underline">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
