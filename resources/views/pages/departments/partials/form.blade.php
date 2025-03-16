@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script>
        let time = $(".bs-rangepicker-single")
        time.flatpickr({
            monthSelectorType: "static",
            dateFormat: "d/m/Y",
            static: !0
        })
    </script>
@endsection

@php
if ($result){
    $result->founding_at = !empty($result?->founding_at) ? \Carbon\Carbon::parse($result?->founding_at)->format('d/m/Y') : '';
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
                <x-input-label for="name">
                    <span class="text-danger">*</span>
                    @lang('messages.department-name')
                </x-input-label>
                <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                    value="{{ old('name', $result->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="" />
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="manager_id">
                        <span class="text-danger">*</span>
                        @lang('messages.user-manager_id')
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="manager_id"
                        {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($users as $userItem)
                            <option value="{{ $userItem->id }}"
                                {{ old('manager_id', $result->manager_id ?? null) == $userItem->id ? 'selected' : '' }}>
                                {{ '[' . $userItem->code . '] ' . $userItem->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('manager_id')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="status">
                        <span class="text-danger">*</span>
                        @lang('messages.status')
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="status" {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($StatusGlobalEnum as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('status', $result->status ?? null) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="founding_at">
                        <span class="text-danger">*</span>
                        @lang('messages.department-founding_at')
                    </x-input-label>
                    <input type="text" class="form-control bs-rangepicker-single" id="founding_at" name="founding_at"
                        placeholder="dd/mm/yyy" {{ $disabled ?? '' }}
                        value="{{ old('founding_at', $result->founding_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('founding_at')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="email">
                        <span class="text-danger">*</span>
                        @lang('messages.email')
                    </x-input-label>
                    <input type="email" class="form-control" id="email" name="email" {{ $disabled ?? '' }}
                        value="{{ old('email', $result->email ?? '') }}" />
                    <x-input-error :messages="$errors->get('email')" class="" />
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="phone">
                        @lang('messages.phone')
                    </x-input-label>
                    <input type="tel" class="form-control" id="phone" name="phone" {{ $disabled ?? '' }}
                        value="{{ old('phone', $result->phone ?? '') }}" />
                    <x-input-error :messages="$errors->get('phone')" class="" />
                </div>
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
            <a href="{{ route('departments.index') }}">
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
