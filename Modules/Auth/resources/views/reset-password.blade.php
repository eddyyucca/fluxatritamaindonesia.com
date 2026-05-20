@extends('layouts.portal')
@section('title', 'Reset Password — ' . $user->name)
@section('page-title', 'Reset Password Pengguna')

@section('topbar-actions')
<li class="nav-item d-flex align-items-center">
    <a href="{{ route('dashboard.users') }}" class="btn btn-sm btn-fluxa-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:10px;">
                <div class="user-avatar-circle" style="width:36px;height:36px;font-size:14px;flex-shrink:0;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h6 class="card-title mb-0">Reset Password</h6>
                    <p style="font-size:11px;color:#64748b;margin:0;">{{ $user->name }} · {{ $user->email }}</p>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" style="font-size:12px;">
                    <i class="fas fa-triangle-exclamation mr-1"></i>
                    Password lama akan langsung diganti. Beritahu pengguna password barunya.
                </div>

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3" style="font-size:13px;">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('users.reset-password.update', $user) }}">
                    @csrf
                    @method('PUT')

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

                    <button type="submit" class="btn btn-sm btn-fluxa-danger w-100">
                        <i class="fas fa-key mr-1"></i> Reset Password Sekarang
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
