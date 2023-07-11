@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <!--content-->
    <div class='container' style="width:100%;padding-top:1rem">
        <div class="row">{{-- <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
            <p>Fitur poin akan diaktifkan secepatnya. 
                Fitur ini memungkinkan anda untuk mendapatkan reward poin dari aktifitas pengumpulan sampah, sedekah barkas dan lainnya. 
                Poin dapat ditukar dengan berbagai penawaran menarik, seperti pulsa/paket data, iurab BPJS dan token listrik
            </p>
        </div> --}}
            <div class="col d-flex align-items-center justify-content-center" style="padding-top:5%">
                <a href="tukar-poin/lt" style="text-align:center;text-decoration:none;color:black;">
                    <img src="{!! asset('public/img/poin.png') !!}" class="img-fluid" alt="tukar poin" style="max-height: 120px;">
                    {{-- <img src="{!! asset('https://ambilin.com/img/png/tukar poin.png') !!}" class="img-fluid" alt="tukar poin" style="max-height: 120px;"> --}}
                </br>Poin LT
                </a>
            </div>
            <div class="col d-flex align-items-center justify-content-center" style="padding-top:5%">
                <a href="tukar-poin/epr" style="text-align:center;text-decoration:none;color:black;">
                    <img src="{!! asset('https://ambilin.com/img/png/epr.png') !!}" class="img-fluid" alt="tukar poin" style="max-height: 120px;">
                    {{-- <img src="{!! asset('https://ambilin.com/img/png/tukar poin.png') !!}" class="img-fluid" alt="tukar poin" style="max-height: 120px;"> --}}
                </br>Poin EPR
                </a>
            </div>
        </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
