@if ($paginator->hasPages())
    <div class="blog-pagination d-flex flex-wrap justify-content-flex-start">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                {{-- <a href="#" class="pagination-item disabled"><i class="fas fa-angle-left"></i></a> --}}
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item" rel="prev" aria-label="@lang('pagination.previous')">
                    <i class="fas fa-angle-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span>{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="pagination-item active" aria-current="page">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}" class="pagination-item" aria-current="page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item" rel="next" aria-label="@lang('pagination.next')">
                    <i class="fas fa-angle-right"></i>
                </a>
            @else
                {{-- <a href="#" class="pagination-item"><i class="fas fa-angle-right"></i></a> --}}
            @endif
    </div>
@endif
