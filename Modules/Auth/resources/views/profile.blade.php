@extends('layouts.portal')
@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
<div class="row">

    {{-- Profil --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-user-pen" style="color:#2563eb;font-size:13px;"></i>
                <h6 class="card-title mb-0">Informasi Profil</h6>
            </div>
            <div class="card-body">
                @if($errors->has('name') || $errors->has('email') || $errors->has('position'))
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 pl-3" style="font-size:13px;">
                        @foreach(['name','email','position'] as $f)
                            @foreach($errors->get($f) as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required-star">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Jabatan</label>
                        @if($positions->count())
                        <select name="position" class="form-control">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($positions as $pos)
                            <option value="{{ $pos->name }}" {{ $user->position === $pos->name ? 'selected' : '' }}>{{ $pos->name }}</option>
                            @endforeach
                            <option value="{{ $user->position }}" {{ !$positions->contains('name', $user->position) && $user->position ? 'selected' : '' }}>
                                {{ $user->position && !$positions->contains('name', $user->position) ? $user->position . ' (kustom)' : '' }}
                            </option>
                        </select>
                        @else
                        <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}" placeholder="Mis: Marketing, Programmer...">
                        <small class="text-muted">Belum ada jabatan di master data. <a href="{{ route('dashboard.positions') }}">Tambahkan jabatan</a>.</small>
                        @endif
                    </div>

                    <div class="form-group mb-0">
                        <div class="d-flex align-items-center" style="background:#f8fafc;border-radius:8px;padding:12px 16px;border:1px solid #e2e8f0;gap:12px;">
                            <div class="user-avatar-circle" style="width:44px;height:44px;font-size:18px;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:700;color:#1e293b;font-size:14px;margin-bottom:2px;">{{ $user->name }}</p>
                                <p style="font-size:12px;color:#64748b;margin-bottom:0;">{{ $user->email }}</p>
                                <span class="user-role-badge {{ $user->isDirector() ? 'user-role-director' : 'user-role-staff' }}" style="margin-top:4px;display:inline-block;">
                                    {{ $user->isDirector() ? 'Director' : 'Staff' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-fluxa-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Ubah Password --}}
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-lock" style="color:#7c3aed;font-size:13px;"></i>
                <h6 class="card-title mb-0">Ubah Password</h6>
            </div>
            <div class="card-body">
                @if($errors->has('current_password') || $errors->has('password'))
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0 pl-3" style="font-size:13px;">
                        @foreach(['current_password','password'] as $f)
                            @foreach($errors->get($f) as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Password Saat Ini <span class="required-star">*</span></label>
                        <div style="position:relative;">
                            <input type="password" name="current_password" id="cur_pass" class="form-control" required style="padding-right:40px;">
                            <button type="button" onclick="toggleVis('cur_pass','cur_eye')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;">
                                <i class="fas fa-eye" id="cur_eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password Baru <span class="required-star">*</span></label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="new_pass" class="form-control" required minlength="8" style="padding-right:40px;">
                            <button type="button" onclick="toggleVis('new_pass','new_eye')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;">
                                <i class="fas fa-eye" id="new_eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="required-star">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="alert alert-info" style="font-size:12px;">
                        <i class="fas fa-shield-halved mr-1"></i>
                        Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan terbaik.
                    </div>

                    <button type="submit" class="btn btn-sm btn-fluxa-primary">
                        <i class="fas fa-key mr-1"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function toggleVis(inputId, iconId) {
    const inp = document.getElementById(inputId);
    const ico = document.getElementById(iconId);
    const hidden = inp.type === 'password';
    inp.type = hidden ? 'text' : 'password';
    ico.classList.toggle('fa-eye', !hidden);
    ico.classList.toggle('fa-eye-slash', hidden);
}
</script>
@endpush
