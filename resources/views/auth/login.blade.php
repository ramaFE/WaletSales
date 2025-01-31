<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user"
                                    id="email" placeholder="Enter Email Address..." required autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    id="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Remember Me</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                        </form>
                        
                        <hr>

                        <!-- Face Scanner -->
                        <div class="text-center">
                            <h5>Or Login with Face Recognition</h5>
                        </div>
                        <div class="form-group text-center">
                            <video id="loginVideoElement" autoplay width="100%" height="300"></video>
                            <button type="button" class="btn btn-secondary mt-2" id="loginScanFaceBtn">Scan Face</button>
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
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api"></script>
    @include('includes.script')

    <script>
        const loginVideo = document.getElementById('loginVideoElement');
        const loginScanFaceBtn = document.getElementById('loginScanFaceBtn');

        async function loadFaceModels() {
            const MODEL_URL = '/models';
            await faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
        }

        async function handleLoginFaceDetection(videoElement) {
            const detections = await faceapi.detectSingleFace(videoElement)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detections) {
                alert("No face detected. Try again.");
                return null;
            }

            return detections.descriptor;
        }

        loginScanFaceBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                loginVideo.srcObject = stream;

                await loadFaceModels();
                const descriptor = await handleLoginFaceDetection(loginVideo);

                if (descriptor) {
                    fetch('/api/login-face', {
                        method: 'POST',
                        body: JSON.stringify({ face_descriptor: descriptor }),
                        headers: { 'Content-Type': 'application/json' },
                    }).then(response => response.json())
                      .then(data => {
                          if (data.message === 'Login successful') {
                              window.location.href = '/dashboard';
                          } else {
                              alert('Face not recognized. Please try again.');
                          }
                      });
                }
            } catch (err) {
                console.error("Error accessing camera:", err);
            }
        });
    </script>
</body>
</html>
