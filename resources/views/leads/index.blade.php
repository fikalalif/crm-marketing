@extends('layouts.app')

@section('header_title', 'Kelola Leads')

@section('content')
    <!-- Area Search & Filter -->
    <form action="{{ route('leads.index') }}" method="GET"
        class="mb-6 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 bg-white p-4 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">

        <!-- Filter Status -->
        <div class="flex flex-wrap gap-2">
            <button type="submit" name="status" value=""
                class="px-3 py-1 text-sm font-semibold border-2 border-black transition-all {{ request('status') == '' ? 'bg-slate-800 text-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white text-black hover:bg-slate-100' }}">Semua</button>
            <button type="submit" name="status" value="cool"
                class="px-3 py-1 text-sm font-semibold border-2 border-black transition-all {{ request('status') == 'cool' ? 'bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white hover:bg-slate-100' }}">Cool</button>
            <button type="submit" name="status" value="warm"
                class="px-3 py-1 text-sm font-semibold border-2 border-black transition-all {{ request('status') == 'warm' ? 'bg-[#fde047] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white hover:bg-slate-100' }}">Warm</button>
            <button type="submit" name="status" value="hot"
                class="px-3 py-1 text-sm font-semibold border-2 border-black transition-all {{ request('status') == 'hot' ? 'bg-[#fca5a5] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white hover:bg-slate-100' }}">Hot</button>
            <button type="submit" name="status" value="close"
                class="px-3 py-1 text-sm font-semibold border-2 border-black transition-all {{ request('status') == 'close' ? 'bg-[#86efac] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]' : 'bg-white hover:bg-slate-100' }}">Close</button>
        </div>

        <!-- Search, Date, Source, and Action -->
        <div class="flex flex-wrap items-center gap-2 w-full xl:w-auto">
            <!-- Input Search -->
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, email, perusahaan..."
                class="p-2 text-sm border-2 border-black focus:outline-none focus:bg-slate-50 flex-1 min-w-[200px]">

            <!-- Input Date -->
            <input type="date" name="date" value="{{ request('date') }}"
                class="p-2 text-sm border-2 border-black focus:outline-none focus:bg-slate-50 bg-white">

            <!-- Select Source -->
            <select name="source" class="p-2 text-sm border-2 border-black focus:outline-none focus:bg-slate-50 bg-white">
                <option value="">Semua Source</option>
                <option value="Google Ads" {{ request('source') == 'Google Ads' ? 'selected' : '' }}>Google Ads</option>
                <option value="Meta Ads" {{ request('source') == 'Meta Ads' ? 'selected' : '' }}>Meta Ads</option>
                <option value="Website" {{ request('source') == 'Website' ? 'selected' : '' }}>Website</option>
                <option value="WhatsApp" {{ request('source') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="Referral" {{ request('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                <option value="Organic" {{ request('source') == 'Organic' ? 'selected' : '' }}>Organic</option>
            </select>

            <!-- Tombol Terapkan Filter -->
            <button type="submit"
                class="px-4 py-2 text-sm font-bold bg-slate-800 text-white border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                Cari
            </button>

            <!-- Tombol Tambah Lead -->
            <a href="{{ route('leads.create') }}"
                class="px-4 py-2 text-sm font-bold bg-[#93c5fd] text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all flex items-center whitespace-nowrap">
                + Tambah
            </a>
        </div>
    </form>

    <!-- Table Container -->
    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Bagian Header Tabel (Tidak boleh ada variabel $lead di sini) -->
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-black">
                        <th class="p-3 border-r-2 border-black text-sm font-bold">No</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Nama Lengkap</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Perusahaan</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Status</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Source</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Tanggal</th>
                        <th class="p-3 text-sm font-bold text-center">Sunting</th>
                    </tr>
                </thead>

                <!-- Bagian Body Tabel (Variabel $lead ada di dalam sini) -->
                <tbody>
                    @forelse($leads as $index => $lead)
                        <tr class="border-b-2 border-black hover:bg-slate-50">
                            <td class="p-3 border-r-2 border-black">{{ $leads->firstItem() + $index }}</td>
                            <td class="p-3 border-r-2 border-black font-semibold">{{ $lead->name }}</td>
                            <td class="p-3 border-r-2 border-black">{{ $lead->company ?? '-' }}</td>
                            <td class="p-3 border-r-2 border-black">
                                <!-- Badges -->
                                @if ($lead->status == 'cool')
                                    <span class="px-2 py-1 text-xs font-bold bg-[#93c5fd] border border-black">Cool</span>
                                @elseif($lead->status == 'warm')
                                    <span class="px-2 py-1 text-xs font-bold bg-[#fde047] border border-black">Warm</span>
                                @elseif($lead->status == 'hot')
                                    <span class="px-2 py-1 text-xs font-bold bg-[#fca5a5] border border-black">Hot</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold bg-[#86efac] border border-black">Close</span>
                                @endif
                            </td>
                            <td class="p-3 border-r-2 border-black">{{ $lead->source ?? '-' }}</td>
                            <td class="p-3 border-r-2 border-black">{{ $lead->created_at->format('d M Y') }}</td>

                            <!-- Letak tombol Edit dan Hapus yang benar -->
                            <td class="p-3 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('leads.edit', $lead->id) }}"
                                    class="px-2 py-1 text-xs font-bold bg-[#fde047] border border-black shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus lead ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs font-bold bg-[#fca5a5] border border-black shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500 font-semibold">Belum ada data leads.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $leads->links() }}
    </div>
@endsection
