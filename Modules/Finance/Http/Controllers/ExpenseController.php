<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Finance\Models\Expense;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->get();
        return view('finance::expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('finance::expenses.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'file' => 'nullable|file|mimes:jpeg,png,pdf|max:10240'
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('expenses', 'public');
        }

        Expense::create([
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'has_tax' => $request->has('has_tax'),
            'tax_amount' => $request->tax_amount ?? 0,
            'receipt_path' => $path,
            'notes' => $request->notes
        ]);

        return redirect()->route('finance.expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Expense $expense)
    {
        return view('finance::expenses.form', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
            'file' => 'nullable|file|mimes:jpeg,png,pdf|max:10240'
        ]);

        if ($request->hasFile('file')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $expense->receipt_path = $request->file('file')->store('expenses', 'public');
        }

        $expense->update([
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'has_tax' => $request->has('has_tax'),
            'tax_amount' => $request->tax_amount ?? 0,
            'notes' => $request->notes
        ]);

        return redirect()->route('finance.expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }
        $expense->delete();
        return redirect()->route('finance.expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
