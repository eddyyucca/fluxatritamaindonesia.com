@extends('recruitment::dashboard.layout')
@section('title', 'Data Diri & CV')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-2 font-heading">Data Diri & Curriculum Vitae</h1>
        <p class="text-slate-400">Lengkapi profil Anda agar perusahaan dapat menilai kualifikasi Anda dengan baik.</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 p-4 rounded-xl mb-8 flex items-start gap-3">
            <i class="fas fa-check-circle mt-1"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-4 rounded-xl mb-8">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('career.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="glass p-6 md:p-8 rounded-2xl mb-8">
            <h2 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4 font-heading">Informasi Dasar</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full bg-slate-800/30 border border-slate-700/50 rounded-xl px-4 py-3 text-slate-400 cursor-not-allowed">
                    <p class="text-xs text-slate-500 mt-1">Nama diambil dari akun pendaftaran.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <input type="text" value="{{ Auth::user()->email }}" disabled class="w-full bg-slate-800/30 border border-slate-700/50 rounded-xl px-4 py-3 text-slate-400 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" required class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Jenis Kelamin</label>
                    <select name="gender" required class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('gender', $profile->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $profile->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth) }}" required class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all [color-scheme:dark]">
                </div>
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Alamat Domisili Lengkap</label>
                <textarea name="address" required rows="3" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">{{ old('address', $profile->address) }}</textarea>
            </div>
        </div>

        <div class="glass p-6 md:p-8 rounded-2xl mb-8">
            <h2 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4 font-heading">Pendidikan & Pengalaman</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Pendidikan Terakhir</label>
                    <select name="education_level" required class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        <option value="">-- Pilih --</option>
                        <option value="SMA/SMK" {{ old('education_level', $profile->education_level) == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                        <option value="D3" {{ old('education_level', $profile->education_level) == 'D3' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                        <option value="D4/S1" {{ old('education_level', $profile->education_level) == 'D4/S1' ? 'selected' : '' }}>Sarjana (D4 / S1)</option>
                        <option value="S2" {{ old('education_level', $profile->education_level) == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Jurusan</label>
                    <input type="text" name="major" value="{{ old('major', $profile->major) }}" required placeholder="Misal: Teknik Informatika" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Nama Sekolah / Universitas</label>
                    <input type="text" name="university" value="{{ old('university', $profile->university) }}" required placeholder="Misal: Universitas Indonesia" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Total Pengalaman Kerja (Tahun)</label>
                    <input type="number" name="experience_years" min="0" value="{{ old('experience_years', $profile->experience_years) }}" required placeholder="0 untuk Fresh Graduate" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Keahlian (Skills)</label>
                <textarea name="skills" required rows="3" placeholder="Pisahkan dengan koma (misal: Laravel, React, Photoshop, dll)" class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">{{ old('skills', $profile->skills) }}</textarea>
            </div>
        </div>

        <div class="glass p-6 md:p-8 rounded-2xl mb-8">
            <h2 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4 font-heading">Dokumen Curriculum Vitae</h2>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-300 mb-2 required-star">Upload CV (PDF, Maksimal 5MB)</label>
                @if(isset($profile) && $profile->cv_path)
                    <div class="mb-4 p-4 bg-slate-800/80 rounded-xl flex justify-between items-center border border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-red-500/20 text-red-400 flex items-center justify-center">
                                <i class="fas fa-file-pdf text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">CV Tersimpan</p>
                                <p class="text-xs text-slate-400">File telah berhasil diunggah.</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium text-white transition-colors">
                            Lihat File
                        </a>
                    </div>
                @endif
                
                <div class="relative">
                    <input type="file" name="cv_file" accept=".pdf" class="w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer bg-slate-800/50 border border-slate-700 rounded-xl">
                </div>
                <p class="text-xs text-slate-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Biarkan kosong jika tidak ingin mengubah CV yang sudah diunggah sebelumnya.</p>
            </div>
        </div>

        <div class="flex justify-end mb-16">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2 text-lg">
                <i class="fas fa-save"></i> Simpan Data Diri
            </button>
        </div>
    </form>
@endsection
