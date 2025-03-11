@if ($paginator->hasPages())
    @section('cssVendor')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    @endsection
    @section('scriptVendor')
        <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    @endsection
    @section('script')
        <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    @endsection

    <nav class="d-flex justify-items-center justify-content-between px-4 align-items-center">
        <div class="d-flex justify-content-between flex-fill d-sm-none align-items-center">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-center justify-content-sm-between">
            <div>
                <p class="small text-muted mb-0">
                    @lang('messages.showing')
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    @lang('messages.to')
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    @lang('messages.of')
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    @lang('messages.results')
                </p>
            </div>
            @php
                // dd($paginator);
            @endphp
            <div class="d-flex gap-4 align-items-center">
                <div class="">
                    <select class="select2 form-select" data-allow-clear="false" onchange="window.location.href = '{{ $paginator->url(1) }}&perPage=' + this.value">
                        @foreach ([5, 10, 25, 50, 100] as $perPage)
                            <option value="{{ $perPage }}" {{ request()->get('perPage', 10) == $perPage ? 'selected' : '' }}>
                                {{ $perPage }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item first disabled" aria-disabled="true">
                            <span class="page-link " aria-hidden="true">
                                <x-icon :icon="'chevrons-left'" class="icon-sm"></x-icon>
                            </span>
                        </li>
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">
                                <x-icon :icon="'chevron-left'" class="icon-sm"></x-icon>
                            </span>
                        </li>
                    @else
                        <li class="page-item first">
                            <a class="page-link" href="{{ $paginator->url(1) }}">
                                <x-icon :icon="'chevrons-left'" class="icon-sm"></x-icon></a>
                        </li>
                        <li class="page-item prev">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                                <x-icon :icon="'chevron-left'" class="icon-sm"></x-icon>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}

                    @foreach ($elements as $element)
                        @if (is_array($element))
                            @php
                                $current = $paginator->currentPage();
                                $total = $paginator->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($total, $current + 1);
                            @endphp

                            @foreach ($element as $page => $url)
                                @if ($page >= $start && $page <= $end)
                                    @if ($page == $current)
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item next">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                                <x-icon :icon="'chevron-right'" class="icon-sm"></x-icon>
                            </a>
                        </li>
                        <li class="page-item last">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                                <x-icon :icon="'chevrons-right'" class="icon-sm"></x-icon>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">
                                <x-icon :icon="'chevron-right'" class="icon-sm"></x-icon>
                            </span>
                        </li>
                        <li class="page-item last disabled">
                            <a class="page-link" href="javascript:void(0);">
                                <x-icon :icon="'chevrons-right'" class="icon-sm"></x-icon>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
