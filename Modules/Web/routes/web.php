<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\App\Http\Controllers\WebController;

Route::middleware('web')->group(function () {
    Route::get('/', [WebController::class, 'index'])->name('home');
});
