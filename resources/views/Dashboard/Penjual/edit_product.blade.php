@extends('Layouts.navbar-dashboard')

@section('title', 'Tambah Barang Saya')

@section('content')

    <div class="container">

        @if (Session::get('user')['status'] == 2)
            <div class="card p-3 shadow mt-3">
                <h4 class="mt-3">Edit Barang Saya</h4>
                @if(session()->has('failsDate'))
                <div class="alert alert-danger">
                    <span class="form-text">{{ Session::get('failsDate') }}</span>
                </div>
                @endif
                <form action="/dashboard/barang_saya/edit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="old_foto" value="{{ $barang_saya->foto }}">
                    <input type="hidden" name="id" value="{{ $barang_saya->id }}">
                    <label for="form-foto" class="form-text">Foto Barang</label>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <input id="form-foto" type="file" name="foto"
                                    class="form-control @error('foto') is-invalid @enderror " placeholder="Barang">
                                <span class="form-text">Masukkan foto baru apabila ingin merubah</span>
                                @error('foto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <input required type="text" name="nama_barang"
                                    class="form-control @error('nama_barang') is-invalid @enderror"
                                    placeholder="Masukkan Nama Barang..." value="{{ old('nama_barang') ?? $barang_saya->nama_barang }}">
                                @error('nama_barang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input required type="text" name="harga_awal"
                                    class="form-control @error('harga_awal') is-invalid @enderror"
                                    placeholder="Harga Awal untuk barang anda..." value="{{ old('harga_awal') ?? $barang_saya->harga_awal }}">
                                @error('harga_awal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp.</span>
                                <input required type="text" name="kelipatan"
                                    class="form-control @error('kelipatan') is-invalid @enderror"
                                    placeholder="Masukkan Kelipatan harga untuk ditawarkan..." value="{{ old('kelipatan') ?? $barang_saya->kelipatan }}">
                                @error('kelipatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <span class="form-text" for="tgl_awal">Taggal Buka Lelang</span>
                            <div class="form-group mb-3">
                                <input readonly required id="tgl_awal" type="date" name="tgl_dibuka"
                                    class="form-control @error('tgl_dibuka') is-invalid @enderror" value="{{ old('tgl_dibuka') ?? $barang_saya->tgl_dibuka }}">
                                @error('tgl_dibuka')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <span class="form-text" for="time_awal">Waktu Buka Lelang</span>
                            <div class="form-group mb-3">
                                <input readonly required id="time_awal" type="time" name="time_awal"
                                    class="form-control @error('time_awal') is-invalid @enderror" value="{{ old('time_awal') ?? $barang_saya->waktu_dibuka }}">
                                @error('time_awal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <span class="form-text" for="tgl_akhir">Taggal Tutup Lelang</span>
                            <div class="form-group mb-3">
                                <input readonly required id="tgl_akhir" type="date" name="tgl_ditutup"
                                    class="form-control @error('tgl_ditutup') is-invalid @enderror" value="{{ old('tgl_ditutup') ?? $barang_saya->tgl_ditutup }}">
                                @error('tgl_ditutup')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <span class="form-text" for="time_akhir">Waktu Tutup Lelang</span>
                            <div class="form-group mb-3">
                                <input readonly required id="time_akhir" type="time" name="time_akhir"
                                    class="form-control @error('time_akhir') is-invalid @enderror" value="{{ old('time_akhir') ?? $barang_saya->waktu_ditutup }}">
                                @error('time_akhir')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <textarea name="deskripsi" id="" cols="30" rows="5"
                                    class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi Barang...">{{ old('deskripsi') ?? $barang_saya->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <select name="kategori" id="kategori" class="form-select">
                                        <option value="#">Pilih Kategori...</option>
                                    @foreach ($kategori as $data)
                                        <option value="{{ $data->id }}" {{ $data->id == $barang_saya->kategori_id ? 'selected' : '' }}>{{ $data->nama_kategori }}</option>
                                    @endforeach
                                    
                                </select>
                                <label for="kategori">Kategori Barang</label>
                                @error('kategori')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <input required type="submit" class="btn btn-primary me-1" value="Simpan">
                        <a href="/account/dashboard" class="btn btn-success">Kembali</a>
                    </div>
                </form>

            </div>
        @else
            <div class="position-absolute top-50 start-50 translate-middle">
                <h4>Mohon maaf, akun anda belum terverifikasi</h4>
                <span>Silahkan <b>Verifikasi Akun</b> di laman <a
                        href="/account/{{ Session::get('user')['auth_id'] }}/profile"
                        style="text-decoration: none;">Profile</a> anda</span>
            </div>
        @endif
    </div>

@endsection
