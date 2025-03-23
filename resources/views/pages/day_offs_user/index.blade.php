@section('title', __('messages.day_off_user-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.day_off_user')">
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
        <div class="nav-align-top nav-tabs-shadow">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="{{ route('day_offs.index') }}"
                        class="nav-link {{ request()->routeIs('day_offs.index') ? 'active' : '' }}">
                        {{ __('messages.day_off-index') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('day_offs_user.index') }}"
                        class="nav-link {{ request()->routeIs('day_offs_user.index') ? 'active' : '' }}">
                        {{ __('messages.day_off_user-index') }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-header pb-0 text-md-start text-center">
            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.day_off_user-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    @can('allocation', App\Models\DayOffs::class)
                        <form action="{{ route('day_offs_user.createDayOffForAllUsers') }}" method="POST">
                            @csrf
                            <x-button type="submit" class="btn-info" :icon="'home-plus'">
                                {{ __('messages.day_off-allocation') }}
                            </x-button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.day_offs_user.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">

            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>
                            {{ __('messages.stt') }}
                        </th>
                        <th>
                            {{ __('messages.user_id') }}
                        </th>

                        <th>
                            {{ __('messages.day_off_user-num') }}
                        </th>
                        <th>
                            {{ __('messages.day_off_user-remaining_leave') }}
                        </th>
                        <th>
                            {{ __('messages.day_off_user-start_at') }}
                        </th>
                        <th>
                            {{ __('messages.created_at') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listAll as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                [{{ $item?->user?->code }}] - {{ $item?->user?->name }}
                            </td>
                            <td>{{ number_format($item->num, 2) }}</td>
                            <td>{{ number_format($item->remaining_leave, 2) }}</td>
                            <td>{{ formatDateView($item->start_at, 'Y') }}</td>
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {!! $listAll->links('vendor.pagination.bootstrap-5') !!}
            </div>
        </div>
    </div>
    <script></script>
</x-app-layout>
