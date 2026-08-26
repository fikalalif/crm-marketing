@extends('layouts.app')

@section('header_title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-2 dark:text-white">Ringkasan Performa</h2>
        <p class="text-slate-600 dark:text-slate-400">Pantau metrik utama dari seluruh data leads Anda di sini.</p>
    </div>

    <!-- KPI Cards Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Leads -->
        <div
            class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm flex flex-col justify-between transition-colors duration-300">
            <h3 class="font-bold text-slate-500 dark:text-slate-300 text-sm uppercase tracking-wider mb-2">Total Leads</h3>
            <span class="text-4xl font-black dark:text-white">{{ number_format($totalLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Conversion Rate -->
        <div
            class="bg-[#d8b4fe] border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm flex flex-col justify-between transition-colors duration-300">
            <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Conversion Rate</h3>
            <div class="flex items-end gap-2 text-black">
                <span class="text-4xl font-black">{{ $conversionRate }}</span>
                <span class="font-bold text-xl mb-1">%</span>
            </div>
        </div>

        <!-- Looping Dinamis Status Leads -->
        @foreach ($statuses as $status)
            <div
                class="{{ $status->color }} border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm flex flex-col justify-between transition-colors duration-300">
                <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: {{ $status->name }}</h3>
                <span
                    class="text-4xl font-black text-black">{{ number_format($statusCounts[$status->id] ?? 0, 0, ',', '.') }}</span>
            </div>
        @endforeach

    </div>

    <!-- Filter Waktu & Judul Grafik -->
    <div class="mt-8 mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-bold dark:text-white">Grafik Analisis</h2>

        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
            <select name="range"
                class="p-2 text-sm font-bold border-2 border-black dark:border-white focus:outline-none bg-white dark:bg-slate-700 dark:text-white"
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

        <!-- Chart 1: Status (Doughnut) Dinamis -->
        <div
            class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
            <h3 class="font-bold text-center mb-4 dark:text-white">Sebaran Status Leads</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Source (Bar) -->
        <div
            class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
            <h3 class="font-bold text-center mb-4 dark:text-white">Performa Sumber Leads (Source)</h3>
            <div class="relative h-64 w-full">
                <canvas id="sourceChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Trend Waktu (Line) -->
        <div
            class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm lg:col-span-2 transition-colors duration-300">
            <h3 class="font-bold text-center mb-4 dark:text-white">Tren Leads Masuk ({{ $days }} Hari Terakhir)
            </h3>
            <div class="relative h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const initialDark = localStorage.getItem('theme') === 'dark';
        const getTextColor = (isDark) => isDark ? '#ffffff' : '#000000';
        const getGridColor = (isDark) => isDark ? '#334155' : '#e2e8f0';
        const getThemeBorder = (isDark) => isDark ? '#ffffff' : '#000000';

        Chart.defaults.font.family =
            'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
        Chart.defaults.color = getTextColor(initialDark);
        Chart.defaults.borderColor = getGridColor(initialDark);

        // Data Dinamis dari Database
        const dynamicStatusLabels = {!! json_encode($chartLabels) !!};
        const dynamicStatusData = {!! json_encode(array_values($statusCounts)) !!};
        const dynamicStatusColors = {!! json_encode($chartColors) !!};

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: dynamicStatusLabels,
                datasets: [{
                    data: dynamicStatusData,
                    backgroundColor: dynamicStatusColors, // Menggunakan hex color dari database
                    borderColor: getThemeBorder(initialDark),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: getTextColor(initialDark)
                        }
                    }
                }
            }
        });

        // Chart 2 (Source Bar)
        const ctxSource = document.getElementById('sourceChart').getContext('2d');
        const sourceLabels = {!! json_encode(array_keys($sourceData)) !!};
        const sourceData = {!! json_encode(array_values($sourceData)) !!};
        const sourceChart = new Chart(ctxSource, {
            type: 'bar',
            data: {
                labels: sourceLabels,
                datasets: [{
                    label: 'Jumlah Leads',
                    data: sourceData,
                    backgroundColor: ['#93c5fd', '#fca5a5', '#86efac', '#fde047', '#d8b4fe', '#fdba74'],
                    borderColor: getThemeBorder(initialDark),
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            color: getTextColor(initialDark)
                        },
                        grid: {
                            color: getGridColor(initialDark)
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: getTextColor(initialDark)
                        },
                        grid: {
                            color: getGridColor(initialDark)
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

        // Chart 3 (Trend Line)
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const trendLabels = {!! json_encode(array_keys($dateData)) !!};
        const trendData = {!! json_encode(array_values($dateData)) !!};
        const trendChart = new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Leads Masuk',
                    data: trendData,
                    backgroundColor: 'rgba(147, 197, 253, 0.5)',
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointBackgroundColor: getThemeBorder(initialDark),
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            color: getTextColor(initialDark)
                        },
                        grid: {
                            color: getGridColor(initialDark)
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: getTextColor(initialDark)
                        },
                        grid: {
                            color: getGridColor(initialDark)
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: getTextColor(initialDark)
                        }
                    }
                }
            }
        });

        // Observer Dark/Light Mode
        const observer = new MutationObserver(() => {
            const isNowDark = document.documentElement.classList.contains('dark');
            const newTextColor = getTextColor(isNowDark);
            const newGridColor = getGridColor(isNowDark);
            const newBorderColor = getThemeBorder(isNowDark);

            Chart.defaults.color = newTextColor;
            Chart.defaults.borderColor = newGridColor;

            for (let id in Chart.instances) {
                let chart = Chart.instances[id];
                if (chart.options.plugins && chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                    chart.options.plugins.legend.labels.color = newTextColor;
                }
                if (chart.options.scales) {
                    if (chart.options.scales.x) {
                        if (chart.options.scales.x.ticks) chart.options.scales.x.ticks.color = newTextColor;
                        if (chart.options.scales.x.grid) chart.options.scales.x.grid.color = newGridColor;
                    }
                    if (chart.options.scales.y) {
                        if (chart.options.scales.y.ticks) chart.options.scales.y.ticks.color = newTextColor;
                        if (chart.options.scales.y.grid) chart.options.scales.y.grid.color = newGridColor;
                    }
                }
                chart.data.datasets.forEach(dataset => {
                    if (dataset.borderColor !== '#2563eb') dataset.borderColor = newBorderColor;
                    if (dataset.pointBackgroundColor) dataset.pointBackgroundColor = newBorderColor;
                });
                chart.update();
            }
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
@endsection
