@extends('layouts.portal')
@section('title', 'Master Jabatan')
@section('page-title', 'Master Data Jabatan')

@section('content')
<div class="row">

    {{-- Form Tambah Jabatan --}}
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center" style="gap:8px;">
                <i class="fas fa-plus-circle" style="color:#2563eb;font-size:13px;"></i>
                <h6 class="card-title mb-0">Tambah Jabatan</h6>
            </div>
            <div class="card-body">
                @if($errors->has('name'))
                <div class="alert alert-danger" style="font-size:12px;">{{ $errors->first('name') }}</div>
                @endif
                <form method="POST" action="{{ route('dashboard.positions.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Jabatan <span class="required-star">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Mis: Marketing, Programmer..." required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Opsional">
                    </div>
                    <button type="submit" class="btn btn-sm btn-fluxa-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Jabatan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Jabatan --}}
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="gap:8px;">
                    <i class="fas fa-id-badge" style="color:#7c3aed;font-size:13px;"></i>
                    <h6 class="card-title mb-0">Daftar Jabatan <span style="color:#94a3b8;font-weight:400;">({{ $positions->count() }})</span></h6>
                </div>
            </div>
            <div class="card-body p-0">
                @if($positions->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-id-badge"></i></div>
                    <p>Belum ada jabatan</p>
                    <small>Tambahkan jabatan menggunakan form di samping</small>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Jabatan</th>
                                <th>Deskripsi</th>
                                <th class="text-center" style="width:80px;">Status</th>
                                <th style="width:100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($positions as $pos)
                            <tr>
                                <td style="font-weight:600;color:#1e293b;">{{ $pos->name }}</td>
                                <td style="color:#64748b;font-size:12px;">{{ $pos->description ?? '—' }}</td>
                                <td class="text-center">
                                    @if($pos->is_active)
                                    <span class="pill pill-paid">Aktif</span>
                                    @else
                                    <span class="pill pill-draft">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex" style="gap:4px;">
                                        <button class="btn btn-icon btn-fluxa-secondary" data-toggle="modal" data-target="#editModal{{ $pos->id }}" title="Edit">
                                            <i class="fas fa-pen" style="font-size:11px;"></i>
                                        </button>
                                        <form method="POST" action="{{ route('dashboard.positions.destroy', $pos) }}"
                                              data-confirm="Hapus jabatan '{{ $pos->name }}'?" data-confirm-icon="warning" data-confirm-btn="Ya, Hapus">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-fluxa-secondary" title="Hapus" style="color:#ef4444!important;">
                                                <i class="fas fa-trash" style="font-size:11px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editModal{{ $pos->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content" style="border-radius:12px;">
                                        <div class="modal-header" style="border-bottom:1px solid #f1f5f9;padding:16px 20px;">
                                            <h6 class="modal-title" style="font-weight:700;">Edit Jabatan</h6>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="POST" action="{{ route('dashboard.positions.update', $pos) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body" style="padding:20px;">
                                                <div class="form-group">
                                                    <label>Nama Jabatan <span class="required-star">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="{{ $pos->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <input type="text" name="description" class="form-control" value="{{ $pos->description }}">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="active{{ $pos->id }}" name="is_active" value="1" {{ $pos->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="active{{ $pos->id }}">Jabatan Aktif</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:12px 20px;">
                                                <button type="button" class="btn btn-sm btn-fluxa-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm btn-fluxa-primary"><i class="fas fa-save mr-1"></i>Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
