@extends('layouts.default')

@section('content')
{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCx0EKlhFQxtCkftinhjGf3BqFMy7oyF4Q&callback=initMap&libraries=&v=weekly" defer></script> --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <style>
                            p {
                                margin:0;
                            }

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
                
                            button {
                                margin: 0.2px 0;
                            }
                        </style>

                        <div class="container">
                            <div class="accordion" id="profil">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelDataDiri-heading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelDataDiri-collapse" aria-expanded="true"
                                            aria-controls="panelDataDiri-collapse" style="margin-top: 0">
                                            <b>Alamat Pengambilan</b>
                                        </button>
                                    </h2>
                                    <div id="panelDataDiri-collapse" class="accordion-collapse collapse show"
                                        aria-labelledby="panelDataDiri-heading">
                                        <div class="accordion-body">
                                            <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                                <tr>
                                                    <td><p>Nama Lokasi</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{$wp_lokasi->nama_lokasi}}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Jenis Lokasi</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $jenis_lokasi->jenis_lokasi }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Catatan</p></td>
                                                    <td><p>:</p></td>
                                                    @if ($wp_lokasi->catatan != null)
                                                    <td><p><b>{{ $wp_lokasi->catatan }}</b></p></td>
                                                    @else
                                                    <td><p class="text-danger"><b>―</b></p></td>
                                                    @endif
                                                </tr>
                                                {{-- <tr>
                                                    <td colspan="3" style="width: 100%">
                                                        <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between" style="width: 100%">
                                                            <a href="{{route('edit_detail_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                        </div>
                                                        </center>
                                                    </td>
                                                </tr> --}}
                                                <tr><td colspan="3"><hr></td></tr>
                                                <tr>
                                                    <td><p>Provinsi</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $prov->name }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Kabupaten</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $kab->name }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Kecamatan</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $kec->name }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Kelurahan</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $kel->name }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Alamat</p></td>
                                                    <td><p>:</p></td>
                                                    <td><p><b>{{ $wp_lokasi->alamat_lokasi }}</b></p></td>
                                                </tr>
                                                <tr>
                                                    <td><p>Kode Pos</p></td>
                                                    <td><p>:</p></td>
                                                    @if($wp_lokasi->kode_pos != null)
                                                    <td><p><b>{{ $wp_lokasi->kode_pos }}</b></p></td>
                                                    @else
                                                    <td><p class="text-danger"><b>―</b></p></td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="width: 100%">
                                                        <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between" style="width: 100%">
                                                            {{-- <a href="{{route('edit_alamat_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a> --}}
                                                            <a href="{{route('edit_detail_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                        </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelBerkasKTP-heading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelBerkasKTP-collapse" aria-expanded="false"
                                            aria-controls="panelBerkasKTP-collapse" style="margin-bottom: 0">
                                            <b>Lampiran Foto</b>
                                        </button>
                                    </h2>
                                    <div id="panelBerkasKTP-collapse" class="accordion-collapse collapse show"
                                        aria-labelledby="panelBerkasKTP-heading">
                                        <div class="accordion-body">
                                            <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                                <tr>
                                                    <td>Denah Lokasi</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        @if(($wp_lokasi->lokasi_x != null) && ($wp_lokasi->lokasi_y != null))
                                                            <div id="map" style="height: 10rem; width: 100%"></div>
                                                            <script>
                                                                // async function initMap() {
                                                                //     const myLocation = {
                                                                //         lat: parseFloat("<?php echo"$wp_lokasi->lokasi_x"?>"),
                                                                //         lng: parseFloat("<?php echo"$wp_lokasi->lokasi_y"?>"),
                                                                //     };

                                                                //     const map = new google.maps.Map(document.getElementById("map"), {
                                                                //         zoom: 12,
                                                                //         center: myLocation,
                                                                //     });

                                                                //     const marker = new google.maps.Marker({
                                                                //         position: myLocation,
                                                                //         map,
                                                                //         title: "Lokasi Saya",
                                                                //     });
                                                                // }

                                                                // var mapOptions = {
                                                                //     center: [{!! $wp_lokasi->lokasi_x !!}, {!! $wp_lokasi->lokasi_y !!}],
                                                                //     zoom: 15
                                                                // }

                                                                var map = L.map('map').setView([{!! $wp_lokasi->lokasi_x !!}, {!! $wp_lokasi->lokasi_y !!}], 15);

                                                                // var tiles = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
                                                                //     attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
                                                                // }).addTo(map);
                                                                var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                                    maxZoom: 19,
                                                                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                                                }).addTo(map);

                                                                // Icon options
                                                                var iconOptions = {
                                                                    iconUrl: "{!! asset('public/img/lokasi.png') !!}",
                                                                    iconSize: [50, 50]
                                                                }

                                                                // Creating a custom icon
                                                                var customIcon = L.icon(iconOptions);

                                                                // Creating Marker Options
                                                                var markerOptions = {
                                                                    title: "Lokasi Pengambilan",
                                                                    clickable: true,
                                                                    icon: customIcon
                                                                }

                                                                var marker = L.marker([{!! $wp_lokasi->lokasi_x !!}, {!! $wp_lokasi->lokasi_y !!}], markerOptions).addTo(map);
                                                                
                                                            </script>
                                                        @else
                                                            <p class="text-danger"><b>Lokasi belum ditambahkan!</b></p>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="width: 100%">
                                                        <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between" style="width: 100%">
                                                            @if(($wp_lokasi->lokasi_x != null) && ($wp_lokasi->lokasi_y != null))
                                                            <a href="{{route('edit_denah_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                            @else
                                                            <a href="{{route('edit_denah_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-success btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah</p></a>
                                                            @endif
                                                        </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <tr><td colspan="3"><hr></td></tr>
                                                <tr>
                                                    <td>Foto Lokasi</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    @if($wp_lokasi->foto_lokasi != null)
                                                    <td colspan="3">
                                                        <img alt="{{$wp_lokasi->foto_lokasi}}" src="{!! asset('public/img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi) !!}" style="max-width: 100%"/>
                                                    </td>
                                                    @else
                                                    <td colspan="3">
                                                        <p class="text-danger"><b>Gambar belum ditambahkan!</b></p>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="width: 100%">
                                                        <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between" style="width: 100%">
                                                            @if($wp_lokasi->foto_lokasi != null)
                                                            <a href="{{route('edit_foto_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                            @else
                                                            <a href="{{route('edit_foto_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-success btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah</p></a>
                                                            @endif
                                                        </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                                {{-- <tr><td colspan="3"><hr></td></tr> --}}
                                                {{-- <tr>
                                                    <td>Foto Denah Lokasi</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    @if($wp_lokasi->lampiran_denah != null)
                                                    <td colspan="3">
                                                        <img alt="{{$wp_lokasi->lampiran_denah}}" src="{!! asset('public/img/wp_lokasi/lampiran_denah/'.$wp_lokasi->lampiran_denah) !!}" style="max-width: 100%"/>
                                                    </td>
                                                    @else
                                                    <td colspan="3">
                                                        <p class="text-danger"><b>Gambar belum ditambahkan!</b></p>
                                                    </td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="width: 100%">
                                                        <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between" style="width: 100%">
                                                            @if($wp_lokasi->lampiran_denah != null)
                                                            <a href="{{route('edit_denah_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                            @else
                                                            <a href="{{route('edit_denah_lokasi', ['id' => $wp_lokasi->id])}}" role="button" class="btn btn-success btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                                class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah</p></a>
                                                            @endif
                                                        </div>
                                                        </center>
                                                    </td>
                                                </tr> --}}
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container" style="padding-top: 10px; padding-bottom: 5rem;">
                                <button role="button" class="btn btn-danger"
                                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"
                                    data-bs-toggle="modal" data-bs-target="#delLokModal">
                                    <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Hapus Lokasi</button>
                            </div>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('partials.modal_hapus_lokasi')
@endsection
