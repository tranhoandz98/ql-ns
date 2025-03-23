@section('title', __('messages.kpi-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.kpi')" :urlParent="route('kpi.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.kpi-edit') }}
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
            @include('pages.kpi.partials.form', [
                'action' => route('kpi.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
