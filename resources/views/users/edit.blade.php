@extends('layouts.app')

@section('header_title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6 rounded-sm">
    <div class="mb-6 border-b-2 border-black pb-4">
        <h3 class="font-bold text-xl">Sunting Data Akun</h3>
        <p class="text-slate-600 text-sm">Perbarui informasi anggota tim atau ganti password mereka di sini.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-[#fca5a5] border-2 border-black p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
            <h4 class="font-bold mb-1">Terjadi Kesalahan:</h4>
            <ul class="list-disc list-inside text-sm font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')

        <!-- Nama Lengkap -->
        <div class="flex flex-col gap-1">
            <label for="name" class="font-bold text-sm">Nama Lengkap <span class="text-red-600">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                class="p-2 border-2 border-black focus:outline-none focus:bg-slate-50 transition-colors">
        </div>

        <!-- Email -->
        <div class="flex flex-col gap-1">
            <label for="email" class="font-bold text-sm">Alamat Email <span class="text-red-600">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                class="p-2 border-2 border-black focus:outline-none focus:bg-slate-50 transition-colors">
        </div>

        <!-- Password (Opsional) -->
        <div class="flex flex-col gap-1">
            <label for="password" class="font-bold text-sm">Password Baru <span class="text-slate-400 font-normal">(Opsional)</span></label>
            <input type="password" name="password" id="password" minlength="8"
                class="p-2 border-2 border-black focus:outline-none focus:bg-slate-50 transition-colors placeholder:text-sm"
                placeholder="Kosongkan jika tidak ingin mengganti password">
        </div>

        <!-- Role -->
        <div class="flex flex-col gap-1">
            <label for="role" class="font-bold text-sm">Hak Akses (Role) <span class="text-red-600">*</span></label>
            <select name="role" id="role" required
                class="p-2 border-2 border-black focus:outline-none focus:bg-slate-50 transition-colors bg-white">
                <option value="marketing" {{ old('role', $user->role) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-4 border-t-2 border-black pt-4">
            <a href="{{ route('users.index') }}"
                class="px-4 py-2 font-bold bg-white border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all">
                Batal
            </a>
            <button type="submit"
                class="px-4 py-2 font-bold bg-[#fde047] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)] transition-all">
                Perbarui Akun
            </button>
        </div>
    </form>
</div>
@endsection
