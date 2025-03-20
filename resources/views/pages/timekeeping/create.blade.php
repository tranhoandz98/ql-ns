@section('title', __('messages.timekeeping-create'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.timekeeping')" :urlParent="route('timekeeping.index')" :label="__('messages.create')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.timekeeping-create') }}
        </h4>
        @include('pages.timekeeping.partials.form', [
            'action' => route('timekeeping.store'),
            'method' => 'POST',
            'result' => null, // Không có dữ liệu cũ
        ])
    </x-card>
</x-app-layout>
