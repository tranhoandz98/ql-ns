<x-app-layout>
    <x-card>
        <section>
            <h4>
                Thông tin cá nhân
            </h4>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <div class="mb-4">
                            <img id="preview"
                                src="{{ old('avatar', $result->avatar ? asset('storage/' . $result->avatar) : asset('assets/img/avatars/default.jpg')) }}"
                                class="rounded-circle account-file-input"
                                style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="mt-4">
                                <div class="d-flex gap-4 justify-content-center">
                                    <x-input-label for="fileAvatar" class="btn btn-primary text-white">
                                        <i class="me-2 icon-xs  icon-base ti tabler-upload"></i>
                                        Tải ảnh mới
                                    </x-input-label>
                                    <x-button type="button" id="remove-avatar" class="btn-danger {{ $disabled ?? '' }}"
                                        :icon="'x'">Loại bỏ</x-button>
                                </div>

                                <div class="text-sm mt-2">Chấp nhận file JPG, PNG. Dung lượng tối đa 1MB</div>

                            </div>
                            <input type="text" id="avatar" name="avatar" class="form-control d-none"
                                value="{{ old('avatar', $result->avatar ?? '') }}">
                            <input type="file" id="fileAvatar" name="fileAvatar" class="form-control d-none"
                                accept="image/png, image/jpeg" onchange="previewImage(this)">
                            <x-input-text name="face_descriptor" id="face_descriptor" class="d-none" :value="old('name', $result->face_descriptor)">
                            </x-input-text>
                            <x-input-error class="mt-2" :messages="$errors->get('fileAvatar')" />


                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h5 class="text-primary mb-2">Thông tin chung</h5>
                        <div class="row">
                            <input type="text" value="{{ $result->id }}" name="id" class="d-none" />
                            <div class="col-md-6">
                                <div class=" form-group mb-4">
                                    <x-input-label for="name">
                                        <span class="text-danger">*</span>
                                        @lang('messages.user-name')
                                    </x-input-label>
                                    <x-input-text id="name" name="name" type="text" class="form-control"
                                        :value="old('name', $result->name)" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <x-input-label for="phone" :value="'Số điện thoại'"></x-input-label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        {{ $disabled ?? '' }} value="{{ old('phone', $result->phone ?? '') }}" />
                                    <x-input-error :messages="$errors->get('phone')" class="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <x-input-label for="email">
                                <span class="text-danger">*</span>
                                @lang('messages.user-email')
                            </x-input-label>
                            <x-input-text id="email" name="email" type="email" class="form-control"
                                :value="old('email', $result->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($result instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$result->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div>
                            <h5 class="text-primary mb-2">Thông tin khác</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="person_tax_code">MST cá nhân</x-input-label>
                                        <input type="timestamp" class="form-control" id="person_tax_code"
                                            name="person_tax_code" {{ $disabled ?? '' }}
                                            value="{{ old('person_tax_code', $result->person_tax_code ?? '') }}" />
                                        <x-input-error :messages="$errors->get('person_tax_code')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="identifier">Mã định danh</x-input-label>
                                        <input type="timestamp" class="form-control" id="identifier" name="identifier"
                                            {{ $disabled ?? '' }}
                                            value="{{ old('identifier', $result->identifier ?? '') }}" />
                                        <x-input-error :messages="$errors->get('identifier')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="date_of_issue">Ngày cấp</x-input-label>
                                        <input type="text" class="form-control bs-rangepicker-single"
                                            id="date_of_issue" name="date_of_issue" placeholder="dd/mm/yyy"
                                            {{ $disabled ?? '' }}
                                            value="{{ old('date_of_issue', $result->date_of_issue ?? '') }}" />
                                        <x-input-error :messages="$errors->get('date_of_issue')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="place_of_issue">Nơi cấp</x-input-label>
                                        <input type="timestamp" class="form-control" id="place_of_issue"
                                            name="place_of_issue" {{ $disabled ?? '' }}
                                            value="{{ old('place_of_issue', $result->place_of_issue ?? '') }}" />
                                        <x-input-error :messages="$errors->get('place_of_issue')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="date_of_birth">Ngày sinh</x-input-label>
                                        <input type="text" class="form-control bs-rangepicker-single"
                                            id="date_of_birth" name="date_of_birth" placeholder="dd/mm/yyy"
                                            {{ $disabled ?? '' }}
                                            value="{{ old('date_of_birth', $result->date_of_birth ?? '') }}" />
                                        <x-input-error :messages="$errors->get('date_of_birth')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="gender">Giới tính</x-input-label>
                                        <select class="select2 form-select" data-allow-clear="true" name="work_time"
                                            {{ $disabled ?? '' }}>
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
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="nationality">Quốc tịnh</x-input-label>
                                        <input type="timestamp" class="form-control" id="nationality"
                                            name="nationality" {{ $disabled ?? '' }}
                                            value="{{ old('nationality', $result->nationality ?? '') }}" />
                                        <x-input-error :messages="$errors->get('nationality')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="nation">Dân tộc</x-input-label>
                                        <input type="timestamp" class="form-control" id="nation" name="nation"
                                            {{ $disabled ?? '' }}
                                            value="{{ old('nation', $result->nation ?? '') }}" />
                                        <x-input-error :messages="$errors->get('nation')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="current_address">Địa chỉ hiện tại</x-input-label>
                                        <input type="timestamp" class="form-control" id="current_address"
                                            name="current_address" {{ $disabled ?? '' }}
                                            value="{{ old('current_address', $result->current_address ?? '') }}" />
                                        <x-input-error :messages="$errors->get('current_address')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="permanent_address">Địa chỉ thường trú</x-input-label>
                                        <input type="timestamp" class="form-control" id="permanent_address"
                                            name="permanent_address" {{ $disabled ?? '' }}
                                            value="{{ old('permanent_address', $result->permanent_address ?? '') }}" />
                                        <x-input-error :messages="$errors->get('permanent_address')" class="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-primary mb-2">Thông tin ngân hàng</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="bank_account">Tài khoản ngân hàng</x-input-label>
                                        <input type="timestamp" class="form-control" id="bank_account"
                                            name="bank_account" {{ $disabled ?? '' }}
                                            value="{{ old('bank_account', $result->bank_account ?? '') }}" />
                                        <x-input-error :messages="$errors->get('bank_account')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="bank">Ngân hàng</x-input-label>
                                        <input type="timestamp" class="form-control" id="bank" name="bank"
                                            {{ $disabled ?? '' }} value="{{ old('bank', $result->bank ?? '') }}" />
                                        <x-input-error :messages="$errors->get('bank')" class="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <x-input-label for="bank_branch">Chi nhánh</x-input-label>
                                        <input type="timestamp" class="form-control" id="bank_branch"
                                            name="bank_branch" {{ $disabled ?? '' }}
                                            value="{{ old('bank_branch', $result->bank_branch ?? '') }}" />
                                        <x-input-error :messages="$errors->get('bank_branch')" class="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <x-button :icon="'device-floppy'">Lưu</x-button>

                        </div>
                    </div>
                </div>
            </form>
        </section>
    </x-card>
    @section('scriptVendor')
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
        </script>
        <script>
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

            $('#remove-avatar').on('click', function() {
                $('#avatar').val('');
                $('#fileAvatar').val('');
                $('#preview').attr('src', '{{ asset('assets/img/avatars/default.jpg') }}');
            });
        </script>
    @endsection
</x-app-layout>
