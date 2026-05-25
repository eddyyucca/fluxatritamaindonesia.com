@extends('layouts.portal')

@section('title', 'Kanban - ' . $project->name)

@push('styles')
<style>
    .kanban-board {
        display: flex;
        overflow-x: auto;
        padding-bottom: 20px;
        min-height: calc(100vh - 200px);
    }
    .kanban-col {
        min-width: 300px;
        max-width: 300px;
        background: #f4f6f9;
        border-radius: 8px;
        padding: 15px;
        margin-right: 20px;
        display: flex;
        flex-direction: column;
    }
    .kanban-col-header {
        font-weight: bold;
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 2px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .kanban-tasks {
        flex-grow: 1;
        min-height: 50px;
    }
    .kanban-task {
        background: #fff;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        cursor: grab;
        border-left: 4px solid #3c8dbc;
    }
    .kanban-task:active { cursor: grabbing; }
    .col-todo { border-left-color: #6c757d !important; }
    .col-inprogress { border-left-color: #f39c12 !important; }
    .col-review { border-left-color: #00c0ef !important; }
    .col-done { border-left-color: #00a65a !important; }
    
    /* Dragging highlight */
    .sortable-ghost { opacity: 0.4; background: #e9ecef; }
</style>
@endpush

@section('content')
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <a href="{{ route('project.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-left"></i></a>
            <h1 class="m-0 d-inline-block" style="font-weight: 600;">{{ $project->name }}</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-primary rounded-pill" data-toggle="modal" data-target="#addTaskModal">
                <i class="fas fa-plus"></i> Tambah Tugas
            </button>
        </div>
    </div>

    <div class="kanban-board">
        <!-- TO DO -->
        <div class="kanban-col">
            <div class="kanban-col-header">
                <span>To Do</span>
                <span class="badge badge-secondary">{{ count($tasks['todo']) }}</span>
            </div>
            <div class="kanban-tasks" id="col-todo" data-status="todo">
                @foreach($tasks['todo'] as $t)
                    <div class="kanban-task col-todo" data-id="{{ $t->id }}">
                        <strong>{{ $t->title }}</strong>
                        @if($t->description)<p class="text-muted small mt-1 mb-0">{{ Str::limit($t->description, 50) }}</p>@endif
                        <div class="text-right mt-2">
                            <form action="{{ route('task.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- IN PROGRESS -->
        <div class="kanban-col">
            <div class="kanban-col-header">
                <span>In Progress</span>
                <span class="badge badge-warning">{{ count($tasks['in_progress']) }}</span>
            </div>
            <div class="kanban-tasks" id="col-in_progress" data-status="in_progress">
                @foreach($tasks['in_progress'] as $t)
                    <div class="kanban-task col-inprogress" data-id="{{ $t->id }}">
                        <strong>{{ $t->title }}</strong>
                        @if($t->description)<p class="text-muted small mt-1 mb-0">{{ Str::limit($t->description, 50) }}</p>@endif
                        <div class="text-right mt-2">
                            <form action="{{ route('task.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- REVIEW -->
        <div class="kanban-col">
            <div class="kanban-col-header">
                <span>Review</span>
                <span class="badge badge-info">{{ count($tasks['review']) }}</span>
            </div>
            <div class="kanban-tasks" id="col-review" data-status="review">
                @foreach($tasks['review'] as $t)
                    <div class="kanban-task col-review" data-id="{{ $t->id }}">
                        <strong>{{ $t->title }}</strong>
                        @if($t->description)<p class="text-muted small mt-1 mb-0">{{ Str::limit($t->description, 50) }}</p>@endif
                        <div class="text-right mt-2">
                            <form action="{{ route('task.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- DONE -->
        <div class="kanban-col">
            <div class="kanban-col-header">
                <span>Done</span>
                <span class="badge badge-success">{{ count($tasks['done']) }}</span>
            </div>
            <div class="kanban-tasks" id="col-done" data-status="done">
                @foreach($tasks['done'] as $t)
                    <div class="kanban-task col-done" data-id="{{ $t->id }}">
                        <strong>{{ $t->title }}</strong>
                        @if($t->description)<p class="text-muted small mt-1 mb-0">{{ Str::limit($t->description, 50) }}</p>@endif
                        <div class="text-right mt-2">
                            <form action="{{ route('task.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tugas?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Add Task -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:15px;">
                <form action="{{ route('task.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Buat Tugas Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Tugas</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="todo">To Do</option>
                                <option value="in_progress">In Progress</option>
                                <option value="review">Review</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const columns = document.querySelectorAll('.kanban-tasks');
        
        columns.forEach(col => {
            new Sortable(col, {
                group: 'shared', // set both lists to same group
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function (evt) {
                    let itemEl = evt.item;  // dragged HTMLElement
                    let toCol = evt.to;    // target list
                    
                    let taskId = itemEl.getAttribute('data-id');
                    let newStatus = toCol.getAttribute('data-status');
                    
                    // Ganti class border agar warnanya sesuai kolom baru
                    itemEl.classList.remove('col-todo', 'col-inprogress', 'col-review', 'col-done');
                    if(newStatus == 'todo') itemEl.classList.add('col-todo');
                    if(newStatus == 'in_progress') itemEl.classList.add('col-inprogress');
                    if(newStatus == 'review') itemEl.classList.add('col-review');
                    if(newStatus == 'done') itemEl.classList.add('col-done');

                    // Ajax call to update status
                    fetch(`/project/tasks/${taskId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Task moved successfully');
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        // Idealnya reload page jika error agar UI sinkron kembali
                    });
                },
            });
        });
    });
</script>
@endpush
