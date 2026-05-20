<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth', 'force_password_change'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Users
        Route::get('/users', [DashboardController::class, 'users'])->name('users');
        Route::get('/users/create', [DashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [DashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [DashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [DashboardController::class, 'updateUser'])->name('users.update');

        // Organization
        Route::get('/organization', [DashboardController::class, 'organization'])->name('organization');
        Route::get('/organization/edit', [DashboardController::class, 'editOrganization'])->name('organization.edit');
        Route::post('/organization', [DashboardController::class, 'updateOrganization'])->name('organization.update');

        // Positions (Master Data Jabatan)
        Route::get('/positions', [DashboardController::class, 'positions'])->name('positions');
        Route::post('/positions', [DashboardController::class, 'storePosition'])->name('positions.store');
        Route::put('/positions/{position}', [DashboardController::class, 'updatePosition'])->name('positions.update');
        Route::delete('/positions/{position}', [DashboardController::class, 'destroyPosition'])->name('positions.destroy');
    });
});
