@section('title', __('messages.role-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.role')">
    </x-breadcrumb>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endsection

<x-app-layout>
    <div class="card">
        <div class="card-header pb-0 text-md-start text-center">
            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.role-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('roles.create') }}">
                        <x-button type="button" class="btn-success" :icon="'plus'">
                            {{ __('messages.add') }}
                        </x-button>
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="dt_adv_search" method="GET">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <input type="search" class="form-control dt-input dt-full-name" data-column="1"
                            value="{{ request('name') }}" placeholder="Tên vai trò" name="name"
                            data-column-index="0" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="d-flex gap-4">
                            <x-button :icon="'search'" class="submit-btn">
                                {{ __('messages.search') }}
                            </x-button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        <div class="card-datatable table-responsive ">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>
                            {{ __('messages.stt') }}
                        </th>
                        <th>
                            {{ __('messages.role-name') }}
                        </th>
                        <th>
                            {{ __('messages.role-description') }}
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

                            <td style="max-width: 7rem;">
                                <span class="text-truncate-3-lines" title=" {{ $item->name }}">
                                    {{ $item->name }}
                                </span>
                            </td>
                            <td style="max-width: 8rem;">
                                <span class="text-truncate-3-lines" title=" {{ $item->description }}">
                                    {{ $item->description }}
                                </span>
                            </td>
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('roles.show', $item->id) }}" title="{{ __('messages.view') }}"
                                        class="text-primary">
                                        <x-icon :icon="'eye'"></x-icon>
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <x-icon :icon="'dots-vertical'"></x-icon>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href={{ route('roles.edit', $item->id) }}>
                                                <x-icon :icon="'edit'" class="me-2"></x-icon>
                                                {{ __('messages.edit') }}
                                            </a>
                                            <form action="{{ route('roles.destroy', $item->id) }}" method="POST"
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

@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

@endsection
