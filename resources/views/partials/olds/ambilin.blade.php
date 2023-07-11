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
        @if (auth()->user()->kat_user != 2)
            <div style="padding-bottom:1rem;padding-top:1rem" class="d-flex justify-content-center">
                <a href="ambilin-baru" role="button" class="btn btn-success"
                    style="width: 80%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                    ambil pilihanku</a>
            </div>
            <hr>
        @else
            <br>
        @endif
        <ul class="nav nav-tabs">
            @if (auth()->user()->kat_user == 2)
                <li>
                    <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="ambilin-tersedia">tersedia
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{$count_tersedia}}
                            </span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link active position-relative" style="padding:0.5rem 0.75rem" aria-current="page" href="ambilin">
                    Proses           
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$count_proses}}
                        </span>      
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="ambilin-riwayat">riwayat
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$count_riwayat}}
                        </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link position-relative" style="padding:0.5rem 0.75rem" href="ambilin-batal">Dibatalkan
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$count_batal}}
                        </span>
                </a>
            </li>
        </ul>
        @foreach ($data as $ambil)
            <div style="padding:0.5rem 1rem">
                <div class="alert alert-secondary d-flex justify-content-center align-items-center" role="alert"
                    style="margin:0%">
                    <div class="row" style="width:100%;height:auto">
                        <div class="col-12" style="padding:0;">
                            @php
                                $foto = rawurlencode($ambil->foto);
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
                                alt={{ $ambil->foto }}> --}}
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
                                        <p><b>{{ \Carbon\Carbon::parse($ambil->tgl)->translatedFormat('l, d F Y') }}, </br>
                                                ({{ $ambil->waktu }})</b></p>
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
                                        <p>
                                            @if(empty($ambil->idlokasi))
                                                <p class="text-danger"><b>Data alamat dihapus oleh pemilik barang</b></p> 
                                            @else
                                                <b>{{ $ambil->alamat_lokasi }}{{ $ambil->kel }}, {{ $ambil->kec }},
                                                    {{ $ambil->kab }}, {{ $ambil->prov }}</b>
                                            @endif
                                        </p>
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
                                <td><p><b>{{$ambil->id_ambilin}} - {{$berat_raw->where('uns_berat.id_ambilin',$ambil->id_ambilin)->sum('berat')}}</b></p></td>
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
                                @if ($user->kat_user == 1)
                                    <tr>
                                        <td>
                                            <p>Status</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        @if ($ambil->status_id == 1)
                                            @if ($ambil->tgl < $today)
                                                <td class="align-middle">
                                                    <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                                </td>
                                            @else
                                                <td class="align-middle">
                                                    <div class="badge text-bg-warning">{{ $ambil->status }}</div>
                                                </td>
                                            @endif
                                        @elseif ($ambil->status_id == 2)
                                            <td class="align-middle">
                                                <div class="badge text-bg-primary">{{ $ambil->status }}</div>
                                            </td>
                                        @endif
                                    </tr>
                                @endif

                                @php
                                    $ket = '-';
                                    if (!empty($ambil->keterangan)) {
                                        $ket = $ambil->keterangan;
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
                                        <p><b>{{ Str::limit($ket, 18) }}</b></p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            @if ($user->kat_user == 2)
                                <a href="ambilin-edit/{{ $ambil->id_ambilin }}" role="button" class="btn btn-success"
                                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                        class="fa-solid fa-circle-info text-light"></i>&nbsp;&nbsp;Detail</a>
                            @elseif($user->kat_user == 1)
                                @if ($ambil->status_id == 1)
                                    <a href="ambilin-edit/{{ $ambil->id_ambilin }}" role="button" class="btn btn-warning"
                                        style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                            class="fa-solid fa-pencil text-danger"></i>&nbsp;&nbsp;Detail/Ubah Data</a>
                                @elseif($ambil->status_id == 2)
                                    <a href="ambilin-edit/{{ $ambil->id_ambilin }}" role="button" class="btn btn-warning"
                                        style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                            class="fa-solid fa-circle-info text-primary"></i>&nbsp;&nbsp;Detail</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="container mx-auto justify-content-center d-flex mb-7" style="width:100%">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <!-- Content End -->
@endsection
@include('partials.shortcut')
