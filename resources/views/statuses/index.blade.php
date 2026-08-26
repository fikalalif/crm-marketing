@extends('layouts.app')

@section('header_title', 'Manajemen Kolom Board')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Tambah Status -->
        <div class="lg:col-span-1">
            <div
                class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] dark:shadow-[6px_6px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
                <div class="p-4 border-b-2 border-black dark:border-white bg-[#86efac] transition-colors">
                    <h3 class="font-black text-black uppercase tracking-widest">+ Tambah Kolom</h3>
                </div>

                <div class="p-5">
                    @if ($errors->any())
                        <div
                            class="mb-4 bg-[#fca5a5] border-2 border-black dark:border-white p-3 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] text-black">
                            <ul class="list-disc list-inside text-xs font-bold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('statuses.store') }}" method="POST"
                        class="flex flex-col gap-4 text-black dark:text-white">
                        @csrf
                        <div class="flex flex-col gap-1">
                            <label class="font-bold text-sm">Nama Status <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <input type="text" name="name" required placeholder="Cth: Follow Up, Meeting..."
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-slate-50 dark:bg-slate-700 text-black dark:text-white">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="font-bold text-sm">Urutan (Angka) <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <input type="number" name="order" value="1" required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-slate-50 dark:bg-slate-700 text-black dark:text-white">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="font-bold text-sm">Warna Background <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <select name="color" required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none bg-slate-50 dark:bg-slate-700 text-black dark:text-white cursor-pointer">
                                <option value="bg-[#93c5fd]">Biru Pastel (Cool)</option>
                                <option value="bg-[#fde047]">Kuning Pastel (Warm)</option>
                                <option value="bg-[#fca5a5]">Merah Pastel (Hot)</option>
                                <option value="bg-[#86efac]">Hijau Pastel (Close)</option>
                                <option value="bg-[#d8b4fe]">Ungu Pastel</option>
                                <option value="bg-[#fdba74]">Oranye Pastel</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="mt-2 px-4 py-3 font-black uppercase tracking-wider bg-[#93c5fd] text-black border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none transition-all">
                            Simpan Kolom
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Status -->
        <div class="lg:col-span-2">
            <div
                class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] dark:shadow-[6px_6px_0px_0px_rgba(255,255,255,1)] rounded-sm overflow-hidden transition-colors duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-black dark:text-slate-100">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-700 border-b-2 border-black dark:border-white">
                                <th
                                    class="p-3 border-r-2 border-black dark:border-white text-sm font-black uppercase tracking-wider">
                                    Urutan</th>
                                <th
                                    class="p-3 border-r-2 border-black dark:border-white text-sm font-black uppercase tracking-wider">
                                    Nama Status</th>
                                <th
                                    class="p-3 border-r-2 border-black dark:border-white text-sm font-black uppercase tracking-wider">
                                    Preview Warna</th>
                                <th class="p-3 text-sm font-black text-center uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($statuses as $status)
                                <tr
                                    class="border-b-2 border-black dark:border-white hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                                    <td class="p-3 border-r-2 border-black dark:border-white font-bold text-center text-lg">
                                        {{ $status->order }}</td>
                                    <td class="p-3 border-r-2 border-black dark:border-white font-bold">{{ $status->name }}
                                    </td>
                                    <td class="p-3 border-r-2 border-black dark:border-white">
                                        <span
                                            class="{{ $status->color }} px-3 py-1 border-2 border-black dark:border-white font-bold text-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">{{ $status->name }}</span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <form action="{{ route('statuses.destroy', $status->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kolom ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs font-bold text-black bg-[#fca5a5] border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-500 font-bold">Belum ada kolom
                                        status yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
