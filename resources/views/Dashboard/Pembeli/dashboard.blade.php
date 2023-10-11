@extends('Layouts.navbar-dashboard')

@section('title', 'Penawaran Saya')

@section('content')

    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-header">
                <h3>Penawaran Saya</h3>
            </div>

            <div class="d-flex justify-content-center mt-3 mb-3">
                <table id="table-penawaran-saya" class="table table-striped table-bordered" style="width: 100%">
                    <thead class="text-center">
                        <th class="text-center">No</th>
                        <th>Nama Produk</th>
                        <th>Harga Awal</th>
                        <th>Harga yang anda tawarkan</th>
                        <td>Status</td>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($penawaran as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_barang }}</td>
                                <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                <td>{{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}</td>
                                <td>{{ $data->status_lelang }}</td>
                                <td class="text-center">
                                    @if ($data->is_outstanding)
                                        <a href="/account/{{ md5($data->id) }}/verification/lelang" class="btn btn-outline-success">Verifikasi</a>
                                    @endif
                                    @if ($data->selesai == false )
                                        <a href="/homepage/{{ md5($data->id_barang) }}/detail" class="btn btn-outline-primary">Detail</a>
                                    @elseif ($data->is_pemenang == false) 
                                        <a href="/homepage/{{ md5($data->id_barang) }}/detail" class="btn btn-outline-success ms-1">Detail</a>
                                    @endif
                                    @if ($data->selesai && $data->is_pemenang)
                                        <a href="{{ 'https://wa.me/' . preg_replace('/^0/', '62', $data->telp_penjual) }}" class="btn btn-success">Hubungi
                                            via <i class="fa-brands fa-whatsapp"></i>
                                            Whatsapp</a>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button onclick="window.history.back()" class="btn btn-success">Kembali</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script.js')

@endsection
