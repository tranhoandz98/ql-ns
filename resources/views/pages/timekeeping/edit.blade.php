@section('title', __('messages.timekeeping-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.timekeeping')" :urlParent="route('timekeeping.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.timekeeping-edit') }}
        </h4>
            @include('pages.timekeeping.partials.form', [
                'action' => route('timekeeping.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
