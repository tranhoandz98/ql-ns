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
            const expectedStartInput = document.getElementById('start_at');
            const expectedEndInput = document.getElementById('end_at');
            const expectedTimeShow = document.getElementById('num_show');
            const expectedTime = document.getElementById('num');

            // Function to calculate time difference
            function calculateTimeDifference(startInput, endInput, showElement, hiddenElement) {
                const startDate = startInput._flatpickr.selectedDates[0];
                const endDate = endInput._flatpickr.selectedDates[0];

                if (startDate && endDate) {
                    // Calculate difference in days
                    let totalDays = 0;

                    // Check each day in the range
                    for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                        const day = d.getDay();
                        // Count only weekdays (Monday to Friday)
                        if (day !== 6 && day !== 0) { // Not Saturday or Sunday
                            totalDays++;
                        }
                    }

                    // Round to 2 decimal places
                    const roundedDays = Math.round(totalDays * 100) / 100;

                    // Update the display and hidden input fields
                    showElement.value = roundedDays;
                    hiddenElement.value = roundedDays;
                } else {
                    showElement.value = '';
                    hiddenElement.value = '';
                }
            }

            // Add event listeners for expected time
            expectedStartInput.addEventListener('change', () => {
                calculateTimeDifference(expectedStartInput, expectedEndInput, expectedTimeShow,
                    expectedTime);
            });

            expectedEndInput.addEventListener('change', () => {
                calculateTimeDifference(expectedStartInput, expectedEndInput, expectedTimeShow,
                    expectedTime);
            });

            const halfDayCheckbox = document.getElementById(
                'half_day'); // Assuming you have a checkbox with this ID
            const sessionForm = document.getElementById(
                'session-form'); // Assuming this is the ID for the session form
            const endAtForm = document.getElementById('end_at-form'); // Assuming this is the ID for the end_at form

            function toggleForms() {
                if (halfDayCheckbox.checked) {
                    sessionForm.classList.remove('d-none'); // Show session form
                    endAtForm.classList.add('d-none'); // Hide end_at form
                } else {
                    sessionForm.classList.add('d-none'); // Hide session form
                    endAtForm.classList.remove('d-none'); // Show end_at form
                }
            }

            // Initial check on page load
            toggleForms();

            // Add event listener to toggle forms when checkbox is checked/unchecked
            halfDayCheckbox.addEventListener('change', toggleForms);
        });

        function getRemainingLeave(event) {
            const value = event?.target?.value;
            const remaining_leave_days = document.getElementById('remaining_leave_days');
            const remaining_leave_days_show = document.getElementById('remaining_leave_days_show');

            const userId = value ?? document.querySelector('select[name="user_id"]').value;
            fetch("{{ route('day_offs_user.getByUser') }}?user_id=" + userId)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 1) {
                        // Handle the response data as needed
                        const resData = data.data;
                        const numRemainingLeave = resData.remaining_leave; // Assuming 'num' is part of the fetched data

                        // Populate the input fields with the fetched values
                        remaining_leave_days.value = numRemainingLeave; // Assuming you have an input with this ID
                        remaining_leave_days_show.value = numRemainingLeave; // Assuming you have an input with this ID
                        // You can populate fields or perform other actions based on the response
                    } else {
                        console.error('Error fetching day off user data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error)
                })
        }

        getRemainingLeave()
    </script>
@endsection

