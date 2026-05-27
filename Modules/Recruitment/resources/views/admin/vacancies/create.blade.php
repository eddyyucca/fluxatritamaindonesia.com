@extends('layouts.portal')
@section('title', 'Buat Lowongan')
@section('page-title', 'Buat Lowongan Pekerjaan Baru')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle text-primary mr-2"></i> Form Lowongan Baru</h3>
            </div>
            <form action="{{ route('admin.vacancies.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="required-star">Judul Posisi / Pekerjaan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Senior Web Developer">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label>Lokasi Kerja</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Contoh: Jakarta Selatan (WFO)">
                    </div>

                    <div class="form-group mb-3">
                        <label class="required-star">Deskripsi Pekerjaan</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required placeholder="Jelaskan tanggung jawab dan tugas pekerjaan..."></textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="required-star">Persyaratan Khusus</label>
                        <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="5" required placeholder="Jelaskan kualifikasi yang dibutuhkan (pengalaman, skill, dll)..."></textarea>
                        @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="closing_date">Batas Waktu Lamaran <span class="text-muted">(Opsional)</span></label>
                                <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ old('closing_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="required-star">Status Lowongan</label>
                                <select name="status" class="form-control" required>
                                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Buka (Terima Lamaran)</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Tutup (Sembunyikan)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.vacancies.index') }}" class="btn btn-sm btn-fluxa-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-sm btn-fluxa-primary">Simpan Lowongan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
