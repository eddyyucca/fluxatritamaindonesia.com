<?php

namespace Modules\StateReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\StateReport\Models\TaxReturn;
use Illuminate\Support\Facades\Storage;

class TaxReturnController extends Controller
{
    public function index()
    {
        $reports = TaxReturn::orderBy('created_at', 'desc')->get();
        return view('statereport::taxes.index', compact('reports'));
    }

    public function create()
    {
        return view('statereport::taxes.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax_type' => 'required',
            'year' => 'required',
            'period' => 'required',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('tax_returns', 'public');
        }

        TaxReturn::create([
            'tax_type' => $request->tax_type,
            'year' => $request->year,
            'period' => $request->period,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
            'file_path' => $path
        ]);

        return redirect()->route('statereport.taxes.index')->with('success', 'Pelaporan SPT berhasil ditambahkan.');
    }

    public function edit(TaxReturn $report)
    {
        return view('statereport::taxes.form', compact('report'));
    }

    public function update(Request $request, TaxReturn $report)
    {
        $request->validate([
            'tax_type' => 'required',
            'year' => 'required',
            'period' => 'required',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            $report->file_path = $request->file('file')->store('tax_returns', 'public');
        }

        $report->update([
            'tax_type' => $request->tax_type,
            'year' => $request->year,
            'period' => $request->period,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
        ]);

        return redirect()->route('statereport.taxes.index')->with('success', 'Pelaporan SPT berhasil diperbarui.');
    }

    public function destroy(TaxReturn $report)
    {
        if ($report->file_path) {
            Storage::disk('public')->delete($report->file_path);
        }
        $report->delete();
        return redirect()->route('statereport.taxes.index')->with('success', 'Pelaporan SPT berhasil dihapus.');
    }

    public function print(TaxReturn $report)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('statereport::taxes.print', compact('report'));
        return $pdf->stream('Laporan_SPT_'.$report->tax_type.'_'.$report->year.'.pdf');
    }

    public function generateAuto(\Illuminate\Http\Request $request)
    {
        $year = $request->year ?? date('Y');
        
        // Pemasukan = pt_profit_amount
        $invoices = \Illuminate\Support\Facades\DB::table('invoices')
                        ->where('status', 'paid')
                        ->whereYear('invoice_date', $year)
                        ->get();
                        
        $totalPendapatanPT = $invoices->sum('pt_profit_amount');
        
        // PPN Keluaran: 11% dari Pendapatan PT
        $ppnKeluaran = $totalPendapatanPT * 0.11;

        // PPN Masukan: dari seluruh expenses yang punya pajak
        $expenses = \Modules\Finance\Models\Expense::whereYear('expense_date', $year)
                        ->where('has_tax', true)
                        ->get();
        $ppnMasukan = $expenses->sum('tax_amount');
                        
        $pajakKurangBayar = $ppnKeluaran - $ppnMasukan;

        $notes = "--- RINCIAN DASAR PENGENAAN PAJAK ---\n";
        if($invoices->count() > 0) {
            foreach($invoices as $inv) {
                $pajakInv = $inv->pt_profit_amount * 0.11;
                $notes .= "• " . $inv->invoice_number . " (Porsi PT: Rp " . number_format($inv->pt_profit_amount, 0, ',', '.') . ") -> PPN 11%: Rp " . number_format($pajakInv, 0, ',', '.') . "\n";
            }
        } else {
            $notes .= "Tidak ada data pemasukan untuk dikenakan pajak.\n";
        }

        $notes .= "\n--- RINCIAN PAJAK MASUKAN (PENGELUARAN) ---\n";
        if($expenses->count() > 0) {
            foreach($expenses as $exp) {
                $notes .= "• " . $exp->title . " -> Pajak Rp " . number_format($exp->tax_amount, 0, ',', '.') . "\n";
            }
        } else {
            $notes .= "Tidak ada data pajak masukan dari pengeluaran.\n";
        }

        $notes .= "\n======================================\n";
        $notes .= "Total Pendapatan Perusahaan : Rp " . number_format($totalPendapatanPT, 0, ',', '.') . "\n";
        $notes .= "PPN Keluaran (11% x Pendapatan) : Rp " . number_format($ppnKeluaran, 0, ',', '.') . "\n";
        $notes .= "PPN Masukan (Dari Pengeluaran) : Rp " . number_format($ppnMasukan, 0, ',', '.') . "\n";
        $notes .= "Total PPN Kurang/Lebih Bayar : Rp " . number_format($pajakKurangBayar, 0, ',', '.') . "\n";
        $notes .= "======================================";

        TaxReturn::create([
            'tax_type' => 'PPN',
            'year' => $year,
            'period' => 'Tahunan (Auto)',
            'status' => 'draft',
            'notes' => $notes,
            'file_path' => null
        ]);

        return redirect()->route('statereport.taxes.index')->with('success', 'Draf SPT PPN Tahun '.$year.' berhasil di-generate dengan rincian per-transaksi.');
    }
}
