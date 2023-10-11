@extends('Layouts.navbar-dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <div class="card card-shadow-lg p-3 mt-5">
            <h3>Request Verifikasi Barang Masuk</h3>
        <table id="table-request-barang" class="table table-striped table-bordered">
            <thead>
                <th class="text-center">No</th>
                <th>Nama Barang</th>
                <th class="text-center">Aksi</th>
            </thead>
            <tbody>
                @foreach($barang as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $data->nama_barang }}</td>
                    <td class="text-center">
                        @if($data->status == 0)
                        <a href="/request_barang/{{ md5($data->id) }}/detail" class="btn btn-outline-primary">Detail</a>
                        @else
                        <button class="btn btn-secondary" disabled>Menunggu Verifikasi Penjual...</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection