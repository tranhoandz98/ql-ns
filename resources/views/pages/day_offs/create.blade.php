@section('title', __('messages.day_off-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.day_off')" :urlParent="route('day_offs.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.day_off-create') }}
        </h4>
        @include('pages.day_offs.partials.form', [
            'action' => route('day_offs.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
