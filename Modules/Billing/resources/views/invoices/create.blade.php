@extends('layouts.portal')
@section('title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice')
@section('page-title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice Baru')

@section('content')
<div class="mt-4">
    <form method="POST"
          action="{{ isset($invoice) ? route('billing.invoices.update', $invoice) : route('billing.invoices.store') }}">
        @csrf
        @if(isset($invoice)) @method('PUT') @endif

        @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm space-y-1">
            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Main form --}}
            <div class="lg:col-span-2 space-y-4">

                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-4">Informasi Invoice</h3>
                    <div class="space-y-4">

                        {{-- From Quotation (optional) --}}
                        @if($quotations->count())
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Berdasarkan Quotation (Opsional)</label>
                            <select name="quotation_id" id="quotationSelect" class="input-field w-full rounded-lg px-3 py-2 text-sm" onchange="fillFromQuotation()">
                                <option value="">— Tanpa Quotation / Manual —</option>
                                @foreach($quotations as $q)
                                <option value="{{ $q->id }}"
                                    data-client="{{ $q->client_id }}"
                                    data-title="{{ $q->title }}"
                                    {{ old('quotation_id', $invoice->quotation_id ?? ($fromQuotation->id ?? '')) == $q->id ? 'selected' : '' }}>
                                    {{ $q->quotation_number }} — {{ $q->client->name }} ({{ $q->title }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <input type="hidden" name="quotation_id" value="">
                        @endif

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Klien <span class="text-red-400">*</span></label>
                            <div class="flex gap-2">
                                <select name="client_id" id="clientSelect" class="input-field flex-1 rounded-lg px-3 py-2 text-sm" required>
                                    <option value="">— Pilih Klien —</option>
                                    @foreach($clients as $c)
                                    <option value="{{ $c->id }}" {{ old('client_id', $invoice->client_id ?? ($fromQuotation->client_id ?? '')) == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <a href="{{ route('billing.clients.create') }}" target="_blank"
                                   class="px-3 py-2 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm hover:bg-blue-500/20 transition-colors">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Judul Proyek <span class="text-red-400">*</span></label>
                            <input type="text" name="title" id="titleInput"
                                   value="{{ old('title', $invoice->title ?? ($fromQuotation->title ?? '')) }}"
                                   class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1.5">Deskripsi</label>
                            <textarea name="description" rows="2"
                                      class="input-field w-full rounded-lg px-3 py-2 text-sm resize-none">{{ old('description', $invoice->description ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Tanggal Invoice <span class="text-red-400">*</span></label>
                                <input type="date" name="invoice_date"
                                       value="{{ old('invoice_date', isset($invoice) ? $invoice->invoice_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                       class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Jatuh Tempo</label>
                                <input type="date" name="due_date"
                                       value="{{ old('due_date', isset($invoice) && $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}"
                                       class="input-field w-full rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Keuntungan PT (%)</label>
                                <div class="relative">
                                    <input type="number" name="pt_profit_percent" id="ptPercent"
                                           value="{{ old('pt_profit_percent', $invoice->pt_profit_percent ?? 11) }}"
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
                        <h3 class="text-sm font-semibold text-white">Rincian Item</h3>
                        <button type="button" onclick="addRow()"
                                class="text-blue-400 hover:text-blue-300 text-xs px-3 py-1.5 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 transition-colors">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Item
                        </button>
                    </div>

                    <div class="grid text-xs text-slate-500 font-medium mb-2 px-1" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                        <span>Deskripsi</span><span class="text-center">Qty</span>
                        <span class="text-right">Harga Satuan</span><span class="text-right">Jumlah</span><span></span>
                    </div>

                    <div id="items-container" class="space-y-2">
                        @php $existingItems = isset($invoice) ? $invoice->items : (isset($fromQuotation) ? $fromQuotation->items : collect()) @endphp
                        @if($existingItems->isEmpty())
                            <div class="item-row grid gap-2 items-center" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                                <input type="text" name="items[0][description]" class="input-field rounded-lg px-3 py-2 text-sm" placeholder="Nama layanan / item" required>
                                <input type="number" name="items[0][quantity]" value="1" min="1" class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
                                <input type="number" name="items[0][unit_price]" value="0" min="0" step="1000" class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
                                <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400" value="0" data-raw="0">
                                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        @else
                            @foreach($existingItems as $i => $item)
                            <div class="item-row grid gap-2 items-center" style="grid-template-columns: 1fr 80px 130px 130px 32px">
                                <input type="text" name="items[{{ $i }}][description]" value="{{ $item->description }}" class="input-field rounded-lg px-3 py-2 text-sm" required>
                                <input type="number" name="items[{{ $i }}][quantity]" value="{{ $item->quantity }}" min="1" class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
                                <input type="number" name="items[{{ $i }}][unit_price]" value="{{ $item->unit_price }}" min="0" step="1000" class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
                                <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400" value="{{ number_format($item->amount, 0, ',', '.') }}" data-raw="{{ $item->amount }}">
                                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- T&C --}}
                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-3">Syarat & Ketentuan</h3>
                    <textarea name="terms_and_conditions" rows="10"
                              class="input-field w-full rounded-lg px-3 py-2 text-xs font-mono resize-y">{{ old('terms_and_conditions', $invoice->terms_and_conditions ?? $defaultTnc ?? '') }}</textarea>
                </div>

                <div class="card p-5">
                    <h3 class="text-sm font-semibold text-white mb-3">Catatan Internal</h3>
                    <textarea name="notes" rows="3"
                              class="input-field w-full rounded-lg px-3 py-2 text-sm resize-none">{{ old('notes', $invoice->notes ?? '') }}</textarea>
                </div>
            </div>

            {{-- Right: Summary --}}
            <div>
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
                        <div class="border-t border-white/10 pt-3">
                            <p class="text-xs text-slate-500 mb-2 font-semibold uppercase tracking-wide">Pembagian Internal</p>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-amber-400 text-sm">PT (<span id="disp-pct">11</span>%)</span>
                                <span class="text-amber-400 font-medium text-sm" id="disp-pt">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-emerald-400 text-sm">Bagian Anda</span>
                                <span class="text-emerald-400 font-bold text-sm" id="disp-user">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 space-y-2">
                        <button type="submit" class="btn-primary w-full text-white text-sm py-2.5 rounded-lg font-medium">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                            {{ isset($invoice) ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                        </button>
                        <a href="{{ route('billing.invoices.index') }}"
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
let rowIndex = {{ isset($invoice) && $invoice->items->count() > 0 ? $invoice->items->count() : (isset($fromQuotation) && $fromQuotation->items->count() > 0 ? $fromQuotation->items->count() : 1) }};

function fmtRp(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

function recalcRow(el) {
    const row = el.closest('.item-row');
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const up  = parseFloat(row.querySelector('.unit-price').value) || 0;
    const amt = qty * up;
    const amtEl = row.querySelector('.amount');
    amtEl.value = fmtRp(amt);
    amtEl.dataset.raw = amt;
    recalc();
}

function recalc() {
    let subtotal = 0;
    document.querySelectorAll('.amount').forEach(el => {
        subtotal += parseFloat(el.dataset.raw || 0);
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
        <input type="text" name="items[${rowIndex}][description]" class="input-field rounded-lg px-3 py-2 text-sm" placeholder="Nama layanan / item" required>
        <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" class="input-field rounded-lg px-3 py-2 text-sm text-center qty" onchange="recalcRow(this)" required>
        <input type="number" name="items[${rowIndex}][unit_price]" value="0" min="0" step="1000" class="input-field rounded-lg px-3 py-2 text-sm text-right unit-price" onchange="recalcRow(this)" required>
        <input type="text" readonly class="input-field rounded-lg px-3 py-2 text-sm text-right amount bg-white/2 text-slate-400" value="Rp 0" data-raw="0">
        <button type="button" onclick="removeRow(this)" class="text-red-400 text-xs w-7 h-7 flex items-center justify-center rounded hover:bg-red-500/10"><i class="fa-solid fa-xmark"></i></button>
    </div>`;
    document.getElementById('items-container').insertAdjacentHTML('beforeend', tpl);
    rowIndex++;
}

function removeRow(btn) {
    if (document.querySelectorAll('.item-row').length <= 1) { alert('Minimal 1 item.'); return; }
    btn.closest('.item-row').remove();
    recalc();
}

@if(isset($fromQuotation) && !isset($invoice))
// Pre-select client from quotation
document.addEventListener('DOMContentLoaded', () => {
    const clientId = "{{ $fromQuotation->client_id }}";
    const sel = document.getElementById('clientSelect');
    if (sel) sel.value = clientId;
    recalcInit();
});
@else
document.addEventListener('DOMContentLoaded', () => { recalcInit(); });
@endif

function recalcInit() {
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const up  = parseFloat(row.querySelector('.unit-price').value) || 0;
        const amtEl = row.querySelector('.amount');
        amtEl.dataset.raw = parseFloat(amtEl.dataset.raw || qty * up);
    });
    recalc();
}
</script>
@endpush
