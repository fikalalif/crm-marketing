@extends('layouts.app')

@section('header_title', 'Edit Lead')

@section('content')
    <div
        class="max-w-3xl bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] p-6 rounded-sm transition-colors duration-300">

        <!-- Area Pesan Error Global -->
        @if ($errors->any())
            <div
                class="mb-6 bg-[#fca5a5] border-2 border-black dark:border-white p-4 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] text-black">
                <h3 class="font-bold mb-1">Terjadi Kesalahan:</h3>
                <ul class="list-disc list-inside text-sm font-semibold">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('leads.update', $lead->id) }}" method="POST"
            class="flex flex-col gap-5 text-black dark:text-slate-100">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Nama Customer -->
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-bold text-sm">Nama Customer <span
                            class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $lead->name) }}" required
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                </div>

                <!-- Phone -->
                <div class="flex flex-col gap-1">
                    <label for="phone" class="font-bold text-sm">Nomor Telepon <span
                            class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $lead->phone) }}" required
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-1">
                    <label for="email" class="font-bold text-sm">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $lead->email) }}"
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                </div>

                <!-- Company -->
                <div class="flex flex-col gap-1">
                    <label for="company" class="font-bold text-sm">Perusahaan</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $lead->company) }}"
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                </div>

                <!-- Status -->
                <div class="flex flex-col gap-1">
                    <label for="status" class="font-bold text-sm">Status <span
                            class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                    <select name="status" id="status" required
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        <option value="cool" {{ old('status', $lead->status) == 'cool' ? 'selected' : '' }}>Cool</option>
                        <option value="warm" {{ old('status', $lead->status) == 'warm' ? 'selected' : '' }}>Warm</option>
                        <option value="hot" {{ old('status', $lead->status) == 'hot' ? 'selected' : '' }}>Hot</option>
                        <option value="close" {{ old('status', $lead->status) == 'close' ? 'selected' : '' }}>Close
                        </option>
                    </select>
                </div>

                <!-- Source -->
                <div class="flex flex-col gap-1">
                    <label for="source" class="font-bold text-sm">Source / Sumber Lead</label>
                    <select name="source" id="source"
                        class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        <option value="">-- Pilih Sumber --</option>
                        <option value="Google Ads" {{ old('source', $lead->source) == 'Google Ads' ? 'selected' : '' }}>
                            Google Ads</option>
                        <option value="Meta Ads" {{ old('source', $lead->source) == 'Meta Ads' ? 'selected' : '' }}>Meta
                            Ads</option>
                        <option value="Website" {{ old('source', $lead->source) == 'Website' ? 'selected' : '' }}>Website
                        </option>
                        <option value="WhatsApp" {{ old('source', $lead->source) == 'WhatsApp' ? 'selected' : '' }}>
                            WhatsApp</option>
                        <option value="Referral" {{ old('source', $lead->source) == 'Referral' ? 'selected' : '' }}>
                            Referral</option>
                        <option value="Organic" {{ old('source', $lead->source) == 'Organic' ? 'selected' : '' }}>Organic
                        </option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div class="flex flex-col gap-1">
                <label for="notes" class="font-bold text-sm">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="4"
                    class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-slate-50 dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">{{ old('notes', $lead->notes) }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-4 border-t-2 border-black dark:border-white pt-4">
                <a href="{{ route('leads.index') }}"
                    class="px-4 py-2 font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 font-bold bg-[#fde047] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                    Perbarui Lead
                </button>
            </div>
        </form>
    </div>
@endsection
