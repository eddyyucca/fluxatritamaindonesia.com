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
        return view('billing::invoices.print', compact('invoice'));
    }

    public function quotation(Quotation $quotation)
    {
        $user = Auth::user();
        if (!$user->isDirector() && $quotation->created_by !== $user->id) {
            abort(403);
        }
        $quotation->load(['client', 'creator', 'approver', 'items']);
        return view('billing::quotations.print', compact('quotation'));
    }
}
