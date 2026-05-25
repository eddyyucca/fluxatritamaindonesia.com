@extends('layouts.portal')

@section('title', isset($expense) ? 'Edit Pengeluaran' : 'Catat Pengeluaran')
@section('page-title', isset($expense) ? 'Edit Pengeluaran' : 'Catat Pengeluaran Baru')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ isset($expense) ? 'Form Edit Pengeluaran' : 'Form Pengeluaran' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($expense) ? route('finance.expenses.update', $expense) : route('finance.expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($expense)) @method('PUT') @endif

                    <div class="form-group">
                        <label>Nama / Deskripsi Pengeluaran <span class="required-star">*</span></label>
                        <input type="text" name="title" class="form-control" required value="{{ old('title', $expense->title ?? '') }}" placeholder="Contoh: Pembelian Server / Gaji Bulan Mei">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Kategori <span class="required-star">*</span></label>
                            <select name="category" class="form-control" required>
                                <option value="Operasional" {{ old('category', $expense->category ?? '') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="Gaji & Tunjangan" {{ old('category', $expense->category ?? '') == 'Gaji & Tunjangan' ? 'selected' : '' }}>Gaji & Tunjangan</option>
                                <option value="Pemasaran" {{ old('category', $expense->category ?? '') == 'Pemasaran' ? 'selected' : '' }}>Pemasaran</option>
                                <option value="Inventaris/Aset" {{ old('category', $expense->category ?? '') == 'Inventaris/Aset' ? 'selected' : '' }}>Inventaris/Aset</option>
                                <option value="Lainnya" {{ old('category', $expense->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal <span class="required-star">*</span></label>
                            <input type="date" name="expense_date" class="form-control" required value="{{ old('expense_date', $expense->expense_date ?? date('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nominal (Rp) <span class="required-star">*</span></label>
                        <input type="number" name="amount" class="form-control" required value="{{ old('amount', $expense->amount ?? '') }}" placeholder="Contoh: 1500000">
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="has_tax" id="has_tax" class="form-check-input" value="1" {{ old('has_tax', $expense->has_tax ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="has_tax">Pengeluaran ini dikenakan/mengandung Pajak (PPN/PPh)</label>
                    </div>

                    <div class="form-group" id="tax_amount_div" style="display: {{ old('has_tax', $expense->has_tax ?? false) ? 'block' : 'none' }};">
                        <label>Nominal Pajak (Rp)</label>
                        <input type="number" name="tax_amount" class="form-control" value="{{ old('tax_amount', $expense->tax_amount ?? 0) }}">
                        <small class="text-muted">Masukkan jumlah pajak yang sudah termasuk atau dipotong.</small>
                    </div>

                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $expense->notes ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Bukti Pembayaran / Nota (Opsional)</label>
                        <input type="file" name="file" class="form-control" style="padding: 6px;">
                        <small class="text-muted">Maksimal 10MB (JPG/PNG/PDF).</small>
                        @if(isset($expense) && $expense->receipt_path)
                            <div class="mt-2">
                                <a href="{{ Storage::url($expense->receipt_path) }}" target="_blank" class="text-primary" style="font-size:12px;">
                                    <i class="fas fa-paperclip"></i> Lihat Bukti Saat Ini
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-top text-right">
                        <a href="{{ route('finance.expenses.index') }}" class="btn btn-fluxa-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-fluxa-primary">Simpan Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('has_tax').addEventListener('change', function() {
        document.getElementById('tax_amount_div').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection
