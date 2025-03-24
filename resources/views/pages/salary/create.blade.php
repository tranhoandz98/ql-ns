@section('title', __('messages.salary-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.salary')" :urlParent="route('salary.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.salary-create') }}
        </h4>
        @include('pages.salary.partials.form', [
            'action' => route('salary.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
