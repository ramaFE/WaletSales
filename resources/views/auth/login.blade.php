<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Login</title>
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
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back to Walets</h1>
                        </div>

                        <!-- Form Login dengan Email dan Password -->
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Enter Email Address..." required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Login with Email and Password</button>
                        </form>

                        <hr>

                        <!-- Atau Login dengan Face Recognition -->
                        <div class="text-center">
                            <h5>Or Login with Face Recognition</h5>
                        </div>
                        <div class="form-group text-center">
                            <video id="loginVideoElement" autoplay width="100%" height="300"></video>
                            <canvas id="loginCanvasElement" width="100%" height="300" style="display: none;"></canvas>
                            <button type="button" class="btn btn-secondary mt-2" id="loginScanFaceBtn">Scan Face</button>
                            <input type="hidden" name="face_descriptor" id="face_descriptor"> <!-- Face Descriptor Input -->
                        </div>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('register') }}">Create an Account!</a>
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
        const loginVideo = document.getElementById('loginVideoElement');
        const loginCanvas = document.getElementById('loginCanvasElement');
        const loginScanFaceBtn = document.getElementById('loginScanFaceBtn');
        const faceDescriptorInput = document.getElementById('face_descriptor');
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');

        async function loadFaceModels() {
            const MODEL_URL = '/models';
            await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
            console.log("Face-api models loaded successfully!");
        }

        async function handleLoginFaceDetection(videoElement) {
            const detections = await faceapi.detectSingleFace(videoElement)
                .withFaceLandmarks()
                .withFaceDescriptor();

            console.log("Deteksi Wajah Login:", detections);

            if (!detections) {
                alert("No face detected. Try again.");
                return null;
            }

            const displaySize = { width: videoElement.width, height: videoElement.height };
            faceapi.matchDimensions(loginCanvas, displaySize);
            const resizedDetections = faceapi.resizeResults(detections, displaySize);
            loginCanvas.getContext('2d').clearRect(0, 0, loginCanvas.width, loginCanvas.height);
            faceapi.draw.drawDetections(loginCanvas, resizedDetections);
            faceapi.draw.drawFaceLandmarks(loginCanvas, resizedDetections);

            return detections.descriptor;
        }

            loginScanFaceBtn.addEventListener('click', async () => {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                    loginVideo.srcObject = stream;
        
                    await loadFaceModels();
                    const descriptor = await handleLoginFaceDetection(loginVideo);
        
                    if (descriptor) {
                        faceDescriptorInput.value = JSON.stringify(descriptor);  // Menyimpan face descriptor di input tersembunyi
                        console.log("Face Descriptor Terkirim:", faceDescriptorInput.value);
                        alert("Face scanned successfully!");
        
                        // Ambil email dari form untuk dikirimkan bersama face_descriptor
                        const email = emailInput.value;
        
                        // Ambil CSRF Token dari meta tag
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
                        // Kirim data face_descriptor dan email untuk login
                        fetch('{{ route('login.face') }}', {
                            method: 'POST',
                            body: JSON.stringify({
                                email: email,  // Email yang diambil dari input form
                                face_descriptor: descriptor  // Face descriptor hasil scan
                            }),
                            headers: { 
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken  // Sertakan CSRF Token
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Login response:", data);
                            if (data.message === 'User logged in successfully') {
                                window.location.href = '/dashboard';  // Redirect ke dashboard jika login sukses
                            } else {
                                alert('Face not recognized. Please try again.');
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    }
                } catch (err) {
                    console.error("Error accessing camera:", err);
                }
            });

    </script>
</body>
</html>
