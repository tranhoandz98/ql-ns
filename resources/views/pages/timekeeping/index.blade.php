@section('title', __('messages.timekeeping-index'))
@section('breadcrumbs')
    <x-breadcrumb :label="__('messages.timekeeping')">
    </x-breadcrumb>
@endsection
<x-app-layout>
    <x-card>
        <div class="d-flex gap-4">
            <div>
                <h4>
                    {{ __('messages.timekeeping-index') }}
                </h4>
            </div>

            <div class="ms-auto">
                <a href="{{ route('cham-cong.add-me') }}">
                    <x-button type="button" class="btn-success" :icon="'plus'">
                        {{ __('messages.add') }}
                    </x-button>
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('pages.timekeeping.partials.search-form')
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th></th>
                        <th>
                            {{ __('messages.department-user_id') }}
                        </th>
                        <th>
                            {{ __('messages.department-checkin') }}
                        </th>

                        <th>
                            {{ __('messages.department-checkout') }}
                        </th>
                        <th>
                            {{ __('messages.department-work_time') }}
                        </th>
                        <th>
                            {{ __('messages.department-num_work_date') }}
                        </th>
                        <th>
                            {{ __('messages.department-work_late') }}
                        </th>
                        <th>
                            {{ __('messages.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listAll as $index => $item)
                        <tr>
                            <td style="">
                                <div class="">
                                    <span class="" data-bs-toggle="collapse" id="btn-details-{{ $index }}"
                                        data-bs-target="#details-{{ $index }}" aria-expanded="false"
                                        aria-controls="details-{{ $index }}" onclick="">
                                        <i class="icon-base ti tabler-chevron-right"></i>
                                    </span>
                                </div>
                            </td>

                            <td>[{{ $item?->user?->code }}] - {{ $item?->user?->name }}</td>
                            <td>{{ $item->first_checkin }}</td>
                            <td>{{ $item->last_checkout }}</td>
                            <td>{{ $item->total_work_time }}</td>
                            <td>{{ number_format($item->total_work_days, 2) }}</td>
                            <td>{{ number_format($item->total_late_minutes, 2) }}</td>
                            <td></td>
                        </tr>
                        <tr class="collapse " id="details-{{ $index }}">
                            <td colspan="8" class="p-0">
                                <div>
                                    <table class="table">
                                        <tbody>
                                            @foreach ($item->records as $record)
                                                <tr>
                                                    <td>
                                                        <span class="">
                                                            <i class="icon-base ti tabler-chevron-right"></i>
                                                        </span>
                                                    </td>
                                                    <td>[{{ $item?->user?->code }}] - {{ $item?->user?->name }}</td>
                                                    <td>{{ $record->checkin }}</td>
                                                    <td>{{ $record->checkout }}</td>
                                                    <td>{{ $record->work_time }}</td>
                                                    <td>{{ $record->num_work_date }}</td>
                                                    <td>{{ $record->work_late }}</td>
                                                    <td>ádasd</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{-- {!! $listAll->links('vendor.pagination.bootstrap-5') !!} --}}
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButtons = document.querySelectorAll('[id^="btn-details-"]');
                toggleButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const isExpanded = this.getAttribute('aria-expanded') === 'true';
                        const icon = this.querySelector('.icon-base');
                        if (isExpanded) {
                            icon.classList.add('tabler-chevron-up');
                            icon.classList.remove('tabler-chevron-right');
                        } else {
                            icon.classList.add('tabler-chevron-right');
                            icon.classList.remove('tabler-chevron-up');
                        }
                    });
                });
            });
        </script>
    </x-card>
</x-app-layout>
