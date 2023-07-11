@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    {{-- @if (auth()->user()->kat_user == 2)
        @include('partials.navbar_back')
    @else --}}
        @include('partials.navbar_umum')
    {{-- @endif --}}
    <!-- Navbar end -->
    <style>
        p {margin: 0;}
    </style>
    <!--content-->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="toastify on  toastify-center toastify-top alert" role="alert"
            style="background: rgb(220, 53, 69); transform: translate(0px, 0px); top: 15px;">
            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col" style="height: fit-content; padding: 0;">
                    <ul class="list-unstyled" style="margin: 0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                </div>
                <div class="col-auto" style="height: fit-content; padding: 0;">
                    <span class="toast-close" data-bs-dismiss="alert" aria-label="Close">✖</span>
                </div>
            </div>
        </div>
    @endif
    
    <div class="row w-100 d-flex justify-content-center" style="margin: 0">
        <div class="col-lg-4 col-md-5 col-12" style="padding: 0">
            <div class="card border border-0 rounded-0 d-flex justify-content-center align-items-center"
                style="background-color: black;">
                @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1))
                <div class="position-absolute bottom-0 start-0">
                    <button class="btn btn-warning btn-lg rounded-circle" style="opacity: 0.5; margin: 0 0 1rem 1rem;"
                        data-bs-toggle="modal" data-bs-target="#gambarModal">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="gambarModal" tabindex="-1" aria-labelledby="gambarModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('ambilin_post_gambar') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="gambarModalLabel">Ubah Gambar</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- id ambilin -->
                                    <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                    <!-- Gambar -->
                                    <div class="position-relative">
                                        <div class="form-group">
                                            <style>
                                                .input-group>.btn {padding-top: 0.7rem;}
                                            </style>
                                            <div class="file-loading">
                                                <input id="foto-ambilin" type="file" name="foto" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true">
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $("#foto-ambilin").fileinput({
                                                theme: 'explorer-fa5',
                                                previewFileType: "image",
                                                browseClass: "btn btn-success btn-md",
                                                browseLabel: "Cari",
                                                removeClass: "btn btn-danger btn-md",
                                                removeLabel: "",
                                                showUpload: false,
                                                allowedFileTypes: ['image'],
                                                allowedFileExtensions: ['png', 'jpg', 'jpeg'],
                                                overwriteInitial: false,
                                                maxFileSize: 4096,
                                                uploadExtraData: function() {
                                                    return {
                                                        _token: $("input[name='_token']").val(),
                                                    };
                                                },
                                                slugCallback: function (filename) {
                                                    return filename.replace('(', '_').replace(']', '_');
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @if (!empty($data->foto) && file_exists('public/img/ambilin/sampah/' . $data->foto))
                    <img src="{!! asset('public/img/ambilin/sampah/' . $data->foto . '') !!}" class="img-fluid" alt="{{ $data->foto }}"
                        style="max-width: 100%; max-height: 100%; aspect-ratio: 1 / 1; object-fit: contain; background-color: black;">
                @else
                    <img src="https://ambilin.com/img/png/ambilin.png" class="img-fluid"
                        alt="Gambar tidak ditemukan"
                        style="width: 100%;">
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-5 col-12" style="padding: 0">
            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                @if ($data->status_id != 3)
                    <div class="col-auto d-flex align-items-center" style="padding-top: 0.5rem;"><h6 style="margin: 0">Estimasi Jenis</h6></div>
                @else
                    <div class="col-auto d-flex align-items-center" style="padding-top: 0.5rem;"><h6 style="margin: 0">Jenis Riil</h6></div>
                @endif
                <div class="col-auto d-flex align-items-center" style="padding-top: 0.5rem;"><p style="margin: 0; color: darkgrey;">{{ $jenis }} Macam</p></div>
                <div class="col-12"><hr style="margin: 0.25rem 0;"></div>
                @if ($data->status_id != 3)
                    <div class="col-auto d-flex align-items-center" style="padding-bottom: 0.5rem;"><h6 style="margin: 0">Estimasi Berat</h6></div>
                @else
                    <div class="col-auto d-flex align-items-center" style="padding-bottom: 0.5rem;"><h6 style="margin: 0">Berat Riil</h6></div>
                @endif
                <div class="col-auto d-flex align-items-center" style="padding-bottom: 0.5rem;"><p style="margin: 0; color: darkgrey;">{{ $berat }} Kg</p></div>
            </div>

            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;"><h6 style="margin: 0">Status</h6></div>
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
                <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                    <span class="badge {{ $bg2 }}">{{ $verif_status }}</span>
                    <span class="badge {{ $bg }}">{{ $data->status }}</span>
                </div>
            </div>

            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Waktu</h6></div>
                        @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#waktuModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="waktuModal" tabindex="-1" aria-labelledby="waktuModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('ambilin_post_waktu') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="waktuModalLabel">Ubah Waktu</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- id ambilin -->
                                                <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                                <!-- Tanggal ambil -->
                                                <label class="form-label" for="tanggal_ambil">Tanggal pengambilan <font color='#ff0000'>*</font></label>
                                                <select class="form-select" aria-label="tanggal_ambil" name="tgl_ambil">
                                                    @foreach($tanggal as $tgl)
                                                    <option value="{{$tgl->id}}" @if($tgl->tgl == $data->tgl) selected @endif >{{ \Carbon\Carbon::parse($tgl->tgl)->translatedFormat('l, d F Y') }}</option>
                                                    @endforeach
                                                </select>

                                                <!-- Waktu -->
                                                <label class="form-label" for="waktu_ambil" style="padding-top: 10px">Waktu Pengambilan <font color='#ff0000'>*</font></label>
                                                <select class="form-select" aria-label="waktu_ambil" name="waktu_ambil">
                                                    @foreach($waktu as $wkt)
                                                    <option value="{{$wkt->id}}" @if($wkt->waktu == $data->waktu) selected @endif >{{$wkt->waktu}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                              </div>
                        @endif
                    </div>
                </div>
                <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                    <p style="line-height: 1.2; margin: 0; color: darkgrey;"
                        >{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('l, d F Y') }}
                        <br>
                        {{ $data->waktu }}</p>
                </div>
                @if(($data->tgl <= $today) && ($data->status_id < 3))
                <div class="col-12" style="padding-bottom: 0.5rem;">
                    <span class="badge text-bg-danger">Melampaui Jadwal</span>
                </div>
                @endif
            </div>

            @if ((auth()->user()->kat_user != 2) && ($data->status_id == 1))
            
            @else
            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                @php
                    if (auth()->user()->kat_user != 2) {
                        $target = 'kolektor';
                        $id_target = $kolektor->id;
                        $foto = rawurlencode($kolektor->foto_diri);
                        $imgurl = 'public/img/foto/' . $foto . '';
                    } else {
                        $target = 'mitra';
                        $id_target = $data->id_wp;
                        $foto = rawurlencode($data->foto_diri);
                        $imgurl = 'public/img/foto/' . $foto . '';
                    }
                @endphp
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;"><h6 style="margin: 0; text-transform: capitalize;">{{ $target }}</h6></div>
                <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                    <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                        <div class="col" style="padding: 0;">
                            {{-- @if (auth()->user()->kat_user != 2) --}}
                                <a href="{{ route($target, ['id' => $id_target, 'fitur' => 'ambilin']) }}" style="text-decoration: none; color: unset;">
                            {{-- @endif --}}
                            <div class="row w-100" style="margin: 0">
                                <div class="col-auto" style="padding: 0">
                                    @if (!empty($foto) && file_exists($imgurl))
                                    <div style="height: 3rem; width: 3rem; border-radius: 50%;
                                        background-image: url({!! asset($imgurl) !!});
                                        background-size: cover; background-position: center;"
                                        class="img-thumbnail" alt="{{ $foto }}">
                                    </div>
                                    @else
                                    <div style="height: 3rem; width: 3rem; border-radius: 50%;
                                        background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                                        background-size: cover; background-position: center;"
                                        class="img-thumbnail" alt="">
                                    </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="row w-100 d-flex align-items-between" style="height: 100%;">
                                        @if (auth()->user()->kat_user != 2)
                                        <div class="col-12"><h6 style="margin: 0; text-align: justify;">{{ $kolektor->nama }}</h6></div>
                                        <div class="col-12">
                                            <p style="margin:0; text-align: justify; color:darkgrey;">
                                                @php
                                                    $rating_avg = (float)$attribute;
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
                                                &nbsp;{{number_format($rating_avg, 1, ',', '.')}}/5,0
                                            </p>
                                        </div>
                                        @else
                                            <div class="col-12"><h6 style="margin: 0; text-align: justify;">{{ $data->nama }}</h6></div>
                                            <div class="col-12"><p style="margin:0; text-align: justify; color:darkgrey;">{{ $attribute }}</p></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- @if (auth()->user()->kat_user != 2) --}}
                            </a>
                            {{-- @endif --}}
                        </div>
                        <div class="col-auto d-flex align-items-center" style="padding: 0">
                            <a href="{{ route('chat', ['id' => $id_target]) }}" style="text-decoration: none;">
                                <h6 class="text-success" style="margin: 0">Hubungi <i class="fa-solid fa-chevron-right"></i></h6>
                            </a>
                        </div>
                    </div>
                </div>
                @if ((auth()->user()->kat_user != 2) && ($data->status_id == 3))
                {{-- @dd($data->id_ambilin, $rating_cek) --}}
                {{-- @dd($today, \Carbon\Carbon::parse($data->waktuubah)->addWeeks(1)->format("Y-m-d H:i:s")) --}}
                    @if (in_array($data->id_ambilin, $rating_cek))
                        <div class="col-12" style="padding-bottom: 0.5rem;">
                            <a href="{{ route('lihat_rating_kolektor', ['id_booking' => $kolektor->booking_id]) }}" type="button" class="btn btn-outline-secondary" style="font-weight: 600; text-transform: capitalize; width: 100%">Lihat Penilaianku</a>
                        </div>
                    @else
                        @if (($today) <= (\Carbon\Carbon::parse($data->waktuubah)->addWeeks(1)->format("Y-m-d H:i:s")))
                            <div class="col-12" style="padding-bottom: 0.5rem;">
                                <a href="{{ route('beri_rating_kolektor', ['id_booking' => $kolektor->booking_id]) }}" type="button" class="btn btn-outline-success" style="font-weight: 600; text-transform: capitalize; width: 100%">Beri Penilaian</a>
                            </div>
                        @endif
                    @endif
                @elseif ((auth()->user()->kat_user == 2) && ($data->status_id == 3))
                    {{-- @dd($data->id_ambilin, $rating_cek) --}}
                    @if (in_array($data->id_ambilin, $rating_cek))
                        <div class="col-12" style="padding-bottom: 0.5rem;">
                            <a href="{{ route('lihat_rating_mitra', ['id_ambilin' => $id]) }}" type="button" class="btn btn-outline-secondary" style="font-weight: 600; text-transform: capitalize; width: 100%">Lihat Penilaianku</a>
                        </div>
                    @else
                        @if (($today) <= (\Carbon\Carbon::parse($data->waktuubah)->addWeeks(1)->format("Y-m-d H:i:s")))
                            <div class="col-12" style="padding-bottom: 0.5rem;">
                                <a href="{{ route('beri_rating_mitra', ['id_ambilin' => $id]) }}" type="button" class="btn btn-outline-success" style="font-weight: 600; text-transform: capitalize; width: 100%">Beri Penilaian</a>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            @endif

            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Lokasi</h6></div>
                        @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#lokasiModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="lokasiModal" tabindex="-1" aria-labelledby="lokasiModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="lokasiModalLabel">Ubah Lokasi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('ambilin_post_lokasi') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id ambilin -->
                                                <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                                <!-- Lokasi -->
                                                    <label class="form-label" for="lokasi">Lokasi Pengambilan <font color='#ff0000'>*</font></label>
                                                    <select class="form-select" aria-label="lokasi" name="idlokasi">
                                                    {{-- <option value=""> Pilih lokasi pengambilan barang </option> --}}
                                                        @foreach ($lokasi as $lok)
                                                            <option value="{{$lok->id}}" @if($lok->id == $data->id_lokasi) selected @endif>{{$lok->nama_lokasi}}</option>        
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="modal-footer">
                                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($data->id_wp != auth()->user()->id)
                    <div class="col-auto d-flex align-items-center">
                        <a href="{{ route('map_ambilin', ['id' => $data->id_ambilin]) }}" style="text-decoration: none;">
                            <h6 class="text-success" style="margin: 0">Lihat <i class="fa-solid fa-chevron-right"></i></h6>
                        </a>
                    </div>
                @endif
                <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                    <p style="line-height: 1.2; margin: 0; color: darkgrey; text-align: justify;"
                        >{{ $data->alamat_lokasi }} {{ $data->kel }}, {{ $data->kec }}, {{ $data->kab }}, {{ $data->prov }}</p>
                </div>
            </div>

            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Deskripsi</h6></div>
                        @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#deskripsiModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="deskripsiModal" tabindex="-1" aria-labelledby="deskripsiModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="deskripsiModalLabel">Ubah Deskripsi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('ambilin_post_deskripsi') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id ambilin -->
                                                <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                                <!-- Deskripsi -->
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Deskripsi...">{{ $data->keterangan }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                    <p style="line-height: 1.2; margin: 0; color: darkgrey; text-align: justify;"
                        >@if(!empty($data->keterangan)){{ $data->keterangan }}@else - @endif</p>
                </div>
            </div>

            @if ($data->status_id != 3) <!-- Selain Diterima -->
                <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

                <table class="table table-bordered align-middle text-center" style="font-size: smaller;">
                    <thead class="align-middle">
                        <tr>
                            <th scope="col">Jenis</th>
                            <th scope="col">Berat</th>
                            <th scope="col">Estimasi Harga /Kg</th>
                            <th scope="col">Estimasi Jumlah</th>
                            @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1)) <!-- Mitra & Mencari pengambil -->
                                <th scope="col">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                        @foreach ($list_sampah as $sampah)
                        @php
                            $mean_harga = ($sampah->harga_top + $sampah->harga_down)/2;
                            $jumlah = $mean_harga * $sampah->berat;
                            $total = $total + $jumlah;
                        @endphp
                        <tr>
                            <td>{{ $sampah->nama }}</td>
                            <td>{{ $sampah->berat }} Kg</td>
                            <td>Rp. {{ $sampah->harga_down }} - Rp. {{ $sampah->harga_top }}</td>
                            <td>Rp. {{ $jumlah }}</td>
                            @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1)) <!-- Mitra & Mencari pengambil -->
                                <td style="padding: 0">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editSampahModal{{ $sampah->id_berat }}">
                                        <i class="fa-solid fa-pen-to-square text-warning" style="font-size: x-large"></i>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editSampahModal{{ $sampah->id_berat }}" tabindex="-1" aria-labelledby="editSampahModal{{ $sampah->id_berat }}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editSampahModal{{ $sampah->id_berat }}Label">Ubah Sampah</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('ambilin_post_barang') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <!-- id ambilin -->
                                                        <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                                        <!-- id berat -->
                                                        <input type="hidden" name="id_berat" value="{{ $sampah->id_berat }}">
                                                        <!-- Jenis Sampah -->
                                                        <label class="form-label" for="jenis_sampah"><h6 style="font-weight: 700; margin: 0;">Jenis Sampah <font color='#ff0000'>*</font></h6></label>
                                                        <select class="form-select" aria-label="jenis_sampah" name="jenis_sampah">
                                                            {{-- <option value=""> Pilih jenis sampah </option> --}}
                                                            @foreach($jenis_sampah as $jns)
                                                            <option value="{{$jns->id}}" @if($jns->id == $sampah->id_sampah) selected @endif>{{$jns->nama}}</option>
                                                            @endforeach
                                                        </select>

                                                        <!-- Berat Sampah -->
                                                        <label class="form-label" for="jenis_sampah"><h6 style="font-weight: 700; margin: 0; padding-top: 10px;">Berat (Kg) <font color='#ff0000'>*</font></h6></label>
                                                        <input class="form-control" type="number" name="berat" style="background-color:white; width: 100%" value="{{ $sampah->berat }}" placeholder="berat..." required/>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-between">
                                                        <a type="button" href="{{ route('ambilin_hapus_barang', ['id_barang' => $sampah->id_berat]) }}"
                                                            onclick="return confirm('Apakah anda yakin ingin menghapus sampah ini?');" class="btn btn-danger">Hapus</a>
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Estimasi Total</th>
                            <th>Rp. {{ $total }}</th>
                            @if (($data->id_wp == auth()->user()->id) && ($data->status_id == 1)) <!-- Mitra & Mencari pengambil -->
                                <th style="padding: 0">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#tambahSampahModal">
                                        <i class="fa-solid fa-circle-plus text-success" style="font-size: x-large"></i>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="tambahSampahModal" tabindex="-1" aria-labelledby="tambahSampahModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="tambahSampahModalLabel">Tambah Sampah</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('ambilin_post_barang') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <!-- id ambilin -->
                                                        <input type="hidden" name="id_ambilin" value="{{ $data->id_ambilin }}">
                                                        <!-- id berat -->
                                                        <input type="hidden" name="id_berat" value="">
                                                        <!-- Jenis Sampah -->
                                                        <label class="form-label" for="jenis_sampah"><h6 style="font-weight: 700; margin: 0;">Jenis Sampah <font color='#ff0000'>*</font></h6></label>
                                                        <select class="form-select" aria-label="jenis_sampah" name="jenis_sampah">
                                                            <option value=""> Pilih jenis sampah </option>
                                                            @foreach($jenis_sampah as $jns)
                                                            <option value="{{$jns->id}}">{{$jns->nama}}</option>
                                                            @endforeach
                                                        </select>

                                                        <!-- Berat Sampah -->
                                                        <label class="form-label" for="jenis_sampah"><h6 style="font-weight: 700; margin: 0; padding-top: 10px;">Berat (Kg) <font color='#ff0000'>*</font></h6></label>
                                                        <input class="form-control" type="number" name="berat" style="background-color:white; width: 100%" placeholder="berat..." required/>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            @endif
                        </tr>
                    </tbody>
                </table>
            @else <!-- Diterima -->
                <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

                <table class="table table-bordered align-middle text-center" style="font-size: smaller;">
                    <thead class="align-middle">
                        <tr>
                            <th scope="col">Jenis</th>
                            <th scope="col">Berat Riil</th>
                            <th scope="col">Harga Riil /Kg</th>
                            <th scope="col">Jumlah</th>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                        @foreach ($list_sampah as $sampah)
                        @php
                            $jumlah = $sampah->harga_riil * $sampah->berat_riil;
                            $total = $total + $jumlah;
                        @endphp
                        <tr>
                            <td>{{ $sampah->nama }}</td>
                            <td>{{ $sampah->berat_riil }} Kg</td>
                            <td>Rp. {{ $sampah->harga_riil }}</td>
                            <td>Rp. {{ $jumlah }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Total</th>
                            <th>Rp. {{ $total }}</th>
                        </tr>
                    </tbody>
                </table>
            @endif

            <div class="row d-flex justify-content-center" style="margin: 0">
                @if (auth()->user()->kat_user == 2) <!-- Kolektor -->
                    @if ($data->status_id == 1) <!-- Belum diambil -->
                        <div class="col-6" style="padding-bottom: 1rem;">
                            <a type="button" class="btn btn-primary w-100" style="font-weight:600; text-transform: capitalize;"
                                href="{{ route('ambilin_ambil', ['id' => $data->id_ambilin]) }}"
                                onclick="return confirm('Apakah anda yakin ingin mengambil sampah ini?');">
                                <i class="fa-solid fa-truck-pickup"></i>&nbsp;&nbsp;Ambil
                            </a>
                        </div>
                    @elseif ($data->status_id == 2) <!-- Proses -->
                        <div class="col-6" style="padding-bottom: 1rem;">
                            <a type="button" class="btn btn-danger w-100" style="font-weight:600; text-transform: capitalize;"
                                href="{{ route('ambilin_kolektor_batal', ['id' => $data->id_ambilin]) }}"
                                onclick="return confirm('Apakah anda yakin ingin membatalkan pengambilan?');">
                                <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Batalkan
                            </a>
                        </div>
                        <div class="col-6" style="padding-bottom: 1rem;">
                            <a type="button" class="btn btn-success w-100" style="font-weight:600; text-transform: capitalize;"
                                href="{{ route('ambilin_verifikasi', ['id_ambilin' => $data->id_ambilin, 'id_booking' => $kolektor->booking_id]) }}">
                                <i class="fa-solid fa-check"></i>&nbsp;&nbsp;Verifikasi
                            </a>
                        </div>
                    @endif
                @else <!-- Mitra -->
                    @if ($data->status_id == 1) <!-- Belum diambil -->
                        <div class="col-6" style="padding-bottom: 1rem;">
                            <button type="button" class="btn btn-danger w-100" style="font-weight:600; text-transform: capitalize;" data-bs-toggle="modal" data-bs-target="#delAmbilinModal">
                                <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Hapus
                            </button>
                        </div>
                        @include('partials.modal_hapus_ambilin')
                    @elseif ($data->status_id == 2) <!-- Proses -->
                        <div class="col-6" style="padding-bottom: 1rem;">
                            <a type="button" class="btn btn-danger w-100" style="font-weight:600; text-transform: capitalize;"
                                href="{{ route('ambilin_mitra_batal', ['id' => $data->id_ambilin]) }}"
                                onclick="return confirm('Apakah anda yakin ingin membatalkan pengambilan?');">
                                <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Batalkan
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}