@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark " style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            @php
                if ($fitur == 'paskas') {
                    $Nama = 'Pasar Barang Bekas';
                    $imgurl = 'public/img/paskas/' . $data->foto . '';
                } else {
                    $Nama = 'Sedekah Barang Bekas';
                    $imgurl = 'public/img/sebar/' . $data->foto . '';
                }
            @endphp
            <!-- Navbar brand -->
            <a class="navbar-brand" onclick="history.back()" style="padding-left:0.5rem"><i
                    class="fa-solid fa-chevron-left"></i></a>
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{ strtoupper($fitur) }} |
                {{ $Nama }}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <style>
        p {
            margin: 0;
        }
    </style>
    <!--content-->
    <div class="container" style="width:100%; padding-bottom:2rem; ">
        <div style="padding:0.5rem">
            <div class="alert alert-secondary d-flex justify-content-center align-items-center" style=""
                role="alert">
                <div class="row" style="width:100%">
                    <div class="col-12">
                        <div class="d-flex justify-content-center" style="padding-bottom:1rem">
                            <img src="{{ asset($imgurl) }}" class="img-fluid" alt="{{ $data->judul }}"
                                style="border-radius: 5%;max-width: 80%">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <table class="table table-borderless table-sm" style="width: 95%">
                            <tr>
                                <td style="width: 10%">
                                    <p>Nama Barang</p>
                                </td>
                                <td style="width: 5%">
                                    <p>:</p>
                                </td>
                                <td style="width: 80%">
                                    <p><b>{{ $data->judul }}</b></p>
                                </td>
                            </tr>
                            <tr>
                                @php
                                    $desc = '-';
                                    if (!empty($data->deskripsi)) {
                                        $desc = $data->deskripsi;
                                    }
                                @endphp

                                <td style="width: 10%">
                                    <p>Deskripsi</p>
                                </td>
                                <td style="width: 5%">
                                    <p>:</p>
                                </td>
                                <td style="width: 80%">
                                    <p><b>{{ $desc }}</b></p>
                                </td>
                            </tr>
                            @if ($fitur == 'paskas')
                                <tr>
                                    <td style="width: 10%">
                                        <p>Harga</p>
                                    </td>
                                    <td style="width: 5%">
                                        <p>:</p>
                                    </td>
                                    <td style="width: 80%">
                                        <p><b>Rp. {{ number_format($data->harga, 0, ',', '.') }},-</b></p>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td style="width: 10%">
                                    <p>Alamat</p>
                                </td>
                                <td style="width: 5%">
                                    <p>:</p>
                                </td>
                                <td style="width: 80%">
                                    <p><b>{{ $data->alamat_lokasi }} {{ $data->kel }}, {{ $data->kec }},
                                        {{ $data->kab }}, {{ $data->prov }}</b></p>
                                </td>
                            </tr>
                        </table>

                        @if (!empty($data->lokasi_x) && !empty($data->lokasi_y) && $data->wp_id != auth()->user()->id)
                            <center>
                                <!-- Gmaps -->
                                {{-- <form action="{{ route('direction', ['id' => $data->id, 'fitur' => $fitur]) }}"
                                    method="POST" id="formLokasi">
                                    @csrf
                                    <div>
                                        <!-- <div class="buttons px-4 mt-0"> -->
                                        <input class="form-control" type="hidden" name="lokasi_x" value=''
                                            id='latitude' required>
                                        <input class="form-control" type="hidden" name="lokasi_y" value=''
                                            id='longitude' required>
                                        <div class="row" style="width: 100%;">
                                            <center>
                                                <div class="col-6">
                                                    <button class="btn btn-success" type="button" id="get-location"
                                                        disabled
                                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                        <i class="fa-solid fa-map-location-dot text-white"></i> Cek lokasi</button>
                                                </div>
                                            </center>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    <script>
                                        $(document).ready(function geolocation() {
                                            if (!navigator.geolocation) {
                                                return alert("Geolocation is not supported.")
                                            } else {
                                                navigator.geolocation.getCurrentPosition((position) => {
                                                    document.getElementById("latitude").value = position.coords.latitude;
                                                    document.getElementById("longitude").value = position.coords.longitude;
                                                });

                                                setTimeout(function() {
                                                    button();
                                                }, 1500);
                                            };
                                        });

                                        function button() {
                                            var xValue = document.getElementById("latitude").value;
                                            var yValue = document.getElementById("longitude").value;

                                            console.log(xValue);
                                            console.log(yValue);

                                            if ((xValue.length != 0) && (yValue.length != 0)) {
                                                document.getElementById("get-location").disabled = false;
                                            } else {
                                                document.getElementById("get-location").disabled = true;
                                            };
                                        };

                                        $("#get-location").click(() => {
                                            // setTimeout( function(){
                                            document.getElementById("formLokasi").submit();
                                            // },500 );
                                        });

                                        // $.ajax({
                                        //     url:geolocation(),
                                        //     success:function(){
                                        //     button();
                                        //     }
                                        // })

                                        // $.when(geolocation()).then(button());
                                    </script>
                                </form> --}}
                                <!-- END Gmaps -->

                                <!-- OSM -->
                                <div>
                                    <div class="row" style="width: 100%;">
                                        <center>
                                            <div class="col-6">
                                                <a class="btn btn-success" type="button" href="{{ route('map_barkas', ['id' => $id, 'fitur' => $fitur]) }}"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-map-location-dot text-white"></i> Cek lokasi</a>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <!-- END OSM -->
                            </center>
                        @elseif( $data->wp_id != auth()->user()->id && (empty($data->lokasi_x) || empty($data->lokasi_y)))
                            <center>
                                <div>
                                    <div class="row" style="width: 100%;">
                                        <center>
                                            <div class="col-6">
                                                <button class="btn btn-success" disabled
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-map-location-dot text-white"></i> Cek lokasi</button>
                                            </div>
                                            <div class="col-12" style="padding:0">
                                                <p style="font-size:75%; font-weight:600" class="text-danger">Pengunggah tidak menginput koordinat</p>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </center>
                        @endif

                        <hr>
                    </div>

                    <!--total-->
                    <div class="col-12">
                        <table class="table table-borderless table-sm" style="width: 95%">
                            <tr>
                                <td style="width: 10%">
                                    <p>Jenis</p>
                                </td>
                                <td style="width: 5%">
                                    <p>:</p>
                                </td>
                                <td style="width: 80%">
                                    <p>
                                        <b>{{ $data->jenis }}</b>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 10%">
                                    <p>Kondisi</p>
                                </td>
                                <td style="width: 5%">
                                    <p>:</p>
                                </td>
                                <td style="width: 80%">
                                    <p><b>{{ $data->kondisi }}</b></p>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td style="width: 10%"><p>Estimasi Harga</p></td>
                                <td style="width: 5%"><p>:</p></td>
                                <td style="width: 80%"><p>
                                <b>
                                     
                                        Rp. {{ number_format($est_down, 0, ',', '.') }} - Rp. {{ number_format($est_top, 0, ',', '.') }} 
                                    
                                     |  (± Rp. {{ number_format($avg, 0, ',', '.') }})
                                    </b>
                                </p></td>
                            </tr> --}}
                        </table>
                        <hr>
                    </div>
                    <!--total end-->
                    <div class="row d-flex justify-content-center">
                        @php
                            if($fitur == 'paskas'){
                                $subjek = 'Penjual';
                            } else {
                                $subjek = 'Pemilik';
                            }
                        @endphp
                        @if ($data->wp_id != auth()->user()->id)
                            <div class="col-6">
                                <a role="button" href="{{ route('chat', ['id' => $data->wp_id]) }}"
                                    class="btn btn-success btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                    <i class="fa-solid fa-comment text-light"></i>&nbsp;&nbsp; Hubungi {{$subjek}}
                                </a>
                            </div>
                            {{-- {{dd($data)}} --}}
                        @elseif($data->wp_id == auth()->user()->id)
                            <div class="col-6">
                                <button class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;"
                                    data-bs-toggle="modal" data-bs-target="#delFitModal">
                                    <i class="fa-solid fa-trash text-light"></i>&nbsp;&nbsp; Hapus
                                </button>
                            </div>
                            @include('partials.modal_hapus_fitur')
                            @if ($data->aktif == 1)
                                <div class="col-6">
                                    <a role="button"
                                        href="{{ route('nonaktifkan_fitur', ['fitur' => $fitur, 'id' => $id]) }}"
                                        class="btn btn-warning btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        <i class="fa-solid fa-power-off text-danger"></i>&nbsp;&nbsp;Nonaktifkan
                                    </a>
                                </div>
                            @elseif($data->aktif == 0)
                                <div class="col-6">
                                    <a role="button"
                                        href="{{ route('aktifkan_fitur', ['fitur' => $fitur, 'id' => $id]) }}"
                                        class="btn btn-success btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        <i class="fa-solid fa-power-off text-light"></i>&nbsp;&nbsp; Aktifkan
                                    </a>
                                </div>
                            @endif

                            {{-- Under construction --}}
                                {{-- {{dd($data)}} --}}
                            @if ($fitur == 'paskas' && \Carbon\Carbon::parse($data->waktucatat)->addMonth()->format('Y-m-d H:i:s') < $today && $data->status_publikasi == 2)
                                @if ($fitur == 'paskas')
                                    <div class="col-6" style='padding:0.5rem'>
                                        <a role="button" href="{{ route('paskas_sedekah', ['id' => $id]) }}"
                                            class="btn btn-success btn-lg btn-block"
                                            onclick="return confirm('Apakah anda yakin ingin menyedekahkan barang ini?')"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                            <i class="fa-solid fa-box-open text-light"></i>&nbsp;&nbsp; Sedekahkan
                                        </a>
                                    </div>
                                    {{-- @else
                                    <div class="col-6" style='padding:0.5rem'>
                                        <a role="button"
                                            href="#"
                                            class="btn btn-success btn-lg btn-block" onclick="return confirm('Apakah anda yakin ingin merequest ambilin?')"
                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                            <i class="fa-solid fa-box-open text-light"></i>&nbsp;&nbsp; Request ambilin
                                        </a>
                                    </div> --}}
                                @endif
                            @endif

                            {{-- Under construction end --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
