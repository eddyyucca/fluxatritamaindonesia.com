@extends('layouts.portal')
@section('title', 'Kelola Lowongan')
@section('page-title', 'Kelola Lowongan Kerja')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-briefcase text-primary mr-2"></i> Daftar Lowongan Pekerjaan</h3>
        <a href="{{ route('admin.vacancies.create') }}" class="btn btn-sm btn-fluxa-primary"><i class="fas fa-plus mr-1"></i> Buat Lowongan Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Posisi / Judul</th>
                        <th>Departemen</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Batas Waktu</th>
                        <th class="text-center">Pelamar</th>
                        <th class="text-center" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vacancies as $vacancy)
                    <tr>
                        <td>
                            <strong>{{ $vacancy->title }}</strong><br>
                            <small class="text-muted">Dibuat: {{ $vacancy->created_at->format('d M Y') }}</small>
                        </td>
                        <td>{{ $vacancy->department ?? '-' }}</td>
                        <td>{{ $vacancy->location ?? '-' }}</td>
                        <td>
                            @if($vacancy->status == 'open')
                                <span class="badge badge-success">Open</span>
                            @else
                                <span class="badge badge-secondary">Closed</span>
                            @endif
                        </td>
                        <td>
                            @if($vacancy->closing_date)
                                <span class="{{ \Carbon\Carbon::parse($vacancy->closing_date)->isPast() ? 'text-danger font-weight-bold' : 'text-primary' }}">
                                    {{ \Carbon\Carbon::parse($vacancy->closing_date)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $vacancy->applications->count() }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.applicants.index', ['vacancy_id' => $vacancy->id]) }}" class="btn btn-sm btn-fluxa-primary mr-1" title="Lihat Pelamar"><i class="fas fa-users"></i></a>
                            <a href="{{ route('admin.vacancies.edit', $vacancy->id) }}" class="btn btn-sm btn-fluxa-secondary mr-1"><i class="fas fa-edit"></i></a>
                            
                            <form action="{{ route('admin.vacancies.destroy', $vacancy->id) }}" method="POST" class="d-inline-block" data-confirm="Apakah Anda yakin ingin menghapus lowongan ini? Semua data pelamar di lowongan ini akan ikut terhapus.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-fluxa-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state-icon mx-auto"><i class="fas fa-box-open"></i></div>
                            <p class="mt-3 text-muted">Belum ada lowongan pekerjaan yang dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($vacancies->hasPages())
    <div class="card-footer">
        {{ $vacancies->links() }}
    </div>
    @endif
</div>
@endsection
