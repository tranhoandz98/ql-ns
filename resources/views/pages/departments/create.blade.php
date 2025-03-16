@section('title', __('messages.department-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.department')" :urlParent="route('departments.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.department-create') }}
        </h4>
        @include('pages.departments.partials.form', [
            'action' => route('departments.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
