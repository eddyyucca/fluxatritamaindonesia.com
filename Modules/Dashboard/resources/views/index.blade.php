@extends('layouts.portal')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <p style="color:#bfdbfe;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:4px;">
                {{ $user->isDirector() ? 'Director View' : 'Staff View' }}
            </p>
            <h4 class="mb-1 font-weight-bold" style="color:#fff;">
                Selamat datang, {{ explode(' ', $user->name)[0] }}!
            </h4>
            <p style="color:#bfdbfe;font-size:13px;margin-bottom:0;">
                {{ $user->isDirector()
                    ? 'Berikut ringkasan bisnis PT Fluxa Tritama Indonesia.'
                    : 'Berikut ringkasan aktivitas dan penghasilan Anda.' }}
            </p>
            @if(!$user->isDirector() && $user->position)
            <p style="color:rgba(191,219,254,0.6);font-size:11px;margin-top:4px;margin-bottom:0;">{{ $user->position }}</p>
            @endif
        </div>
        <div class="d-none d-sm-flex align-items-center justify-content-center flex-shrink-0"
             style="width:54px;height:54px;border-radius:14px;background:rgba(255,255,255,0.15);">
            <span style="color:#fff;font-size:22px;font-weight:900;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
    </div>
</div>

@if($user->isDirector())
{{-- ── DIRECTOR DASHBOARD ── --}}

@php $totalPending = ($stats['pending_quotations'] ?? 0) + ($stats['pending_invoices'] ?? 0); @endphp
@if($totalPending > 0)
<div class="alert alert-warning d-flex align-items-start mb-4" style="gap:12px;">
    <i class="fas fa-bell flex-shrink-0 mt-1"></i>
    <div>
        <strong>Perlu Persetujuan Anda</strong>
        <div class="mt-1" style="font-size:12px;">
            @if($stats['pending_quotations'] > 0)
            <div>• <a href="{{ route('billing.quotations.index') }}" class="font-weight-bold">{{ $stats['pending_quotations'] }} quotation</a> menunggu persetujuan</div>
            @endif
            @if($stats['pending_invoices'] > 0)
            <div>• <a href="{{ route('billing.invoices.index') }}" class="font-weight-bold">{{ $stats['pending_invoices'] }} invoice</a> menunggu persetujuan Director</div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- KPI Row 1 --}}
