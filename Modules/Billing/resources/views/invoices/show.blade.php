@extends('layouts.portal')
@section('title', $invoice->invoice_number)
@section('page-title', 'Detail Invoice')

@section('topbar-actions')
<li class="nav-item">
    <div class="d-flex align-items-center" style="gap:6px;">
        @if($invoice->status === 'draft')
            <a href="{{ route('billing.invoices.edit', $invoice) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.invoices.submit', $invoice) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-primary">
                    <i class="fas fa-paper-plane mr-1"></i> Ajukan Persetujuan Final ke Director
                </button>
            </form>
        @endif
        @if($invoice->status === 'pending_approval' && Auth::user()->isDirector())
            <button type="button" class="btn btn-sm btn-fluxa-success" onclick="openApproveModal()">
                <i class="fas fa-circle-check mr-1"></i> Setujui &amp; Terbitkan
            </button>
            <button type="button" class="btn btn-sm btn-fluxa-danger" onclick="openRejectModal()">
                <i class="fas fa-xmark mr-1"></i> Tolak
            </button>
        @endif
        @if(in_array($invoice->status, ['approved','partial']) && Auth::user()->isDirector())
            <button type="button" class="btn btn-sm btn-fluxa-success" onclick="openPaymentModal()">
                <i class="fas fa-money-bill-wave mr-1"></i> Catat Pembayaran
            </button>
        @endif
        <a href="{{ route('billing.invoices.print', $invoice) }}" class="btn btn-sm btn-fluxa-secondary">
            <i class="fas fa-file-pdf mr-1" style="color:#ef4444;"></i> Download PDF
        </a>
        @if($invoice->status === 'draft')
        <form method="POST" action="{{ route('billing.invoices.destroy', $invoice) }}" class="d-inline"
              data-confirm="Hapus invoice ini secara permanen?" data-confirm-icon="warning" data-confirm-btn="Ya, Hapus">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-icon btn-fluxa-secondary" title="Hapus" style="color:#ef4444!important;">
                <i class="fas fa-trash" style="font-size:11px;"></i>
            </button>
        </form>
        @endif
    </div>
</li>
@endsection

@section('content')

{{-- Status bar --}}
@php
    $color = $invoice->status_color;
    $alertMap = ['emerald'=>'alert-success','blue'=>'alert-info','amber'=>'alert-warning','red'=>'alert-danger','slate'=>'alert-secondary'];
    $iconMap  = ['emerald'=>'fa-circle-check','blue'=>'fa-stamp','amber'=>'fa-clock','red'=>'fa-circle-xmark','slate'=>'fa-file'];
@endphp
<div class="alert {{ $alertMap[$color] ?? 'alert-secondary' }} mb-4">
    <div class="d-flex align-items-center justify-content-between" style="gap:12px;">
        <div class="d-flex align-items-center" style="gap:10px;">
            <i class="fas {{ $iconMap[$color] ?? 'fa-file' }}"></i>
            <div>
                <strong>Status: {{ $invoice->status_label }}</strong>
                @if($invoice->status === 'draft')
                <div style="font-size:11px;margin-top:2px;opacity:.85;">Ajukan ke Director agar masuk ke data pendapatan perusahaan setelah disetujui.</div>
                @elseif($invoice->status === 'pending_approval')
                <div style="font-size:11px;margin-top:2px;opacity:.85;">Menunggu persetujuan Director. Setelah disetujui, invoice ini akan tercatat sebagai pendapatan resmi.</div>
                @elseif(in_array($invoice->status, ['approved','partial','paid']))
                <div style="font-size:11px;margin-top:2px;opacity:.85;">
                    @if($invoice->approved_at) Disetujui {{ $invoice->approved_at->isoFormat('D MMMM YYYY') }} oleh {{ $invoice->approver->name ?? '&mdash;' }} @endif
                    &nbsp;&middot;&nbsp; <i class="fas fa-chart-line" style="font-size:9px;"></i> <strong>Tercatat di data pendapatan</strong>
                </div>
                @elseif($invoice->status === 'rejected')
                <div style="font-size:11px;margin-top:2px;opacity:.85;">Invoice ditolak. Edit dan ajukan ulang.</div>
                @endif
            </div>
        </div>
        <span style="font-size:11px;opacity:.7;white-space:nowrap;">
            {{ $invoice->creator->name }} &middot; {{ $invoice->created_at->isoFormat('D MMM YYYY') }}
        </span>
    </div>
    @if($invoice->director_notes)
    <div style="margin-top:10px;padding:10px 14px;background:rgba(0,0,0,0.05);border-radius:8px;font-size:12px;line-height:1.6;border-left:3px solid rgba(0,0,0,0.15);">
        <i class="fas fa-comment-dots mr-1" style="opacity:.6;"></i>
        <strong>Catatan Director:</strong> {{ $invoice->director_notes }}
    </div>
    @endif
