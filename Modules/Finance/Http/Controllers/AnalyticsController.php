<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Finance\Models\Expense;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');

        // 1. KEY METRICS (KARTU RINGKASAN)
        // Ambil data dari seluruh invoice lunas di tahun terkait
        $invoices = DB::table('invoices')
            ->where('status', 'paid')
            ->whereYear('invoice_date', $year)
            ->get();
            
        $expenses = Expense::whereYear('expense_date', $year)->get();

        $totalIncome = $invoices->sum('pt_profit_amount');
        $totalExpense = $expenses->sum('amount');
        $netProfit = $totalIncome - $totalExpense;
        $totalInvoicesCount = $invoices->count();

        // 2. DATA GRAFIK BATANG (PEMASUKAN VS PENGELUARAN PER BULAN)
        $monthlyIncome = array_fill(1, 12, 0);
        $monthlyExpense = array_fill(1, 12, 0);

        foreach ($invoices as $inv) {
            $month = (int) Carbon::parse($inv->invoice_date)->format('n');
            $monthlyIncome[$month] += $inv->pt_profit_amount;
        }

        foreach ($expenses as $exp) {
            $month = (int) Carbon::parse($exp->expense_date)->format('n');
            $monthlyExpense[$month] += $exp->amount;
        }

        // Siapkan array untuk dikirim ke Chart.js (indeks 0-11)
        $chartMonthlyIncome = array_values($monthlyIncome);
        $chartMonthlyExpense = array_values($monthlyExpense);

        // 3. DATA GRAFIK LINGKARAN (KATEGORI PENGELUARAN)
        $expenseCategories = $expenses->groupBy('category')->map(function ($row) {
            return $row->sum('amount');
        });
        
        $pieLabels = $expenseCategories->keys()->toArray();
        $pieData = $expenseCategories->values()->toArray();

        // Jika tidak ada data pengeluaran, hindari array kosong yang bikin chart error
        if (empty($pieLabels)) {
            $pieLabels = ['Belum ada pengeluaran'];
            $pieData = [0];
        }

        return view('finance::analytics.index', compact(
            'year',
            'totalIncome',
            'totalExpense',
            'netProfit',
            'totalInvoicesCount',
            'chartMonthlyIncome',
            'chartMonthlyExpense',
            'pieLabels',
            'pieData'
        ));
    }
}
