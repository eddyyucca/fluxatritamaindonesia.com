<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vacancy->title }} - Karir PT Fluxa Tritama Indonesia</title>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="relative overflow-x-hidden antialiased bg-slate-900">
    <div class="min-h-screen flex flex-col justify-between w-full">
        <div class="w-full flex-grow flex flex-col relative pb-10">
            <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-900/20 to-transparent pointer-events-none -z-10"></div>

            <!-- Navigation -->
            <nav class="glass sticky top-0 z-50 border-b border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="flex items-center gap-2">
                                <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-8">
                            </a>
                        </div>
                        <div class="flex items-center gap-4">
                            @auth
                                @if(Auth::user()->role === 'candidate')
                                    <a href="{{ route('career.dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard Saya</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Portal Admin</a>
                                @endif
                            @else
                                <a href="{{ route('career.login') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Login</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full flex-grow">
                
                <a href="{{ route('career.index') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium mb-6 inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Lowongan
                </a>

                @if(session('error'))
                    <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-300 p-4 rounded-xl flex items-start gap-3">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="glass rounded-2xl p-8 md:p-12 shadow-2xl shadow-blue-900/20">
                    <div class="flex justify-between items-start flex-col md:flex-row gap-6 mb-10 pb-10 border-b border-white/10">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 font-heading">{{ $vacancy->title }}</h1>
                            <div class="flex flex-wrap gap-3">
                                @if($vacancy->location)
                                    <span class="px-4 py-1.5 bg-slate-800/80 rounded-full text-sm text-slate-300 border border-slate-700 flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vacancy->location }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @auth
                            @if($hasApplied)
                                <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-400 px-6 py-3 rounded-xl font-semibold flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i> Anda Sudah Melamar
                                </div>
                            @else
                                <form action="{{ route('career.apply', $vacancy->id) }}" method="POST" class="w-full md:w-auto mt-4 md:mt-0">
                                    @csrf
                                    <div class="flex flex-col md:flex-row gap-3">
                                        <input type="text" id="expected_salary" name="expected_salary" required placeholder="Gaji yang diharapkan..." class="bg-slate-800/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 text-sm w-full md:w-64">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                                            <i class="fas fa-paper-plane"></i> Kirim Lamaran
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('career.login') }}" class="w-full md:w-auto mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-600/30 transition-all flex items-center justify-center gap-2 inline-flex">
                                <i class="fas fa-sign-in-alt"></i> Login untuk Melamar
                            </a>
                        @endauth
                    </div>

                    <div class="prose prose-invert max-w-none">
                        <h3 class="text-xl font-semibold mb-4 text-white font-heading">Deskripsi Pekerjaan</h3>
                        <div class="text-slate-300 mb-8 leading-relaxed">
                            {!! nl2br(e($vacancy->description)) !!}
                        </div>

                        <h3 class="text-xl font-semibold mb-4 text-white font-heading">Persyaratan</h3>
                        <div class="text-slate-300 leading-relaxed">
                            {!! nl2br(e($vacancy->requirements)) !!}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="w-full border-t border-white/10 bg-slate-900/50 py-8">
            <div class="text-center text-slate-400 text-sm">
                &copy; {{ date('Y') }} PT Fluxa Tritama Indonesia. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salaryInput = document.getElementById('expected_salary');
            if (salaryInput) {
                salaryInput.addEventListener('keyup', function(e) {
                    let value = this.value.replace(/[^,\d]/g, '').toString();
                    if (value === '') {
                        this.value = '';
                        return;
                    }
                    
                    let split = value.split(',');
                    let sisa = split[0].length % 3;
                    let rupiah = split[0].substr(0, sisa);
                    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                    
                    if (ribuan) {
                        let separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }
                    
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    this.value = 'Rp ' + rupiah;
                });
            }
        });
    </script>
</body>
</html>
