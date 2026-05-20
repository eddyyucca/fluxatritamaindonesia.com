@extends('layouts.portal')
@section('title', 'Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('topbar-actions')
<li class="nav-item d-flex align-items-center">
    <a href="{{ route('dashboard.users.create') }}" class="btn btn-sm btn-fluxa-primary">
        <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna
    </a>
</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center" style="gap:8px;">
            <i class="fas fa-users-gear" style="color:#2563eb;font-size:13px;"></i>
            <h6 class="card-title mb-0">Daftar Pengguna <span style="color:#94a3b8;font-weight:400;">({{ $users->count() }})</span></h6>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="d-none d-md-table-cell">Jabatan</th>
                        <th class="text-center">Peran</th>
                        <th class="d-none d-sm-table-cell">Bergabung</th>
                        <th style="width:110px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center" style="gap:10px;">
                                <div class="user-avatar-circle" style="width:32px;height:32px;font-size:12px;flex-shrink:0;">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span style="font-weight:600;color:#1e293b;">{{ $u->name }}</span>
                                    @if($u->id === Auth::id())
                                    <span style="font-size:9px;background:#dbeafe;color:#1e40af;padding:1px 6px;border-radius:99px;margin-left:4px;font-weight:700;">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color:#64748b;font-size:12px;">{{ $u->email }}</td>
                        <td class="d-none d-md-table-cell" style="color:#64748b;font-size:12px;">{{ $u->position ?? '—' }}</td>
                        <td class="text-center">
                            @if($u->isDirector())
                            <span class="pill" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;">Director</span>
                            @else
                            <span class="pill pill-draft">Staff</span>
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell" style="color:#94a3b8;font-size:12px;">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex" style="gap:4px;">
                                <a href="{{ route('users.reset-password', $u) }}" class="btn btn-icon btn-fluxa-secondary" title="Reset Password">
                                    <i class="fas fa-key" style="font-size:11px;color:#d97706;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
