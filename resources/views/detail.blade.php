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
                    // $back = route('paskas-jualan');
                } else {
                    $Nama = 'Sedekah Barang Bekas';
                    $imgurl = 'public/img/sebar/' . $data->foto . '';
                    // $back = route('sebarku');
                }
            @endphp
            <!-- Navbar brand -->
            <a class="navbar-brand" onclick="history.back()" style="padding-left:0.5rem"><i
                    class="fa-solid fa-chevron-left"></i></a>
            {{-- <a class="navbar-brand" href="{{ $back }}" style="padding-left:0.5rem"><i
                    class="fa-solid fa-chevron-left"></i></a> --}}
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{ strtoupper($fitur) }} |
                {{ $Nama }}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>

    <style>
        p {margin: 0;}

        .carousel .carousel-indicators button {width: 10px; height: 10px; border-radius: 100%;}
        .carousel-indicators .active {background-color: #176e41;}

        .input-group>.btn {padding-top: 0.7rem;}

        .strikethrough {
            position: relative;
        }
        .strikethrough:before {
            position: absolute;
            content: "";
            left: 0;
            top: 50%;
            right: 0;
            border-top: 1px solid;
            border-color: red;
            
            -webkit-transform:rotate(-5deg);
            -moz-transform:rotate(-5deg);
            -ms-transform:rotate(-5deg);
            -o-transform:rotate(-5deg);
            transform:rotate(-5deg);
        }
    </style>

    <!-- Content -->
    <div class="row w-100 d-flex justify-content-center" style="margin: 0">
        <div class="col-lg-4 col-md-5 col-12" style="padding: 0">
            <div class="card border border-0 rounded-0 d-flex justify-content-center align-items-center"
                style="background-color: black;">

                @if (!empty($data->foto) && file_exists($imgurl))
                <!-- Slide Show -->
                <div id="carouselExampleIndicators" class="carousel slide" data-mdb-ride="carousel" data-mdb-interval="false">
                    <div class="carousel-indicators mb-0">
                        @if ($foto->count() > 0)
                            @php $slide = 0; @endphp
                            <button type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide-to="{{ $slide }}"
                                class="active" aria-current="true" aria-label="Slide {{ $slide + 1 }}"></button>
                        @endif
                        @foreach ($foto as $foto_count)
                            @php $slide++; @endphp
                            <button type="button" data-mdb-target="#carouselExampleIndicators"
                                data-mdb-slide-to="{{ $slide }}" aria-label="Slide {{ $slide + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @php $count = 1; @endphp
                        <div class="carousel-item active">
                            @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                            <!-- Button Modal -->
                            <div class="position-absolute bottom-0 start-0">
                                <button class="btn btn-warning btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 0 0 1rem 1rem;"
                                    data-bs-toggle="modal" data-bs-target="#editGambarModal{{ $count }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                            {{-- <div class="position-absolute bottom-0 end-0">
                                <button class="btn btn-success btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 0 1rem 1rem 0;"
                                    data-bs-toggle="modal" data-bs-target="#tambahGambarModal">
                                    <i class="fa-solid fa-file-circle-plus"></i>
                                </button>
                            </div> --}}
                            {{-- <div class="position-absolute top-0 end-0">
                                <a class="btn btn-danger btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 1rem 1rem 0 0;" href="javascript:void(0)">
                                    <i class="fa-solid fa-file-circle-xmark"></i>
                                </a>
                            </div> --}}
                            <!-- Button Modal End -->
                            <!-- Modal -->
                            <div class="modal fade" id="editGambarModal{{ $count }}" tabindex="-1" aria-labelledby="editGambarModal{{ $count }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('barkas_edit_gambar_utama', ['fitur' => $fitur]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editGambarModal{{ $count }}Label">Ubah Gambar</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <!-- Gambar -->
                                                <div class="position-relative">
                                                    <div class="form-group">
                                                        <div class="file-loading">
                                                            <input id="foto-barkas{{ $count }}" type="file" name="foto" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true">
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        $("#foto-barkas{{ $count }}").fileinput({
                                                            theme: 'explorer-fa5',
                                                            language: "id",
                                                            previewFileType: "image",
                                                            browseClass: "btn btn-success btn-md",
                                                            browseLabel: "Cari",
                                                            removeClass: "btn btn-danger btn-md",
                                                            removeLabel: "",
                                                            showClose: false,
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
                            <!-- Modal End -->
                            @endif
                            <img src="{!! asset($imgurl) !!}" class="d-block w-100" alt="{{ $data->foto }} {{ $count }}"
                                style="max-width: 100%; max-height: 100%; aspect-ratio: 1 / 1; object-fit: contain; background-color: black;" />
                        </div>
                        @foreach ($foto as $foto_barkas)
                            @php $count++; @endphp
                            <div class="carousel-item">
                                @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                                <!-- Button Modal -->
                                <div class="position-absolute bottom-0 start-0">
                                    <button class="btn btn-warning btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 0 0 1rem 1rem;"
                                        data-bs-toggle="modal" data-bs-target="#editGambarModal{{ $count }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                                {{-- <div class="position-absolute bottom-0 end-0">
                                    <button class="btn btn-success btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 0 1rem 1rem 0;"
                                        data-bs-toggle="modal" data-bs-target="#tambahGambarModal">
                                        <i class="fa-solid fa-file-circle-plus"></i>
                                    </button>
                                </div> --}}
                                <div class="position-absolute top-0 end-0">
                                    <a class="btn btn-danger btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 1rem 1rem 0 0;"
                                    href="{{ route('barkas_hapus_gambar', ['fitur' => $fitur, 'id' => $foto_barkas->id]) }}"
                                    onclick="return confirm('Apakah anda yakin ingin menghapus gambar ini?');">
                                        <i class="fa-solid fa-file-circle-xmark"></i>
                                    </a>
                                </div>
                                <!-- Button Modal End -->
                                <!-- Modal -->
                                <div class="modal fade" id="editGambarModal{{ $count }}" tabindex="-1" aria-labelledby="editGambarModal{{ $count }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('barkas_edit_gambar', ['fitur' => $fitur]) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editGambarModal{{ $count }}Label">Ubah Gambar</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- id foto -->
                                                    <input type="hidden" name="id" value="{{ $foto_barkas->id }}">
                                                    <!-- Gambar -->
                                                    <div class="position-relative">
                                                        <div class="form-group">
                                                            <div class="file-loading">
                                                                <input id="foto-barkas{{ $count }}" type="file" name="foto" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true">
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript">
                                                            $("#foto-barkas{{ $count }}").fileinput({
                                                                theme: 'explorer-fa5',
                                                                language: "id",
                                                                previewFileType: "image",
                                                                browseClass: "btn btn-success btn-md",
                                                                browseLabel: "Cari",
                                                                removeClass: "btn btn-danger btn-md",
                                                                removeLabel: "",
                                                                showClose: false,
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
                                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> -->
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal End -->
                                @endif
                                <img src="{!! asset('public/img/'.$fitur.'/' . $foto_barkas->foto) !!}" class="d-block w-100" alt="{{ $data->foto }} {{ $count }}"
                                style="max-width: 100%; max-height: 100%; aspect-ratio: 1 / 1; object-fit: contain; background-color: black;" />
                            </div>
                        @endforeach
                    </div>
                    @if ($foto->count() > 0)
                        <button class="carousel-control-prev visually-hidden" type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide="prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button class="carousel-control-next visually-hidden" type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide="next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
                <!-- END Slide Show -->

                <div class="position-absolute top-0 start-0">
                    @if ($data->id_kondisi == 1)
                        @php $badge_color = 'text-bg-danger'; @endphp
                    @elseif ($data->id_kondisi == 2)
                        @php $badge_color = 'text-bg-warning'; @endphp
                    @elseif ($data->id_kondisi == 3)
                        @php $badge_color = 'text-bg-success'; @endphp
                    @elseif ($data->id_kondisi == 4)
                        @php $badge_color = 'text-bg-info'; @endphp
                    @endif
                    <span class="badge {{ $badge_color }}"
                        style="font-size: unset; font-weight: 600; margin-left: 0.5rem; margin-top: 0.5rem; text-transform: capitalize;">{{ $data->kondisi }}</span>
                </div>
                
                    {{-- <img src="{!! asset($imgurl) !!}" class="" alt="{{ $data->foto }}"
                        style="max-width: 100%; max-height: 100%; aspect-ratio: 1 / 1; object-fit: contain; background-color: black;"> --}}
                @else
                    <img src="https://ambilin.com/img/png/ambilin.png" class=""
                        alt="Gambar tidak ditemukan"
                        style="width: 100%;">
                @endif

                @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                    @if ($foto->count() < 9)
                        <div class="position-absolute bottom-0 end-0">
                            <button class="btn btn-success btn-lg rounded-circle text-center" style="opacity: 0.5; margin: 0 1rem 1rem 0;"
                                data-bs-toggle="modal" data-bs-target="#tambahGambarModal">
                                <i class="fa-solid fa-file-circle-plus"></i>
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="tambahGambarModal" tabindex="-1" aria-labelledby="tambahGambarModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('barkas_tambah_gambar', ['fitur' => $fitur]) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="tambahGambarModalLabel">Tambah Gambar</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- id barkas -->
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <!-- Gambar -->
                                            <div class="position-relative">
                                                <div class="form-group">
                                                    <div class="file-loading">
                                                        <input id="tambah-foto-barkas" type="file" name="foto" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true">
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    $("#tambah-foto-barkas").fileinput({
                                                        theme: 'explorer-fa5',
                                                        language: "id",
                                                        previewFileType: "image",
                                                        browseClass: "btn btn-success btn-md",
                                                        browseLabel: "Cari",
                                                        removeClass: "btn btn-danger btn-md",
                                                        removeLabel: "",
                                                        showClose: false,
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
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> -->
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal End -->
                    @endif
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-5 col-12" style="padding: 0">
            <div class="row w-100" style="margin: 0">
                <div class="col-12"
                    style="letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                    <div class="row" style="margin-top: 0.5rem;">
                        <div class="col-auto">
                            <h6 style="margin:0.25rem 0; font-size: 100%; font-weight: 700;"
                                id="nama_barkas">{{ $data->judul }}</h6>
                        </div>
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#judulModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="judulModal" tabindex="-1" aria-labelledby="judulModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="judulModalLabel">Ubah Judul</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barkas_edit_judul', ['fitur' => $fitur]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Judul -->
                                                <label class="form-label" for="judul">Judul Barang Bekas <font color='#ff0000'>*</font></label>
                                                <input type="text" class="form-control" name="judul" value="{{ $data->judul }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($fitur == 'paskas')
                        @if ($data->status_publikasi == 4)
                        <div class="row d-flex flex-column">
                            @if ($data->harga != $info_tambahan->harga)
                            <div class="col-auto">
                                <p class="text-secondary strikethrough" style="font-weight: 600; font-size: smaller; width: fit-content; margin-bottom: -0.5rem;">
                                    Rp. {{ number_format($data->harga, 0, ',', '.') }},-
                                </p>
                            </div>
                            @endif
                            <div class="col-auto">
                                <p class="text-success" style="font-weight: 600;">Rp. {{ number_format($info_tambahan->harga, 0, ',', '.') }},-</p>
                            </div>
                        @else
                        <div class="row">
                            <div class="col-auto">
                                <p class="text-success" style="font-weight: 600;">Rp. {{ number_format($data->harga, 0, ',', '.') }},-</p>
                            </div>
                        @endif
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#hargaModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="hargaModal" tabindex="-1" aria-labelledby="hargaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="hargaModalLabel">Ubah Harga</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barkas_edit_harga') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Harga -->
                                                <label class="form-label" for="harga">Harga Barang Bekas <font color='#ff0000'>*</font></label>
                                                <input type="number" min="1000" class="form-control" name="harga" value="{{ $data->harga }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div style="height: 0.5rem; width: 100%; background-color: lightgray; margin-top: 0.5rem;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto d-flex align-items-center" style="padding-top: 0.5rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Jenis</h6></div>
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#jenisModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="jenisModal" tabindex="-1" aria-labelledby="jenisModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="jenisModalLabel">Ubah Jenis</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barkas_edit_jenis', ['fitur' => $fitur]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Jenis -->
                                                <label class="form-label" for="jenis">Jenis Barang Bekas <font color='#ff0000'>*</font></label>
                                                <select class="form-select" aria-label="jenis" name="idjenis">
                                                    @foreach ($jenis as $jns)
                                                        <option value="{{$jns->id}}" @if($jns->id == $data->id_jenis) selected @endif>{{$jns->jenis}}</option>        
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center" style="padding-top: 0.5rem;"><p style="margin: 0; color: darkgrey;">{{ $data->jenis }}</p></div>

                <div class="col-12"><hr style="margin: 0.25rem 0;"></div>

                <div class="col-auto d-flex align-items-center" style="padding-bottom: 0.5rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Kondisi</h6></div>
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
                            <div class="col-auto">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kondisiModal">
                                    <i class="fa-solid fa-pen-to-square text-warning" style="font-size: larger"></i>
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="kondisiModal" tabindex="-1" aria-labelledby="kondisiModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="kondisiModalLabel">Ubah Kondisi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('barkas_edit_kondisi', ['fitur' => $fitur]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Kondisi -->
                                                <label class="form-label" for="kondisi">Kondisi Barang Bekas <font color='#ff0000'>*</font></label>
                                                <select class="form-select" aria-label="kondisi" name="idkondisi">
                                                    @foreach ($kondisi as $knds)
                                                        <option value="{{$knds->id}}" @if($knds->id == $data->id_kondisi) selected @endif>{{$knds->kondisi}}</option>        
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center" style="padding-bottom: 0.5rem;"><p style="margin: 0; color: darkgrey;">{{ $data->kondisi }}</p></div>
            </div>

            @if ($data->wp_id != auth()->user()->id)
                <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

                <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                    @php
                        $foto = rawurlencode($data->foto_diri);
                        $fotourl = 'public/img/foto/' . $foto . '';
                    @endphp
                    <div class="col-12" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                        <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                            <div class="col" style="padding: 0;">
                                <a href="{{ route('mitra', ['id' => $data->wp_id, 'fitur' => $fitur]) }}" style="text-decoration: none; color: unset;">
                                <div class="row w-100" style="margin: 0">
                                    <div class="col-auto" style="padding: 0">
                                        @if (!empty($foto) && file_exists($fotourl))
                                        <div style="height: 3rem; width: 3rem; border-radius: 50%;
                                            background-image: url({!! asset($fotourl) !!});
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
                                            <div class="col-12"><h6 style="margin: 0; text-align: justify;">{{ $data->nama }}</h6></div>
                                            <div class="col-12"><p style="margin:0; text-align: justify; color:darkgrey;">{{ $attribute }}</p></div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-auto d-flex align-items-center" style="padding: 0">
                                <a href="{{ route('chat', ['id' => $data->wp_id]) }}" style="text-decoration: none;">
                                    <h6 class="text-success" style="margin: 0">Hubungi <i class="fa-solid fa-chevron-right"></i></h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

            <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                    <div class="row">
                        <div class="col-auto"><h6 style="margin: 0">Lokasi</h6></div>
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
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
                                        <form action="{{ route('barkas_edit_lokasi', ['fitur' => $fitur]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Lokasi -->
                                                    <label class="form-label" for="lokasi">Lokasi Pengambilan <font color='#ff0000'>*</font></label>
                                                    <select class="form-select" aria-label="lokasi" name="idlokasi">
                                                        @foreach ($lokasi as $lok)
                                                            <option value="{{$lok->id}}" @if($lok->id == $data->id_lokasi) selected @endif>{{$lok->nama_lokasi}}</option>        
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($data->wp_id != auth()->user()->id)
                    @if (!empty($data->lokasi_x) && !empty($data->lokasi_y))
                        <div class="col-auto d-flex align-items-center">
                            <a href="{{ route('map_barkas', ['id' => $id, 'fitur' => $fitur]) }}" style="text-decoration: none;">
                                <h6 class="text-success" style="margin: 0">Lihat <i class="fa-solid fa-chevron-right"></i></h6>
                            </a>
                        </div>
                    @else
                        <div class="col-auto d-flex align-items-center">
                            <a href="javascript:void(0)" style="text-decoration: none;">
                                <h6 style="color: darkgrey; margin: 0;" style="margin: 0">Lihat <i class="fa-solid fa-chevron-right"></i></h6>
                            </a>
                        </div>
                    @endif
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
                        @if (($data->wp_id == auth()->user()->id) && ($data->status_publikasi != 4))
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
                                        <form action="{{ route('barkas_edit_deskripsi', ['fitur' => $fitur]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- id barkas -->
                                                <input type="hidden" name="id_barkas" value="{{ $id }}">
                                                <!-- Deskripsi -->
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi...">{{ $data->deskripsi }}</textarea>
                                            </div>
                                            <div class="modal-footer">
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
                        >@if(!empty($data->deskripsi)){{ $data->deskripsi }}@else - @endif</p>
                </div>
            </div>

            @if ($data->status_publikasi == 4)
                <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

                <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                    <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                        <div class="row">
                            <div class="col-auto"><h6 style="margin: 0">Keterangan Laku</h6></div>
                        </div>
                    </div>
                    <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                        <p style="line-height: 1.2; margin: 0; color: darkgrey; text-align: justify;"
                            >@if(!empty($info_tambahan->keterangan)){{ $info_tambahan->keterangan }}@else - @endif</p>
                    </div>
                </div>
            @elseif ($data->status_publikasi == 3)
                <div style="height: 0.5rem; width: 100%; background-color: lightgray;"></div>

                <div class="row w-100 d-flex justify-content-between" style="margin: 0">
                    <div class="col-auto" style="padding-top: 0.5rem; padding-bottom: 0.25rem;">
                        <div class="row">
                            <div class="col-auto"><h6 style="margin: 0">Alasan Ditolak</h6></div>
                        </div>
                    </div>
                    <div class="col-12" style="padding-top: 0.25rem; padding-bottom: 0.5rem;">
                        <p style="line-height: 1.2; margin: 0; color: darkgrey; text-align: justify;"
                            >@if(!empty($info_tambahan->alasan)){{ $info_tambahan->alasan }}@else - @endif</p>
                    </div>
                </div>
            @endif

            <br>

            @if ($data->wp_id == auth()->user()->id)
                @if ($data->status_publikasi != 4)
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-6 pb-2">
                                <button type="button" class="btn btn-danger w-100" style="font-weight:600; text-transform: capitalize;"
                                    data-bs-toggle="modal" data-bs-target="#delFitModal">
                                    <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Hapus
                                </button>
                            </div>
                            @include('partials.modal_hapus_fitur')
                            @if ($fitur == 'paskas')
                            <div class="col-6 pb-2">
                                <a type="button" class="btn btn-success w-100" style="font-weight:600; text-transform: capitalize;"
                                    href="{{ route('paskas_sedekah', ['id' => $id]) }}"
                                    onclick="return confirm('Apakah anda yakin ingin menyedekahkan barang bekas ini?');">
                                    <i class="fa-solid fa-gift"></i>&nbsp;&nbsp;Sedekahkan
                                </a>
                            </div>
                            @endif
                            @if ($data->status_publikasi == 2)
                            <div class="col-6 pb-2">
                                {{-- <a type="button" class="btn btn-primary w-100" style="font-weight:600; text-transform: capitalize;" 
                                    href="{{ route('laku', ['fitur' => $fitur, 'id' => $id]) }}"
                                    onclick="return confirm('Apakah anda yakin ingin mengubah status barang bekas ini menjadi laku?');">
                                    <i class="fa-solid fa-clipboard-check"></i>&nbsp;&nbsp;Laku
                                </a> --}}
                                <button type="button" class="btn btn-primary w-100" style="font-weight:600; text-transform: capitalize;" 
                                    data-bs-toggle="modal" data-bs-target="#lakuModal">
                                    <i class="fa-solid fa-clipboard-check"></i>&nbsp;&nbsp;Laku
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="lakuModal" tabindex="-1" aria-labelledby="lakuModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="lakuModalLabel">Konfirmasi Laku</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('laku', ['fitur' => $fitur, 'id' => $id]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-body">
                                                    <div class="row">
                                                        @if ($fitur == 'paskas')
                                                            <div class="col-12">
                                                                <label for="alasan_tolak" style="font-weight: 600; padding-bottom: 0.5rem;">Harga kesepakatan</label>
                                                                <div class="position-relative">
                                                                    <input type="number" class="form-control" name="harga" value="{{ $data->harga }}" required>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-12">
                                                            <label for="keterangan" style="font-weight: 600; padding-bottom: 0.5rem;">Keterangan</label>
                                                            <div class="position-relative">
                                                                <textarea type="text" class="form-control" name="keterangan" placeholder="Sudah diambil pak Yudi" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @elseif ($data->status_publikasi == 3)
                            <div class="col-6 pb-2">
                                <a type="button" class="btn btn-primary w-100" style="font-weight:600; text-transform: capitalize;"
                                    href="{{ route('ajukan_ulang', ['fitur' => $fitur, 'id' => $id]) }}"
                                    onclick="return confirm('Apakah anda yakin ingin mengajukan barang bekas ini lagi?');">
                                    <i class="fa-solid fa-file-arrow-up"></i>&nbsp;&nbsp;Ajukkan Ulang
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            {{-- <div class="row d-flex justify-content-center" style="margin: 0">
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
            </div> --}}
        </div>
    </div>
    <!-- Content End -->
@endsection