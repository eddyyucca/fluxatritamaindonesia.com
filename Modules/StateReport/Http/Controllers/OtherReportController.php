<?php

namespace Modules\StateReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\StateReport\Models\OtherReport;
use Illuminate\Support\Facades\Storage;

class OtherReportController extends Controller
{
    public function index()
    {
        $reports = OtherReport::orderBy('created_at', 'desc')->get();
        return view('statereport::others.index', compact('reports'));
    }

    public function create()
    {
        return view('statereport::others.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'institution' => 'required',
            'report_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('other_reports', 'public');
        }

        OtherReport::create([
            'title' => $request->title,
            'institution' => $request->institution,
            'report_date' => $request->report_date,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
            'file_path' => $path
        ]);

        return redirect()->route('statereport.others.index')->with('success', 'Laporan Lainnya berhasil ditambahkan.');
    }

    public function edit(OtherReport $report)
    {
        return view('statereport::others.form', compact('report'));
    }

    public function update(Request $request, OtherReport $report)
    {
        $request->validate([
            'title' => 'required',
            'institution' => 'required',
            'report_date' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            $report->file_path = $request->file('file')->store('other_reports', 'public');
        }

        $report->update([
            'title' => $request->title,
            'institution' => $request->institution,
            'report_date' => $request->report_date,
            'status' => $request->status ?? 'draft',
            'notes' => $request->notes,
        ]);

        return redirect()->route('statereport.others.index')->with('success', 'Laporan Lainnya berhasil diperbarui.');
    }

    public function destroy(OtherReport $report)
    {
        if ($report->file_path) {
            Storage::disk('public')->delete($report->file_path);
        }
        $report->delete();
        return redirect()->route('statereport.others.index')->with('success', 'Laporan Lainnya berhasil dihapus.');
    }
}
