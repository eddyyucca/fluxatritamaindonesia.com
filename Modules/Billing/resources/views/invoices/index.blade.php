@extends('layouts.portal')
@section('title', 'Invoice')
@section('page-title', 'Invoice Diterbitkan')

@section('content')
@php
    $totalNilai    = $invoices->sum('total');
    $totalTerbayar = $invoices->sum('amount_paid');
    $totalOutstand = $invoices->sum('amount_remaining');
    $lunas         = $invoices->where('status', 'paid')->count();
    $sebagian      = $invoices->where('status', 'partial')->count();
    $aktif         = $invoices->where('status', 'approved')->count();
@endphp

{{-- Summary cards --}}
<div class="row mb-4">
    <div class="col-6 col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#eff6ff;">
                <i class="fas fa-file-invoice-dollar" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value">{{ $invoices->count() }}</div>
                <div class="fluxa-stat-label">Total Invoice</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm mb-3">
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
    <div class="col-6 col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#fff7ed;">
                <i class="fas fa-hourglass-half" style="color:#ea580c;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#ea580c;">{{ $aktif + $sebagian }}</div>
                <div class="fluxa-stat-label">Outstanding</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#fef2f2;">
                <i class="fas fa-circle-exclamation" style="color:#dc2626;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#dc2626;font-size:13px;">
                    Rp {{ number_format($totalOutstand, 0, ',', '.') }}
                </div>
                <div class="fluxa-stat-label">Belum Dibayar</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm mb-3">
        <div class="fluxa-stat">
            <div class="fluxa-stat-icon" style="background:#f0fdf4;">
                <i class="fas fa-chart-line" style="color:#059669;"></i>
            </div>
            <div>
                <div class="fluxa-stat-value" style="color:#059669;font-size:13px;">
                    Rp {{ number_format($totalTerbayar, 0, ',', '.') }}
                </div>
                <div class="fluxa-stat-label">Terbayar</div>
            </div>
        </div>
    </div>
</div>

{{-- Outstanding banner --}}
@if($totalOutstand > 0)
<div class="alert d-flex align-items-center mb-4" style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #ea580c;gap:12px;border-radius:10px;">
    <i class="fas fa-triangle-exclamation" style="color:#ea580c;font-size:18px;flex-shrink:0;"></i>
    <div>
        <strong style="color:#9a3412;">Outstanding Belum Terbayar</strong>
        <div style="font-size:12px;color:#c2410c;margin-top:2px;">
            Total <strong>Rp {{ number_format($totalOutstand, 0, ',', '.') }}</strong> dari
            <strong>{{ $aktif + $sebagian }}</strong> invoice masih belum lunas.
        </div>
    </div>
