@extends('layouts.portal')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('topbar-actions')
    <a href="{{ route('dashboard.users.create') }}" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5">
        <i class="fa-solid fa-user-plus text-xs"></i> Tambah Pengguna
    </a>
@endsection

@section('content')
<div class="mt-4">
    <div class="card overflow-hidden">
        <div class="p-4 border-b border-white/5">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-blue-400"></i>
                Daftar Pengguna <span class="text-slate-500 font-normal">({{ $users->count() }})</span>
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5 text-slate-500 text-xs">
                        <th class="text-left px-4 py-3 font-medium">Nama</th>
                        <th class="text-left px-4 py-3 font-medium">Email</th>
                        <th class="text-left px-4 py-3 font-medium">Jabatan</th>
                        <th class="text-center px-4 py-3 font-medium">Peran</th>
                        <th class="text-left px-4 py-3 font-medium">Bergabung</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($users as $u)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="avatar w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-white font-medium">{{ $u->name }}</span>
                                @if($u->id === Auth::id())
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-blue-500/15 text-blue-400">(Anda)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $u->email }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $u->position ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($u->isDirector())
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-amber-500/15 text-amber-400 border border-amber-500/25">Director</span>
                            @else
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-500/15 text-slate-400 border border-slate-500/25">Staff</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-500 text-xs">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            {{-- Can't delete yourself or the only director --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
