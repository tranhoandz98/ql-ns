@section('title', __('messages.user-list'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.user')">
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
                        {{ __('messages.user-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('users.create') }}">
                        <x-button type="button" class="btn-success" :icon="'plus'">
                            {{ __('messages.add') }}
                        </x-button>
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.users.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
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
                            {{ __('messages.user-name') }}
                        </th>

                        <th>
                            {{ __('messages.user-email') }}
                        </th>
                        <th>
                            {{ __('messages.user-role_id') }}
                        </th>
                        <th>
                            {{ __('messages.user-type') }}
                        </th>
                        <th>
                            {{ __('messages.status') }}
                        </th>
                        <th>
                            {{ __('messages.created_at') }}
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
                            <td>{{ $item->code }}</td>
                            <td style="">
                                <div class="d-flex gap-4 align-items-center">
                                    <div>
                                        <img id="preview"
                                            src="{{ $item?->avatar ? asset('storage/' . $item->avatar) : asset('assets/img/avatars/default.jpg') }}"
                                            class="rounded-circle account-file-input"
                                            style="width: 3rem; height: 3rem; object-fit: cover;">
                                    </div>
                                    <div class="max-width: 5rem;">
                                        <div class="text-truncate fw-500" title=" {{ $item->name }}">
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-truncate" title=" {{ $item?->department?->name }}">
                                            <small>
                                                {{ __('messages.user-department_id') }}:
                                                {{ $item?->department?->name }}
                                            </small>
                                        </div>
                                        <div class="text-truncate" title=" {{ $item?->position?->name }}">
                                            <small>
                                                {{ __('messages.user-position_id') }}:
                                                {{ $item?->position?->name }}
                                            </small>
                                        </div>
                                        <div class="text-truncate" title=" {{ $item?->manager?->name }}">
                                            <small>
                                                {{ __('messages.user-manager_id') }}:
                                                {{ $item?->manager?->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                    title=" {{ $item?->email }}">
                                    {{ $item?->email }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 7rem;"
                                    title=" {{ $item?->role?->name }}">

                                    {{ $item?->role?->name }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusBadge = '';
                                    $colorBadge = '';
                                    foreach ($TypeUserEnum as $type) {
                                        if ($type['id'] == $item->type) {
                                            $statusBadge = $type['name'];
                                            $colorBadge = $type['color'];
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="badge text-bg-{{ $colorBadge ?? 'secondary' }}">
                                    {{ $statusBadge }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $statusBadge = '';
                                    $colorBadge = '';
                                    foreach ($StatusUserEnum as $status) {
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
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('users.show', $item->id) }}" title="Xem" class="text-primary">
                                        <x-icon :icon="'eye'"></x-icon>
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <x-icon :icon="'dots-vertical'"></x-icon>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href={{ route('users.edit', $item->id) }}>
                                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                                {{ __('messages.edit') }}

                                            </a>
                                            <form action="{{ route('users.destroy', $item->id) }}" method="POST"
                                                style="display:inline;"
                                                id="delete-form-{{ $item->id }}"
                                                >
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item"
                                                onclick="onDeleteItem({{ $item->id }})"

                                                >
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
