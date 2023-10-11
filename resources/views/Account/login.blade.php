<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LeLine || {{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/LostFactory.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/fontawesome.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/brands.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/solid.css') }}" />

</head>

<body class="login-body navbar-dashboard">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card mb-3 mt-3 shadow-lg" style="max-width: 720px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ asset('images/login-img1.png') }}"
                        style="height: 24rem; width: 48rem; object-fit: cover" class="img-fluid rounded-start"
                        alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title">Welcome to LeLine</h3>
                        <div class="card-body">
                            <p><small>Login Page</small></p>
                            @if (session()->has('LoginFailed'))
                                <div class="alert alert-danger">
                                    <span>Username atau Password Salah!</span>
                                </div>
                            @endif

                            @if (session()->has('failedDaftar'))
                                <div id="successupdate" class="alert alert-info success-update">
                                    <span>Silahkan login terlebih dahulu</span>
                                </div>
                            @endif

                            @if (session()->has('SuccessCreate'))
                                <div class="alert alert-success">
                                    <span>Akun telah dibuat, silahkan login</span>
                                </div>
                            @endif
                            <form action="/account/login" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="email" id="form-email" class="form-control" name="email"
                                        placeholder="Masukkan Email..." required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" id="form-password" class="form-control" name="password"
                                        placeholder="Masukkan Password..." required>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group mb-3">
                                        <input type="submit" class="btn btn-outline-primary" value="Masuk">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mb-3">
                                    <small>Belum mempunyai akun? <a href="{{ route('account.register') }}">Daftar
                                            disini</a></small>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/LostFactory.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</html>
