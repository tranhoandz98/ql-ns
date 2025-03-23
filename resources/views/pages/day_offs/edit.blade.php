@section('title', __('messages.day_off-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.day_off')" :urlParent="route('day_offs.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.day_off-edit') }}
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
            @include('pages.day_offs.partials.form', [
                'action' => route('day_offs.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
