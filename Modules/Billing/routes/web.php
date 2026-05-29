<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\App\Http\Controllers\ClientController;
use Modules\Billing\App\Http\Controllers\QuotationController;
use Modules\Billing\App\Http\Controllers\AppProposalController;
use Modules\Billing\App\Http\Controllers\InvoiceController;
use Modules\Billing\App\Http\Controllers\VerifyController;
use Modules\Billing\App\Http\Controllers\PrintController;

// Public verification (no auth required)
Route::middleware('web')->group(function () {
    Route::get('/verify/q/{token}', [VerifyController::class, 'quotation'])->name('verify.quotation');
    Route::get('/verify/p/{token}', [VerifyController::class, 'app_proposal'])->name('verify.app_proposal');
    Route::get('/verify/i/{token}', [VerifyController::class, 'invoice'])->name('verify.invoice');
});

// Authenticated billing routes
Route::middleware(['web', 'auth', 'force_password_change'])->prefix('billing')->name('billing.')->group(function () {

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    // Quotations
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::get('/quotations/{quotation}/edit', [QuotationController::class, 'edit'])->name('quotations.edit');
    Route::put('/quotations/{quotation}', [QuotationController::class, 'update'])->name('quotations.update');
    Route::post('/quotations/{quotation}/submit', [QuotationController::class, 'submit'])->name('quotations.submit');
    Route::post('/quotations/{quotation}/approve', [QuotationController::class, 'approve'])->name('quotations.approve');
    Route::post('/quotations/{quotation}/reject', [QuotationController::class, 'reject'])->name('quotations.reject');
    Route::post('/quotations/{quotation}/revert', [QuotationController::class, 'revert'])->name('quotations.revert');
    Route::post('/quotations/{quotation}/to-invoice', [InvoiceController::class, 'storeFromQuotation'])->name('quotations.to-invoice');
    Route::delete('/quotations/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');

    // App Proposals
    Route::get('/app-proposals', [AppProposalController::class, 'index'])->name('app_proposals.index');
    Route::get('/app-proposals/create', [AppProposalController::class, 'create'])->name('app_proposals.create');
    Route::post('/app-proposals', [AppProposalController::class, 'store'])->name('app_proposals.store');
    Route::get('/app-proposals/{app_proposal}', [AppProposalController::class, 'show'])->name('app_proposals.show');
    Route::get('/app-proposals/{app_proposal}/edit', [AppProposalController::class, 'edit'])->name('app_proposals.edit');
    Route::put('/app-proposals/{app_proposal}', [AppProposalController::class, 'update'])->name('app_proposals.update');
    Route::post('/app-proposals/{app_proposal}/submit', [AppProposalController::class, 'submit'])->name('app_proposals.submit');
    Route::post('/app-proposals/{app_proposal}/approve', [AppProposalController::class, 'approve'])->name('app_proposals.approve');
    Route::post('/app-proposals/{app_proposal}/reject', [AppProposalController::class, 'reject'])->name('app_proposals.reject');
    Route::post('/app-proposals/{app_proposal}/revert', [AppProposalController::class, 'revert'])->name('app_proposals.revert');
    Route::delete('/app-proposals/{app_proposal}', [AppProposalController::class, 'destroy'])->name('app_proposals.destroy');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::post('/invoices/{invoice}/submit', [InvoiceController::class, 'submit'])->name('invoices.submit');
    Route::post('/invoices/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoices.approve');
    Route::post('/invoices/{invoice}/reject', [InvoiceController::class, 'reject'])->name('invoices.reject');
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'addPayment'])->name('invoices.payment');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    // Print views
    Route::get('/invoices/{invoice}/print', [PrintController::class, 'invoice'])->name('invoices.print');
    Route::get('/quotations/{quotation}/print', [PrintController::class, 'quotation'])->name('quotations.print');
    Route::get('/app-proposals/{app_proposal}/print', [PrintController::class, 'app_proposal'])->name('app_proposals.print');

});
