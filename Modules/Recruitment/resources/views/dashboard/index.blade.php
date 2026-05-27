@extends('recruitment::dashboard.layout')
@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white mb-2 font-heading">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="text-slate-400">Pantau status lamaran Anda dan jelajahi lowongan terbaru.</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 p-4 rounded-xl mb-8 flex items-start gap-3">
            <i class="fas fa-check-circle mt-1"></i>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-4 rounded-xl mb-8 flex items-start gap-3">
            <i class="fas fa-exclamation-circle mt-1"></i>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Kolom Kiri: Riwayat Lamaran -->
        <div>
            <div class="glass p-6 rounded-2xl h-full">
                <h2 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4 font-heading">
                    <i class="fas fa-history text-blue-500 mr-2"></i> Riwayat Lamaran Saya
                </h2>

                @if($applications->count() > 0)
                    <div class="space-y-4">
                        @foreach($applications as $app)
                            <div class="bg-slate-800/40 border border-slate-700 rounded-xl p-4 hover:bg-slate-800/60 transition-all flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                <div>
                                    <h3 class="font-bold text-white">{{ $app->vacancy->title }}</h3>
                                    <div class="text-xs text-slate-400 mt-1">
                                        <i class="far fa-clock"></i> Dilamar pada {{ $app->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <div>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-500/20 text-amber-300 border-amber-500/30',
                                            'reviewed' => 'bg-blue-500/20 text-blue-300 border-blue-500/30',
                                            'interview' => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/30',
                                            'rejected' => 'bg-red-500/20 text-red-300 border-red-500/30',
                                            'hired' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Sedang Diproses',
                                            'reviewed' => 'Direview',
                                            'interview' => 'Wawancara',
                                            'rejected' => 'Ditolak',
                                            'hired' => 'Diterima'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border inline-block whitespace-nowrap {{ $statusColors[$app->status] ?? 'bg-slate-500/20 text-slate-300 border-slate-500/30' }}">
                                        {{ $statusLabels[$app->status] ?? ucfirst($app->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-800 border border-slate-700 text-slate-400 text-xl mb-3">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h3 class="font-bold text-white mb-1">Belum Ada Lamaran</h3>
                        <p class="text-slate-400 text-sm">Anda belum melamar pekerjaan apapun.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Lowongan Tersedia -->
        <div>
            <div class="glass p-6 rounded-2xl h-full">
                <h2 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4 font-heading flex justify-between items-center">
                    <span><i class="fas fa-briefcase text-blue-500 mr-2"></i> Lowongan Aktif</span>
                    <a href="{{ route('career.index') }}" class="text-xs text-blue-400 hover:text-blue-300">Lihat Semua</a>
                </h2>

                @if($vacancies->count() > 0)
                    <div class="space-y-4">
                        @foreach($vacancies->take(5) as $vacancy)
                            @php
                                $hasApplied = $applications->contains('job_vacancy_id', $vacancy->id);
                            @endphp
                            <div class="bg-slate-800/40 border border-slate-700 rounded-xl p-4 hover:bg-slate-800/60 transition-all flex flex-col sm:flex-row justify-between gap-4">
                                <div>
                                    <h3 class="font-bold text-white">{{ $vacancy->title }}</h3>
                                    <div class="text-xs text-slate-400 mt-1 flex gap-3">
                                        @if($vacancy->location)
                                            <span><i class="fas fa-map-marker-alt"></i> {{ $vacancy->location }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="sm:text-right">
                                    @if($hasApplied)
                                        <span class="text-xs text-emerald-400 bg-emerald-500/10 px-3 py-1.5 rounded-lg border border-emerald-500/20 inline-block"><i class="fas fa-check"></i> Sudah Dilamar</span>
                                    @else
                                        <a href="{{ route('career.show', $vacancy->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-4 rounded-lg transition-all shadow-lg shadow-blue-500/20 inline-block whitespace-nowrap">
                                            Lihat Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-400 text-sm">Belum ada lowongan pekerjaan saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
