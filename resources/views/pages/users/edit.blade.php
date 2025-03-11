@section('title', 'Cập nhật vai trò')
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.role')" :urlParent="route('roles.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card :title="'Cập nhật vai trò'">
            @include('pages.roles.partials.form', [
                'action' => route('roles.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
                'permissionOld'=>$permissionOld
            ])
    </x-card>
</x-app-layout>
