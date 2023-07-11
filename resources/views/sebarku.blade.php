@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            <a class="navbar-brand" style="padding-left:0.25rem" href="{{ session('sebar_url') }}"><i class="fa-solid fa-chevron-left"></i></a>
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">SEBAR | Toko {{$user->nama}}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <!--content-->
    <div class="container">
        <div class="d-flex justify-content-center" style="margin-top: 1rem;">
            <a href="{{ route('sebar_baru') }}" role="button" class="btn btn-success"
                style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Tambah Barkas</a>
        </div>

        <style>
            .singleinfos .singleinfostabs > ul {
                overflow-x: auto;
                overflow-y:hidden;
                flex-wrap: nowrap;
            }

            .singleinfos .singleinfostabs .nav-tabs > li > a {
                font-weight: 700;
                padding: 0.75rem 1rem;
                overflow: hidden;
                text-align: center;
                white-space: nowrap !important;
            }

            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                color: #176e41;
                border-color: #176e41;
                border-bottom-color: transparent;
            }

            .rounded-pill {
                --bs-badge-padding-x: 0.5em;
                --bs-badge-padding-y: 0.2em;
                margin-top: 0.4rem;
                margin-left: -0.4rem;
            }

            #nama_barkas {
                -webkit-line-clamp: 2;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                overflow: hidden;
                white-space: unset;
            }
        </style>

        <div class="singleinfos">
            <div class="row container-fluid" style="padding: 0; margin: 0;">
                <div class="singleinfostabs" style="padding: 0">
                    <ul class="nav nav-tabs" id="nav-tab" role="tablist" style="padding-top: 1rem;">
                        <li class="active position-relative">
                            <a class="nav-link active" id="nav-proses-tab" data-bs-toggle="tab" data-bs-target="#nav-proses" type="button" role="tab" aria-controls="nav-proses" aria-selected="true">Proses Cek</a>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $proses_cek->count(); }}
                            </span>
                        </li>
                        <li class="position-relative">
                            <a class="nav-link position-relative" id="nav-lolos-tab" data-bs-toggle="tab" data-bs-target="#nav-lolos" type="button" role="tab" aria-controls="nav-lolos" aria-selected="false">Lolos Cek</a>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                {{ $lolos_cek->count(); }}
                            </span>
                        </li>
                        <li class="position-relative">
                            <a class="nav-link position-relative" id="nav-tidak_lolos-tab" data-bs-toggle="tab" data-bs-target="#nav-tidak_lolos" type="button" role="tab" aria-controls="nav-tidak_lolos" aria-selected="false">Tidak Lolos Cek</a>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                {{ $tidak_lolos_cek->count(); }}
                            </span> 
                        </li>
                        <li class="position-relative">
                            <a class="nav-link position-relative" id="nav-laku-tab" data-bs-toggle="tab" data-bs-target="#nav-laku" type="button" role="tab" aria-controls="nav-laku" aria-selected="false">Laku</a>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                {{ $barang_laku->count(); }}
                            </span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    
        <div class="tab-content" id="nav-tabContent">
            <!-- Proses Cek -->
            <div class="tab-pane fade show active" id="nav-proses" role="tabpanel" aria-labelledby="nav-proses-tab" tabindex="0">
                <div class="row d-flex justify-content-center" style="padding: 0.5rem 0;">
                    @foreach ($proses_cek as $proses)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="margin: 0.5rem 0; ">
                            <a href="{{ route('detail', ['fitur' => 'sebar', 'id' => $proses->id]) }}"
                                style="text-decoration: none; color:black;">
                                <div class="card border border-1 h-100" style="background-color: gainsboro;">
                                    <div class="card border border-0" style="aspect-ratio: 1 / 1;">
                                        <div class="position-absolute top-0 start-0">
                                            @if ($proses->id_kondisi == 1)
                                                @php $badge_color = 'text-bg-danger'; @endphp
                                            @elseif ($proses->id_kondisi == 2)
                                                @php $badge_color = 'text-bg-warning'; @endphp
                                            @elseif ($proses->id_kondisi == 3)
                                                @php $badge_color = 'text-bg-success'; @endphp
                                            @elseif ($proses->id_kondisi == 4)
                                                @php $badge_color = 'text-bg-info'; @endphp
                                            @endif
                                            <span class="badge {{ $badge_color }}"
                                                style="font-size: 75%; font-weight: 600; margin-left: 0.2rem; text-transform: capitalize;">
                                                {{$proses->kondisi}}
                                            </span>
                                        </div>
                                        @php
                                            $foto_sebar = "https://ambilin.com/img/png/ambilin.png";
                                            if (!empty($proses->foto) && file_exists('public/img/sebar/' . $proses->foto)) {
                                                $foto_sebar = 'public/img/sebar/' . $proses->foto;
                                            }
                                        @endphp
                                        <img src="{!! asset($foto_sebar) !!}" class="card-img-top"
                                            alt="{{$proses->judul}}"
                                            style="aspect-ratio: 1 / 1; object-fit: cover;">
                                    </div>
    
                                    <div class="container"
                                        style="font-size: 75%; letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                                        <span class="text-truncate" style="margin:0.25rem 0; font-size: 100%; font-weight: 700;" id="nama_barkas">
                                            {{$proses->judul}}
                                        </span>
                                        <hr style="border-top: 1px solid #666666; margin: 0.25rem 0">
                                        <p style="margin:0.25rem 0 0.75rem 0;">
                                            {{$proses->fungsi}}
                                        </p>
                                        {{-- <br>
                                        <div class="position-absolute bottom-0 end-0">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: unset">
                                                    <p class="text-success"
                                                        style="margin: 0 0.5rem 0.25rem 0; font-weight: 600; text-align: end;">
                                                        <small>Rp.</small> {{ number_format($proses->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Lolos Cek -->
            <div class="tab-pane fade" id="nav-lolos" role="tabpanel" aria-labelledby="nav-lolos-tab" tabindex="0">
                <div class="row d-flex justify-content-center" style="padding: 0.5rem 0;">
                    @foreach ($lolos_cek as $lolos)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="margin: 0.5rem 0; ">
                            <a href="{{ route('detail', ['fitur' => 'sebar', 'id' => $lolos->id]) }}"
                                style="text-decoration: none; color:black;">
                                <div class="card border border-1 h-100" style="background-color: gainsboro;">
                                    <div class="card border border-0" style="aspect-ratio: 1 / 1;">
                                        <div class="position-absolute top-0 start-0">
                                            @if ($lolos->id_kondisi == 1)
                                                @php $badge_color = 'text-bg-danger'; @endphp
                                            @elseif ($lolos->id_kondisi == 2)
                                                @php $badge_color = 'text-bg-warning'; @endphp
                                            @elseif ($lolos->id_kondisi == 3)
                                                @php $badge_color = 'text-bg-success'; @endphp
                                            @elseif ($lolos->id_kondisi == 4)
                                                @php $badge_color = 'text-bg-info'; @endphp
                                            @endif
                                            <span class="badge {{ $badge_color }}"
                                                style="font-size: 75%; font-weight: 600; margin-left: 0.2rem; text-transform: capitalize;">
                                                {{$lolos->kondisi}}
                                            </span>
                                        </div>
                                        @php
                                            $foto_sebar = "https://ambilin.com/img/png/ambilin.png";
                                            if (!empty($lolos->foto) && file_exists('public/img/sebar/' . $lolos->foto)) {
                                                $foto_sebar = 'public/img/sebar/' . $lolos->foto;
                                            }
                                        @endphp
                                        <img src="{!! asset($foto_sebar) !!}" class="card-img-top"
                                            alt="{{$lolos->judul}}"
                                            style="aspect-ratio: 1 / 1; object-fit: cover;">
                                    </div>
    
                                    <div class="container"
                                        style="font-size: 75%; letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                                        <span class="text-truncate" style="margin:0.25rem 0; font-size: 100%; font-weight: 700;" id="nama_barkas">
                                            {{$lolos->judul}}
                                        </span>
                                        <hr style="border-top: 1px solid #666666; margin: 0.25rem 0">
                                        <p style="margin:0.25rem 0 0.75rem 0;">
                                            {{$lolos->fungsi}}
                                        </p>
                                        {{-- <br>
                                        <div class="position-absolute bottom-0 end-0">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: unset">
                                                    <p class="text-success"
                                                        style="margin: 0 0.5rem 0.25rem 0; font-weight: 600; text-align: end;">
                                                        <small>Rp.</small> {{ number_format($lolos->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
    
            <!-- Tidak Lolos Cek -->
            <div class="tab-pane fade" id="nav-tidak_lolos" role="tabpanel" aria-labelledby="nav-tidak_lolos-tab" tabindex="0">
                <div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert"
                    style="margin-top: 1rem; padding: 0.5rem 1rem 0.75rem 1rem; text-align: justify;">
                    <span>Peraturan komunitas Ambilin bisa dibaca <a href="#" style="text-weight:bold">disini</a></span>
                </div>
                <div class="row d-flex justify-content-center" style="padding: 0.5rem 0;">
                    @foreach ($tidak_lolos_cek as $tidak_lolos)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="margin: 0.5rem 0; ">
                            <a href="{{ route('detail', ['fitur' => 'sebar', 'id' => $tidak_lolos->id]) }}"
                                style="text-decoration: none; color:black;">
                                <div class="card border border-1 h-100" style="background-color: gainsboro;">
                                    <div class="card border border-0" style="aspect-ratio: 1 / 1;">
                                        <div class="position-absolute top-0 start-0">
                                            @if ($tidak_lolos->id_kondisi == 1)
                                                @php $badge_color = 'text-bg-danger'; @endphp
                                            @elseif ($tidak_lolos->id_kondisi == 2)
                                                @php $badge_color = 'text-bg-warning'; @endphp
                                            @elseif ($tidak_lolos->id_kondisi == 3)
                                                @php $badge_color = 'text-bg-success'; @endphp
                                            @elseif ($tidak_lolos->id_kondisi == 4)
                                                @php $badge_color = 'text-bg-info'; @endphp
                                            @endif
                                            <span class="badge {{ $badge_color }}"
                                                style="font-size: 75%; font-weight: 600; margin-left: 0.2rem; text-transform: capitalize;">
                                                {{$tidak_lolos->kondisi}}
                                            </span>
                                        </div>
                                        @php
                                            $foto_sebar = "https://ambilin.com/img/png/ambilin.png";
                                            if (!empty($tidak_lolos->foto) && file_exists('public/img/sebar/' . $tidak_lolos->foto)) {
                                                $foto_sebar = 'public/img/sebar/' . $tidak_lolos->foto;
                                            }
                                        @endphp
                                        <img src="{!! asset($foto_sebar) !!}" class="card-img-top"
                                            alt="{{$tidak_lolos->judul}}"
                                            style="aspect-ratio: 1 / 1; object-fit: cover;">
                                    </div>
    
                                    <div class="container"
                                        style="font-size: 75%; letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                                        <span class="text-truncate" style="margin:0.25rem 0; font-size: 100%; font-weight: 700;" id="nama_barkas">
                                            {{$tidak_lolos->judul}}
                                        </span>
                                        <hr style="border-top: 1px solid #666666; margin: 0.25rem 0">
                                        <p style="margin:0.25rem 0 0.75rem 0;">
                                            {{$tidak_lolos->fungsi}}
                                        </p>
                                        {{-- <br>
                                        <div class="position-absolute bottom-0 end-0">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: unset">
                                                    <p class="text-success"
                                                        style="margin: 0 0.5rem 0.25rem 0; font-weight: 600; text-align: end;">
                                                        <small>Rp.</small> {{ number_format($tidak_lolos->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
    
            <!-- Laku -->
            <div class="tab-pane fade" id="nav-laku" role="tabpanel" aria-labelledby="nav-laku-tab" tabindex="0">
                <div class="row d-flex justify-content-center" style="padding: 0.5rem 0;">
                    @foreach ($barang_laku as $laku)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="margin: 0.5rem 0; ">
                            <a href="{{ route('detail', ['fitur' => 'sebar', 'id' => $laku->id]) }}"
                                style="text-decoration: none; color:black;">
                                <div class="card border border-1 h-100" style="background-color: gainsboro;">
                                    <div class="card border border-0" style="aspect-ratio: 1 / 1;">
                                        <div class="position-absolute top-0 start-0">
                                            @if ($laku->id_kondisi == 1)
                                                @php $badge_color = 'text-bg-danger'; @endphp
                                            @elseif ($laku->id_kondisi == 2)
                                                @php $badge_color = 'text-bg-warning'; @endphp
                                            @elseif ($laku->id_kondisi == 3)
                                                @php $badge_color = 'text-bg-success'; @endphp
                                            @elseif ($laku->id_kondisi == 4)
                                                @php $badge_color = 'text-bg-info'; @endphp
                                            @endif
                                            <span class="badge {{ $badge_color }}"
                                                style="font-size: 75%; font-weight: 600; margin-left: 0.2rem; text-transform: capitalize;">
                                                {{$laku->kondisi}}
                                            </span>
                                        </div>
                                        @php
                                            $foto_sebar = "https://ambilin.com/img/png/ambilin.png";
                                            if (!empty($laku->foto) && file_exists('public/img/sebar/' . $laku->foto)) {
                                                $foto_sebar = 'public/img/sebar/' . $laku->foto;
                                            }
                                        @endphp
                                        <img src="{!! asset($foto_sebar) !!}" class="card-img-top"
                                            alt="{{$laku->judul}}"
                                            style="aspect-ratio: 1 / 1; object-fit: cover;">
                                    </div>
    
                                    <div class="container"
                                        style="font-size: 75%; letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                                        <span class="text-truncate" style="margin:0.25rem 0; font-size: 100%; font-weight: 700;" id="nama_barkas">
                                            {{$laku->judul}}
                                        </span>
                                        <hr style="border-top: 1px solid #666666; margin: 0.25rem 0">
                                        <p style="margin:0.25rem 0 0.75rem 0;">
                                            {{$laku->fungsi}}
                                        </p>
                                        {{-- <br>
                                        <div class="position-absolute bottom-0 end-0">
                                            <div class="row">
                                                <div class="col-auto" style="padding-left: unset">
                                                    <p class="text-success"
                                                        style="margin: 0 0.5rem 0.25rem 0; font-weight: 600; text-align: end;">
                                                        <small>Rp.</small> {{ number_format($laku->harga, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- <div  class="container" style="width:100%; padding-bottom:3rem">
    <!--style accordion-->
        <style>
            .accordion-button {
                color: #41464b;
                background-color: #e2e3e5;
                border-color: black;
            }
    
            .accordion-button:focus {
                z-index: 3;
                border-color: #badbcc;
                outline: 0;
                box-shadow: #d1e7dd;
            }
    
            .accordion-button:not(.collapsed) {
                color: #0f5132;
                background-color: #d1e7dd;
                box-shadow: inset 0 calc(var(--bs-accordion-border-width) * -1) 0 #0f5132;
            }
    
            .accordion-button:not(.collapsed):after {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230c4128'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            }
        </style>
        <!--style accordion end-->

        <div style="padding: 1rem">
            <!--accordions-->
            <div class="accordion" id="sebarku">
                <!--Proses cek-->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="prosesCek-heading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#prosesCek-collapse" aria-expanded="true"
                            aria-controls="prosesCek-collapse">
                            <b>Proses Cek</b>
                        </button>
                    </h2>
                    <div id="prosesCek-collapse" class="accordion-collapse collapse show"
                        aria-labelledby="prosesCek-heading">
                        <div class="accordion-body">
                            <div class="container">
                                <table class="table table-striped table-borderless" style=" width: 100%">
                                @foreach ($proses as $barang)
                                    @php
                                        $foto = $barang->foto;
                                        $imgurl = "public/img/sebar/" . $foto ."";
                                    @endphp 
                                    <tr class="row">
                                    <td class="col-6 d-flex align-items-center justify-content-center">
                                        <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                                        style="
                                        background-size:cover;
                                        background-position: center;
                                        width:10rem;
                                        height: 8rem;
                                        ">
                                            <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style=" border-radius: 5%;object-fit: cover;height: 8rem;width:auto">
                                        </div>
                                    </td>
                                    <td class="col-6">
                                        <p style="font-weight:500">{{$barang->judul}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">{{Str::limit($barang->deskripsi,32)}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">kondisi: {{$barang->kondisi}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">Jenis: {{$barang->jenis}}</p>
                                        <a href="detail/sebar/{{$barang->id}}" class="btn btn-success" style="margin: 0.5rem 0; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.25rem 1rem;">detail</button>
                                    </td>
                                </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--proses cek end-->

                <!--lolos cek-->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="lolosCek-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" style="margin-top:2px"
                            data-bs-target="#lolosCek-collapse" aria-expanded="false"
                            aria-controls="lolosCek-collapse">
                            <b>Lolos Cek</b>
                        </button>
                    </h2>
                    <div id="lolosCek-collapse" class="accordion-collapse collapse"
                        aria-labelledby="lolosCek-heading">
                        <div class="accordion-body">
                            <div class="container">
                                <table class="table table-striped table-borderless" style=" width: 100%">
                                @foreach ($lolos as $barang)
                                    @php
                                        $foto = $barang->foto;
                                        $imgurl = "public/img/sebar/" . $foto ."";
                                    @endphp 
                                    <tr class="row">
                                    <td class="col-6 d-flex align-items-center justify-content-center">
                                        <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                                        style="
                                        background-size:cover;
                                        background-position: center;
                                        width:10rem;
                                        height: 8rem;
                                        ">
                                            <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style=" border-radius: 5%;object-fit: cover;height: 8rem;width:auto">
                                        </div>
                                    </td>
                                    <td class="col-6">
                                        <p style="font-weight:500">{{$barang->judul}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">{{Str::limit($barang->deskripsi,32)}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">kondisi: {{$barang->kondisi}}</p>
                                        <p style="margin: 0;padding-top:0.25rem">Jenis: {{$barang->jenis}}</p>
                                        <a href="detail/sebar/{{$barang->id}}" class="btn btn-success" style="margin: 0.5rem 0; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.25rem 1rem;">detail</button>
                                    </td>
                                </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--lolos cek end-->
                
                <!--tidak lolos cek-->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="tidakLolosCek-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" style='margin-top:2px'
                            data-bs-target="#tidakLolosCek-collapse" aria-expanded="false"
                            aria-controls="tidakLolosCek-collapse">
                            <b>Tidak Lolos Cek</b>
                        </button>
                    </h2>
                    <div id="tidakLolosCek-collapse" class="accordion-collapse collapse"
                        aria-labelledby="tidakLolosCek-heading">
                        <div class="accordion-body">
                            <div class="container">
                                <div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
                                    <p> Peraturan komunitas Ambilin bisa dibaca <a href="#" style="text-weight:bold">disini</a>
                                    </p>
                                </div>
                                <table class="table table-striped table-borderless" style=" width: 100%">
                                @foreach ($tidak as $barang)
                                    @php
                                    $foto = $barang->foto;
                                    $imgurl = "public/img/sebar/" . $foto ."";
                                @endphp 
                                <tr class="row">
                                <td class="col-6 d-flex align-items-center justify-content-center">
                                    <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                                    style="
                                    background-size:cover;
                                    background-position: center;
                                    width:10rem;
                                    height: 8rem;
                                    ">
                                        <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style="border-radius: 5%;object-fit: cover;height: 8rem;width:auto">
                                    </div>
                                </td>
                                <td class="col-6">
                                    <p style="font-weight:500">{{$barang->judul}}</p>
                                    <p style="margin: 0;padding-top:0.25rem">{{Str::limit($barang->deskripsi,32)}}</p>
                                    <p style="margin: 0;padding-top:0.25rem">kondisi: {{$barang->kondisi}}</p>
                                    <p style="margin: 0;padding-top:0.25rem">Jenis: {{$barang->jenis}}</p>
                                    <a href="detail/sebar/{{$barang->id}}" class="btn btn-success" style="margin: 0.5rem 0; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.25rem 1rem;">detail</button>
                                </td>
                                </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--tidak lolos cek end-->
            </div>
            <!--accordions end-->
        </div>    

        <div style="padding-top:1rem; padding-bottom:1rem" class="d-flex justify-content-center">
                <a href="sebar-baru" role="button" class="btn btn-success" style="width: 80%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Tambah Barkas</a>
            </div>
        </div>

    </div> --}}
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}