@extends('layouts.portal')
@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan Pekerjaan')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit text-primary mr-2"></i> Edit Lowongan: {{ $vacancy->title }}</h3>
            </div>
            <form action="{{ route('admin.vacancies.update', $vacancy->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="required-star">Judul Posisi / Pekerjaan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $vacancy->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label>Lokasi Kerja</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $vacancy->location) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="required-star">Deskripsi Pekerjaan</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $vacancy->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="required-star">Persyaratan Khusus</label>
                        <textarea name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="5" required>{{ old('requirements', $vacancy->requirements) }}</textarea>
                        @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="closing_date">Batas Waktu Lamaran <span class="text-muted">(Opsional)</span></label>
                                <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ old('closing_date', $vacancy->closing_date) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="open" {{ old('status', $vacancy->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ old('status', $vacancy->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.vacancies.index') }}" class="btn btn-sm btn-fluxa-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-sm btn-fluxa-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
