@section('title', __('messages.user-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card :title=" __('messages.user-create') ">
        @include('pages.users.partials.form', [
            'action' => route('users.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
