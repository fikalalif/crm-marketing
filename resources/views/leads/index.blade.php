@extends('layouts.app')

@section('header_title', 'Kelola Leads')

@section('content')
    <!-- Area Search & Filter -->
    <form action="{{ route('leads.index') }}" method="GET"
        class="mb-6 flex flex-col gap-4 bg-white dark:bg-slate-800 p-4 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">

        <!-- Baris Atas: Status & Action Buttons -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <!-- Filter Status -->
            <div class="flex flex-wrap gap-2">
                <button type="submit" name="status" value=""
                    class="px-3 py-1 text-sm font-semibold border-2 border-black dark:border-white transition-all {{ request('status') == '' ? 'bg-slate-800 dark:bg-slate-100 text-white dark:text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'bg-white dark:bg-slate-700 text-black dark:text-white hover:bg-slate-100 dark:hover:bg-slate-600' }}">Semua</button>
                <button type="submit" name="status" value="cool"
                    class="px-3 py-1 text-sm font-semibold text-black border-2 border-black dark:border-white transition-all {{ request('status') == 'cool' ? 'bg-[#93c5fd] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'bg-white dark:bg-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-600' }}">Cool</button>
                <button type="submit" name="status" value="warm"
                    class="px-3 py-1 text-sm font-semibold text-black border-2 border-black dark:border-white transition-all {{ request('status') == 'warm' ? 'bg-[#fde047] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'bg-white dark:bg-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-600' }}">Warm</button>
                <button type="submit" name="status" value="hot"
                    class="px-3 py-1 text-sm font-semibold text-black border-2 border-black dark:border-white transition-all {{ request('status') == 'hot' ? 'bg-[#fca5a5] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'bg-white dark:bg-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-600' }}">Hot</button>
                <button type="submit" name="status" value="close"
                    class="px-3 py-1 text-sm font-semibold text-black border-2 border-black dark:border-white transition-all {{ request('status') == 'close' ? 'bg-[#86efac] shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]' : 'bg-white dark:bg-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-600' }}">Close</button>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <a href="{{ route('leads.export.pdf', request()->query()) }}" target="_blank"
                    class="flex-1 md:flex-none px-4 py-2 text-center text-sm font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    Export PDF
                </a>
                <a href="{{ route('leads.create') }}"
                    class="flex-1 md:flex-none px-4 py-2 text-center text-sm font-bold bg-[#93c5fd] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    + Tambah
                </a>
            </div>
        </div>

        <!-- Baris Bawah: Inputs (Search, Date, Source, Button Cari) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, email, perusahaan..."
                class="p-2 w-full text-sm border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 dark:text-white transition-colors">

            <input type="date" name="date" value="{{ request('date') }}"
                class="p-2 w-full text-sm border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 dark:text-white transition-colors">

            <select name="source"
                class="p-2 w-full text-sm border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 dark:text-white transition-colors">
                <option value="">Semua Source</option>
                <option value="Google Ads" {{ request('source') == 'Google Ads' ? 'selected' : '' }}>Google Ads</option>
                <option value="Meta Ads" {{ request('source') == 'Meta Ads' ? 'selected' : '' }}>Meta Ads</option>
                <option value="Website" {{ request('source') == 'Website' ? 'selected' : '' }}>Website</option>
                <option value="WhatsApp" {{ request('source') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="Referral" {{ request('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                <option value="Organic" {{ request('source') == 'Organic' ? 'selected' : '' }}>Organic</option>
            </select>

            <button type="submit"
                class="p-2 w-full text-sm font-bold bg-slate-800 dark:bg-slate-200 text-white dark:text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                Cari
            </button>
        </div>
    </form>

    <!-- Table Container -->
    <div
        class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-black dark:text-slate-100">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700 border-b-2 border-black dark:border-white transition-colors">
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">No</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold min-w-[150px]">Nama
                            Lengkap</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Perusahaan</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Status</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Source</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Catatan</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold min-w-[120px]">Tanggal
                        </th>
                        <th class="p-3 text-sm font-bold text-center min-w-[120px]">Sunting</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($leads as $index => $lead)
                        <tr
                            class="border-b-2 border-black dark:border-white hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                            <td class="p-3 border-r-2 border-black dark:border-white">{{ $leads->firstItem() + $index }}
                            </td>
                            <td class="p-3 border-r-2 border-black dark:border-white font-semibold">{{ $lead->name }}
                            </td>
                            <td class="p-3 border-r-2 border-black dark:border-white">{{ $lead->company ?? '-' }}</td>
                            <td class="p-3 border-r-2 border-black dark:border-white">
                                <!-- Badges (Tetap Pastel dengan Teks Hitam) -->
                                @if ($lead->status == 'cool')
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#93c5fd] border border-black dark:border-white">Cool</span>
                                @elseif($lead->status == 'warm')
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#fde047] border border-black dark:border-white">Warm</span>
                                @elseif($lead->status == 'hot')
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#fca5a5] border border-black dark:border-white">Hot</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#86efac] border border-black dark:border-white">Close</span>
                                @endif
                            </td>
                            <td class="p-3 border-r-2 border-black dark:border-white">{{ $lead->source ?? '-' }}</td>

                            <td class="p-3 border-r-2 border-black dark:border-white">
                                @if ($lead->notes)
                                    <div x-data="{ openModal: false }">
                                        <button @click="openModal = true" type="button"
                                            class="text-left group cursor-pointer">
                                            <div
                                                class="truncate max-w-[140px] lg:max-w-[200px] text-sm text-slate-700 dark:text-slate-300 font-medium underline decoration-dotted underline-offset-4 hover:text-blue-600 dark:hover:text-[#93c5fd]">
                                                {{ $lead->notes }}
                                            </div>
                                        </button>

                                        <!-- Modal Pop-up Catatan Lengkap -->
                                        <div x-show="openModal"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                            style="display: none;">
                                            <div @click.away="openModal = false"
                                                class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] dark:shadow-[6px_6px_0px_0px_rgba(255,255,255,1)] p-6 max-w-lg w-full rounded-sm relative text-black dark:text-white">
                                                <h3
                                                    class="font-bold text-lg mb-2 border-b-2 border-black dark:border-white pb-2">
                                                    Catatan Detail Leads</h3>
                                                <p
                                                    class="text-sm text-slate-800 dark:text-slate-200 my-4 whitespace-pre-line bg-slate-50 dark:bg-slate-700 p-3 border-2 border-black dark:border-white">
                                                    {{ $lead->notes }}
                                                </p>
                                                <div class="flex justify-end">
                                                    <button @click="openModal = false" type="button"
                                                        class="px-4 py-1.5 text-sm font-bold text-black bg-[#93c5fd] border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>

                            <td class="p-3 border-r-2 border-black dark:border-white">
                                {{ $lead->created_at->format('d M Y') }}</td>

                            <td class="p-3 text-center flex justify-center gap-2">
                                <a href="{{ route('leads.edit', $lead->id) }}"
                                    class="px-2 py-1 text-xs font-bold text-black bg-[#fde047] border border-black dark:border-white shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] dark:shadow-[1px_1px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                                    Edit
                                </a>

                                <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus lead ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#fca5a5] border border-black dark:border-white shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] dark:shadow-[1px_1px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-slate-500 dark:text-slate-400 font-semibold">
                                Belum ada data leads.</td>
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
