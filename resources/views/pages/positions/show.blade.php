@section('title', __('messages.position-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.position')" :urlParent="route('positions.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.position-show') }}
        </h4>
        @include('pages.positions.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
        ])
    </x-card>
</x-app-layout>
