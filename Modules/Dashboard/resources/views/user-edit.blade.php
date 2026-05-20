@extends('layouts.portal')
@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-user-pen" style="color:#2563eb;font-size:14px;"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Informasi Pengguna</h6>
                    <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">Perbarui data akun pengguna</p>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.users.update', $user) }}">
                    @csrf @method('PUT')

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        @foreach($errors->all() as $e)
                        <div><i class="fas fa-circle-exclamation mr-1"></i>{{ $e }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nama Lengkap <span class="required-star">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Alamat Email <span class="required-star">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Peran <span class="required-star">*</span></label>
                            <select name="role" class="form-control" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Staff / User</option>
                                <option value="director" {{ old('role', $user->role) === 'director' ? 'selected' : '' }}>Director</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Jabatan <span class="required-star">*</span></label>
                            <select name="position" class="form-control">
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach($positions as $pos)
                                <option value="{{ $pos->name }}" {{ old('position', $user->position) === $pos->name ? 'selected' : '' }}>{{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Level Organisasi</label>
                            <select name="org_level" class="form-control">
                                <option value="">-- Tidak Masuk Bagan --</option>
                                @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('org_level', $user->org_level) == $i ? 'selected' : '' }}>Level {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Atasan Langsung (Reports To)</label>
                            <select name="parent_id" class="form-control">
                                <option value="">-- Paling Atas (Tidak Punya Atasan) --</option>
                                @foreach($supervisors as $sup)
                                <option value="{{ $sup->id }}" {{ old('parent_id', $user->parent_id) == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->name }} ({{ $sup->position }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="form-group">
                        <label>Ubah Password (Opsional)</label>
                        <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mereset password pengguna ini">
                        <small class="form-text text-muted">Jika diisi, pengguna akan dipaksa mengubah password ini pada saat login berikutnya.</small>
                    </div>

                    <div class="d-flex align-items-center mt-4" style="gap:10px;">
                        <button type="submit" class="btn btn-fluxa-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard.users') }}" class="btn btn-fluxa-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
