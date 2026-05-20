<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Quotation {{ $quotation->quotation_number }}</title>
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
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .header-table td { vertical-align: middle; }
        .header-left { width: 55%; }
        .header-right { width: 45%; text-align: right; }
        
        .company-logo { height: 60px; margin-bottom: 8px; }
        .company-name { font-size: 16px; font-weight: bold; color: #0f172a; margin: 0 0 2px 0; }
        .company-contact { font-size: 11px; color: #64748b; margin: 0; }
        
        .doc-title { font-size: 32px; font-weight: bold; color: #0f172a; letter-spacing: 2px; margin: 0 0 4px 0; }
        .doc-no { font-size: 16px; font-weight: bold; color: #0f172a; margin: 0 0 12px 0; }
        
        .meta-table { width: 100%; border-collapse: collapse; float: right; width: 220px; }
        .meta-table td { font-size: 12px; padding: 2px 0; }
        .meta-label { color: #64748b; font-weight: bold; text-align: right; padding-right: 8px; }
        .meta-val { color: #0f172a; font-weight: bold; text-align: right; }

        .divider { border-bottom: 2px solid #e2e8f0; margin-bottom: 25px; }

        /* ── CLIENT & STATUS ── */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .info-table td { vertical-align: top; }
        
        .box { border-radius: 6px; padding: 15px; border: 1px solid; height: 100px; }
        .box-client { background-color: #f8fafc; border-color: #e2e8f0; }
        .box-notice { background-color: #fffbeb; border-color: #fde68a; }
        
        .box-title { font-size: 10px; font-weight: bold; text-transform: uppercase; margin: 0 0 8px 0; }
        .title-client { color: #64748b; }
        .title-notice { color: #92400e; }
        
        .client-name { font-size: 14px; font-weight: bold; color: #0f172a; margin: 0 0 4px 0; }
        .client-detail { font-size: 12px; color: #475569; margin: 0 0 2px 0; }

        .notice-text { color: #92400e; font-size: 11px; line-height: 1.5; margin: 0; }

        /* ── ITEMS TABLE ── */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; border: 1px solid #e2e8f0; }
        .items-table thead tr { background-color: #f8fafc; border-bottom: 2px solid #cbd5e1; }
        .items-table th {
            font-size: 11px; font-weight: bold; color: #0f172a; text-transform: uppercase;
            padding: 10px 12px; text-align: left;
        }
        .items-table td {
            padding: 10px 12px; border-bottom: 1px solid #e2e8f0; font-size: 12px; vertical-align: top;
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
        .totals-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .totals-table td { padding: 8px 12px; font-size: 12px; }
        .totals-label { text-align: right; color: #475569; font-weight: bold; width: 70%; }
        .totals-val { text-align: right; color: #0f172a; font-weight: bold; width: 30%; }
        
        .grand-total-label { text-align: right; font-size: 14px; font-weight: bold; color: #0f172a; border-top: 2px solid #cbd5e1; padding-top: 10px; }
        .grand-total-val { text-align: right; font-size: 16px; font-weight: bold; color: #0f172a; border-top: 2px solid #cbd5e1; padding-top: 10px; }

        /* ── PAYMENT & SIGNATURE ── */
        .bottom-table { width: 100%; border-collapse: collapse; page-break-inside: avoid; }
        .bottom-table td { vertical-align: top; }
        
        .tnc-box { border-left: 3px solid #0284c7; padding-left: 12px; margin-bottom: 20px; }
        .tnc-title { font-size: 11px; font-weight: bold; color: #0f172a; margin: 0 0 8px 0; text-transform: uppercase; }
        .tnc-text { font-size: 11px; color: #475569; margin: 0; line-height: 1.5; }
        
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
                <td class="footer-left">QUOTATION RESMI PT FLUXA TRITAMA INDONESIA</td>
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
                    <p class="doc-title">QUOTATION</p>
                    <p class="doc-no">{{ $quotation->quotation_number }}</p>
                    
                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Tanggal:</td>
                            <td class="meta-val">{{ $quotation->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @if($quotation->valid_until)
                        <tr>
                            <td class="meta-label">Berlaku s/d:</td>
                            <td class="meta-val">{{ $quotation->valid_until->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="info-table">
            <tr>
                <td style="width: 50%; padding-right: 10px;">
                    <div class="box box-client">
                        <p class="box-title title-client">DITAWARKAN KEPADA</p>
                        <p class="client-name">{{ $quotation->client->name }}</p>
                        @if($quotation->client->address)<p class="client-detail">{{ $quotation->client->address }}</p>@endif
                        @if($quotation->client->city)<p class="client-detail">{{ $quotation->client->city }}</p>@endif
                        @if($quotation->client->email)<p class="client-detail">{{ $quotation->client->email }}</p>@endif
                    </div>
                </td>
                <td style="width: 50%; padding-left: 10px;">
                    <div class="box box-notice">
                        <p class="box-title title-notice">PERHATIAN</p>
                        <p class="notice-text">
                            <strong>Surat Penawaran Harga</strong><br>
                            Dokumen ini merupakan bentuk penawaran harga resmi dan tidak mengikat sebagai surat tagihan. Kewajiban pembayaran baru berlaku setelah penawaran ini disetujui dan Invoice diterbitkan.
                        </p>
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
                @foreach($quotation->items as $i => $item)
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
                <td class="totals-label"></td>
                <td class="totals-val"></td>
            </tr>
            <tr>
                <td class="grand-total-label">TOTAL PENAWARAN</td>
                <td class="grand-total-val">Rp{{ number_format($quotation->total, 0, ',', '.') }}</td>
            </tr>
        </table>

        <table class="bottom-table">
            <tr>
                <td style="width: 60%; padding-right: 20px;">
                    <!-- T&C INFO -->
                    @if($quotation->terms_and_conditions)
                    <div class="tnc-box">
                        <p class="tnc-title">Syarat &amp; Ketentuan</p>
                        <div class="tnc-text">
                            {!! nl2br(e($quotation->terms_and_conditions)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- CREATOR NAME DIRECTLY BELOW T&C -->
                    <div style="margin-top: 25px;">
                        <p style="font-size:11px; color:#64748b; font-weight: bold; margin:0 0 4px 0;">Dibuat Oleh,</p>
                        <p style="font-size:13px; font-weight: bold; color: #0f172a; margin: 0;">{{ $quotation->creator->name }}</p>
                    </div>
                </td>
                <td style="width: 40%;" class="sig-box">
                    <p style="font-size:11px; color:#64748b; font-weight: bold; margin:0 0 8px 0;">Disetujui Oleh,</p>
                    <div class="qr-code">
                        <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(85)->margin(0)->generate(route('verify.quotation', $quotation->qr_token))) !!}" alt="QR Code">
                    </div>
                    <div class="sig-line" style="margin-top: 15px;"></div>
                    <p class="sig-name">{{ $quotation->approver->name ?? 'Eddy Adha Saputra' }}</p>
                    <p class="sig-role">Director</p>
                </td>
            </tr>
        </table>
    </main>

</body>
</html>
