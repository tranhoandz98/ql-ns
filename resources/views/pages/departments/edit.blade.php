@section('title', __('messages.department-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.department')" :urlParent="route('departments.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.department-edit') }}
        </h4>
            @include('pages.departments.partials.form', [
                'action' => route('departments.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
