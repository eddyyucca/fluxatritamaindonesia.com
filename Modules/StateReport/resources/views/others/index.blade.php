@extends('layouts.portal')

@section('title', 'Laporan Ke Negara Lainnya')
@section('page-title', 'Pelaporan Lainnya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Laporan Lainnya</h3>
                <a href="{{ route('statereport.others.create') }}" class="btn btn-sm btn-fluxa-primary ml-auto">
                    <i class="fas fa-plus mr-1"></i> Tambah Laporan
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Laporan</th>
                                <th>Lembaga Tujuan</th>
                                <th>Tanggal Lapor</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td style="font-weight: 600;">{{ $report->title }}</td>
                                <td>{{ $report->institution }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->report_date)->isoFormat('D MMMM Y') }}</td>
                                <td>
                                    <span class="pill {{ $report->status == 'submitted' ? 'pill-approved' : ($report->status == 'draft' ? 'pill-draft' : 'pill-pending') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($report->file_path)
                                        <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="btn btn-xs btn-fluxa-secondary">
                                            <i class="fas fa-download mr-1"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('statereport.others.edit', $report) }}" class="btn btn-icon btn-fluxa-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('statereport.others.destroy', $report) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-fluxa-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                                    <p class="mb-1">Belum ada data pelaporan lainnya.</p>
                                    <small>Contoh: BPJS, LKPM, Laporan Disnaker.</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
