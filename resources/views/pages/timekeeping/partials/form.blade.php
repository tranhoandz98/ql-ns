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
@endsection

@php
    if ($result) {
        $result->checkin = !empty($result->checkin) ? \Carbon\Carbon::parse($result->checkin)->format('d/m/Y H:i') : '';
        $result->checkout = !empty($result->checkout)
            ? \Carbon\Carbon::parse($result->checkout)->format('d/m/Y H:i')
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
            <div class="form-group mb-4 col-12">
                <x-input-label for="user_id">
                    <span class="text-danger">*</span>
                    @lang('messages.timekeeping-user_id')
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
            <div class="form-group mb-4 col-12">
                <x-input-label for="checkin">
                    <span class="text-danger">*</span>
                    @lang('messages.timekeeping-checkin')
                </x-input-label>
                <input type="text" class="form-control flatpickr-datetime" id="checkin" name="checkin"
                    placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                    value="{{ old('checkin', $result->checkin ?? '') }}" />
                <x-input-error :messages="$errors->get('checkin')" class="" />
            </div>
            <div class="form-group mb-4 col-12">
                <x-input-label for="checkout">
                    <span class="text-danger">*</span>
                    @lang('messages.timekeeping-checkout')
                </x-input-label>
                <input type="text" class="form-control flatpickr-datetime" id="checkout" name="checkout"
                    placeholder="DD/MM/YYYY HH:MM" {{ $disabled ?? '' }}
                    value="{{ old('checkout', $result->checkout ?? '') }}" />
                <x-input-error :messages="$errors->get('checkout')" class="" />
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
            <a href="{{ route('timekeeping.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @if (!isset($disabled))
                <x-button :icon="'device-floppy'" class="submit-btn">
                    @lang('messages.save')
                </x-button>
            @endif
        </div>
</form>
