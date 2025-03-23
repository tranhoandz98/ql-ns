@section('title', __('messages.notification-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.notification')">
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
                        {{ __('messages.notification-index') }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('pages.notifications.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>
                            {{ __('messages.stt') }}
                        </th>
                        <th>
                            {{ __('messages.notification-title') }}
                        </th>
                        <th>
                            {{ __('messages.notification-content') }}
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
                        <tr
                            >
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="javascript:0"
                                onclick="handleNotificationClick(event, '{{ $item->id }}', '{{ $item->link ?? '#' }}')"
                                >
                                    <span class="text-truncate-3-lines" style="max-width: 10rem;"
                                        title=" {{ $item?->title }}">
                                        {{ $item?->title }}
                                    </span>
                                </a>

                            </td>
                            <td>
                                <span class="text-truncate-3-lines" style="max-width: 20rem;"
                                    title=" {{ $item?->content }}"
                                    >
                                    {{ $item?->content }}
                                </span>
                            </td>
                            <td>{{ formatDateTimeView($item->created_at) }}</td>
                            <td>
                                @php
                                    $statusBadge = '';
                                    $colorBadge = '';
                                    foreach ($statusNotifyReadEnum as $status) {
                                        if ($status['id'] == $item->is_read) {
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
                                    <a href="javascript:0" title="Xem" class="text-primary"
                                        onclick="handleNotificationClick(event, '{{ $item->id }}', '{{ $item->link ?? '#' }}')">
                                        <x-icon :icon="'eye'"></x-icon>
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <x-icon :icon="'dots-vertical'"></x-icon>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('notifications.updateRead', $item->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @if ($item->is_read === App\Enums\User\StatusNotifyReadEnum::UNREAD->value)
                                                    <button type="submit" class="dropdown-item">
                                                        <x-icon :icon="'check'" class="me-2"></x-icon>
                                                        {{ __('messages.notification-read_tick') }}
                                                    </button>
                                                @else
                                                    <button type="submit" class="dropdown-item">
                                                        <x-icon :icon="'check'" class="me-2"></x-icon>
                                                        {{ __('messages.notification-un_read_tick') }}
                                                    </button>
                                                @endif
                                            </form>

                                            <form action="{{ route('notifications.destroy', $item->id) }}"
                                                method="POST" style="display:inline;"
                                                id="delete-form-{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item"
                                                    onclick="onDeleteItem({{ $item->id }})">
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
    <script></script>
    <script>
        async function handleNotificationClick(event, notificationId, redirectUrl) {
            try {
                // Call the notification read API
                const response = await fetch(`{{ route('notifications.read', '') }}/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                });
                if (response.ok) {
                    // If API call is successful, redirect to the specified URL
                    window.location.href = redirectUrl;
                } else {
                    console.error('Failed to mark notification as read');
                }
            } catch (error) {
                console.error('Error:', error);
            }

        }
    </script>
</x-app-layout>
