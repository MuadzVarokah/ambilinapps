@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    {{-- @if (auth()->user()->kat_user == 2 && $data->status_id == 1) --}}
    @include('partials.navbar_back')
    {{-- @else
        @include('partials.navbar_umum')
    @endif --}}
    <!-- Navbar end -->
    <style>
        p {
            margin: 0;
        }

        .circle-image img {

            border: 6px solid #fff;
            border-radius: 100%;
            padding: 0px;
            top: -28px;
            position: relative;
            width: 70px;
            height: 70px;
            border-radius: 100%;
            z-index: 1;
            background: rgb(250, 165, 0);
            cursor: pointer;

        }

        .rate {

            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px;

        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 1em;
            font-size: 30px;
            font-weight: 300;
            color: rgb(250, 165, 0);
            cursor: pointer
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1 !important
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            opacity: 0.4
        }

        .rating-submit:hover {

            color: #fff;
        }
    </style>
    <!--content-->
    <div class="container" style="width:100%; padding-bottom:3.5rem; padding-top: 0.6rem">
        <div style="padding:0.5rem;">
            {{-- <div class="alert alert-secondary d-flex justify-content-center align-items-center" style="" role="alert">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-center" style="padding-bottom:1rem">
                            <img src="{!! asset('public/img/ambilin/sampah/' . $data->foto . '') !!}" class="img-fluid" alt="{{ $data->foto }}"
                                style=" border-radius: 5%;object-fit: cover;max-width: 80%">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm" style="width: 95%">
                                <tr>
                                    <td style="width: 10%">
                                        <p>Jadwal</p>
                                    </td>
                                    <td style="width: 5%">
                                        <p>:</p>
                                    </td>
                                    <td style="width: 80%">
                                        <p><b>{{ $tgl_trans }}, ({{ $data->waktu }})</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 10%">
                                        <p>Lokasi Pickup</p>
                                    </td>
                                    <td style="width: 5%">
                                        <p>:</p>
                                    </td>
                                    <td style="width: 80%">
                                        <p><b>{{ $data->alamat_lokasi }} {{ $data->kel }}, {{ $data->kec }},
                                                {{ $data->kab }}, {{ $data->prov }}</b></p>
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
                                        <p>Deskripsi</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><b>{{ $ket }}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Status</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($data->status_id == 1)
                                        <td>
                                            <div class="badge text-bg-warning">{{ $data->status }}</div>
                                        </td>
                                    @elseif ($data->status_id == 2)
                                        <td>
                                            <div class="badge text-bg-primary">{{ $data->status }}</div>
                                        </td>
                                    @elseif ($data->status_id == 3)
                                        <td>
                                            <div class="badge text-bg-success">{{ $data->status }}</div>
                                        </td>
                                    @endif
                                </tr>
                            </table>    
                        </div>
                        <hr>
                    </div>

                    <!--total-->
                    <div class="col-12">
                        @php
                            $count = $jenis->count();
                            // $est_down = $sum_down/ $count * $berat ;
                            // $est_top = $sum_top/ $count * $berat;
                            // $avg = ($est_down + $est_top)/2;
                        @endphp
                        <div class="table-responsive">
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
                                            <b>{{ $count }}</b>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 10%">
                                        <p>Berat</p>
                                    </td>
                                    <td style="width: 5%">
                                        <p>:</p>
                                    </td>
                                    @if ($berat >= 1)
                                        <td style="width: 80%">
                                            <p><b>{{ $berat }} Kg</b></p>
                                        </td>
                                    @elseif($berat < 1)
                                        @php
                                            $beratnew = $berat * 1000;
                                        @endphp
                                        <td style="width: 80%">
                                            <p><b>{{ $beratnew }} gr</b></p>
                                        </td>
                                    @endif
    
                                </tr>
                                <!-- <tr>
                                    <td style="width: 10%"><p>Estimasi Harga</p></td>
                                    <td style="width: 5%"><p>:</p></td>
                                    <td style="width: 80%"><p>
                                    <b>
                                         
                                            Rp. {{ number_format($est_down, 0, ',', '.') }} - Rp. {{ number_format($est_top, 0, ',', '.') }} 
                                        
                                         |  (± Rp. {{ number_format($avg, 0, ',', '.') }})
                                        </b>
                                    </p></td>
                                </tr> -->
                            </table>
                        </div>
                        <hr>
                    </div>
                    <!--total end-->
                    <div class="col-12" style="padding:0">
                        <div class="table-responsive">
                        
                            <table class="table table-borderless table-sm text-center" style="width: 95%; font-size:75%">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">
                                            <p>Jenis</p>
                                        </th>
                                        <th style="width: 5%">
                                            <p>Berat</p>
                                        </th>
                                        <th style="width: 20%">
                                            <p>Harga minimum /kg</p>
                                        </th>
                                        <th style="width: 20%">
                                            <p>Harga maximum /kg</p>
                                        </th>
                                        <th style="width: 20%">
                                            <p>Harga</p>
                                        </th>
                                        <th style="width: 10%;  padding:0">
                                            <p>aksi</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenis as $jenis)
                                        <tr>
                                            @php
                                                // $harga_down = $jenis->harga_down;
                                                // $harga_top = $jenis->harga_top;
                                                $est_down = $jenis->harga_down * $jenis->berat;
                                                $est_top = $jenis->harga_top * $jenis->berat;
                                                $avg = ($est_down + $est_top) / 2;
                                            @endphp
                                            <td>
                                                <p><b>{{ $jenis->nama }}</b></p>
                                            </td>
    
                                            @if ($jenis->berat >= 1)
                                                <td>
                                                    <p><b>{{ $jenis->berat }} Kg</b></p>
                                                </td>
                                            @elseif($jenis->berat < 1)
                                                @php
                                                    $beratnew = $jenis->berat * 1000;
                                                @endphp
                                                <td>
                                                    <p><b>{{ $beratnew }} gr</b></p>
                                                </td>
                                            @endif
    
                                            <!-- <td><p><b>{{$jenis->berat}}</b></p></td> -->
                                            <td>
                                                <p><b>Rp. {{ number_format($jenis->harga_down, 0, ',', '.') }}</b></p>
                                            </td>
                                            <td>
                                                <p><b>Rp. {{ number_format($jenis->harga_top, 0, ',', '.') }}</b></p>
                                            </td>
                                            <td>
                                                <p><b>± Rp. {{ number_format($avg, 0, ',', '.') }}</b></p>
                                            </td>
                                            @if ($jenis->status < 2)
                                                <td style="padding-left:0;padding-right:0"><a
                                                        href="{{ route('ambilin_hapus_barang', ['id_ambilin' => $id, 'id_barang' => $jenis->id_berat]) }}"
                                                        onclick="return confirm('Apakah anda yakin ingin menghapus barang?');"><i
                                                            style='color:#dc3545;' class="fa-solid fa-xmark"></i></a></td>
                                            @else
                                                <td>
                                                    <div><i style='color:gray' class="fa-solid fa-xmark"></i></div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    </div>
                    <div class="col">
                        @if ($jenis->status < 2)
                            <a type="button" href="{{ route('ambilin_hapus', ['id' => $id]) }}"
                                onclick="return confirm('Apakah anda yakin ingin menghapus data?');"
                                class="btn btn-danger btn-lg btn-block"
                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"><i
                                    style="color:white" class="fa-solid fa-trash"></i> Hapus</a>
                        @else
                            <div type="button" disabled href="#" class="btn btn-secondary btn-lg btn-block"
                                style="font-size: 80%"><i style="color:white" class="fa-solid fa-trash"></i> Hapus</div>
                        @endif
                    </div>
                </div>
            </div> --}}

            <div class="card border border-0" style="background-color: #dcdddd">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12">
                            <div class="d-flex justify-content-center" style="padding-bottom:1rem">
                                @if (!empty($data->foto) && file_exists('public/img/ambilin/sampah/' . $data->foto))
                                    <img src="{!! asset('public/img/ambilin/sampah/' . $data->foto . '') !!}" class="img-fluid" alt="{{ $data->foto }}"
                                        style=" border-radius: 5%;object-fit: cover;max-width: 80%">
                                @else
                                    <img src="https://ambilin.com/img/png/ambilin.png" class="img-fluid"
                                        alt="gambar tidak ditemukan"
                                        style=" border-radius: 5%;object-fit: cover;max-width: 80%">
                                @endif
                            </div>
                        </div>
                        @if (empty($data->id_wp) && auth()->user()->kat_user == 2)
                            <div class='col-12 d-flex justify-content-center'>
                                <div class="alert alert-danger"> Akun pemilik barang ini sudah dihapus </div>
                            </div>
                        @elseif(empty($kolektor->id) && auth()->user()->kat_user != 2 && $data->status_id != 1)
                            <div class='col-12 d-flex justify-content-center'>
                                <div class="alert alert-danger">akun kolektor ini sudah dihapus</div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="table-responsive-sm">
                                <table class="table table-borderless table-sm" style="width: 95%;">
                                    <tr>
                                        <td style="width: 10%">
                                            <p>Jadwal</p>
                                        </td>
                                        <td style="width: 5%">
                                            <p>:</p>
                                        </td>
                                        <td style="width: 85%">
                                            <p><b>{{ $tgl_trans }}, ({{ $data->waktu }})</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 10%">
                                            <p>Lokasi Pickup</p>
                                        </td>
                                        <td style="width: 5%">
                                            <p>:</p>
                                        </td>
                                        <td style="width: 85%">
                                            @if (empty($data->idlokasi))
                                                <p class="text-danger"><b>data lokasi dihapus oleh pemilik barang</b></p>
                                            @else
                                                <p><b>{{ $data->alamat_lokasi }} {{ $data->kel }}, {{ $data->kec }},
                                                        {{ $data->kab }}, {{ $data->prov }}</b></p>
                                            @endif

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
                                            <p>Deskripsi</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <p><b>{{ $ket }}</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Status</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            @php
                                                if ($data->status_id == 1) {
                                                    $bg = 'text-bg-warning';
                                                } elseif ($data->status_id == 2) {
                                                    $bg = 'text-bg-primary';
                                                } elseif ($data->status_id == 3) {
                                                    $bg = 'text-bg-success';
                                                } elseif ($data->status_id == 4) {
                                                    $bg = 'text-bg-secondary';
                                                }
                                                if ($data->verifikasi == 'proses') {
                                                    $bg2 = 'text-bg-warning';
                                                    $verif_status = 'proses verifikasi';
                                                } elseif ($data->verifikasi == 'diterima') {
                                                    $bg2 = 'text-bg-success';
                                                    $verif_status = 'verifikasi diterima';
                                                } elseif ($data->verifikasi == 'ditolak') {
                                                    $bg2 = 'text-bg-danger';
                                                    $verif_status = 'verifikasi ditolak';
                                                }
                                            @endphp
                                            @if ($data->tgl <= $today && $data->status < 3 && $data->verifikasi != 'ditolak')
                                                <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                            @endif
                                            <div class="badge {{ $bg2 }}">{{ $verif_status }}</div>
                                            <div class="badge {{ $bg }}">{{ $data->status }}</div>
                                        </td>

                                        {{-- 
                                        @if ($data->status_id == 1 && $data->tgl <= $today)
                                            <td class="align-middle">
                                                <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                            </td>
                                        @elseif ($data->status_id == 1)
                                            <td>
                                                <div class="badge text-bg-warning">{{ $data->status }}</div>
                                            </td>
                                        @endif
                                        @if ($data->status_id == 2)
                                            <td>
                                                <div class="badge text-bg-primary">{{ $data->status }}</div>
                                                @if ($data->tgl <= $today)
                                                    <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                                @endif
                                            </td>
                                        @elseif ($data->status_id == 3)
                                            <td>
                                                <div class="badge text-bg-success">{{ $data->status }}</div>
                                            </td>
                                        @elseif ($data->status_id == 4)
                                            <td>
                                                <div class="badge text-bg-secondary">{{ $data->status }}</div>
                                            </td>
                                        @endif 
                                    --}}
                                    </tr>
                                    @if (empty($kolektor) && $data->status_id != 1)
                                        <td>
                                            <p>Nama Kolektor</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <p class="text-danger">N/A</p>
                                        </td>
                                    @elseif (auth()->user()->kat_user != 2 && $data->status_id >= 2 && !empty($kolektor->nama))
                                        <tr>
                                            <td>
                                                <p>Nama Kolektor</p>
                                            </td>
                                            <td>
                                                <p>:</p>
                                            </td>
                                            <td class="align-middle">{{ $kolektor->nama }}
                                                <a style="font-size:85%; padding:0.25rem;" {{-- href="kolektor/{{ $kolektor->id }}" --}}
                                                    @php
                                                        $id_a = $id;
                                                        $id_k = $kolektor->id; @endphp
                                                    href="{{ route('kolektor', [$id_a, $id_k]) }}" {{-- href ="{{ route('kolektor/$kolektor->id') }}" --}}><i
                                                        class="fa-solid fa-circle-info"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            @if (empty($kolektor->id))
                            @elseif ($data->status_id == 3 && auth()->user()->kat_user != 2)
                                <div class="rate">
                                    @php
                                        $id_k = $kolektor->id;
                                        $id_a = $id;
                                        $oldDate = \Carbon\Carbon::parse($data->tgl)->format('Y-m-d H:i:s');
                                        $weekAfter = \Carbon\Carbon::parse($kolektor->waktu_booking)
                                            ->addWeek()
                                            ->format('Y-m-d H:i:s');
                                        $today = \Carbon\Carbon::today()->format('Y-m-d H:i:s');
                                    @endphp

                                    <form action="{{ route('post_rating', [$id_k, $id_a]) }}" method="POST">
                                        @csrf
                                        <div class="rating">
                                            {{-- {{dd($ada)}} --}}
                                            <input type="radio" name="rating" value="5" id="rate5"
                                                @if (!empty($ada) && $ada->rating == 5) checked @endif>
                                            <label for="rate5">☆</label>
                                            <input type="radio"name="rating" value="4" id="rate4"
                                                @if (!empty($ada) && $ada->rating == 4) checked @endif>
                                            <label for="rate4">☆</label>
                                            <input type="radio" name="rating" value="3" id="rate3"
                                                @if (!empty($ada) && $ada->rating == 3) checked @endif>
                                            <label for="rate3">☆</label>
                                            <input type="radio" name="rating" value="2" id="rate2"
                                                @if (!empty($ada) && $ada->rating == 2) checked @endif>
                                            <label for="rate2">☆</label>
                                            <input type="radio" name="rating" value="1" id="rate1"
                                                @if (!empty($ada) && $ada->rating == 1) checked @endif>
                                            <label for="rate1">☆</label>
                                        </div>
                                        <div id='reason_form' class="visually-hidden" style='padding:0 1.5rem'>
                                            <div class="card">
                                                <textarea type="text" name="reason" id="reason" class="form-control" rows="2"></textarea>
                                                <label for="reason" class="form-label" style="font-size:small">
                                                    <span class="text-danger" id="requiredd">*</span>Yuk bantu kolektor ini
                                                    menjadi lebih baik
                                                </label>
                                            </div>
                                        </div>

                                        {{-- {{dd($oldDate, $weekAfter, $today, $ada)}} --}}
                                        @if (empty($ada))
                                            <div class="buttons px-4 mt-0">
                                                <button class="btn btn-success btn-block rating-submit"
                                                    type="submit">Submit</button>
                                            </div>
                                        @elseif(!empty($ada) && $weekAfter < $today)
                                            <div class="buttons px-4 mt-0">
                                                <button class="btn btn-success btn-block rating-submit" disabled
                                                    type="submit">Update</button>
                                            </div>
                                        @elseif($weekAfter < $today)
                                            <div class="buttons px-4 mt-0">
                                                <button class="btn btn-success btn-block rating-submit" disabled
                                                    type="submit">Submit</button>
                                            </div>
                                        @else
                                            <div class="buttons px-4 mt-0">
                                                <button class="btn btn-success btn-block rating-submit"
                                                    type="submit">Update</button>
                                            </div>
                                        @endif
                                    </form>
                                    <script>
                                        const toggle1 = document.querySelector('#rate1');
                                        const toggle2 = document.querySelector('#rate2');
                                        const toggle3 = document.querySelector('#rate3');
                                        const toggle4 = document.querySelector('#rate4');
                                        const toggle5 = document.querySelector('#rate5');
                                        const reason_form = document.querySelector('#reason_form');
                                        const reason = document.querySelector('#reason');
                                        const star = document.querySelector('#requiredd');


                                        toggle1.addEventListener('click', function(e) {
                                            // toggle the type attribute
                                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'form-outline flex-fill mb-2' :
                                                'form-outline flex-fill mb-2';
                                            const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                                            reason_form.setAttribute('class', type);
                                            star.setAttribute('class', startype);
                                            reason.setAttribute('required', '');
                                        });

                                        toggle2.addEventListener('click', function(e) {
                                            // toggle the type attribute
                                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'form-outline flex-fill mb-2' :
                                                'form-outline flex-fill mb-2';
                                            const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                                            reason_form.setAttribute('class', type);
                                            star.setAttribute('class', startype);
                                            reason.setAttribute('required', '');
                                        });

                                        toggle3.addEventListener('click', function(e) {
                                            // toggle the type attribute
                                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'form-outline flex-fill mb-2' :
                                                'form-outline flex-fill mb-2';
                                            const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                                            reason_form.setAttribute('class', type);
                                            star.setAttribute('class', startype);
                                            reason.setAttribute('required', '');
                                        });

                                        toggle4.addEventListener('click', function(e) {
                                            // toggle the type attribute
                                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'form-outline flex-fill mb-2' :
                                                'form-outline flex-fill mb-2';
                                            const startype = star.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' :
                                                'visually-hidden';
                                            reason_form.setAttribute('class', type);
                                            star.setAttribute('class', startype);
                                            reason.removeAttribute('required');
                                        });

                                        toggle5.addEventListener('click', function(e) {
                                            // toggle the type attribute
                                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'form-outline flex-fill mb-2' :
                                                'form-outline flex-fill mb-2';
                                            const startype = star.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' :
                                                'visually-hidden';
                                            reason_form.setAttribute('class', type);
                                            star.setAttribute('class', startype);
                                            reason.removeAttribute('required');
                                        });
                                    </script>
                                </div>
                            @elseif($data->status_id == 2 && auth()->user()->kat_user == 2 && !empty($data->lokasi_x) && !empty($data->lokasi_y))
                                <center>
                                    {{-- <form action="{{ route('direction_ambilin', ['id' => $data->id_ambilin]) }}"
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
                                                            <i class="fa-solid fa-map-location-dot"></i> Cek
                                                            lokasi</button>
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
                                                document.getElementById("formLokasi").submit();
                                            });
                                        </script>
                                    </form> --}}
                                    <!-- Form input -->
                                    {{-- <form action="{{ route('map_ambilin') }}" method="post">
                                        @csrf
                                        <div>
                                            <!-- <div class="buttons px-4 mt-0"> -->
                                            <input class="form-control" type="hidden" name="id_ambilin" value='{{ $data->id_ambilin }}' required>
                                            <div class="row" style="width: 100%;">
                                                <center>
                                                    <div class="col-6">
                                                        <button class="btn btn-success" type="submit"
                                                            style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                            <i class="fa-solid fa-map-location-dot"></i> Cek
                                                            lokasi</button>
                                                    </div>
                                                </center>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                    </form> --}}
                                    <!-- Form input -->
                                    <div>
                                        <div class="row" style="width: 100%;">
                                            <center>
                                                <div class="col-6">
                                                    <a class="btn btn-success" type="button"
                                                        href="{{ route('map_ambilin', ['id' => $data->id_ambilin]) }}"
                                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                        <i class="fa-solid fa-map-location-dot"></i> Cek lokasi
                                                    </a>
                                                </div>
                                            </center>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </center>
                            @elseif($data->status_id == 2 && auth()->user()->kat_user == 2 && (empty($data->lokasi_x) || empty($data->lokasi_y)))
                                <center>
                                    <div>
                                        <div class="row" style="width: 100%;">
                                            <center>
                                                <div class="col-6">
                                                    <button class="btn btn-success" disabled
                                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                        <i class="fa-solid fa-map-location-dot"></i> Cek lokasi</button>
                                                </div>
                                                <div class="col-12" style="padding:0">
                                                    <p style="font-size:75%; font-weight:600" class="text-danger">
                                                        Pengunggah tidak menginput koordinat</p>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </center>
                            @endif
                            <hr>

                            <!--total-->
                            <div class="col-12">
                                @php
                                    $count = $jenis->count();
                                    // $est_down = $sum_down/ $count * $berat ;
                                    // $est_top = $sum_top/ $count * $berat;
                                    // $avg = ($est_down + $est_top)/2;
                                @endphp
                                <table class="table table-borderless table-sm" style="width: 95%">
                                    <tr>
                                        <td style="width: 10%">
                                            <p>Jenis</p>
                                        </td>
                                        <td style="width: 5%">
                                            <p>:</p>
                                        </td>
                                        <td style="width: 85%">
                                            <p>
                                                <b>{{ $count }}</b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        @if (!empty($berat_riil))
                                            <td style="width: 10%">
                                                <p>Berat riil</p>
                                            </td>
                                            <td style="width: 5%">
                                                <p>:</p>
                                            </td>
                                            @if ($berat_riil >= 1000)
                                                @php
                                                    $beratnew = $berat_riil / 1000;
                                                @endphp
                                                <td style="width: 85%">
                                                    <p><b>{{ $beratnew }} ton</b></p>
                                                </td>
                                                {{-- @elseif($jns->berat < 1)
                                            @php
                                                $beratnew = $jns->berat * 1000;
                                            @endphp
                                            <td>
                                                <p><b>{{ $beratnew }} gr</b></p>
                                            </td> --}}
                                            @else
                                                <td style="width: 75%">
                                                    <p><b>{{ $berat }} Kg</b></p>
                                                </td>
                                            @endif
                                        @else
                                            <td style="width: 10%">
                                                <p>Berat</p>
                                            </td>
                                            <td style="width: 5%">
                                                <p>:</p>
                                            </td>
                                            @if ($berat >= 1000)
                                                @php
                                                    $beratnew = $berat / 1000;
                                                @endphp
                                                <td style="width: 75%">
                                                    <p><b>{{ $beratnew }} ton</b></p>
                                                </td>
                                                {{-- @elseif($jns->berat < 1)
                                            @php
                                                $beratnew = $jns->berat * 1000;
                                            @endphp
                                            <td>
                                                <p><b>{{ $beratnew }} gr</b></p>
                                            </td> --}}
                                            @else
                                                <td style="width: 75%">
                                                    <p><b>{{ $berat }} Kg</b></p>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                    {{-- {{dd($sum_epr)}} --}}
                                    @if (!empty($sum_epr))
                                        @if ($data->status_id == 3)
                                            <tr>
                                                <td style="width: 20%">
                                                    <p>EPR</p>
                                                </td>
                                                <td style="width: 5%">
                                                    <p>:</p>
                                                </td>
                                                <td style="width: 75%">
                                                    <p>
                                                        <b>{{ $sum_epr }}</b>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
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
                            <center>
                                <div class="col-12" style="padding:0">
                                    <table class="table table-borderless table-striped table-sm text-center"
                                        style="width: 95%; font-size:75%">
                                        <thead>
                                            <tr>
                                                @if ($tgl_ambilin->user_id == auth()->user()->id)
                                                    <th style="width:25%">
                                                        <p>Jenis</p>
                                                    </th>
                                                @else
                                                    <th style="width:35%">
                                                        <p>Jenis</p>
                                                    </th>
                                                @endif

                                                @if (!empty($berat_riil))
                                                    <th style="width: 5%">
                                                        <p>Berat riil</p>
                                                    </th>
                                                @else
                                                    <th style="width: 5%">
                                                        <p>Berat</p>
                                                    </th>
                                                @endif

                                                @if (empty($total_riil))
                                                    <th style="width: 20%">
                                                        <p>Harga min /kg</p>
                                                    </th>
                                                    <th style="width: 20%">
                                                        <p>Harga max /kg</p>
                                                    </th>
                                                    <th style="width: 20%">
                                                        <p>Harga</p>
                                                    </th>
                                                @else
                                                    <th style="width: 30%">
                                                        <p>Harga riil/kg</p>
                                                    </th>
                                                    <th style="width: 30%">
                                                        <p>Harga</p>
                                                    </th>
                                                @endif

                                                @if ($tgl_ambilin->user_id == auth()->user()->id)
                                                    <th style="width: 10%;  padding:0">
                                                        <p>aksi</p>
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($jenis)}} --}}
                                            @foreach ($jenis as $jns)
                                                <tr>
                                                    @php
                                                        // $harga_down = $jenis->harga_down;
                                                        // $harga_top = $jenis->harga_top;
                                                        if (!empty($jns->berat_riil)) {
                                                            $est_down = $jns->harga_down * $jns->berat_riil;
                                                            $est_top = $jns->harga_top * $jns->berat_riil;
                                                        } else {
                                                            $est_down = $jns->harga_down * $jns->berat;
                                                            $est_top = $jns->harga_top * $jns->berat;
                                                        }
                                                        if (empty($jns->harga_riil)) {
                                                            $avg = ($est_down + $est_top) / 2;
                                                        } else {
                                                            $avg = $jns->harga_riil;
                                                        }
                                                    @endphp
                                                    <td>
                                                        <p><b>{{ $jns->nama }}</b></p>
                                                    </td>
                                                    @if (!empty($jns->berat_riil))
                                                        @if ($jns->berat >= 1000)
                                                            @php
                                                                $beratnew = $jns->berat_riil / 1000;
                                                            @endphp
                                                            <td>
                                                                <p><b>{{ $beratnew }} ton</b></p>
                                                            </td>
                                                            {{-- @elseif($jns->berat < 1)
                                                        @php
                                                            $beratnew = $jns->berat * 1000;
                                                        @endphp
                                                        <td>
                                                            <p><b>{{ $beratnew }} gr</b></p>
                                                        </td> --}}
                                                        @else
                                                            <td>
                                                                <p><b>{{ $jns->berat_riil }} Kg</b></p>
                                                            </td>
                                                        @endif
                                                    @else
                                                        @if ($jns->berat >= 1000)
                                                            @php
                                                                $beratnew = $jns->berat / 1000;
                                                            @endphp
                                                            <td>
                                                                <p><b>{{ $beratnew }} ton</b></p>
                                                            </td>
                                                            {{-- @elseif($jns->berat < 1)
                                                        @php
                                                            $beratnew = $jns->berat * 1000;
                                                        @endphp
                                                        <td>
                                                            <p><b>{{ $beratnew }} gr</b></p>
                                                        </td> --}}
                                                        @else
                                                            <td>
                                                                <p><b>{{ $jns->berat }} kg</b></p>
                                                            </td>
                                                        @endif
                                                    @endif
                                                    @if (empty($jns->harga_riil))
                                                        <td>
                                                            <p><b>Rp.
                                                                    {{ number_format($jns->harga_down, 0, ',', '.') }}</b>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p><b>Rp.
                                                                    {{ number_format($jns->harga_top, 0, ',', '.') }}</b>
                                                            </p>
                                                        </td>
                                                    @endif
                                                    {{-- <td><p><b>{{$jenis->berat}}</b></p></td> --}}
                                                    <td>
                                                        <p>
                                                            <b>
                                                                @if (empty($jns->harga_riil))
                                                                    ±
                                                                @endif Rp.
                                                                {{ number_format($avg, 0, ',', '.') }}
                                                            </b>
                                                        </p>
                                                    </td>
                                                    {{-- harga-riil --}}
                                                    @if (!empty($jns->harga_riil) && !empty($jns->berat_riil))
                                                        <td>
                                                            <p><b>Rp.{{ number_format($avg * $jns->berat_riil, 0, ',', '.') }}
                                                                </b></p>
                                                        </td>
                                                    @elseif(!empty($jns->harga_riil) && empty($jns->berat_riil))
                                                        <td>
                                                            <p><b>Rp.{{ number_format($avg * $jns->berat, 0, ',', '.') }}
                                                                </b></p>
                                                        </td>
                                                        {{-- @elseif(empty($jns->harga_riil)&& empty($jns->berat_riil))
                                                        <td><p><b>a</b></p></td> --}}
                                                    @endif
                                                    {{-- harga-riil end --}}
                                                    {{-- aksi --}}
                                                    @if ($jns->status < 2 && $tgl_ambilin->user_id == auth()->user()->id)
                                                        <td style="padding-left:0;padding-right:0"><a
                                                                href="{{ route('ambilin_hapus_barang', ['id_ambilin' => $id, 'id_barang' => $jns->id_berat]) }}"
                                                                onclick="return confirm('Apakah anda yakin ingin menghapus barang?');"><i
                                                                    style='color:#dc3545;'
                                                                    class="fa-solid fa-xmark"></i></a>
                                                        </td>
                                                    @elseif($tgl_ambilin->user_id == auth()->user()->id)
                                                        <td>
                                                            <div><i style='color:gray' class="fa-solid fa-xmark"></i>
                                                            </div>
                                                        </td>
                                                    @endif
                                                    {{-- aksiend --}}
                                                </tr>
                                            @endforeach
                                            {{-- {{dd($sum_harga)}} --}}
                                            @if (!empty($sum_harga))
                                                <tr style="background-color: lightgray">
                                                    @if (!empty($jns->harga_riil))
                                                        <td colspan='3'>
                                                            <p><b>Total</b></p>
                                                        </td>
                                                    @else
                                                        <td colspan='4'>
                                                            <p><b>Total</b></p>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <p>
                                                            <b>
                                                                @if (empty($jns->harga_riil))
                                                                    ±
                                                                @endif Rp.
                                                                {{ number_format($sum_harga, 0, ',', '.') }}
                                                            </b>
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                            </center>
                        </div>

                        <hr>

                        @if (!empty($sum_epr))
                            @if ($data->status_id == 3)
                                <div class="col-12" style="padding:0">
                                    <center class="table-responsive">
                                        <table class="table table-borderless table-striped table-sm text-center"
                                            style="width: 100%; overflow-x:scroll; font-size:75%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20%">
                                                        <p>Merek</p>
                                                    </th>
                                                    <th style="width: 15%">
                                                        <p>Jenis</p>
                                                    </th>
                                                    <th style="width: 5%">
                                                        <p>Berat</p>
                                                    </th>
                                                    <th style="width: 20%">
                                                        <p>Berat/poin</p>
                                                    </th>
                                                    <th style="width: 20%">
                                                        <p>total</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($detail_epr as $items)
                                                    <tr>
                                                        <td>
                                                            <p><b>{{ $items->merek }}</b></p>
                                                        </td>
                                                        <td>
                                                            <p><b>{{ $items->sampah }}</b></p>
                                                        </td>
                                                        @if ($items->berat >= 1000)
                                                            @php
                                                                $beratnew = $items->berat / 1000;
                                                            @endphp
                                                            <td>
                                                                <p><b>{{ $beratnew }} ton</b></p>
                                                            </td>
                                                            {{-- @elseif($items->berat < 1)
                                                        @php
                                                            $beratnew = $items->berat * 1000;
                                                        @endphp
                                                        <td>
                                                            <p><b>{{ $beratnew }} gr</b></p>
                                                        </td> --}}
                                                        @else
                                                            <td>
                                                                <p><b>{{ $items->berat }} kg</b></p>
                                                            </td>
                                                        @endif

                                                        {{-- <td><p><b>{{$jenis->berat}}</b></p></td> --}}
                                                        <td>
                                                            <p><b>{{ $items->harga }}</b></p>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                <b>{{ $items->berat / $items->harga }} poin</b>

                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </center>
                                    <hr>
                                </div>
                            @endif
                        @endif
                        <div class="row d-flex justify-content-center">
                            @if ($data->status_id != 4)
                                @if (auth()->user()->kat_user == 2)
                                    @if ($data->status_id == 1)
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <a type="button"
                                                href="{{ route('ambilin_ambil', ['id' => $data->id_ambilin]) }}"
                                                class="btn btn-primary btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"
                                                onclick="return confirm('Apakah anda yakin ingin mengambil sampah ini?');">
                                                <i class="fa-solid fa-hands-holding"></i> Ambil Sampah
                                            </a>
                                        </div>
                                    @elseif ($data->status_id == 2)
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <a type="button"
                                                href="{{ route('ambilin_kolektor_batal', ['id' => $data->id_ambilin]) }}"
                                                class="btn btn-danger btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"
                                                onclick="return confirm('Apakah anda yakin ingin membatalkan pengambilan sampah ini?');">
                                                <i class="fa-solid fa-xmark"></i> Batalkan
                                            </a>
                                        </div>
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            @if (empty($data->id_wp))
                                                <button disabled type="button"
                                                    href="{{ route('ambilin_verifikasi', ['id_ambilin' => $data->id_ambilin, 'id_booking' => $kolektor->booking_id]) }}"class="btn btn-primary btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-check"></i> Verifikasi
                                                </button>
                                            @else
                                                <a type="button"
                                                    href="{{ route('ambilin_verifikasi', ['id_ambilin' => $data->id_ambilin, 'id_booking' => $kolektor->booking_id]) }}"class="btn btn-primary btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-check"></i> Verifikasi
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($data->status_id < 3)
                                        @if (empty($data->id_wp))
                                            <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                                <button disabled type="button" href="javascript:void(0)"
                                                    class="btn btn-success btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-comment-dots"></i> Hubungi
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                                <a type="button" href="{{ route('chat', ['id' => $data->id_wp]) }}"
                                                    class="btn btn-success btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-comment-dots"></i> Hubungi
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @elseif(auth()->user()->kat_user != 2)
                                    @if ($data->status_id == 1)
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <button class="btn btn-danger btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"
                                                data-bs-toggle="modal" data-bs-target="#delAmbilinModal">
                                                <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Hapus</button>
                                        </div>
                                        @include('partials.modal_hapus_ambilin')
                                        {{-- <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <a type="button" href="/ambilinapps/ambilin-baru/{{$id}}"
                                                class="btn btn-warning btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"><i
                                                    class="fa-solid fa-pencil"></i> Edit Data
                                            </a>
                                        </div> --}}
                                    @endif
                                    @if ($data->status_id == 1 && $data->tgl <= $today)
                                        {{-- <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <a type="button" href="#" class="btn btn-warning btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"><i
                                                    class="fa-solid fa-repeat"></i> Request ulang
                                            </a>
                                        </div> --}}
                                    @endif
                                    @if ($data->status_id > 1 && $data->status_id < 4)
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            @if (empty($kolektor->id))
                                                <button disabled type="button" href="javascript:void(0)"
                                                    class="btn btn-success btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-comment-dots"></i> Hubungi
                                                </button>
                                            @else
                                                <a type="button" href="{{ route('chat', ['id' => $kolektor->id]) }}"
                                                    class="btn btn-success btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                    <i class="fa-solid fa-comment-dots"></i> Hubungi
                                                </a>
                                            @endif
                                        </div>
                                        @if ($data->status_id == 2)
                                            <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                                <a type="button"
                                                    href="{{ route('ambilin_mitra_batal', ['id' => $data->id_ambilin]) }}"
                                                    onclick="return confirm('Apakah anda yakin ingin membatalkan pengambilan?');"
                                                    class="btn btn-danger btn-lg btn-block"
                                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;"><i
                                                        class="fa-solid fa-xmark"></i> Batalkan
                                                </a>
                                            </div>
                                        @endif
                                    @elseif ($data->status_id == 4)
                                        <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                            <a type="button" href="{{ route('chat', ['id' => $kolektor->id]) }}"
                                                class="btn btn-success btn-lg btn-block"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                <i class="fa-solid fa-comment-dots"></i> Hubungi
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if (auth()->user()->kat_user == 2)
                                    <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                        @if (empty($data->id_wp))
                                            <button disabled type="button" class="btn btn-success btn-lg btn-block"
                                                href="javascript:void(0)"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                <i class="fa-solid fa-comment-dots"></i> Hubungi
                                            </button>
                                        @else
                                            <a type="button" class="btn btn-success btn-lg btn-block"
                                                href="{{ route('chat', ['id' => $data->id_wp]) }}"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                <i class="fa-solid fa-comment-dots"></i> Hubungi
                                            </a>
                                        @endif
                                    </div>
                                @elseif (auth()->user()->kat_user != 2)
                                    <div class="col-6" style="padding: 0.2rem 0.2rem;">
                                        @if (empty($kolektor->id))
                                            <button disabled type="button" class="btn btn-success btn-lg btn-block"
                                                href="javascript:void(0)"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                <i class="fa-solid fa-comment-dots"></i>
                                                Hubungi
                                            </button>
                                        @else
                                            <a type="button" class="btn btn-success btn-lg btn-block"
                                                href="{{ route('chat', ['id' => $kolektor->id]) }}"
                                                style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.25rem 1rem;">
                                                <i class="fa-solid fa-comment-dots"></i>
                                                Hubungi
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content End -->
    @endsection
    {{-- @include('partials.shortcut') --}}
