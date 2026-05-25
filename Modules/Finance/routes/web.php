<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\ExpenseController;
use Modules\Finance\Http\Controllers\CashflowController;
use Modules\Finance\Http\Controllers\AnalyticsController;

Route::middleware(['auth'])->prefix('finance')->name('finance.')->group(function () {
    
    // Laporan & Analitik Dashboard
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Pengeluaran Operasional
    Route::resource('expenses', ExpenseController::class)->except(['show']);
    
    // Arus Kas Bulanan/Tahunan
    Route::get('cashflow', [CashflowController::class, 'index'])->name('cashflow.index');

});
