@section('title', __('messages.department-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.department')" :urlParent="route('departments.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.department-show') }}
        </h4>
        @include('pages.departments.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
        ])
    </x-card>
</x-app-layout>
