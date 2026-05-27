<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karir - PT Fluxa Tritama Indonesia</title>
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
        
        .job-card {
            transition: all 0.3s ease;
        }
        .job-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-900/20 to-transparent pointer-events-none -z-10"></div>
    <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none -z-10"></div>

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
                        <a href="{{ route('career.register') }}" class="text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full transition-all shadow-lg shadow-blue-500/30">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 font-heading">Bergabunglah Bersama <span class="gradient-text">Tim Kami</span></h1>
            <p class="text-lg md:text-xl text-slate-400 max-w-3xl mx-auto">Kami mencari talenta-talenta terbaik untuk ikut membangun masa depan teknologi bersama PT Fluxa Tritama Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vacancies as $vacancy)
                <div class="glass job-card rounded-2xl p-6 flex flex-col h-full">
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-white mb-2 font-heading">{{ $vacancy->title }}</h3>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($vacancy->location)
                                <span class="px-3 py-1 bg-slate-800/50 rounded-full text-xs text-slate-300 border border-slate-700 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt"></i> {{ $vacancy->location }}
                                </span>
                            @endif
                        </div>

                        <p class="text-slate-400 text-sm mb-6 line-clamp-3">
                            {{ Str::limit($vacancy->description, 120) }}
                        </p>
                    </div>
                    
                    <div class="mt-auto pt-4 border-t border-white/10 flex justify-between items-center">
                        <span class="text-xs text-slate-500"><i class="far fa-clock"></i> Diposting {{ $vacancy->created_at->diffForHumans() }}</span>
                        <a href="{{ route('career.show', $vacancy->id) }}" class="text-sm font-semibold text-blue-400 hover:text-blue-300 flex items-center gap-1 group">
                            Lihat Detail <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full glass rounded-2xl p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 border border-slate-700 text-slate-400 text-2xl mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum Ada Lowongan</h3>
                    <p class="text-slate-400">Saat ini belum ada lowongan pekerjaan yang dibuka. Silakan kembali lagi nanti.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-white/10 mt-auto bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-slate-400 text-sm">
            &copy; {{ date('Y') }} PT Fluxa Tritama Indonesia. All rights reserved.
        </div>
    </footer>
</body>
</html>
