<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karir - PT Fluxa Tritama Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #07111f; color: #cbd5e1; }
        .glass { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(12px); }
        .hov-card:hover { border-color: rgba(56,189,248,0.3); transform: translateY(-4px); }
    </style>
</head>
<body class="min-h-screen">
    
    <nav class="border-b border-white/10 px-5 sm:px-8 py-4 flex justify-between items-center bg-slate-900/50 sticky top-0 backdrop-blur-md z-50">
        <a href="/" class="text-white font-bold text-xl tracking-tight">FLUXA<span class="text-sky-400">KARIR</span></a>
        <div>
            @auth
                <a href="{{ route('career.dashboard') }}" class="bg-white/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition">Dashboard</a>
            @else
                <a href="{{ route('career.login') }}" class="text-sm font-semibold hover:text-white mr-4">Login</a>
                <a href="{{ route('career.register') }}" class="bg-gradient-to-r from-teal-400 to-sky-400 text-slate-900 px-4 py-2 rounded-lg text-sm font-bold hover:opacity-90 transition">Daftar</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-5 py-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4">Bergabunglah Bersama Kami</h1>
            <p class="text-slate-400 max-w-2xl mx-auto">Kami mencari individu berbakat dan bersemangat untuk membangun solusi digital terbaik. Temukan posisi yang cocok untuk Anda dan mulai karir cemerlang di PT Fluxa Tritama Indonesia.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Job 1 -->
            <div class="glass p-6 rounded-2xl hov-card transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs bg-teal-400/10 text-teal-300 px-2 py-1 rounded border border-teal-400/20 font-semibold uppercase tracking-wider">Teknologi</span>
                        <h2 class="text-xl font-bold text-white mt-2">Web Developer</h2>
                    </div>
                    <span class="text-slate-400 text-sm"><i class="fas fa-map-marker-alt mr-1"></i> Banjarmasin / WFA</span>
                </div>
                <p class="text-sm text-slate-400 mb-6 line-clamp-2">Bertanggung jawab mengembangkan aplikasi web menggunakan Laravel dan React/Vue. Pengalaman 1-3 tahun.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-sky-400">Full-Time</span>
                    <a href="{{ route('career.login') }}" class="border border-sky-400/50 text-sky-300 hover:bg-sky-400/10 px-4 py-2 rounded-lg text-sm font-semibold transition">Lamar Sekarang</a>
                </div>
            </div>

            <!-- Job 2 -->
            <div class="glass p-6 rounded-2xl hov-card transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs bg-blue-400/10 text-blue-300 px-2 py-1 rounded border border-blue-400/20 font-semibold uppercase tracking-wider">Infrastruktur</span>
                        <h2 class="text-xl font-bold text-white mt-2">Network Engineer</h2>
                    </div>
                    <span class="text-slate-400 text-sm"><i class="fas fa-map-marker-alt mr-1"></i> On-Site (Proyek)</span>
                </div>
                <p class="text-sm text-slate-400 mb-6 line-clamp-2">Melakukan instalasi, konfigurasi, dan troubleshooting perangkat jaringan LAN/WAN di lapangan.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-sky-400">Full-Time / Kontrak</span>
                    <a href="{{ route('career.login') }}" class="border border-sky-400/50 text-sky-300 hover:bg-sky-400/10 px-4 py-2 rounded-lg text-sm font-semibold transition">Lamar Sekarang</a>
                </div>
            </div>
            
            <!-- Job 3 -->
            <div class="glass p-6 rounded-2xl hov-card transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="text-xs bg-amber-400/10 text-amber-300 px-2 py-1 rounded border border-amber-400/20 font-semibold uppercase tracking-wider">Support</span>
                        <h2 class="text-xl font-bold text-white mt-2">IT Support</h2>
                    </div>
                    <span class="text-slate-400 text-sm"><i class="fas fa-map-marker-alt mr-1"></i> Banjarmasin</span>
                </div>
                <p class="text-sm text-slate-400 mb-6 line-clamp-2">Mendukung penyelesaian masalah teknis hardware dan software harian untuk klien kami.</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-sky-400">Full-Time</span>
                    <a href="{{ route('career.login') }}" class="border border-sky-400/50 text-sky-300 hover:bg-sky-400/10 px-4 py-2 rounded-lg text-sm font-semibold transition">Lamar Sekarang</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
