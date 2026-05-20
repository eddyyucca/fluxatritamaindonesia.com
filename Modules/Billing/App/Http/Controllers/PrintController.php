<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Billing\App\Models\Invoice;
use Modules\Billing\App\Models\Quotation;

class PrintController extends Controller
{
    public function invoice(Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user->isDirector() && $invoice->created_by !== $user->id) {
            abort(403);
        }
        $invoice->load(['client', 'creator', 'approver', 'items', 'quotation']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billing::invoices.print', compact('invoice'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('Invoice_' . str_replace('/', '_', $invoice->invoice_number) . '.pdf');
    }

    public function quotation(Quotation $quotation)
    {
        $user = Auth::user();
        if (!$user->isDirector() && $quotation->created_by !== $user->id) {
            abort(403);
        }
        $quotation->load(['client', 'creator', 'approver', 'items']);
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billing::quotations.print', compact('quotation'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('Quotation_' . str_replace('/', '_', $quotation->quotation_number) . '.pdf');
    }
}
