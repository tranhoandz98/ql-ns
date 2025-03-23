@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-date.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get input elements
            const expectedStartInput = document.getElementById('expected_start');
            const expectedEndInput = document.getElementById('expected_end');
            const expectedTimeShow = document.getElementById('expected_time_show');
            const expectedTime = document.getElementById('expected_time');

            const actualStartInput = document.getElementById('actual_start');
            const actualEndInput = document.getElementById('actual_end');
            const actualTimeShow = document.getElementById('actual_time_show');
            const actualTime = document.getElementById('actual_time');

            // Function to calculate time difference
            function calculateTimeDifference(startInput, endInput, showElement, hiddenElement) {
                const startDate = startInput._flatpickr.selectedDates[0];
                const endDate = endInput._flatpickr.selectedDates[0];

                if (startDate && endDate) {
                    // Calculate difference in hours
                    const diffInHours = (endDate - startDate) / (1000 * 60 * 60);

                    // Round to 2 decimal places
                    const roundedHours = Math.round(diffInHours * 100) / 100;

                    // Update the display and hidden input fields
                    showElement.value = roundedHours;
                    hiddenElement.value = roundedHours;
                } else {
                    showElement.value = '';
                    hiddenElement.value = '';
                }
            }

            // Function to sync expected and actual times
            function syncExpectedToActual(source, target, isStart) {
                if (source._flatpickr.selectedDates[0]) {
                    target._flatpickr.setDate(source._flatpickr.selectedDates[0]);

                    // Recalculate actual time after sync
                    calculateTimeDifference(actualStartInput, actualEndInput, actualTimeShow, actualTime);
                }
            }

            // Add event listeners for expected time
            expectedStartInput.addEventListener('change', () => {
                calculateTimeDifference(expectedStartInput, expectedEndInput, expectedTimeShow,
                    expectedTime);
                syncExpectedToActual(expectedStartInput, actualStartInput);
            });

            expectedEndInput.addEventListener('change', () => {
                calculateTimeDifference(expectedStartInput, expectedEndInput, expectedTimeShow,
                    expectedTime);
                syncExpectedToActual(expectedEndInput, actualEndInput);
            });

            // Add event listeners for actual time
            actualStartInput.addEventListener('change', () =>
                calculateTimeDifference(actualStartInput, actualEndInput, actualTimeShow, actualTime)
            );
            actualEndInput.addEventListener('change', () =>
                calculateTimeDifference(actualStartInput, actualEndInput, actualTimeShow, actualTime)
            );
        });
    </script>
@endsection

