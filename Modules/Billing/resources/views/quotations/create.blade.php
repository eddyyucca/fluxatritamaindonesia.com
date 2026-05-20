@extends('layouts.portal')
@section('title', isset($quotation) ? 'Edit Quotation' : 'Buat Quotation')
@section('page-title', isset($quotation) ? 'Edit Quotation' : 'Buat Quotation Baru')

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
      action="{{ isset($quotation) ? route('billing.quotations.update', $quotation) : route('billing.quotations.store') }}">
    @csrf
    @if(isset($quotation)) @method('PUT') @endif

    @if($errors->any())
    <div class="alert alert-danger mb-4">
        @foreach($errors->all() as $e)<div><i class="fas fa-circle-exclamation mr-1"></i>{{ $e }}</div>@endforeach
    </div>
    @endif

    <div class="row">

        {{-- ── LEFT: Main form ── --}}
        <div class="col-lg-8">

            {{-- Header info --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Informasi Quotation</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Klien <span class="required-star">*</span></label>
                        <div class="d-flex" style="gap:8px;">
                            <select name="client_id" class="form-control flex-grow-1" required>
                                <option value="">— Pilih Klien —</option>
                                @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id', $quotation->client_id ?? '') == $c->id ? 'selected' : '' }}>
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
                        <input type="text" name="title" value="{{ old('title', $quotation->title ?? '') }}"
                               class="form-control" placeholder="e.g. Sistem Manajemen Maintenance" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="3" class="form-control"
                                  placeholder="Deskripsi singkat proyek...">{{ old('description', $quotation->description ?? '') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Berlaku Hingga</label>
                                <input type="date" name="valid_until"
                                       value="{{ old('valid_until', isset($quotation->valid_until) ? $quotation->valid_until->format('Y-m-d') : '') }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keuntungan PT (%)</label>
                                <div class="input-group">
                                    <input type="number" name="pt_profit_percent" id="ptPercent"
                                           value="11"
                                           min="11" max="11" step="1"
                                           class="form-control" readonly onchange="recalc()">
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
                    <h6 class="card-title mb-0">Rincian Layanan / Item</h6>
                    <button type="button" onclick="addRow()" class="btn btn-sm btn-fluxa-secondary">
                        <i class="fas fa-plus mr-1"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body">

                    {{-- Table header --}}
                    <div class="item-row mb-1" style="grid-template-columns: 1fr 80px 130px 130px 32px;display:grid;">
                        <small style="color:#64748b;font-weight:700;">Deskripsi</small>
                        <small style="color:#64748b;font-weight:700;text-align:center;">Qty</small>
                        <small style="color:#64748b;font-weight:700;text-align:right;">Harga Satuan</small>
                        <small style="color:#64748b;font-weight:700;text-align:right;">Jumlah</small>
                        <span></span>
                    </div>

                    <div id="items-container">
                        @php $existingItems = isset($quotation) ? $quotation->items : collect() @endphp
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
                              style="font-family:monospace;font-size:12px;resize:vertical;">{{ old('terms_and_conditions', $quotation->terms_and_conditions ?? $defaultTnc ?? '') }}</textarea>
                    <small class="text-muted mt-1 d-block">Gunakan **teks** untuk bold. Mendukung format dasar markdown.</small>
                </div>
            </div>

            {{-- Notes --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Catatan Internal</h6>
                </div>
                <div class="card-body">
                    <textarea name="notes" rows="3" class="form-control"
                              placeholder="Catatan tambahan (tidak tercetak di dokumen klien)">{{ old('notes', $quotation->notes ?? '') }}</textarea>
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
                        <span style="color:#d97706;">Keuntungan PT (<span id="disp-pct">11</span>%)</span>
                        <span style="color:#d97706;font-weight:600;" id="disp-pt">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span style="color:#16a34a;">Bagian Anda</span>
                        <strong style="color:#16a34a;" id="disp-user">Rp 0</strong>
                    </div>

                    <div style="background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;padding:10px;margin-top:10px;font-size:12px;color:#64748b;">
                        <i class="fas fa-circle-info mr-1" style="color:#0ea5e9;"></i>
                        Pembagian bersifat internal dan tidak tercetak pada dokumen klien.
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-fluxa-primary btn-block mb-2">
                            <i class="fas fa-floppy-disk mr-1"></i>
                            {{ isset($quotation) ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                        </button>
                        <a href="{{ route('billing.quotations.index') }}"
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
    const rows = document.querySelectorAll('.item-row');
    if (rows.length <= 1) {
        Swal.fire({ icon:'warning', title:'Perhatian', text:'Minimal harus ada 1 item.', confirmButtonColor:'#2563eb' });
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
