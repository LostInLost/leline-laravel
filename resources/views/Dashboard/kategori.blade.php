@extends('Layouts.navbar-dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="container">
        <div class="card card-shadow-lg p-3">
            @if (Session::has('successTambah'))
                <div class="alert alert-success success-update">
                    Data Berhasil Ditambahkan
                </div>
            @endif
            @if (Session::has('gagalTambah'))
                <div class="alert alert-danger ">
                    Data Gagal Ditambahkan
                </div>
            @endif
            <a href="/account/kategori/tambah" class="btn btn-primary mb-3">Tambah Kategori</a>
            <table class="table table-striped table-bordered">
                <thead>
                    <th class="text-center">No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($kategori as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_kategori }}</td>
                            <td>
                                <a href="/dashboard/kategori/{{ $data->id }}/hapus"
                                    class="btn btn-outline-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
