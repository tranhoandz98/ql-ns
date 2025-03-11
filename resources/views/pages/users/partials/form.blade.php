@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script></script>
@endsection


<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input name="id" value="{{ $result->id ?? '' }}" class="d-none" />
    <div class="d-flex gap-4">
        <div>
            <h6 class="text-primary mb-0">Thông tin chung</h6>
        </div>
        <div class="ml-auto">
            avatar
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="form-group mb-4">
                <x-input-label for="name" :value="'Tên nhân viên'"></x-input-label>
                <input type="text" class="form-control" id="name" name="name" {{ $disabled ?? '' }}
                    value="{{ old('name', $result->name ?? '') }}" />
                <x-input-error :messages="$errors->get('name')" class="" />
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="form-group mb-4">
                <x-input-label for="position_id" :value="'Chức vụ'"></x-input-label>
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
                <x-input-label for="department_id" :value="'Phòng ban'"></x-input-label>
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
                <input type="text" class="form-control" id="phone" name="phone" {{ $disabled ?? '' }}
                    value="{{ old('phone', $result->phone ?? '') }}" />
                <x-input-error :messages="$errors->get('phone')" class="" />
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="form-group mb-4">
                <x-input-label for="email" :value="'Email'"></x-input-label>
                <input type="text" class="form-control" id="email" name="email" {{ $disabled ?? '' }}
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
                        <option value="{{ $item->id }}"
                            {{ old('status', $result->status ?? null) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
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
                        <option value="{{ $item->id }}"
                            {{ old('type', $result->type ?? null) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="" />
            </div>
        </div>

    </div>

    <div>
        <h6 class="text-primary">Thời gian làm việc</h6>
    </div>
    <div class="row">
        <div class="col-lg-6">
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
        <div class="col-lg-6">
            <div class="form-group mb-4">
                <x-input-label for="start_date" :value="'Ngày bắt đầu làm việc'"></x-input-label>
                <input type="timestamp" class="form-control" id="start_date" name="start_date" {{ $disabled ?? '' }}
                    value="{{ old('start_date', $result->start_date ?? '') }}" />
                <x-input-error :messages="$errors->get('start_date')" class="" />
            </div>

        </div>
    </div>

    <div class="gap-4 d-flex">
        <a href="{{ route('roles.index') }}">
            <x-button type="button" class="btn-secondary">Huỷ</x-button>
        </a>
        @if (!isset($disabled))
            <x-button class="">Lưu</x-button>
        @endif
    </div>

</form>
