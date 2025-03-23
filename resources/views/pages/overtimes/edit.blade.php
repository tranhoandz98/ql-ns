@section('title', __('messages.overtime-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.overtime')" :urlParent="route('overtimes.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.overtime-edit') }}
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
                'action' => route('overtimes.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
