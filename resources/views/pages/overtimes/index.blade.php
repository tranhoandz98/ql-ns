@section('title', __('messages.overtime-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.overtime')">
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

    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-date.js') }}"></script>
@endsection
<x-app-layout>
    <div class="card">
        <div class="card-header pb-0 text-md-start text-center">

            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.overtime-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    @can('create', App\Models\Overtimes::class)
                        <a href="{{ route('overtimes.create') }}">
                            <x-button type="button" class="btn-success" :icon="'plus'">
                                {{ __('messages.add') }}
                            </x-button>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.overtimes.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            @if (request('group_by'))
                <table class="table table-hover tree-table">
                    <colgroup>
                        <col style="width: 3%;">
                        <col style="width: 10%;">
                        <col style="width: 20%;">
                        <col style="width: 10%;">
                        <col style="width: 10%;">
                        <col style="width: 10%;">
                        <col style="width: 10%;">
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
                                {{ __('messages.overtime-user_id') }}
                            </th>
                            <th>
                                {{ __('messages.code') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_start') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_end') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-type') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_time') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-actual_time') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-content') }}
                            </th>
                            <th>
                                {{ __('messages.status') }}
                            </th>
                            <th>
                                {{ __('messages.action') }}
                            </th>
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
                                    @if (strlen($parent->group_period) === 7)
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $parent->group_period)->format('m/Y') }}
                                    @else
                                        {{ \Carbon\Carbon::createFromFormat('Y', $parent->group_period)->format('Y') }}
                                    @endif
                                </td>
                                <td>
                                    [{{ $parent?->user?->code }}] - {{ $parent?->user?->name }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ number_format($parent->total_expected_time, 2) }}</td>
                                <td>{{ number_format($parent->total_actual_time, 2) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            @foreach ($parent->records as $child)
                                <tr class="collapse tree-content" id="tree-{{ $index }}">
                                    <td></td> <!-- Tháng trống -->
                                    <td></td> <!-- Tháng trống -->
                                    <td>
                                        [{{ $parent?->user?->code }}] - {{ $parent?->user?->name }}
                                    </td>
                                    <td>{{ $child->code }}</td>
                                    <td>{{ formatDateTimeView($child->expected_start) }}</td>
                                    <td>{{ formatDateTimeView($child->expected_end) }}</td>
                                    <td>
                                        @php
                                            $statusBadgeType = '';
                                            foreach ($typeOvertimeEnum as $status) {
                                                if ($status['id'] == $child->type) {
                                                    $statusBadgeType = $status['name'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <span class="">
                                            {{ $statusBadgeType }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($child->expected_time, 2) }}</td>
                                    <td>{{ number_format($child->actual_time, 2) }}</td>
                                    <td>
                                        <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                            title=" {{ $child?->content }}">
                                            {{ $child?->content }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusBadge = '';
                                            $colorBadge = '';
                                            foreach ($statusOverTimeEnum as $status) {
                                                if ($status['id'] == $child->status) {
                                                    $statusBadge = $status['name'];
                                                    $colorBadge = $status['color'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <span>
                                            <span class="badge text-bg-{{ $colorBadge ?? 'secondary' }}"
                                                style="width: 6rem;white-space: normal;">
                                                {{ $statusBadge }}
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        @include('pages.overtimes.partials.action-index', [
                                            'item' => $child,
                                        ])
                                    </td> <!-- Hành động trống -->
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th>
                                {{ __('messages.stt') }}
                            </th>
                            <th>
                                {{ __('messages.code') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-user_id') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_start') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_end') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-type') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-expected_time') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-actual_time') }}
                            </th>
                            <th>
                                {{ __('messages.overtime-content') }}
                            </th>
                            <th>
                                {{ __('messages.status') }}
                            </th>
                            <th>
                                {{ __('messages.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listAll as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $item->code }}
                                </td>
                                <td>
                                    [{{ $item?->user?->code }}] - {{ $item?->user?->name }}
                                </td>
                                <td>{{ formatDateTimeView($item->expected_start) }}</td>
                                <td>{{ formatDateTimeView($item->expected_end) }}</td>
                                <td>
                                    @php
                                        $statusBadgeType = '';
                                        foreach ($typeOvertimeEnum as $status) {
                                            if ($status['id'] == $item->type) {
                                                $statusBadgeType = $status['name'];
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span class="">
                                        {{ $statusBadgeType }}
                                    </span>
                                </td>
                                <td>{{ number_format($item->expected_time, 2) }}</td>
                                <td>{{ number_format($item->actual_time, 2) }}</td>
                                <td>
                                    <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                        title=" {{ $item?->content }}">
                                        {{ $item?->content }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $statusBadge = '';
                                        $colorBadge = '';
                                        foreach ($statusOverTimeEnum as $status) {
                                            if ($status['id'] == $item->status) {
                                                $statusBadge = $status['name'];
                                                $colorBadge = $status['color'];
                                                break;
                                            }
                                        }
                                    @endphp
                                    <span>
                                        <span class="badge text-bg-{{ $colorBadge ?? 'secondary' }}"
                                            style="width: 6rem;white-space: normal;">
                                            {{ $statusBadge }}
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    @include('pages.overtimes.partials.action-index', [
                                        'item' => $item,
                                    ])

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $listAll->links('vendor.pagination.bootstrap-5') !!}
                </div>
            @endif
        </div>
    </div>
    <script></script>
</x-app-layout>
