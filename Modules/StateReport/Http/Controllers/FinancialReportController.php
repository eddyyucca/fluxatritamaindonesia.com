<?php

namespace Modules\StateReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\StateReport\Models\FinancialReport;
use Illuminate\Support\Facades\Storage;

class FinancialReportController extends Controller
{
    public function index()
    {
        $reports = FinancialReport::orderBy('created_at', 'desc')->get();
        return view('statereport::financials.index', compact('reports'));
    }

    public function create()
    {
        return view('statereport::financials.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'period' => 'required',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('financial_reports', 'public');
        }

        FinancialReport::create([
            'year' => $request->year,
            'period' => $request->period,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
            'file_path' => $path
        ]);

        return redirect()->route('statereport.financials.index')->with('success', 'Laporan Keuangan berhasil ditambahkan.');
    }

    public function edit(FinancialReport $report)
    {
        return view('statereport::financials.form', compact('report'));
    }

    public function update(Request $request, FinancialReport $report)
    {
        $request->validate([
            'year' => 'required',
            'period' => 'required',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            $report->file_path = $request->file('file')->store('financial_reports', 'public');
        }

        $report->update([
            'year' => $request->year,
            'period' => $request->period,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
        ]);

        return redirect()->route('statereport.financials.index')->with('success', 'Laporan Keuangan berhasil diperbarui.');
    }

    public function destroy(FinancialReport $report)
    {
        if ($report->file_path) {
            Storage::disk('public')->delete($report->file_path);
        }
        $report->delete();
        return redirect()->route('statereport.financials.index')->with('success', 'Laporan Keuangan berhasil dihapus.');
    }

    public function generateAuto(\Illuminate\Http\Request $request)
    {
        $year = $request->year ?? date('Y');
        
        $invoices = \Illuminate\Support\Facades\DB::table('invoices')
                        ->where('status', 'paid')
                        ->whereYear('invoice_date', $year)
                        ->get();
                        
        $expenses = \Modules\Finance\Models\Expense::whereYear('expense_date', $year)->get();

        $totalIncome = $invoices->sum('pt_profit_amount'); // Pendapatan perusahaan
        $totalExpense = $expenses->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        $notes = "--- RINCIAN PEMASUKAN (KEUNTUNGAN PT) ---\n";
        if($invoices->count() > 0) {
            foreach($invoices as $inv) {
                $notes .= "• " . $inv->invoice_number . " : Rp " . number_format($inv->pt_profit_amount, 0, ',', '.') . "\n";
            }
        } else {
            $notes .= "Tidak ada data pemasukan.\n";
        }

        $notes .= "\n--- RINCIAN PENGELUARAN ---\n";
        if($expenses->count() > 0) {
            foreach($expenses as $exp) {
                $notes .= "• [" . $exp->category . "] " . $exp->title . " : Rp " . number_format($exp->amount, 0, ',', '.') . "\n";
            }
        } else {
            $notes .= "Tidak ada data pengeluaran.\n";
        }

        $notes .= "\n======================================\n";
        $notes .= "Total Pemasukan Perusahaan : Rp " . number_format($totalIncome, 0, ',', '.') . "\n";
        $notes .= "Total Pengeluaran : Rp " . number_format($totalExpense, 0, ',', '.') . "\n";
        $notes .= "Laba Bersih : Rp " . number_format($netProfit, 0, ',', '.') . "\n";
        $notes .= "======================================";

        FinancialReport::create([
            'year' => $year,
            'period' => 'Tahunan (Auto)',
            'status' => 'draft',
            'notes' => $notes,
            'file_path' => null
        ]);

        return redirect()->route('statereport.financials.index')->with('success', 'Laporan Keuangan Tahun '.$year.' berhasil di-generate beserta detailnya.');
    }

    public function print(FinancialReport $report)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('statereport::financials.print', compact('report'));
        return $pdf->stream('Laporan_Keuangan_'.$report->year.'_'.$report->period.'.pdf');
    }
}

