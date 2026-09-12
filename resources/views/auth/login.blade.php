<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Invito</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 p-0">
                    <img src="{{ asset('assets/hero/login-sideimg.jpg') }}" class="vh-100 w-100" alt="hero-login">
                </div>
                <div class="col-6 d-flex flex-column justify-content-center p-0">
                    <div class="card w-50 mx-auto border-0">
                        <h3 class="mb-4">Login to Invito</h3>
                        <div class="card-body border border-1 rounded-4">

                            <!-- this code below for debugging -->
                            <!-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif -->

                             @if (session('login_error'))
                                <div class="alert alert-danger mt-3 mb-0">
                                    {{ session('login_error') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login.process') }}" class="needs-validation" novalidate>
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                        value="{{ old('email') }}" autocomplete="off" placeholder="email" required>
                                    <label for="email">Email</label>
                                    <div class="invalid-feedback">
                                        @error('email')
                                            {{ $message }}
                                        @else
                                            Masukkan email Anda.
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                        autocomplete="off" placeholder="password" required>
                                    <label for="password">Password</label>
                                    <div class="invalid-feedback">
                                        @error('password')
                                            {{ $message }}
                                        @else
                                            Masukkan password Anda.
                                        @enderror
                                    </div>
                                </div>
                                <div class="btn-group w-75" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary">
                                        Forget password?
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>