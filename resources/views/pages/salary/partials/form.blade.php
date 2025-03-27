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
                    @lang('messages.salary-name')
                </x-input-label>
                <input type="text" class="form-control" id="name" name="name" disabled
                    value="{{ old('name', $result->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="" />
            </div>
            <div class="form-group mb-4 col-6">
                <x-input-label for="user_id">
                    <span class="text-danger">*</span>
                    @lang('messages.user_id')
                </x-input-label>
                <select class="select2 form-select" data-allow-clear="true" name="user_id"
                disabled
                >
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

            <div class="col-md-6 ">
                <div class="form-group mb-4">
                    <x-input-label for="start_at">
                        <span class="text-danger">*</span>
                        @lang('messages.start_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="start_at"
                        name="start_at" placeholder="DD/MM/YYYY" disabled
                        value="{{ old('start_at', $result->start_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('start_at')" class="" />
                </div>

            </div>
            <div class="col-md-6 ">
                <div class="form-group mb-4" id="end_at-form">
                    <x-input-label for="end_at">
                        <span class="text-danger">*</span>
                        @lang('messages.end_at')
                    </x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="end_at"
                        name="end_at" placeholder="DD/MM/YYYY" disabled
                        value="{{ old('end_at', $result->end_at ?? '') }}" />
                    <x-input-error :messages="$errors->get('end_at')" class="" />
                </div>
            </div>

            <div class="nav-align-top nav-tabs-shadow">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                        @lang('messages.salary-tab_num')
                    </button>
                  </li>
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                        @lang('messages.salary-tab_cacular')
                    </button>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                    @include('pages.salary.partials.tab-num')

                </div>
                  <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                    @include('pages.salary.partials.tab-calculate')


                </div>
                </div>
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
            <a href="{{ route('salary.index') }}">
                <x-button :icon="'x'" type="button" class="btn-secondary">
                    @lang('messages.cancel')
                </x-button>
            </a>
            @can('send', App\Models\KPI::class)
                @if (!empty($disabled) && $result && $result->status === App\Enums\DayOff\StatusDayOffEnum::DRAFT->value)
                    <a class="btn btn-info" href={{ route('salary.send', $result->id) }}>
                        <x-icon :icon="'send'" class="me-2"></x-icon>
                        {{ __('messages.send') }}
                    </a>
                @endif
            @endcan
            @if (
                !empty($disabled) &&
                    $result &&
                    $result->status === \App\Enums\DayOff\StatusDayOffEnum::WAIT_MANAGER->value &&
                    $result->isApprove)
                @can('reject', App\Models\KPI::class)
                    <a href="{{ route('salary.reject', $result->id) }}" class="btn btn-danger">
                        <x-icon :icon="'x'" />
                        @lang('messages.reject')
                    </a>
                @endcan

                @can('approve', App\Models\KPI::class)
                    <a href="{{ route('salary.approve', $result->id) }}" class="btn btn-success">
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
