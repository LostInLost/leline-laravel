@extends('Layouts.navbar-dashboard')

@section('title', 'Tambah Barang Saya')

@section('content')

    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="card mb-3 shadow" style="max-width: 720px;">
            <div class="row g-0">
                <div class="col-md-6">
                    <img style="height: 24rem; width: 48rem; object-fit: cover" src="{{ asset('images/barang/' . $detail->foto) }}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">{{ $detail->nama_barang }}</h5>
                        <span class="text-secondary">#{{ $detail->nama_kategori }}</span>
                        <p class="card-text">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-text">Harga Awal</label>
                                <div>
                                    <span>{{ 'Rp. ' . number_format($detail->harga_awal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-text">Kelipatan Harga</label>
                                <div>
                                    <span>{{ 'Rp. ' . number_format($detail->kelipatan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-text">Tanggal Buka</label>
                                <div>
                                    <span>{{ $detail->tgl_dibuka }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-text">Waktu Buka</label>
                                <div>
                                    <span>{{ $detail->waktu_dibuka }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-text">Tanggal Tutup</label>
                                <div>
                                    <span>{{ $detail->tgl_ditutup }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-text">Waktu Tutup</label>
                                <div>
                                    <span>{{ $detail->waktu_ditutup }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-text">Deskripsi Barang</label>
                                <div>
                                    <span>{{ $detail->deskripsi }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="/account/dashboard" class="btn btn-success">Kembali</a>
                                </div>
                            </div>
                        </div>
                        </p>
                        <p class="card-text"><small class="text-muted">{{ $detail->last_update }}</small></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
