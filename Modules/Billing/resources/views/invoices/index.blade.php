@extends('layouts.portal')
@section('title', 'Invoice')
@section('page-title', 'Invoice Diterbitkan')

@section('content')
@php
    $totalNilai = $invoices->sum('total');
    $lunas      = $invoices->where('status', 'paid')->count();
    $aktif      = $invoices->where('status', 'approved')->count();
@endphp

{{-- Summary cards --}}
<div class="row mb-4">
    <div class="col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-file-invoice-dollar" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $invoices->count() }}</div>
                <div class="fluxa-stat-label">Total Diterbitkan</div>
            </div>
        </div>
    </div>
    <div class="col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-stamp" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#2563eb;">{{ $aktif }}</div>
                <div class="fluxa-stat-label">Aktif</div>
            </div>
        </div>
    </div>
    <div class="col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-circle-check" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#16a34a;">{{ $lunas }}</div>
                <div class="fluxa-stat-label">Lunas</div>
            </div>
        </div>
    </div>
    <div class="col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-chart-line" style="color:#059669;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#059669;font-size:14px;">
                    Rp {{ number_format($totalNilai, 0, ',', '.') }}
                </div>
                <div class="fluxa-stat-label">Total Nilai</div>
            </div>
        </div>
    </div>
</div>

{{-- ── PENDING APPROVAL (Director only) ── --}}
@if(Auth::user()->isDirector() && $pendingInvoices->count() > 0)
<div class="card mb-4" style="border-left:3px solid #d97706!important;">
    <div class="card-header d-flex align-items-center justify-content-between" style="background:#fffbeb;">
        <div class="d-flex align-items-center" style="gap:8px;">
            <i class="fas fa-clock" style="color:#d97706;font-size:13px;"></i>
            <h6 class="card-title mb-0" style="color:#92400e;">
                Menunggu Persetujuan Final
                <span style="background:#d97706;color:#fff;border-radius:99px;font-size:10px;padding:1px 8px;margin-left:4px;">
                    {{ $pendingInvoices->count() }}
                </span>
            </h6>
        </div>
        <small style="color:#92400e;font-size:11px;">Setujui untuk menerbitkan ke data pendapatan</small>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Klien</th>
                        <th class="d-none d-md-table-cell">Judul Proyek</th>
                        <th class="d-none d-lg-table-cell">Dibuat oleh</th>
                        <th class="text-right">Total</th>
                        <th style="width:160px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingInvoices as $inv)
                    <tr>
                        <td>
                            <a href="{{ route('billing.invoices.show', $inv) }}"
                               style="font-family:monospace;font-size:12px;font-weight:700;color:#d97706;">
                                {{ $inv->invoice_number }}
                            </a>
                        </td>
                        <td style="font-weight:600;color:#334155;">{{ $inv->client->name }}</td>
                        <td class="d-none d-md-table-cell" style="font-size:12px;color:#64748b;">
                            {{ Str::limit($inv->title, 36) }}
                        </td>
                        <td class="d-none d-lg-table-cell" style="font-size:12px;color:#64748b;">
                            {{ $inv->creator->name }}
                        </td>
                        <td class="text-right" style="font-weight:600;color:#334155;white-space:nowrap;">
                            Rp {{ number_format($inv->total, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="d-flex justify-content-end" style="gap:4px;">
                                <form method="POST" action="{{ route('billing.invoices.approve', $inv) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-fluxa-success" style="font-size:11px;padding:3px 10px;">
                                        <i class="fas fa-circle-check mr-1"></i> Setujui
                                    </button>
                                </form>
                                <a href="{{ route('billing.invoices.show', $inv) }}"
                                   class="btn btn-icon btn-fluxa-secondary" title="Lihat Detail">
                                    <i class="fas fa-eye" style="font-size:11px;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ── PUBLISHED INVOICES ── --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center" style="gap:8px;">
            <i class="fas fa-file-invoice-dollar" style="color:#2563eb;font-size:13px;"></i>
            <h6 class="card-title mb-0">
                Invoice Diterbitkan
                <span style="color:#94a3b8;font-weight:400;">({{ $invoices->count() }})</span>
            </h6>
        </div>
    </div>
    <div class="card-body p-0">
        @if($invoices->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <p>Belum ada invoice yang diterbitkan</p>
            <small>Invoice akan muncul di sini setelah disetujui oleh Director</small>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Klien</th>
                        <th class="d-none d-md-table-cell">Judul Proyek</th>
                        @if(Auth::user()->isDirector())
                        <th class="d-none d-lg-table-cell">Dibuat oleh</th>
                        @endif
                        <th class="text-right">Total</th>
                        <th class="text-center">Status</th>
                        <th class="d-none d-sm-table-cell">Tgl Terbit</th>
                        <th style="width:40px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                    @php
                        $isPaid = $inv->status === 'paid';
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('billing.invoices.show', $inv) }}"
                               style="font-family:monospace;font-size:12px;font-weight:700;color:#2563eb;">
                                {{ $inv->invoice_number }}
                            </a>
                        </td>
                        <td style="font-weight:600;color:#334155;">{{ $inv->client->name }}</td>
                        <td class="d-none d-md-table-cell">
                            <span style="font-size:12px;color:#64748b;">
                                {{ Str::limit($inv->title, 40) }}
                            </span>
                        </td>
                        @if(Auth::user()->isDirector())
                        <td class="d-none d-lg-table-cell">
                            <span style="font-size:12px;color:#64748b;">{{ $inv->creator->name }}</span>
                        </td>
                        @endif
                        <td class="text-right">
                            <span style="font-size:12px;font-weight:700;color:#1e293b;white-space:nowrap;">
                                Rp {{ number_format($inv->total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($isPaid)
                            <span class="pill pill-paid">Lunas</span>
                            @else
                            <span class="pill pill-approved">Aktif</span>
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span style="font-size:12px;color:#94a3b8;">
                                {{ $inv->approved_at ? $inv->approved_at->format('d/m/Y') : $inv->invoice_date->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('billing.invoices.show', $inv) }}"
                               class="btn btn-icon btn-fluxa-secondary" title="Lihat Detail">
                                <i class="fas fa-eye" style="font-size:11px;"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