</div>
@endif

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
                                <form method="POST" action="{{ route('billing.invoices.approve', $inv) }}" class="d-inline"
                                      onsubmit="return submitApproveQuick(event, '{{ $inv->invoice_number }}', '{{ route('billing.invoices.approve', $inv) }}', '{{ csrf_token() }}')">
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
        {{-- Legend --}}
        <div class="d-none d-md-flex align-items-center" style="gap:12px;font-size:11px;color:#64748b;">
            <span><span style="display:inline-block;width:10px;height:10px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:2px;margin-right:4px;"></span>Lunas</span>
            <span><span style="display:inline-block;width:10px;height:10px;background:#fff7ed;border:1px solid #fed7aa;border-radius:2px;margin-right:4px;"></span>Sebagian</span>
            <span><span style="display:inline-block;width:10px;height:10px;background:#fef2f2;border:1px solid #fecaca;border-radius:2px;margin-right:4px;"></span>Belum Bayar</span>
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
                        <th class="text-right d-none d-lg-table-cell">Terbayar</th>
                        <th class="text-right d-none d-lg-table-cell">Outstanding</th>
                        <th class="text-center">Status</th>
                        <th class="d-none d-sm-table-cell">Tgl Terbit</th>
                        <th style="width:40px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                    @php
                        $isPaid     = $inv->status === 'paid';
                        $isPartial  = $inv->status === 'partial';
                        $isUnpaid   = $inv->status === 'approved';
                        $rowBg      = $isPaid ? '#f0fdf4' : ($isPartial ? '#fff7ed' : '#fef2f2');
                        $rowBorder  = $isPaid ? '#bbf7d0' : ($isPartial ? '#fed7aa' : '#fecaca');
                        $outstanding = $inv->amount_remaining ?? $inv->total;
                        $paid        = $inv->amount_paid ?? 0;
                    @endphp
                    <tr style="border-left:3px solid {{ $rowBorder }};background:{{ $rowBg }}08;">
                        <td>
                            <a href="{{ route('billing.invoices.show', $inv) }}"
                               style="font-family:monospace;font-size:12px;font-weight:700;color:#2563eb;">
                                {{ $inv->invoice_number }}
                            </a>
                            @if($isUnpaid)
                            <div style="font-size:10px;color:#dc2626;font-weight:600;margin-top:1px;">
                                <i class="fas fa-circle-exclamation" style="font-size:9px;"></i> Belum Bayar
                            </div>
                            @elseif($isPartial)
                            <div style="font-size:10px;color:#ea580c;font-weight:600;margin-top:1px;">
                                <i class="fas fa-hourglass-half" style="font-size:9px;"></i> Sebagian Terbayar
                            </div>
                            @endif
                        </td>
                        <td style="font-weight:600;color:#334155;">{{ $inv->client->name }}</td>
                        <td class="d-none d-md-table-cell">
                            <span style="font-size:12px;color:#64748b;">
                                {{ Str::limit($inv->title, 36) }}
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
                        <td class="text-right d-none d-lg-table-cell">
                            @if($paid > 0)
                            <span style="font-size:12px;font-weight:600;color:#16a34a;white-space:nowrap;">
                                Rp {{ number_format($paid, 0, ',', '.') }}
                            </span>
                            @else
                            <span style="font-size:12px;color:#cbd5e1;">&mdash;</span>
                            @endif
                        </td>
                        <td class="text-right d-none d-lg-table-cell">
                            @if($outstanding > 0)
                            <span style="font-size:12px;font-weight:700;color:#dc2626;white-space:nowrap;">
                                Rp {{ number_format($outstanding, 0, ',', '.') }}
                            </span>
                            @else
                            <span style="font-size:12px;color:#16a34a;font-weight:600;">Lunas ✓</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($isPaid)
                            <span class="pill pill-paid">Lunas</span>
                            @elseif($isPartial)
                            <span class="pill" style="background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;font-size:10px;padding:2px 8px;border-radius:99px;font-weight:600;white-space:nowrap;">Sebagian</span>
                            @else
                            <span class="pill" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-size:10px;padding:2px 8px;border-radius:99px;font-weight:600;white-space:nowrap;">Outstanding</span>
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
                <tfoot style="background:#f8fafc;border-top:2px solid #e2e8f0;">
                    <tr>
                        <td colspan="{{ Auth::user()->isDirector() ? 4 : 3 }}" style="font-size:12px;font-weight:700;color:#475569;padding:10px 12px;">
                            TOTAL ({{ $invoices->count() }} invoice)
                        </td>
                        <td class="text-right" style="font-size:13px;font-weight:900;color:#1e293b;white-space:nowrap;padding:10px 12px;">
                            Rp {{ number_format($invoices->sum('total'), 0, ',', '.') }}
                        </td>
                        <td class="text-right d-none d-lg-table-cell" style="font-size:13px;font-weight:700;color:#16a34a;white-space:nowrap;padding:10px 12px;">
                            Rp {{ number_format($totalTerbayar, 0, ',', '.') }}
                        </td>
                        <td class="text-right d-none d-lg-table-cell" style="font-size:13px;font-weight:700;color:#dc2626;white-space:nowrap;padding:10px 12px;">
                            Rp {{ number_format($totalOutstand, 0, ',', '.') }}
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function submitApproveQuick(event, invNum, action, token) {
    event.preventDefault();
    Swal.fire({
        title: 'Setujui Invoice',
        html: `<p style="font-size:13px;color:#64748b;margin-bottom:12px;">Invoice <strong>${invNum}</strong> akan disetujui dan masuk ke data pendapatan.</p>
               <textarea id="swal-notes" class="swal2-textarea" placeholder="Catatan (opsional)..." style="height:80px;font-size:13px;"></textarea>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-circle-check mr-1"></i> Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action;
            form.innerHTML = `<input name="_token" value="${token}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
    return false;
}
</script>
@endpush
