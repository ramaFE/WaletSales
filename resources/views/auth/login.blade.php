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
                            <img src="{{ asset('logo_walet.png') }}" alt="Logo" class="logo mb-4, img-profile rounded-circle" >
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
                        <div class="text-center">
                            <a class="small" href="{{ route('register') }}">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.script')
</body>
</html>
