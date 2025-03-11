@section('title', __('messages.user-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.user')" :urlParent="route('users.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.user-create') }}
        </h4>
        @include('pages.users.partials.form', [
            'action' => route('users.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
