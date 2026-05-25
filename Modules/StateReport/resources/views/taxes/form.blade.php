@extends('layouts.portal')

@section('title', isset($report) ? 'Edit SPT' : 'Lapor SPT Baru')
@section('page-title', isset($report) ? 'Edit SPT' : 'Lapor SPT Baru')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ isset($report) ? 'Form Edit SPT' : 'Form Pelaporan SPT' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($report) ? route('statereport.taxes.update', $report) : route('statereport.taxes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($report)) @method('PUT') @endif

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Jenis Pajak <span class="required-star">*</span></label>
                            <select name="tax_type" class="form-control" required>
                                <option value="PPh Pasal 21" {{ old('tax_type', $report->tax_type ?? '') == 'PPh Pasal 21' ? 'selected' : '' }}>PPh Pasal 21</option>
                                <option value="PPh Pasal 23" {{ old('tax_type', $report->tax_type ?? '') == 'PPh Pasal 23' ? 'selected' : '' }}>PPh Pasal 23</option>
                                <option value="PPh Pasal 25" {{ old('tax_type', $report->tax_type ?? '') == 'PPh Pasal 25' ? 'selected' : '' }}>PPh Pasal 25</option>
                                <option value="PPh Pasal 29 (Badan)" {{ old('tax_type', $report->tax_type ?? '') == 'PPh Pasal 29 (Badan)' ? 'selected' : '' }}>PPh Pasal 29 (Badan)</option>
                                <option value="PPN" {{ old('tax_type', $report->tax_type ?? '') == 'PPN' ? 'selected' : '' }}>PPN (Pajak Pertambahan Nilai)</option>
                                <option value="Pajak Daerah" {{ old('tax_type', $report->tax_type ?? '') == 'Pajak Daerah' ? 'selected' : '' }}>Pajak Daerah Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tahun Pajak <span class="required-star">*</span></label>
                            <input type="number" name="year" class="form-control" required value="{{ old('year', $report->year ?? date('Y')) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Masa Pajak (Bulan) <span class="required-star">*</span></label>
                            <select name="period" class="form-control" required>
                                <option value="Tahunan" {{ old('period', $report->period ?? '') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                    <option value="{{ $bln }}" {{ old('period', $report->period ?? '') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Pelaporan</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status', $report->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ old('status', $report->status ?? '') == 'submitted' ? 'selected' : '' }}>Submitted (Memiliki BPE)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan / NTPN</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Masukkan Nomor Tanda Penerimaan Negara (NTPN) atau catatan lain">{{ old('notes', $report->notes ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Dokumen BPE / Bukti Setor</label>
                        <input type="file" name="file" class="form-control" style="padding: 6px;">
                        <small class="text-muted">Maksimal 10MB (PDF).</small>
                        @if(isset($report) && $report->file_path)
                            <div class="mt-2">
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-primary" style="font-size:12px;">
                                    <i class="fas fa-paperclip"></i> Lihat BPE Saat Ini
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-top text-right">
                        <a href="{{ route('statereport.taxes.index') }}" class="btn btn-fluxa-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-fluxa-primary">Simpan SPT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
