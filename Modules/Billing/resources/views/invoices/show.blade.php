@extends('layouts.portal')
@section('title', $invoice->invoice_number)
@section('page-title', 'Detail Invoice')

@section('topbar-actions')
    <div class="flex items-center gap-2 no-print">
        @if($invoice->status === 'draft')
            <a href="{{ route('billing.invoices.edit', $invoice) }}"
               class="text-slate-400 hover:text-white text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:border-white/20 transition-colors">
                <i class="fa-solid fa-pen mr-1"></i> Edit
            </a>
            <form method="POST" action="{{ route('billing.invoices.submit', $invoice) }}" class="inline">
                @csrf
                <button type="submit" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium">
                    <i class="fa-solid fa-paper-plane mr-1"></i> Ajukan ke Director
                </button>
            </form>
        @endif
        @if($invoice->status === 'pending_approval' && Auth::user()->isDirector())
            <form method="POST" action="{{ route('billing.invoices.approve', $invoice) }}" class="inline">
                @csrf
                <button type="submit" class="btn-success text-white text-xs px-3 py-1.5 rounded-lg font-medium">
                    <i class="fa-solid fa-check mr-1"></i> Setujui & Terbitkan
                </button>
            </form>
            <form method="POST" action="{{ route('billing.invoices.reject', $invoice) }}" class="inline"
                  onsubmit="return confirm('Tolak invoice ini?')">
                @csrf
                <button type="submit" class="btn-danger text-white text-xs px-3 py-1.5 rounded-lg font-medium">
                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                </button>
            </form>
        @endif
        @if($invoice->status === 'approved' && Auth::user()->isDirector())
            <form method="POST" action="{{ route('billing.invoices.paid', $invoice) }}" class="inline">
                @csrf
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition-colors">
                    <i class="fa-solid fa-money-bill-wave mr-1"></i> Tandai Lunas
                </button>
            </form>
        @endif
        <a href="{{ route('billing.invoices.print', $invoice) }}" target="_blank"
           class="text-slate-400 hover:text-white text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:border-white/20 transition-colors">
            <i class="fa-solid fa-print mr-1"></i> Cetak
        </a>
        @if($invoice->status === 'draft')
        <form method="POST" action="{{ route('billing.invoices.destroy', $invoice) }}" class="inline"
              onsubmit="return confirm('Hapus invoice ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 text-xs px-2 py-1.5 rounded-lg hover:bg-red-500/10 transition-colors">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
        @endif
    </div>
@endsection

