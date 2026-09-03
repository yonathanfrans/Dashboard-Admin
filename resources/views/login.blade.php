<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>App Name - Sign In</title>
    <meta name="Description" content="Login Page">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('assets/js/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>

    <div class="autentication-bg">
        <div class="container-lg">
            <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">

                    <!-- Logo -->
                    <div class="my-4 d-flex justify-content-center">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo">
                        </a>
                    </div>

                    <!-- Login Card -->
                    <div class="card custom-card">
                        <div class="card-body p-5">
                            <p class="h5 fw-semibold mb-4 text-center">
                                Sign In
                            </p>

                            {{-- Error message --}}
                            @error('login')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            {{-- Login Form --}}
                            <form method="POST" action="{{ route('login.authenticate') }}">
                                @csrf
                                <div class="row gy-3">

                                    <!-- Username -->
                                    <div class="col-xl-12">
                                        <label for="username" class="form-label text-default">
                                            User Name
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" value="{{ old('username') }}" placeholder="username anda" required >
                                    </div>

                                    <!-- Password -->
                                    <div class="col-xl-12 mb-2">
                                        <label for="password" class="form-label text-default d-block">
                                            Password
                                        </label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="password anda" required >
                                            <button class="btn btn-light" type="button" onclick="createpassword('password',this)" id="button-addon2">
                                                <i class="ri-eye-off-line align-middle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="col-xl-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="1" id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Sign In -->
                                    <div class="col-xl-12 d-grid mt-4">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            Sign In
                                        </button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Switcher JS -->
    <script src="{{ asset('assets/js/custom-switcher.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('assets/js/show-password.js') }}"></script>

</body>
</html>