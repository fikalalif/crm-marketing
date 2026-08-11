@extends('layouts.app')

@section('header_title', 'Kelola Leads')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex gap-2">
            <!-- Filter Status Placeholder -->
            <button class="px-3 py-1 text-sm font-semibold bg-white border-2 border-black hover:bg-slate-100">Semua</button>
            <button
                class="px-3 py-1 text-sm font-semibold bg-[#93c5fd] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Cool</button>
            <button
                class="px-3 py-1 text-sm font-semibold bg-[#fde047] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Warm</button>
            <button
                class="px-3 py-1 text-sm font-semibold bg-[#fca5a5] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Hot</button>
            <button
                class="px-3 py-1 text-sm font-semibold bg-[#86efac] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">Close</button>
        </div>

        <div class="flex gap-2">
            <button
                class="px-4 py-2 font-bold bg-white border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all">
                Export PDF
            </button>
            <!-- Ubah bagian ini di index.blade.php -->
            <a href="{{ route('leads.create') }}"
                class="px-4 py-2 font-bold bg-[#93c5fd] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all inline-block">
                + Tambah Lead
            </a>
        </div>
    </div>

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
