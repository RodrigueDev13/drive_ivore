@if ($vehicles->hasPages())
    <div class="flex justify-center mt-8">
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
            {{-- Previous Page Link --}}
            @if ($vehicles->onFirstPage())
                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-l cursor-not-allowed">
                    Précédent
                </span>
            @else
                <a href="{{ $vehicles->previousPageUrl() }}" rel="prev" class="px-3 py-1 bg-drive-teal text-white rounded-l hover:bg-opacity-90">
                    Précédent
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex">
                @foreach ($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
                    @if ($page == $vehicles->currentPage())
                        <span class="px-3 py-1 bg-drive-teal text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 bg-white text-drive-teal hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($vehicles->hasMorePages())
                <a href="{{ $vehicles->nextPageUrl() }}" rel="next" class="px-3 py-1 bg-drive-teal text-white rounded-r hover:bg-opacity-90">
                    Suivant
                </a>
            @else
                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-r cursor-not-allowed">
                    Suivant
                </span>
            @endif
        </nav>
    </div>
@endif
