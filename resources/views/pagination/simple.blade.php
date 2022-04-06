@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center">
        <ul class="pagination pagination-flat">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                {{--
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.first')">
                    <span class="page-link" aria-hidden="true">
                        <i class="mi-first-page"></i>
                    </span>
                </li>
                --}}
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <i class="mi-arrow-back"></i>
                    </span>
                </li>
            @else
                {{--
                <li class="page-item">
                    <a class="page-link legitRipple" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.first')">
                        <i class="mi-first-page"></i>
                    </a>
                </li>
                --}}
                <li class="page-item">
                    <a class="page-link legitRipple" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="mi-arrow-back"></i>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link legitRipple" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="mi-arrow-forward"></i>
                    </a>
                </li>
                {{--
                <li class="page-item">
                    <a class="page-link legitRipple" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.last')">
                        <i class="mi-last-page"></i>
                    </a>
                </li>
                --}}
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <i class="mi-arrow-forward"></i>
                    </span>
                </li>
                {{--
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.last')">
                    <span class="page-link" aria-hidden="true">
                        <i class="mi-last-page"></i>
                    </span>
                </li>
                --}}
            @endif
        </ul>
    </nav>
@endif
