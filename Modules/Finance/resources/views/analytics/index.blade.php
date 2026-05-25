@extends('layouts.portal')

@section('title', 'Laporan & Analitik')

@push('styles')
<style>
    /* Modern UI/UX Overhaul for Analytics Dashboard */
    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .analytics-title {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-weight: 800;
        font-size: 1.8rem;
        color: #1e293b;
        letter-spacing: -0.5px;
        margin: 0;
    }

    .year-selector {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 6px 16px;
        font-weight: 600;
        color: #475569;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
        outline: none;
        cursor: pointer;
    }
    .year-selector:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    /* Glassy Premium Cards */
    .metric-card {
        border-radius: 16px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }
    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .metric-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
        pointer-events: none;
    }

    /* Gradients */
    .bg-grad-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-grad-danger { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }
    .bg-grad-info { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); }
    .bg-grad-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .bg-grad-primary { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }

    .metric-title {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        opacity: 0.9;
    }
    .metric-value {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .metric-icon {
        position: absolute;
        right: -10px;
        bottom: -15px;
        font-size: 6rem;
        opacity: 0.15;
        transform: rotate(-15deg);
        transition: transform 0.3s ease;
    }
    .metric-card:hover .metric-icon { transform: rotate(0deg) scale(1.1); }

    /* Chart Cards */
    .chart-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 20px;
        margin-bottom: 24px;
        transition: box-shadow 0.3s ease;
    }
    .chart-card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08); }
    
    .chart-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }
    .chart-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .chart-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }
    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-red { background: #fef2f2; color: #ef4444; }

</style>
@endpush

@section('content')
    <!-- HEADER -->
    <div class="analytics-header">
        <h1 class="analytics-title">Laporan & Analitik Keuangan</h1>
        
        <form action="{{ route('finance.analytics.index') }}" method="GET" class="d-flex align-items-center">
            <span class="mr-2 text-muted" style="font-weight:600; font-size:14px;">Tahun Laporan:</span>
            <select name="year" class="year-selector" onchange="this.form.submit()">
                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- METRICS ROW -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="metric-card bg-grad-success">
                <p class="metric-title">Total Pemasukan (Profit)</p>
                <h4 class="metric-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                <i class="fas fa-chart-line metric-icon"></i>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="metric-card bg-grad-danger">
                <p class="metric-title">Total Pengeluaran</p>
                <h4 class="metric-value">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                <i class="fas fa-shopping-cart metric-icon"></i>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="metric-card {{ $netProfit >= 0 ? 'bg-grad-info' : 'bg-grad-warning' }}">
                <p class="metric-title">Laba / Rugi Bersih</p>
                <h4 class="metric-value">Rp {{ number_format($netProfit, 0, ',', '.') }}</h4>
                <i class="fas fa-wallet metric-icon"></i>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="metric-card bg-grad-primary">
                <p class="metric-title">Transaksi Lunas</p>
                <h4 class="metric-value">{{ $totalInvoicesCount }} <span style="font-size:1rem; font-weight:500;">Invoice</span></h4>
                <i class="fas fa-file-invoice-dollar metric-icon"></i>
            </div>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="row mt-2">
        <!-- Bar Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-icon icon-blue">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="chart-title">Arus Kas Bulanan ({{ $year }})</h3>
                </div>
                <div style="position: relative; height:320px; width:100%;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Pie Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-icon icon-red">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="chart-title">Distribusi Pengeluaran</h3>
                </div>
                <div style="position: relative; height:320px; width:100%;">
                    <canvas id="expensePieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
        Chart.defaults.color = '#64748b';

        // --- BAR CHART (Pemasukan vs Pengeluaran) ---
        var ctxBar = document.getElementById('monthlyChart').getContext('2d');
        var monthlyIncome = @json($chartMonthlyIncome);
        var monthlyExpense = @json($chartMonthlyExpense);
        
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan (Rp)',
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                        borderRadius: 6,
                        data: monthlyIncome
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        backgroundColor: 'rgba(244, 63, 94, 0.85)',
                        hoverBackgroundColor: 'rgba(244, 63, 94, 1)',
                        borderRadius: 6,
                        data: monthlyExpense
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false } },
                    y: { 
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8 } },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                }
            }
        });

        // --- PIE CHART (Distribusi Pengeluaran) ---
        var ctxPie = document.getElementById('expensePieChart').getContext('2d');
        var pieLabels = @json($pieLabels);
        var pieData = @json($pieData);
        
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [
                    {
                        data: pieData,
                        backgroundColor: [
                            '#3b82f6', '#f43f5e', '#10b981', '#f59e0b', '#8b5cf6', '#64748b'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
