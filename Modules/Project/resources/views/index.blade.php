@extends('layouts.portal')

@section('title', 'Daftar Project')

@section('content')
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h1 class="m-0" style="font-weight: 600;">Project Management</h1>
            <p class="text-muted mb-0">Kelola semua aktivitas operasional dan tugas proyek</p>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#addProjectModal">
                <i class="fas fa-plus"></i> Buat Project Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($projects as $p)
            <div class="col-md-4">
                <div class="card shadow-sm" style="border-radius: 12px; border: none; transition: transform 0.2s;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-bold"><a href="{{ route('project.kanban', $p->id) }}" class="text-dark">{{ $p->name }}</a></h5>
                            <form action="{{ route('project.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus project beserta semua task di dalamnya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0"><i class="fas fa-times"></i></button>
                            </form>
                        </div>
                        <p class="text-muted mb-3"><i class="far fa-clock"></i> Deadline: {{ $p->deadline ? $p->deadline->format('d M Y') : 'Tanpa Batas Waktu' }}</p>
                        
                        <a href="{{ route('project.kanban', $p->id) }}" class="btn btn-outline-primary btn-block rounded-pill">
                            Buka Papan Kanban <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/1086/1086504.png" width="100" class="mb-3 opacity-50">
                <h4 class="text-muted">Belum ada project</h4>
                <button class="btn btn-primary rounded-pill mt-2" data-toggle="modal" data-target="#addProjectModal">Buat Project Pertama Anda</button>
            </div>
        @endforelse
    </div>

    <!-- Modal Add Project -->
    <div class="modal fade" id="addProjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:15px;">
                <form action="{{ route('project.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Buat Project Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Project</label>
                            <input type="text" name="name" class="form-control" required placeholder="Contoh: Desain Website Klien X">
                        </div>
                        <div class="form-group">
                            <label>Deadline (Tenggat Waktu)</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Buat Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
