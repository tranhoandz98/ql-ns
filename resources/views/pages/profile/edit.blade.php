<x-app-layout>
    <x-card>
        <section>
            @if (session('status') === 'profile-updated')
                <x-alert>
                    Lưu thành công
                </x-alert>
            @endif
            <h3>
                Thông tin cá nhân
            </h3>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <div class="mb-4">
                            <img id="preview"
                                src="{{ old('avatar', $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/avatars/default.jpg')) }}"
                                class="rounded-circle account-file-input"
                                style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="mt-4">
                                <x-input-label for="avatar" class="btn btn-primary text-white">
                                    Tải ảnh mới
                                </x-input-label>
                                <div class="text-sm mt-2">Chấp nhận file JPG, PNG. Dung lượng tối đa 1MB</div>

                            </div>
                            <input type="file" id="avatar" name="avatar" class="form-control d-none"
                                accept="image/png, image/jpeg" onchange="previewImage(this)">
                            <x-input-text name="face_descriptor" id="face_descriptor" class="d-none"
                            :value="old('name', $user->face_descriptor)"
                            >
                            </x-input-text>
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />


                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-input-text id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-input-text id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
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

                        <div class="flex items-center gap-4">
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
            document.getElementById('avatar').addEventListener('change', async (e) => {
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
        </script>
    @endsection
</x-app-layout>
