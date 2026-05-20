<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/users', [DashboardController::class, 'users'])->name('users');
        Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
        
        Route::get('/organization', [DashboardController::class, 'organization'])->name('organization');
        Route::get('/organization/edit', [DashboardController::class, 'editOrganization'])->name('organization.edit');
        Route::post('/organization', [DashboardController::class, 'updateOrganization'])->name('organization.update');
    });
});
