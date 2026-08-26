@extends('layouts.app')
@section('header_title', 'Kelola Leads (Board View)')

@section('content')
    <!-- Tombol Tambah & Export -->
    <div
        class="mb-6 flex justify-between items-center bg-white dark:bg-slate-800 p-4 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm transition-colors duration-300">
        <h3 class="font-bold text-lg dark:text-white">Pipeline Leads</h3>
        <div class="flex gap-2">
            <a href="{{ route('leads.create') }}"
                class="px-4 py-2 text-sm font-bold bg-[#93c5fd] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">+
                Tambah Lead</a>
        </div>
    </div>

    <!-- Alpine Wrapper untuk Modal -->
    <div x-data="{
        modalOpen: false,
        activeLead: null,
        openDetail(lead) {
            this.activeLead = lead;
            this.modalOpen = true;
        },
        cleanPhone(phone) {
            if (!phone) return '';
            let cleaned = phone.replace(/\D/g, '');
            if (cleaned.startsWith('0')) {
                cleaned = '62' + cleaned.substring(1);
            }
            return cleaned;
        }
    }">

        <!-- Kanban Board Wrapper dengan Pattern -->
        <div
            class="relative bg-white dark:bg-slate-900 border-2 border-black dark:border-white shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rounded-sm mb-6 transition-colors duration-300 overflow-hidden">

            <!-- Background Pattern (Dot Matrix) -->
            <div
                class="absolute inset-0 pointer-events-none opacity-40 dark:opacity-60 bg-[radial-gradient(#94a3b8_2px,transparent_2px)] dark:bg-[radial-gradient(#475569_2px,transparent_2px)] bg-[size:24px_24px]">
            </div>

            <!-- Kanban Board Container (Diberi relative & z-10 agar berada di atas pattern) -->
            <!-- Tambahkan id="kanban-board" dan class cursor-grab -->
            <div id="kanban-board"
                class="relative z-10 p-6 flex gap-4 overflow-x-auto items-start min-h-[400px] cursor-grab">

                <!-- LOOPING DINAMIS DARI DATABASE -->
                @foreach ($statuses as $status)
                    <!-- Kolom Status -->
                    <div
                        class="w-80 shrink-0 flex flex-col bg-slate-50 dark:bg-slate-800 border-2 border-black dark:border-white rounded-sm transition-colors duration-300 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)]">
                        <!-- Header Kolom -->
                        <div
                            class="{{ $status->color }} p-3 border-b-2 border-black dark:border-white text-black font-black uppercase tracking-widest text-center transition-colors">
                            {{ $status->name }} ({{ $leads->get($status->id, collect())->count() }})
                        </div>

                        <!-- Area Drop Drag (Kanban Column) -->
                        <div class="p-3 flex flex-col gap-3 min-h-[300px] kanban-column" data-status="{{ $status->id }}">
                            @foreach ($leads->get($status->id, []) as $lead)
                                <!-- Card Lead -->
                                <div data-id="{{ $lead->id }}" @click="openDetail({{ json_encode($lead) }})"
                                    class="bg-white dark:bg-slate-700 p-3 border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] cursor-pointer hover:-translate-y-1 hover:translate-x-1 hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] dark:hover:shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] transition-all">

                                    <h4 class="font-bold text-lg dark:text-white mb-1">{{ $lead->name }}</h4>
                                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-300 mb-2">
                                        {{ $lead->company ?? 'No Company' }}</p>

                                    <div
                                        class="flex justify-between items-center text-xs border-t-2 border-black dark:border-white border-dashed pt-2 mt-2 transition-colors">
                                        <span
                                            class="font-bold bg-slate-200 dark:bg-slate-600 dark:text-white px-2 py-1 transition-colors">{{ $lead->source ?? 'Unknown' }}</span>
                                        <span
                                            class="dark:text-slate-300 font-bold transition-colors">{{ $lead->created_at->format('d M') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Detail & Aksi -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
            style="display: none;" x-transition>
            <div @click.away="modalOpen = false"
                class="bg-white dark:bg-slate-800 w-full max-w-2xl border-2 border-black dark:border-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] dark:shadow-[8px_8px_0px_0px_rgba(255,255,255,1)] rounded-sm flex flex-col transition-colors duration-300">

                <div
                    class="p-4 border-b-2 border-black dark:border-white flex justify-between items-center bg-[#d8b4fe] transition-colors">
                    <h3 class="font-black text-xl text-black">Detail Prospek Lengkap</h3>
                    <button @click="modalOpen = false"
                        class="font-bold text-black text-xl hover:scale-125 transition-transform">&times;</button>
                </div>

                <!-- Area Konten -->
                <div
                    class="p-6 flex flex-col gap-6 text-black dark:text-white transition-colors max-h-[70vh] overflow-y-auto">

                    <!-- Grid Informasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Nama
                                Lengkap</p>
                            <p class="font-bold text-lg" x-text="activeLead?.name"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mb-1">
                                Status Saat Ini</p>
                            <span
                                class="px-2 py-1 text-xs font-bold text-black border border-black dark:border-white inline-block uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)]"
                                :class="activeLead?.status?.color"
                                x-text="activeLead?.status?.name || 'Tanpa Status'"></span>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Alamat
                                Email</p>
                            <p class="font-bold" x-text="activeLead?.email || '-'"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Nomor
                                Telepon</p>
                            <p class="font-bold" x-text="activeLead?.phone"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">
                                Perusahaan</p>
                            <p class="font-bold" x-text="activeLead?.company || '-'"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Sumber
                                Lead (Source)</p>
                            <p class="font-bold" x-text="activeLead?.source || '-'"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">PIC
                                Marketing</p>
                            <p class="font-bold" x-text="activeLead?.marketing?.name || 'Tidak diketahui'"></p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Tanggal
                                Input</p>
                            <p class="font-bold"
                                x-text="activeLead?.created_at ? new Date(activeLead.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'">
                            </p>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Catatan</p>
                        <div class="bg-slate-50 dark:bg-slate-700 p-4 border-2 border-black dark:border-white mt-1 min-h-[80px] transition-colors whitespace-pre-wrap leading-relaxed"
                            x-text="activeLead?.notes || 'Tidak ada catatan.'"></div>
                    </div>
                </div>

                <!-- Tombol Aksi di dalam Modal -->
                <div
                    class="p-4 border-t-2 border-black dark:border-white flex flex-wrap justify-end gap-3 bg-slate-50 dark:bg-slate-900 transition-colors shrink-0">

                    <a :href="'https://wa.me/' + cleanPhone(activeLead?.phone)" target="_blank"
                        class="px-4 py-2 flex items-center gap-2 font-bold bg-[#86efac] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.42 9.49c-.19-.09-1.1-.54-1.27-.61s-.29-.09-.42.1-.5.61-.61.73-.23.14-.42.04a5.1 5.1 0 0 1-1.5-.92 5.61 5.61 0 0 1-1.04-1.3c-.11-.19-.01-.29.08-.38.09-.08.19-.22.28-.33.1-.11.13-.19.19-.32.06-.13.03-.23-.01-.33-.05-.09-.42-1.02-.58-1.4-.15-.37-.31-.32-.42-.32h-.36c-.13 0-.33.05-.5.23-.17.18-.65.64-.65 1.55s.66 1.8 .76 1.94c.09.13 1.32 2.01 3.2 2.82.45.19.8.31 1.07.39.45.14.86.12 1.18.08.36-.05 1.1-.45 1.25-.88.15-.43.15-.8.1-.88-.04-.07-.15-.12-.34-.21zM8 14c-1.3 0-2.55-.33-3.66-.9l-.26-.14-2.7.71.72-2.63-.16-.25A5.95 5.95 0 0 1 2 8c0-3.3 2.7-6 6-6s6 2.7 6 6-2.7 6-6 6zm0-13.5C4.14 1.5.99 4.64.99 8.5c0 1.25.32 2.47.93 3.55L.5 16l4.08-1.07A6.96 6.96 0 0 0 8 15.5c3.86 0 7-3.14 7-7s-3.14-7-7-7z" />
                        </svg>
                        Hubungi WA
                    </a>

                    <a :href="'{{ url('leads') }}/' + activeLead?.id + '/edit'"
                        class="px-4 py-2 font-bold bg-[#fde047] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                        Edit
                    </a>

                    <form :action="'{{ url('leads') }}/' + activeLead?.id" method="POST"
                        onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 font-bold bg-[#fca5a5] text-black border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Library Drag and Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('.kanban-column');

            columns.forEach(column => {
                new Sortable(column, {
                    group: 'leads',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onEnd: function(evt) {
                        const leadId = evt.item.dataset.id;
                        const newStatus = evt.to.dataset.status;

                        // PAYLOAD HARUS lead_status_id AGAR MATCH DENGAN CONTROLLER
                        fetch(`/leads/${leadId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                lead_status_id: newStatus
                            })
                        }).then(response => {
                            if (!response.ok) alert(
                                'Gagal memindahkan data. Refresh halaman.');
                        });
                    }
                });
            });
            // --- FITUR DRAG TO SCROLL ---
            const board = document.getElementById('kanban-board');
            let isDown = false;
            let startX;
            let startY;
            let scrollLeft;
            let scrollTop;

            board.addEventListener('mousedown', (e) => {
                // Proteksi: Jangan aktifkan scroll container kalau kursor menekan Card Lead (SortableJS) atau Tombol
                if (e.target.closest('[data-id]') || e.target.closest('button') || e.target.closest('a'))
                    return;

                isDown = true;
                board.classList.add('cursor-grabbing'); // Ubah ikon kursor jadi menggenggam
                board.classList.remove('cursor-grab');

                // Simpan posisi awal kursor dan posisi scroll saat ini
                startX = e.pageX - board.offsetLeft;
                startY = e.pageY - board.offsetTop;
                scrollLeft = board.scrollLeft;
                scrollTop = board.scrollTop;
            });

            board.addEventListener('mouseleave', () => {
                isDown = false;
                board.classList.remove('cursor-grabbing');
                board.classList.add('cursor-grab');
            });

            board.addEventListener('mouseup', () => {
                isDown = false;
                board.classList.remove('cursor-grabbing');
                board.classList.add('cursor-grab');
            });

            board.addEventListener('mousemove', (e) => {
                if (!isDown) return; // Hentikan kalau mouse tidak ditahan
                e.preventDefault(); // Cegah blok teks ga sengaja saat narik

                const x = e.pageX - board.offsetLeft;
                const y = e.pageY - board.offsetTop;

                // Angka 2 di bawah adalah multiplier agar scroll terasa lebih cepat. Bisa lu ubah sesuai selera (1 untuk normal, 3 untuk ngebut)
                const walkX = (x - startX) * 2;
                const walkY = (y - startY) * 2;

                board.scrollLeft = scrollLeft - walkX;
                board.scrollTop = scrollTop - walkY;
            });
        });
    </script>
@endsection
