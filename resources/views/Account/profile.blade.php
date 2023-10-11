@extends('Layouts.navbar-dashboard')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <div class="card p-3 shadow mt-3">
            <h4 class="mt-3">Profile</h4>
            @if ($user->status == 0 && $user->level != 3)
                <div class="alert alert-warning">
                    <span>Silahkan verifikasi akun agar dapat melelang ataupun menjual</span>
                </div>
            @endif

            @if ($user->status == 3 && $user->level != 3)
                <div class="alert alert-warning">
                    <span>Anda telah mengubah data lama anda, anda diharuskan memverifikasi ulang</span>
                </div>
            @endif

            {{-- @if (Session::has('failedDaftar'))
                <div class="alert alert-warning">
                    <span>Silahkan verifikasi akun agar dapat melelang ataupun menjual</span>
                </div>
            @endif --}}

            @if (Session::has('success_request'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success_request') }}</span>
                </div>
            @endif

            @if (Session::has('failedUpdate'))
                <div id="successupdate" class="alert alert-danger success-update">
                    <span>{{ Session::get('failedUpdate') }}</span>
                </div>
            @endif

            @if (Session::has('successUpdate'))
                <div id="successupdate" class="alert alert-success success-update">
                    <span>{{ Session::get('successUpdate') }}</span>
                </div>
            @endif

            <form action="/account/{{ Session::get('user')['auth_id'] }}/request_verification" method="POST">
                @csrf
                <div class="row row-cols-2">
                    <div class="col mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ $user->username }}" required placeholder="Username..." autofocus>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                            <input type="hidden" name="old_email" value="{{ $user->email }}">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? $user->email }}" name="email" required placeholder="Email...">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col mb-3">
                        <div class="form-group">
                            <input id="form-password" type="password" class="form-control" value="" name="password"
                                placeholder="Password...">
                            <div class="form-text">Isi jika ingin mengganti password</div>
                        </div>
                    </div>
                    @if (Session::get('user')['level'] != 3)
                        <div class="col mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik') ?? $user->nik }}" name="nik" placeholder="Nik..."
                                    {{ $user->status == 1 ? 'readonly' : '' }}>
                                @error('nik')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    value="{{ old('nama_lengkap') ?? $user->nama_lengkap }}" name="nama_lengkap"
                                    placeholder="Nama Lengkap..." {{ $user->status == 1 ? 'readonly' : '' }}>
                                @error('nama_lengkap')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                    value="{{ old('no_telp') ?? $user->no_telp }}" name="no_telp" placeholder="No Telp..."
                                    {{ $user->status == 1 ? 'readonly' : '' }}>
                                @error('no_telp')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-3">
                            <div class="form-group">
                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="20"
                                    rows="5" placeholder="Alamat..." {{ $user->status == 1 ? 'readonly' : '' }}>{{ old('alamat') ?? $user->alamat }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col mb-3">
                            <div>
                                <label for="">Verifikasi Akun</label>
                            </div>
                            @if ($user->status == 0 || $user->status == 3 || $user->status == 4)
                                <input type="submit" name="request_verification" class="btn btn-outline-info"
                                    value="Minta Verifikasi Akun">
                            @endif
                            @if ($user->status == 1)
                                <a href="" class="btn btn-outline-secondary disabled">Sedang Ditinjau</a>
                            @endif
                            @if ($user->status == 2)
                                <a href="" class="btn btn-outline-success disabled">
                                    <i class="fa-regular fa-check"></i> Terverifikasi
                                </a>
                            @endif

                        </div>
                    @endif
                </div>


                <div class="d-flex justify-content-end ms-auto">
                    <input type="submit" name="update_profile" class="btn btn-primary me-1" value="Simpan">
                    <a href="/" class="btn btn-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
