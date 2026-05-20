@extends('layouts.portal')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-user-plus" style="color:#2563eb;font-size:14px;"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Informasi Pengguna</h6>
                    <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">Isi data untuk membuat akun baru</p>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.users.store') }}">
                    @csrf

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)
                        <div><i class="fas fa-circle-exclamation mr-1"></i>{{ $e }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Email <span class="required-star">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control" placeholder="email@fluxaborneo.tech" required>
                    </div>

                    <div class="form-group">
                        <label>Jabatan / Posisi</label>
                        <input type="text" name="position" value="{{ old('position') }}"
                               class="form-control" placeholder="cth. Web Developer, Project Manager">
                    </div>

                    <div class="form-group">
                        <label>Peran <span class="required-star">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Staff / User</option>
                            <option value="director" {{ old('role') === 'director' ? 'selected' : '' }}>Director</option>
                        </select>
                        <small class="form-text text-muted">Director dapat menyetujui/menolak dokumen dan melihat seluruh data.</small>
                    </div>

                    <hr class="my-3">

                    <div class="form-group">
                        <label>Password <span class="required-star">*</span></label>
                        <input type="password" name="password"
                               class="form-control" placeholder="Minimal 8 karakter" required minlength="8">
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password <span class="required-star">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Ulangi password" required>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex align-items-center" style="gap:10px;">
                        <button type="submit" class="btn btn-fluxa-primary">
                            <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna
                        </button>
                        <a href="{{ route('dashboard.users') }}" class="btn btn-fluxa-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
