<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Finance\Models\Expense;
use Modules\Billing\App\Models\Invoice; // Note: Invoices model in billing

class CashflowController extends Controller
{
    public function index()
    {
        // Get all paid invoices for income
        // We will assume "paid" is the status for fully paid invoices
        $totalIncome = DB::table('invoices')->where('status', 'paid')->sum('total');
        
        $totalExpense = Expense::sum('amount');
        
        $balance = $totalIncome - $totalExpense;

        // Get monthly data for the current year
        $currentYear = date('Y');
        
        $incomesMonthly = DB::table('invoices')
            ->selectRaw('MONTH(invoice_date) as month, SUM(total) as total')
            ->where('status', 'paid')
            ->whereYear('invoice_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();
            
        $expensesMonthly = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->whereYear('expense_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        return view('finance::cashflow.index', compact('totalIncome', 'totalExpense', 'balance', 'incomesMonthly', 'expensesMonthly', 'currentYear'));
    }
}
