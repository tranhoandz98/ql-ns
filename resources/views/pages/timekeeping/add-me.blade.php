@section('title', 'Chấm công cho tôi')

<x-app-layout>
    <x-card :title="'Chấm công cho tôi'">
        <div class="row justify-content-center">
            {{-- <div class="col-md-6 text-center">
                <div class="mb-4">
                    <video id="video" class="img-fluid rounded" autoplay></video>
                </div>
                <div class="mb-3">
                    <button id="startCamera" class="btn btn-primary me-2">
                        <i class="ti tabler-camera me-2"></i>
                        Bật camera
                    </button>
                    <button id="capture" class="btn btn-success" disabled>
                        <i class="ti tabler-capture me-2"></i>
                        Chấm công
                    </button>
                    <input type="file" id="uploadImage"
                    >
                </div>
                <canvas id="canvas" class="d-none"></canvas>



            </div> --}}
            <div class="col-md-6 text-center">
                <video id="webcam" class="img-fluid rounded" autoplay></video>
                <div class="mt-4">
                    <x-button type="button" id="captureBtn" :icon="'fingerprint'">
                        Chấm công</x-button>
                </div>
            </div>
        </div>
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
            const video = document.getElementById('webcam');
            const captureBtn = document.getElementById('captureBtn');

            // Khởi động camera
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => video.srcObject = stream);

            // Xử lý chụp ảnh
            captureBtn.addEventListener('click', async () => {
                const canvas = faceapi.createCanvasFromMedia(video);
                const displaySize = {
                    width: video.width,
                    height: video.height
                };
                faceapi.matchDimensions(canvas, displaySize);

                const detection = await faceapi.detectSingleFace(
                        video,
                        new faceapi.TinyFaceDetectorOptions()
                    ).withFaceLandmarks()
                    .withFaceDescriptor();

                if (!detection) {
                    alert('Không tìm thấy khuôn mặt!');
                    return;
                }

                // Gửi descriptor để so sánh
                const capturedDescriptor = Array.from(detection.descriptor);
                const response = await fetch('{{ route('cham-cong.checkin') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        descriptor: capturedDescriptor
                    })
                });

                const result = await response.json();
                alert(result.match ? 'Chấm công thành công!' : 'Xác thực thất bại!');
            });
        </script>
    @endsection
</x-app-layout>
