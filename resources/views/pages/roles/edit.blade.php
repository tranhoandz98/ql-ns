@section('title', __('messages.role-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h5>
            {{ __('messages.role-edit') }}
        </h5>
        @include('pages.roles.partials.form', [
            'action' => route('roles.update', $result->id),
            'method' => 'PUT',
            'result' => $result,
            'permissionOld' => $permissionOld,
        ])
    </x-card>
</x-app-layout>
