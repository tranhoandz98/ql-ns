@section('title', __('messages.user-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.user')" :urlParent="route('users.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.user-edit') }}
        </h4>
            @include('pages.users.partials.form', [
                'action' => route('users.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
