@extends('layouts.portal')
@section('title', 'Struktur Organisasi')
@section('page-title', 'Struktur Organisasi')

@section('topbar-actions')
    @if(Auth::user()->isDirector())
    <li class="nav-item">
        <a href="{{ route('dashboard.organization.edit') }}" class="btn btn-sm btn-fluxa-primary" style="display:flex;align-items:center;gap:6px;">
            <i class="fas fa-pen-to-square"></i> Edit Struktur
        </a>
    </li>
    @endif
@endsection

@section('content')
<style>
/* CSS untuk Bagan Struktur Organisasi */
.org-chart-container {
    width: 100%;
    overflow-x: auto;
    padding: 30px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
}
.org-tree {
    display: flex;
    justify-content: center;
    min-width: max-content;
}
.org-tree ul {
    padding-top: 24px;
    position: relative;
    display: flex;
    justify-content: center;
    gap: 16px;
    padding-left: 0;
    margin: 0;
}
.org-tree li {
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 24px 8px 0 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Garis konektor horizontal */
.org-tree li::before, .org-tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #cbd5e1;
    width: 50%;
    height: 24px;
    z-index: 1;
}
.org-tree li::after {
    right: auto;
    left: 50%;
    border-left: 2px solid #cbd5e1;
}

/* Hapus garis untuk node tunggal */
.org-tree li:only-child::after, .org-tree li:only-child::before {
    display: none;
}
.org-tree li:only-child {
    padding-top: 0;
}

/* Hapus garis lebih untuk anak pertama & terakhir */
.org-tree li:first-child::before, .org-tree li:last-child::after {
    border: 0 none;
}
/* Lengkungan garis */
.org-tree li:last-child::before {
    border-right: 2px solid #cbd5e1;
    border-radius: 0 6px 0 0;
}
.org-tree li:first-child::after {
    border-radius: 6px 0 0 0;
}

/* Garis vertikal ke bawah dari parent */
.org-tree ul ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 2px solid #cbd5e1;
    width: 0;
    height: 24px;
    transform: translateX(-50%);
    z-index: 1;
}

/* Kartu Node */
.org-node-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    transition: all 0.2s ease;
    min-width: 160px;
    max-width: 200px;
    text-align: center;
}
.org-node-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    border-color: #93c5fd;
}

/* Styling Avatar & Text */
.org-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.org-name {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px 0;
    line-height: 1.2;
}
.org-position {
    font-size: 12px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
}

/* Warna Level Hierarchy */
.level-1 .org-node-card { border-top: 4px solid #2563eb; }
.level-1 .org-avatar { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }

.level-2 .org-node-card { border-top: 4px solid #8b5cf6; }
.level-2 .org-avatar { background: linear-gradient(135deg, #a855f7, #6d28d9); }

.level-3 .org-node-card { border-top: 4px solid #f59e0b; }
.level-3 .org-avatar { background: linear-gradient(135deg, #fbbf24, #d97706); }

.level-4 .org-node-card { border-top: 4px solid #10b981; }
.level-4 .org-avatar { background: linear-gradient(135deg, #34d399, #047857); }

.level-5 .org-node-card { border-top: 4px solid #ef4444; }
.level-5 .org-avatar { background: linear-gradient(135deg, #f87171, #b91c1c); }

.level-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #334155;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 99px;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <p style="color:#64748b;font-size:14px;margin:0;">Visualisasi struktur hierarki perusahaan dari tingkat atas hingga bawah.</p>
</div>

<div class="org-chart-container">
    @if($topLevelUsers->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-sitemap text-slate-300" style="font-size:48px;margin-bottom:16px;"></i>
            <p style="color:#64748b;">Struktur organisasi belum diatur.</p>
        </div>
    @else
        <div class="org-tree">
            <ul>
                @foreach($topLevelUsers as $user)
                    @include('dashboard::_org_node', ['user' => $user])
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
