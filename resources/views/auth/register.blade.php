<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @include('includes.style')
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <img src="{{ asset('logo_walet.png') }}" alt="Logo" class="logo mb-4 img-profile rounded-circle">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="{{ route('register.face') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form-control-user"
                                    id="name" placeholder="Full Name" required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user"
                                    id="email" placeholder="Email Address" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    id="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control form-control-user"
                                    id="password_confirmation" placeholder="Confirm Password" required>
                            </div>

                            <!-- Face Scanner -->
                            <div class="form-group">
                                <video id="videoElement" autoplay width="100%" height="300"></video>
                                <canvas id="canvasElement" width="100%" height="300" style="display: none;"></canvas>
                                <button type="button" class="btn btn-secondary mt-2" id="scanFaceBtn">Scan Face</button>
                                <input type="hidden" name="face_descriptor" id="face_descriptor">
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Load Face-API.js -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js/dist/face-api.min.js"></script>
    @include('includes.script')

    <script>
        async function loadFaceModels() {
            const MODEL_URL = '/models';
            await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
            console.log("Face-API models loaded successfully!");
        }

        const video = document.getElementById('videoElement');
        const canvas = document.getElementById('canvasElement');
        const scanFaceBtn = document.getElementById('scanFaceBtn');
        const faceDescriptorInput = document.getElementById('face_descriptor');

        async function handleFaceDetection(videoElement) {
            const detections = await faceapi.detectSingleFace(videoElement)
                .withFaceLandmarks()
                .withFaceDescriptor();
            console.log("Face Detected:", detections);

            if (!detections) {
                alert("No face detected, please try again.");
                return null;
            }

            // Draw bounding box and landmarks
            const displaySize = { width: videoElement.width, height: videoElement.height };
            faceapi.matchDimensions(canvas, displaySize);
            const resizedDetections = faceapi.resizeResults(detections, displaySize);
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            faceapi.draw.drawDetections(canvas, resizedDetections);
            faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

            return detections.descriptor;
        }

        scanFaceBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                video.srcObject = stream;
    
                await loadFaceModels();
                const descriptor = await handleFaceDetection(video);
                
                if (descriptor) {
                    faceDescriptorInput.value = JSON.stringify(descriptor);
                    console.log("Face Descriptor yang Dikirim:", faceDescriptorInput.value);
                    alert("Face scanned successfully!");
                }
            } catch (err) {
                console.error("Error accessing camera:", err);
            }
        });
    </script>
</body>
</html>
