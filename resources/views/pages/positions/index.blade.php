@section('title', __('messages.position-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.position')">
    </x-breadcrumb>
@endsection
@section('cssVendor')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endsection
@section('scriptVendor')
@endsection
@section('script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection
<x-app-layout>
    <div class="card">
        <div class="card-header pb-0 text-md-start text-center">

            <div class="d-flex gap-4">
                <div>
                    <h4>
                        {{ __('messages.position-index') }}
                    </h4>
                </div>
                <div class="ms-auto">
                    @can('create', App\Models\Position::class)
                        <a href="{{ route('positions.create') }}">
                            <x-button type="button" class="btn-success" :icon="'plus'">
                                {{ __('messages.add') }}
                            </x-button>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.positions.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>
                            {{ __('messages.stt') }}
                        </th>
                        <th>
                            {{ __('messages.position-name') }}
                        </th>
                        <th>
                            {{ __('messages.description') }}
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
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                    title=" {{ $item?->name }}">
                                    {{ $item?->name }}
                                </span>
                            </td>
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 30rem;"
                                    title=" {{ $item?->description }}">
                                    {{ $item?->description }}
                                </span>

                            </td>
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    @can('view', App\Models\Position::class)
                                        <a href="{{ route('positions.show', $item->id) }}" title="Xem"
                                            class="text-primary">
                                            <x-icon :icon="'eye'"></x-icon>
                                        </a>
                                    @endcan
                                    @canany(['update', 'delete'], App\Models\Position::class)
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <x-icon :icon="'dots-vertical'"></x-icon>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('update', App\Models\Position::class)
                                                    <a class="dropdown-item" href={{ route('positions.edit', $item->id) }}>
                                                        <x-icon :icon="'edit'" class="me-2"></x-icon>
                                                        {{ __('messages.edit') }}

                                                    </a>
                                                @endcan
                                                @can('delete', App\Models\Position::class)
                                                    <form action="{{ route('positions.destroy', $item->id) }}" method="POST"
                                                        style="display:inline;" id="delete-form-{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item"
                                                            onclick="onDeleteItem({{ $item->id }})">
                                                            <x-icon :icon="'trash'" class="me-2"></x-icon>
                                                            {{ __('messages.delete') }}

                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    @endcanany
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
    <script></script>
</x-app-layout>
