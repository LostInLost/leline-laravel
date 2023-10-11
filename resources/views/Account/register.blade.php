<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LeLine || {{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/LostFactory.css') }}">
</head>

<body class="bg-info">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card mb-3 mt-3 shadow-lg" style="max-width: 720px;">
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title">Daftar Akun LeLine</h3>
                        <div class="card-body">
                            <form action="/account/register" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" id="form-username"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        placeholder="Masukkan Username..." required value="{{ old('username') }}">
                                    @error('username')
                                        <span class="invalid-feedback" for="form-email">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" id="form-email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Masukkan Email..." required value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" for="form-email">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" id="form-password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Masukkan Password..." required>
                                    @error('password')
                                        <span class="invalid-feedback" for="form-email">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="checkbox" id="form-penjual" class="form-check-input chk-penjual"
                                        name="level" value="2">
                                    <label for="form-penjual" class="form-check-label chk-penjual"><small>Saya ingin
                                            menjual barang
                                            lelang saya</small> </label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="form-group mb-3">
                                        <input type="submit" class="btn btn-outline-success" value="Daftar">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mb-3">
                                    <small>Sudah mempunyai akun? <a href="/account/login">Login disini</a></small>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/login-img1.png') }}"
                        style="height: 28rem; width: 48rem; object-fit: cover" class="img-fluid rounded-start"
                        alt="...">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

</html>
