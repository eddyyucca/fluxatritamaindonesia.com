@extends('layouts.portal')
@section('title', 'Quotation')
@section('page-title', 'Daftar Quotation')

@section('topbar-actions')
    <a href="{{ route('billing.quotations.create') }}" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5">
        <i class="fa-solid fa-plus text-xs"></i> Buat Quotation
    </a>
@endsection

@section('content')
<div class="mt-4">
    {{-- Summary cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        @php
            $total     = $quotations->count();
            $draft     = $quotations->where('status','draft')->count();
            $pending   = $quotations->where('status','sent')->count();
            $approved  = $quotations->where('status','approved')->count();
        @endphp
        <div class="stat-card p-4">
            <p class="text-xs text-slate-400 mb-1">Total</p>
            <p class="text-2xl font-bold text-white">{{ $total }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-xs text-slate-400 mb-1">Draft</p>
            <p class="text-2xl font-bold text-slate-400">{{ $draft }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-xs text-amber-400 mb-1">Menunggu</p>
            <p class="text-2xl font-bold text-amber-400">{{ $pending }}</p>
        </div>
        <div class="stat-card p-4">
            <p class="text-xs text-emerald-400 mb-1">Disetujui</p>
            <p class="text-2xl font-bold text-emerald-400">{{ $approved }}</p>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5 text-slate-500 text-xs">
                        <th class="text-left px-4 py-3 font-medium">No. Quotation</th>
                        <th class="text-left px-4 py-3 font-medium">Klien</th>
                        <th class="text-left px-4 py-3 font-medium">Judul</th>
                        @if(Auth::user()->isDirector())
                        <th class="text-left px-4 py-3 font-medium">Dibuat oleh</th>
                        @endif
                        <th class="text-right px-4 py-3 font-medium">Total</th>
                        <th class="text-center px-4 py-3 font-medium">Status</th>
                        <th class="text-left px-4 py-3 font-medium">Berlaku s/d</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($quotations as $q)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <a href="{{ route('billing.quotations.show', $q) }}" class="text-blue-400 hover:underline font-mono text-xs">
                                {{ $q->quotation_number }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-slate-300">{{ $q->client->name }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ Str::limit($q->title, 40) }}</td>
                        @if(Auth::user()->isDirector())
                        <td class="px-4 py-3 text-slate-500 text-xs">{{ $q->creator->name }}</td>
                        @endif
                        <td class="px-4 py-3 text-right text-white font-medium text-xs">
                            Rp {{ number_format($q->total, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php $color = $q->status_color @endphp
                            <span class="text-[11px] px-2 py-0.5 rounded-full
                                {{ $color === 'emerald' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/25' : '' }}
                                {{ $color === 'amber'   ? 'bg-amber-500/15   text-amber-400   border border-amber-500/25'   : '' }}
                                {{ $color === 'red'     ? 'bg-red-500/15     text-red-400     border border-red-500/25'     : '' }}
                                {{ $color === 'slate'   ? 'bg-slate-500/15   text-slate-400   border border-slate-500/25'   : '' }}">
                                {{ $q->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500 text-xs">
                            {{ $q->valid_until ? $q->valid_until->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('billing.quotations.show', $q) }}"
                               class="text-slate-400 hover:text-blue-400 text-xs px-2 py-1 rounded hover:bg-blue-500/10 transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-file-contract text-3xl mb-3 block opacity-30"></i>
                            Belum ada quotation.
                            <a href="{{ route('billing.quotations.create') }}" class="text-blue-400 ml-1 hover:underline">Buat sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
