@extends('layouts.portal')

@section('title', isset($report) ? 'Edit Laporan Lainnya' : 'Tambah Laporan Lainnya')
@section('page-title', isset($report) ? 'Edit Laporan Lainnya' : 'Tambah Laporan Lainnya')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ isset($report) ? 'Form Edit Laporan Lainnya' : 'Form Tambah Laporan Lainnya' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($report) ? route('statereport.others.update', $report) : route('statereport.others.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($report)) @method('PUT') @endif

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nama / Judul Laporan <span class="required-star">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title', $report->title ?? '') }}" placeholder="Contoh: Laporan LKPM Kuartal 1">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Lembaga Tujuan <span class="required-star">*</span></label>
                            <input type="text" name="institution" class="form-control" required value="{{ old('institution', $report->institution ?? '') }}" placeholder="Contoh: BKPM / BPJS / Disnaker">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tanggal Pelaporan <span class="required-star">*</span></label>
                            <input type="date" name="report_date" class="form-control" required value="{{ old('report_date', $report->report_date ?? date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status Laporan</label>
                            <select name="status" class="form-control">
                                <option value="draft" {{ old('status', $report->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="submitted" {{ old('status', $report->status ?? '') == 'submitted' ? 'selected' : '' }}>Submitted (Selesai Dilapor)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $report->notes ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Dokumen Tanda Terima (Opsional)</label>
                        <input type="file" name="file" class="form-control" style="padding: 6px;">
                        <small class="text-muted">Maksimal 10MB (PDF/ZIP).</small>
                        @if(isset($report) && $report->file_path)
                            <div class="mt-2">
                                <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="text-primary" style="font-size:12px;">
                                    <i class="fas fa-paperclip"></i> Lihat Dokumen Saat Ini
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-top text-right">
                        <a href="{{ route('statereport.others.index') }}" class="btn btn-fluxa-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-fluxa-primary">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
