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
    <div class="bg-white border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-slate-500 text-sm uppercase tracking-wider mb-2">Total Leads</h3>
        <span class="text-4xl font-black">{{ number_format($totalLeads, 0, ',', '.') }}</span>
    </div>

    <!-- Conversion Rate -->
    <div class="bg-[#d8b4fe] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Conversion Rate</h3>
        <div class="flex items-end gap-2">
            <span class="text-4xl font-black">{{ $conversionRate }}</span>
            <span class="font-bold text-xl mb-1">%</span>
        </div>
    </div>

    <!-- Leads: Cool -->
    <div class="bg-[#93c5fd] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Cool</h3>
        <span class="text-4xl font-black">{{ number_format($coolLeads, 0, ',', '.') }}</span>
    </div>

    <!-- Leads: Warm -->
    <div class="bg-[#fde047] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Warm</h3>
        <span class="text-4xl font-black">{{ number_format($warmLeads, 0, ',', '.') }}</span>
    </div>

    <!-- Leads: Hot -->
    <div class="bg-[#fca5a5] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Hot</h3>
        <span class="text-4xl font-black">{{ number_format($hotLeads, 0, ',', '.') }}</span>
    </div>

    <!-- Leads: Close (Won) -->
    <div class="bg-[#86efac] border-2 border-black p-6 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex flex-col justify-between">
        <h3 class="font-bold text-black text-sm uppercase tracking-wider mb-2">Status: Close / Won</h3>
        <span class="text-4xl font-black">{{ number_format($closeLeads, 0, ',', '.') }}</span>
    </div>

</div>

<!-- Placeholder untuk Chart.js (Phase 8) -->
<div class="mt-8 p-6 bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm flex items-center justify-center min-h-[300px]">
    <p class="font-bold text-slate-400">Area Grafik Chart.js (Akan diisi di Phase 8)</p>
</div>
@endsection
