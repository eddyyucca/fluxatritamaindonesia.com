<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal') — PT Fluxa Tritama Indonesia</title>
    <meta name="theme-color" content="#07111f">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <style>
        body { background: #07111f; }
        .sidebar { background: rgba(255,255,255,0.03); border-right: 1px solid rgba(255,255,255,0.07); }
        .nav-item { color: rgba(148,163,184,0.8); transition: background 0.15s, color 0.15s; border-radius: 8px; }
        .nav-item:hover { background: rgba(59,130,246,0.12); color: #93c5fd; }
        .nav-item.active { background: rgba(59,130,246,0.15); color: #93c5fd; border-left: 3px solid #3b82f6; }
        .nav-section { color: #475569; font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; padding: 0.5rem 0.5rem 0.25rem; }
        .card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; }
        .topbar { background: rgba(7,17,31,0.85); border-bottom: 1px solid rgba(255,255,255,0.07); backdrop-filter: blur(12px); }
        .avatar { background: linear-gradient(135deg,#1d4ed8,#7c3aed); }
        .badge-role { background: rgba(124,58,237,0.15); border: 1px solid rgba(124,58,237,0.3); color: #a78bfa; }
        .badge-director { background: rgba(234,179,8,0.15); border: 1px solid rgba(234,179,8,0.3); color: #fbbf24; }
        .stat-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius:12px; transition: border-color 0.2s, transform 0.2s; }
        .stat-card:hover { border-color: rgba(59,130,246,0.3); transform: translateY(-2px); }
        .btn-primary { background: linear-gradient(135deg,#1d4ed8,#3b82f6); transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.88; }
        .btn-success { background: linear-gradient(135deg,#065f46,#10b981); }
        .btn-danger  { background: linear-gradient(135deg,#7f1d1d,#ef4444); }
        .input-field { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color: #e2e8f0; transition: border-color 0.2s; }
        .input-field:focus { outline: none; border-color: #3b82f6; background: rgba(59,130,246,0.08); }
        .input-field::placeholder { color: rgba(148,163,184,0.45); }
        .table-row:hover { background: rgba(255,255,255,0.03); }
        .sidebar-collapsed { width: 4rem; }
        @media print { .no-print { display: none !important; } body { background: #fff !important; } }
    </style>
    @stack('styles')
</head>
<body class="text-slate-300">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="sidebar w-60 flex-shrink-0 flex flex-col h-full no-print">

        {{-- Logo --}}
        <div class="p-4 border-b border-white/5">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo-white-transparent.png') }}"
                     alt="Fluxa" class="h-7 opacity-90">
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">

            <p class="nav-section mt-1">Utama</p>
            <a href="{{ route('dashboard') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high w-4 text-center text-xs"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('dashboard.organization') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard.organization*') ? 'active' : '' }}">
                <i class="fa-solid fa-sitemap w-4 text-center text-xs"></i>
                <span>Struktur Organisasi</span>
            </a>

            <p class="nav-section mt-3">Dokumen</p>
            <a href="{{ route('billing.quotations.index') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm {{ request()->routeIs('billing.quotations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-contract w-4 text-center text-xs"></i>
                <span>Quotation</span>
            </a>
            <a href="{{ route('billing.quotations.create') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm pl-9 {{ request()->routeIs('billing.quotations.create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus w-4 text-center text-xs"></i>
                <span>Buat Quotation</span>
            </a>
            <a href="{{ route('billing.invoices.index') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm {{ request()->routeIs('billing.invoices.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar w-4 text-center text-xs"></i>
                <span>Invoice</span>
            </a>
            <a href="{{ route('billing.invoices.create') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm pl-9">
                <i class="fa-solid fa-plus w-4 text-center text-xs"></i>
                <span>Buat Invoice</span>
            </a>

            <p class="nav-section mt-3">Master Data</p>
            <a href="{{ route('billing.clients.index') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm {{ request()->routeIs('billing.clients.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building w-4 text-center text-xs"></i>
                <span>Klien</span>
            </a>

            @if(Auth::user()->isDirector())
            <p class="nav-section mt-3">Manajemen</p>
            <a href="{{ route('dashboard.users') }}"
               class="nav-item flex items-center gap-3 px-3 py-2 text-sm {{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear w-4 text-center text-xs"></i>
                <span>Pengguna</span>
            </a>
            @endif
        </nav>

        {{-- User info --}}
        <div class="p-3 border-t border-white/5">
            <div class="flex items-center gap-2.5 mb-2">
                <div class="avatar w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <span class="text-[10px] px-1.5 py-0.5 rounded {{ Auth::user()->isDirector() ? 'badge-director' : 'badge-role' }}">
                        {{ Auth::user()->isDirector() ? 'Director' : 'Staff' }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-1.5 text-xs text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="topbar px-6 py-3 flex items-center justify-between flex-shrink-0 no-print">
            <div>
                <h1 class="text-base font-semibold text-white">@yield('page-title', 'Portal')</h1>
                <p class="text-[11px] text-slate-500">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
            <div class="flex items-center gap-3">
                @yield('topbar-actions')
                <span class="text-[11px] px-2.5 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400">
                    <i class="fa-solid fa-circle text-green-400 text-[6px] mr-1 align-middle"></i>Online
                </span>
            </div>
        </header>

        {{-- Flash messages --}}
        <div class="px-6 pt-4 no-print">
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-3 text-sm text-emerald-300">
                    <i class="fa-solid fa-circle-check flex-shrink-0"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center gap-3 text-sm text-red-300">
                    <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>{{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
