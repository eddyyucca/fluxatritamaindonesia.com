@extends('layouts.portal')
@section('title', isset($client) ? 'Edit Klien' : 'Tambah Klien')
@section('page-title', isset($client) ? 'Edit Klien' : 'Tambah Klien')

@section('content')
<div class="mt-4 max-w-xl">
    <div class="card p-6">
        <form method="POST"
              action="{{ isset($client) ? route('billing.clients.update', $client) : route('billing.clients.store') }}">
            @csrf
            @if(isset($client)) @method('PUT') @endif

            @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nama Perusahaan / Klien <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $client->name ?? '') }}"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Alamat</label>
                    <textarea name="address" rows="3"
                              class="input-field w-full rounded-lg px-3 py-2 text-sm resize-none">{{ old('address', $client->address ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $client->city ?? '') }}"
                               class="input-field w-full rounded-lg px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}"
                               class="input-field w-full rounded-lg px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $client->email ?? '') }}"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm">
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="btn-primary text-white text-sm px-5 py-2 rounded-lg font-medium">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    {{ isset($client) ? 'Simpan Perubahan' : 'Tambah Klien' }}
                </button>
                <a href="{{ route('billing.clients.index') }}" class="text-slate-400 hover:text-slate-200 text-sm px-3 py-2 rounded-lg hover:bg-white/5 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
