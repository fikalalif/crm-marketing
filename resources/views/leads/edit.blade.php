@extends('layouts.app')

@section('header_title', 'Edit Lead')

@section('content')
    <div
        class="max-w-4xl bg-white dark:bg-slate-800 border-2 border-black dark:border-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] dark:shadow-[8px_8px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">

        <!-- Header Ala Card Trello -->
        <div
            class="p-4 border-b-2 border-black dark:border-white bg-[#fde047] flex justify-between items-center transition-colors">
            <h2 class="font-black text-xl text-black uppercase tracking-widest">Sunting Kartu Prospek</h2>
        </div>

        <div class="p-6">
            <!-- Area Pesan Error Global -->
            @if ($errors->any())
                <div
                    class="mb-6 bg-[#fca5a5] border-2 border-black dark:border-white p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] text-black">
                    <h3 class="font-black mb-1 text-lg">⚠️ Terjadi Kesalahan:</h3>
                    <ul class="list-disc list-inside text-sm font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('leads.update', $lead->id) }}" method="POST"
                class="flex flex-col gap-8 text-black dark:text-slate-100">
                @csrf
                @method('PUT')

                <!-- SEKSI 1: Informasi Kontak -->
                <div
                    class="p-5 border-2 border-black dark:border-white bg-slate-50 dark:bg-slate-900 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] transition-colors">
                    <h3 class="font-black text-lg mb-4 border-b-2 border-black dark:border-white pb-2 inline-block">📋
                        Informasi Kontak</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-1">
                            <label for="name" class="font-bold text-sm">Nama Customer <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $lead->name) }}"
                                required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="phone" class="font-bold text-sm">Nomor Telepon <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $lead->phone) }}"
                                required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="email" class="font-bold text-sm">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $lead->email) }}"
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="company" class="font-bold text-sm">Perusahaan</label>
                            <input type="text" name="company" id="company" value="{{ old('company', $lead->company) }}"
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        </div>
                    </div>
                </div>

                <!-- SEKSI 2: Pipeline & Status -->
                <div
                    class="p-5 border-2 border-black dark:border-white bg-[#f8fafc] dark:bg-slate-900 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] transition-colors">
                    <h3 class="font-black text-lg mb-4 border-b-2 border-black dark:border-white pb-2 inline-block">🚀
                        Pipeline & Status</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="flex flex-col gap-1">
                            <label for="lead_status_id" class="font-bold text-sm">Posisi Board (Status) <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <!-- BERUBAH MENJADI DINAMIS DARI DATABASE -->
                            <select name="lead_status_id" id="lead_status_id" required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none font-bold cursor-pointer focus:bg-white dark:focus:bg-slate-600 bg-[#fde047] text-black transition-colors">
                                <option value="">-- Pilih Status --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}"
                                        {{ old('lead_status_id', $lead->lead_status_id) == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="source" class="font-bold text-sm">Sumber Lead</label>
                            <select name="source" id="source"
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                                <option value="">-- Pilih Sumber --</option>
                                <option value="Google Ads"
                                    {{ old('source', $lead->source) == 'Google Ads' ? 'selected' : '' }}>Google Ads
                                </option>
                                <option value="Meta Ads"
                                    {{ old('source', $lead->source) == 'Meta Ads' ? 'selected' : '' }}>Meta Ads</option>
                                <option value="Website" {{ old('source', $lead->source) == 'Website' ? 'selected' : '' }}>
                                    Website</option>
                                <option value="WhatsApp"
                                    {{ old('source', $lead->source) == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="Referral"
                                    {{ old('source', $lead->source) == 'Referral' ? 'selected' : '' }}>Referral</option>
                                <option value="Organic" {{ old('source', $lead->source) == 'Organic' ? 'selected' : '' }}>
                                    Organic</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="created_at" class="font-bold text-sm">Tanggal Input <span
                                    class="text-red-600 dark:text-[#fca5a5]">*</span></label>
                            <input type="date" name="created_at" id="created_at"
                                value="{{ old('created_at', $lead->created_at->format('Y-m-d')) }}" required
                                class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="flex flex-col gap-1 mt-5">
                        <label for="notes" class="font-bold text-sm">Catatan Prospek</label>
                        <textarea name="notes" id="notes" rows="4"
                            placeholder="Tuliskan detail permintaan, histori chat, atau kebutuhan prospek di sini..."
                            class="p-2 border-2 border-black dark:border-white focus:outline-none focus:bg-white dark:focus:bg-slate-600 bg-white dark:bg-slate-700 text-black dark:text-white transition-colors">{{ old('notes', $lead->notes) }}</textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 mt-2">
                    <a href="{{ route('leads.index') }}"
                        class="px-6 py-3 font-black uppercase tracking-wider bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none dark:hover:shadow-none transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 font-black uppercase tracking-wider bg-[#fde047] text-black border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-none dark:hover:shadow-none transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
