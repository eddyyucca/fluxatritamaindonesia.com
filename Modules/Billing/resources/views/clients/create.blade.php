@extends('layouts.portal')
@section('title', isset($client) ? 'Edit Klien' : 'Tambah Klien')
@section('page-title', isset($client) ? 'Edit Klien' : 'Tambah Klien')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-building" style="color:#2563eb;font-size:14px;"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">{{ isset($client) ? 'Edit Data Klien' : 'Data Klien Baru' }}</h6>
                    <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">
                        {{ isset($client) ? 'Perbarui informasi klien' : 'Isi informasi perusahaan atau klien' }}
                    </p>
                </div>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ isset($client) ? route('billing.clients.update', $client) : route('billing.clients.store') }}">
                    @csrf
                    @if(isset($client)) @method('PUT') @endif

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)
                        <div><i class="fas fa-circle-exclamation mr-1"></i>{{ $e }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Nama Perusahaan / Klien <span class="required-star">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name', $client->name ?? '') }}"
                               class="form-control"
                               placeholder="cth. PT Maju Bersama Indonesia"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" rows="3" class="form-control"
                                  placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan">{{ old('address', $client->address ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kota</label>
                                <input type="text" name="city"
                                       value="{{ old('city', $client->city ?? '') }}"
                                       class="form-control"
                                       placeholder="cth. Banjarmasin">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="text" name="phone"
                                       value="{{ old('phone', $client->phone ?? '') }}"
                                       class="form-control"
                                       placeholder="cth. 0812-xxxx-xxxx">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $client->email ?? '') }}"
                               class="form-control"
                               placeholder="email@perusahaan.com">
                    </div>

                    <hr class="my-3">

                    <div class="d-flex align-items-center" style="gap:10px;">
                        <button type="submit" class="btn btn-fluxa-primary">
                            <i class="fas fa-floppy-disk mr-1"></i>
                            {{ isset($client) ? 'Simpan Perubahan' : 'Tambah Klien' }}
                        </button>
                        <a href="{{ route('billing.clients.index') }}" class="btn btn-fluxa-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
