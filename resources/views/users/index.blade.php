@extends('layouts.app')

@section('header_title', 'Kelola Pengguna (Admin)')

@section('content')
    <!-- Header Action -->
    <div
        class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-800 p-4 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
        <div>
            <h3 class="font-bold text-lg dark:text-white">Daftar Akun Tim</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">Kelola akses sistem untuk Admin dan Marketing.</p>
        </div>
        <a href="{{ route('users.create') }}"
            class="px-4 py-2 text-sm font-bold bg-[#93c5fd] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all flex items-center whitespace-nowrap">
            + Tambah Akun
        </a>
    </div>

    <!-- Error Message -->
    @if ($errors->any())
        <div
            class="mb-6 bg-[#fca5a5] border-2 border-black dark:border-white p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]">
            <span class="font-bold text-black">{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Table Container -->
    <div
        class="bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm overflow-hidden transition-colors duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-black dark:text-slate-100">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700 border-b-2 border-black dark:border-white transition-colors">
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">No</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Nama Lengkap</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Email</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Role</th>
                        <th class="p-3 border-r-2 border-black dark:border-white text-sm font-bold">Terdaftar Sejak</th>
                        <th class="p-3 text-sm font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr
                            class="border-b-2 border-black dark:border-white hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
                            <td class="p-3 border-r-2 border-black dark:border-white">{{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-3 border-r-2 border-black dark:border-white font-semibold">{{ $user->name }}</td>
                            <td class="p-3 border-r-2 border-black dark:border-white">{{ $user->email }}</td>
                            <td class="p-3 border-r-2 border-black dark:border-white">
                                <!-- Badge tetap pastel dengan teks hitam -->
                                @if ($user->role === 'admin')
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#fca5a5] border border-black dark:border-white uppercase tracking-wider">Admin</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#86efac] border border-black dark:border-white uppercase tracking-wider">Marketing</span>
                                @endif
                            </td>
                            <td class="p-3 border-r-2 border-black dark:border-white">
                                {{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-3 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="px-2 py-1 text-xs font-bold text-black bg-[#fde047] border border-black dark:border-white shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] dark:shadow-[1px_1px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs font-bold text-black bg-[#fca5a5] border border-black dark:border-white shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] dark:shadow-[1px_1px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all {{ $user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500 dark:text-slate-400 font-semibold">
                                Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection
