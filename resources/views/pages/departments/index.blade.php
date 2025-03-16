@section('title', __('messages.department-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.department')">
    </x-breadcrumb>
@endsection
@section('cssVendor')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endsection
@section('scriptVendor')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection
<x-app-layout>
    <div class="card">
        <div class="card-header pb-0 text-md-start text-center">

            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.department-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('departments.create') }}">
                        <x-button type="button" class="btn-success" :icon="'plus'">
                            {{ __('messages.add') }}
                        </x-button>
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.departments.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>
                            {{ __('messages.stt') }}
                        </th>
                        <th>
                            {{ __('messages.department-name') }}
                        </th>
                        <th>
                            {{ __('messages.department-manager_id') }}
                        </th>
                        <th>
                            {{ __('messages.department-founding_at') }}
                        </th>

                        <th>
                            {{ __('messages.created_at') }}
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
                                <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                    title=" {{ $item?->name }}">
                                    {{ $item?->name }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                    title=" {{ $item?->manager?->name }}">
                                    {{ $item?->manager?->name }}
                                </span>
                            </td>
                            <td>{{ formatDateView($item->founding_at) }}</td>
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                            <td>
                                @php
                                    $statusBadge = '';
                                    $colorBadge = '';
                                    foreach ($StatusGlobalEnum as $status) {
                                        if ($status['id'] == $item->status) {
                                            $statusBadge = $status['name'];
                                            $colorBadge = $status['color'];
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="badge text-bg-{{ $colorBadge ?? 'secondary' }}">
                                    {{ $statusBadge }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('departments.show', $item->id) }}" title="Xem"
                                        class="text-primary">
                                        <x-icon :icon="'eye'"></x-icon>
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <x-icon :icon="'dots-vertical'"></x-icon>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href={{ route('departments.edit', $item->id) }}>
                                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                                {{ __('messages.edit') }}

                                            </a>
                                            <form action="{{ route('departments.destroy', $item->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <x-icon :icon="'trash'" class="me-2"></x-icon>
                                                    {{ __('messages.delete') }}

                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {!! $listAll->links('vendor.pagination.bootstrap-5') !!}
            </div>

        </div>
    </div>
    <script>
        function confirmDelete(url) {
            if (confirm("Bạn có chắc chắn muốn xóa không?")) {
                window.location.href = url;
            }
        }
    </script>
</x-app-layout>
