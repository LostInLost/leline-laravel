@extends('Layouts.navbar-dashboard')

@section('title', 'Dashboard')

@section('content')
    {{-- {{ dd($laporan_penjual) }} --}}
    <div class="container">
        <div class="d-flex align-items-start mt-3">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                @if (Session::get('user')['level'] == 2)
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home"
                        type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Report</button>
                    <button class="nav-link" id="v-pills-barang-saya-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-barang-saya" type="button" role="tab"
                        aria-controls="v-pills-barang-saya" aria-selected="true">Barang Saya</button>
                @endif
                @if (Session::get('user')['level'] == 3)
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">Report</button>
                    <button class="nav-link" id="verifikasi-akun" data-bs-toggle="pill"
                        data-bs-target="#verifikasi-akun-tab" type="button" role="tab"
                        aria-controls="verifikasi-akun-tab" aria-selected="false">Request
                        Verification</button>
                @endif
            </div>
            <div class="tab-content" id="v-pills-tabContent">

                {{-- Tab Laporan --}}
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"
                    tabindex="0">
                    @if (count($laporan_penjual) > 0 && Session::get('user')['level'] == 2)
                        <div class="h4">Laporan Lelang Saya</div>
                        <table id="laporan-lelang-penjual" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Lelang</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan_penjual as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ $data->nama_kategori }}</td>
                                        <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td class="d-flex justify-content-enter">
                                            <a href="{{ 'https://wa.me/' . preg_replace('/^0/', '62', $data->no_telpon_pembeli) }}"
                                                class="btn btn-success">Hubungi via <i class="fa-brands fa-whatsapp"></i>
                                                Whatsapp</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @elseif(count($laporan_admin) > 0 && Session::get('user')['level'] == 3)
                        <div class="h4">Laporan Lelang Hari Ini</div>
                        <table id="laporan-lelang-admin-harian" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Selesai Pada</th>
                                    <th>Nama Barang</th>
                                    <th>Penjual</th>
                                    <th>Harga Awal Lelang</th>
                                    <th>Harga Lelang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($laporan_admin as $data)
                                    @if ($data->is_day == true)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ date('m/d/Y', strtotime($data->tgl_selesai)) }}</td>
                                            <td>{{ $data->nama_barang }}</td>
                                            <td>{{ $data->nama_penjual }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}</td>
                                            <td class="d-flex justify-content-enter">
                                                <a href="/homepage/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-primary me-1">Detail</a>
                                                <a href="/dashboard/barang/{{ $data->id }}"
                                                    class="btn btn-outline-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="h4">Laporan Lelang(Minggu Ini)</div>
                        <table id="laporan-lelang-admin-mingguan" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Selesai Pada</th>
                                    <th>Nama Barang</th>
                                    <th>Penjual</th>
                                    <th>Harga Awal Lelang</th>
                                    <th>Harga Lelang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($laporan_admin as $data)
                                    @if ($data->is_week == true)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ date('m/d/Y', strtotime($data->tgl_selesai)) }}</td>
                                            <td>{{ $data->nama_barang }}</td>
                                            <td>{{ $data->nama_penjual }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="/homepage/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-primary me-1">Detail</a>
                                                <a href="/dashboard/barang/{{ $data->id }}"
                                                    class="btn btn-outline-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="h4">Laporan Lelang(Bulan Ini)</div>
                        <table id="laporan-lelang-admin-bulanan" class="table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Selesai Pada</th>
                                    <th>Nama Barang</th>
                                    <th>Penjual</th>
                                    <th>Harga Awal Lelang</th>
                                    <th>Harga Lelang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($laporan_admin as $data)
                                    @if ($data->is_month == true)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td>{{ date('m/d/Y', strtotime($data->tgl_selesai)) }}</td>
                                            <td>{{ $data->nama_barang }}</td>
                                            <td>{{ $data->nama_penjual }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($data->harga, 0, ',', '.') }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="/homepage/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-primary me-1">Detail</a>
                                                <a href="/dashboard/barang/{{ $data->id }}"
                                                    class="btn btn-outline-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div>Belum ada laporan anda.</div>
                    @endif
                </div>

                {{-- Tab Barang Saya --}}
                <div class="tab-pane fade active" id="v-pills-barang-saya" role="tabpanel"
                    aria-labelledby="v-pills-barang-saya-tab" tabindex="0">
                    <div class="h4">Barang Saya</div>
                    @if (count($barang_saya) > 0)
                        <table id="laporan-barang-saya" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Kelipatan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang_saya as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ 'Rp. ' . number_format($data->harga_awal, 0, ',', '.') }}</td>
                                        <td>{{ 'Rp. ' . number_format($data->kelipatan, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($data->status_kontrak == 2)
                                                {{ $data->status . ($data->is_exists_pemenang == false && $data->is_ditutup ? '(Tidak ada pemenang)' : false) }}
                                            @elseif($data->status == 'invoice')
                                                <a href="/barang_saya/{{ md5($data->id) }}/cetak_kontrak"
                                                    class="btn btn-secondary">Cetak Kontrak</a>
                                                <a href="/barang_saya/{{ md5($data->id) }}/accept"
                                                    class="btn btn-success">Setuju</a>
                                                <a href="/barang_saya/{{ md5($data->id) }}/decline"
                                                    class="btn btn-danger">Tolak</a>
                                            @else
                                                {{ $data->status }}
                                            @endif
                                        </td>
                                        @if ($data->is_ditutup == false && $data->status_kontrak != 3)
                                            <td class="d-flex justify-content-center">
                                                <a href="/dashboard/barang_saya/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-success ms-1">Detail</a>
                                                @if ($data->status != 'Lelang sedang berlangsung')
                                                    <a href="/dashboard/barang_saya/{{ md5($data->id) }}/edit"
                                                        class="btn btn-outline-primary ms-1">Ubah</a>
                                                @endif
                                                <form action="/dashboard/barang_saya/delete" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="submit" class="btn btn-outline-danger ms-1"
                                                        value="Hapus">
                                                </form>
                                            </td>
                                        @elseif(
                                            $data->is_outstanding == false &&
                                                $data->selesai == false &&
                                                $data->is_exists_pemenang == true &&
                                                $data->status_kontrak == 2)
                                            <td class="f-flex flex-column text-center">
                                                <a href="/homepage/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-success me-1 mb-1">Detail</a>
                                                <a href="/account/{{ md5($data->id) }}/barang_saya/verification"
                                                    class="btn btn-secondary">Verifikasi Pemenang</a>
                                            </td>
                                        @elseif($data->is_outstanding == true && $data->status_kontrak == 2)
                                            <td class="d-flex justify-content-center">
                                                <button href="" class="btn btn-secondary" disabled>Sedang menunggu
                                                    verifikasi...</button>
                                            </td>
                                        @elseif($data->status_kontrak == 3)
                                            <td class="text-center form-text">
                                                <form action="/dashboard/barang_saya/delete" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="submit" class="btn btn-outline-danger ms-1"
                                                        value="Hapus">
                                                </form>
                                            </td>
                                        @else
                                            <td class="text-center d-flex justify-content-center form-text">
                                                <a href="/homepage/{{ md5($data->id) }}/detail"
                                                    class="btn btn-outline-success me-1 mb-1">Detail</a>
                                                <form action="/dashboard/barang_saya/delete" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="submit" class="btn btn-outline-danger ms-1"
                                                        value="Hapus">
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <div class="d-flex justify-content-center">
                            <h3 class="form-text">Kamu belum mempunyai barang untuk dilelang</h3>
                        </div>
                    @endif
                    <div class="d-flex justify-content-start">
                        <a href="/dashboard/barang_saya" class="btn btn-primary">Tambah Barang Saya</a>
                    </div>
                </div>

                {{-- Tab Request Verification --}}
                <div class="tab-pane fade active" id="verifikasi-akun-tab" role="tabpanel"
                    aria-labelledby="verifikasi-akun">
                    <div class="h4">Request Verification</div>
                    @if ($request_verification_count > 0)
                        <table id="table-verifikasi" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>No. Telp</th>
                                    <th>Verified?</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($request_verification as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_lengkap }}</td>
                                        <td>{{ $data->nik }}</td>
                                        <td>{{ $data->no_telp }}</td>
                                        <td><a href="/request_account/{{ $data->auth_id }}/verified"
                                                class="btn btn-outline-success">Accept</a>
                                            <a href="/request_account/{{ $data->auth_id }}/declined"
                                                class="btn btn-outline-danger">Decline</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="d-flex justify-content-center">
                            Tidak ada permintaan verifikasi akun
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
