<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page { margin: 35px 40px 60px 40px; }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: #ffffff;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* ── HEADER ── */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .header-table td { vertical-align: top; }
        .header-left { width: 60%; }
        .header-right { width: 40%; text-align: right; }
        
        .company-logo { height: 60px; margin-bottom: 8px; }
        .company-name { font-size: 14px; font-weight: bold; color: #0f172a; margin: 0 0 2px 0; }
        .company-contact { font-size: 10px; color: #64748b; margin: 0; }
        
        .doc-title { font-size: 24px; font-weight: bold; color: #0284c7; letter-spacing: 1px; margin: 0 0 2px 0; }
        .doc-no { font-size: 12px; font-weight: bold; color: #334155; margin: 0 0 8px 0; }
        
        .meta-table { border-collapse: collapse; width: 200px; margin-left: auto; }
        .meta-table td { font-size: 10px; padding: 2px 0; }
        .meta-label { color: #64748b; font-weight: bold; text-align: right; padding-right: 8px; }
        .meta-val { color: #0f172a; font-weight: bold; text-align: right; }

        .divider { border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; }

        /* ── CLIENT & STATUS ── */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { vertical-align: top; }
        
        .box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; }
        .box-title { font-size: 9px; color: #64748b; font-weight: bold; text-transform: uppercase; margin: 0 0 6px 0; }
        
        .client-name { font-size: 13px; font-weight: bold; color: #0f172a; margin: 0 0 3px 0; }
        .client-detail { font-size: 11px; color: #475569; margin: 0 0 2px 0; }

        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 11px; }
        .status-unpaid { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
        .status-paid { background-color: #d1fae5; color: #047857; border: 1px solid #6ee7b7; }
        .status-partial { background-color: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }

        /* ── ITEMS TABLE ── */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e2e8f0; }
        .items-table thead tr { background-color: #f8fafc; border-bottom: 2px solid #cbd5e1; }
        .items-table th {
            font-size: 10px; font-weight: bold; color: #334155; text-transform: uppercase;
            padding: 8px 10px; text-align: left;
        }
        .items-table td {
            padding: 8px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; vertical-align: top;
        }
        
        .th-no { width: 5%; text-align: center !important; }
        .th-qty { width: 8%; text-align: center !important; }
        .th-price { width: 20%; text-align: right !important; }
        .th-total { width: 22%; text-align: right !important; }

        .td-no { text-align: center; color: #64748b; }
        .td-desc { font-weight: bold; color: #0f172a; }
        .td-qty { text-align: center; }
        .td-price { text-align: right; }
        .td-total { text-align: right; font-weight: bold; color: #0f172a; }

        /* ── TOTALS ── */
        .totals-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .totals-table td { padding: 6px 10px; font-size: 11px; }
        .totals-label { text-align: right; color: #475569; font-weight: bold; width: 75%; }
        .totals-val { text-align: right; color: #0f172a; font-weight: bold; width: 25%; }
        
        .grand-total-label { text-align: right; font-size: 12px; font-weight: bold; color: #0f172a; border-top: 2px solid #cbd5e1; padding-top: 8px; }
        .grand-total-val { text-align: right; font-size: 14px; font-weight: bold; color: #0284c7; border-top: 2px solid #cbd5e1; padding-top: 8px; }

        /* ── PAYMENT & SIGNATURE ── */
        .bottom-table { width: 100%; border-collapse: collapse; page-break-inside: avoid; }
        .bottom-table td { vertical-align: top; }
        
        .payment-info { border-left: 3px solid #0284c7; padding-left: 12px; }
        .payment-title { font-size: 10px; font-weight: bold; color: #0f172a; margin: 0 0 6px 0; text-transform: uppercase; }
        .payment-text { font-size: 11px; color: #475569; margin: 0 0 4px 0; }
        .bank-name { font-weight: bold; color: #0f172a; }
        
        .sig-box { text-align: center; }
        .qr-code { margin: 5px auto; }
        .sig-name { font-size: 12px; font-weight: bold; color: #0f172a; margin: 2px 0 2px 0; }
        .sig-role { font-size: 10px; color: #64748b; margin: 0; }
        .sig-line { border-bottom: 1px solid #cbd5e1; width: 140px; margin: 5px auto; }

        /* ── FOOTER ── */
        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 20px;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            font-size: 9px;
            color: #94a3b8;
        }
        .footer-table { width: 100%; }
        .footer-left { text-align: left; }
        .footer-right { text-align: right; }
        .pagenum:before { content: counter(page); }

    </style>
</head>
<body>

    <footer>
        <table class="footer-table">
            <tr>
                <td class="footer-left">INVOICE DIGENERATE OLEH SISTEM &middot; PT FLUXA TRITAMA INDONESIA</td>
                <td class="footer-right">Halaman <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <main>
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <img src="{{ public_path('assets/images/FLUXATRITAMAINDONESIA.png') }}" alt="Fluxa" class="company-logo">
                    <p class="company-name">PT FLUXA TRITAMA INDONESIA</p>
                    <p class="company-contact">
                        Tapin, RT 011, RW 004, Suato Tatakan<br>
                        Tapin Selatan, Kalimantan Selatan 71181<br>
                        0812-5065-3005 &middot; official@fluxa.co.id
                    </p>
                </td>
                <td class="header-right">
                    <p class="doc-title">INVOICE</p>
                    <p class="doc-no">{{ $invoice->invoice_number }}</p>
                    
                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Tanggal:</td>
                            <td class="meta-val">{{ $invoice->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @if($invoice->due_date)
                        <tr>
                            <td class="meta-label">Jatuh Tempo:</td>
                            <td class="meta-val" style="{{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'color:#dc2626;' : '' }}">{{ $invoice->due_date->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        @if($invoice->quotation)
                        <tr>
                            <td class="meta-label">Ref Quotation:</td>
                            <td class="meta-val">{{ $invoice->quotation->quotation_number }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="info-table">
            <tr>
                <td style="width: 55%; padding-right: 10px;">
                    <div class="box">
                        <p class="box-title">DITAGIHKAN KEPADA</p>
                        <p class="client-name">{{ $invoice->client->name }}</p>
                        @if($invoice->client->address)<p class="client-detail">{{ $invoice->client->address }}</p>@endif
                        @if($invoice->client->city)<p class="client-detail">{{ $invoice->client->city }}</p>@endif
                        @if($invoice->client->email)<p class="client-detail" style="color: #0284c7;">{{ $invoice->client->email }}</p>@endif
                    </div>
                </td>
                <td style="width: 45%; padding-left: 10px;">
                    <div class="box">
                        <p class="box-title">STATUS PEMBAYARAN</p>
                        @php
                            $statusClass = 'status-unpaid';
                            $statusText = 'MENUNGGU PEMBAYARAN';
                            if ($invoice->status === 'paid') {
                                $statusClass = 'status-paid';
                                $statusText = 'LUNAS';
                            } elseif ($invoice->status === 'partial') {
                                $statusClass = 'status-partial';
                                $statusText = 'DIBAYAR SEBAGIAN';
                            }
                        @endphp
                        <div class="status-badge {{ $statusClass }}">
                            {{ $statusText }}
                        </div>
                        
                        @if($invoice->paid_amount > 0)
                        <div style="font-size: 10px; color: #475569; margin-top: 8px; border-top: 1px dashed #cbd5e1; padding-top: 6px;">
                            Telah dibayar: <strong>Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</strong><br>
                            Sisa tagihan: <strong>Rp{{ number_format($invoice->remaining_balance, 0, ',', '.') }}</strong>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="th-no">No</th>
                    <th>Deskripsi Layanan / Produk</th>
                    <th class="th-qty">Qty</th>
                    <th class="th-price">Harga Satuan</th>
                    <th class="th-total">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $i => $item)
                <tr>
                    <td class="td-no">{{ sprintf('%02d', $i + 1) }}</td>
                    <td class="td-desc">{{ $item->description }}</td>
                    <td class="td-qty">{{ $item->quantity }}</td>
                    <td class="td-price">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="td-total">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td class="totals-label">Subtotal</td>
                <td class="totals-val">Rp{{ number_format($invoice->total, 0, ',', '.') }}</td>
            </tr>
            @if($invoice->paid_amount > 0)
            <tr>
                <td class="totals-label">Telah Dibayar</td>
                <td class="totals-val" style="color:#059669;">- Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td class="grand-total-label">{{ $invoice->paid_amount > 0 ? 'SISA TAGIHAN' : 'TOTAL TAGIHAN' }}</td>
                <td class="grand-total-val">Rp{{ number_format($invoice->remaining_balance, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- T&C INFO -->
        @if($invoice->terms_and_conditions)
        <div style="border-left: 3px solid #0284c7; padding-left: 12px; margin-bottom: 20px;">
            <p style="font-size: 10px; font-weight: bold; color: #0f172a; margin: 0 0 6px 0; text-transform: uppercase;">Syarat &amp; Ketentuan</p>
            <div style="font-size: 10px; color: #475569; margin: 0; line-height: 1.5;">
                {!! nl2br(e($invoice->terms_and_conditions)) !!}
            </div>
        </div>
        @elseif($invoice->quotation && $invoice->quotation->terms_and_conditions)
        <div style="border-left: 3px solid #0284c7; padding-left: 12px; margin-bottom: 20px;">
            <p style="font-size: 10px; font-weight: bold; color: #0f172a; margin: 0 0 6px 0; text-transform: uppercase;">Syarat &amp; Ketentuan</p>
            <div style="font-size: 10px; color: #475569; margin: 0; line-height: 1.5;">
                {!! nl2br(e($invoice->quotation->terms_and_conditions)) !!}
            </div>
        </div>
        @endif

        <!-- PAYMENT INFO -->
        <div style="border-left: 3px solid #0284c7; padding-left: 12px; margin-bottom: 30px;">
            <p style="font-size: 10px; font-weight: bold; color: #0f172a; margin: 0 0 6px 0; text-transform: uppercase;">Informasi Pembayaran</p>
            <p style="font-size: 11px; color: #475569; margin: 0 0 4px 0;">Silakan lakukan pembayaran melalui transfer bank ke:</p>
            <p style="font-size: 11px; color: #475569; margin: 0 0 4px 0; margin-top: 8px;">Bank: <span style="font-weight: bold; color: #0f172a;">Bank Mandiri</span></p>
            <p style="font-size: 11px; color: #475569; margin: 0 0 4px 0;">No. Rekening: <span style="font-weight: bold; color: #0f172a; font-size: 13px;">031-00-2387227-1</span></p>
            <p style="font-size: 11px; color: #475569; margin: 0 0 4px 0;">Atas Nama: <span style="font-weight: bold; color: #0f172a;">PT FLUXA TRITAMA INDONESIA</span></p>
            @if($invoice->notes)
            <p style="font-size:10px; color:#64748b; font-style: italic; margin-top: 10px;">Catatan: {{ $invoice->notes }}</p>
            @endif
        </div>

        <!-- SIGNATURES -->
        <table class="bottom-table" style="margin-top: 20px;">
            <tr>
                <td style="width: 50%; vertical-align: bottom; padding-bottom: 8px;">
                    <p style="font-size:10px; color:#64748b; font-weight: bold; margin:0 0 2px 0;">Dibuat Oleh,</p>
                    <p class="sig-name">{{ $invoice->creator->name }}</p>
                </td>
                <td style="width: 50%;" class="sig-box">
                    <p style="font-size:10px; color:#64748b; font-weight: bold; margin:0 0 5px 0;">Disetujui Oleh,</p>
                    <div class="qr-code">
                        <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(75)->margin(0)->generate(route('verify.invoice', $invoice->qr_token))) !!}" alt="QR Code">
                    </div>
                    <div class="sig-line"></div>
                    <p class="sig-name">{{ $invoice->approver->name ?? 'Eddy Adha Saputra' }}</p>
                    <p class="sig-role">Director</p>
                </td>
            </tr>
        </table>
    </main>

</body>
</html>
