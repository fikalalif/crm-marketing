@extends('layouts.app')

@section('header_title', 'Kelola Leads')

@section('content')
    <!-- Area Search & Filter -->
    <form action="{{ route('leads.index') }}" method="GET"
        class="mb-6 flex flex-col gap-4 bg-white p-4 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">

        <!-- Baris Atas: Status & Action Buttons -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
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

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <a href="{{ route('leads.export.pdf', request()->query()) }}" target="_blank"
                    class="flex-1 md:flex-none px-4 py-2 text-center text-sm font-bold bg-white text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all">
                    Export PDF
                </a>
                <a href="{{ route('leads.create') }}"
                    class="flex-1 md:flex-none px-4 py-2 text-center text-sm font-bold bg-[#93c5fd] text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all">
                    + Tambah
                </a>
            </div>
        </div>

        <!-- Baris Bawah: Inputs (Search, Date, Source, Button Cari) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama, email, perusahaan..."
                class="p-2 w-full text-sm border-2 border-black focus:outline-none focus:bg-slate-50 bg-white">

            <input type="date" name="date" value="{{ request('date') }}"
                class="p-2 w-full text-sm border-2 border-black focus:outline-none focus:bg-slate-50 bg-white">

            <select name="source"
                class="p-2 w-full text-sm border-2 border-black focus:outline-none focus:bg-slate-50 bg-white">
                <option value="">Semua Source</option>
                <option value="Google Ads" {{ request('source') == 'Google Ads' ? 'selected' : '' }}>Google Ads</option>
                <option value="Meta Ads" {{ request('source') == 'Meta Ads' ? 'selected' : '' }}>Meta Ads</option>
                <option value="Website" {{ request('source') == 'Website' ? 'selected' : '' }}>Website</option>
                <option value="WhatsApp" {{ request('source') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                <option value="Referral" {{ request('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                <option value="Organic" {{ request('source') == 'Organic' ? 'selected' : '' }}>Organic</option>
            </select>

            <button type="submit"
                class="p-2 w-full text-sm font-bold bg-slate-800 text-white border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                Cari
            </button>
        </div>
    </form>

    <!-- Table Container -->
    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Bagian Header Tabel (Tidak boleh ada variabel $lead di sini) -->
                <!-- Bagian Header Tabel -->
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-black">
                        <th class="p-3 border-r-2 border-black text-sm font-bold">No</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold min-w-[150px]">Nama Lengkap</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Perusahaan</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Status</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Source</th>
                        <!-- Tambahan Header Catatan -->
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Catatan</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold min-w-[120px]">Tanggal</th>
                        <th class="p-3 text-sm font-bold text-center min-w-[120px]">Sunting</th>
                    </tr>
                </thead>

                <!-- Bagian Body Tabel -->
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

                            <td class="p-3 border-r-2 border-black">
                                @if ($lead->notes)
                                    <!-- Tombol untuk memicu modal, menggunakan Alpine.js -->
                                    <div x-data="{ openModal: false }">
                                        <button @click="openModal = true" type="button"
                                            class="text-left group cursor-pointer">
                                            <div
                                                class="truncate max-w-[140px] lg:max-w-[200px] text-sm text-slate-700 font-medium underline decoration-dotted underline-offset-4 hover:text-blue-600">
                                                {{ $lead->notes }}
                                            </div>
                                        </button>

                                        <!-- Modal Pop-up Catatan Lengkap -->
                                        <div x-show="openModal"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                            style="display: none;">
                                            <div @click.away="openModal = false"
                                                class="bg-white border-2 border-black shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] p-6 max-w-lg w-full rounded-sm relative">
                                                <h3 class="font-bold text-lg mb-2 border-b-2 border-black pb-2">Catatan
                                                    Detail Leads</h3>
                                                <p
                                                    class="text-sm text-slate-800 my-4 whitespace-pre-line bg-slate-50 p-3 border-2 border-black">
                                                    {{ $lead->notes }}</p>
                                                <div class="flex justify-end">
                                                    <button @click="openModal = false" type="button"
                                                        class="px-4 py-1.5 text-sm font-bold bg-[#93c5fd] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <td class="p-3 border-r-2 border-black">{{ $lead->created_at->format('d M Y') }}</td>

                            <td class="p-3 text-center flex justify-center gap-2">
                                <a href="{{ route('leads.edit', $lead->id) }}"
                                    class="px-2 py-1 text-xs font-bold bg-[#fde047] border border-black shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                    Edit
                                </a>

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
                            <td colspan="8" class="p-6 text-center text-slate-500 font-semibold">Belum ada data leads.
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
