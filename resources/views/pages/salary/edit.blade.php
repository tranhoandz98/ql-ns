@section('title', __('messages.salary-edit'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.salary')" :urlParent="route('salary.index')" :label="__('messages.update')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <h4>
            {{ __('messages.salary-edit') }}
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
            @include('pages.salary.partials.form', [
                'action' => route('salary.update', $result->id),
                'method' => 'PUT',
                'result' => $result,
            ])
    </x-card>
</x-app-layout>
