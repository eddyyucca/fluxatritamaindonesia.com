@extends('layouts.portal')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="mt-4 space-y-5">

    {{-- Welcome banner --}}
    <div class="card p-5 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white mb-0.5">
                Halo, {{ explode(' ', $user->name)[0] }}!
            </h2>
            <p class="text-slate-400 text-sm">
                {{ $user->isDirector() ? 'Selamat datang kembali, Director. Berikut ringkasan bisnis Anda.' : 'Selamat datang! Berikut ringkasan aktivitas dan penghasilan Anda.' }}
            </p>
            @if(!$user->isDirector())
            <p class="text-slate-500 text-xs mt-1">{{ $user->position ?? 'Staff PT Fluxa Tritama Indonesia' }}</p>
            @endif
        </div>
        <div class="avatar w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
            <span class="text-white font-black text-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
    </div>

    @if($user->isDirector())
    {{-- ── DIRECTOR DASHBOARD ── --}}

    {{-- Pending approvals alert --}}
    @php $totalPending = ($stats['pending_quotations'] ?? 0) + ($stats['pending_invoices'] ?? 0); @endphp
    @if($totalPending > 0)
    <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/25 flex items-start gap-3">
        <i class="fa-solid fa-bell text-amber-400 mt-0.5"></i>
        <div>
            <p class="text-amber-300 font-semibold text-sm">Perlu Perhatian Segera</p>
            <div class="text-amber-400/80 text-xs mt-1 space-y-0.5">
                @if($stats['pending_quotations'] > 0)
                <p>• <a href="{{ route('billing.quotations.index') }}" class="hover:underline">{{ $stats['pending_quotations'] }} quotation</a> menunggu persetujuan</p>
                @endif
                @if($stats['pending_invoices'] > 0)
                <p>• <a href="{{ route('billing.invoices.index') }}" class="hover:underline">{{ $stats['pending_invoices'] }} invoice</a> menunggu persetujuan Director</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Quotation</span>
                <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-file-contract text-blue-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['total_quotations'] }}</p>
            @if($stats['pending_quotations'])
            <p class="text-xs text-amber-400 mt-1">{{ $stats['pending_quotations'] }} menunggu persetujuan</p>
            @else
            <p class="text-xs text-slate-500 mt-1">Semua terproses</p>
            @endif
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Invoice</span>
                <div class="w-8 h-8 rounded-lg bg-violet-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-file-invoice-dollar text-violet-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['total_invoices'] }}</p>
            <p class="text-xs text-emerald-400 mt-1">{{ $stats['paid_invoices'] }} lunas</p>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Keuntungan PT</span>
                <div class="w-8 h-8 rounded-lg bg-amber-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-amber-400 text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-amber-400">Rp {{ number_format($stats['pt_profit_total'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-1">Bulan ini: Rp {{ number_format($stats['monthly_pt_profit'], 0, ',', '.') }}</p>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Revenue</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-trend-up text-emerald-400 text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-1">Bulan ini: Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Second row --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Staff</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-users text-indigo-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['total_staff'] }}</p>
            <a href="{{ route('dashboard.users') }}" class="text-xs text-blue-400 mt-1 block hover:underline">Kelola Pengguna →</a>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Klien</span>
                <div class="w-8 h-8 rounded-lg bg-teal-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-building text-teal-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['total_clients'] }}</p>
            <a href="{{ route('billing.clients.index') }}" class="text-xs text-blue-400 mt-1 block hover:underline">Lihat Klien →</a>
        </div>
    </div>

    @else
    {{-- ── USER DASHBOARD ── --}}

    {{-- Pending alert --}}
    @if($stats['my_pending_quotations'] > 0 || $stats['my_pending_invoices'] > 0)
    <div class="p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-start gap-3">
        <i class="fa-solid fa-clock text-blue-400 mt-0.5"></i>
        <div>
            <p class="text-blue-300 font-semibold text-sm">Menunggu Persetujuan Director</p>
            <div class="text-blue-400/80 text-xs mt-1 space-y-0.5">
                @if($stats['my_pending_quotations'] > 0)
                <p>• {{ $stats['my_pending_quotations'] }} quotation Anda menunggu disetujui</p>
                @endif
                @if($stats['my_pending_invoices'] > 0)
                <p>• {{ $stats['my_pending_invoices'] }} invoice Anda menunggu persetujuan</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- My earnings --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Quotation Saya</span>
                <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-file-contract text-blue-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['my_quotations'] }}</p>
            <a href="{{ route('billing.quotations.index') }}" class="text-xs text-blue-400 mt-1 block hover:underline">Lihat semua →</a>
        </div>
        <div class="stat-card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Invoice Saya</span>
                <div class="w-8 h-8 rounded-lg bg-violet-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-file-invoice-dollar text-violet-400 text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['my_invoices'] }}</p>
            <p class="text-xs text-emerald-400 mt-1">{{ $stats['my_paid_invoices'] }} lunas</p>
        </div>
        <div class="stat-card p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <span class="text-slate-400 text-xs">Total Revenue Proyek Saya</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-trend-up text-emerald-400 text-xs"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-white">Rp {{ number_format($stats['my_total_revenue'], 0, ',', '.') }}</p>
            <p class="text-xs text-slate-500 mt-1">Bulan ini: Rp {{ number_format($stats['my_monthly_revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Earnings breakdown --}}
    <div class="card p-5">
        <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-blue-400"></i> Rincian Penghasilan (Invoice Lunas)
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-emerald-500/8 border border-emerald-500/20">
                <p class="text-xs text-emerald-400 mb-1">Bagian Anda (89%)</p>
                <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($stats['my_user_amount'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-1">Bulan ini: Rp {{ number_format($stats['my_monthly_share'], 0, ',', '.') }}</p>
            </div>
            <div class="p-4 rounded-xl bg-amber-500/8 border border-amber-500/20">
                <p class="text-xs text-amber-400 mb-1">Potongan PT (11%)</p>
                <p class="text-xl font-bold text-amber-400">Rp {{ number_format($stats['my_pt_deduction'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-1">Dari total proyek Anda</p>
            </div>
            <div class="p-4 rounded-xl bg-blue-500/8 border border-blue-500/20">
                <p class="text-xs text-blue-400 mb-1">Info Akun PT</p>
                <p class="text-sm font-semibold text-white mt-1">Bank Mandiri</p>
                <p class="text-xs text-slate-400 font-mono">031 00 2387227 1</p>
                <p class="text-xs text-slate-500">PT Fluxa Tritama Indonesia</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Recent documents --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Recent Quotations --}}
        <div class="card overflow-hidden">
            <div class="p-4 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-contract text-blue-400 text-xs"></i> Quotation Terbaru
                </h3>
                <a href="{{ route('billing.quotations.index') }}" class="text-blue-400 text-xs hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($recentQuotations as $q)
                <a href="{{ route('billing.quotations.show', $q) }}" class="flex items-center justify-between px-4 py-3 hover:bg-white/3 transition-colors">
                    <div>
                        <p class="text-xs font-mono text-blue-400">{{ $q->quotation_number }}</p>
                        <p class="text-sm text-white">{{ $q->client->name }}</p>
                        @if($user->isDirector())
                        <p class="text-xs text-slate-500">{{ $q->creator->name }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-white font-medium">Rp {{ number_format($q->total, 0, ',', '.') }}</p>
                        @php $c = $q->status_color @endphp
                        <span class="text-[10px] px-1.5 py-0.5 rounded
                            {{ $c === 'emerald' ? 'text-emerald-400' : '' }}
                            {{ $c === 'amber'   ? 'text-amber-400'   : '' }}
                            {{ $c === 'red'     ? 'text-red-400'     : '' }}
                            {{ $c === 'slate'   ? 'text-slate-500'   : '' }}">
                            {{ $q->status_label }}
                        </span>
                    </div>
                </a>
                @empty
                <div class="px-4 py-8 text-center text-slate-500 text-sm">
                    <i class="fa-solid fa-file-contract opacity-30 text-2xl mb-2 block"></i>
                    Belum ada quotation
                </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Invoices --}}
        <div class="card overflow-hidden">
            <div class="p-4 border-b border-white/5 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice-dollar text-violet-400 text-xs"></i> Invoice Terbaru
                </h3>
                <a href="{{ route('billing.invoices.index') }}" class="text-blue-400 text-xs hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-white/5">
                @forelse($recentInvoices as $inv)
                <a href="{{ route('billing.invoices.show', $inv) }}" class="flex items-center justify-between px-4 py-3 hover:bg-white/3 transition-colors">
                    <div>
                        <p class="text-xs font-mono text-violet-400">{{ $inv->invoice_number }}</p>
                        <p class="text-sm text-white">{{ $inv->client->name }}</p>
                        @if($user->isDirector())
                        <p class="text-xs text-slate-500">{{ $inv->creator->name }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-white font-medium">Rp {{ number_format($inv->total, 0, ',', '.') }}</p>
                        @php $c = $inv->status_color @endphp
                        <span class="text-[10px] px-1.5 py-0.5 rounded
                            {{ $c === 'emerald' ? 'text-emerald-400' : '' }}
                            {{ $c === 'blue'    ? 'text-blue-400'    : '' }}
                            {{ $c === 'amber'   ? 'text-amber-400'   : '' }}
                            {{ $c === 'red'     ? 'text-red-400'     : '' }}
                            {{ $c === 'slate'   ? 'text-slate-500'   : '' }}">
                            {{ $inv->status_label }}
                        </span>
                    </div>
                </a>
                @empty
                <div class="px-4 py-8 text-center text-slate-500 text-sm">
                    <i class="fa-solid fa-file-invoice-dollar opacity-30 text-2xl mb-2 block"></i>
                    Belum ada invoice
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
