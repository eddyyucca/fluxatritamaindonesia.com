@extends('layouts.portal')

@section('title', 'Buku Kas & Arus Kas')
@section('page-title', 'Arus Kas (Cashflow)')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="fluxa-stat mb-4">
            <div class="fluxa-stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <div class="fluxa-stat-label">Total Pemasukan (Paid Invoices)</div>
                <div class="fluxa-stat-value text-success" style="font-size: 20px;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="fluxa-stat mb-4">
            <div class="fluxa-stat-icon" style="background: #fef2f2; color: #dc2626;">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <div class="fluxa-stat-label">Total Pengeluaran</div>
                <div class="fluxa-stat-value text-danger" style="font-size: 20px;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="fluxa-stat mb-4">
            <div class="fluxa-stat-icon" style="background: #f0fdf4; color: #16a34a;">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <div class="fluxa-stat-label">Saldo / Laba Kotor</div>
                <div class="fluxa-stat-value" style="font-size: 20px;">Rp {{ number_format($balance, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ringkasan Bulanan Tahun {{ $currentYear }}</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th>Bulan</th>
                                <th class="text-right">Pemasukan (Rp)</th>
                                <th class="text-right">Pengeluaran (Rp)</th>
                                <th class="text-right">Net / Margin (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($m=1; $m<=12; $m++)
                                @php
                                    $inc = $incomesMonthly[$m] ?? 0;
                                    $exp = $expensesMonthly[$m] ?? 0;
                                    $net = $inc - $exp;
                                @endphp
                                @if($inc > 0 || $exp > 0)
                                <tr>
                                    <td>{{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}</td>
                                    <td class="text-right text-success">{{ number_format($inc, 0, ',', '.') }}</td>
                                    <td class="text-right text-danger">{{ number_format($exp, 0, ',', '.') }}</td>
                                    <td class="text-right" style="font-weight:bold; color: {{ $net >= 0 ? '#16a34a' : '#dc2626' }};">
                                        {{ number_format($net, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
