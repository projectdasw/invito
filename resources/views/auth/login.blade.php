<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Invito</title>

    @vite([
    'resources/css/app.css',
    'resources/css/login.css',
    'resources/js/app.js'
])
</head>

<body>

<div class="container-fluid min-vh-100">

    <div class="row min-vh-100">

        {{-- Login Section --}}
        <div class="col-lg-6 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width: 420px;">

                {{-- Logo / Brand --}}
                <div class="text-center mb-4">

                    <h1 class="fw-bold mb-1">
                        <i class="fa-solid fa-qrcode"></i>
                        Invito
                    </h1>

                    <p class="text-muted mb-0">
                        Guest Check-in System
                    </p>

                </div>


                {{-- Login Card --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4 p-lg-5">

                        <div class="mb-4">

                            <h4 class="fw-bold mb-1">
                                Welcome Back
                            </h4>

                            <p class="text-muted mb-0">
                                Sign in to continue to Invito.
                            </p>

                        </div>


                        <form
                            id="loginForm"
                            action="{{ route('login.process') }}"
                            method="POST"
                            novalidate
                        >

                            @csrf


                            {{-- Username / Email --}}
                            <div class="mb-3">

                                <label
                                    for="login"
                                    class="form-label fw-semibold"
                                >
                                    Username / Email
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-user"></i>
                                    </span>

                                    <input
                                        type="text"
                                        class="form-control @error('login') is-invalid @enderror"
                                        id="login"
                                        name="login"
                                        value="{{ old('login') }}"
                                        placeholder="Enter username or email"
                                        autocomplete="username"
                                    >

                                </div>

                                @error('login')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Password --}}
                            <div class="mb-4">

                                <label
                                    for="password"
                                    class="form-label fw-semibold"
                                >
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Enter password"
                                        autocomplete="current-password"
                                    >

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        id="togglePassword"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Login Button --}}
                            <div class="d-grid">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    id="loginButton"
                                >

                                    <i class="fa-solid fa-right-to-bracket me-1"></i>

                                    Login

                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="text-center mt-4">

                    <small class="text-muted">
                        &copy; {{ date('Y') }} Invito.
                        All rights reserved.
                    </small>

                </div>

            </div>

        </div>


        {{-- Information Section --}}
        <div class="col-lg-6 d-none d-lg-flex bg-light align-items-center justify-content-center">

            <div class="text-center px-5">

                <div class="mb-4">

                    <i
                        class="fa-solid fa-qrcode"
                        style="font-size: 100px;"
                    ></i>

                </div>

                <h2 class="fw-bold">
                    Fast & Simple Guest Check-in
                </h2>

                <p class="text-muted mt-3">
                    Manage your event guests and check them in
                    quickly using QR Code technology.
                </p>

            </div>

        </div>

    </div>

</div>


{{-- Login JavaScript --}}
@vite('resources/js/login.js')

</body>

</html>