@section('content')
<div class="mt-4">

    {{-- Status bar --}}
    @php $color = $invoice->status_color @endphp
    <div class="mb-4 p-3 rounded-lg flex items-center justify-between no-print
        {{ $color === 'emerald' ? 'bg-emerald-500/10 border border-emerald-500/20' : '' }}
        {{ $color === 'blue'    ? 'bg-blue-500/10    border border-blue-500/20'    : '' }}
        {{ $color === 'amber'   ? 'bg-amber-500/10   border border-amber-500/20'   : '' }}
        {{ $color === 'red'     ? 'bg-red-500/10     border border-red-500/20'     : '' }}
        {{ $color === 'slate'   ? 'bg-slate-500/10   border border-slate-500/20'   : '' }}">
        <div class="flex items-center gap-2">
            <i class="fa-solid
                {{ $color === 'emerald' ? 'fa-circle-check text-emerald-400' : '' }}
                {{ $color === 'blue'    ? 'fa-stamp text-blue-400'             : '' }}
                {{ $color === 'amber'   ? 'fa-clock text-amber-400'            : '' }}
                {{ $color === 'red'     ? 'fa-circle-xmark text-red-400'       : '' }}
                {{ $color === 'slate'   ? 'fa-file text-slate-400'              : '' }}"></i>
            <span class="text-sm font-medium
                {{ $color === 'emerald' ? 'text-emerald-300' : '' }}
                {{ $color === 'blue'    ? 'text-blue-300'    : '' }}
                {{ $color === 'amber'   ? 'text-amber-300'   : '' }}
                {{ $color === 'red'     ? 'text-red-300'     : '' }}
                {{ $color === 'slate'   ? 'text-slate-300'   : '' }}">
                Status: {{ $invoice->status_label }}
            </span>
            @if($invoice->approved_at)
            <span class="text-slate-500 text-xs">
                — {{ $invoice->approved_at->isoFormat('D MMMM YYYY, HH:mm') }} oleh {{ $invoice->approver->name ?? '—' }}
            </span>
            @endif
        </div>
        <div class="text-xs text-slate-500">
            Dibuat: {{ $invoice->creator->name }} · {{ $invoice->created_at->isoFormat('D MMM YYYY') }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Document --}}
        <div class="lg:col-span-2">
            <div class="card p-0 overflow-hidden" id="document-print">
                {{-- Header --}}
                <div style="background: linear-gradient(135deg, #07111f 0%, #0f1e35 100%); border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <div class="p-6 flex items-start justify-between">
                        <div>
                            <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-9 mb-3 opacity-90">
                            <p class="text-white font-bold text-sm">PT FLUXA TRITAMA INDONESIA</p>
                            <p class="text-slate-400 text-xs mt-0.5">Tapin, RT 011, RW 004, Suato Tatakan</p>
                            <p class="text-slate-400 text-xs">Tapin Selatan, Kalimantan Selatan 71181</p>
                            <p class="text-slate-400 text-xs mt-0.5">0812-5065-3005 · official@fluxaborneo.tech</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black text-white tracking-tight">INVOICE</p>
                            <p class="text-blue-400 font-mono text-sm mt-1">{{ $invoice->invoice_number }}</p>
                            <p class="text-slate-400 text-xs mt-1">Tgl Invoice: {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                            @if($invoice->due_date)
                            <p class="{{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-400' : 'text-slate-400' }} text-xs">
                                Jatuh Tempo: {{ $invoice->due_date->format('d/m/Y') }}
                            </p>
                            @endif
                            @if($invoice->quotation)
                            <p class="text-slate-500 text-xs mt-1">Ref: {{ $invoice->quotation->quotation_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Client & Title --}}
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mb-1">Ditagihkan Kepada</p>
                            <p class="text-white font-bold">{{ $invoice->client->name }}</p>
                            @if($invoice->client->address)
                            <p class="text-slate-400 text-xs mt-0.5">{{ $invoice->client->address }}</p>
                            @endif
                            @if($invoice->client->city)
                            <p class="text-slate-400 text-xs">{{ $invoice->client->city }}</p>
                            @endif
                            @if($invoice->client->email)
                            <p class="text-slate-400 text-xs mt-0.5">{{ $invoice->client->email }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest mb-1">Proyek</p>
                            <p class="text-white font-semibold">{{ $invoice->title }}</p>
                            @if($invoice->description)
                            <p class="text-slate-400 text-xs mt-1">{{ $invoice->description }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Items table --}}
                    <div class="mb-6">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-blue-500/10 border border-blue-500/15">
                                    <th class="text-left px-3 py-2.5 text-xs text-blue-300 font-semibold">No</th>
                                    <th class="text-left px-3 py-2.5 text-xs text-blue-300 font-semibold">Deskripsi</th>
                                    <th class="text-center px-3 py-2.5 text-xs text-blue-300 font-semibold">Qty</th>
                                    <th class="text-right px-3 py-2.5 text-xs text-blue-300 font-semibold">Harga Satuan</th>
                                    <th class="text-right px-3 py-2.5 text-xs text-blue-300 font-semibold">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($invoice->items as $i => $item)
                                <tr>
                                    <td class="px-3 py-2.5 text-slate-500 text-xs">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2.5 text-slate-200">{{ $item->description }}</td>
                                    <td class="px-3 py-2.5 text-center text-slate-400 text-xs">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2.5 text-right text-slate-300 text-xs">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-3 py-2.5 text-right text-white font-medium text-xs">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-blue-500/30">
                                    <td colspan="3"></td>
                                    <td class="px-3 py-3 text-right text-slate-400 text-sm font-semibold">TOTAL</td>
                                    <td class="px-3 py-3 text-right text-white text-base font-black">
                                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- Payment info --}}
                    <div class="bg-blue-500/5 border border-blue-500/15 rounded-lg p-4 mb-6">
                        <p class="text-xs font-semibold text-blue-300 mb-2 uppercase tracking-wide">Informasi Pembayaran</p>
                        <div class="grid grid-cols-3 gap-2 text-xs">
                            <div><span class="text-slate-500">Bank</span><br><span class="text-white font-medium">MANDIRI</span></div>
                            <div><span class="text-slate-500">No. Rekening</span><br><span class="text-white font-medium font-mono">031 00 2387227 1</span></div>
                            <div><span class="text-slate-500">Atas Nama</span><br><span class="text-white font-medium">PT Fluxa Tritama Indonesia</span></div>
                        </div>
                    </div>

                    {{-- T&C --}}
                    @if($invoice->terms_and_conditions)
                    <div class="border-t border-white/5 pt-5 mb-5">
                        <p class="text-xs font-semibold text-white mb-3 uppercase tracking-wide">Syarat & Ketentuan</p>
                        <div class="text-xs text-slate-400 space-y-2 leading-relaxed">
                            @foreach(explode("\n\n", $invoice->terms_and_conditions) as $para)
                            <div class="border-l-2 border-blue-500/20 pl-3">
                                {!! nl2br(preg_replace('/\*\*(.*?)\*\*/', '<span class="text-slate-200 font-semibold">$1</span>', e(trim($para)))) !!}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Footer --}}
                    <div class="border-t border-white/5 pt-4 flex items-end justify-between">
                        <div class="text-xs text-slate-500">
                            <p>Disiapkan oleh: <span class="text-slate-300">{{ $invoice->creator->name }}</span></p>
                            <p class="mt-1">{{ $invoice->creator->position ?? 'PT Fluxa Tritama Indonesia' }}</p>
                            @if($invoice->status === 'approved' || $invoice->status === 'paid')
                            <div class="mt-3 p-2 rounded bg-blue-500/10 border border-blue-500/20">
                                <p class="text-blue-400 font-semibold text-[10px] uppercase tracking-wide">✓ DISETUJUI DIRECTOR</p>
                                <p class="text-blue-300 text-[10px]">{{ $invoice->approver->name ?? '' }} · {{ $invoice->approved_at?->format('d/m/Y') }}</p>
                            </div>
                            @endif
                            @if($invoice->status === 'paid')
                            <div class="mt-2 p-2 rounded bg-emerald-500/10 border border-emerald-500/20">
                                <p class="text-emerald-400 font-semibold text-[10px] uppercase tracking-wide">✓ LUNAS</p>
                            </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <div id="qrcode" class="inline-block rounded-lg overflow-hidden bg-white p-2"></div>
                            <p class="text-slate-600 text-[10px] mt-1">Scan untuk verifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right sidebar --}}
        <div class="space-y-4 no-print">
            {{-- Profit split --}}
            @if(Auth::user()->isDirector() || $invoice->created_by === Auth::id())
            <div class="card p-5">
                <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-blue-400"></i> Pembagian Keuntungan
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <span class="text-slate-400 text-sm">Total Invoice</span>
                        <span class="text-white font-bold">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5">
                        <div>
                            <span class="text-amber-400 text-sm">Keuntungan PT</span>
                            <span class="text-slate-500 text-xs ml-1">({{ $invoice->pt_profit_percent }}%)</span>
                        </div>
                        <span class="text-amber-400 font-semibold">Rp {{ number_format($invoice->pt_profit_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-emerald-400 text-sm">
                            {{ Auth::user()->isDirector() ? 'Bagian ' . ($invoice->creator->name ?? 'Staff') : 'Bagian Anda' }}
                        </span>
                        <span class="text-emerald-400 font-bold text-lg">Rp {{ number_format($invoice->user_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Info --}}
            <div class="card p-5 text-xs space-y-3">
                <h3 class="text-sm font-semibold text-white mb-1">Informasi Dokumen</h3>
                <div class="flex justify-between text-slate-400">
                    <span>No. Invoice</span><span class="text-white font-mono">{{ $invoice->invoice_number }}</span>
                </div>
                @if($invoice->quotation)
                <div class="flex justify-between text-slate-400">
                    <span>Ref. Quotation</span>
                    <a href="{{ route('billing.quotations.show', $invoice->quotation) }}" class="text-blue-400 hover:underline font-mono">
                        {{ $invoice->quotation->quotation_number }}
                    </a>
                </div>
                @endif
                <div class="flex justify-between text-slate-400">
                    <span>Klien</span><span class="text-white">{{ $invoice->client->name }}</span>
                </div>
                <div class="flex justify-between text-slate-400">
                    <span>Tgl Invoice</span><span class="text-white">{{ $invoice->invoice_date->format('d/m/Y') }}</span>
                </div>
                @if($invoice->due_date)
                <div class="flex justify-between text-slate-400">
                    <span>Jatuh Tempo</span>
                    <span class="{{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-400' : 'text-white' }}">
                        {{ $invoice->due_date->format('d/m/Y') }}
                    </span>
                </div>
                @endif
                <div class="flex justify-between text-slate-400">
                    <span>Dibuat oleh</span><span class="text-white">{{ $invoice->creator->name }}</span>
                </div>
            </div>

            <div class="card p-4">
                <p class="text-xs text-slate-500 mb-2">Link Verifikasi</p>
                <p class="text-[11px] text-blue-400 font-mono break-all">{{ route('verify.invoice', $invoice->qr_token) }}</p>
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
    width: 80,
    height: 80,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});
</script>
@endpush
