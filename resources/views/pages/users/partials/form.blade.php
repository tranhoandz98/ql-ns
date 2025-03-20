@section('cssVendor')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection
@section('scriptVendor')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <script src="{{ asset('assets/js/face-api.min.js') }}"></script>
    <script>
        async function loadModels() {
            await faceapi.nets.tinyFaceDetector.loadFromUri("{{ asset('/assets/vendor/face-api-models') }}");
            await faceapi.nets.faceLandmark68Net.loadFromUri("{{ asset('/assets/vendor/face-api-models') }}");
            await faceapi.nets.faceRecognitionNet.loadFromUri("{{ asset('/assets/vendor/face-api-models') }}");
        }
        loadModels();
    </script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/app/app-date.js') }}"></script>
    <script>
        document.getElementById('fileAvatar').addEventListener('change', async (e) => {
            const file = e.target.files[0];
            const img = await faceapi.bufferToImage(file);
            showLoading()
            const detection = await faceapi.detectSingleFace(
                    img,
                    new faceapi.TinyFaceDetectorOptions()
                ).withFaceLandmarks()
                .withFaceDescriptor();
            hideLoading()
            if (!detection) {
                alert('Không tìm thấy khuôn mặt!');
                document.querySelector('input[name="face_descriptor"]').value = JSON.stringify(Array.from(""));
                return;
            }

            document.querySelector('input[name="face_descriptor"]').value = JSON.stringify(Array.from(detection
                .descriptor));
        });

        $('#remove-avatar').on('click', function() {
            $('#avatar').val('');
            $('#fileAvatar').val('');
            $('#preview').attr('src', '{{ asset('assets/img/avatars/default.jpg') }}');
        });

        function previewImage(input) {
            // Check file size before upload
            if (input.files[0].size > 1024 * 1024) { // 1MB
                alert('File ảnh phải nhỏ hơn 1MB');
                input.value = '';
                return;
            }

            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(input.files[0].type)) {
                alert('Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG');
                input.value = '';
                return;
            }

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@php
    if ($result) {
        $result->start_date = !empty($result->start_date)
            ? \Carbon\Carbon::parse($result->start_date)->format('d/m/Y')
            : '';
        $result->date_of_birth = !empty($result->date_of_birth)
            ? \Carbon\Carbon::parse($result->date_of_birth)->format('d/m/Y')
            : '';
        $result->date_of_issue = !empty($result->date_of_issue)
            ? \Carbon\Carbon::parse($result->date_of_issue)->format('d/m/Y')
            : '';
    }
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
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

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="name">
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
                    <x-input-label for="email">
                        <span class="text-danger">*</span>
                        @lang('messages.email')
                    </x-input-label>
                    <input type="email" class="form-control" id="email" name="email" {{ $disabled ?? '' }}
                        value="{{ old('email', $result->email ?? '') }}" />
                    <x-input-error :messages="$errors->get('email')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="phone">
                        @lang('messages.phone')
                    </x-input-label>
                    <input type="tel" class="form-control" id="phone" name="phone" {{ $disabled ?? '' }}
                        value="{{ old('phone', $result->phone ?? '') }}" />
                    <x-input-error :messages="$errors->get('phone')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="position_id">
                        <span class="text-danger">*</span>
                        Vai trò
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="role_id" {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $result->role_id ?? null) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="position_id">
                        <span class="text-danger">*</span>
                        Chức vụ
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="position_id"
                        {{ $disabled ?? '' }}>
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
                    <x-input-label for="department_id">
                        <span class="text-danger">*</span>
                        Phòng ban

                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="department_id"
                        {{ $disabled ?? '' }}>
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
                    <x-input-label for="manager_id">
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


            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="status">
                        <span class="text-danger">*</span>
                        Trạng thái
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="status" {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($StatusUserEnum as $item)
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
                    <x-input-label for="type">
                        <span class="text-danger">*</span>
                        Loại người dùng

                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="type" {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($TypeUserEnum as $item)
                            <option value="{{ $item['id'] }}"
                                {{ old('type', $result->type ?? null) == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="" />
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="d-flex gap-4">
                    <div class="">
                        <x-input-label for="type">
                            Avatar
                        </x-input-label>
                        <div class="d-flex gap-4">
                            <x-input-label for="fileAvatar" class="btn btn-primary text-white {{ $disabled ?? '' }}">
                                <i class="me-2 icon-xs  icon-base ti tabler-upload"></i>
                                Tải ảnh mới
                            </x-input-label>
                            <x-button type="button" id="remove-avatar" class="btn-danger {{ $disabled ?? '' }}"
                                :icon="'x'">Loại bỏ</x-button>
                        </div>
                        <input type="text" class="form-control d-none" id="avatar" name="avatar"
                            {{ $disabled ?? '' }} value="{{ old('avatar', $result->avatar ?? '') }}" />
                        <input type="file" class="form-control d-none" id="fileAvatar" name="fileAvatar"
                            {{ $disabled ?? '' }} accept="image/png, image/jpeg" onchange="previewImage(this)" />
                        <x-input-text name="face_descriptor" id="face_descriptor" class="d-none" :value="old('name', $result?->face_descriptor)">
                        </x-input-text>
                        <x-input-error :messages="$errors->get('fileAvatar')" class="" />
                    </div>
                    <div class="w-25 d-flex ">
                        <img id="preview"
                            src="{{ old('avatar', $result?->avatar ? asset('storage/' . $result->avatar) : asset('assets/img/avatars/default.jpg')) }}"
                            class="rounded-circle account-file-input"
                            style="width: 4rem; height: 4rem; object-fit: cover;">
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div>
        <h5 class="text-primary mb-2">Thông tin khác</h5>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="work_time">
                        @lang('messages.user-work_time')
                    </x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="work_time"
                        {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($timeWorkUserEnum as $department)
                            <option value="{{ $department['id'] }}"
                                {{ old('work_time', $result->work_time ?? null) == $department['id'] ? 'selected' : '' }}>
                                {{ $department['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('work_time')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="start_date" :value="'Ngày bắt đầu làm việc'"></x-input-label>
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="start_date"
                        name="start_date" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('start_date', $result->start_date ?? '') }}" />
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
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="date_of_issue"
                        name="date_of_issue" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('date_of_issue', $result->date_of_issue ?? '') }}" />
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
                    <input type="text" class="form-control flatpickr-rangepicker-single" id="date_of_birth"
                        name="date_of_birth" placeholder="DD/MM/YYYY" {{ $disabled ?? '' }}
                        value="{{ old('date_of_birth', $result->date_of_birth ?? '') }}" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="form-group mb-4">
                    <x-input-label for="gender">Giới tính</x-input-label>
                    <select class="select2 form-select" data-allow-clear="true" name="work_time"
                        {{ $disabled ?? '' }}>
                        <option value="" disabled selected>Chọn</option>
                        @foreach ($GenderUserEnum as $item)
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

            @if (isset($disabled) && $disabled)
                <div class="col-md-6 col-lg-4">
                    <div class="form-group mb-4">
                        <x-input-label for="created_at">
                            @lang('messages.created_at')
                        </x-input-label>
                        <input type="text" class="form-control" id="created_at" name="created_at" disabled
                            value="{{ formatDateTimeView($result?->created_at) }}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">

                    <div class="form-group mb-4">
                        <x-input-label for="created_by">
                            @lang('messages.created_by')
                        </x-input-label>
                        <input type="text" class="form-control" id="created_by" name="created_by" disabled
                            value="{{ $result?->createdByData?->name }}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">

                    <div class="form-group mb-4">
                        <x-input-label for="updated_at">
                            @lang('messages.updated_at')
                        </x-input-label>
                        <input type="text" class="form-control" id="updated_at" name="updated_at" disabled
                            value="{{ formatDateTimeView($result?->updated_at) }}" />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="form-group mb-4">
                        <x-input-label for="updated_by">
                            @lang('messages.updated_by')
                        </x-input-label>
                        <input type="text" class="form-control" id="updated_by" name="updated_by" disabled
                            value="{{ $result?->updatedByData?->name }}" />
                    </div>
                </div>
            @endif
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
