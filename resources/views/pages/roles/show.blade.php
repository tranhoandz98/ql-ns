@section('title', __('messages.role-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.role-show') }}
        </h4>
        @include('pages.roles.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
            'permissionOld' => $permissionOld,
        ])
    </x-card>
</x-app-layout>
