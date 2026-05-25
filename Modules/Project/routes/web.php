<?php

use Illuminate\Support\Facades\Route;
use Modules\Project\Http\Controllers\ProjectController;
use Modules\Project\Http\Controllers\TaskController;

Route::middleware(['auth'])->group(function () {
    Route::resource('project', ProjectController::class)->except(['show', 'edit', 'update']);
    Route::get('project/{id}/kanban', [ProjectController::class, 'kanban'])->name('project.kanban');
    
    Route::post('task', [TaskController::class, 'store'])->name('task.store');
    Route::delete('task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::patch('project/tasks/{id}/status', [TaskController::class, 'updateStatus'])->name('task.updateStatus');
});
