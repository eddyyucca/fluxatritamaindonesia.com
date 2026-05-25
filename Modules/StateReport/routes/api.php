<?php

use Illuminate\Support\Facades\Route;
use Modules\StateReport\Http\Controllers\StateReportController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('statereports', StateReportController::class)->names('statereport');
});
