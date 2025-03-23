@section('title', __('messages.kpi-show'))
@section('breadcrumbs')
    <x-breadcrumb :labelParent="__('messages.kpi')" :urlParent="route('kpi.index')" :label="__('messages.show')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <div class="d-flex ">
            <h4 class="">
                {{ __('messages.kpi-show') }}
                @if ($result)
                    <span class="">
                        &nbsp;-&nbsp;
                        @lang('messages.code')
                        : <span class="text-fw-500 text-primary">
                            {{ $result->code }}
                        </span>
                    </span>
                @endif
            </h4>
            <div class="ms-auto">
                @php
                    $statusBadge = '';
                    $colorBadge = '';
                    foreach ($statusApproveEnum as $status) {
                        if ($status['id'] == $result->status) {
                            $statusBadge = $status['name'];
                            $colorBadge = $status['color'];
                            break;
                        }
                    }
                @endphp
                <span>
                    <span class="badge badge-sm text-bg-{{ $colorBadge ?? 'secondary' }}">
                        {{ $statusBadge }}
                    </span>
                </span>
            </div>
        </div>

        @include('pages.kpi.partials.form', [
            'action' => '#',
            'method' => 'GET',
            'result' => $result,
            'disabled' => 'disabled',
        ])
    </x-card>
</x-app-layout>
