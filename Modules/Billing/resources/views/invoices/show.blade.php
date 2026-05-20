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
            <form method="POST" action="{{ route('billing.invoices.approve', $invoice) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-success">
                    <i class="fas fa-circle-check mr-1"></i> Setujui &amp; Terbitkan ke Pendapatan
                </button>
            </form>
            <form method="POST" action="{{ route('billing.invoices.reject', $invoice) }}" class="d-inline"
                  data-confirm="Tolak invoice ini? Invoice akan dikembalikan ke Draft." data-confirm-icon="warning" data-confirm-btn="Ya, Tolak">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-danger">
                    <i class="fas fa-xmark mr-1"></i> Tolak
                </button>
            </form>
        @endif
        @if($invoice->status === 'approved' && Auth::user()->isDirector())
            <form method="POST" action="{{ route('billing.invoices.paid', $invoice) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-fluxa-success">
                    <i class="fas fa-money-bill-wave mr-1"></i> Tandai Lunas
                </button>
            </form>
        @endif
        <a href="{{ route('billing.invoices.print', $invoice) }}" target="_blank" class="btn btn-sm btn-fluxa-secondary">
            <i class="fas fa-print mr-1"></i> Cetak
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
<div class="alert {{ $alertMap[$color] ?? 'alert-secondary' }} d-flex align-items-center justify-content-between mb-4" style="gap:12px;">
    <div class="d-flex align-items-center" style="gap:10px;">
        <i class="fas {{ $iconMap[$color] ?? 'fa-file' }}"></i>
        <div>
            <strong>Status: {{ $invoice->status_label }}</strong>
            @if($invoice->status === 'draft')
            <div style="font-size:11px;margin-top:2px;opacity:.85;">Ajukan ke Director agar masuk ke data pendapatan perusahaan setelah disetujui.</div>
            @elseif($invoice->status === 'pending_approval')
            <div style="font-size:11px;margin-top:2px;opacity:.85;">Menunggu persetujuan Director. Setelah disetujui, invoice ini akan tercatat sebagai pendapatan resmi.</div>
            @elseif(in_array($invoice->status, ['approved','paid']))
            <div style="font-size:11px;margin-top:2px;opacity:.85;">
                @if($invoice->approved_at) Disetujui {{ $invoice->approved_at->isoFormat('D MMMM YYYY') }} oleh {{ $invoice->approver->name ?? '—' }} @endif
                &nbsp;·&nbsp; <i class="fas fa-chart-line" style="font-size:9px;"></i> <strong>Tercatat di data pendapatan</strong>
            </div>
            @elseif($invoice->status === 'rejected')
            <div style="font-size:11px;margin-top:2px;opacity:.85;">Invoice ditolak. Edit dan ajukan ulang.</div>
            @endif
        </div>
    </div>
    <span style="font-size:11px;opacity:.7;white-space:nowrap;">
        {{ $invoice->creator->name }} · {{ $invoice->created_at->isoFormat('D MMM YYYY') }}
    </span>
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
</script>
@endpush
