<?php

use Illuminate\Support\Facades\Route;
use Modules\Recruitment\Http\Controllers\CandidateAuthController;

Route::prefix('career')->group(function () {
    // Public Job List & Detail
    Route::get('/', [\Modules\Recruitment\Http\Controllers\PublicCareerController::class, 'index'])->name('career.index');
    Route::get('/job/{id}', [\Modules\Recruitment\Http\Controllers\PublicCareerController::class, 'show'])->name('career.show');
    Route::post('/job/{id}/apply', [\Modules\Recruitment\Http\Controllers\PublicCareerController::class, 'apply'])->name('career.apply')->middleware(['auth', 'verified']);

    // Guest Routes (Login & Register)
    Route::middleware('guest')->group(function () {
        Route::get('/register', [CandidateAuthController::class, 'showRegister'])->name('career.register');
        Route::post('/register', [CandidateAuthController::class, 'register']);
        Route::get('/login', [CandidateAuthController::class, 'showLogin'])->name('career.login');
        Route::post('/login', [CandidateAuthController::class, 'login']);
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [CandidateAuthController::class, 'logout'])->name('career.logout');

        // Email Verification Routes
        Route::get('/email/verify', [CandidateAuthController::class, 'notice'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [CandidateAuthController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
        Route::post('/email/verification-notification', [CandidateAuthController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');

        // Verified Candidate Routes
        Route::middleware('verified')->group(function () {
            Route::get('/dashboard', [\Modules\Recruitment\Http\Controllers\CandidateAuthController::class, 'dashboard'])->name('career.dashboard');
            Route::get('/profile', [\Modules\Recruitment\Http\Controllers\CandidateAuthController::class, 'profile'])->name('career.profile');
            Route::post('/profile/update', [\Modules\Recruitment\Http\Controllers\CandidateAuthController::class, 'updateProfile'])->name('career.profile.update');
            Route::get('/cv/{path}', [\Modules\Recruitment\Http\Controllers\CandidateAuthController::class, 'viewCv'])->where('path', '.*')->name('career.cv');
        });
    });
});

// Admin Routes (Kelola Pelamar & Lowongan)
Route::middleware(['web', 'auth', \App\Http\Middleware\ForcePasswordChange::class, \App\Http\Middleware\CheckDirector::class])->prefix('dashboard/recruitment')->name('admin.')->group(function () {
    Route::get('/applicants', [\Modules\Recruitment\Http\Controllers\AdminRecruitmentController::class, 'index'])->name('applicants.index');
    Route::put('/applicants/{id}/status', [\Modules\Recruitment\Http\Controllers\AdminRecruitmentController::class, 'updateStatus'])->name('applicants.update-status');
    Route::get('/applicants/cv/{path}', [\Modules\Recruitment\Http\Controllers\AdminRecruitmentController::class, 'viewCv'])->where('path', '.*')->name('applicants.cv');

    Route::resource('vacancies', \Modules\Recruitment\Http\Controllers\AdminJobVacancyController::class);
});
