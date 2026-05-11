@if ($paginator->hasPages())
    <nav class="ui-pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="ui-pagination__btn is-disabled">&larr; Prev</span>
        @else
            <a class="ui-pagination__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Prev</a>
        @endif

        <div class="ui-pagination__pages">
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span class="ui-pagination__page is-active">{{ $page }}</span>
                @else
                    <a class="ui-pagination__page" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="ui-pagination__btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &rarr;</a>
        @else
            <span class="ui-pagination__btn is-disabled">Next &rarr;</span>
        @endif
    </nav>
@endif
