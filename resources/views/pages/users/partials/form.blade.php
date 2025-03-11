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
        time.flatpickr({ monthSelectorType: "static",
        dateFormat: "d/m/Y",
        static: !0 })
    </script>
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
        <div class="d-flex gap-4">
            <div>
                <h5 class="text-primary mb-2">Thông tin chung</h5>
            </div>
            <div class="ml-auto">
                avatar
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="name" >
                        <span class="text-danger">*</span>
                        @lang('messages.user-name')
                    </x-input-label>
                    <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                        value="{{ old('name', $result->name ?? '') }}" />
                    <x-input-error :messages="$errors->get('name')" class="" />
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="position_id" >
                        <span class="text-danger">*</span>
                        Chức vụ

                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="position_id">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}"
                                {{ old('position_id', $result->position_id ?? null) == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('position_id')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="department_id" >
                        <span class="text-danger">*</span>
                        Phòng ban

                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="department_id">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id', $result->department_id ?? null) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('department_id')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="manager" :value="'Cán bộ quản lý'"></x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="manager">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($users as $userItem)
                            <option value="{{ $userItem->id }}"
                                {{ old('manager', $result->manager ?? null) == $userItem->id ? 'selected' : '' }}>
                                {{ '[' . $userItem->code . '] ' . $userItem->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('manager')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="phone" :value="'Số điện thoại'"></x-input-label>
                    <input type="tel" class="form-control" id="phone" name="phone" {{ $disabled ?? '' }}
                        value="{{ old('phone', $result->phone ?? '') }}" />
                    <x-input-error :messages="$errors->get('phone')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="email" >
                        <span class="text-danger">*</span>
                        Email

                    </x-input-label>
                    <input type="email" class="form-control" id="email" name="email" {{ $disabled ?? '' }}
                        value="{{ old('email', $result->email ?? '') }}" />
                    <x-input-error :messages="$errors->get('email')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="status" :value="'Trạng thái'"></x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="status">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($statusUser as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('status', $result->status ?? null) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="type" :value="'Loại người dùng'"></x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="type">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($typeUser as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('type', $result->type ?? null) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="" />
                </div>
            </div>

        </div>
    </div>


    <div>
        <h5 class="text-primary mb-2">Thông tin khác</h5>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="work_time" :value="'Giờ làm việc'"></x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="work_time">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('work_time', $result->work_time ?? null) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('work_time')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="start_date" :value="'Ngày bắt đầu làm việc'"></x-input-label>
                    <input type="text" class="form-control bs-rangepicker-single" id="start_date" name="start_date"
                    placeholder="dd/mm/yyy"
                        {{ $disabled ?? '' }} value="{{ old('start_date', $result->start_date ?? '') }}" />
                    <x-input-error :messages="$errors->get('start_date')" class="" />
                </div>

            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="person_tax_code">MST cá nhân</x-input-label>
                    <input type="timestamp" class="form-control" id="person_tax_code" name="person_tax_code"
                        {{ $disabled ?? '' }} value="{{ old('person_tax_code', $result->person_tax_code ?? '') }}" />
                    <x-input-error :messages="$errors->get('person_tax_code')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="identifier">Mã định danh</x-input-label>
                    <input type="timestamp" class="form-control" id="identifier" name="identifier"
                        {{ $disabled ?? '' }} value="{{ old('identifier', $result->identifier ?? '') }}" />
                    <x-input-error :messages="$errors->get('identifier')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="date_of_issue">Ngày cấp</x-input-label>
                    <input type="text" class="form-control bs-rangepicker-single" id="date_of_issue" name="date_of_issue"
                    placeholder="dd/mm/yyy"

                        {{ $disabled ?? '' }} value="{{ old('date_of_issue', $result->date_of_issue ?? '') }}" />
                    <x-input-error :messages="$errors->get('date_of_issue')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="place_of_issue">Nơi cấp</x-input-label>
                    <input type="timestamp" class="form-control" id="place_of_issue" name="place_of_issue"
                        {{ $disabled ?? '' }} value="{{ old('place_of_issue', $result->place_of_issue ?? '') }}" />
                    <x-input-error :messages="$errors->get('place_of_issue')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="date_of_birth">Ngày sinh</x-input-label>
                    <input type="text" class="form-control bs-rangepicker-single" id="date_of_birth" name="date_of_birth"
                    placeholder="dd/mm/yyy"

                        {{ $disabled ?? '' }} value="{{ old('date_of_birth', $result->date_of_birth ?? '') }}" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="gender">Giới tính</x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="work_time">
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($genderUser as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('gender', $result->gender ?? null) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('gender')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="nationality">Quốc tịnh</x-input-label>
                    <input type="timestamp" class="form-control" id="nationality" name="nationality"
                        {{ $disabled ?? '' }} value="{{ old('nationality', $result->nationality ?? '') }}" />
                    <x-input-error :messages="$errors->get('nationality')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="nation">Dân tộc</x-input-label>
                    <input type="timestamp" class="form-control" id="nation" name="nation"
                        {{ $disabled ?? '' }} value="{{ old('nation', $result->nation ?? '') }}" />
                    <x-input-error :messages="$errors->get('nation')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="current_address">Địa chỉ hiện tại</x-input-label>
                    <input type="timestamp" class="form-control" id="current_address" name="current_address"
                        {{ $disabled ?? '' }} value="{{ old('current_address', $result->current_address ?? '') }}" />
                    <x-input-error :messages="$errors->get('current_address')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="permanent_address">Địa chỉ thường trú</x-input-label>
                    <input type="timestamp" class="form-control" id="permanent_address" name="permanent_address"
                        {{ $disabled ?? '' }}
                        value="{{ old('permanent_address', $result->permanent_address ?? '') }}" />
                    <x-input-error :messages="$errors->get('permanent_address')" class="" />
                </div>
            </div>
        </div>
    </div>

    <div>
        <h5 class="text-primary mb-2">Thông tin ngân hàng</h5>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="bank_account">Tài khoản ngân hàng</x-input-label>
                    <input type="timestamp" class="form-control" id="bank_account" name="bank_account"
                        {{ $disabled ?? '' }} value="{{ old('bank_account', $result->bank_account ?? '') }}" />
                    <x-input-error :messages="$errors->get('bank_account')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="bank">Ngân hàng</x-input-label>
                    <input type="timestamp" class="form-control" id="bank" name="bank"
                        {{ $disabled ?? '' }} value="{{ old('bank', $result->bank ?? '') }}" />
                    <x-input-error :messages="$errors->get('bank')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="bank_branch">Chi nhánh</x-input-label>
                    <input type="timestamp" class="form-control" id="bank_branch" name="bank_branch"
                        {{ $disabled ?? '' }} value="{{ old('bank_branch', $result->bank_branch ?? '') }}" />
                    <x-input-error :messages="$errors->get('bank_branch')" class="" />
                </div>
            </div>
        </div>
    </div>

    <div class="gap-4 justify-content-center d-flex">
        <a href="{{ route('users.index') }}">
            <x-button :icon="'x'" type="button" class="btn-secondary">Huỷ</x-button>
        </a>
        @if (!isset($disabled))
            <x-button :icon="'device-floppy'" class="">Lưu</x-button>
        @endif
    </div>

</form>
