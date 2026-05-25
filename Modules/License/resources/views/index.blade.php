@extends('layouts.portal')

@section('title', 'Pencatatan Lisensi')

@section('content')
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h1 class="m-0" style="font-weight: 600;">Manajemen Lisensi & Layanan</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('license.create') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-plus"></i> Tambah Lisensi Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm" style="border-radius: 12px; border: none;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Siklus Tagihan</th>
                        <th>Tanggal Beli</th>
                        <th>Expired</th>
                        <th>Biaya / Harga</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($licenses as $lic)
                        <tr>
                            <td><strong>{{ $lic->name }}</strong></td>
                            <td>
                                @if($lic->billing_cycle == 'monthly') <span class="badge badge-info">Bulanan</span>
                                @elseif($lic->billing_cycle == 'yearly') <span class="badge badge-primary">Tahunan</span>
                                @else <span class="badge badge-secondary">Sekali Bayar</span> @endif
                            </td>
                            <td>{{ $lic->start_date->format('d M Y') }}</td>
                            <td>
                                @if($lic->expiry_date)
                                    <span class="{{ $lic->is_expiring ? 'text-danger font-weight-bold' : '' }}">
                                        {{ $lic->expiry_date->format('d M Y') }}
                                        @if($lic->is_expiring)
                                            <i class="fas fa-exclamation-triangle ml-1" title="Mendekati masa aktif"></i>
                                        @endif
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($lic->price, 0, ',', '.') }}</td>
                            <td>
                                @if($lic->expiry_date && $lic->expiry_date->isPast())
                                    <span class="badge badge-danger">Expired</span>
                                @else
                                    <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('license.edit', $lic->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('license.destroy', $lic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus lisensi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada pencatatan lisensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
