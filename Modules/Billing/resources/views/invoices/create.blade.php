@extends('layouts.portal')
@section('title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice')
@section('page-title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice Baru')

@push('styles')
<style>
    .item-row { display: grid; gap: 8px; align-items: center; margin-bottom: 8px; }
    .item-row .form-control { height: 38px; }
    .item-row .form-control[readonly] { background: #f8fafc !important; color: #94a3b8 !important; }
    .summary-row { display:flex; justify-content:space-between; align-items:center; padding: 8px 0; font-size:13px; }
    .summary-divider { border-top:1px solid #e2e8f0; margin: 6px 0; }
</style>
@endpush

@section('content')
<form method="POST"
      action="{{ isset($invoice) ? route('billing.invoices.update', $invoice) : route('billing.invoices.store') }}">
    @csrf
    @if(isset($invoice)) @method('PUT') @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        @foreach($errors->all() as $e)<div><i class="fas fa-circle-exclamation mr-1"></i>{{ $e }}</div>@endforeach
    </div>
    @endif

    {{-- Alur Invoice --}}
    @if(!isset($invoice))
    <div class="alert alert-info d-flex align-items-start mb-4" style="gap:12px;">
        <i class="fas fa-circle-info flex-shrink-0 mt-1" style="font-size:16px;"></i>
        <div>
            <strong>Alur Penerbitan Invoice</strong>
            <div class="mt-1" style="font-size:12px;line-height:1.7;">
                Invoice yang dibuat dari Quotation yang sudah disetujui tetap memerlukan
                <strong>persetujuan akhir Director</strong> sebelum dapat diterbitkan ke klien.
                Setelah disetujui Director, invoice akan otomatis masuk ke data pendapatan perusahaan.
            </div>
            <div class="mt-2" style="font-size:11px;color:#1e40af;">
                <i class="fas fa-arrow-right mr-1"></i>
                Draft &nbsp;→&nbsp; Ajukan ke Director &nbsp;→&nbsp; <strong>Disetujui Director</strong> &nbsp;→&nbsp; Masuk Pendapatan
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        {{-- ── LEFT: Main form ── --}}
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center" style="gap:8px;">
                    <i class="fas fa-file-invoice-dollar" style="color:#7c3aed;font-size:13px;"></i>
                    <h6 class="card-title mb-0">Informasi Invoice</h6>
                </div>
                <div class="card-body">

                    {{-- From Quotation --}}
                    @if($quotations->count())
                    <div class="form-group">
                        <label>
                            <i class="fas fa-link mr-1" style="color:#94a3b8;"></i>
                            Berdasarkan Quotation
                            <span style="font-weight:400;color:#94a3b8;">(Opsional — hanya quotation yang sudah disetujui)</span>
                        </label>
                        <select name="quotation_id" id="quotationSelect" class="form-control" onchange="fillFromQuotation()">
                            <option value="">— Tanpa Referensi Quotation (Manual) —</option>
                            @foreach($quotations as $q)
                            <option value="{{ $q->id }}"
                                data-client="{{ $q->client_id }}"
                                data-title="{{ $q->title }}"
                                {{ old('quotation_id', $invoice->quotation_id ?? ($fromQuotation->id ?? '')) == $q->id ? 'selected' : '' }}>
                                ✓ {{ $q->quotation_number }} — {{ $q->client->name }} · {{ $q->title }}
                            </option>
                            @endforeach
                        </select>
                        @if(isset($fromQuotation))
                        <div style="margin-top:6px;padding:8px 12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:12px;color:#166534;">
                            <i class="fas fa-circle-check mr-1"></i>
                            Dibuat dari Quotation <strong>{{ $fromQuotation->quotation_number }}</strong>
                            yang telah disetujui Director. Invoice ini masih perlu persetujuan final Director.
                        </div>
                        @endif
                    </div>
                    @else
                    <input type="hidden" name="quotation_id" value="">
                    @endif

                    <div class="form-group">
                        <label>Klien <span class="required-star">*</span></label>
                        <div class="d-flex" style="gap:8px;">
                            <select name="client_id" id="clientSelect" class="form-control flex-grow-1" required>
                                <option value="">— Pilih Klien —</option>
                                @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id', $invoice->client_id ?? ($fromQuotation->client_id ?? '')) == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                                @endforeach
                            </select>
                            <a href="{{ route('billing.clients.create') }}" target="_blank"
                               class="btn btn-fluxa-secondary d-flex align-items-center px-3" title="Tambah Klien Baru">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Judul Proyek <span class="required-star">*</span></label>
                        <input type="text" name="title" id="titleInput"
                               value="{{ old('title', $invoice->title ?? ($fromQuotation->title ?? '')) }}"
                               class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="2" class="form-control">{{ old('description', $invoice->description ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Invoice <span class="required-star">*</span></label>
                                <input type="date" name="invoice_date"
                                       value="{{ old('invoice_date', isset($invoice) ? $invoice->invoice_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jatuh Tempo</label>
                                <input type="date" name="due_date"
                                       value="{{ old('due_date', isset($invoice) && $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Keuntungan PT (%)</label>
                                <div class="input-group">
                                    <input type="number" name="pt_profit_percent" id="ptPercent"
                                           value="{{ old('pt_profit_percent', $invoice->pt_profit_percent ?? 11) }}"
                                           min="0" max="100" step="0.1"
                                           class="form-control" onchange="recalc()">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">Rincian Item</h6>
                    <button type="button" onclick="addRow()" class="btn btn-sm btn-fluxa-secondary">
                        <i class="fas fa-plus mr-1"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body">

                    <div class="item-row mb-1" style="grid-template-columns: 1fr 80px 130px 130px 32px;display:grid;">
                        <small style="color:#64748b;font-weight:700;">Deskripsi</small>
                        <small style="color:#64748b;font-weight:700;text-align:center;">Qty</small>
                        <small style="color:#64748b;font-weight:700;text-align:right;">Harga Satuan</small>
                        <small style="color:#64748b;font-weight:700;text-align:right;">Jumlah</small>
                        <span></span>
                    </div>

                    <div id="items-container">
                        @php $existingItems = isset($invoice) ? $invoice->items : (isset($fromQuotation) ? $fromQuotation->items : collect()) @endphp
                        @if($existingItems->isEmpty())
                        <div class="item-row" style="grid-template-columns: 1fr 80px 130px 130px 32px;">
                            <input type="text" name="items[0][description]" class="form-control" placeholder="Nama layanan / item" required>
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="form-control text-center qty" onchange="recalcRow(this)" required>
                            <input type="number" name="items[0][unit_price]" value="0" min="0" step="1000" class="form-control text-right unit-price" onchange="recalcRow(this)" required>
                            <input type="text" readonly class="form-control text-right amount" value="0" data-raw="0">
                            <button type="button" onclick="removeRow(this)" class="btn btn-icon" style="color:#ef4444;border:1px solid #fecaca;background:#fff;"><i class="fas fa-xmark"></i></button>
                        </div>
                        @else
                        @foreach($existingItems as $i => $item)
                        <div class="item-row" style="grid-template-columns: 1fr 80px 130px 130px 32px;">
                            <input type="text" name="items[{{ $i }}][description]" value="{{ $item->description }}" class="form-control" required>
                            <input type="number" name="items[{{ $i }}][quantity]" value="{{ $item->quantity }}" min="1" class="form-control text-center qty" onchange="recalcRow(this)" required>
                            <input type="number" name="items[{{ $i }}][unit_price]" value="{{ $item->unit_price }}" min="0" step="1000" class="form-control text-right unit-price" onchange="recalcRow(this)" required>
                            <input type="text" readonly class="form-control text-right amount" value="{{ number_format($item->amount, 0, ',', '.') }}" data-raw="{{ $item->amount }}">
                            <button type="button" onclick="removeRow(this)" class="btn btn-icon" style="color:#ef4444;border:1px solid #fecaca;background:#fff;"><i class="fas fa-xmark"></i></button>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- T&C --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Syarat & Ketentuan</h6>
                </div>
                <div class="card-body">
                    <textarea name="terms_and_conditions" rows="10" class="form-control"
                              style="font-family:monospace;font-size:12px;resize:vertical;">{{ old('terms_and_conditions', $invoice->terms_and_conditions ?? $defaultTnc ?? '') }}</textarea>
                </div>
            </div>

            {{-- Notes --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Catatan Internal</h6>
                </div>
                <div class="card-body">
                    <textarea name="notes" rows="3" class="form-control"
                              placeholder="Catatan tambahan (tidak tercetak di dokumen klien)">{{ old('notes', $invoice->notes ?? '') }}</textarea>
                </div>
            </div>

        </div>

        {{-- ── RIGHT: Summary ── --}}
        <div class="col-lg-4">
            <div class="card" style="position:sticky;top:76px;">
                <div class="card-header">
                    <h6 class="card-title mb-0">Ringkasan Nilai</h6>
                </div>
                <div class="card-body">

                    <div class="summary-row">
                        <span style="color:#64748b;">Subtotal</span>
                        <span style="font-weight:600;color:#1e293b;" id="disp-subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span style="color:#64748b;">Total</span>
                        <strong style="color:#1e293b;font-size:15px;" id="disp-total">Rp 0</strong>
                    </div>

                    <div class="summary-divider"></div>

                    <p style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;">Pembagian Internal</p>
                    <div class="summary-row">
                        <span style="color:#d97706;">PT (<span id="disp-pct">11</span>%)</span>
                        <span style="color:#d97706;font-weight:600;" id="disp-pt">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span style="color:#16a34a;">Bagian Anda</span>
                        <strong style="color:#16a34a;" id="disp-user">Rp 0</strong>
                    </div>

                    <div class="mt-4">
                        {{-- Workflow reminder --}}
                        @if(!isset($invoice))
                        <div style="background:#fafafa;border:1px solid #e2e8f0;border-radius:8px;padding:10px 12px;margin-bottom:12px;font-size:11px;color:#64748b;line-height:1.6;">
                            <i class="fas fa-info-circle mr-1" style="color:#3b82f6;"></i>
                            Invoice akan tersimpan sebagai <strong>Draft</strong>. Ajukan ke Director setelah data lengkap.
                            Hanya invoice yang disetujui Director yang masuk ke data pendapatan.
                        </div>
                        @endif
                        <button type="submit" class="btn btn-fluxa-primary btn-block mb-2">
                            <i class="fas fa-floppy-disk mr-1"></i>
                            {{ isset($invoice) ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                        </button>
                        <a href="{{ route('billing.invoices.index') }}"
                           class="btn btn-fluxa-secondary btn-block">Batal</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
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
        subtotal += parseFloat(el.dataset.raw || 0) || 0;
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

function fillFromQuotation() {
    const sel    = document.getElementById('quotationSelect');
    const opt    = sel.options[sel.selectedIndex];
    const client = opt.dataset.client;
    const title  = opt.dataset.title;
    if (client) {
        const clientSel = document.getElementById('clientSelect');
        if (clientSel) clientSel.value = client;
    }
    if (title) {
        const titleInput = document.getElementById('titleInput');
        if (titleInput) titleInput.value = title;
    }
}

function addRow() {
    const tpl = `
    <div class="item-row" style="grid-template-columns: 1fr 80px 130px 130px 32px;">
        <input type="text" name="items[${rowIndex}][description]" class="form-control" placeholder="Nama layanan / item" required>
        <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" class="form-control text-center qty" onchange="recalcRow(this)" required>
        <input type="number" name="items[${rowIndex}][unit_price]" value="0" min="0" step="1000" class="form-control text-right unit-price" onchange="recalcRow(this)" required>
        <input type="text" readonly class="form-control text-right amount" value="Rp 0" data-raw="0">
        <button type="button" onclick="removeRow(this)" class="btn btn-icon" style="color:#ef4444;border:1px solid #fecaca;background:#fff;"><i class="fas fa-xmark"></i></button>
    </div>`;
    document.getElementById('items-container').insertAdjacentHTML('beforeend', tpl);
    rowIndex++;
}

function removeRow(btn) {
    if (document.querySelectorAll('.item-row').length <= 1) {
        Swal.fire({ icon:'warning', title:'Perhatian', text:'Minimal 1 item.', confirmButtonColor:'#2563eb' });
        return;
    }
    btn.closest('.item-row').remove();
    recalc();
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const up  = parseFloat(row.querySelector('.unit-price').value) || 0;
        const amtEl = row.querySelector('.amount');
        amtEl.dataset.raw = parseFloat(amtEl.dataset.raw || qty * up) || 0;
    });
    recalc();
});
</script>
@endpush
