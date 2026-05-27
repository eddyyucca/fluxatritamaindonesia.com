@extends('layouts.portal')
@section('title', 'Kelola Pelamar')
@section('page-title', 'Kelola Pelamar')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-users-viewfinder text-primary mr-2"></i> Daftar Lamaran Masuk</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Pelamar</th>
                        <th>Posisi</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Tanggal Submit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td>
                            <strong>{{ $app->user->name }}</strong><br>
                            <small class="text-muted">{{ $app->user->email }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $app->vacancy->title }}</span>
                            @if($app->expected_salary)
                                <br><small class="text-muted"><i class="fas fa-money-bill-wave text-success"></i> {{ $app->expected_salary }}</small>
                            @endif
                        </td>
                        <td>
                            <i class="fas fa-phone text-muted mr-1" style="font-size:10px;"></i> {{ optional($app->user->candidateProfile)->phone ?? '-' }}<br>
                            <small class="text-muted d-inline-block text-truncate" style="max-width: 150px;" title="{{ optional($app->user->candidateProfile)->address }}">{{ optional($app->user->candidateProfile)->address ?? '-' }}</small><br>
                            <button class="btn btn-xs btn-outline-info mt-1" data-toggle="modal" data-target="#detailModal{{ $app->id }}">Lihat Detail</button>
                            
                            <!-- Modal Detail Data Diri -->
                            <div class="modal fade" id="detailModal{{ $app->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pelamar: {{ $app->user->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Jenis Kelamin</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->gender ?? '-' }}</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Tanggal Lahir</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->date_of_birth ? \Carbon\Carbon::parse($app->user->candidateProfile->date_of_birth)->format('d M Y') : '-' }}</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Pendidikan Terakhir</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->education_level ?? '-' }} ({{ optional($app->user->candidateProfile)->major ?? '-' }})</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Universitas / Sekolah</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->university ?? '-' }}</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Pengalaman Kerja</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->experience_years ?? '0' }} Tahun</strong>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <small class="text-muted d-block">Keahlian (Skills)</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->skills ?? '-' }}</strong>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <small class="text-muted d-block">Alamat Lengkap</small>
                                                    <strong>{{ optional($app->user->candidateProfile)->address ?? '-' }}</strong>
                                                </div>
                                                @if($app->expected_salary)
                                                <div class="col-md-12 mb-3">
                                                    <small class="text-muted d-block">Ekspektasi Gaji</small>
                                                    <strong class="text-success">{{ $app->expected_salary }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            @if($app->cv_path)
                                                <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf mr-1"></i> Buka CV</a>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusBadge = [
                                    'pending' => 'badge-warning',
                                    'reviewed' => 'badge-primary',
                                    'interview' => 'badge-info',
                                    'rejected' => 'badge-danger',
                                    'hired' => 'badge-success'
                                ];
                                $statusLabel = [
                                    'pending' => 'Pending',
                                    'reviewed' => 'Direview',
                                    'interview' => 'Wawancara',
                                    'rejected' => 'Ditolak',
                                    'hired' => 'Diterima'
                                ];
                            @endphp
                            <span class="badge {{ $statusBadge[$app->status] ?? 'badge-secondary' }}">{{ $statusLabel[$app->status] ?? $app->status }}</span>
                        </td>
                        <td>{{ $app->created_at->format('d M Y, H:i') }}</td>
                        <td class="text-center">
                            @if($app->cv_path)
                                <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-fluxa-secondary mr-1" title="Lihat CV"><i class="fas fa-file-pdf text-danger"></i></a>
                            @endif
                            <button type="button" class="btn btn-sm btn-fluxa-primary" data-toggle="modal" data-target="#statusModal{{ $app->id }}" title="Ubah Status"><i class="fas fa-edit"></i></button>

                            <!-- Modal Ubah Status -->
                            <div class="modal fade" id="statusModal{{ $app->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Status Lamaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.applicants.update-status', $app->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-left">
                                                <p>Pelamar: <strong>{{ $app->user->name }}</strong><br><small>Posisi: {{ $app->vacancy->title }}</small></p>
                                                <div class="form-group">
                                                    <label>Pilih Status Baru</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="reviewed" {{ $app->status == 'reviewed' ? 'selected' : '' }}>Direview</option>
                                                        <option value="interview" {{ $app->status == 'interview' ? 'selected' : '' }}>Wawancara</option>
                                                        <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                                        <option value="hired" {{ $app->status == 'hired' ? 'selected' : '' }}>Diterima</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-fluxa-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm btn-fluxa-primary">Simpan Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state-icon mx-auto"><i class="fas fa-inbox"></i></div>
                            <p class="mt-3 text-muted">Belum ada pelamar yang masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($applications->hasPages())
    <div class="card-footer">
        {{ $applications->links() }}
    </div>
    @endif
</div>
@endsection