@php
    if ($result) {
        $result->start_at = !empty($result->start_at) ? \Carbon\Carbon::parse($result->start_at)->format('d/m/Y') : '';
        $result->end_at = !empty($result->end_at) ? \Carbon\Carbon::parse($result->end_at)->format('d/m/Y') : '';

        $result->handover_date = !empty($result->handover_date)
            ? \Carbon\Carbon::parse($result->handover_date)->format('d/m/Y')
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
                    @lang('messages.day_off-user_id')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="user_id"
                    onchange="getRemainingLeave(event)" {{ $disabled ?? '' }}
                    {{ $result && $result->user_id ? 'disabled' : '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($users as $userItem)
                        <option value="{{ $userItem->id }}"
                            {{ old('user_id', $result->user_id ?? Auth::user()->id) == $userItem->id ? 'selected' : '' }}>
                            {{ '[' . $userItem->code . '] ' . $userItem->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('user_id')" class="" />
            </div>
            <div class="form-group mb-4 col-6">
                <x-input-label for="type">
                    <span class="text-danger">*</span>
                    @lang('messages.day_off-type')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" id="type" name="type"
                    {{ $disabled ?? '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($typeDayOffEnum as $item)
                        <option value="{{ $item['id'] }}"
                            {{ old('type', $result->type ?? App\Enums\DayOff\TypeDayOffEnum::LEAVE_WITHOUT_PAY->value) == $item['id'] ? 'selected' : '' }}>
                            {{ $item['name'] }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="" />
            </div>

            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="start_at">
                        <span class="text-danger">*</span>
                        @lang('messages.day_off-start_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="start_at"
                        name="start_at" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('start_at', $result->start_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('start_at')" class="" />
                </div>
                <div class="form-group mb-4" id="end_at-form">
                    <x-input-label for="end_at">
                        <span class="text-danger">*</span>
                        @lang('messages.day_off-end_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="end_at"
                        name="end_at" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('end_at', $result->end_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('end_at')" class="" />
                </div>
                <div class="form-group mb-4 d-none" id="session-form">
                    <x-input-label for="session">
                        <span class="text-danger">*</span>
                        @lang('messages.day_off-session')
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="session" {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($typeSessionDayOffEnum as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('status', $result->session ?? App\Enums\DayOff\TypeSessionDayOffEnum::MORNING->value) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('session')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="num">
                        @lang('messages.day_off-num')
                    </x-input-label>
                    <input type="text" class="form-control" id="num_show" name="num_show" placeholder="" disabled
                        value="{{ old('num', $result->num ?? '0') }}" />
                    <input type="text" class="form-control d-none" id="num" name="num" placeholder=""
                        value="{{ old('num', $result->num ?? '0') }}" />
                    <x-input-error :messages="$errors->get('num')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="remaining_leave_days">
                        @lang('messages.day_off-remaining_leave_days')
                    </x-input-label>
                    <input type="text" class="form-control" id="remaining_leave_days_show"
                        name="remaining_leave_days_show" placeholder="" disabled
                        value="{{ old('remaining_leave_days', $result->remaining_leave_days ?? '0') }}" />
                    <input type="text" class="form-control d-none" id="remaining_leave_days"
                        name="remaining_leave_days" placeholder=""
                        value="{{ old('remaining_leave_days', $result->remaining_leave_days ?? '0') }}" />
                    <x-input-error :messages="$errors->get('remaining_leave_days')" class="" />
                </div>
                <div class="form-group mb-4">
                    <x-input-label for="half_day">
                        &nbsp;
                    </x-input-label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="half_day" name="half_day" value="1" {{ old('half_day') ? 'checked' : '' }}
                        {{ $disabled ?? '' }}
                        />
                        <label class="form-check-label" for="half_day">
                            @lang('messages.day_off-half_day')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4 col-6">
                <x-input-label for="handover_recipient">
                    @lang('messages.day_off-handover_recipient')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="handover_recipient"
                    {{ $disabled ?? '' }} {{ $result && $result->handover_recipient ? 'disabled' : '' }}>
                    <option value="" disabled selected>Chọn</option>
                    @foreach ($users as $userItem)
                        <option value="{{ $userItem->id }}"
                            {{ old('handover_recipient', $result->handover_recipient ?? null) == $userItem->id ? 'selected' : '' }}>
                            {{ '[' . $userItem->code . '] ' . $userItem->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('handover_recipient')" class="" />
            </div>

            <div class="form-group mb-4 col-6">
                <x-input-label for="handover_date">
                    @lang('messages.day_off-handover_date')
                </x-input-label>
                <input type="text" class="form-control flatpickr-rangepicker-single" id="handover_date"
                    name="handover_date" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                    {{ $result && $result->handover_date ? 'disabled' : '' }}
                    value="{{ old('handover_date', $result->handover_date ?? '') }}" />
                <x-input-error :messages="$errors->get('handover_date')" class="" />
            </div>

            <div class="form-group mb-4 col-12">
                <x-input-label for="description">
                    @lang('messages.description')
                </x-input-label>
                <textarea id="description" name="description" {{ $disabled ?? '' }} class="form-control">{{ old('description', $result->description ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="" />
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
            <a href="{{ route('day_offs.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @can('send', App\Models\DayOffs::class)
                @if (!empty($disabled) && $result && $result->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value)
                    <a class="btn btn-info" href={{ route('day_offs.send', $result->id) }}>
                        <x-icon :icon="'send'" class="me-2"></x-icon>
                        {{ __('messages.send') }}
                    </a>
                @endif
            @endcan
            @if (!empty($disabled) && $result && $result->status === \App\Enums\DayOff\StatusDayOffEnum::WAIT_MANAGER->value)
                @can('reject', App\Models\DayOffs::class)
                    <a href="{{ route('day_offs.reject', $result->id) }}" class="btn btn-danger">
                        <x-icon :icon="'x'" />
                        @lang('messages.reject')
                    </a>
                @endcan

                @can('approve', App\Models\DayOffs::class)
                    <a href="{{ route('day_offs.approve', $result->id) }}" class="btn btn-success">
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
