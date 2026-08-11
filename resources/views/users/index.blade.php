@extends('layouts.app')

@section('header_title', 'Kelola Pengguna (Admin)')

@section('content')
    <!-- Header Action -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm">
        <div>
            <h3 class="font-bold text-lg">Daftar Akun Tim</h3>
            <p class="text-sm text-slate-600">Kelola akses sistem untuk Admin dan Marketing.</p>
        </div>
        <a href="{{ route('users.create') }}"
            class="px-4 py-2 text-sm font-bold bg-[#93c5fd] text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all flex items-center whitespace-nowrap">
            + Tambah Akun
        </a>
    </div>

    <!-- Error Message -->
    @if($errors->any())
        <div class="mb-6 bg-[#fca5a5] border-2 border-black p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
            <span class="font-bold text-black">{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Table Container -->
    <div class="bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b-2 border-black">
                        <th class="p-3 border-r-2 border-black text-sm font-bold">No</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Nama Lengkap</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Email</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Role</th>
                        <th class="p-3 border-r-2 border-black text-sm font-bold">Terdaftar Sejak</th>
                        <th class="p-3 text-sm font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-b-2 border-black hover:bg-slate-50">
                            <td class="p-3 border-r-2 border-black">{{ $users->firstItem() + $index }}</td>
                            <td class="p-3 border-r-2 border-black font-semibold">{{ $user->name }}</td>
                            <td class="p-3 border-r-2 border-black">{{ $user->email }}</td>
                            <td class="p-3 border-r-2 border-black">
                                @if ($user->role === 'admin')
                                    <span class="px-2 py-1 text-xs font-bold bg-[#fca5a5] border border-black uppercase tracking-wider">Admin</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold bg-[#86efac] border border-black uppercase tracking-wider">Marketing</span>
                                @endif
                            </td>
                            <td class="p-3 border-r-2 border-black">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-3 text-center flex justify-center gap-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="px-2 py-1 text-xs font-bold bg-[#fde047] border border-black shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-2 py-1 text-xs font-bold bg-[#fca5a5] border border-black shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all {{ $user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500 font-semibold">Belum ada data pengguna.</td>
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
