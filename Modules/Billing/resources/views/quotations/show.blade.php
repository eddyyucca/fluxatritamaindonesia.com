@extends('layouts.portal')
@section('title', $quotation->quotation_number)
@section('page-title', 'Detail Quotation')

@section('topbar-actions')
<li class="nav-item">
    <div class="d-flex align-items-center" style="gap:6px;">
        @if($quotation->status === 'draft')
            <a href="{{ route('billing.quotations.edit', $quotation) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.quotations.submit', $quotation) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-primary">
                    <i class="fas fa-paper-plane mr-1"></i> Ajukan Persetujuan
                </button>
            </form>
        @endif
        @if($quotation->status === 'sent' && Auth::user()->isDirector())
            <a href="{{ route('billing.quotations.edit', $quotation) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-sm btn-fluxa-success" onclick="openApproveModal()">
                <i class="fas fa-check mr-1"></i> Setujui
            </button>
            <button type="button" class="btn btn-sm btn-fluxa-danger" onclick="openRejectModal()">
                <i class="fas fa-xmark mr-1"></i> Tolak
            </button>
        @endif
        @if(in_array($quotation->status, ['approved', 'rejected']) && Auth::user()->isDirector())
            <a href="{{ route('billing.quotations.edit', $quotation) }}" class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.quotations.revert', $quotation) }}" class="d-inline"
                  data-confirm="Kembalikan quotation ini ke Draft?" data-confirm-icon="question" data-confirm-btn="Ya, Kembalikan">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-secondary" style="color:#d97706!important;">
                    <i class="fas fa-rotate-left mr-1"></i> Kembalikan ke Draft
                </button>
            </form>
        @endif
        @if($quotation->status === 'approved')
            @if($quotation->invoices->count())
            {{-- Invoice sudah ada --}}
            <a href="{{ route('billing.invoices.show', $quotation->invoices->first()) }}"
               class="btn btn-sm btn-fluxa-secondary">
                <i class="fas fa-file-invoice-dollar mr-1"></i> Lihat Invoice
            </a>
            @else
            {{-- Terbitkan 1 klik --}}
            <form method="POST" action="{{ route('billing.quotations.to-invoice', $quotation) }}" class="d-inline"
                  data-confirm="Konfirmasi penerbitan Invoice berdasarkan Quotation {{ $quotation->quotation_number }}. Invoice akan memerlukan persetujuan final Director sebelum resmi diterbitkan."
                  data-confirm-icon="question" data-confirm-btn="Ya, Terbitkan Invoice">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-primary">
                    <i class="fas fa-file-invoice-dollar mr-1"></i> Terbitkan sebagai Invoice
                </button>
            </form>
            @endif
        @endif
        <a href="{{ route('billing.quotations.print', $quotation) }}" class="btn btn-sm btn-fluxa-secondary">
            <i class="fas fa-file-pdf mr-1" style="color:#ef4444;"></i> Download PDF
        </a>
        @if($quotation->status === 'draft')
        <form method="POST" action="{{ route('billing.quotations.destroy', $quotation) }}" class="d-inline"
              data-confirm="Hapus quotation ini secara permanen?" data-confirm-icon="warning" data-confirm-btn="Ya, Hapus">
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
    $color = $quotation->status_color;
    $alertMap = ['emerald'=>'alert-success','amber'=>'alert-warning','red'=>'alert-danger','slate'=>'alert-secondary','blue'=>'alert-info'];
    $iconMap  = ['emerald'=>'fa-circle-check','amber'=>'fa-clock','red'=>'fa-circle-xmark','slate'=>'fa-file','blue'=>'fa-stamp'];
@endphp
<div class="alert {{ $alertMap[$color] ?? 'alert-secondary' }} mb-4" style="gap:12px;">
    <div class="d-flex align-items-center justify-content-between" style="gap:12px;">
        <div class="d-flex align-items-center" style="gap:10px;">
            <i class="fas {{ $iconMap[$color] ?? 'fa-file' }}"></i>
            <div>
                <strong>Status: {{ $quotation->status_label }}</strong>
                @if($quotation->approved_at)
                <span style="font-size:12px;opacity:.75;margin-left:8px;">
                    &mdash; {{ $quotation->approved_at->isoFormat('D MMMM YYYY') }} oleh {{ $quotation->approver->name ?? '&mdash;' }}
                </span>
                @endif
            </div>
        </div>
        <span style="font-size:11px;opacity:.7;white-space:nowrap;">
            {{ $quotation->creator->name }} &middot; {{ $quotation->created_at->isoFormat('D MMM YYYY') }}
        </span>
    </div>
    @if($quotation->director_notes)
    <div style="margin-top:10px;padding:10px 14px;background:rgba(0,0,0,0.05);border-radius:8px;font-size:12px;line-height:1.6;border-left:3px solid rgba(0,0,0,0.15);">
        <i class="fas fa-comment-dots mr-1" style="opacity:.6;"></i>
        <strong>Catatan Director:</strong> {{ $quotation->director_notes }}
    </div>
    @endif
</div>

<div class="row">

    {{-- ── DOCUMENT PREVIEW ── --}}
    <div class="col-lg-8 mb-4">
        <div class="card">

            {{-- Doc header (dark) --}}
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
                        <p style="font-size:24px;font-weight:900;color:#fff;letter-spacing:-0.5px;margin-bottom:4px;">QUOTATION</p>
                        <p style="color:#60a5fa;font-family:monospace;font-size:13px;font-weight:700;margin-bottom:6px;">{{ $quotation->quotation_number }}</p>
                        <p style="font-size:11px;color:#94a3b8;margin-bottom:2px;">Tanggal: {{ $quotation->created_at->format('d/m/Y') }}</p>
                        @if($quotation->valid_until)
                        <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">Berlaku s/d: {{ $quotation->valid_until->format('d/m/Y') }}</p>
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
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Ditujukan Kepada</p>
                            <p style="color:#1e293b;font-weight:700;font-size:14px;margin-bottom:4px;">{{ $quotation->client->name }}</p>
                            @if($quotation->client->address)
                            <p style="color:#64748b;font-size:12px;margin-bottom:2px;">{{ $quotation->client->address }}</p>
                            @endif
                            @if($quotation->client->city)
                            <p style="color:#64748b;font-size:12px;margin-bottom:2px;">{{ $quotation->client->city }}</p>
                            @endif
                            @if($quotation->client->email)
                            <p style="color:#94a3b8;font-size:11px;margin-bottom:0;">{{ $quotation->client->email }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="background:#f8fafc;border-radius:10px;padding:16px;height:100%;">
                            <p style="font-size:9px;color:#94a3b8;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">Proyek</p>
                            <p style="color:#1e293b;font-weight:600;font-size:14px;margin-bottom:4px;">{{ $quotation->title }}</p>
                            @if($quotation->description)
                            <p style="color:#64748b;font-size:12px;margin-bottom:0;">{{ $quotation->description }}</p>
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
                            @foreach($quotation->items as $i => $item)
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
                                    Rp {{ number_format($quotation->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Quotation Notice (penawaran, bukan tagihan) --}}
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:16px;" class="mb-4">
                    <p style="font-size:10px;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">
                        <i class="fas fa-circle-info mr-1"></i> Keterangan Penawaran
                    </p>
                    <p style="font-size:12px;color:#78350f;margin-bottom:0;line-height:1.7;">
                        Dokumen ini merupakan <strong>surat penawaran harga</strong>, bukan tagihan atau permintaan pembayaran.
                        Pembayaran hanya dilakukan setelah penawaran ini disetujui oleh kedua belah pihak dan invoice resmi telah diterbitkan.
                    </p>
                </div>

                {{-- T&C --}}
                @if($quotation->terms_and_conditions)
                <div style="border-top:1px solid #f1f5f9;padding-top:16px;" class="mb-4">
                    <p style="font-size:10px;font-weight:700;color:#475569;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;">Syarat & Ketentuan</p>
                    <div style="font-size:12px;color:#475569;line-height:1.7;">
                        @foreach(explode("\n\n", $quotation->terms_and_conditions) as $para)
                        <div style="border-left:2px solid #fde68a;padding-left:10px;margin-bottom:8px;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong style="color:#1e293b;">$1</strong>', e(trim($para)))) !!}
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Footer: creator + QR --}}
                <div class="d-flex align-items-end justify-content-between" style="border-top:1px solid #f1f5f9;padding-top:16px;gap:16px;">
                    <div style="font-size:12px;color:#64748b;">
                        <p style="margin-bottom:2px;">Disiapkan oleh: <strong style="color:#334155;">{{ $quotation->creator->name }}</strong></p>
                        <p style="margin-bottom:0;">{{ $quotation->creator->position ?? 'PT Fluxa Tritama Indonesia' }}</p>
                        @if($quotation->status === 'approved')
                        <div style="margin-top:10px;padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                            <p style="font-size:10px;font-weight:700;color:#166534;text-transform:uppercase;margin-bottom:2px;">✓ Disetujui Director</p>
                            <p style="font-size:10px;color:#16a34a;margin-bottom:0;">{{ $quotation->approver->name ?? '' }} · {{ $quotation->approved_at?->format('d/m/Y') }}</p>
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
        @if(Auth::user()->isDirector() || $quotation->created_by === Auth::id())
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-chart-pie" style="color:#2563eb;font-size:13px;"></i>
                <h6 class="card-title mb-0">Pembagian Keuntungan</h6>
            </div>
            <div class="card-body p-0">
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#64748b;">Total Proyek</span>
                    <span style="font-weight:700;color:#1e293b;font-size:13px;">Rp {{ number_format($quotation->total, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#92400e;font-weight:500;">Keuntungan PT <span style="font-size:11px;color:#94a3b8;">({{ $quotation->pt_profit_percent }}%)</span></span>
                    <span style="font-weight:600;color:#92400e;font-size:13px;">Rp {{ number_format($quotation->pt_profit_amount, 0, ',', '.') }}</span>
                </div>
                <div style="padding:12px 16px;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:13px;color:#166534;font-weight:500;">
                        {{ Auth::user()->isDirector() ? 'Bagian ' . ($quotation->creator->name ?? 'Staff') : 'Bagian Anda' }}
                    </span>
                    <span style="font-weight:700;color:#166534;font-size:15px;">Rp {{ number_format($quotation->user_amount, 0, ',', '.') }}</span>
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
                    <span style="color:#64748b;flex-shrink:0;">No. Quotation</span>
                    <span style="font-family:monospace;font-weight:700;color:#1e293b;text-align:right;">{{ $quotation->quotation_number }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-start mb-2" style="gap:8px;">
                    <span style="color:#64748b;flex-shrink:0;">Klien</span>
                    <span style="color:#334155;text-align:right;">{{ $quotation->client->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Tanggal Dibuat</span>
                    <span style="color:#334155;">{{ $quotation->created_at->format('d/m/Y') }}</span>
                </div>
                @if($quotation->valid_until)
                <div class="d-flex justify-content-between mb-2">
                    <span style="color:#64748b;">Berlaku s/d</span>
                    <span style="{{ $quotation->valid_until->isPast() ? 'color:#dc2626;font-weight:700;' : 'color:#334155;' }}">
                        {{ $quotation->valid_until->format('d/m/Y') }}
                        @if($quotation->valid_until->isPast()) <br><small>(Kedaluwarsa)</small> @endif
                    </span>
                </div>
                @endif
                <div class="d-flex justify-content-between">
                    <span style="color:#64748b;">Dibuat oleh</span>
                    <span style="color:#334155;">{{ $quotation->creator->name }}</span>
                </div>
                @if($quotation->invoices->count())
                <div style="border-top:1px solid #f1f5f9;margin-top:10px;padding-top:10px;">
                    <p style="color:#64748b;font-weight:600;margin-bottom:6px;">Invoice terkait:</p>
                    @foreach($quotation->invoices as $inv)
                    <a href="{{ route('billing.invoices.show', $inv) }}"
                       style="display:block;color:#2563eb;font-family:monospace;font-size:12px;">
                        {{ $inv->invoice_number }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Verification link --}}
        <div class="card">
            <div class="card-body" style="padding:14px 16px;">
                <p style="font-size:11px;font-weight:600;color:#64748b;margin-bottom:6px;">
                    <i class="fas fa-link mr-1" style="color:#94a3b8;"></i> Link Verifikasi
                </p>
                <p style="font-size:11px;color:#2563eb;font-family:monospace;word-break:break-all;margin-bottom:0;line-height:1.6;">
                    {{ route('verify.quotation', $quotation->qr_token) }}
                </p>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('verify.quotation', $quotation->qr_token) }}",
    width: 80, height: 80,
    colorDark: "#000000", colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});

function openApproveModal() {
    Swal.fire({
        title: 'Setujui Quotation',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Quotation <strong>{{ $quotation->quotation_number }}</strong> akan disetujui.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Catatan untuk staff (opsional)..." style="height:100px;font-size:13px;"></textarea>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check mr-1"></i> Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#16a34a',
        focusConfirm: false,
        preConfirm: () => {
            const notes = document.getElementById('swal-notes').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("billing.quotations.approve", $quotation) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function openRejectModal() {
    Swal.fire({
        title: 'Tolak Quotation',
        html: `
            <p style="font-size:13px;color:#64748b;margin-bottom:12px;">
                Quotation <strong>{{ $quotation->quotation_number }}</strong> akan ditolak.
            </p>
            <textarea id="swal-notes" class="swal2-textarea" placeholder="Alasan penolakan (opsional)..." style="height:100px;font-size:13px;"></textarea>
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
            form.action = '{{ route("billing.quotations.reject", $quotation) }}';
            form.innerHTML = `<input name="_token" value="{{ csrf_token() }}"><input name="director_notes" value="${notes}">`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
