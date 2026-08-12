@extends('layouts.app')

@section('header_title', 'Tambah Pengguna')

@section('content')
    <div
        class="max-w-2xl bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] p-6 rounded-sm transition-colors duration-300">
        <div class="mb-6 border-b-2 border-black dark:border-white pb-4 transition-colors">
            <h3 class="font-bold text-xl dark:text-white">Buat Akun Baru</h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm">Tambahkan anggota tim Marketing atau Admin baru ke dalam
                sistem.</p>
        </div>

        <!-- Area Notifikasi Error -->
        @if ($errors->any())
            <div
                class="mb-6 bg-[#fca5a5] border-2 border-black dark:border-white p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] text-black">
                <h4 class="font-bold mb-1">Gagal menyimpan data:</h4>
                <ul class="list-disc list-inside text-sm font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="flex flex-col gap-5 text-black dark:text-slate-100">
            @csrf

            <!-- Nama Lengkap -->
            <div class="flex flex-col gap-1">
                <label for="name" class="font-bold text-sm">Nama Lengkap <span
                        class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1">
                <label for="email" class="font-bold text-sm">Alamat Email <span
                        class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1" x-data="{ showPassword: false }">
                <label for="password" class="font-bold text-sm">Password</label>
                <div class="flex">
                    <!-- Input Field yang type-nya dinamis mengikuti state Alpine -->
                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                        class="w-full p-2 border-2 border-black dark:border-white border-r-0 focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">

                    <!-- Tombol Toggle Show/Hide -->
                    <button type="button" @click="showPassword = !showPassword"
                        class="px-4 bg-[#d8b4fe] border-2 border-black dark:border-white text-black font-bold text-xs hover:bg-[#fde047] transition-colors flex items-center justify-center shrink-0">
                        <!-- Teks berubah otomatis -->
                        <span x-text="showPassword ? 'Hide' : 'Show'"></span>
                    </button>
                </div>
            </div>

            <!-- Role -->
            <div class="flex flex-col gap-1">
                <label for="role" class="font-bold text-sm">Hak Akses (Role) <span
                        class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                <select name="role" id="role" required
                    class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                    <option value="marketing" {{ old('role') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-4 border-t-2 border-black dark:border-white pt-4 transition-colors">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 font-bold bg-[#86efac] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
@endsection
