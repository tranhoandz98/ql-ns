@section('title', __('messages.position-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.position')" :urlParent="route('positions.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.position-edit') }}
        </h4>
            @include('pages.positions.partials.form', [
                'action' => route('positions.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
