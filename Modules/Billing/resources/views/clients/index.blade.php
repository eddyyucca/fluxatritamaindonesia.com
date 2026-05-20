@extends('layouts.portal')
@section('title', 'Klien')
@section('page-title', 'Manajemen Klien')

@section('topbar-actions')
<li class="nav-item d-flex align-items-center">
    <a href="{{ route('billing.clients.create') }}" class="btn btn-sm btn-fluxa-primary">
        <i class="fas fa-plus mr-1"></i> Tambah Klien
    </a>
</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center" style="gap:8px;">
        <i class="fas fa-building" style="color:#2563eb;"></i>
        <h6 class="card-title mb-0">
            Daftar Klien
            <span style="font-size:11px;font-weight:400;color:#94a3b8;">({{ $clients->count() }})</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Klien</th>
                        <th class="d-none d-sm-table-cell">Kota</th>
                        <th class="d-none d-md-table-cell">Kontak</th>
                        @if(Auth::user()->isDirector())
                        <th class="d-none d-lg-table-cell">Dibuat oleh</th>
                        @endif
                        <th class="d-none d-sm-table-cell">Tanggal</th>
                        <th style="width:80px;" class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center" style="gap:10px;">
                                <div style="width:34px;height:34px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-building" style="color:#2563eb;font-size:12px;"></i>
                                </div>
                                <div>
                                    <p style="font-weight:600;color:#334155;font-size:13px;margin:0;">{{ $client->name }}</p>
                                    @if($client->address)
                                    <p class="d-none d-md-block mb-0 text-truncate" style="font-size:11px;color:#94a3b8;max-width:280px;">
                                        {{ Str::limit($client->address, 55) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span style="font-size:13px;color:#475569;">{{ $client->city ?? '—' }}</span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <p style="font-size:12px;color:#475569;margin:0;">{{ $client->email ?? '—' }}</p>
                            <p style="font-size:11px;color:#94a3b8;margin:0;">{{ $client->phone ?? '' }}</p>
                        </td>
                        @if(Auth::user()->isDirector())
                        <td class="d-none d-lg-table-cell">
                            <span style="font-size:12px;color:#64748b;">{{ $client->creator->name ?? '—' }}</span>
                        </td>
                        @endif
                        <td class="d-none d-sm-table-cell">
                            <span style="font-size:12px;color:#94a3b8;">{{ $client->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="text-right">
                            <div class="d-flex align-items-center justify-content-end" style="gap:4px;">
                                <a href="{{ route('billing.clients.edit', $client) }}"
                                   class="btn btn-icon btn-fluxa-secondary" title="Edit">
                                    <i class="fas fa-pen-to-square" style="font-size:11px;"></i>
                                </a>
                                <form method="POST" action="{{ route('billing.clients.destroy', $client) }}"
                                      data-confirm="Hapus klien {{ addslashes($client->name) }}? Tindakan ini tidak dapat dibatalkan."
                                      data-confirm-icon="warning"
                                      data-confirm-btn="Ya, Hapus">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-fluxa-secondary" title="Hapus"
                                            style="color:#ef4444 !important;">
                                        <i class="fas fa-trash" style="font-size:11px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-building"></i></div>
                                <p>Belum ada data klien</p>
                                <small>Tambahkan klien pertama Anda</small><br>
                                <a href="{{ route('billing.clients.create') }}" class="btn btn-sm btn-fluxa-primary mt-3">
                                    <i class="fas fa-plus mr-1"></i> Tambah Klien
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
