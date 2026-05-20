@extends('layouts.portal')
@section('title', isset($quotation) ? 'Edit Quotation' : 'Buat Quotation')
@section('page-title', isset($quotation) ? 'Edit Quotation' : 'Buat Quotation Baru')

@section('content')
<div class="mt-4">
    <form method="POST"
          action="{{ isset($quotation) ? route('billing.quotations.update', $quotation) : route('billing.quotations.store') }}">
        @csrf
        @if(isset($quotation)) @method('PUT') @endif

        @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm space-y-1">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Main form --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Header info --}}
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-4">Informasi Quotation</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Klien <span class="text-red-400">*</span></label>
                            <div class="flex gap-2">
                                <select name="client_id" class="input-field flex-1 rounded-lg px-3 py-2 text-sm" required>
                                    <option value="">— Pilih Klien —</option>
                                    @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ old('client_id', $quotation->client_id ?? '') == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('billing.clients.create') }}" target="_blank"
                                   class="px-3 py-2 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm hover:bg-blue-500/20 transition-colors whitespace-nowrap">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Judul Proyek <span class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $quotation->title ?? '') }}"
                                   class="input-field w-full rounded-lg px-3 py-2 text-sm"
                                   placeholder="e.g. Sistem Manajemen Maintenance" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Deskripsi</label>
                            <textarea name="description" rows="3"
                                      class="input-field w-full rounded-lg px-3 py-2 text-sm resize-none"
                                      placeholder="Deskripsi singkat proyek...">{{ old('description', $quotation->description ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Berlaku Hingga</label>
                                <input type="date" name="valid_until"
                                       value="{{ old('valid_until', isset($quotation->valid_until) ? $quotation->valid_until->format('Y-m-d') : '') }}"
                                       class="input-field w-full rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Keuntungan PT (%)</label>
                                <div class="relative">
                                    <input type="number" name="pt_profit_percent" id="ptPercent"
                                           value="{{ old('pt_profit_percent', $quotation->pt_profit_percent ?? 11) }}"
                                           min="0" max="100" step="0.1"
                                           class="input-field w-full rounded-lg px-3 py-2 pr-8 text-sm"
                                           onchange="recalc()">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Items --}}
                <div class="card p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-white">Rincian Layanan / Item</h3>
                        <button type="button" onclick="addRow()"
                                class="text-blue-400 hover:text-blue-300 text-xs px-3 py-1.5 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 transition-colors">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Item
                        </button>
                    </div>

                    {{-- Table header --}}
                    <div class="grid text-xs text-slate-500 font-medium mb-2 px-1" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                        <span>Deskripsi</span>
                        <span class="text-center">Qty</span>
                        <span class="text-right">Harga Satuan</span>
                        <span class="text-right">Jumlah</span>
                        <span></span>
                    </div>

                    <div id="items-container" class="space-y-2">
                        @php $existingItems = isset($quotation) ? $quotation->items : collect() @endphp
                        @if($existingItems->isEmpty())
                            {{-- Default empty row --}}
                            <div class="item-row grid gap-2 items-center" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                                <input type="text" name="items[0][description]"
                                       class="input-field rounded-lg px-3 py-2 text-sm" placeholder="Nama layanan / item" required>
                                <input type="number" name="items[0][quantity]" value="1" min="1"
                                       class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
                                <input type="number" name="items[0][unit_price]" value="0" min="0" step="1000"
                                       class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
                                <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400" value="0">
                                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @else
                            @foreach($existingItems as $i => $item)
                            <div class="item-row grid gap-2 items-center" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                                <input type="text" name="items[{{ $i }}][description]" value="{{ $item->description }}"
                                       class="input-field rounded-lg px-3 py-2 text-sm" required>
                                <input type="number" name="items[{{ $i }}][quantity]" value="{{ $item->quantity }}" min="1"
                                       class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
                                <input type="number" name="items[{{ $i }}][unit_price]" value="{{ $item->unit_price }}" min="0" step="1000"
                                       class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
                                <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400"
                                       value="{{ number_format($item->amount, 0, ',', '.') }}" data-raw="{{ $item->amount }}">
                                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Terms & Conditions --}}
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-3">Syarat & Ketentuan</h3>
                    <textarea name="terms_and_conditions" rows="10"
                              class="input-field w-full rounded-lg px-3 py-2 text-xs font-mono resize-y">{{ old('terms_and_conditions', $quotation->terms_and_conditions ?? $defaultTnc ?? '') }}</textarea>
                    <p class="text-slate-600 text-xs mt-1">Gunakan **teks** untuk bold. Mendukung format dasar markdown.</p>
                </div>

                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-3">Catatan Internal</h3>
                    <textarea name="notes" rows="3"
                              class="input-field w-full rounded-lg px-3 py-2 text-sm resize-none"
                              placeholder="Catatan tambahan (tidak tercetak di dokumen klien)">{{ old('notes', $quotation->notes ?? '') }}</textarea>
                </div>
            </div>

            {{-- Right: Summary --}}
            <div class="space-y-4">
                <div class="card p-5 sticky top-4">
                    <h3 class="text-sm font-semibold text-white mb-4">Ringkasan Nilai</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Subtotal</span>
                            <span class="text-white font-medium text-sm" id="disp-subtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Total</span>
                            <span class="text-white font-bold" id="disp-total">Rp 0</span>
                        </div>

                        <div class="border-t border-white/10 pt-3 mt-3">
                            <p class="text-xs text-slate-500 mb-2 font-semibold uppercase tracking-wide">Pembagian Internal</p>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-amber-400 text-sm">Keuntungan PT (<span id="disp-pct">11</span>%)</span>
                                <span class="text-amber-400 font-medium text-sm" id="disp-pt">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-emerald-400 text-sm">Bagian Anda</span>
                                <span class="text-emerald-400 font-bold text-sm" id="disp-user">Rp 0</span>
                            </div>
                        </div>

                        <div class="bg-blue-500/5 border border-blue-500/15 rounded-lg p-3 mt-2 text-xs text-slate-500">
                            <i class="fa-solid fa-circle-info text-blue-400 mr-1"></i>
                            Pembagian bersifat internal dan tidak tercetak pada dokumen klien.
                        </div>
                    </div>

                    <div class="mt-5 space-y-2">
                        <button type="submit" class="btn-primary w-full text-white text-sm py-2.5 rounded-lg font-medium">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                            {{ isset($quotation) ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                        </button>
                        <a href="{{ route('billing.quotations.index') }}"
                           class="block text-center w-full text-slate-400 hover:text-slate-200 text-sm py-2 rounded-lg hover:bg-white/5 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let rowIndex = {{ isset($quotation) && $quotation->items->count() > 0 ? $quotation->items->count() : 1 }};

function fmtRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function recalcRow(el) {
    const row = el.closest('.item-row');
    const qty  = parseFloat(row.querySelector('.qty').value) || 0;
    const up   = parseFloat(row.querySelector('.unit-price').value) || 0;
    const amt  = qty * up;
    const amtEl = row.querySelector('.amount');
    amtEl.value = fmtRp(amt);
    amtEl.dataset.raw = amt;
    recalc();
}

function recalc() {
    let subtotal = 0;
    document.querySelectorAll('.amount').forEach(el => {
        subtotal += parseFloat(el.dataset.raw || el.value.replace(/[^\d]/g,'')) || 0;
    });
    const pct  = parseFloat(document.getElementById('ptPercent').value) || 0;
    const pt   = subtotal * pct / 100;
    const user = subtotal - pt;

    document.getElementById('disp-subtotal').textContent = fmtRp(subtotal);
    document.getElementById('disp-total').textContent    = fmtRp(subtotal);
    document.getElementById('disp-pct').textContent      = pct;
    document.getElementById('disp-pt').textContent       = fmtRp(pt);
    document.getElementById('disp-user').textContent     = fmtRp(user);
}

function addRow() {
    const tpl = `
    <div class="item-row grid gap-2 items-center" style="grid-template-columns: 1fr 80px 130px 130px 32px">
        <input type="text" name="items[${rowIndex}][description]"
               class="input-field rounded-lg px-3 py-2 text-sm" placeholder="Nama layanan / item" required>
        <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1"
               class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
        <input type="number" name="items[${rowIndex}][unit_price]" value="0" min="0" step="1000"
               class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
        <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400" value="Rp 0" data-raw="0">
        <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>`;
    document.getElementById('items-container').insertAdjacentHTML('beforeend', tpl);
    rowIndex++;
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length <= 1) { alert('Minimal harus ada 1 item.'); return; }
    btn.closest('.item-row').remove();
    recalc();
}

// Init calculation on load
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const up  = parseFloat(row.querySelector('.unit-price').value) || 0;
        const amtEl = row.querySelector('.amount');
        amtEl.dataset.raw = qty * up;
    });
    recalc();
});
</script>
@endpush
