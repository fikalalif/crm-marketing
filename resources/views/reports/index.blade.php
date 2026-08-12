@extends('layouts.app')

@section('header_title', 'Laporan Kinerja')

@section('content')
    <!-- Header & Filter Area -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
        <div>
            <h3 class="font-bold text-xl">Laporan Kinerja Marketing</h3>
            <p class="text-sm text-slate-600">Analisis data prospek dan tingkat konversi berdasarkan rentang waktu.</p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
            <select name="days" class="p-2 text-sm font-bold border-2 border-black focus:outline-none focus:bg-slate-50 bg-white flex-1" onchange="this.form.submit()">
                <option value="7" {{ $days == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="365" {{ $days == 365 ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
            <!-- Tombol Export PDF menggunakan route dari leads, tapi kita lempar parameter days -->
            <a href="{{ route('leads.export.pdf', ['days' => $days]) }}" target="_blank"
                class="px-4 py-2 text-sm font-bold bg-[#fde047] text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all flex items-center whitespace-nowrap">
                Cetak PDF
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
            <h4 class="font-bold text-slate-500 text-sm uppercase tracking-wider mb-2">Total Prospek Baru</h4>
            <span class="text-4xl font-black">{{ number_format($totalLeads, 0, ',', '.') }}</span>
        </div>

        <div class="bg-[#86efac] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
            <h4 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Total Deals (Close)</h4>
            <span class="text-4xl font-black">{{ number_format($closeLeads, 0, ',', '.') }}</span>
        </div>

        <div class="bg-[#d8b4fe] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
            <h4 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Tingkat Konversi</h4>
            <div class="flex items-end gap-1">
                <span class="text-4xl font-black">{{ $conversionRate }}</span>
                <span class="font-bold text-xl mb-1">%</span>
            </div>
        </div>
    </div>

    <!-- Breakdown Table -->
    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm overflow-hidden">
        <div class="p-4 border-b-2 border-black bg-slate-50">
            <h3 class="font-bold text-lg">Distribusi Berdasarkan Sumber (Source)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="p-3 border-r-2 border-black text-sm font-bold bg-white">Sumber Lead</th>
                        <th class="p-3 text-sm font-bold bg-white">Jumlah Didapat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leadsBySource as $source)
                        <tr class="border-b-2 border-black hover:bg-slate-50">
                            <td class="p-3 border-r-2 border-black font-semibold">{{ $source->source }}</td>
                            <td class="p-3">{{ $source->total }} Leads</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="p-6 text-center text-slate-500 font-semibold">Tidak ada data untuk rentang waktu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
