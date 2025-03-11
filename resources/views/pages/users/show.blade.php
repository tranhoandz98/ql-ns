@section('title', 'Xem vai trò')
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card :title="'Xem vai trò'">
            @include('pages.roles.partials.form', [
                'action' => '#',
                'method' => 'GET',
                'result' => $result,
                'disabled' => 'disabled',
                'permissionOld'=>$permissionOld
            ])
    </x-card>
</x-app-layout>
