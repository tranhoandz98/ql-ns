@section('title', __('messages.timekeeping-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.timekeeping')">
    </x-breadcrumb>
@endsection
@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

@endsection
@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-date.js') }}"></script>
@endsection
<x-app-layout>
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.timekeeping-index') }}
                    </h4>
                </div>

                <div class="ms-auto">
                    <a href="{{ route('timekeeping.create') }}">
                        <x-button type="button" class="btn-success" :icon="'plus'">
                            {{ __('messages.add') }}
                        </x-button>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @include('pages.timekeeping.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover tree-table">
                <colgroup>
                    <col style="width: 3%;">
                    <col style="width: 10%;">
                    <col style="width: 20%;">
                    <col style="width: 12%;">
                    <col style="width: 12%;">
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                    <col style="width: 10%;">
                </colgroup>
                <thead class="">
                    <tr>
                        <th>
                        </th>
                        <th>
                            {{ __('messages.time') }}
                        </th>
                        <th>
                            {{ __('messages.timekeeping-user_id') }}
                        </th>
                        <th>{{ __('messages.timekeeping-checkin') }}</th>
                        <th>{{ __('messages.timekeeping-checkout') }}</th>
                        <th>{{ __('messages.timekeeping-work_time') }}</th>
                        <th>{{ __('messages.timekeeping-num_work_date') }}</th>
                        <th>{{ __('messages.timekeeping-work_late') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listAll as $index => $parent)
                        <tr class=" table-bold tree-toggle" data-bs-toggle="collapse"
                            data-bs-target="#tree-{{ $index }}">
                            <td>
                                <i class="icon-base ti tabler-chevron-right"></i>
                            </td>
                            <td>
                                @if(strlen($parent->group_period) === 7)
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $parent->group_period)->format('m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::createFromFormat('Y', $parent->group_period)->format('Y') }}
                                @endif
                            </td>
                            <td>
                                [{{ $parent?->user?->code }}] - {{ $parent?->user?->name }}
                            </td>
                            <td></td> <!-- Check-in trống -->
                            <td></td> <!-- Check-out trống -->
                            <td>{{ $parent->total_work_time }}</td>
                            <td>{{ number_format($parent->total_work_days, 2) }}</td>
                            <td>{{ number_format($parent->total_late_minutes, 2) }}</td>
                            <td>
                            </td>
                        </tr>

                        @foreach ($parent->records as $child)
                            <tr class="collapse tree-content" id="tree-{{ $index }}">
                                <td></td> <!-- Tháng trống -->
                                <td></td> <!-- Tháng trống -->
                                <td>
                                    [{{ $parent?->user?->code }}] - {{ $parent?->user?->name }}
                                </td>
                                <td>{{ formatDateTimeView($child->checkin) }}</td>
                                <td>{{ formatDateTimeView($child->checkout) }}</td>
                                <td>{{ $child->work_time }}</td>
                                <td>{{ number_format($child->num_work_date, 2) }}</td>
                                <td>{{ $child->work_late }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <x-icon :icon="'dots-vertical'"></x-icon>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href={{ route('timekeeping.edit', $child->id) }}>
                                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                                {{ __('messages.edit') }}
                                            </a>
                                            <form action="{{ route('timekeeping.destroy', $child->id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $child->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item delete-btn"
                                                    onclick="onDeleteItem({{ $child->id }})"
                                                    >
                                                    <x-icon :icon="'trash'" class="me-2"></x-icon>
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </td> <!-- Hành động trống -->
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{-- {!! $listAll->links('vendor.pagination.bootstrap-5') !!} --}}
            </div>
        </div>
        <script>
            document.querySelectorAll('.tree-toggle').forEach(row => {
                row.addEventListener('click', function() {
                    let target = document.querySelector(this.dataset.bsTarget);
                    let icon = this.querySelector('i');

                    const isExpanded = row.getAttribute('aria-expanded') === 'true';
                    if (isExpanded) {
                        icon.classList.remove('tabler-chevron-right');
                        icon.classList.add('tabler-chevron-down');
                    } else {
                        icon.classList.remove('tabler-chevron-down');
                        icon.classList.add('tabler-chevron-right');
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
