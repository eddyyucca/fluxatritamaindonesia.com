@extends('layouts.portal')
@section('title', 'Quotation')
@section('page-title', 'Daftar Quotation')

@section('topbar-actions')
<li class="nav-item d-flex align-items-center">
    <a href="{{ route('billing.quotations.create') }}" class="btn btn-sm btn-fluxa-primary">
        <i class="fas fa-plus mr-1"></i> Buat Quotation
    </a>
</li>
@endsection

@section('content')
@php
    $total    = $quotations->count();
    $draft    = $quotations->where('status','draft')->count();
    $pending  = $quotations->where('status','sent')->count();
    $approved = $quotations->where('status','approved')->count();
@endphp

{{-- Summary cards --}}
<div class="row mb-4">
    <div class="col-6 col-sm-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f1f5f9;">
                <i class="fas fa-file-contract" style="color:#64748b;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $total }}</div>
                <div class="fluxa-stat-label">Total</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f1f5f9;">
                <i class="fas fa-file" style="color:#94a3b8;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#64748b;">{{ $draft }}</div>
                <div class="fluxa-stat-label">Draft</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#fffbeb;">
                <i class="fas fa-clock" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#d97706;">{{ $pending }}</div>
                <div class="fluxa-stat-label">Menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-3 mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-circle-check" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#16a34a;">{{ $approved }}</div>
                <div class="fluxa-stat-label">Disetujui</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">Semua Quotation</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Quotation</th>
                        <th>Klien</th>
                        <th class="d-none d-md-table-cell">Judul Proyek</th>
                        @if(Auth::user()->isDirector())
                        <th class="d-none d-lg-table-cell">Dibuat oleh</th>
                        @endif
                        <th class="text-right">Total</th>
                        <th class="text-center">Status</th>
                        <th class="d-none d-sm-table-cell">Berlaku s/d</th>
                        <th style="width:40px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $q)
                    @php $c = $q->status_color; $pMap=['emerald'=>'pill-paid','amber'=>'pill-pending','red'=>'pill-rejected','slate'=>'pill-draft','blue'=>'pill-approved']; @endphp
                    <tr>
                        <td>
                            <a href="{{ route('billing.quotations.show', $q) }}"
                               style="font-family:monospace;font-size:12px;font-weight:700;color:#2563eb;">
                                {{ $q->quotation_number }}
                            </a>
                        </td>
                        <td style="font-weight:600;color:#334155;">{{ $q->client->name }}</td>
                        <td class="d-none d-md-table-cell">
                            <span style="font-size:12px;color:#64748b;" class="text-truncate d-inline-block" style="max-width:220px;">
                                {{ Str::limit($q->title, 40) }}
                            </span>
                        </td>
                        @if(Auth::user()->isDirector())
                        <td class="d-none d-lg-table-cell">
                            <span style="font-size:12px;color:#64748b;">{{ $q->creator->name }}</span>
                        </td>
                        @endif
                        <td class="text-right">
                            <span style="font-size:12px;font-weight:600;color:#334155;white-space:nowrap;">
                                Rp {{ number_format($q->total, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="pill {{ $pMap[$c] ?? 'pill-draft' }}">{{ $q->status_label }}</span>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span style="font-size:12px;color:#94a3b8;">{{ $q->valid_until ? $q->valid_until->format('d/m/Y') : '—' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('billing.quotations.show', $q) }}"
                               class="btn btn-icon btn-fluxa-secondary" title="Lihat Detail">
                                <i class="fas fa-eye" style="font-size:11px;"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-file-contract"></i></div>
                                <p>Belum ada quotation</p>
                                <small>Buat quotation pertama untuk klien Anda</small><br>
                                <a href="{{ route('billing.quotations.create') }}" class="btn btn-sm btn-fluxa-primary mt-3">
                                    <i class="fas fa-plus mr-1"></i> Buat Quotation
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
