<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #1a1a2e;
            background: #e8e8e8;
        }

        .btn-print-action {
            position: fixed; top: 20px; right: 20px;
            background: #1d4ed8; color: #fff; border: none;
            padding: 10px 22px; border-radius: 8px;
            font-size: 13px; font-weight: 700; cursor: pointer;
            z-index: 999; box-shadow: 0 4px 12px rgba(29,78,216,0.4);
            display: flex; align-items: center; gap: 8px;
        }
        .btn-back {
            position: fixed; top: 20px; right: 170px;
            background: #374151; color: #fff; border: none;
            padding: 10px 18px; border-radius: 8px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            z-index: 999; text-decoration: none;
            display: flex; align-items: center; gap: 6px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            margin: 30px auto;
            padding: 12mm 14mm 0 14mm;
            position: relative;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            overflow: hidden;
        }

        /* Subtle decorative arc on right side */
        .page-deco {
            position: absolute;
            top: -20mm;
            right: -18mm;
            width: 70mm;
            height: 80mm;
            border-radius: 50%;
            border: 18mm solid rgba(0,188,212,0.06);
            pointer-events: none;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        /* LEFT: logo + company info */
        .company-block { flex: 0 0 44%; }
        .company-logo { height: 42px; display: block; margin-bottom: 7px; }
        .company-name { font-size: 9.5pt; font-weight: 800; color: #1a1a2e; letter-spacing: 0.02em; }
        .company-address { font-size: 7pt; color: #666; line-height: 1.65; margin-top: 3px; }

        /* RIGHT: quotation title + client info */
        .doc-right-block { flex: 0 0 54%; text-align: right; }
        .doc-label {
            font-size: 30pt; font-weight: 900; color: #1a1a2e;
            letter-spacing: -1.5px; line-height: 1; text-transform: uppercase;
        }
        .doc-number { font-size: 11pt; font-weight: 700; color: #1a1a2e; margin-top: 2px; }
        .doc-meta { font-size: 7.5pt; color: #666; margin-top: 5px; line-height: 1.75; }
        .billed-label {
            font-size: 7pt; font-weight: 800; color: #999; text-transform: uppercase;
            letter-spacing: 0.1em; margin-top: 10px; margin-bottom: 1px;
        }
        .billed-name { font-size: 15pt; font-weight: 900; color: #1a1a2e; letter-spacing: -0.4px; line-height: 1.1; }
        .billed-address { font-size: 7pt; color: #666; margin-top: 2px; line-height: 1.6; }

        /* Divider */
        .header-divider { border: none; border-top: 1.5px solid #1a1a2e; margin-bottom: 0; }

        /* ── QUOTATION NOTICE ── */
        .quotation-notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 6px 10px;
            margin: 8px 0;
            font-size: 7.5pt;
            color: #78350f;
        }
        .quotation-notice strong { color: #92400e; }

        /* ── ITEMS TABLE ── */
        .items-table { width: 100%; border-collapse: collapse; margin-top: 0; }
        .items-table thead tr { background-color: #1a1a2e; }
        .items-table thead th {
            color: #fff; font-size: 8.5pt; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            padding: 8px 10px; border: 1px solid #1a1a2e;
        }
        .items-table thead th.col-no    { text-align: center; width: 38px; }
        .items-table thead th.col-detail { text-align: left; }
        .items-table thead th.col-qty   { text-align: center; width: 50px; }
        .items-table thead th.col-price { text-align: right; width: 110px; }
        .items-table thead th.col-total { text-align: right; width: 110px; }

        .items-table tbody td {
            padding: 6px 10px; font-size: 9pt; color: #333;
            vertical-align: top; border: 1px solid #d1d5db;
        }
        .items-table tbody td.col-no    { text-align: center; color: #888; font-size: 8.5pt; }
        .items-table tbody td.col-qty   { text-align: center; }
        .items-table tbody td.col-price { text-align: right; white-space: nowrap; }
        .items-table tbody td.col-total { text-align: right; font-weight: 600; white-space: nowrap; }

        /* Total row */
        .total-row-table { width: 100%; border-collapse: collapse; margin-top: 0; }
        .total-row-table td { padding: 5px 10px; font-size: 9pt; border: 1px solid #d1d5db; }
        .total-row-table .total-label { text-align: right; font-weight: 700; background: #1a1a2e; color: #fff; }
        .total-row-table .total-val   { text-align: right; font-size: 11pt; font-weight: 900; background: #f8f8f8; white-space: nowrap; }

        /* ── T&C ── */
        .tnc-section { border-top: 2px solid #1a1a2e; padding-top: 7px; margin-top: 8px; }
        .tnc-heading { font-size: 8.5pt; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
        .tnc-item { margin-bottom: 6px; }
        .tnc-item-title { font-size: 7.5pt; font-weight: 800; margin-bottom: 1px; }
        .tnc-item-body { font-size: 7pt; color: #444; line-height: 1.6; text-align: justify; }

        /* ── SIGNATURE + QR area ── */
        .sig-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 14px;
            margin-bottom: 8px;
            gap: 20px;
        }
        /* Left: creator info */
        .sig-left {
            flex: 1;
        }
        .sig-name { font-size: 8pt; font-weight: 700; color: #333; }
        .sig-role { font-size: 7pt; color: #888; margin-top: 1px; }
        .sig-line {
            border-bottom: 1px solid #bbb;
            margin: 24px 0 4px 0;
            width: 120px;
        }
        .approval-stamp {
            display: inline-block; border: 2px solid #059669;
            border-radius: 4px; padding: 3px 7px; text-align: center; margin-top: 5px;
        }
        .stamp-title { font-size: 7pt; font-weight: 800; color: #059669; text-transform: uppercase; letter-spacing: 0.08em; }
        .stamp-name  { font-size: 6pt; color: #047857; margin-top: 1px; }

        /* Right: QR (acts as signature) */
        .sig-right {
            flex-shrink: 0;
            text-align: center;
            min-width: 90px;
        }
        .sig-right .sig-line-right {
            border-bottom: 1px solid #bbb;
            margin: 0 0 4px 0;
        }
        .qr-caption { font-size: 6pt; color: #888; margin-top: 3px; }
        .qr-label   { font-size: 6.5pt; color: #666; font-weight: 600; margin-bottom: 4px; }

        /* ── FOOTER ── */
        .footer-contacts {
            display: flex; justify-content: center; align-items: center;
            gap: 24px; padding: 7px 0; border-top: 1px solid #e5e7eb;
        }
        .footer-contact-item { display: flex; align-items: center; gap: 6px; font-size: 7.5pt; color: #333; font-weight: 600; }
        .footer-icon {
            width: 20px; height: 20px; border-radius: 50%; background: #1a1a2e;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .footer-icon svg { width: 11px; height: 11px; fill: #fff; }

        /* Two-tone bar */
        .footer-bar { height: 32px; display: flex; margin: 0 -14mm; overflow: hidden; }
        .footer-bar-teal { flex: 0 0 35%; background: linear-gradient(90deg, #00bcd4 0%, #00909e 100%); }
        .footer-bar-dark { flex: 1; background: #1e2235; position: relative; overflow: hidden; }
        .footer-bar-dark svg { position: absolute; inset: 0; width: 100%; height: 100%; }

        /* Page counter */
        .page-number {
            text-align: center;
            font-size: 7pt;
            color: #aaa;
            padding: 4px 0;
        }

        @media print {
            body { background: #fff; }
            .page { margin: 0; box-shadow: none; width: 100%; padding: 12mm 14mm 0; }
            .btn-print-action, .btn-back { display: none !important; }
            .footer-bar { margin: 0 -14mm; }
            .page-number { display: none; }
        }

        /* Print page counter via CSS counters */
        @page { size: A4; margin: 0; }

        /* Sambungan halaman label */
        .page-break-label {
            text-align: center;
            font-size: 7pt;
            color: #aaa;
            padding: 3px 0;
            border-top: 1px dashed #ddd;
            margin-top: 6px;
        }
    </style>
</head>
<body>

    <a href="{{ route('billing.quotations.show', $quotation) }}" class="btn-back">← Kembali</a>
    <button class="btn-print-action" onclick="window.print()">🖨 Cetak / Simpan PDF</button>

    <div class="page" id="page">

        {{-- Decorative arc --}}
        <div class="page-deco"></div>

        {{-- ── HEADER ── --}}
        <div class="header">

            {{-- LEFT: company --}}
            <div class="company-block">
                <img src="{{ asset('assets/images/FLUXATRITAMAINDONESIA.png') }}"
                     alt="PT Fluxa Tritama Indonesia" class="company-logo">
                <div class="company-name">PT FLUXA TRITAMA INDONESIA</div>
                <div class="company-address">
                    Tapin, RT 011, RW 004, Suato Tatakan,<br>
                    Tapin Selatan, Kabupaten Tapin,<br>
                    Kalimantan Selatan 71181
                </div>
            </div>

            {{-- RIGHT: quotation title + client info --}}
            <div class="doc-right-block">
                <div class="doc-label">QUOTATION</div>
                <div class="doc-number">#{{ $quotation->quotation_number }}</div>
                <div class="doc-meta">
                    Tanggal : {{ $quotation->created_at->format('d/m/Y') }}<br>
                    @if($quotation->valid_until)
                    Berlaku s/d : {{ $quotation->valid_until->format('d/m/Y') }}<br>
                    @endif
                </div>
                <div class="billed-label">QUOTATION FOR</div>
                <div class="billed-name">{{ strtoupper($quotation->client->name) }}</div>
                @if($quotation->client->address || $quotation->client->city)
                <div class="billed-address">
                    @if($quotation->client->address){{ $quotation->client->address }}<br>@endif
                    @if($quotation->client->city){{ $quotation->client->city }}@endif
                </div>
                @endif
            </div>
        </div>

        <hr class="header-divider">

        {{-- ── QUOTATION NOTICE ── --}}
        <div class="quotation-notice">
            <strong>Surat Penawaran Harga</strong> — Dokumen ini adalah penawaran dan bukan tagihan atau permintaan pembayaran.
            Pembayaran dilakukan setelah penawaran disetujui dan invoice resmi diterbitkan.
        </div>

        {{-- ── ITEMS TABLE ── --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th class="col-no">NO</th>
                    <th class="col-detail">DESKRIPSI</th>
                    <th class="col-qty">QTY</th>
                    <th class="col-price">HARGA SATUAN</th>
                    <th class="col-total">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $i => $item)
                <tr>
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="col-qty">{{ $item->quantity }}</td>
                    <td class="col-price">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="col-total">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ── TOTAL ── --}}
        <table class="total-row-table">
            <tr>
                <td style="border:1px solid #d1d5db;width:60%;"></td>
                <td class="total-label" style="width:20%;">TOTAL</td>
                <td class="total-val" style="width:20%;">Rp{{ number_format($quotation->total, 0, ',', '.') }}</td>
            </tr>
        </table>

        {{-- ── TERM & CONDITION ── --}}
        @if($quotation->terms_and_conditions)
        <div class="tnc-section">
            <div class="tnc-heading">TERM & CONDITION — GARANSI & SUPPORT</div>
            @php
                $sections = [];
                $raw = array_filter(explode("\n\n", $quotation->terms_and_conditions));
                foreach ($raw as $block) {
                    $block = trim($block);
                    if (preg_match('/^\*\*(.*?)\*\*\n?(.*)$/s', $block, $m)) {
                        $sections[] = ['title' => trim($m[1]), 'body' => trim($m[2])];
                    } elseif ($block) {
                        $sections[] = ['title' => '', 'body' => $block];
                    }
                }
            @endphp
            @foreach($sections as $s)
            <div class="tnc-item">
                @if($s['title'])<div class="tnc-item-title">{{ $s['title'] }}</div>@endif
                <div class="tnc-item-body">{{ $s['body'] }}</div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ── SIGNATURE + QR (seperti area tanda tangan) ── --}}
        <div class="sig-area">
            {{-- Left: pembuat --}}
            <div class="sig-left">
                <div class="sig-name">{{ $quotation->creator->name }}</div>
                <div class="sig-role">{{ $quotation->creator->position ?? 'PT Fluxa Tritama Indonesia' }}</div>
                <div class="sig-line"></div>
                <div style="font-size:7pt;color:#888;">Dibuat oleh</div>
                @if($quotation->status === 'approved')
                <div class="approval-stamp" style="margin-top:8px;">
                    <div class="stamp-title">✓ Disetujui Director</div>
                    <div class="stamp-name">{{ $quotation->approver->name ?? '' }} · {{ $quotation->approved_at?->format('d/m/Y') }}</div>
                </div>
                @endif
            </div>

            {{-- Right: QR (tanda tangan digital) --}}
            <div class="sig-right">
                <div class="qr-label">Tanda Tangan Digital</div>
                <div id="qrcode"></div>
                <div class="sig-line-right"></div>
                <div class="qr-caption">Scan untuk verifikasi keaslian</div>
            </div>
        </div>

        {{-- ── FOOTER ── --}}
        <div class="footer-contacts">
            <div class="footer-contact-item">
                <div class="footer-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                </div>
                
            </div>
            <div class="footer-contact-item">
                <div class="footer-icon">
                    <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                </div>
                0812-5065-3005
            </div>
            <div class="footer-contact-item">
                <div class="footer-icon">
                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </div>
                official@fluxa.co.id
            </div>
        </div>

        {{-- Two-tone decorative bar --}}
        <div class="footer-bar">
            <div class="footer-bar-teal"></div>
            <div class="footer-bar-dark">
                <svg viewBox="0 0 400 32" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="floral" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
                            <polygon points="16,2 30,16 16,30 2,16" fill="none" stroke="rgba(255,255,255,0.18)" stroke-width="0.8"/>
                            <circle cx="16" cy="16" r="5" fill="none" stroke="rgba(255,255,255,0.22)" stroke-width="0.8"/>
                            <circle cx="16" cy="16" r="1.5" fill="rgba(255,255,255,0.3)"/>
                            <circle cx="2"  cy="2"  r="2" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="0.7"/>
                            <circle cx="30" cy="2"  r="2" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="0.7"/>
                            <circle cx="2"  cy="30" r="2" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="0.7"/>
                            <circle cx="30" cy="30" r="2" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="0.7"/>
                            <line x1="16" y1="7"  x2="16" y2="11" stroke="rgba(255,255,255,0.18)" stroke-width="0.6"/>
                            <line x1="16" y1="21" x2="16" y2="25" stroke="rgba(255,255,255,0.18)" stroke-width="0.6"/>
                            <line x1="7"  y1="16" x2="11" y2="16" stroke="rgba(255,255,255,0.18)" stroke-width="0.6"/>
                            <line x1="21" y1="16" x2="25" y2="16" stroke="rgba(255,255,255,0.18)" stroke-width="0.6"/>
                        </pattern>
                    </defs>
                    <rect width="400" height="32" fill="url(#floral)"/>
                </svg>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            new QRCode(document.getElementById('qrcode'), {
                text: "{{ route('verify.quotation', $quotation->qr_token) }}",
                width: 76, height: 76,
                colorDark: '#000000', colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            });

            // Auto-number pages when printing
            window.addEventListener('beforeprint', function() {
                var pages = document.querySelectorAll('.page');
                var total = pages.length;
                pages.forEach(function(pg, idx) {
                    var el = pg.querySelector('.page-number');
                    if (!el) {
                        el = document.createElement('div');
                        el.className = 'page-number';
                        pg.appendChild(el);
                    }
                    el.textContent = 'Halaman ' + (idx + 1) + ' dari ' + total;
                });
            });
        });
    </script>
</body>
</html>
