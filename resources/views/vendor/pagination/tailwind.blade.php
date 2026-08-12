@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-4">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm font-bold bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-500 border-2 border-black dark:border-white cursor-not-allowed transition-colors duration-300">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all duration-300">
                &laquo; Previous
            </a>
        @endif

        {{-- Pagination Elements (Numbers) --}}
        <div class="hidden sm:flex gap-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white transition-colors duration-300">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <!-- Halaman Aktif: Tetap Pastel Kuning, Teks Hitam, Border/Shadow menyesuaikan -->
                            <span aria-current="page" class="px-4 py-2 text-sm font-bold text-black bg-[#fde047] border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] transition-colors duration-300">
                                {{ $page }}
                            </span>
                        @else
                            <!-- Halaman Tidak Aktif -->
                            <a href="{{ $url }}" class="px-4 py-2 text-sm font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white hover:bg-slate-100 dark:hover:bg-slate-600 transition-all duration-300">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-bold bg-white dark:bg-slate-700 text-black dark:text-white border-2 border-black dark:border-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] dark:shadow-[2px_2px_0px_0px_rgba(255,255,255,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none dark:hover:shadow-none transition-all duration-300">
                Next &raquo;
            </a>
        @else
            <span class="px-4 py-2 text-sm font-bold bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-500 border-2 border-black dark:border-white cursor-not-allowed transition-colors duration-300">
                Next &raquo;
            </span>
        @endif
    </nav>
@endif
