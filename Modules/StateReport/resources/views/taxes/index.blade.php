@extends('layouts.portal')

@section('title', 'Pelaporan SPT')
@section('page-title', 'Pelaporan Pajak (SPT)')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pelaporan SPT</h3>
                <div class="ml-auto d-flex gap-2" style="gap: 10px;">
                    <form action="{{ route('statereport.taxes.generate') }}" method="POST" onsubmit="return confirm('Sistem akan mengkalkulasi estimasi PPN Keluaran & Masukan untuk tahun ini. Lanjutkan?');">
                        @csrf
                        <input type="hidden" name="year" value="{{ date('Y') }}">
                        <button type="submit" class="btn btn-sm btn-fluxa-success">
                            <i class="fas fa-robot mr-1"></i> Generate Otomatis (PPN)
                        </button>
                    </form>
                    <a href="{{ route('statereport.taxes.create') }}" class="btn btn-sm btn-fluxa-primary">
                        <i class="fas fa-plus mr-1"></i> Lapor SPT
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Jenis Pajak</th>
                                <th>Masa / Periode</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>BPE / Dokumen</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td style="font-weight: 600;">{{ $report->tax_type }}</td>
                                <td>{{ $report->period }}</td>
                                <td>{{ $report->year }}</td>
                                <td>
                                    <span class="pill {{ $report->status == 'submitted' ? 'pill-approved' : ($report->status == 'draft' ? 'pill-draft' : 'pill-pending') }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($report->file_path)
                                        <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="btn btn-xs btn-fluxa-secondary">
                                            <i class="fas fa-download mr-1"></i> BPE
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('statereport.taxes.print', $report) }}" target="_blank" class="btn btn-icon btn-fluxa-primary" title="Cetak PDF">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('statereport.taxes.edit', $report) }}" class="btn btn-icon btn-fluxa-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('statereport.taxes.destroy', $report) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan SPT ini?');">
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
                                    <div class="empty-state-icon"><i class="fas fa-file-signature"></i></div>
                                    <p class="mb-1">Belum ada data pelaporan SPT.</p>
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