</div>

<div class="row">

    {{-- ── DOCUMENT PREVIEW ── --}}
    <div class="col-lg-8 mb-4">
        <div class="card">

            {{-- Doc header --}}
            <div style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);border-radius:12px 12px 0 0;">
                <div class="p-4 d-flex align-items-start justify-content-between" style="gap:16px;">
                    <div>
                        <img src="{{ asset('assets/images/logo-white-transparent.png') }}"
                             alt="Fluxa" style="height:34px;margin-bottom:10px;opacity:.9;">
                        <p style="color:#fff;font-weight:700;font-size:13px;margin-bottom:4px;">PT FLUXA TRITAMA INDONESIA</p>
                        <p style="color:#94a3b8;font-size:11px;line-height:1.6;margin-bottom:0;">
                            Tapin, RT 011, RW 004, Suato Tatakan<br>
                            Tapin Selatan, Kalimantan Selatan 71181<br>
                            0812-5065-3005 · official@fluxa.co.id
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p style="font-size:24px;font-weight:900;color:#fff;letter-spacing:-0.5px;margin-bottom:4px;">INVOICE</p>
                        <p style="color:#60a5fa;font-family:monospace;font-size:13px;font-weight:700;margin-bottom:6px;">{{ $invoice->invoice_number }}</p>
                        <p style="font-size:11px;color:#94a3b8;margin-bottom:2px;">Tgl Invoice: {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                        @if($invoice->due_date)
                        <p style="font-size:11px;margin-bottom:2px;{{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'color:#f87171;' : 'color:#94a3b8;' }}">
                            Jatuh Tempo: {{ $invoice->due_date->format('d/m/Y') }}
                        </p>
                        @endif
                        @if($invoice->quotation)
                        <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">Ref: {{ $invoice->quotation->quotation_number }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Doc content --}}
            <div class="card-body">

                {{-- Client & Project --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div style="background:#f8fafc;border-radius:10px;padding:16px;height:100%;">
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Ditagihkan Kepada</p>
                            <p style="color:#1e293b;font-weight:700;font-size:14px;margin-bottom:4px;">{{ $invoice->client->name }}</p>
                            @if($invoice->client->address)
                            <p style="color:#64748b;font-size:12px;margin-bottom:2px;">{{ $invoice->client->address }}</p>
                            @endif
                            @if($invoice->client->city)
                            <p style="color:#64748b;font-size:12px;margin-bottom:2px;">{{ $invoice->client->city }}</p>
                            @endif
                            @if($invoice->client->email)
                            <p style="color:#94a3b8;font-size:11px;margin-bottom:0;">{{ $invoice->client->email }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background:#f8fafc;border-radius:10px;padding:16px;height:100%;">
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Proyek</p>
                            <p style="color:#1e293b;font-weight:600;font-size:14px;margin-bottom:4px;">{{ $invoice->title }}</p>
                            @if($invoice->description)
                            <p style="color:#64748b;font-size:12px;margin-bottom:0;">{{ $invoice->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Items table --}}
                <div class="table-responsive mb-4" style="border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;">
                    <table class="table mb-0" style="font-size:13px;">
                        <thead>
                            <tr style="background:#1e293b;">
                                <th style="color:#cbd5e1;border:none;width:40px;">No</th>
                                <th style="color:#cbd5e1;border:none;">Deskripsi</th>
                                <th style="color:#cbd5e1;border:none;text-align:center;width:56px;">Qty</th>
                                <th style="color:#cbd5e1;border:none;text-align:right;">Harga Satuan</th>
                                <th style="color:#cbd5e1;border:none;text-align:right;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $i => $item)
                            <tr>
                                <td style="color:#94a3b8;text-align:center;">{{ $i + 1 }}</td>
                                <td style="color:#334155;">{{ $item->description }}</td>
                                <td style="color:#64748b;text-align:center;">{{ $item->quantity }}</td>
                                <td style="color:#64748b;text-align:right;white-space:nowrap;">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td style="color:#1e293b;font-weight:600;text-align:right;white-space:nowrap;">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="border-top:2px solid #cbd5e1;background:#f8fafc;">
                            <tr>
                                <td colspan="3"></td>
                                <td style="text-align:right;font-weight:700;color:#475569;font-size:13px;">TOTAL</td>
                                <td style="text-align:right;font-weight:900;color:#1e293b;font-size:16px;white-space:nowrap;">
                                    Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Payment info --}}
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px;" class="mb-4">
                    <p style="font-size:10px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">
                        <i class="fas fa-building-columns mr-1"></i> Informasi Pembayaran
                    </p>
                    <div class="row" style="font-size:12px;">
                        <div class="col-4">
                            <p style="color:#64748b;margin-bottom:2px;">Bank</p>
                            <p style="font-weight:700;color:#1e293b;margin-bottom:0;">MANDIRI</p>
                        </div>
                        <div class="col-4">
                            <p style="color:#64748b;margin-bottom:2px;">No. Rekening</p>
                            <p style="font-weight:700;color:#1e293b;font-family:monospace;margin-bottom:0;">031 00 2387227 1</p>
                        </div>
                        <div class="col-4">
                            <p style="color:#64748b;margin-bottom:2px;">Atas Nama</p>
                            <p style="font-weight:700;color:#1e293b;margin-bottom:0;">PT Fluxa Tritama Indonesia</p>
                        </div>
                    </div>
                </div>

                {{-- T&C --}}
                @if($invoice->terms_and_conditions)
                <div style="border-top:1px solid #f1f5f9;padding-top:16px;" class="mb-4">
                    <p style="font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">Syarat & Ketentuan</p>
                    <div style="font-size:12px;color:#475569;line-height:1.7;">
                        @foreach(explode("\n\n", $invoice->terms_and_conditions) as $para)
                        <div style="border-left:2px solid #bfdbfe;padding-left:10px;margin-bottom:8px;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong style="color:#1e293b;">$1</strong>', e(trim($para)))) !!}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Footer: creator + QR --}}
                <div class="d-flex align-items-end justify-content-between" style="border-top:1px solid #f1f5f9;padding-top:16px;gap:16px;">
                    <div style="font-size:12px;color:#64748b;">
                        <p style="margin-bottom:2px;">Disiapkan oleh: <strong style="color:#334155;">{{ $invoice->creator->name }}</strong></p>
                        <p style="margin-bottom:0;">{{ $invoice->creator->position ?? 'PT Fluxa Tritama Indonesia' }}</p>
                        @if(in_array($invoice->status, ['approved', 'paid']))
                        <div style="margin-top:10px;padding:8px 12px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;">
                            <p style="font-size:10px;font-weight:700;color:#1e40af;text-transform:uppercase;margin-bottom:2px;">✓ Disetujui Director</p>
                            <p style="font-size:10px;color:#2563eb;margin-bottom:0;">{{ $invoice->approver->name ?? '' }} · {{ $invoice->approved_at?->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        @if($invoice->status === 'paid')
                        <div style="margin-top:6px;padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                            <p style="font-size:10px;font-weight:700;color:#166534;text-transform:uppercase;margin-bottom:0;">✓ LUNAS</p>
                        </div>
                        @endif
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div id="qrcode" style="display:inline-block;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0;padding:6px;background:#fff;"></div>
                        <p style="font-size:10px;color:#94a3b8;margin-top:4px;margin-bottom:0;">Scan untuk verifikasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RIGHT SIDEBAR ── --}}
    <div class="col-lg-4">

        {{-- Profit split --}}
        @if(Auth::user()->isDirector() || $invoice->created_by === Auth::id())
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-chart-pie" style="color:#2563eb;font-size:13px;"></i>
                <h6 class="card-title mb-0">Pembagian Keuntungan</h6>
            </div>
            <div class="card-body p-0">
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#64748b;">Total Invoice</span>
                    <span style="font-weight:700;color:#1e293b;font-size:13px;">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#92400e;font-weight:500;">Keuntungan PT <span style="font-size:11px;color:#94a3b8;">({{ $invoice->pt_profit_percent }}%)</span></span>
                    <span style="font-weight:600;color:#92400e;font-size:13px;">Rp {{ number_format($invoice->pt_profit_amount, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#166534;font-weight:500;">
                        {{ Auth::user()->isDirector() ? 'Bagian ' . ($invoice->creator->name ?? 'Staff') : 'Bagian Anda' }}
                    </span>
                    <span style="font-weight:700;color:#166534;font-size:15px;">Rp {{ number_format($invoice->user_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Document info --}}
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Informasi Dokumen</h6>
            </div>
            <div class="card-body" style="font-size:12px;">
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">No. Invoice</span>
                    <span style="font-family:monospace;font-weight:700;color:#1e293b;text-align:right;">{{ $invoice->invoice_number }}</span>
                </div>
                @if($invoice->quotation)
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">Ref. Quotation</span>
                    <a href="{{ route('billing.quotations.show', $invoice->quotation) }}"
                       style="font-family:monospace;font-weight:700;color:#2563eb;text-align:right;">
                        {{ $invoice->quotation->quotation_number }}
                    </a>
                </div>
                @endif
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">Klien</span>
                    <span style="color:#334155;text-align:right;">{{ $invoice->client->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Tgl Invoice</span>
                    <span style="color:#334155;">{{ $invoice->invoice_date->format('d/m/Y') }}</span>
                </div>
                @if($invoice->due_date)
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Jatuh Tempo</span>
                    <span style="{{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'color:#dc2626;font-weight:700;' : 'color:#334155;' }}">
                        {{ $invoice->due_date->format('d/m/Y') }}
                    </span>
                </div>
                @endif
                <div class="d-flex justify-content-between">
                    <span style="color:#64748b;">Dibuat oleh</span>
                    <span style="color:#334155;">{{ $invoice->creator->name }}</span>
                </div>
            </div>
        </div>

        {{-- Payment summary card --}}
        <div class="card mb-3" style="border-color:#bfdbfe!important;">
            <div class="card-body" style="padding:14px 16px;background:#eff6ff;border-radius:12px;">
                <p style="font-size:10px;font-weight:700;color:#1e40af;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">
                    <i class="fas fa-building-columns mr-1"></i> Rekening Pembayaran
                </p>
                <p style="font-size:12px;font-weight:700;color:#1e293b;margin-bottom:2px;">Bank Mandiri</p>
                <p style="font-size:13px;font-weight:800;color:#1e293b;font-family:monospace;margin-bottom:2px;">031 00 2387227 1</p>
                <p style="font-size:11px;color:#64748b;margin-bottom:0;">a/n PT Fluxa Tritama Indonesia</p>
            </div>
        </div>

        {{-- Verification link --}}
        <div class="card">
            <div class="card-body" style="padding:14px 16px;">
                <p style="font-size:11px;font-weight:600;color:#64748b;margin-bottom:6px;">
                    <i class="fas fa-link mr-1" style="color:#94a3b8;"></i> Link Verifikasi
                </p>
                <p style="font-size:11px;color:#2563eb;font-family:monospace;word-break:break-all;margin-bottom:0;line-height:1.6;">
                    {{ route('verify.invoice', $invoice->qr_token) }}
                </p>
            </div>
        </div>

    </div>
</div>

{{-- Payment History --}}
@if($invoice->payments->count() > 0)
<div class="card mt-4">
    <div class="card-header d-flex align-items-center" style="gap:8px;">
        <i class="fas fa-money-bill-wave" style="color:#16a34a;font-size:13px;"></i>
        <h6 class="card-title mb-0">Riwayat Pembayaran</h6>
        <span style="margin-left:auto;font-size:12px;color:#64748b;">
            Terbayar: <strong style="color:#16a34a;">Rp {{ number_format($invoice->amount_paid, 0, ',', '.') }}</strong>
            &nbsp;|&nbsp; Sisa: <strong style="color:{{ $invoice->amount_remaining > 0 ? '#dc2626' : '#16a34a' }};">Rp {{ number_format($invoice->amount_remaining, 0, ',', '.') }}</strong>
        </span>
    </div>
    <div class="card-body p-0">
        <table class="table mb-0" style="font-size:12px;">
            <thead><tr>
                <th>Tanggal</th><th>Jenis</th><th>Metode</th><th class="text-right">Jumlah</th><th>Catatan</th><th>Dicatat oleh</th>
            </tr></thead>
            <tbody>
                @foreach($invoice->payments as $pay)
                <tr>
                    <td>{{ $pay->payment_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="pill {{ $pay->type === 'full' ? 'pill-paid' : 'pill-pending' }}" style="font-size:10px;">
                            {{ $pay->type === 'full' ? 'Lunas' : 'Sebagian' }}
                        </span>
                    </td>
                    <td>{{ $pay->payment_method ?? '&mdash;' }}</td>
                    <td class="text-right" style="font-weight:700;color:#16a34a;">Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                    <td style="color:#64748b;">{{ $pay->notes ?? '&mdash;' }}</td>
                    <td style="color:#94a3b8;">{{ $pay->recorder->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('verify.invoice', $invoice->qr_token) }}",
    width: 80, height: 80,
    colorDark: "#000000", colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});

function openApproveModal() {
    Swal.fire({
        title: 'Setujui & Terbitkan Invoice',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Invoice <strong>{{ $invoice->invoice_number }}</strong> akan disetujui dan masuk ke data pendapatan.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Catatan untuk staff (opsional)..." style="height:90px;font-size:13px;"></textarea>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-circle-check mr-1"></i> Ya, Setujui & Terbitkan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.invoices.approve", $invoice) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openRejectModal() {
    Swal.fire({
        title: 'Tolak Invoice',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Invoice <strong>{{ $invoice->invoice_number }}</strong> akan ditolak dan dikembalikan ke Draft.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Alasan penolakan (opsional)..." style="height:90px;font-size:13px;"></textarea>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-xmark mr-1"></i> Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.invoices.reject", $invoice) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openPaymentModal() {
    const remaining = {{ $invoice->amount_remaining ?? $invoice->total }};
    const fmtRp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    Swal.fire({
        title: 'Catat Pembayaran',
        width: 520,
        html: `
            <p style="font-size:12px;color:#64748b;margin-bottom:14px;">Sisa tagihan: <strong style="color:#dc2626;">${fmtRp(remaining)}</strong></p>
            <div style="text-align:left;">
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Jenis Pembayaran</label>
                <div style="display:flex;gap:12px;margin-bottom:14px;">
                    <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                        <input type="radio" name="ptype" value="partial" id="r-partial" checked onchange="toggleAmount()"> Pembayaran Sebagian
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                        <input type="radio" name="ptype" value="full" id="r-full" onchange="toggleAmount()"> Lunas Penuh
                    </label>
                </div>
                <div id="amount-wrap" style="margin-bottom:14px;">
                    <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Jumlah Dibayar (Rp)</label>
                    <input type="number" id="pay-amount" class="swal2-input" style="margin:0;" placeholder="Masukkan nominal..." min="1" max="${remaining}">
                </div>
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Tanggal Pembayaran</label>
                <input type="date" id="pay-date" class="swal2-input" style="margin:0 0 14px;" value="{{ now()->format('Y-m-d') }}">
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Metode Pembayaran</label>
                <input type="text" id="pay-method" class="swal2-input" style="margin:0 0 14px;" placeholder="Transfer Bank, Tunai, dll">
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;">Catatan</label>
                <input type="text" id="pay-notes" class="swal2-input" style="margin:0;" placeholder="Opsional">
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save mr-1"></i> Simpan Pembayaran',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb',
        focusConfirm: false,
        didOpen: () => { toggleAmount(); },
        preConfirm: () => {
            const type   = document.querySelector('input[name="ptype"]:checked').value;
            const amount = document.getElementById('pay-amount').value;
            const date   = document.getElementById('pay-date').value;
            const method = document.getElementById('pay-method').value;
            const notes  = document.getElementById('pay-notes').value;
            if (type === 'partial') {
                if (!amount || parseFloat(amount) <= 0) {
                    Swal.showValidationMessage('Masukkan jumlah pembayaran yang valid.');
                    return false;
                }
                if (parseFloat(amount) > remaining) {
                    Swal.showValidationMessage(
                        `Jumlah melebihi sisa tagihan. Maksimal yang dapat dibayar: ${fmtRp(remaining)}`
                    );
                    return false;
                }
            }
            if (!date) { Swal.showValidationMessage('Tanggal pembayaran wajib diisi.'); return false; }
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.invoices.payment", $invoice) }}';
            form.innerHTML = `
                <input name="_token" value="{{ csrf_token() }}">
                <input name="payment_type" value="${type}">
                <input name="amount" value="${amount}">
                <input name="payment_date" value="${date}">
                <input name="payment_method" value="${method}">
                <input name="notes" value="${notes}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function toggleAmount() {
    const isFull = document.getElementById('r-full') && document.getElementById('r-full').checked;
    const wrap = document.getElementById('amount-wrap');
    if (wrap) wrap.style.display = isFull ? 'none' : 'block';
}
</script>
@endpush
