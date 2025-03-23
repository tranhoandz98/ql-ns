@section('title', __('messages.overtime-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.overtime')" :urlParent="route('overtimes.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4 class="">
            {{ __('messages.overtime-show') }}

            @if($result)
            <span class="">
                &nbsp;-&nbsp;
                @lang('messages.code')
                : <span class="text-fw-500 text-primary">
                    {{$result->code}}
                </span>
            </span>
            @endif
        </h4>
        @include('pages.overtimes.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
        ])
    </x-card>
</x-app-layout>
