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
                            <img src="{{ asset('logo_walet.png') }}" alt="Logo" class="logo mb-4, img-profile rounded-circle">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
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

                            <!-- Video Input for Face Recognition -->
                            <div id="face-scanner" class="form-group">
                                <video id="videoElement" autoplay></video>
                                <button type="button" class="btn btn-secondary" id="scanFaceBtn">Scan Face</button>
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
    
    @include('includes.script')

    <script>
        const video = document.getElementById('videoElement');
        const scanFaceBtn = document.getElementById('scanFaceBtn');
    
        scanFaceBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
                video.srcObject = stream;
            } catch (err) {
                console.error("Error accessing camera:", err);
            }
    
            const descriptors = await handleFaceDetection(video);
            if (descriptors) {
                fetch('/api/register-face', {
                    method: 'POST',
                    body: JSON.stringify({ descriptors }),
                    headers: { 'Content-Type': 'application/json' },
                }).then(response => response.json())
                  .then(data => alert('Face registered successfully'));
            }
        });
    </script>
    
</body>
</html>
