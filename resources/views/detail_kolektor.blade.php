@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
    <style>
        p {
            margin: 0;
        }
    </style>
    <!--content-->
    {{-- <div class="container" style="width:100%; padding-bottom:3.5rem; padding-top: 0.6rem">
        <div style="padding:0.5rem;">
            <div class="card border border-0" style="background-color: #dcdddd">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-center" style="padding-bottom:1rem">

                                @if ($data->foto_diri != null && file_exists('public/img/foto/' . $data->foto_diri))
                                    <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                                        background-image: url({!! asset('public/img/foto/' . $data->foto_diri) !!});
                                        background-size: cover; background-position: center;"
                                        class="img-thumbnail" alt="{{ $data->nama }}">
                                    </div>
                                @else
                                    <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                                        background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                                        background-size: cover; background-position: center;"
                                        class="img-thumbnail" alt="{{ $data->nama }}kosong">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive-sm">
                                <table class="table table-borderless table-sm" style="width: 95%;">
                                    <tr>
                                        <td style="width: 10%">
                                            <p>Nama</p>
                                        </td>
                                        <td style="width: 5%">
                                            <p>:</p>
                                        </td>
                                        <td style="width: 80%">
                                            <p><b>{{ $data->nama_lengkap }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10%">
                                            <p>Email</p>
                                        </td>
                                        <td style="width: 5%">
                                            <p>:</p>
                                        </td>
                                        <td style="width: 80%">
                                            <p><b>{{ $data->email }}</b></p>
                                        </td>
                                    </tr>
                                    @php
                                        $ket = '-';
                                        if (!empty($data->keterangan)) {
                                            $ket = $data->keterangan;
                                        }
                                    @endphp


                                    <tr>
                                        <td>
                                            <p>Alamat</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <p><b>{{ $data->alamat_lokasi }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>No. WhatsApp</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <p><b>{{ $data->no_wa }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Rating</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <div>
                                                <p>
                                                    @php
                                                        if (fmod($rating_avg, 1) == 0.00) {
                                                            $num = number_format($rating_avg, 0, ',', '.');
                                                        } else {
                                                            $num = number_format($rating_avg, 0, ',', '.') - 1;
                                                        }
                                                    @endphp
                                                    @for ($i = 0; $i < $num; $i++)
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    @endfor
                                                    @if (fmod($rating_avg, 1) !== 0.00)
                                                        <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                    @endif
                                                    {{number_format($rating_avg, 1, ',', '.')}}/5
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
    </div>
    <br>
    <div class="row" style="margin: 0">
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
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
