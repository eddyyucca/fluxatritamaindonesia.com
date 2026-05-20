<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\App\Http\Controllers\WebController;

Route::middleware('web')->group(function () {
    Route::get('/', [WebController::class, 'index'])->name('home');
    
    Route::get('/coming-soon', function () {
        return view('coming-soon');
    })->name('coming-soon');
    
    Route::get('/company-profile', function () {
        return redirect()->route('coming-soon', ['feature' => 'Profil Perusahaan']);
    })->name('company-profile');
});