@php
    if ($result) {
        $result->expected_start = !empty($result->expected_start)
            ? \Carbon\Carbon::parse($result->expected_start)->format('d/m/Y H:i')
            : '';
        $result->expected_end = !empty($result->expected_end)
            ? \Carbon\Carbon::parse($result->expected_end)->format('d/m/Y H:i')
            : '';
        $result->actual_start = !empty($result->actual_start)
            ? \Carbon\Carbon::parse($result->actual_start)->format('d/m/Y H:i')
            : '';
        $result->actual_end = !empty($result->actual_end)
            ? \Carbon\Carbon::parse($result->actual_end)->format('d/m/Y H:i')
            : '';
    }
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input name="id" value="{{ $result->id ?? '' }}" class="d-none" />
    <div class="">
        <div class="row">

            <div class="form-group mb-4 col-6">
                <x-input-label for="user_id">
                    <span class="text-danger">*</span>
                    @lang('messages.overtime-user_id')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="user_id" {{ $disabled ?? '' }}
                    {{ $result && $result->user_id ? 'disabled' : '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($users as $userItem)
                        <option value="{{ $userItem->id }}"
                            {{ old('user_id', $result->user_id ?? null) == $userItem->id ? 'selected' : '' }}>
                            {{ '[' . $userItem->code . '] ' . $userItem->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="" />
            </div>
            <div class="form-group mb-4 col-6">
                <x-input-label for="type">
                    <span class="text-danger">*</span>
                    @lang('messages.overtime-type')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="type" {{ $disabled ?? '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($typeOvertimeEnum as $item)
                        <option value="{{ $item['id'] }}"
                            {{ old('status', $result->type ?? null) == $item['id'] ? 'selected' : '' }}>
                            {{ $item['name'] }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="" />
            </div>

            <div class="col-md-6 ">
                <h5 class="text-primary mb-2">
                    @lang('messages.overtime-expected')
                </h5>
                <div class="form-group mb-4">
                    <x-input-label for="expected_start">
                        <span class="text-danger">*</span>
                        @lang('messages.overtime-expected_start')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-datetime" id="expected_start"
                        name="expected_start" placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                        {{ $result && $result->expected_start ? 'disabled' : '' }}
                        value="{{ old('expected_start', $result->expected_start ?? '') }}" />
                    <x-input-error :messages="$errors->get('expected_start')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="expected_end">
                        <span class="text-danger">*</span>
                        @lang('messages.overtime-expected_end')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-datetime" id="expected_end" name="expected_end"
                        placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                        {{ $result && $result->expected_end ? 'disabled' : '' }}
                        value="{{ old('expected_end', $result->expected_end ?? '') }}" />
                    <x-input-error :messages="$errors->get('expected_end')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="expected_time">
                        @lang('messages.overtime-expected_time')
                    </x-input-label>
                    <input type="text" class="form-control" id="expected_time_show" name="expected_time_show"
                        placeholder="" disabled value="{{ old('expected_time', $result->expected_time ?? '0') }}" />
                    <input type="text" class="form-control d-none" id="expected_time" name="expected_time"
                        placeholder="" value="{{ old('expected_time', $result->expected_time ?? '0') }}" />
                    <x-input-error :messages="$errors->get('expected_time')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <h5 class="text-primary mb-2">
                    @lang('messages.overtime-actual')
                </h5>
                <div class="form-group mb-4">
                    <x-input-label for="actual_start">
                        <span class="text-danger">*</span>
                        @lang('messages.overtime-actual_start')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-datetime" id="actual_start" name="actual_start"
                        placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                        value="{{ old('actual_start', $result->actual_start ?? '') }}" />
                    <x-input-error :messages="$errors->get('actual_start')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="actual_end">
                        <span class="text-danger">*</span>
                        @lang('messages.overtime-actual_end')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-datetime" id="actual_end" name="actual_end"
                        placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                        value="{{ old('actual_end', $result->actual_end ?? '') }}" />
                    <x-input-error :messages="$errors->get('actual_end')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="actual_time">
                        @lang('messages.overtime-actual_time')
                    </x-input-label>
                    <input type="text" class="form-control" id="actual_time_show" name="actual_time_show"
                        placeholder="" disabled value="{{ old('actual_time', $result->actual_time ?? '0') }}" />
                    <input type="text" class="form-control d-none" id="actual_time" name="actual_time"
                        placeholder="" value="{{ old('actual_time', $result->actual_time ?? '0') }}" />
                    <x-input-error :messages="$errors->get('actual_time')" class="" />
                </div>
            </div>


            <div class="form-group mb-4 col-12">
                <x-input-label for="content">
                    <span class="text-danger">*</span>
                    @lang('messages.overtime-content')
                </x-input-label>
                <textarea id="content" name="content" {{ $disabled ?? '' }} class="form-control">{{ old('content', $result->content ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="" />
            </div>
            <div class="form-group mb-4 col-12">
                <x-input-label for="work_results">
                    @lang('messages.overtime-work_results')
                </x-input-label>
                <textarea id="work_results" name="work_results" {{ $disabled ?? '' }} class="form-control">{{ old('work_results', $result->work_results ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('work_results')" class="" />
            </div>
            <div class="form-group mb-4 col-12">
                <x-input-label for="note">
                    @lang('messages.note')
                </x-input-label>
                <textarea id="note" name="note" {{ $disabled ?? '' }} class="form-control">{{ old('note', $result->note ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('note')" class="" />
            </div>


            @if (isset($disabled) && $disabled)
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="created_at">
                        @lang('messages.created_at')
                    </x-input-label>
                    <input type="text" class="form-control" id="created_at" name="created_at" disabled
                        value="{{ formatDateTimeView($result?->created_at) }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="created_by">
                        @lang('messages.created_by')
                    </x-input-label>
                    <input type="text" class="form-control" id="created_by" name="created_by" disabled
                        value="{{ $result?->createdByData?->name }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="updated_at">
                        @lang('messages.updated_at')
                    </x-input-label>
                    <input type="text" class="form-control" id="updated_at" name="updated_at" disabled
                        value="{{ formatDateTimeView($result?->updated_at) }}" />
                </div>
                <div class="form-group mb-4 col-md-6">
                    <x-input-label for="updated_by">
                        @lang('messages.updated_by')
                    </x-input-label>
                    <input type="text" class="form-control" id="updated_by" name="updated_by" disabled
                        value="{{ $result?->updatedByData?->name }}" />
                </div>
            @endif
        </div>

        <div class="gap-4 justify-content-center d-flex">
            <a href="{{ route('overtimes.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @can('send', App\Models\Overtimes::class)
                @if (!empty($disabled) && $result && $result->status === App\Enums\User\StatusOverTimeEnum::DRAFT->value)
                    <a class="btn btn-info" href={{ route('overtimes.send', $result->id) }}>
                        <x-icon :icon="'send'" class="me-2"></x-icon>
                        {{ __('messages.send') }}
                    </a>
                @endif
            @endcan
            @if (!empty($disabled) && $result && $result->status === \App\Enums\User\StatusOverTimeEnum::WAIT_MANAGER->value)
                @can('reject', App\Models\Overtimes::class)
                    <a href="{{ route('overtimes.reject', $result->id) }}" class="btn btn-danger">
                        <x-icon :icon="'x'" />
                        @lang('messages.reject')
                    </a>
                @endcan

                @can('approve', App\Models\Overtimes::class)
                    <a href="{{ route('overtimes.approve', $result->id) }}" class="btn btn-success">
                        <x-icon :icon="'check'" />
                        @lang('messages.approve')
                    </a>
                @endcan
            @endif

            @if (!isset($disabled))
                <x-button :icon="'device-floppy'" class="submit-btn">
                    @lang('messages.save')
                </x-button>
            @endif
        </div>
</form>
