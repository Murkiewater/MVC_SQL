@if ($paginator->hasPages())
    <nav class="pagination-container" role="navigation" aria-label="Pagination Navigation">
        
        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="page-link disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev" aria-label="@lang('pagination.previous')">
                    &lsaquo;
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="page-link separator" aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="@lang('pagination.next')">
                    &rsaquo;
                </a>
            @else
                <span class="page-link disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </span>
            @endif
        </div>
        
        <div class="per-page-form-container">
            <span class="per-page-label">Элементов на странице:</span>
            <form method="get" action="{{ url()->current() }}">
                <select name="perpage" class="per-page-select">
                    @foreach([2, 3, 4, 5, 10, 20] as $perPageOption)
                        <option value="{{ $perPageOption }}" 
                                @if ($paginator->perPage() == $perPageOption) selected @endif>
                            {{ $perPageOption }}
                        </option>
                    @endforeach
                </select>
                <input type="submit" value="Изменить" class="btn-per-page-submit">
            </form>
        </div>

    </nav>
@endif