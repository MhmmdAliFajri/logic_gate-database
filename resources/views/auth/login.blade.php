<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - Logic Gate</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @include('layouts.css')
</head>

<body>

    <main>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="logo d-flex align-items-center">
                    <img src="{{ asset('img/logo-avisha.png') }}" alt="">

                </a>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse w-100 mt-3 mb-2 mb-md-0 mt-md-0" id="navbarText">
                    <span class="navbar-text ms-auto">
                        @guest
                            <a class="mx-2" href="{{ route('login') }}">Login</a>
                            {{-- <a class="mx-2" href="{{ route('register') }}">Register</a> --}}
                        @endguest

                        @auth
                            <a class="mx-2" href="{{ route('home') }}">Home</a>
                        @endauth
                    </span>

                </div>
            </div>
        </nav>

        <div class="container">

            <section class="section login min-vh-100 d-flex flex-column align-items-center justify-content-center pb-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center pb-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Logic Gate</span>
                                </a>
                            </div><!-- End Logo -->

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <h6>{{ $error }}</h6>
                                    @endforeach
                                </div>
                            @endif

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                        <p class="text-center small">Masukkan email dan password Anda</p>
                                    </div>

                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <!-- Input untuk Email -->
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ old('email') }}" id="email" required>
                                                <div class="invalid-feedback">Tolong isi email Anda yang valid.</div>
                                            </div>
                                        </div>

                                        <!-- Input untuk Password -->
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            <div class="invalid-feedback">Tolong masukkan password Anda.</div>
                                        </div>

                                        <!-- Checkbox Remember Me -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                            </div>
                                        </div>

                                        <!-- Tombol Login -->
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>

                                        <!-- Link ke Halaman Lupa Password -->
                                        {{-- <div class="col-12 text-center">
                                            <p class="small mb-0">Belum punya akun? <a
                                                    href="{{ route('register') }}">Klik di sini</a></p>
                                        </div> --}}
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    @include('layouts.js')

</body>

</html>
