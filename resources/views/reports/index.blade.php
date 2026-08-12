@extends('layouts.app')

@section('header_title', 'Laporan Kinerja')

@section('content')
    <!-- Header & Filter Area -->
    <div
        class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-800 p-6 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
        <div>
            <h3 class="font-bold text-xl dark:text-white">Laporan Kinerja Marketing</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Analisis data prospek dan tingkat konversi berdasarkan
                rentang waktu.</p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
            <select name="days"
                class="p-2 text-sm font-bold border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 dark:text-white flex-1 transition-colors"
                onchange="this.form.submit()">
                <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="365" {{ $days == 365 ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
            <!-- Tombol Export PDF -->
            <a href="{{ route('leads.export.pdf', ['days' => $days]) }}" target="_blank"
                class="px-4 py-2 text-sm font-bold text-black bg-[#fde047] border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all flex items-center whitespace-nowrap">
                Cetak PDF
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Prospek Baru (Putih -> Gelap) -->
        <div
            class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
            <h4 class="font-bold text-slate-500 dark:text-slate-300 text-sm uppercase tracking-wider mb-2">Total Prospek
                Baru</h4>
            <span class="text-4xl font-black dark:text-white">{{ number_format($totalLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Card 2: Total Deals (Tetap Pastel Hijau, Teks Hitam) -->
        <div
            class="bg-[#86efac] border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
            <h4 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Total Deals (Close)</h4>
            <span class="text-4xl font-black text-black">{{ number_format($closeLeads, 0, ',', '.') }}</span>
        </div>

        <!-- Card 3: Tingkat Konversi (Tetap Pastel Ungu, Teks Hitam) -->
        <div
            class="bg-[#d8b4fe] border-2 border-black dark:border-white p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
            <h4 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Tingkat Konversi</h4>
            <div class="flex items-end gap-1 text-black">
                <span class="text-4xl font-black">{{ $conversionRate }}</span>
                <span class="font-bold text-xl mb-1">%</span>
            </div>
        </div>
    </div>

    <!-- Breakdown Table -->
    <div
        class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm overflow-hidden transition-colors duration-300">
        <div class="p-4 border-b-2 border-black dark:border-white bg-slate-50 dark:bg-slate-700 transition-colors">
            <h3 class="font-bold text-lg dark:text-white">Distribusi Berdasarkan Sumber (Source)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-black dark:text-slate-100">
                <thead>
                    <tr class="border-b-2 border-black dark:border-white">
                        <th
                            class="p-3 border-r-2 border-black dark:border-white text-sm font-bold bg-white dark:bg-slate-700 transition-colors">
                            Sumber Lead</th>
                        <th class="p-3 text-sm font-bold bg-white dark:bg-slate-700 transition-colors">Jumlah Didapat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leadsBySource as $source)
                        <tr
                            class="border-b-2 border-black dark:border-white hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                            <td class="p-3 border-r-2 border-black dark:border-white font-semibold">{{ $source->source }}
                            </td>
                            <td class="p-3">{{ $source->total }} Leads</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-6 text-center text-slate-500 dark:text-slate-400 font-semibold">
                                Tidak ada data untuk rentang waktu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
