@extends('layouts.portal')

@section('title', 'Daftar Pengeluaran')
@section('page-title', 'Pengeluaran (Expenses)')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Catatan Pengeluaran</h3>
                <a href="{{ route('finance.expenses.create') }}" class="btn btn-sm btn-fluxa-primary ml-auto">
                    <i class="fas fa-plus mr-1"></i> Catat Pengeluaran
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Nominal</th>
                                <th>Bukti</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $exp)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($exp->expense_date)->isoFormat('D MMM Y') }}</td>
                                <td><span class="pill pill-draft">{{ $exp->category }}</span></td>
                                <td style="font-weight:600;">{{ $exp->title }}</td>
                                <td>Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($exp->receipt_path)
                                        <a href="{{ Storage::url($exp->receipt_path) }}" target="_blank" class="text-primary"><i class="fas fa-file-invoice"></i> Lihat</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('finance.expenses.edit', $exp) }}" class="btn btn-icon btn-fluxa-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('finance.expenses.destroy', $exp) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pengeluaran ini?');">
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
                                    <div class="empty-state-icon"><i class="fas fa-receipt"></i></div>
                                    <p class="mb-1">Belum ada catatan pengeluaran.</p>
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
