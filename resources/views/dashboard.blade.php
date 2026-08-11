@extends('layouts.app')

@section('header_title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-2">Ringkasan Performa</h2>
        <p class="text-slate-600">Pantau metrik utama dari seluruh data leads Anda di sini.</p>
    </div>

    <!-- KPI Cards Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Leads -->
        <div
            class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-slate-500 text-sm uppercase tracking-wider mb-2">Total Leads</h3>
            <span class="text-4xl font-black">{{ number_format($totalLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Conversion Rate -->
        <div
            class="bg-[#d8b4fe] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Conversion Rate</h3>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black">{{ $conversionRate }}</span>
                <span class="font-bold text-xl mb-1">%</span>
            </div>
        </div>

        <!-- Leads: Cool -->
        <div
            class="bg-[#93c5fd] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Cool</h3>
            <span class="text-4xl font-black">{{ number_format($coolLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Leads: Warm -->
        <div
            class="bg-[#fde047] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Warm</h3>
            <span class="text-4xl font-black">{{ number_format($warmLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Leads: Hot -->
        <div
            class="bg-[#fca5a5] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Hot</h3>
            <span class="text-4xl font-black">{{ number_format($hotLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Leads: Close (Won) -->
        <div
            class="bg-[#86efac] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Close / Won</h3>
            <span class="text-4xl font-black">{{ number_format($closeLeads, 0, ',', '.') }}</span>
        </div>

    </div>

    <!-- Filter Waktu & Judul Grafik -->
    <div class="mt-8 mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-bold">Grafik Analisis</h2>

        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
            <select name="range"
                class="p-2 text-sm font-bold border-2 border-black focus:outline-none focus:bg-slate-50 bg-white"
                onchange="this.form.submit()">
                <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                <option value="365" {{ $days == 365 ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
        </form>
    </div>

    <!-- Charts Container -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <!-- Chart 1: Status (Doughnut) -->
        <div class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
            <h3 class="font-bold text-center mb-4">Sebaran Status Leads</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Source (Bar) -->
        <div class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
            <h3 class="font-bold text-center mb-4">Performa Sumber Leads (Source)</h3>
            <div class="relative h-64 w-full">
                <canvas id="sourceChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Trend Waktu (Line) -->
        <div class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm lg:col-span-2">
            <h3 class="font-bold text-center mb-4">Tren Leads Masuk ({{ $days }} Hari Terakhir)</h3>
            <div class="relative h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Import CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Konfigurasi umum agar font cocok dengan tema
        Chart.defaults.font.family =
            'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
        Chart.defaults.color = '#000';

        // 1. Inisialisasi Chart Status (Doughnut)
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Cool', 'Warm', 'Hot', 'Close'],
                datasets: [{
                    data: [{{ $coolLeads }}, {{ $warmLeads }}, {{ $hotLeads }},
                        {{ $closeLeads }}
                    ],
                    backgroundColor: ['#93c5fd', '#fde047', '#fca5a5', '#86efac'], // Warna pastel tema kita
                    borderColor: '#000',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 2. Inisialisasi Chart Source (Bar)
        const ctxSource = document.getElementById('sourceChart').getContext('2d');
        const sourceLabels = {!! json_encode(array_keys($sourceData)) !!};
        const sourceData = {!! json_encode(array_values($sourceData)) !!};

        new Chart(ctxSource, {
            type: 'bar',
            data: {
                labels: sourceLabels,
                datasets: [{
                    label: 'Jumlah Leads',
                    data: sourceData,
                    backgroundColor: '#d8b4fe',
                    borderColor: '#000',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 3. Inisialisasi Chart Trend (Line)
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const trendLabels = {!! json_encode(array_keys($dateData)) !!};
        const trendData = {!! json_encode(array_values($dateData)) !!};

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Leads Masuk',
                    data: trendData,
                    backgroundColor: 'rgba(147, 197, 253, 0.5)',
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointBackgroundColor: '#000',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                }
            }
        });
    </script>
@endsection
