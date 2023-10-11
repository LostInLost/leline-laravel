<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Kontrak Barang</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/LostFactory.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/fontawesome.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/brands.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fontawesome/css/solid.css') }}" />
</head>

<body onload="window.print()">
    <div class="container">
    <h3 class="text-center"> Surat Perjanjian Penitipan Barang</h3>
    <p>
        Sebagai Pemilik Barang Dibawah Ini : <br/>
        <br/>
        Nama Penjual : {{ $invoice->nama_lengkap }} <br/>
        NIK : {{ $invoice->nik }}<br/>
        No. Telp : {{ $invoice->no_telp }}<br/>
        Alamat : {{ $invoice->alamat }}<br/>
        <br/>
        Atas Barang Dibawah Ini : <br/>
        <br/>
        Nama Barang : {{ $invoice->nama_barang }}<br/>
        Harga Awal : {{ 'Rp. ' . number_format($invoice->harga_awal, 0, ',', '.') }}<br/>
        Kelipatan : {{ 'Rp. ' . number_format($invoice->kelipatan, 0, ',', '.') }}<br/>
        Kategori : {{ $invoice->nama_kategori }}<br/>
        <br/>
        Dengan ini menyatakan pada tanggal {{ date("m/d/Y") }}, pihak LeLine sepakat membuat Surat Kontrak Penitipan Barang <b>{{ $invoice->nama_barang }}</b>. Dengan Ini Pemilik barang menitipkan barang pada website LeLine dan barang ini dapat <b>dipertanggungjawabkan</b> dengan mengikuti Syarat & ketentuan yang berlaku.
        <br/>
        Dengan menekan tombol setuju, maka saya menerima perjanjian ini dan saya bertanggung jawab atas segala resiko yang ada pada Syarat & Ketentuan yang berlaku.
    </p>

    </div>
    <script src="{{ asset('assets/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/LostFactory.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        setTimeout(() => {
            window.history.back();
        }, 1000);
    </script>
</body>

</html>
