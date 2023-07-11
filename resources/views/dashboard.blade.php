@extends('layouts.layout_dashb')
@section('content')

    {{-- @include('partials.navbar_dashboard') --}}

    @auth
        @php
        $lt = 0;
        $epr = 0;
        if (isset($point_lt)) {
            $lt = $point_lt;
        }
        if (isset($point_epr)) {
            $epr = $point_epr;
        }
        @endphp

        <style>
            body {
                background-color: #cfe1d8;
            }

            .card {
                border: 0;
            }
        </style>

        {{-- Header --}}
        @include('partials.navbar_dashboard')
        {{-- End Header --}}

        {{-- <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container p-3 top-0 start-50 translate-middle-x" data-original-class="toast-container p-3">
              <div class="toast fade show">
                <div class="toast-header">
                  <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
                  <strong class="me-auto">Bootstrap</strong>
                  <small>11 mins ago</small>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Hello, world! This is a toast message.
                </div>
              </div>
            </div>
          </div> --}}

        {{-- Point --}}
        <div style="padding: 0 3.5rem;">
            <a href='{{ route('statistik') }}' style='text-decoration:none;'>
                <div class="card border border-0 rounded-3" style="margin-top: -1.5rem;">
                    <div class="row d-flex justify-content-evenly" style="padding: 0.5rem;">
                        @php
                            if (fmod($lt, 1) == 0.0) {
                                $lt_num = number_format($lt, 0, ',', '.');
                            } else {
                                $lt_num = number_format($lt, 1, ',', '.');
                            }
                            if (fmod($epr, 1) == 0.0) {
                                $epr_num = number_format($epr, 0, ',', '.');
                            } else {
                                $epr_num = number_format($epr, 1, ',', '.');
                            }
                            
                        @endphp
                        <div class="col-3" style="padding: 0">
                            <div class="row">
                                <center style="padding: 0">
                                    <div class="col-12 d-flex justify-content-center">
                                        <h1 style="color:#176e41; margin: 0;">{{ $count_amb }}</h1>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Jml Pickup</p>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <div class="col-3" style="padding: 0">
                            <div class="row">
                                <center style="padding: 0">
                                    <div class="col-12 d-flex justify-content-center">
                                        <h1 style="color:#176e41; margin: 0;">{{$lt_num}}</h1>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">LT Point</p>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <div class="col-3" style="padding: 0">
                            <div class="row">
                                <center style="padding: 0">
                                    <div class="col-12 d-flex justify-content-center">
                                        <h1 style="color:#176e41; margin: 0;">{{$epr_num}}</h1>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">EPR Point</p>
                                    </div>
                                </center>
                            </div>
                        </div>
                        @if (auth()->user()->verified > 1)
                            <div class="col-11" style="padding-top: 0.25rem">
                                <div class="progress rounded-0" style="height: 4px;">
                                    <div class="progress-bar rounded-0" role="progressbar"
                                        style="width: {{ $width }}%; background-color:#176e41;"></div>
                                </div>
                                <center>
                                    @if ($exp_left != 0)
                                        <p style="margin: 0; font-size: 69%; color:#176e41;">{{ $exp_left }}x transaksi lagi
                                            menuju {{ $next_level->pangkat }}</p>
                                    @else
                                        <p style="margin: 0; font-size: 69%; color:#176e41;">Selamat, anda berada pada pangkat
                                            tertinggi! terus gunakan layanan ambilin untuk langsung naik pangkat setelah pangkat
                                            selanjutnya tersedia</p>
                                    @endif
                                </center>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        {{-- End Point --}}

        {{-- <div class="toast-container position-static">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
            
                <strong class="me-auto">Bootstrap</strong>
                <small class="text-muted">11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                Hello, world! This is a toast message.
                </div>
            </div>
        </div> --}}


        <!--point-->
        {{-- <div style="width:100%; padding-bottom:0.5rem">
    <center>
    <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert"  style="margin-bottom: 0 !important">            
        <div class="row row-cols-3 justify-content-between d-flex" style="width:100%">
            <div class="col-md-4">
                <div style="font-size: 90%">Ambilin</div>
                <div><h5>{{$ambilin}}</h5></div>
            </div>
            <div class="col-md-4">
                <div style="font-size: 90%">LT</div>
                <div><h5>{{$lt}}</h5></div>
            </div>
            <div class="col-md-4">
                <div style="font-size: 90%">EPR</div>
                <div><h5>{{$epr}}</h5></div>
            </div>
        </div>
    </div>
    </center>
</div> --}}
        <!--point end-->
    @endauth

    @if (session()->has('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert"
            style="margin: 1rem 1rem;margin-bottom: 0;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!--content-->
    {{-- verified == 1 --}}
    @if ($user->verified == 1)
        @if ($user->kat_user == 1 || $user->kat_user == 3)
            @include('partials.verifikasi_proses')
            <div class="container" style="padding: 0 1rem;padding-top:0.5rem;padding-bottom:2rem;">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{route('iframe', ['link' => 'ambilinpedia'])}}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                </div>
            </div>
        @elseif($user->kat_user == 2)
            @include('partials.verifikasi_proses')
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" class="img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" class="img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div> --}}
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_mitra') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="harga mitra"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Mitra</p>
                        </a>
                    </div> --}}
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="daftar harga"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Daftar Harga</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{route('iframe', ['link' => 'ambilinpedia'])}}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_pelapak') }}"
                            style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="harga pelapak"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Pelapak</p>
                        </a>
                    </div> --}}
                </div>
            </div>
        @endif
        {{-- verified == 1 end --}}

        {{-- verified == 2 --}}
    @elseif($user->verified == 2)
        @if ($user->kat_user == 1 || $user->kat_user == 3)
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row">
                    @php
                        $asset = '';
                        if ($user->count < 3) {
                            $asset = '_grey.png';
                        } else {
                            $asset = '.png';
                        }
                    @endphp

                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <a href="{{route('ambilin')}}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <a href="{{route('tukar-poin')}}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar poin.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </a>
                    </div>

                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <a href="epr" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr.png') !!}" class="lazy img-fluid" alt="epr"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </a>
                    </div>

                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="javascript:void(0)" style="text-align:center;text-decoration:none;color:black;" onclick="getLocationPaskas()">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas'.$asset.'') !!}" loading='lazy' class="lazy img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </a>
                        <script>
                            function getLocationPaskas() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(showPositionPaskas, noPositionPaskas, {timeout:100});
                                }
                            }

                            function showPositionPaskas(position) {
                                var lat = position.coords.latitude;
                                var long = position.coords.longitude;
                                var url = "{{route('paskas',['x'=>':lat', 'y'=>':long'])}}";
                                url = url.replace(':lat', lat);
                                url = url.replace(':long', long);
                                window.location.replace(url);
                            }

                            function noPositionPaskas() {
                                var url = "{{ route('paskas_kosong') }}";
                                return window.location.replace(url);
                            }
                        </script>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="javascript:void(0)" style="text-align:center;text-decoration:none;color:black;" onclick="getLocationSebar()">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar' . $asset . '') !!}" loading='lazy' class="lazy img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </a>
                        <script>
                            function getLocationSebar() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(showPositionSebar, noPositionSebar, {timeout:100});
                                }
                            }

                            function showPositionSebar(position) {
                                var lat = position.coords.latitude;
                                var long = position.coords.longitude;
                                var url = "{{route('sebar',['x'=>':lat', 'y'=>':long'])}}";
                                url = url.replace(':lat', lat);
                                url = url.replace(':long', long);
                                window.location.replace(url);
                            }

                            function noPositionSebar() {
                                var url = "{{ route('sebar_kosong') }}";
                                return window.location.replace(url);
                            }
                        </script>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>

                </div>
            </div>
        @elseif($user->kat_user == 2)
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    @php
                        $asset = '';
                        if ($count_amb < 3) {
                            $asset = '_grey.png';
                        } else {
                            $asset = '.png';
                        }
                    @endphp

                    <div class="col-4 d-flex align-items-center justify-content-center">

                        <a href="javascript:void(0)" style="text-align:center;text-decoration:none;color:black;" onclick="getLocation()">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </a>
                        <script>
                            function getLocation() {
                                if (navigator.geolocation) {
                                    navigator.geolocation.getCurrentPosition(showPosition);
                                } else {
                                    return alert("Geolocation is not supported.")
                                }
                            }

                            function showPosition(position) {
                                var lat = position.coords.latitude;
                                var long = position.coords.longitude;
                                var url = "{{route('ambilin_kolektor',['x'=>':lat', 'y'=>':long'])}}";
                                url = url.replace(':lat', lat);
                                url = url.replace(':long', long);
                                window.location.replace(url);
                            }
                        </script>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <a href="tukar-poin" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar poin.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </a>
                    </div>

                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <a href="epr" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr.png') !!}" loading='lazy' class="lazy img-fluid" alt="epr"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </a>
                    </div>

                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="paskas" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas.png') !!}" class="img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="sebar" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar' . $asset . '') !!}" class="img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </a>
                    </div> --}}
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_mitra') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="harga mitra"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Mitra</p>
                        </a>
                    </div> --}}
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="daftar harga"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Daftar Harga</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_pelapak') }}"
                            style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_pelapak.png') !!}" loading='lazy' class="lazy img-fluid" alt="harga pelapak"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Pelapak</p>
                        </a>
                    </div> --}}


                </div>
            </div>
        @endif
        {{-- verified == 2 end --}}

        {{-- verified == 3 --}}
    @elseif($user->verified == 3)
        @if ($user->kat_user == 1 || $user->kat_user == 3)
            <div style="padding:1rem; padding-top:1rem; padding-bottom:0.5rem">
                <div class="alert alert-danger" role="alert" style="margin: 0">
                    <h6 class='text-center' style="width: 100%"> <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp; Verifikasi
                        akun anda ditolak</h6>
                    <hr>
                    <p class="text-center">Silahkan periksa kembali data diri anda <a href="profile">di sini</a> .</p>
                </div>
            </div>
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                </div>
            </div>
        @elseif($user->kat_user == 2)
            <div style="padding:1rem; padding-top:1rem; padding-bottom:0.5rem">
                <div class="alert alert-danger d-flex align-items-center" role="alert" style="margin: 0">
                    <h6 class='text-center' style="width: 100%"> <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp; Verifikasi
                        akun anda ditolak</h6>
                </div>
            </div>
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_mitra') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/notfound.jpg') !!}" loading='lazy' class="lazy img-fluid" alt="harga mitra"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Mitra</p>
                        </a>
                    </div> --}}
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="daftar harga"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Daftar Harga</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_pelapak') }}"
                            style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/notfound.jpg') !!}" loading='lazy' class="lazy img-fluid" alt="harga pelapak"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Pelapak</p>
                        </a>
                    </div> --}}

                </div>
            </div>
        @endif
        {{-- verified == 3 end --}}

        {{-- verified == 0 --}}
    @elseif($user->verified == 0)
        @if ($user->kat_user == 1 || $user->kat_user == 3)
            @include('partials.lengkapi_data')
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                </div>
            </div>
        @elseif($user->kat_user == 2)
            <div style="padding:1rem; padding-top:1rem; padding-bottom:0.5rem">
                <div style='padding:1rem; padding-top:1rem; padding-bottom:0.5rem;'>
                    <div class="alert alert-danger d-flex align-items-center" role="alert"
                        style="width: 100%; margin-bottom:0px">
                        <h6 style='width: 100%' class="text-center">Selamat datang di aplikasi Ambilin!</br>
                            Anda saat ini belum bisa menggunakan beberapa fitur.
                            <hr> <i class="fa-solid fa-triangle-exclamation"></i> &nbsp;&nbsp;
                            Lengkapi data diri anda dengan cara datang ke Bintari
                            sembari membawa KTP anda agar dapat menggunakan fitur yang tersedia.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="container" style="padding: 0 1.5rem;padding-top:0.5rem;padding-bottom:2rem">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center" style="padding-top: 0.5rem;">
                        <h6 style="color: #176e41; font-weight: bold;">Pilih Layanan</h6>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilin_grey_uns.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/tukar_poin_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="tukar poin"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">tukar poin</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/epr_grey.png') !!}" loading='lazy' class="lazy img-fluid" alt="EPR"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">EPR</p>
                        </div>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/paskas_grey.png') !!}" class="img-fluid" alt="paskas"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">paskas</p>
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <div style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/sebar_grey.png') !!}" class="img-fluid" alt="sebar"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">sebar</p>
                        </div>
                    </div> --}}
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_mitra') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/notfound.jpg') !!}" loading='lazy' class="lazy img-fluid" alt="harga mitra"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Mitra</p>
                        </a>
                    </div> --}}
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga') }}" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/icon_harga_mitra.png') !!}" loading='lazy' class="lazy img-fluid" alt="daftar harga"
                                        style="max-height: 120px;">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Daftar Harga</p>
                        </a>
                    </div>
                    <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="iframe/ambilinpedia" style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('https://ambilin.com/img/png/ambilinpedia.png') !!}" loading='lazy' class="lazy img-fluid" alt="ambilinpedia"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">ambilinpedia</p>
                        </a>
                    </div>
                    {{-- <div class="col-4 d-flex align-items-center justify-content-center" style="padding-top:0.5rem">
                        <a href="{{ route('harga_pelapak') }}"
                            style="text-align:center;text-decoration:none;color:black;">
                            <div class="card">
                                <div class="card-body rounded-circle" style="background-color: #fcfbe6;">
                                    <img src="{!! asset('public/img/notfound.jpg') !!}" loading='lazy' class="lazy img-fluid" alt="harga pelapak"
                                        style="max-height: 120px">
                                </div>
                            </div>
                            <p style="margin:0; font-size: 90%">Hg Pelapak</p>
                        </a>
                    </div> --}}

                </div>
            </div>
        @endif
    @endif
    {{-- verified == 0 end --}}

    @auth
        {{-- Total Sampah --}}
        <div style="padding: 0 1.5rem; padding-bottom: 1rem;">
            <div class="card rounded-3">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <h6 style="color: #176e41; font-weight: bold; margin: 0; padding-top: 0.5rem">Total Berat
                                    Sampahku</h6>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <p style="color: #176e41; font-size: 90%; margin: 0;">{{ $now }}</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row card-body d-flex justify-content-center">
                    <div class="col-3" style="padding: 0">
                        <div class="row">
                            <center style="padding: 0">
                                @php
                                    if ($berat_minggu < 1000) {
                                        $bminggu = $berat_minggu;
                                        $satuan = 'kg';
                                        $coma = 2;
                                    } elseif ($berat_minggu >= 1000) {
                                        $bminggu = $berat_minggu / 1000;
                                        $satuan = 'ton';
                                        $coma = 3;
                                    }
                                @endphp
                                <div class="col-12 d-flex justify-content-center">
                                    <h1 style="color:#176e41; margin: 0;">
                                        {{ number_format($bminggu, $coma, ',', '.') }}
                                    </h1>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Minggu ini
                                        ({{ $satuan }})</p>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-1 d-flex">
                        <div class="vr"></div>
                    </div>
                    <div class="col-3" style="padding: 0">
                        <div class="row">
                            <center style="padding: 0">
                                @php
                                    if ($berat_bulan < 1000) {
                                        $bbulan = $berat_bulan;
                                        $satuan = 'kg';
                                        $coma = 2;
                                    } elseif ($berat_bulan >= 1000) {
                                        $bbulan = $berat_bulan / 1000;
                                        $satuan = 'ton';
                                        $coma = 3;
                                    }
                                @endphp
                                <div class="col-12 d-flex justify-content-center">
                                    <h1 style="color:#176e41; margin: 0;">{{ number_format($bbulan, $coma, ',', '.') }}</h1>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Bulan ini
                                        ({{ $satuan }})</p>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-1 d-flex">
                        <div class="vr"></div>
                    </div>
                    <div class="col-3" style="padding: 0">
                        <div class="row">
                            <center style="padding: 0">
                                @php
                                    if ($berat_tahun < 1000) {
                                        $btahun = $berat_tahun;
                                        $satuan = 'kg';
                                        $coma = 2;
                                    } elseif ($berat_tahun >= 1000) {
                                        $btahun = $berat_tahun / 1000;
                                        $satuan = 'ton';
                                        $coma = 3;
                                    }
                                @endphp
                                <div class="col-12 d-flex justify-content-center">
                                    <h1 style="color:#176e41; margin: 0;">{{ number_format($btahun, $coma, ',', '.') }}
                                    </h1>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Tahun ini
                                        ({{ $satuan }})</p>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Total Sampah --}}
        <!--total sampah-->
        {{-- <div style="padding-top:0.5rem; width:100%">
    <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert">
        <div class="row" style="margin-bottom: 5%">
            <div class="col-12" style="padding:0%;">
                <div class="col" style="text-align: center">
                    <div><h5>Total Pengumpulan sampahku (kg)</h5></div>
                    <div style="padding-bottom: 10px; font-size: 90%">{{$now}}</div>
                </div>
            </div>
            <hr>
            <center>
            <div class="row row-cols-3" style="padding:0%;">
                <div class="col">
                        <div style="font-size: 90%">minggu ini</div>
                        <div><h5>{{$berat_minggu}}</h5></div>
                </div>
                <div class="col">
                    <div style="font-size: 90%">bulan ini</div>
                    <div><h5>{{$berat_bulan}}</h5></div>
                </div>
                <div class="col">
                    <div style="font-size: 90%">tahun ini</div>
                    <div><h5>{{$berat_tahun}}</h5></div>
                </div>
            </div>
            </center>
        </div>
    </div>
</div> --}}
        <!--total end-->
    @else
        <br>
    @endauth

    <!--harga material-->
    <div style="width:100%">
        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert"
            style="margin: 0;">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h5>Harga Material Anorganik</h5>
                </div>
                <div class="col-12 d-flex justify-content-center" style="font-size: 90%">
                    {{ $now }}
                </div>
            </div>
        </div>
    </div>
    @include('partials.harga_naik')
    <div class="container"style="padding-bottom:5%;">
        <table class="table table-borderless" style=" width: 100%">
            @foreach ($cat_barang->take(5) as $barang)
                @php
                    $foto = $barang->foto;
                    $imgurl = 'https://ambilin.com/berkas/' . $foto . '';
                @endphp
                <tr>
                    <td>
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $barang->nama }}</h5>
                                        <p class="card-text" style="margin: 0">Estimasi harga per kilogram:</p>
                                        <p class="card-text" style="margin: 0">Rp.
                                            {{ number_format($barang->harga_down, 0, ',', '.') }} - Rp.
                                            {{ number_format($barang->harga_top, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <img src="{{ $imgurl }}" loading='lazy' class="lazy img-fluid rounded-start"
                                        alt="{{ $barang->nama }}" style=";padding: 0.4rem; max-height: 120px">
                                </div>
                                {{-- @if (auth()->user()->verified > 1)
                                        <a style="margin-right:-2rem" href="#"><i class="fa-regular fa-star"></i></a>
                                    @else
                                        <button disabled href="#"><i class="fa-regular fa-star"></i></button>
                                    @endif --}}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
        {{-- <table class="table table-striped table-borderless" style=" width: 100%">
        @foreach ($cat_barang->take(5) as $barang)
            @php
                $foto = $barang->foto;
                $imgurl = "https://ambilin.com/berkas/" . $foto ."";
            @endphp 
            <tr class="row">
                <td class="col-4 d-flex align-items-center justify-content-center">
                    <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style="max-height: 120px">
        
        
            </td>
            <td class="col-8">
                <h5>{{$barang->nama}}</h5>
                <p style="margin: 0">Estimasi harga per kilogram:</p>
                <p style="margin: 0">Rp. {{ number_format($barang->harga_down, 0, ',', '.') }} - Rp. {{ number_format($barang->harga_top, 0, ',', '.') }}</p>
            </td>
        </tr>
        @endforeach
    </table> --}}
        <style>
            .btn-green {
                --bs-btn-color: #fff;
                --bs-btn-bg: #176e41;
                --bs-btn-border-color: #176e41;
                --bs-btn-hover-color: #fff;
                --bs-btn-hover-bg: #157347;
                --bs-btn-hover-border-color: #146c43;
                --bs-btn-focus-shadow-rgb: 60, 153, 110, 0.5;
                --bs-btn-active-color: #fff;
                --bs-btn-active-bg: #146c43;
                --bs-btn-active-border-color: #13653f;
                --bs-btn-active-shadow: inset 0 3px 5pxrgba(0, 0, 0, 0.125);
                --bs-btn-disabled-color: #fff;
                --bs-btn-disabled-bg: #176e41;
                --bs-btn-disabled-border-color: #176e41;
            }
        </style>
        <div style="padding-bottom: 1rem" class="d-flex justify-content-center">
            <a href="harga" role="button" class="btn btn-green"
                style="width: 80%; text-transform: capitalize; backgrond-color: #176e41; color: white; font-weight: 600; padding: 0.5rem 0;">
                lihat selengkapnya</a>
        </div>
    </div>
    <!--harga material-->

    <!--logo-->
    <div class="card border border-0 rounded-5" style="margin-bottom: -5rem; height: 22rem;">
        <div class="card-body">
            <img src="{!! asset('https://ambilin.com/img/jpg/ambilinbg.jpg') !!}" loading='lazy' class="lazy img-fluid" alt="Sponsor">
        </div>
    </div>
    {{-- <div class="container" style="width: 100%; padding-bottom:15%;" >
    <img src="https://ambilin.com/img/jpg/banner_ambilin_giztin.jpg" alt="banner ambilin giztin" style="width: 100%"> 
</div> --}}
    <!--logo-->
    @include('partials.shortcut')
    <script>
        Website2APK.askEnableGPS();
    </script>
@endsection
