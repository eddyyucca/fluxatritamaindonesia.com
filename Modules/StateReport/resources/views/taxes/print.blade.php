<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Pelaporan SPT {{ $report->year }}</title>
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
        
        .doc-title { font-size: 20px; font-weight: bold; color: #0f172a; letter-spacing: 1px; margin: 0 0 2px 0; }
        .doc-no { font-size: 12px; font-weight: bold; color: #334155; margin: 0 0 8px 0; }
        
        .meta-table { border-collapse: collapse; width: 220px; margin-left: auto; }
        .meta-table td { font-size: 10px; padding: 2px 0; }
        .meta-label { color: #64748b; font-weight: bold; text-align: right; padding-right: 8px; }
        .meta-val { color: #0f172a; font-weight: bold; text-align: right; }

        .divider { border-bottom: 2px solid #e2e8f0; margin-bottom: 20px; }

        /* ── DETAILS ── */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e2e8f0; }
        .items-table thead tr { background-color: #f8fafc; border-bottom: 2px solid #cbd5e1; }
        .items-table th {
            font-size: 10px; font-weight: bold; color: #334155; text-transform: uppercase;
            padding: 8px 10px; text-align: left; width: 40%;
        }
        .items-table td {
            padding: 8px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; vertical-align: top; width: 60%; font-weight: bold;
        }

        .notes-box { border-left: 3px solid #0284c7; padding-left: 12px; margin-bottom: 30px; margin-top: 20px; }
        .notes-title { font-size: 10px; font-weight: bold; color: #0f172a; margin: 0 0 6px 0; text-transform: uppercase; }
        .notes-text { font-size: 11px; color: #475569; margin: 0; line-height: 1.5; white-space: pre-line; }

        /* ── SIGNATURE ── */
        .bottom-table { width: 100%; border-collapse: collapse; page-break-inside: avoid; }
        .bottom-table td { vertical-align: top; }
        
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
                <td class="footer-left">DOKUMEN RESMI SISTEM &middot; PT FLUXA TRITAMA INDONESIA</td>
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
                    <p class="doc-title">PELAPORAN SPT</p>
                    <p class="doc-no">#TAX-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</p>
                    
                    <table class="meta-table">
                        <tr>
                            <td class="meta-label">Tanggal Cetak:</td>
                            <td class="meta-val">{{ now()->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Jenis Pajak:</td>
                            <td class="meta-val">{{ $report->tax_type }}</td>
                        </tr>
                        <tr>
                            <td class="meta-label">Masa / Tahun:</td>
                            <td class="meta-val">{{ $report->period }} / {{ $report->year }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Detail Laporan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Status Pelaporan</td>
                    <td>
                        @if($report->status == 'submitted') <span style="color:#059669;">SUBMITTED</span>
                        @elseif($report->status == 'draft') <span style="color:#64748b;">DRAFT</span>
                        @else <span style="color:#d97706;">PENDING</span> @endif
                    </td>
                </tr>
                <tr>
                    <td>Tahun Pajak</td>
                    <td>{{ $report->year }}</td>
                </tr>
                <tr>
                    <td>Tanggal Data Dimasukkan</td>
                    <td>{{ \Carbon\Carbon::parse($report->created_at)->isoFormat('D MMMM Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="notes-box">
            <p class="notes-title">NOMOR TANDA TERIMA / BUKTI SPT</p>
            <div class="notes-text">
                @if($report->notes)
                    {!! nl2br(e($report->notes)) !!}
                @else
                    <i>Belum ada NTPN atau ringkasan pajak yang dimasukkan.</i>
                @endif
            </div>
        </div>

        <!-- SIGNATURES -->
        <table class="bottom-table" style="margin-top: 40px;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;" class="sig-box">
                    <p style="font-size:10px; color:#64748b; font-weight: bold; margin:0 0 5px 0;">Mengetahui &amp; Mengesahkan,</p>
                    <div class="qr-code">
                        <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(75)->margin(0)->generate('Dokumen Resmi PT Fluxa - Laporan SPT ' . $report->tax_type . ' ' . $report->year)) !!}" alt="QR Code">
                    </div>
                    <div class="sig-line"></div>
                    <p class="sig-name">Divisi Perpajakan</p>
                    <p class="sig-role">PT Fluxa Tritama Indonesia</p>
                </td>
            </tr>
        </table>
    </main>

</body>
</html>
