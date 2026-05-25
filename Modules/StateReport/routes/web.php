<?php

use Illuminate\Support\Facades\Route;
use Modules\StateReport\Http\Controllers\FinancialReportController;
use Modules\StateReport\Http\Controllers\TaxReturnController;
use Modules\StateReport\Http\Controllers\OtherReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->prefix('statereport')->name('statereport.')->group(function () {
    // Pelaporan Keuangan
    Route::post('financials/generate-auto', [FinancialReportController::class, 'generateAuto'])->name('financials.generate');
    Route::get('financials/{report}/print', [FinancialReportController::class, 'print'])->name('financials.print');
    Route::resource('financials', FinancialReportController::class)->except(['show'])->parameters(['financials' => 'report']);
    
    // Pelaporan SPT
    Route::post('taxes/generate-auto', [TaxReturnController::class, 'generateAuto'])->name('taxes.generate');
    Route::get('taxes/{report}/print', [TaxReturnController::class, 'print'])->name('taxes.print');
    Route::resource('taxes', TaxReturnController::class)->except(['show'])->parameters(['taxes' => 'report']);

    // Pelaporan Lainnya
    Route::resource('others', OtherReportController::class)->except(['show'])->parameters(['others' => 'report']);
});
