@section('title', __('messages.user-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.user')" :urlParent="route('users.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.user-show') }}
        </h4>
        @include('pages.users.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
        ])
    </x-card>
</x-app-layout>