<div class="row mb-2">
    <div class="col-6 col-lg-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-file-contract" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['total_quotations'] }}</div>
                <div class="fluxa-stat-label">Total Quotation</div>
                @if($stats['pending_quotations'])
                <div class="fluxa-stat-sub" style="color:#d97706;"><i class="fas fa-clock" style="font-size:9px;"></i> {{ $stats['pending_quotations'] }} menunggu</div>
                @else
                <div class="fluxa-stat-sub" style="color:#16a34a;">Semua terproses</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f5f3ff;">
                <i class="fas fa-file-invoice-dollar" style="color:#7c3aed;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['total_invoices'] }}</div>
                <div class="fluxa-stat-label">Total Invoice</div>
                <div class="fluxa-stat-sub" style="color:#16a34a;"><i class="fas fa-check" style="font-size:9px;"></i> {{ $stats['paid_invoices'] }} sudah lunas</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#fffbeb;">
                <i class="fas fa-building-columns" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="font-size:17px;color:#d97706;">Rp {{ number_format($stats['pt_profit_total'], 0, ',', '.') }}</div>
                <div class="fluxa-stat-label">Keuntungan PT</div>
                <div class="fluxa-stat-sub">Bln ini: Rp {{ number_format($stats['monthly_pt_profit'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-money-bill-trend-up" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="font-size:17px;color:#16a34a;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="fluxa-stat-label">Total Revenue</div>
                <div class="fluxa-stat-sub">Bln ini: Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- KPI Row 2 --}}
<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eef2ff;width:48px;height:48px;">
                <i class="fas fa-users" style="color:#4f46e5;font-size:18px;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['total_staff'] }}</div>
                <div class="fluxa-stat-label">Total Staff</div>
                <a href="{{ route('dashboard.users') }}" style="font-size:11px;color:#2563eb;font-weight:600;">Kelola pengguna →</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdfa;width:48px;height:48px;">
                <i class="fas fa-building" style="color:#0d9488;font-size:18px;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['total_clients'] }}</div>
                <div class="fluxa-stat-label">Total Klien</div>
                <a href="{{ route('billing.clients.index') }}" style="font-size:11px;color:#2563eb;font-weight:600;">Lihat semua klien →</a>
            </div>
        </div>
    </div>
</div>

@else
{{-- ── STAFF DASHBOARD ── --}}

@if($stats['my_pending_quotations'] > 0 || $stats['my_pending_invoices'] > 0)
<div class="alert alert-info d-flex align-items-start mb-4" style="gap:12px;">
    <i class="fas fa-clock flex-shrink-0 mt-1"></i>
    <div>
        <strong>Menunggu Persetujuan Director</strong>
        <div class="mt-1" style="font-size:12px;">
            @if($stats['my_pending_quotations'] > 0)
            <div>• {{ $stats['my_pending_quotations'] }} quotation menunggu disetujui</div>
            @endif
            @if($stats['my_pending_invoices'] > 0)
            <div>• {{ $stats['my_pending_invoices'] }} invoice menunggu persetujuan</div>
            @endif
        </div>
    </div>
</div>
@endif

<div class="row mb-2">
    <div class="col-6 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-file-contract" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['my_quotations'] }}</div>
                <div class="fluxa-stat-label">Quotation Saya</div>
                <a href="{{ route('billing.quotations.index') }}" style="font-size:11px;color:#2563eb;font-weight:600;">Lihat semua →</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f5f3ff;">
                <i class="fas fa-file-invoice-dollar" style="color:#7c3aed;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $stats['my_invoices'] }}</div>
                <div class="fluxa-stat-label">Invoice Saya</div>
                <div class="fluxa-stat-sub" style="color:#16a34a;">{{ $stats['my_paid_invoices'] }} sudah lunas</div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;width:48px;height:48px;">
                <i class="fas fa-money-bill-trend-up" style="color:#16a34a;font-size:18px;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="font-size:20px;">Rp {{ number_format($stats['my_total_revenue'], 0, ',', '.') }}</div>
                <div class="fluxa-stat-label">Total Revenue Proyek Saya</div>
                <div class="fluxa-stat-sub">Bln ini: Rp {{ number_format($stats['my_monthly_revenue'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Earnings breakdown --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center" style="gap:8px;">
        <i class="fas fa-chart-pie" style="color:#2563eb;"></i>
        <h6 class="card-title mb-0">Rincian Penghasilan (dari invoice lunas)</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:16px;">
                    <p style="font-size:11px;font-weight:700;color:#166534;margin-bottom:6px;"><i class="fas fa-circle-check" style="color:#22c55e;font-size:9px;"></i> Bagian Anda (89%)</p>
                    <p style="font-size:18px;font-weight:800;color:#166534;margin-bottom:2px;">Rp {{ number_format($stats['my_user_amount'], 0, ',', '.') }}</p>
                    <p style="font-size:11px;color:#16a34a;margin-bottom:0;">Bln ini: Rp {{ number_format($stats['my_monthly_share'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:16px;">
                    <p style="font-size:11px;font-weight:700;color:#92400e;margin-bottom:6px;"><i class="fas fa-building-columns" style="color:#f59e0b;font-size:9px;"></i> Potongan PT (11%)</p>
                    <p style="font-size:18px;font-weight:800;color:#92400e;margin-bottom:2px;">Rp {{ number_format($stats['my_pt_deduction'], 0, ',', '.') }}</p>
                    <p style="font-size:11px;color:#d97706;margin-bottom:0;">Dari total proyek Anda</p>
                </div>
            </div>
            <div class="col-md-4">
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;">
                    <p style="font-size:11px;font-weight:700;color:#475569;margin-bottom:6px;"><i class="fas fa-university" style="color:#94a3b8;font-size:9px;"></i> Rekening PT</p>
                    <p style="font-size:13px;font-weight:700;color:#334155;margin-bottom:2px;">Bank Mandiri</p>
                    <p style="font-family:monospace;font-size:11px;color:#475569;margin-bottom:2px;">031 00 2387227 1</p>
                    <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">PT Fluxa Tritama Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Recent Documents --}}
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0 d-flex align-items-center" style="gap:8px;">
                    <i class="fas fa-file-contract" style="color:#2563eb;font-size:13px;"></i> Quotation Terbaru
                </h6>
                <a href="{{ route('billing.quotations.index') }}" style="font-size:11px;color:#2563eb;font-weight:600;">Lihat semua</a>
            </div>
            @forelse($recentQuotations as $q)
            @php $c = $q->status_color; $pMap=['emerald'=>'pill-paid','amber'=>'pill-pending','red'=>'pill-rejected','slate'=>'pill-draft','blue'=>'pill-approved']; @endphp
            <a href="{{ route('billing.quotations.show', $q) }}"
               class="d-flex align-items-center justify-content-between px-3 py-2"
               style="border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .15s;"
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <div style="min-width:0;flex:1;">
                    <p style="font-family:monospace;color:#2563eb;font-size:11px;font-weight:700;margin:0;">{{ $q->quotation_number }}</p>
                    <p style="color:#334155;font-weight:600;font-size:13px;margin:0;" class="text-truncate">{{ $q->client->name }}</p>
                    @if($user->isDirector())
                    <p style="font-size:11px;color:#94a3b8;margin:0;">oleh {{ $q->creator->name }}</p>
                    @endif
                </div>
                <div class="text-right ml-3 flex-shrink-0">
                    <p style="font-size:11px;font-weight:600;color:#334155;margin:0;">Rp {{ number_format($q->total, 0, ',', '.') }}</p>
                    <span class="pill {{ $pMap[$c] ?? 'pill-draft' }}" style="margin-top:3px;display:inline-block;">{{ $q->status_label }}</span>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-file-contract"></i></div>
                <p>Belum ada quotation</p>
                <small><a href="{{ route('billing.quotations.create') }}">Buat quotation pertama</a></small>
            </div>
            @endforelse
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0 d-flex align-items-center" style="gap:8px;">
                    <i class="fas fa-file-invoice-dollar" style="color:#7c3aed;font-size:13px;"></i> Invoice Terbaru
                </h6>
                <a href="{{ route('billing.invoices.index') }}" style="font-size:11px;color:#2563eb;font-weight:600;">Lihat semua</a>
            </div>
            @forelse($recentInvoices as $inv)
            @php $c = $inv->status_color; @endphp
            <a href="{{ route('billing.invoices.show', $inv) }}"
               class="d-flex align-items-center justify-content-between px-3 py-2"
               style="border-bottom:1px solid #f1f5f9;text-decoration:none;transition:background .15s;"
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                <div style="min-width:0;flex:1;">
                    <p style="font-family:monospace;color:#7c3aed;font-size:11px;font-weight:700;margin:0;">{{ $inv->invoice_number }}</p>
                    <p style="color:#334155;font-weight:600;font-size:13px;margin:0;" class="text-truncate">{{ $inv->client->name }}</p>
                    @if($user->isDirector())
                    <p style="font-size:11px;color:#94a3b8;margin:0;">oleh {{ $inv->creator->name }}</p>
                    @endif
                </div>
                <div class="text-right ml-3 flex-shrink-0">
                    <p style="font-size:11px;font-weight:600;color:#334155;margin:0;">Rp {{ number_format($inv->total, 0, ',', '.') }}</p>
                    @php $pMap=['emerald'=>'pill-paid','amber'=>'pill-pending','red'=>'pill-rejected','slate'=>'pill-draft','blue'=>'pill-approved']; @endphp
                    <span class="pill {{ $pMap[$c] ?? 'pill-draft' }}" style="margin-top:3px;display:inline-block;">{{ $inv->status_label }}</span>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <p>Belum ada invoice</p>
                <small><a href="{{ route('billing.invoices.create') }}">Buat invoice pertama</a></small>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
