@section('title', __('messages.role-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h5>
            {{ __('messages.role-create') }}

        </h5>
        @include('pages.roles.partials.form', [
            'action' => route('roles.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
