@section('title', __('messages.position-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.position')" :urlParent="route('positions.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.position-create') }}
        </h4>
        @include('pages.positions.partials.form', [
            'action' => route('positions.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
