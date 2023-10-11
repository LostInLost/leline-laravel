<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LeLine || @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/LostFactory.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/fontawesome.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/brands.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/solid.css') }}" />

</head>

<body class="">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-dashboard">
        <div class="container">
            <a class="navbar-brand" href="#">LeLine <b>Dashboard</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['auth_id']) && $_SESSION['level'] == 3) { ?>
                    @if (Session::has('user') && Session::get('user')['level'] == 3)
                            <a class="nav-link " aria-current="page" href="/account/kategori">Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="/account/request_barang">Request Verifikasi Barang</a>
                        </li>
                    @endif
                    <?php } ?>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if (Session::has('user'))
                        <li class="nav-item dropdown">
                            <a href="" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Selamat Datang, {{ Session::get('user')['username'] }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/" class="dropdown-item">Halaman Utama</a></li>
                                <li><a href="/account/{{ Session::get('user')['auth_id'] }}/profile"
                                        class="dropdown-item">Profil</a></li>
                                @if (Session::get('user')['level'] == 2 || Session::get('user')['level'] == 3)
                                    <li><a href="/account/dashboard" class="dropdown-item">Dashboard</a></li>
                                @endif
                                @if (Session::get('user')['level'] == 1)
                                    <li><a href="/account/{{ Session::get('user')['auth_id'] ?? null }}/penawaran_saya"
                                            class="dropdown-item">Penawaran Saya</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a href="/account/logout" class="dropdown-item">Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="/account/login" class="nav-link">Login</a>
                        </li>

                    @endif

                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

</body>
<script src="{{ asset('assets/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/LostFactory.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@yield('script.js')

</html>
