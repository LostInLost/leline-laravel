@extends('Layouts.navbar')

@section('title', $barang->nama_barang)

@section('content')
    <div class="d-flex flex-column justify-content-center p-3">
        <div class="card-group shadow">
            <div class="card">
                <div class="card-body">
                    @if ((Session::get('user')['level'] ?? null) == 1 && $barang->var_daftar == 1 && $barang->var_is_lelang_ditutup == false)
                        <h5 class="card-title">Tawaran Saya</h5>
                    @endif

                    @if (Session::has('failedDaftar'))
                        <div class="alert alert-danger">
                            <label class="form-text">{{ Session::get('failedDaftar') }} </label>
                        </div>
                    @endif
                    @if (Session::has('errorTawaran'))
                        <div class="alert alert-danger">
                            <label class="form-text">{{ Session::get('errorTawaran') }} </label>
                        </div>
                    @endif
                    @if (Session::has('successTawaran'))
                        <div id="successupdate" class="alert alert-success success-update">
                            <label class="form-text">{{ Session::get('successTawaran') }} </label>
                        </div>
                    @endif
                    @if (Session::has('successDaftar'))
                        <div id="successupdate" class="alert alert-success success-update">
                            <label class="form-text">Akun anda berhasil didaftarkan</label>
                        </div>
                    @endif

                    @if (Session::has('user') ? Session::get('user')['level'] == 2 && $barang->var_is_penjual == true && $barang->var_is_lelang_ditutup == false : false)
                        <div class="d-flex justify-content-center">
                            <a href="/homepage/{{ md5($barang->id) }}/tutup_lelang" class="btn btn-danger">Tutup Lelang</a>
                        </div>
                    @endif

                    @if (Session::has('successTutup'))
                        <div id="successupdate" class="alert alert-success success-update">
                            <label class="form-text">{{ Session::get('successTutup') }}</label>
                        </div>
                    @endif

                    @if ((Session::get('user')['level'] ?? null) == 1 && $barang->var_daftar == 1 && $barang->var_is_lelang_ditutup == false)
                        <form action="/barang_lelang/{{ md5($barang->id) }}/tawar" method="POST">
                            @csrf
                            <label class="form-text">Kode Lelang Saya : {{ $barang->var_kode }}</label>
                            <div class="input-group">
                                <span class="input-group-text" id="rupiah">Rp.</span>
                                <input type="text"
                                    class="form-control @if (Session::has('FailNominal') || $errors->has('nominal')) is-invalid @endif" name="nominal"
                                    placeholder="Masukkan tawaran anda..." aria-describedby="rupiah">
                                @if (Session::has('FailNominal') || $errors->has('nominal'))
                                    <div class="invalid-feedback">
                                        <small
                                            class="form-text text-danger">{{ Session::get('FailNominal') ?? $errors->get('nominal')[0] }}</small>
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" value="{{ $barang->kelipatan }}" name="kelipatan">
                            <div class="d-flex flex-column justify-content-center">
                                <label class="form-text">Kelipatan :
                                    {{ 'Rp. ' . number_format($barang->kelipatan, 0, ',', '.') }}</label>
                                <input type="submit" class="btn btn-outline-success" value="Tawar">
                            </div>
                        </form>
                    @elseif($barang->var_is_penjual == false && $barang->var_is_lelang_ditutup == false)
                        <div class="d-flex flex-column justify-content-center text-center">
                            <small>Anda belum mendaftar pada barang ini</small>
                            <form action="/homepage/{{ md5($barang->id) }}/detail/daftar" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ Session::get('user')['auth_id'] ?? null }}">
                                <input type="submit" class="btn btn-warning" value="Daftar Lelang">
                            </form>

                        </div>
                    @endif
                    <input type="hidden" id="LelineNo" value="{{ Session::get('user')['auth_id'] ?? null }}">
                    <input type="hidden" id="barang_id_hidden" value="{{ md5($barang->id) }}">
                    <div id="realtime-notif" class="card mt-3 card-notifikasi p-3">
                        <span class="card-title text-center">
                            <h4 class="form-text">Notifikasi</h4>
                        </span>
                        {{-- @foreach ($notif as $data)
                            <div class="d-flex justify-content-end">
                                <small class="form-text">{{ $data->notif_dynamic }}</small>
                            </div>
                        @endforeach --}}
                        <p class="placeholder-glow">
                            <span class="placeholder col-12"></span>
                        </p>
                    </div>
                    <input type="hidden" id="tgl_tutup" value="{{ $barang->tgl_ditutup }}">
                    <div class="d-flex justify-content-center mt-5">
                        <span id="countdown-lelang"></span>
                    </div>

                </div>
            </div>
            <div class="card card-group-width text-bg-dark">
                <img src="{{ asset('images/barang/' . $barang->foto) }}" class="card-img-top" alt="..."
                    style="object-fit: cover; max-height: 250px">
                <div class="card-body">
                    <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                    <small class="form-text">#{{ $barang->nama_kategori }}</small>
                    <p class="card-text">{{ $barang->deskripsi }}</p>
                    <div class="row">
                        <div class="col-6">
                            <span class="form-text">Harga Awal</span>
                        </div>
                        <div class="col-6">
                            <span class="form-text">Kelipatan</span>
                        </div>
                        <div class="col-6">
                            <span
                                class="form-text text-dark">{{ 'Rp. ' . number_format($barang->harga_awal, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-6">
                            <span
                                class="form-text text-dark">{{ 'Rp. ' . number_format($barang->kelipatan, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-6">
                            <span class="form-text">Penjual</span>
                        </div>
                        <div class="col-6">
                            <span class="form-text">Status</span>
                        </div>
                        <div class="col-6">
                            <span class="form-text text-dark">{{ $barang->nama_lengkap }}</span>
                        </div>
                        <div class="col-6">
                            <span class="form-text text-dark">{{ $barang->status }}</span>
                        </div>
                        <div class="col-12">
                            <span class="form-text">Alamat Penjual</span>
                        </div>
                        <div class="col-12">
                            <span class="form-text text-dark">{{ $barang->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Calon Pemenang</h5>
                    <table id="table_pelelangan" class="table table-striped">
                        <thead>
                            <th>Nama</th>
                            <th>Tawaran</th>
                        </thead>
                        <tbody>
                            <span class="spinner"></span>
                        </tbody>
                    </table>
                    <p><small>{{ $barang->last_update }}</small></p>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="/" class="btn btn-success">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script.js')

    <script>
        // clearInterval(realtimelelang);
        // clearInterval(realtimeCountDown);
        // clearInterval(notifLelang);
        const realtimelelang = async () => {
            const id = $("#barang_id_hidden").val();
            const response = await fetch(
                `http://127.0.0.1:8000/api/barang/${id}/pelelangan`, {
                    method: "GET",
                }
            );
            const result = await response.json();
            console.log('respon')
            var text = '';
            await $('#table_pelelangan > tbody').remove();
            result.data_lelang.forEach(data => {
                let num = data.harga
                text += `
            <tbody>
            <tr class='${data.pemenang ? 'bg-info text-white' : ''}'>
                <td>${data.nama_lengkap} ${data.pemenang ? '<i class="fa-solid fa-crown text-warning"></i>' : ''}</td>
                <td>Rp. ${num.toLocaleString('id-ID')}</td>
            </tr>
            </tbody>
            `
            });
            $('#table_pelelangan').append(text)
        };
        realtimelelang()
        let timeloop = setInterval(() => {
            realtimelelang()
        }, 5000)

        const notifLelang = async () => {
            const id = $("#barang_id_hidden").val();
            const auth_id = $('#LelineNo').val();
            const response = await fetch(
                `http://127.0.0.1:8000/api/barang/${id}/${auth_id}/notif_lelang`, {
                    method: "GET",
                }
            );
            const result = await response.json();
            var text = '';
            await $('#realtime-notif > div').remove();
            result.notifikasi.forEach(data => {
                text += `
            <div class="d-flex justify-content-end">
            <small class="form-text">${data.notif_dynamic}</small>
            </div>
            `
            })
            $('#realtime-notif').append(text);
        }
        notifLelang()
        let timeloop1 = setInterval(() => {
            notifLelang()
        }, 5000)

        const realtimeCountDown = () => {
            var date = new Date($('#tgl_tutup').val())
            var current_time = new Date();
            var hasil = date.getTime() - current_time.getTime()
            var day = Math.floor((hasil / 86400000));
            var hours = Math.floor((hasil / 3600000) % 24);
            var minutes = Math.floor((hasil / 60000) % 60);
            var seconds = Math.floor((hasil / 1000) % 60);
            $('#countdown-lelang > div').remove()
            if (date.getTime() > current_time.getTime())
                return $('#countdown-lelang').append(`
            <div>Berakhir dalam ${day > 0 ? day + ' Hari' : ''} ${hours > 0 ? hours + ' Jam' : ''} ${minutes > 0 ? minutes + ' Menit' : ''} ${seconds > 0 ? seconds + ' Detik' : ''} lagi</div>
            `);

            return $('#countdown-lelang').append(`
            <div>Lelang sudah ditutup</div>
            `);
        }
        realtimeCountDown();
        let timeloop2 = setInterval(() => {
            realtimeCountDown()
        }, 1000)
    </script>


@endsection
