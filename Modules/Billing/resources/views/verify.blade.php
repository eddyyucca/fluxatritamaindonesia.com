<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen — PT Fluxa Tritama Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #07111f; min-height: 100vh; }
        .card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }
    </style>
</head>
<body class="text-slate-300 flex items-center justify-center min-h-screen px-4 py-8">
    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-8 mx-auto mb-4 opacity-90">
            </a>
            <p class="text-slate-500 text-sm">Sistem Verifikasi Dokumen</p>
        </div>

        {{-- Verification card --}}
        <div class="card rounded-2xl p-6">

            {{-- Type badge --}}
            <div class="flex items-center justify-center mb-5">
                @if($document->status === 'approved' || $document->status === 'paid')
                    <div class="w-16 h-16 rounded-full bg-emerald-500/15 border-2 border-emerald-500/40 flex items-center justify-center">
                        <i class="fa-solid fa-shield-check text-emerald-400 text-2xl"></i>
                    </div>
                @elseif($document->status === 'rejected')
                    <div class="w-16 h-16 rounded-full bg-red-500/15 border-2 border-red-500/40 flex items-center justify-center">
                        <i class="fa-solid fa-shield-xmark text-red-400 text-2xl"></i>
                    </div>
                @elseif($document->status === 'pending_approval' || $document->status === 'sent')
                    <div class="w-16 h-16 rounded-full bg-amber-500/15 border-2 border-amber-500/40 flex items-center justify-center">
                        <i class="fa-solid fa-clock text-amber-400 text-2xl"></i>
                    </div>
                @else
                    <div class="w-16 h-16 rounded-full bg-slate-500/15 border-2 border-slate-500/40 flex items-center justify-center">
                        <i class="fa-solid fa-file text-slate-400 text-2xl"></i>
                    </div>
                @endif
            </div>

            <h1 class="text-center text-white font-bold text-lg mb-1">
                {{ $type === 'quotation' ? 'Quotation' : ($type === 'app_proposal' ? 'Proposal Aplikasi' : 'Invoice') }} Terverifikasi
            </h1>
            <p class="text-center text-slate-500 text-sm mb-6">
                Dokumen ini dikeluarkan oleh PT Fluxa Tritama Indonesia
            </p>

            {{-- Status --}}
            @php
                $color = $document->status_color;
                $label = $document->status_label;
            @endphp
            <div class="flex items-center justify-center mb-6">
                <span class="text-sm px-4 py-1.5 rounded-full font-semibold
                    {{ $color === 'emerald' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/25' : '' }}
                    {{ $color === 'blue'    ? 'bg-blue-500/15    text-blue-400    border border-blue-500/25'    : '' }}
                    {{ $color === 'amber'   ? 'bg-amber-500/15   text-amber-400   border border-amber-500/25'   : '' }}
                    {{ $color === 'red'     ? 'bg-red-500/15     text-red-400     border border-red-500/25'     : '' }}
                    {{ $color === 'slate'   ? 'bg-slate-500/15   text-slate-400   border border-slate-500/25'   : '' }}">
                    {{ $label }}
                </span>
            </div>

            {{-- Document details --}}
            <div class="space-y-3 border-t border-white/5 pt-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">No. Dokumen</span>
                    <span class="text-white font-mono font-semibold">{{ $number }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Klien</span>
                    <span class="text-white">{{ $document->client->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Diterbitkan oleh</span>
                    <span class="text-white">{{ $document->creator->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Tanggal Dibuat</span>
                    <span class="text-white">{{ $document->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                @if($type === 'invoice')
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Tgl Invoice</span>
                    <span class="text-white">{{ $document->invoice_date->format('d/m/Y') }}</span>
                </div>
                @endif
                @if(in_array($type, ['quotation', 'app_proposal']) && $document->valid_until)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Berlaku s/d</span>
                    <span class="{{ $document->valid_until->isPast() ? 'text-red-400' : 'text-white' }}">
                        {{ $document->valid_until->format('d/m/Y') }}
                    </span>
                </div>
                @endif
                @if($document->approved_at)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Disetujui oleh</span>
                    <span class="text-emerald-400">{{ $document->approver->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Tgl Persetujuan</span>
                    <span class="text-white">{{ $document->approved_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-sm border-t border-white/5 pt-3">
                    <span class="text-slate-500">Total Nilai</span>
                    <span class="text-white font-bold text-base">Rp {{ number_format($document->total, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Approval note --}}
            @if($document->status === 'approved' || $document->status === 'paid')
            <div class="mt-5 p-3 rounded-lg bg-emerald-500/8 border border-emerald-500/20 text-center">
                <i class="fa-solid fa-circle-check text-emerald-400 mr-1"></i>
                <span class="text-emerald-300 text-sm">Dokumen ini telah disetujui dan sah diterbitkan.</span>
            </div>
            @elseif($document->status === 'rejected')
            <div class="mt-5 p-3 rounded-lg bg-red-500/8 border border-red-500/20 text-center">
                <i class="fa-solid fa-circle-xmark text-red-400 mr-1"></i>
                <span class="text-red-300 text-sm">Dokumen ini telah ditolak.</span>
            </div>
            @elseif($document->status === 'pending_approval' || $document->status === 'sent')
            <div class="mt-5 p-3 rounded-lg bg-amber-500/8 border border-amber-500/20 text-center">
                <i class="fa-solid fa-clock text-amber-400 mr-1"></i>
                <span class="text-amber-300 text-sm">Dokumen sedang menunggu persetujuan Director.</span>
            </div>
            @else
            <div class="mt-5 p-3 rounded-lg bg-slate-500/8 border border-slate-500/20 text-center">
                <i class="fa-solid fa-file text-slate-400 mr-1"></i>
                <span class="text-slate-300 text-sm">Dokumen masih dalam status draft.</span>
            </div>
            @endif
        </div>

        <p class="text-center text-slate-600 text-xs mt-6">
            &copy; {{ date('Y') }} PT Fluxa Tritama Indonesia
        </p>
    </div>
</body>
</html>
