@extends('layouts.portal')

@section('title', 'Pelaporan Keuangan')
@section('page-title', 'Pelaporan Keuangan Negara')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pelaporan Keuangan</h3>
                <div class="ml-auto d-flex gap-2" style="gap: 10px;">
                    <form action="{{ route('statereport.financials.generate') }}" method="POST" onsubmit="return confirm('Sistem akan merekap semua Pemasukan & Pengeluaran tahun ini menjadi draf Laporan Keuangan. Lanjutkan?');">
                        @csrf
                        <input type="hidden" name="year" value="{{ date('Y') }}">
                        <button type="submit" class="btn btn-sm btn-fluxa-success">
                            <i class="fas fa-robot mr-1"></i> Generate Otomatis dari Sistem
                        </button>
                    </form>
                    <a href="{{ route('statereport.financials.create') }}" class="btn btn-sm btn-fluxa-primary">
                        <i class="fas fa-plus mr-1"></i> Buat Manual
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->year }}</td>
                                <td>{{ $report->period }}</td>
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
                                        <span class="text-muted"><i class="fas fa-times"></i></span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('statereport.financials.print', $report) }}" target="_blank" class="btn btn-icon btn-fluxa-primary" title="Cetak PDF">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('statereport.financials.edit', $report) }}" class="btn btn-icon btn-fluxa-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('statereport.financials.destroy', $report) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini?');">
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
                                <td colspan="5" class="empty-state">
                                    <div class="empty-state-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                                    <p class="mb-1">Belum ada data pelaporan keuangan.</p>
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
