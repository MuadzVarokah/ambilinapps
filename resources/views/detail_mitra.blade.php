@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
    <style>
        p {margin: 0;}
    </style>
    <!--content-->
    <div class="container" style="padding-top: 1rem;">
        <div class="card">
            @if (!empty($data->foto_diri) && file_exists('public/img/foto/' . $data->foto_diri))
                <img src="{!! asset('public/img/foto/' . $data->foto_diri) !!}" class="card-img-top" alt="{{ $data->nama }}">
            @else
                <img src="{!! asset('https://ambilin.com/img/png/ambilin.png') !!}" class="card-img-top" alt="{{ $data->nama }} kosong">
            @endif
        </div>
        <br>
        <h5 style="margin: 0; text-align: center;">{{ $data->nama }}</h5>
        <p style="text-align: center; color:darkgrey; font-size: 90%">{{ $data->username }}</p>
        <p style="text-align: center; color:darkgrey; font-size: 90%; font-weight: 600; padding-top: 0.25rem;">{{ $pangkat }}</p>
        @if ($fitur == 'ambilin')
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-auto">
                <div class="card rounded-pill border border-0" style="background-color: #dcdddd;">
                    <h5 style="margin:0; text-align: justify; color:darkgrey; padding: 0.5rem 1rem;">
                        @php
                            $num = number_format($rating_avg, 0, ',', '.');
                            if (fmod($rating_avg, 1) == 0.00) {
                                if ($num < 5) {$minus = 5 - $num;}
                            } else {
                                if ($num < 4) {$minus = 4 - $num;}
                            };
                        @endphp
                        @for ($i = 0; $i < $num; $i++)
                            <i class="fa-solid fa-star text-warning"></i>
                        @endfor
                        @if (fmod($rating_avg, 1) !== 0.00)
                            <i class="fa-solid fa-star-half-stroke text-warning"></i>
                        @endif
                        @if (!empty($minus))
                            @for ($i = 0; $i < $minus; $i++)
                                <i class="fa-regular fa-star text-warning"></i>
                            @endfor
                        @endif
                        &nbsp;{{number_format($rating_avg, 1, ',', '.')}}
                    </h5>
                </div>
            </div>
            <div class="col-12">
                <p style="text-align: center; color:darkgrey; font-size: 90%">{{ $count_rating }} Ulasan</p>
            </div>
        </div>
        @endif
    </div>
    <br>
    {{-- <div class="row" style="margin: 0">
        <div class="col border border-2" style="padding: 0.5rem">
            <div class="row d-flex align-items-end" style="margin: 0">
                <div class="col-12">
                    <h2 style="margin: 0; text-align: center;">{{ $count_pengambilan }}</h2>
                </div>
                <div class="col-12">
                    <p style="text-align: center; color:darkgrey; font-size: 90%">Pengambilan</p>
                </div>
            </div>
        </div>
        <div class="col border border-2" style="padding: 0.5rem">
            <div class="row d-flex align-items-end" style="margin: 0">
                <div class="col-12">
                    <h2 style="margin: 0; text-align: center;">{{ $angkut }} <span style="font-size: 75%">Kg</span></h2>
                </div>
                <div class="col-12">
                    <p style="text-align: center; color:darkgrey; font-size: 90%">Telah Diangkut</p>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Content End -->
@endsection