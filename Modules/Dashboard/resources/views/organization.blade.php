@extends('layouts.portal')
@section('title', 'Struktur Organisasi')
@section('page-title', 'Struktur Organisasi')

@section('topbar-actions')
    @if(Auth::user()->isDirector())
    <a href="{{ route('dashboard.organization.edit') }}" class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg font-medium flex items-center gap-1.5">
        <i class="fa-solid fa-pen-to-square text-xs"></i> Edit Struktur
    </a>
    @endif
@endsection

@section('content')
<div class="mt-4">
    <div class="card overflow-hidden p-6">
        @if($topLevelUsers->isEmpty())
            <p class="text-slate-500 text-sm">Struktur organisasi belum diatur.</p>
        @else
            <div class="org-tree">
                @foreach($topLevelUsers as $user)
                    @include('dashboard::_org_node', ['user' => $user])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
