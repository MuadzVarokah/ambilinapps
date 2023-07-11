@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <style>
        p {
            margin: 0;
        }
    </style>
    <!--content-->
    <div class='container' style="width:100%;padding-bottom:3.5rem">
        @if(auth()->user()->kat_user != 2)
        <div style="padding-bottom:1rem;padding-top:1rem" class="d-flex justify-content-center">
            <a href="ambilin-baru" role="button" class="btn btn-success"
                style="width: 80%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">ambil
                pilihanku</a>
        </div>
        <hr>
        @else
        <br>
        @endif
        <div class="table-responsive">
            <table class="table table-sm table-borderless" style="margin: 0;">
                <tr>
                    <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem; width: 1%;">
                        <ul class="nav nav-tabs">
                            <li>
                                <a class="nav-link active position-relative" style="padding:0.5rem 0.75rem" aria-current="page" href="javascript:void(0);">tersedia
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                        {{$count_tersedia}}
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem; width: 1%;">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="{{ route('ambilin_kolektor', ['x' => $x, 'y' => $y]) }}">Proses
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$count_proses}}
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem; width: 1%;">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="{{ route('ambilin_kolektor_riwayat', ['x' => $x, 'y' => $y]) }}">riwayat
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$count_riwayat}}
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem;">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="{{ route('ambilin_kolektor_dibatalkan', ['x' => $x, 'y' => $y]) }}">Dibatalkan
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{$count_batal}}
                                        </span>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Tes -->
        <div class="row">
            @foreach ($data as $tersedia)
            <div class="col-lg-4 col-md-6 col-12" style="padding-top:0.5rem;">
                <a href="{{ route('ambilin_edit', ['id' => $tersedia->id_ambilin]) }}" style="text-decoration: none;">
                    <div class="card" style="background-color: rgb(23, 110, 65, 0.2); color: dimgray;">
                        <div class="card-body" style="padding: 0.75rem">
                            <div class="row w-100 d-flex justify-content-start">
                                <div class="col-auto" style="padding-right: 0;">
                                    <div style="width: 5rem; height: 5rem;">
                                        @php
                                            $foto = rawurlencode($tersedia->foto);
                                            $imgurl = 'public/img/ambilin/sampah/' . $foto . '';
                                        @endphp
                                        @if (!empty($foto) && file_exists('public/img/ambilin/sampah/' . $tersedia->foto))
                                            <img src="{!! asset($imgurl) !!}" alt="{{ $tersedia->foto }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <img src="https://ambilin.com/img/png/ambilin.png" alt="{{ $tersedia->foto }} kosong" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col" style="padding-right: 0;">
                                    <div class="row" style="height: 100%;">
                                        <div class="col-12">
                                            <p style="font-size: smaller; font-weight: 600; line-height: 1.2; margin: 0; color: black;"
                                                >{{ \Carbon\Carbon::parse($tersedia->tgl)->translatedFormat('l, d F Y') }}
                                                <br>
                                                {{ $tersedia->waktu }}</p>
                                        </div>
                                        <div class="col-12 d-flex align-self-end">
                                            @if ($tersedia->status_id == 1 && $user->kat_user == 1)
                                                <td class="align-middle">
                                                    <div class="badge text-bg-warning">{{ $tersedia->status }}</div>
                                                </td>
                                            @elseif ($tersedia->status_id == 2 && $user->kat_user == 1)
                                                <td class="align-middle">
                                                    <div class="badge text-bg-primary">{{ $tersedia->status }}</div>
                                                </td>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 0.5rem 0;">
                            @if (!empty($tersedia->keterangan))
                                <style>
                                    #deskripsi {
                                        -webkit-line-clamp: 2;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                        white-space: unset;
                                    };
                                </style>
                                <p class="text-truncate" style="font-size: small; line-height: 1.2; margin: 0; text-align: justify; color: gray;" id="deskripsi"
                                    >{{ $tersedia->keterangan }}</p>
                                <hr style="margin: 0.5rem 0;">
                            @endif
                            <div class="row w-100">
                                <div class="col-auto d-flex align-self-center" style="padding-right: 0;"><i class="fa-solid fa-location-dot" style="color: black;"></i></div>
                                <div class="col" style="padding-right: 0;">
                                    @if (empty($tersedia->idlokasi))
                                        <p class="text-danger" style="font-size: smaller; line-height: 1.2; margin: 0; text-align: justify; font-weight: 600;">Data alamat dihapus oleh pemilik barang</p>
                                    @else
                                        <p style="font-size: smaller; line-height: 1.2; margin: 0; text-align: justify; font-weight: 600; color: black;"
                                            >{{ $tersedia->alamat_lokasi }} {{ $tersedia->kel }}, {{ $tersedia->kec }}, {{ $tersedia->kab }}, {{ $tersedia->prov }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <!-- END Tes -->
        
        <!-- @foreach ($data as $tersedia)
            <div style="padding:0.5rem 1rem">
                <div class="alert alert-secondary d-flex justify-content-center align-items-center" role="alert"
                    style="margin:0%">
                    <div class="row" style="width:100%;height:auto">
                        <div class="col-12" style="padding:0;">
                            @php
                                $foto = rawurlencode($tersedia->foto);
                                $imgurl = 'public/img/ambilin/sampah/' . $foto . '';
                            @endphp
                            <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                                style="
                            background:  url({!! asset($imgurl) !!});
                            background-size:cover;
                                  background-position: center;
                                  padding-top:30%; 
                                  width:100%; 
                                  max-width: 150%; 
                                  min-height:100%;
                                  max-height:150%; ">
                                {{-- <img src="{!! $imgurl !!}" id="myImg" class="myImages m-auto"
                                style=" border-radius: 5%;object-fit: cover;max-height:100%; width:100%;"
                                alt={{ $tersedia->foto }}> --}}
                            </div>
                        </div>
                        <div class="col-12" style="padding:0">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td>
                                        <p>Jadwal</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><b>{{ \Carbon\Carbon::parse($tersedia->tgl)->translatedFormat('l, d F Y') }},
                                                </br> ({{ $tersedia->waktu }})</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Lokasi Pickup</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                            @if(empty($tersedia->idlokasi))
                                            <p class="text-danger"><b>Data lokasi dihapus oleh pemilik barang</b></p>
                                            @else
                                            <p><b>{{ $tersedia->alamat_lokasi }}{{ $tersedia->kel }}, {{ $tersedia->kec }},
                                                {{ $tersedia->kab }}, {{ $tersedia->prov }}</b></p>
                                            @endif
                                        
                                    </td>
                                </tr>
                                {{-- <tr>
                                <td><p>Jenis</p></td>
                                <td><p>:</p></td>
                                <td><p><b>{{$jenis->jenis}}</b></p></td>
                            </tr> --}}

                                {{-- <tr>
                                <td><p>Berat</p></td>
                                <td><p>:</p></td>
                                <td><p><b>{{$tersedia->id_ambilin}} - {{$berat_raw->where('uns_berat.id_ambilin',$tersedia->id_ambilin)->sum('berat')}}</b></p></td>
                            </tr> --}}

                                {{-- <tr>
                                <td><p>Estimasi Harga</p></td>
                                @php
                                    // $harga_down = $jenis->harga_down;
                                    // $harga_top = $jenis->harga_top;
                                    $count = $jenis_raw->count();
                                    $est_down = $sum_down * $berat/$count;
                                    $est_top = $sum_top * $berat/$count;
                                    $avg = (($est_down + $est_top))/2;
                                @endphp
                                <td><p>:</p></td>
                                <td><p><b>Rp. {{ number_format($est_down, 0, ',', '.') }} - Rp. {{ number_format($est_top, 0, ',', '.') }} |  (± Rp. {{ number_format($avg, 0, ',', '.') }})</b></p></td>
                            </tr> --}}
                                <tr>
                                    @if ($user->kat_user == 1)
                                        <td>
                                            <p>Status</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                    @endif
                                    @if ($tersedia->status_id == 1 && $user->kat_user == 1)
                                        <td class="align-middle">
                                            <div class="badge text-bg-warning">{{ $tersedia->status }}</div>
                                        </td>
                                    @elseif ($tersedia->status_id == 2 && $user->kat_user == 1)
                                        <td class="align-middle">
                                            <div class="badge text-bg-primary">{{ $tersedia->status }}</div>
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $ket = '-';
                                    if (!empty($tersedia->keterangan)) {
                                        $ket = $tersedia->keterangan;
                                    }
                                @endphp

                                <tr>
                                    <td>
                                        <p>Deskripsi</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><b>{{ Str::limit($ket, 16) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('ambilin_edit', ['id' => $tersedia->id_ambilin]) }}" role="button" class="btn btn-success"
                                style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                    class="fa-solid fa-circle-info text-light"></i>&nbsp;&nbsp;Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach -->
        <div class="container mx-auto justify-content-center d-flex mt-2 mb-2" style="width:100%">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
