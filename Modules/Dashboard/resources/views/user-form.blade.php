@extends('layouts.portal')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div class="mt-4 max-w-lg">
    <div class="card p-6">
        <form method="POST" action="{{ route('dashboard.users.store') }}">
            @csrf

            @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Jabatan / Posisi</label>
                    <input type="text" name="position" value="{{ old('position') }}"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" placeholder="e.g. Web Developer">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Peran <span class="text-red-400">*</span></label>
                    <select name="role" class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Staff / User</option>
                        <option value="director" {{ old('role') === 'director' ? 'selected' : '' }}>Director</option>
                    </select>
                    <p class="text-slate-600 text-xs mt-1">Director dapat menyetujui/menolak invoice dan melihat semua data.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Password <span class="text-red-400">*</span></label>
                    <input type="password" name="password"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" required minlength="8">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Konfirmasi Password <span class="text-red-400">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="input-field w-full rounded-lg px-3 py-2 text-sm" required>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="btn-primary text-white text-sm px-5 py-2 rounded-lg font-medium">
                    <i class="fa-solid fa-user-plus mr-1.5"></i> Tambah Pengguna
                </button>
                <a href="{{ route('dashboard.users') }}" class="text-slate-400 hover:text-slate-200 text-sm px-3 py-2 rounded-lg hover:bg-white/5 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
