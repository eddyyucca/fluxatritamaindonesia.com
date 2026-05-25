@extends('layouts.portal')

@section('title', isset($report) ? 'Edit Laporan Keuangan' : 'Tambah Laporan Keuangan')
@section('page-title', isset($report) ? 'Edit Laporan Keuangan' : 'Tambah Laporan Keuangan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ isset($report) ? 'Form Edit Laporan' : 'Form Tambah Laporan' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($report) ? route('statereport.financials.update', $report) : route('statereport.financials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($report)) @method('PUT') @endif

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tahun Laporan <span class="required-star">*</span></label>
                            <input type="number" name="year" class="form-control" required value="{{ old('year', $report->year ?? date('Y')) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Periode <span class="required-star">*</span></label>
                            <select name="period" class="form-control" required>
                                <option value="Tahunan" {{ old('period', $report->period ?? '') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                                <option value="Kuartal 1" {{ old('period', $report->period ?? '') == 'Kuartal 1' ? 'selected' : '' }}>Kuartal 1</option>
                                <option value="Kuartal 2" {{ old('period', $report->period ?? '') == 'Kuartal 2' ? 'selected' : '' }}>Kuartal 2</option>
                                <option value="Kuartal 3" {{ old('period', $report->period ?? '') == 'Kuartal 3' ? 'selected' : '' }}>Kuartal 3</option>
                                <option value="Kuartal 4" {{ old('period', $report->period ?? '') == 'Kuartal 4' ? 'selected' : '' }}>Kuartal 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Laporan</label>
                        <select name="status" class="form-control">
                            <option value="draft" {{ old('status', $report->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ old('status', $report->status ?? '') == 'submitted' ? 'selected' : '' }}>Submitted (Terkirim)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Catatan / Keterangan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $report->notes ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Dokumen Lampiran (Opsional)</label>
                        <input type="file" name="file" class="form-control" style="padding: 6px;">
                        <small class="text-muted">Maksimal 10MB (PDF, DOCX, XLSX).</small>
                        @if(isset($report) && $report->file_path)
                            <div class="mt-2">
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-primary" style="font-size:12px;">
                                    <i class="fas fa-paperclip"></i> Lihat Dokumen Saat Ini
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-top text-right">
                        <a href="{{ route('statereport.financials.index') }}" class="btn btn-fluxa-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-fluxa-primary">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
