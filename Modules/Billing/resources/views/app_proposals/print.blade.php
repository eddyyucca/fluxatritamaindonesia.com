<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Proposal - {{ $app_proposal->proposal_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* Print Margin Setup */
        @page { size: A4; margin: 15mm 20mm 20mm 20mm; }
        @page:first { margin: 0; } /* No margin on cover page */

        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background: #ffffff;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Screen Preview Styling */
        @media screen {
            body { background: #f1f5f9; padding: 20px; }
            .print-container { max-width: 210mm; margin: 0 auto; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
            .cover-page { min-height: 297mm; }
            .content-page { padding: 15mm 20mm 20mm 20mm; }
        }

        /* Running Footer */
        .page-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 25px;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            font-size: 10px;
            color: #64748b;
            z-index: 10;
        }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-left { text-align: left; }
        .footer-right { text-align: right; }
        .pagenum:before { content: counter(page); }

        /* Hide print button on print */
        @media print {
            .no-print { display: none !important; }
            body { background: none; padding: 0; }
            .print-container { box-shadow: none; max-width: none; }
        }

        /* Cover Page Styling */
        .cover-page {
            display: flex;
            flex-direction: column;
            text-align: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: #ffffff;
            padding: 50px !important;
            box-sizing: border-box;
            height: 297mm; /* Exactly 1 A4 page */
            page-break-after: always;
            position: relative;
            z-index: 50; /* Covers the running footer on page 1 */
        }
        .cover-page::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect x="0" y="0" width="100%" height="100%" fill="url(%23dots)"/></svg>');
            pointer-events: none;
        }
        .cover-main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .cover-logo { height: 120px; margin-bottom: 50px; }
        .cover-type { font-size: 16px; font-weight: 700; letter-spacing: 4px; color: #93c5fd; text-transform: uppercase; margin-bottom: 15px; }
        .cover-title { font-size: 38px; font-weight: 900; line-height: 1.2; margin: 0 0 15px 0; color: #ffffff !important; }
        .cover-subtitle { font-size: 18px; color: #f8fafc; font-weight: 400; margin: 0 0 60px 0; }
        
        .cover-client-box { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px); padding: 30px 50px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.2); max-width: 80%; }
        .cover-client-label { font-size: 12px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .cover-client-name { font-size: 26px; font-weight: 800; margin: 0; color: #ffffff; }
        .cover-client-city { font-size: 16px; margin-top: 5px; color: #f1f5f9; }
        
        .cover-footer { margin-top: auto; text-align: center; color: #f1f5f9; font-size: 14px; position: relative; z-index: 1; padding-top: 40px; }

        /* Standard Content Styling */
        .content-wrapper { position: relative; z-index: 20; background: white; }
        
        h1, h2, h3, h4 { color: #0f172a; margin-top: 0; }
        h2 { font-size: 20px; font-weight: 800; text-transform: uppercase; border-bottom: 2px solid #2563eb; padding-bottom: 5px; margin-bottom: 20px; display: inline-block; }
        p { margin-bottom: 15px; text-align: justify; }
        
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 30px; }
        .header img { height: 60px; }
        .header .meta { text-align: right; font-size: 11px; color: #64748b; }
        .header .meta strong { color: #0f172a; font-size: 13px; display: block; margin-bottom: 3px; }

        .section { margin-bottom: 35px; }
        .rich-text { line-height: 1.7; }
        .rich-text ul, .rich-text ol { margin-top: 0; padding-left: 20px; margin-bottom: 15px; }
        .rich-text li { margin-bottom: 5px; }

        /* Investment Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; border: 1px solid #e2e8f0; }
        .items-table thead { display: table-header-group; }
        .items-table tr { page-break-inside: avoid; }
        .items-table th { background-color: #f8fafc; font-size: 12px; font-weight: 700; color: #0f172a; padding: 12px; text-align: left; border-bottom: 2px solid #cbd5e1; }
        .items-table td { padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 13px; vertical-align: top; }
        .items-table tfoot td { font-weight: 800; font-size: 15px; background: #f8fafc; border-top: 2px solid #cbd5e1; page-break-inside: avoid; }
        
        .th-no { width: 5%; text-align: center !important; }
        .th-price { width: 25%; text-align: right !important; }
        .td-no { text-align: center; color: #64748b; }
        .td-price { text-align: right; font-weight: 600; }
        
        /* Signatures */
        .sig-container { display: flex; justify-content: space-between; margin-top: 50px; page-break-inside: avoid; }
        .sig-box { width: 45%; text-align: center; }
        .sig-box p { margin: 0; text-align: center; }
        .sig-title { font-size: 12px; color: #64748b; font-weight: 700; margin-bottom: 10px !important; }
        .sig-name { font-weight: 800; font-size: 14px; text-decoration: underline; margin-bottom: 5px !important; }
        .qr-code { margin: 5px auto; }
        .qr-code img { width: 85px; height: 85px; }
    </style>
</head>
<body>

    <div class="no-print" style="text-align:center; padding:20px; background:#fff; border-bottom:1px solid #e2e8f0; margin-bottom: 20px;">
        <button onclick="window.print()" style="background:#2563eb; color:white; border:none; padding:10px 20px; border-radius:8px; font-weight:bold; cursor:pointer; font-family:'Inter', sans-serif;">Cetak / Print (Ctrl+P)</button>
        <p style="font-size:12px; color:#64748b; margin-top:10px;">Gunakan browser cetak dan aktifkan "Background graphics". Jarak halaman dan header/footer otomatis diatur oleh browser.</p>
    </div>

    <div class="page-footer">
        <table class="footer-table">
            <tr>
                <td class="footer-left">Proposal Penawaran Aplikasi - PT FLUXA TRITAMA INDONESIA</td>
                <td class="footer-right">Halaman <span class="pagenum"></span></td>
            </tr>
        </table>
    </div>

    <div class="print-container">
        <!-- COVER PAGE -->
        <div class="cover-page">
            <div class="cover-main-content">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="cover-logo">
                <div class="cover-type">Proposal Penawaran Aplikasi</div>
                <h1 class="cover-title">{{ $app_proposal->cover_title }}</h1>
                @if($app_proposal->cover_subtitle)
                    <div class="cover-subtitle">{{ $app_proposal->cover_subtitle }}</div>
                @endif
                
                <div class="cover-client-box">
                    <div class="cover-client-label">Disiapkan Untuk:</div>
                    <div class="cover-client-name">{{ $app_proposal->client->name }}</div>
                    @if($app_proposal->client->city)
                        <div class="cover-client-city">{{ $app_proposal->client->city }}</div>
                    @endif
                </div>
            </div>
            
            <div class="cover-footer">
                <p style="margin-bottom:0;"><strong>PT FLUXA TRITAMA INDONESIA</strong></p>
                <p style="margin-bottom:0;">Tanggal Dokumen: {{ $app_proposal->created_at->format('d F Y') }}</p>
                <p style="margin-bottom:0;">No. Ref: {{ $app_proposal->proposal_number }}</p>
            </div>
        </div>

        <!-- CONTENT Flow -->
        <div class="content-wrapper content-page">
            <div class="header">
                <img src="{{ asset('assets/images/FLUXATRITAMAINDONESIA.png') }}" alt="Fluxa">
                <div class="meta">
                    <strong>Proposal Aplikasi</strong>
                    No. {{ $app_proposal->proposal_number }}<br>
                    Tanggal: {{ $app_proposal->created_at->format('d/m/Y') }}
                </div>
            </div>

            @if($app_proposal->introduction)
            <div class="section">
                <h2>Pendahuluan</h2>
                <div class="rich-text">{!! $app_proposal->introduction !!}</div>
            </div>
            @endif

            @if($app_proposal->scope_of_work)
            <div class="section">
                <h2>Ruang Lingkup Pekerjaan</h2>
                <div class="rich-text">{!! $app_proposal->scope_of_work !!}</div>
            </div>
            @endif

            @if($app_proposal->technology_stack)
            <div class="section">
                <h2>Teknologi</h2>
                <div class="rich-text">{!! $app_proposal->technology_stack !!}</div>
            </div>
            @endif

            @if($app_proposal->timeline_notes)
            <div class="section">
                <h2>Estimasi Waktu Pelaksanaan</h2>
                <div class="rich-text">{!! $app_proposal->timeline_notes !!}</div>
            </div>
            @endif

            <div class="section">
                <h2>Rincian Investasi</h2>
                <p>Berdasarkan ruang lingkup pekerjaan di atas, berikut adalah estimasi nilai investasi untuk pengembangan sistem:</p>
                
                <table class="items-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Modul / Item Pekerjaan</th>
                            <th class="th-price">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($app_proposal->items as $i => $item)
                        <tr>
                            <td class="td-no">{{ sprintf('%02d', $i + 1) }}</td>
                            <td>
                                <strong style="color:#0f172a;">{{ $item->item_name }}</strong>
                                @if($item->description)
                                    <div style="color:#64748b; font-size:12px; margin-top:4px;">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td class="td-price">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="text-align:right; color:#475569;">TOTAL NILAI INVESTASI</td>
                            <td class="td-price" style="color:#0f172a;">Rp {{ number_format($app_proposal->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($app_proposal->terms_and_conditions)
            <div class="section" style="page-break-inside: avoid;">
                <h2>Syarat & Ketentuan</h2>
                <div style="font-size:12px; color:#475569; padding: 15px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    @foreach(explode("\n\n", $app_proposal->terms_and_conditions) as $para)
                        <div style="margin-bottom:8px;">
                            {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<strong style="color:#0f172a;">$1</strong>', e(trim($para)))) !!}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="sig-container">
                <div class="sig-box" style="display: flex; flex-direction: column; justify-content: flex-end;">
                    <p class="sig-title">Diajukan Oleh,</p>
                    <!-- Removed 85px empty space for physical signature. Just the name directly. -->
                    <p class="sig-name" style="margin-top: 10px;">{{ $app_proposal->creator->name }}</p>
                    <p style="font-size:11px; color:#64748b;">PT Fluxa Tritama Indonesia</p>
                </div>
                <div class="sig-box">
                    <p class="sig-title">Disetujui Oleh,</p>
                    <div class="qr-code">
                        <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(85)->margin(0)->generate(route('verify.app_proposal', $app_proposal->qr_token))) !!}" alt="QR Code">
                    </div>
                    <p class="sig-name">{{ $app_proposal->approver->name ?? 'Eddy Adha Saputra' }}</p>
                    <p style="font-size:11px; color:#64748b;">Director</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
