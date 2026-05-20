<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Billing\App\Models\Invoice;
use Modules\Billing\App\Models\Quotation;

class VerifyController extends Controller
{
    public function quotation(string $token)
    {
        $quotation = Quotation::where('qr_token', $token)
            ->with(['client', 'creator', 'approver'])
            ->firstOrFail();

        return view('billing::verify', [
            'type'     => 'quotation',
            'document' => $quotation,
            'number'   => $quotation->quotation_number,
        ]);
    }

    public function invoice(string $token)
    {
        $invoice = Invoice::where('qr_token', $token)
            ->with(['client', 'creator', 'approver'])
            ->firstOrFail();

        return view('billing::verify', [
            'type'     => 'invoice',
            'document' => $invoice,
            'number'   => $invoice->invoice_number,
        ]);
    }
}
