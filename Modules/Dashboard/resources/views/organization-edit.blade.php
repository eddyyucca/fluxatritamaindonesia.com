@extends('layouts.portal')
@section('title', 'Atur Struktur Organisasi')
@section('page-title', 'Pengaturan Struktur Organisasi')

@section('topbar-actions')
<a href="{{ route('dashboard.organization') }}" class="btn btn-sm btn-fluxa-secondary mr-2">
    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Bagan
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#fefce8;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-sitemap" style="color:#ca8a04;font-size:14px;"></i>
                </div>
                <div>
                    <h6 class="card-title mb-0">Atur Atasan dan Hierarki Level</h6>
                    <p style="font-size:11px;color:#94a3b8;margin-bottom:0;">Tentukan siapa melapor ke siapa, serta level organisasinya.</p>
                </div>
            </div>
            <div class="card-body p-0">
                <form action="{{ route('dashboard.organization.update') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="padding-left:20px;">Karyawan</th>
                                    <th>Jabatan Saat Ini</th>
                                    <th>Atasan Langsung (Melapor ke)</th>
                                    <th style="width:120px;padding-right:20px;">Level Org</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $u)
                                <tr>
                                    <td style="padding-left:20px;vertical-align:middle;">
                                        <div class="d-flex align-items-center" style="gap:10px;">
                                            <div class="user-avatar-circle" style="width:32px;height:32px;font-size:12px;">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="mb-0" style="font-weight:600;color:#1e293b;font-size:13px;">{{ $u->name }}</p>
                                                <input type="hidden" name="org_data[{{ $index }}][user_id]" value="{{ $u->id }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;color:#64748b;font-size:12px;">
                                        {{ $u->position ?? '—' }}
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <select name="org_data[{{ $index }}][parent_id]" class="form-control" style="font-size:13px;height:36px;">
                                            <option value="">-- Paling Atas (Tanpa Atasan) --</option>
                                            @foreach($users as $parent)
                                                @if($parent->id !== $u->id)
                                                    <option value="{{ $parent->id }}" {{ $u->parent_id == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->name }} ({{ $parent->position ?? '—' }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;padding-right:20px;">
                                        <input type="number" name="org_data[{{ $index }}][org_level]" value="{{ $u->org_level }}" class="form-control text-center" placeholder="1, 2, 3..." min="1" max="10" style="font-size:13px;height:36px;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right" style="padding:16px 20px;">
                        <button type="submit" class="btn btn-fluxa-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Struktur Organisasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
