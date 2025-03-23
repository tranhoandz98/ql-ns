@section('title', __('messages.kpi-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.kpi')" :urlParent="route('kpi.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.kpi-create') }}
        </h4>
        @include('pages.kpi.partials.form', [
            'action' => route('kpi.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
