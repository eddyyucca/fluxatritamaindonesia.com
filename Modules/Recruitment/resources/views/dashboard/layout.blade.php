<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelamar') - Karir PT Fluxa Tritama Indonesia</title>
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
    </style>
</head>
<body class="relative overflow-x-hidden antialiased bg-slate-900">
    <div class="min-h-screen w-full relative pb-[100px]">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-900/20 to-transparent pointer-events-none -z-10"></div>

        <!-- Navigation -->
        <nav class="glass sticky top-0 z-50 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('career.index') }}" class="flex items-center gap-2">
                            <img src="{{ asset('assets/images/logo-white-transparent.png') }}" alt="Fluxa" class="h-8">
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-300 hidden md:inline-block">Halo, {{ Auth::user()->name }}</span>
                        <form action="{{ route('career.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-400 hover:text-red-300 transition-colors flex items-center gap-1">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar -->
            <div class="w-full lg:w-64 flex-shrink-0">
                <div class="glass rounded-2xl p-4 sticky top-24">
                    <nav class="space-y-2">
                        <a href="{{ route('career.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('career.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <i class="fas fa-home w-5 text-center"></i>
                            <span class="font-medium text-sm">Dashboard</span>
                        </a>
                        <a href="{{ route('career.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('career.profile') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <i class="fas fa-user-circle w-5 text-center"></i>
                            <span class="font-medium text-sm">Data Diri (CV)</span>
                        </a>
                        <a href="{{ route('career.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-slate-400 hover:text-white hover:bg-white/5">
                            <i class="fas fa-search w-5 text-center"></i>
                            <span class="font-medium text-sm">Cari Lowongan</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-grow min-w-0">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="absolute bottom-0 left-0 w-full border-t border-white/10 bg-slate-900/50 h-[100px] flex items-center justify-center">
            <div class="text-center text-slate-400 text-sm">
                &copy; {{ date('Y') }} PT Fluxa Tritama Indonesia. All rights reserved.
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
