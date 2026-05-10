<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — PT Fluxa Tritama Indonesia</title>
    <meta name="theme-color" content="#07111f">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <style>
        body { background: #07111f; }

        .sidebar {
            background: rgba(255, 255, 255, 0.03);
            border-right: 1px solid rgba(255, 255, 255, 0.07);
        }

        .nav-item {
            color: rgba(148, 163, 184, 0.8);
            transition: background 0.15s, color 0.15s;
            border-radius: 8px;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(59, 130, 246, 0.12);
            color: #93c5fd;
        }

        .nav-item.active {
            border-left: 3px solid #3b82f6;
        }

        .card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .topbar {
            background: rgba(7, 17, 31, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(12px);
        }

        .avatar {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
        }

        .badge {
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.25);
            color: #93c5fd;
        }
    </style>
</head>
<body class="text-slate-300">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="sidebar w-64 flex-shrink-0 flex flex-col h-full">
        {{-- Logo --}}
        <div class="p-5 border-b border-white/5">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}"
                     alt="Fluxa" class="h-8 opacity-90">
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-xs text-slate-600 font-semibold uppercase tracking-widest mb-3 px-2">Menu</p>

            <a href="{{ route('dashboard') }}" class="nav-item active flex items-center gap-3 px-3 py-2.5 text-sm font-medium">
                <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm">
                <i class="fa-solid fa-users w-4 text-center"></i>
                <span>Pengguna</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm">
                <i class="fa-solid fa-file-lines w-4 text-center"></i>
                <span>Laporan</span>
            </a>
            <a href="#" class="nav-item flex items-center gap-3 px-3 py-2.5 text-sm">
                <i class="fa-solid fa-gear w-4 text-center"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        {{-- User info + Logout --}}
        <div class="p-4 border-t border-white/5">
            <div class="flex items-center gap-3 mb-3">
                <div class="avatar w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="topbar px-6 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-lg font-semibold text-white">Dashboard</h1>
                <p class="text-xs text-slate-500">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge text-xs px-3 py-1 rounded-full font-medium">
                    <i class="fa-solid fa-circle text-green-400 text-[6px] mr-1.5 align-middle"></i>Online
                </span>
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-200 text-sm transition-colors">
                    <i class="fa-solid fa-globe"></i>
                </a>
            </div>
        </header>

        {{-- Page body --}}
        <main class="flex-1 overflow-y-auto p-6">

            {{-- Welcome banner --}}
            <div class="card p-6 mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">
                        Halo, {{ explode(' ', $user->name)[0] }}! 👋
                    </h2>
                    <p class="text-slate-400 text-sm">Selamat datang kembali di panel admin PT Fluxa Tritama Indonesia.</p>
                </div>
                <div class="avatar w-14 h-14 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="stat-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">Total Pengguna</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-500/15 flex items-center justify-center">
                            <i class="fa-solid fa-users text-blue-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-white">—</p>
                    <p class="text-xs text-slate-500 mt-1">Data belum tersedia</p>
                </div>
                <div class="stat-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">Proyek Aktif</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-500/15 flex items-center justify-center">
                            <i class="fa-solid fa-diagram-project text-emerald-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-white">—</p>
                    <p class="text-xs text-slate-500 mt-1">Data belum tersedia</p>
                </div>
                <div class="stat-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">Laporan Bulan Ini</span>
                        <div class="w-9 h-9 rounded-lg bg-violet-500/15 flex items-center justify-center">
                            <i class="fa-solid fa-chart-line text-violet-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-white">—</p>
                    <p class="text-xs text-slate-500 mt-1">Data belum tersedia</p>
                </div>
                <div class="stat-card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">Klien</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center">
                            <i class="fa-solid fa-handshake text-amber-400 text-sm"></i>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-white">—</p>
                    <p class="text-xs text-slate-500 mt-1">Data belum tersedia</p>
                </div>
            </div>

            {{-- Info card --}}
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-slate-300 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-400"></i>
                    Informasi Akun
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 py-2 border-b border-white/5">
                        <span class="text-slate-500 text-sm w-28 flex-shrink-0">Nama</span>
                        <span class="text-slate-200 text-sm">{{ $user->name }}</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/5">
                        <span class="text-slate-500 text-sm w-28 flex-shrink-0">Email</span>
                        <span class="text-slate-200 text-sm">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 py-2">
                        <span class="text-slate-500 text-sm w-28 flex-shrink-0">Bergabung</span>
                        <span class="text-slate-200 text-sm">{{ $user->created_at->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>
