@section('title', __('messages.overtime-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.overtime')" :urlParent="route('overtimes.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card >
        <h4>
            {{ __('messages.overtime-create') }}
        </h4>
        @include('pages.overtimes.partials.form', [
            'action' => route('overtimes.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
            'permissionOld' => null,
        ])
    </x-card>
</x-app-layout>
