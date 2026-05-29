@extends('layouts.portal')
@section('title', isset($app_proposal) ? 'Edit Proposal Aplikasi' : 'Buat Proposal Aplikasi')
@section('page-title', isset($app_proposal) ? 'Edit Proposal Aplikasi' : 'Buat Proposal Aplikasi')

@push('styles')
<style>
    .item-row { display: grid; gap: 8px; align-items: center; margin-bottom: 8px; }
    .item-row .form-control { height: 38px; }
    .item-row .form-control[readonly] { background: #f8fafc !important; color: #94a3b8 !important; }
    .summary-row { display:flex; justify-content:space-between; align-items:center; padding: 8px 0; font-size:13px; }
    .summary-divider { border-top:1px solid #e2e8f0; margin: 6px 0; }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
<form method="POST"
      action="{{ isset($app_proposal) ? route('billing.app_proposals.update', $app_proposal) : route('billing.app_proposals.store') }}">
    @csrf
    @if(isset($app_proposal)) @method('PUT') @endif

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
                    <h6 class="card-title mb-0">Informasi Klien & Cover</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Klien <span class="required-star">*</span></label>
                        <div class="d-flex" style="gap:8px;">
                            <select name="client_id" class="form-control flex-grow-1" required>
                                <option value="">— Pilih Klien —</option>
                                @foreach($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id', $app_proposal->client_id ?? '') == $c->id ? 'selected' : '' }}>
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
                        <label>Judul Cover Proposal <span class="required-star">*</span></label>
                        <input type="text" name="cover_title" value="{{ old('cover_title', $app_proposal->cover_title ?? '') }}"
                               class="form-control" placeholder="e.g. Proposal Pengembangan Sistem Akademik" required>
                    </div>
                    <div class="form-group">
                        <label>Sub-judul Cover</label>
                        <input type="text" name="cover_subtitle" value="{{ old('cover_subtitle', $app_proposal->cover_subtitle ?? '') }}"
                               class="form-control" placeholder="e.g. Terintegrasi dengan Mobile App">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Berlaku Hingga</label>
                                <input type="date" name="valid_until"
                                       value="{{ old('valid_until', isset($app_proposal->valid_until) ? $app_proposal->valid_until->format('Y-m-d') : '') }}"
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

            {{-- Dokumen --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">Isi Proposal</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Latar Belakang / Pendahuluan</label>
                        <textarea name="introduction" class="summernote form-control">{{ old('introduction', $app_proposal->introduction ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Ruang Lingkup Pekerjaan (Scope of Work)</label>
                        <textarea name="scope_of_work" class="summernote form-control">{{ old('scope_of_work', $app_proposal->scope_of_work ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Teknologi yang Digunakan (Opsional)</label>
                        <textarea name="technology_stack" class="summernote form-control">{{ old('technology_stack', $app_proposal->technology_stack ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Estimasi Waktu / Timeline</label>
                        <textarea name="timeline_notes" class="summernote form-control">{{ old('timeline_notes', $app_proposal->timeline_notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">Rincian Investasi / Harga</h6>
                    <button type="button" onclick="addRow()" class="btn btn-sm btn-fluxa-secondary">
                        <i class="fas fa-plus mr-1"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body">
                    <div class="item-row mb-1" style="grid-template-columns: 1.5fr 1fr 130px 32px;display:grid;">
                        <small style="color:#64748b;font-weight:700;">Nama Item / Modul</small>
                        <small style="color:#64748b;font-weight:700;">Keterangan</small>
                        <small style="color:#64748b;font-weight:700;text-align:right;">Harga</small>
                        <span></span>
                    </div>

                    <div id="items-container">
                        @php $existingItems = isset($app_proposal) ? $app_proposal->items : collect() @endphp
                        @if($existingItems->isEmpty())
                        <div class="item-row" style="grid-template-columns: 1.5fr 1fr 130px 32px;">
                            <input type="text" name="items[0][item_name]" class="form-control" placeholder="Modul Utama" required>
                            <input type="text" name="items[0][description]" class="form-control" placeholder="Keterangan singkat">
                            <input type="number" name="items[0][amount]" value="0" min="0" step="1000" class="form-control text-right amount" onchange="recalc()" required data-raw="0">
                            <button type="button" onclick="removeRow(this)" class="btn btn-icon" style="color:#ef4444;border:1px solid #fecaca;background:#fff;"><i class="fas fa-xmark"></i></button>
                        </div>
                        @else
                        @foreach($existingItems as $i => $item)
                        <div class="item-row" style="grid-template-columns: 1.5fr 1fr 130px 32px;">
                            <input type="text" name="items[{{ $i }}][item_name]" value="{{ $item->item_name }}" class="form-control" required>
                            <input type="text" name="items[{{ $i }}][description]" value="{{ $item->description }}" class="form-control">
                            <input type="number" name="items[{{ $i }}][amount]" value="{{ $item->amount }}" min="0" step="1000" class="form-control text-right amount" onchange="recalc()" required data-raw="{{ $item->amount }}">
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
                              style="font-family:monospace;font-size:12px;resize:vertical;">{{ old('terms_and_conditions', $app_proposal->terms_and_conditions ?? $defaultTnc ?? '') }}</textarea>
                    <small class="text-muted mt-1 d-block">Gunakan **teks** untuk bold. Mendukung format dasar markdown.</small>
                </div>
            </div>

        </div>

        {{-- ── RIGHT: Summary ── --}}
        <div class="col-lg-4">
            <div class="card" style="position:sticky;top:76px;">
                <div class="card-header">
                    <h6 class="card-title mb-0">Ringkasan Investasi</h6>
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
                            {{ isset($app_proposal) ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                        </button>
                        <a href="{{ route('billing.app_proposals.index') }}"
                           class="btn btn-fluxa-secondary btn-block">Batal</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
let rowIndex = {{ isset($app_proposal) && $app_proposal->items->count() > 0 ? $app_proposal->items->count() : 1 }};

function fmtRp(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function recalc() {
    let subtotal = 0;
    document.querySelectorAll('.amount').forEach(el => {
        subtotal += parseFloat(el.value || 0) || 0;
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
    <div class="item-row" style="grid-template-columns: 1.5fr 1fr 130px 32px;">
        <input type="text" name="items[${rowIndex}][item_name]" class="form-control" placeholder="Modul Utama" required>
        <input type="text" name="items[${rowIndex}][description]" class="form-control" placeholder="Keterangan singkat">
        <input type="number" name="items[${rowIndex}][amount]" value="0" min="0" step="1000" class="form-control text-right amount" onchange="recalc()" required data-raw="0">
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
    recalc();
    $('.summernote').summernote({
        height: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol']],
        ]
    });
});
</script>
@endpush
