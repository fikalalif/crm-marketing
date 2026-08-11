@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-4">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm font-bold bg-slate-200 text-slate-400 border-2 border-black cursor-not-allowed">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-bold bg-white text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                &laquo; Previous
            </a>
        @endif

        {{-- Pagination Elements (Numbers) --}}
        <div class="hidden sm:flex gap-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 text-sm font-bold bg-white border-2 border-black">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="px-4 py-2 text-sm font-bold bg-[#fde047] border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-sm font-bold bg-white border-2 border-black hover:bg-slate-100 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-bold bg-white text-black border-2 border-black shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[1px] hover:translate-x-[1px] hover:shadow-none transition-all">
                Next &raquo;
            </a>
        @else
            <span class="px-4 py-2 text-sm font-bold bg-slate-200 text-slate-400 border-2 border-black cursor-not-allowed">
                Next &raquo;
            </span>
        @endif
    </nav>
@endif
