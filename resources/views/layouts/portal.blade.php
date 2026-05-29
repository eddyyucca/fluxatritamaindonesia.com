<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1e2a3a">
    <title>@yield('title', 'Portal') — PT Fluxa Tritama Indonesia</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    {{-- AdminLTE 3 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">

    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* ══════════════════════════════════════
           GLOBAL
        ══════════════════════════════════════ */
        * { font-family: 'Inter', sans-serif !important; }
        /* Restore FontAwesome icon font (overridden by wildcard above) */
        .fa, .fas, .far, .fal, .fab, .fad, .fat,
        [class^="fa-"], [class*=" fa-"],
        .fa-solid, .fa-regular, .fa-light, .fa-brands, .fa-thin, .fa-duotone,
        .nav-icon {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900;
        }
        .fab, .fa-brands { font-family: "Font Awesome 6 Brands" !important; font-weight: 400; }
        body.hold-transition .wrapper { transition: none !important; }

        /* ══════════════════════════════════════
           LOADING SCREEN
        ══════════════════════════════════════ */
        #loading-screen {
            position: fixed; inset: 0; z-index: 99999;
            background: #ffffff;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #loading-screen.fade-out { opacity: 0; visibility: hidden; }

        .ls-logo { height: 52px; margin-bottom: 28px; animation: lsPulse 1.8s ease-in-out infinite; }
        @keyframes lsPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.75;transform:scale(.97)} }

        .ls-spinner {
            width: 44px; height: 44px;
            border: 4px solid #e2e8f0;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: lsSpin 0.75s linear infinite;
        }
        @keyframes lsSpin { to { transform: rotate(360deg); } }

        .ls-bar-wrap {
            width: 160px; height: 3px;
            background: #e2e8f0; border-radius: 99px;
            margin-top: 20px; overflow: hidden;
        }
        .ls-bar {
            height: 100%; width: 0; border-radius: 99px;
            background: linear-gradient(90deg, #2563eb, #7c3aed);
            animation: lsBar 1.2s ease-in-out forwards;
        }
        @keyframes lsBar { 0%{width:0} 60%{width:80%} 100%{width:100%} }

        .ls-text {
            margin-top: 14px; font-size: 12px;
            font-weight: 500; color: #94a3b8; letter-spacing: .04em;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .main-sidebar, .main-sidebar::before {
            background: #1e2a3a !important;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15) !important;
        }
        .main-sidebar .brand-link {
            background: #19253300 !important;
            border-bottom: 1px solid rgba(255,255,255,0.07) !important;
            padding: 14px 16px !important;
        }
        .main-sidebar .brand-text { font-size: 14px !important; font-weight: 700 !important; color: #fff !important; letter-spacing: 0.02em !important; margin-left: 8px !important; }

        /* Nav items */
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link {
            color: rgba(148,163,184,0.85) !important;
            border-radius: 8px !important;
            margin: 1px 4px !important;
            font-size: 0.8rem !important;
            font-weight: 500 !important;
            transition: background 0.15s, color 0.15s !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.07) !important;
            color: #e2e8f0 !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(37,99,235,0.35) !important;
        }
        .nav-sidebar .nav-item > .nav-link .nav-icon {
            color: inherit !important; width: 1.4rem !important;
            font-size: 0.78rem !important; margin-right: 6px !important;
        }
        /* Sub-items */
        .sidebar-dark-primary .nav-treeview .nav-link {
            color: rgba(148,163,184,0.7) !important;
            font-size: 0.775rem !important;
            padding-left: 2.2rem !important;
        }
        .sidebar-dark-primary .nav-treeview .nav-link:hover { color: #e2e8f0 !important; }

        /* Nav section headers */
        .nav-header {
            color: #475569 !important;
            font-size: 0.6rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            padding: 14px 16px 4px !important;
        }

        /* User panel at bottom of sidebar */
        .sidebar-user-panel {
            border-top: 1px solid rgba(255,255,255,0.06) !important;
            padding: 10px 12px !important;
        }
        .user-avatar-circle {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
        }
        .user-name-text { font-size: 12px; font-weight: 600; color: #e2e8f0; }
        .user-role-badge {
            display: inline-block; font-size: 9px; font-weight: 700;
            padding: 1px 7px; border-radius: 99px; text-transform: uppercase; letter-spacing: .04em;
        }
        .user-role-director { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .user-role-staff    { background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; }
        .btn-logout {
            background: none; border: none; cursor: pointer; width: 100%;
            display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 8px;
            font-size: 11px; color: rgba(148,163,184,0.75); margin-top: 4px;
            transition: background 0.15s, color 0.15s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.12); color: #fca5a5; }

        /* ══════════════════════════════════════
           TOP NAVBAR
        ══════════════════════════════════════ */
        .main-header {
            background: #ffffff !important;
            border-bottom: 1px solid #e2e8f0 !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06) !important;
            z-index: 1030 !important;
        }
        .main-header .navbar-nav .nav-link { color: #64748b !important; }
        .page-title-text { font-size: 15px; font-weight: 700; color: #1e293b; line-height: 1.2; }
        .page-date-text  { font-size: 11px; color: #94a3b8; }

        /* ══════════════════════════════════════
           CONTENT AREA
        ══════════════════════════════════════ */
        .content-wrapper {
            background: #f1f5f9 !important;
            min-height: calc(100vh - 57px) !important;
        }
        .content-header { padding: 20px 24px 0 !important; }
        .content { padding: 16px 24px 24px !important; }

        /* ══════════════════════════════════════
           CARDS — custom white, elevated
        ══════════════════════════════════════ */
        .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06) !important;
        }
        .card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09) !important; transition: box-shadow 0.25s; }
        .card-header {
            background: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-radius: 12px 12px 0 0 !important;
            padding: 14px 20px !important;
        }
        .card-title { font-size: 14px !important; font-weight: 700 !important; color: #1e293b !important; }
        .card-body { padding: 20px !important; }
        .card-footer { background: #f8fafc !important; border-top: 1px solid #f1f5f9 !important; border-radius: 0 0 12px 12px !important; }

        /* Flat info-box (stat card) */
        .fluxa-stat {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .fluxa-stat:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .fluxa-stat-icon {
            width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .fluxa-stat-value { font-size: 26px; font-weight: 800; color: #1e293b; line-height: 1; }
        .fluxa-stat-label { font-size: 12px; color: #64748b; font-weight: 500; margin-top: 3px; }
        .fluxa-stat-sub   { font-size: 11px; color: #94a3b8; margin-top: 4px; }

        /* ══════════════════════════════════════
           TABLE
        ══════════════════════════════════════ */
        .table thead th {
            background: #f8fafc !important;
            color: #64748b !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: .06em !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-top: none !important;
            padding: 12px 16px !important;
        }
        .table tbody td {
            font-size: 13px !important;
            color: #334155 !important;
            padding: 12px 16px !important;
            vertical-align: middle !important;
            border-color: #f1f5f9 !important;
        }
        .table-hover tbody tr:hover { background: #f8fafc !important; }

        /* ══════════════════════════════════════
           BADGES — status pills
        ══════════════════════════════════════ */
        .pill { display:inline-block; padding:3px 10px; border-radius:99px; font-size:11px; font-weight:700; white-space:nowrap; }
        .pill-draft    { background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; }
        .pill-pending  { background:#fef9c3; color:#854d0e; border:1px solid #fde047; }
        .pill-approved { background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe; }
        .pill-paid     { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
        .pill-rejected { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }

        /* ══════════════════════════════════════
           BUTTONS
        ══════════════════════════════════════ */
        .btn { border-radius: 8px !important; font-weight: 600 !important; font-size: 13px !important; }
        .btn-sm { font-size: 12px !important; padding: 5px 12px !important; }
        .btn-xs { font-size: 11px !important; padding: 3px 10px !important; border-radius: 6px !important; }
        .btn-fluxa-primary { background: linear-gradient(135deg,#2563eb,#3b82f6) !important; color:#fff !important; border:none !important; box-shadow:0 2px 8px rgba(37,99,235,.3) !important; }
        .btn-fluxa-primary:hover { opacity: .9 !important; color:#fff !important; }
        .btn-fluxa-success { background: linear-gradient(135deg,#16a34a,#22c55e) !important; color:#fff !important; border:none !important; }
        .btn-fluxa-success:hover { opacity:.9 !important; color:#fff !important; }
        .btn-fluxa-danger  { background: linear-gradient(135deg,#dc2626,#ef4444) !important; color:#fff !important; border:none !important; }
        .btn-fluxa-danger:hover  { opacity:.9 !important; color:#fff !important; }
        .btn-fluxa-secondary { background:#fff !important; color:#475569 !important; border:1px solid #e2e8f0 !important; }
        .btn-fluxa-secondary:hover { background:#f8fafc !important; }

        /* Icon-only action buttons */
        .btn-icon { width:30px; height:30px; padding:0 !important; display:inline-flex !important; align-items:center; justify-content:center; border-radius:8px !important; font-size:12px !important; }

        /* ══════════════════════════════════════
           FORMS
        ══════════════════════════════════════ */
        .form-control, .form-select, select.form-control {
            border-radius: 8px !important;
            border: 1px solid #d1d5db !important;
            font-size: 13px !important;
            color: #1e293b !important;
            background: #fff !important;
            height: auto !important;
            padding: 9px 12px !important;
        }
        .form-control:focus { border-color: #2563eb !important; box-shadow: 0 0 0 3px rgba(37,99,235,.12) !important; outline: none !important; }
        .form-control[readonly] { background: #f8fafc !important; color: #94a3b8 !important; }
        .form-label, label { font-size: 12px !important; font-weight: 600 !important; color: #475569 !important; margin-bottom: 6px !important; }
        .required-star { color: #ef4444; }

        /* ══════════════════════════════════════
           ALERTS (inline)
        ══════════════════════════════════════ */
        .alert { border-radius: 10px !important; border: none !important; font-size: 13px !important; }
        .alert-success { background: #f0fdf4 !important; color: #166534 !important; border-left: 4px solid #22c55e !important; }
        .alert-danger  { background: #fff1f2 !important; color: #991b1b !important; border-left: 4px solid #ef4444 !important; }
        .alert-warning { background: #fffbeb !important; color: #92400e !important; border-left: 4px solid #f59e0b !important; }
        .alert-info    { background: #eff6ff !important; color: #1e40af !important; border-left: 4px solid #3b82f6 !important; }

        /* SweetAlert2 toast tweaks */
        .swal2-toast { border-radius: 12px !important; box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important; }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        .main-footer {
            background: #fff !important;
            border-top: 1px solid #e2e8f0 !important;
            color: #94a3b8 !important;
            font-size: 12px !important;
            padding: 10px 24px !important;
        }

        /* ══════════════════════════════════════
           WELCOME BANNER
        ══════════════════════════════════════ */
        .welcome-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
            border-radius: 14px; padding: 24px 28px;
            position: relative; overflow: hidden; color: #fff;
        }
        .welcome-banner::before {
            content: ''; position: absolute;
            top: -30px; right: -30px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }
        .welcome-banner::after {
            content: ''; position: absolute;
            bottom: -20px; right: 80px;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        /* ══════════════════════════════════════
           MISC
        ══════════════════════════════════════ */
        .no-print { }
        @media print { .no-print { display: none !important; } }

        /* Page transition */
        .content-wrapper { animation: contentFadeIn 0.25s ease; }
        @keyframes contentFadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }

        /* Empty state */
        .empty-state { text-align: center; padding: 56px 24px; }
        .empty-state-icon { width: 64px; height: 64px; border-radius: 16px; background: #f1f5f9; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #94a3b8; }
        .empty-state p { color: #64748b; font-size: 14px; }
        .empty-state small { color: #94a3b8; font-size: 12px; }        /* Custom Sidebar Size & Transparent Scrollbar */
        .sidebar .nav-link {
            font-size: 13.5px !important;
            padding: 6px 16px !important;
        }
        .sidebar .nav-header {
            font-size: 11px !important;
            padding: 10px 16px 4px 16px !important;
            letter-spacing: 0.5px;
            opacity: 0.7;
        }
        .sidebar .nav-icon {
            font-size: 14px !important;
        }
        
        /* Scrollbar Transparan untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">

{{-- ══ LOADING SCREEN ══ --}}
<div id="loading-screen">
    <img src="{{ asset('assets/images/FLUXATRITAMAINDONESIA.png') }}" alt="Fluxa" class="ls-logo">
    <div class="ls-spinner"></div>
    <div class="ls-bar-wrap"><div class="ls-bar"></div></div>
    <p class="ls-text">Memuat Portal...</p>
</div>

<div class="wrapper">

    {{-- ══ TOP NAVBAR ══ --}}
    <nav class="main-header navbar navbar-expand no-print">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars" style="color:#475569"></i>
                </a>
            </li>
            <li class="nav-item d-flex flex-column justify-content-center ml-1">
                <p class="page-title-text mb-0">@yield('page-title', 'Portal')</p>
                <p class="page-date-text mb-0">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @yield('topbar-actions')
            <li class="nav-item dropdown ml-2">
                <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" style="gap:10px; padding:0; cursor:pointer;" title="Profil & Pengaturan">
                    <div class="text-right d-none d-sm-block">
                        <p class="mb-0" style="font-size:13px; font-weight:600; color:#1e293b; line-height:1.2;">{{ Auth::user()->name }}</p>
                        <p class="mb-0" style="font-size:11px; color:#64748b;">{{ Auth::user()->isDirector() ? 'Director' : 'Staff' }}</p>
                    </div>
                    <span class="user-avatar-circle" style="width:36px;height:36px;font-size:14px;background:#e2e8f0;color:#475569;font-weight:700;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow-sm mt-2" style="border:1px solid #e2e8f0; border-radius:12px; padding:10px; min-width:220px;">
                    <div class="text-center py-2 mb-2" style="border-bottom:1px solid #f1f5f9;">
                        <span class="user-avatar-circle mx-auto mb-2" style="width:48px;height:48px;font-size:18px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <h6 class="mb-1" style="font-weight:700; font-size:14px; color:#1e293b;">{{ Auth::user()->name }}</h6>
                        <span class="user-role-badge {{ Auth::user()->isDirector() ? 'user-role-director' : 'user-role-staff' }}" style="font-size:10px; padding:2px 8px;">
                            {{ Auth::user()->isDirector() ? 'Director' : 'Staff' }}
                        </span>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="dropdown-item d-flex align-items-center" style="border-radius:6px; font-size:13px; color:#475569; padding:8px 12px; gap:8px;">
                        <i class="fas fa-user-pen" style="color:#94a3b8; font-size:12px;"></i> Edit Profil & Password
                    </a>
                    
                    <div class="dropdown-divider my-2 border-slate-100" style="border-color:#f1f5f9;"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center text-danger" style="border-radius:6px; font-size:13px; font-weight:500; padding:8px 12px; gap:8px;">
                            <i class="fas fa-arrow-right-from-bracket" style="font-size:12px;"></i> Keluar dari Sistem
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- ══ SIDEBAR ══ --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4 no-print">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/logo-white-transparent.png') }}"
                 alt="Fluxa" style="height:30px; opacity:.9;">
            <span class="brand-text">Fluxa App</span>
        </a>

        <div class="sidebar d-flex flex-column" style="height:calc(100% - 58px);">
            <nav class="mt-2 flex-grow-1 sidebar-scroll" style="overflow-y:auto; overflow-x:hidden;">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact text-sm" data-widget="treeview" data-accordion="false" style="padding-bottom: 20px;">

                    <!-- 1. Analitik & Dashboard -->
                    <li class="nav-header">Analitik & Dashboard</li>
                    <li class="nav-item">
                        <a href="{{ route('finance.analytics.index') }}" class="nav-link {{ request()->routeIs('finance.analytics.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Laporan & Analitik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Dashboard Utama</p>
                        </a>
                    </li>

                    <!-- 2. Operasional & Project -->
                    <li class="nav-header">Operasional & Project</li>
                    <li class="nav-item">
                        <a href="{{ route('project.index') }}" class="nav-link {{ request()->routeIs('project.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-diagram-project"></i>
                            <p>Project & Kanban</p>
                        </a>
                    </li>

                    <!-- Rekrutmen & HR -->
                    @if(Auth::user()->isDirector())
                    <li class="nav-header">Rekrutmen & HR</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.vacancies.index') }}" class="nav-link {{ request()->routeIs('admin.vacancies.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Kelola Lowongan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.applicants.index') }}" class="nav-link {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-viewfinder"></i>
                            <p>Kelola Pelamar</p>
                        </a>
                    </li>
                    @endif

                    <!-- 3. Aset & Lisensi -->
                    <li class="nav-header">Aset & Lisensi</li>
                    <li class="nav-item">
                        <a href="{{ route('license.index') }}" class="nav-link {{ request()->routeIs('license.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Pencatatan Lisensi</p>
                        </a>
                    </li>

                    <!-- 4. Billing & Kas -->
                    <li class="nav-header">Billing & Kas</li>
                    <li class="nav-item">
                        <a href="{{ route('billing.quotations.index') }}" class="nav-link {{ request()->routeIs('billing.quotations.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-contract"></i>
                            <p>Quotation
                            @if(Auth::user()->isDirector())
                                @php $pendingQ = \Illuminate\Support\Facades\DB::table('quotations')->where('status','sent')->count(); @endphp
                                @if($pendingQ > 0)
                                <span class="badge badge-warning right" style="font-size:10px;background:#d97706;color:#fff;border-radius:99px;padding:1px 6px;margin-left:4px;">{{ $pendingQ }}</span>
                                @endif
                            @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('billing.app_proposals.index') }}" class="nav-link {{ request()->routeIs('billing.app_proposals.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-laptop-code"></i>
                            <p>Proposal Aplikasi
                            @if(Auth::user()->isDirector())
                                @php $pendingP = \Illuminate\Support\Facades\DB::table('app_proposals')->where('status','sent')->count(); @endphp
                                @if($pendingP > 0)
                                <span class="badge badge-warning right" style="font-size:10px;background:#d97706;color:#fff;border-radius:99px;padding:1px 6px;margin-left:4px;">{{ $pendingP }}</span>
                                @endif
                            @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('billing.invoices.index') }}" class="nav-link {{ request()->routeIs('billing.invoices.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Invoice
                            @if(Auth::user()->isDirector())
                                @php $pendingI = \Illuminate\Support\Facades\DB::table('invoices')->where('status','pending_approval')->count(); @endphp
                                @if($pendingI > 0)
                                <span class="badge badge-warning right" style="font-size:10px;background:#dc2626;color:#fff;border-radius:99px;padding:1px 6px;margin-left:4px;">{{ $pendingI }}</span>
                                @endif
                            @endif
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.cashflow.index') }}" class="nav-link {{ request()->routeIs('finance.cashflow.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Arus Kas (Cashflow)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.expenses.index') }}" class="nav-link {{ request()->routeIs('finance.expenses.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Laporan & Analitik</p>
                        </a>
                    </li>

                    <li class="nav-header">Pelaporan Negara</li>
                    <li class="nav-item">
                        <a href="{{ route('statereport.financials.index') }}" class="nav-link {{ request()->routeIs('statereport.financials.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Pelaporan Keuangan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('statereport.taxes.index') }}" class="nav-link {{ request()->routeIs('statereport.taxes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>Pelaporan SPT</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('statereport.others.index') }}" class="nav-link {{ request()->routeIs('statereport.others.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>Laporan Lainnya</p>
                        </a>
                    </li>

                    <li class="nav-header">SDM & Organisasi</li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.organization') }}" class="nav-link {{ request()->routeIs('dashboard.organization*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>Struktur Organisasi</p>
                        </a>
                    </li>
                    @if(Auth::user()->isDirector())
                    <li class="nav-item">
                        <a href="{{ route('dashboard.users') }}" class="nav-link {{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelola Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.positions') }}" class="nav-link {{ request()->routeIs('dashboard.positions*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Master Jabatan</p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-header">Pengaturan</li>
                    <li class="nav-item">
                        <a href="{{ route('coming-soon', ['feature' => 'Pengaturan Sistem']) }}" class="nav-link">
                            <i class="nav-icon fas fa-gear"></i>
                            <p>Pengaturan Sistem</p>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </aside>

    {{-- ══ CONTENT WRAPPER ══ --}}
    <div class="content-wrapper">
        <section class="content" style="padding-top:20px;">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    {{-- ══ FOOTER ══ --}}
    <footer class="main-footer no-print">
        <strong>PT Fluxa Tritama Indonesia</strong> &copy; {{ date('Y') }}
        <span class="float-right text-muted" style="font-size:11px;">
            Portal Internal v2.0
        </span>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

{{-- ══ SCRIPTS ══ --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
// ── Loading screen ──────────────────────────────────────
window.addEventListener('load', function () {
    setTimeout(function () {
        var ls = document.getElementById('loading-screen');
        ls.classList.add('fade-out');
        setTimeout(function () { ls.style.display = 'none'; }, 520);
    }, 350);
});

// ── SweetAlert2 toast helper ───────────────────────────
function fluxaToast(icon, title, timer) {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer || 3800,
        timerProgressBar: true,
        showClass: { popup: 'swal2-show' },
        hideClass: { popup: 'swal2-hide' },
        customClass: { popup: 'fluxa-toast-popup' }
    });
}

// ── Flash messages as toasts ───────────────────────────
@if(session('success'))
    fluxaToast('success', '{{ addslashes(session("success")) }}');
@endif
@if(session('error'))
    fluxaToast('error', '{{ addslashes(session("error")) }}');
@endif
@if(session('warning'))
    fluxaToast('warning', '{{ addslashes(session("warning")) }}');
@endif

// ── Confirm dialog (data-confirm attribute) ────────────
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var self = this;
            var msg  = this.dataset.confirm || 'Apakah Anda yakin?';
            var icon = this.dataset.confirmIcon || 'warning';
            var confirmText = this.dataset.confirmBtn || 'Ya, Lanjutkan';
            Swal.fire({
                title: 'Konfirmasi',
                text: msg,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor:  '#94a3b8',
                confirmButtonText: '<i class="fas fa-check mr-1"></i>' + confirmText,
                cancelButtonText: 'Batal',
                buttonsStyling: true,
                customClass: { confirmButton: 'btn btn-sm', cancelButton: 'btn btn-sm' }
            }).then(function (result) {
                if (result.isConfirmed) self.submit();
            });
        });
    });
});
</script>

@stack('scripts')
</body>
</html>
