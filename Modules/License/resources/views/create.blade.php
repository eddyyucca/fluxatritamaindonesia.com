@extends('layouts.portal')

@section('title', 'Tambah Lisensi')

@section('content')
    <div class="row mb-3 align-items-center">
        <div class="col-sm-12">
            <h1 class="m-0" style="font-weight: 600;">Tambah Lisensi Baru</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="border-radius: 12px; border: none; max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('license.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Layanan / Lisensi</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Domain Perusahaan, Adobe CC, dll" required>
                </div>
                
                <div class="form-group">
                    <label>Klien Terkait (Opsional)</label>
                    <select name="client_id" class="form-control">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Siklus Tagihan</label>
                        <select name="billing_cycle" class="form-control" required>
                            <option value="monthly">Bulanan</option>
                            <option value="yearly">Tahunan</option>
                            <option value="lifetime">Sekali Bayar (Lifetime)</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Harga / Biaya (Rp)</label>
                        <input type="number" name="price" class="form-control" value="0" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Tanggal Beli / Mulai</label>
                        <input type="date" name="start_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tanggal Kedaluwarsa (Expired)</label>
                        <input type="date" name="expiry_date" class="form-control">
                        <small class="text-muted">Kosongkan jika lifetime.</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Lisensi</button>
                    <a href="{{ route('license.index') }}" class="btn btn-light rounded-pill px-4 ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
