<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Profile
        Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [AuthController::class, 'changePassword'])->name('profile.password');

        // Director: reset password pengguna lain
        Route::get('/users/{user}/reset-password', [AuthController::class, 'resetPasswordForm'])->name('users.reset-password');
        Route::put('/users/{user}/reset-password', [AuthController::class, 'resetPassword'])->name('users.reset-password.update');
    });
});
