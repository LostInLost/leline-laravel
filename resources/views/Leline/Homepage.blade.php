@extends('Layouts.navbar')

@section('title', 'Selamat datang di LeLine')

@section('content')
    <div class="container">
        <div class="d-flex flex-row">
            <div class="d-flex flex-column">
                <div class="w-100" style="max-width: 100%">
                    <h3>
                        <ion-icon name="filter-outline"></ion-icon> Filter
                    </h3>
                    <span>By Tag</span>
                    <form action="/">
                        <ul class="list-group me-5 w-100 ">
                            <select name="kategori" id="" class="form-select">
                                <option value="">Pilih Tag</option>
                                @foreach ($kategori as $data)
                                    <option value="{{ $data->id }}" {{ (Request::has('kategori') ? ($data->id == $request['kategori']) : false) ? 'selected' : '' }}>{{ $data->nama_kategori }}</option>
                                @endforeach
                            </select>


                            @if (count($kategori) < 1)
                                <span class="form-text">Tidak ada Tag</span>
                            @endif
                </div>
            </div>
            <div class="row row-cols-5 w-100 ms-3">
                <div class="col-md-12">
                    <div class="d-flex mt-3">
                        <div class="form-group " style="width: 48rem">
                            <input type="text" value="{{ $request['search'] ?? '' }}" name="search" class="form-control"
                                placeholder="Cari barang disini...">
                        </div>
                        <div class="form-group ms-3">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </div>
                    </div>
                    </form>
                </div>
                @foreach ($homepage as $data)
                    <div class="col col-width">
                        <div class="card-thing text-center mt-3">
                            <a href="/homepage/{{ md5($data->id) }}/detail" style="text-decoration: none;">
                                <img src="{{ asset('images/barang/' . $data->foto) }}" alt="" class="card-img"
                                    style="object-fit: cover; max-height: 100px">
                                <div class="card-title-thing clearfix">
                                    <p>{{ $data->nama_barang }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
