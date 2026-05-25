<?php

use Illuminate\Support\Facades\Route;
use Modules\License\Http\Controllers\LicenseController;

Route::middleware(['auth'])->group(function () {
    Route::resource('license', LicenseController::class)->except(['show']);
});
