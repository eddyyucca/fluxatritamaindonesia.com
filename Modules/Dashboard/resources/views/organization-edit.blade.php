@extends('layouts.portal')
@section('title', 'Edit Struktur Organisasi')
@section('page-title', 'Edit Struktur Organisasi')

@section('topbar-actions')
    <a href="{{ route('dashboard.organization') }}" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
    </a>
@endsection

@section('content')
<div class="mt-4 max-w-4xl">
    <div class="card overflow-hidden">
        <div class="p-4 border-b border-white/5">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-400"></i>
                Atur Atasan dan Level
            </h2>
        </div>
        <div class="p-4">
            <form action="{{ route('dashboard.organization.update') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5 text-slate-500 text-xs">
                                <th class="text-left px-4 py-3 font-medium">Pengguna</th>
                                <th class="text-left px-4 py-3 font-medium w-1/3">Atasan Langsung (Parent)</th>
                                <th class="text-left px-4 py-3 font-medium w-32">Level</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $index => $u)
                            <tr class="table-row">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="avatar w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-bold text-xs">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-white font-medium block">{{ $u->name }}</span>
                                            <span class="text-[10px] text-slate-400">{{ $u->position ?? $u->role }}</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="org_data[{{ $index }}][user_id]" value="{{ $u->id }}">
                                </td>
                                <td class="px-4 py-3">
                                    <select name="org_data[{{ $index }}][parent_id]" class="input-field w-full rounded-lg px-3 py-2 text-sm appearance-none" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.7rem top 50%; background-size: 0.65rem auto;">
                                        <option value="">-- Tidak ada atasan --</option>
                                        @foreach($users as $parent)
                                            @if($parent->id !== $u->id)
                                                <option value="{{ $parent->id }}" {{ $u->parent_id == $parent->id ? 'selected' : '' }}>
                                                    {{ $parent->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="number" name="org_data[{{ $index }}][org_level]" value="{{ $u->org_level }}" class="input-field w-full rounded-lg px-3 py-2 text-sm" placeholder="1, 2...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="btn-success text-white text-sm px-6 py-2 rounded-lg font-medium shadow-lg shadow-emerald-500/20">
                        Simpan Struktur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
