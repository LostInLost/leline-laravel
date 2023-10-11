@extends('Layouts.navbar-dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <div class="card card-shadow-lg p-3">
        <h3>Tambah Kategori</h3>
        <form action="/account/kategori" method="POST">
            @csrf
            <div class="row-group">

                <input type="text" name="kategori" required autofocus class="form-control @error('kategori') is-invalid @enderror" placeholder="Nama Kategori" >
                @error('kategori')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="row-group">
                <div class="d-flex justify-content-end mt-3">
                    <a href="/account/kategori" class="btn btn-success me-3">Kembali</a>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </div>
        </form>
    </div>
</div>

@endsection