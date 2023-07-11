<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
@include('operator.partials.toast')
<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Tambah User</h3>
                    <p class="text-subtitle text-muted">Menambahkan user pada Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="card">
            {{-- <div class="card-header" style="padding-bottom: 0;"> --}}
                {{-- <h4 class="card-title">Vertical Form with Icons</h4> --}}
                {{-- <p class="card-text text-danger" style="text-align: justify;"><b>ID UKM Tani akan diperoleh setelah Petani berhasil mendaftarkan diri!</b></p> --}}
            {{-- </div> --}}
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-vertical" action="{{route('post_user-operator')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="back" value="tambah_user-operator">
                        <input type="hidden" name="id" value="new">
                        <input type="hidden" name="verified" value="2">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="kat_user">Kategori User <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" aria-label="Kategori User" name="kat_user" required>
                                                @foreach ($kat as $kat1)
                                                    @if ($loop->first)
                                                    <option selected value="{{$kat1->id}}">{{$kat1->kat}}</option>
                                                    @else
                                                    <option value="{{$kat1->id}}">{{$kat1->kat}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-shop-window"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="username">Username <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <input type="number" class="form-control" placeholder="Username" id="username" name="username" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        <span class="text-secondary" style="font-size: 80%">Isi dengan No WA jika Mitra/Bank Sampah, dan isi dengan KTA jika Kolektor</span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="no_wa">No WA <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <input type="number" class="form-control" placeholder="No WA" id="no_wa" name="no_wa" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-telephone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="password">Password <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="nama">Nama <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Nama" id="nama" name="nama" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap" name="nama_lengkap">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="email">Email</label>
                                        <div class="position-relative">
                                            <input type="email" class="form-control" placeholder="Email" id="Email" name="email">
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <div class="position-relative">
                                            <input type="date" class="form-control" placeholder="Tanggal Lahir" id="tgl_lahir" name="tgl_lahir" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-calendar4-event"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="sex">Gender</label>
                                        <div class="position-relative" style="height: 2.4rem;">
                                            <div class="row d-flex align-items-center h-100">
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sex" id="L" value="L">
                                                        <label class="form-check-label" for="L">
                                                          Laki-laki
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sex" id="P" value="P">
                                                        <label class="form-check-label" for="P">
                                                          Perempuan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idpekerjaan">Pekerjaan</label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" aria-label="Pekerjaan" name="idpekerjaan">
                                                <option value="">Pilih Pekerjaan</option>
                                                @foreach ($pekerjaan as $kerja)
                                                    <option value="{{ $kerja->id }}" {{{ (!empty(old('id_pekerjaan')) && old('id_pekerjaan') == $kerja->id) ? "selected=\"selected\"" : "" }}}>{{ $kerja->pekerjaan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-building"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idpendidikan">Pendidikan</label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idpendidikan">
                                                <option value="">Pilih Pendidikan</option>
                                                @foreach ($pendidikan as $didik)
                                                    <option value="{{ $didik->id }}" {{{ (!empty(old('id_pendidikan')) && old('id_pendidikan') == $didik->id) ? "selected=\"selected\"" : "" }}}>{{ $didik->pendidikan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-book"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><hr></div>
                                
                                {{-- Seluruh Provinsi --}}
                                {{-- <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idprov">Provinsi <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idprov" id="provinsi">
                                                <option selected>Pilih Provinsi</option>
                                                @foreach ($provinsi as $prov)
                                                    <option value="{{ $prov->id }}" {{{ (!empty(old('provinsi')) && old('provinsi') == $prov->id) ? "selected=\"selected\"" : "" }}}>{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idkab">Kabupaten <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idkab" id="kabupaten">
                                                <option value="">Pilih Kabupaten</option>
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idkec">Kecamatan <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idkec" id="kecamatan">
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- End Seluruh Provinsi --}}

                                {{-- Kota Semarang --}}
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idprov">Provinsi <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idprov" id="provinsi" disabled>
                                                <option value="{{ $provinsi->id }}" selected>{{ $provinsi->name }}</option>
                                            </select>
                                            <input type="hidden" name="provinsi" value="{{ $provinsi->id }}"/>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idkab">Kabupaten <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idkab" id="kabupaten" disabled>
                                                <option value="{{ $kabupaten->id }}" selected>{{ $kabupaten->name }}</option>
                                            </select>
                                            <input type="hidden" name="kabupaten" value="{{ $kabupaten->id }}"/>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idkec">Kecamatan <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idkec" id="kecamatan">
                                                <option Selected>Pilih Kecamatan</option>
                                                @foreach ($kecamatan as $kec)
                                                    <option value="{{ $kec->id }}">{{ $kec->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Kota Semarang --}}

                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="idkel">Kelurahan <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <select class="form-control form-select" name="idkel" id="kelurahan">
                                                <option value="">Pilih Kelurahan</option>
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="alamat_lokasi">Alamat Lokasi <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <textarea name="alamat_lokasi" id="alamat_lokasi" class="form-control" rows="2" placeholder="Alamat Lokasi" required></textarea>
                                            <div class="form-control-icon">
                                                <i class="bi bi-map"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="kodepos">Kodepos</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Kodepos" id="kodepos" name="kodepos">
                                            <div class="form-control-icon">
                                                <i class="bi bi-mailbox"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"><hr></div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="foto_diri">Foto Diri <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <div class="form-group">
                                                <div class="file-loading">
                                                    <input id="file-1" type="file" name="foto_diri">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="no_ktp">No KTP <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <input type="number" class="form-control" placeholder="No KTP" id="no_ktp" name="no_ktp" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-card-heading"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="ktp">Foto KTP <font style="color:red">*</font></label>
                                        <div class="position-relative">
                                            <div class="form-group">
                                                <div class="file-loading">
                                                    <input id="file-2" type="file" name="ktp">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="form-group has-icon-left">
                                        <label for="kta">Foto KTA</label>
                                        <div class="position-relative">
                                            <div class="form-group">
                                                <div class="file-loading">
                                                    <input id="file-3" type="file" name="kta">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    <button type="submit" class="btn btn-success me-1 mb-1">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>

<script type="text/javascript">
    $("#file-1").fileinput({
        theme: 'fa',
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        showUpload: false,
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
        overwriteInitial: false,
        maxFileSize: 4096,
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    $("#file-2").fileinput({
        theme: 'fa',
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        showUpload: false,
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
        overwriteInitial: false,
        maxFileSize: 4096,
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    $("#file-3").fileinput({
        theme: 'fa',
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        showUpload: false,
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
        overwriteInitial: false,
        maxFileSize: 4096,
        slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $(function() {
        //     $('#provinsi').on('change', function() {
        //         let provID = $('#provinsi').val();

        //         $.ajax({
        //             type: 'POST',
        //             dataType: "html",
        //             url: "{{route('getkabupaten-operator')}}",
        //             data: {
        //                 provID: provID
        //             },
        //             cache: false,

        //             success: function(msg) {
        //                 $('#kabupaten').html(msg);
        //                 $("#kecamatan").html(
        //                     "<select class='form-control form-select' name='kecamatan' id='kecamatan'><option>Pilih Kecamatan</option></select>"
        //                 );
        //                 $("#kelurahan").html(
        //                     "<select class='form-control form-select' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>"
        //                 );
        //             },

        //             error: function(data) {
        //                 console.log('error: ', data)
        //             },

        //         })
        //     })
        // })

        // $(function() {
        //     $('#kabupaten').on('change', function() {
        //         let kabID = $('#kabupaten').val();

        //         $.ajax({
        //             type: 'POST',
        //             dataType: "html",
        //             url: "{{route('getkecamatan-operator')}}",
        //             data: {
        //                 kabID: kabID
        //             },
        //             cache: false,

        //             success: function(msg) {
        //                 $('#kecamatan').html(msg);
        //                 $("#kelurahan").html(
        //                     "<select class='form-control form-select' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>"
        //                 );
        //             },

        //             error: function(data) {
        //                 console.log('error: ', data)
        //             },

        //         })
        //     })
        // })

        $(function() {
            $('#kecamatan').on('change', function() {
                let kecID = $('#kecamatan').val();

                $.ajax({
                    type: 'POST',
                    dataType: "html",
                    url: "{{route('getkelurahan-operator')}}",
                    data: {
                        kecID: kecID
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kelurahan').html(msg);
                    },

                    error: function(data) {
                        console.log('error: ', data)
                    },

                })
            })
        })

        // $(function() {
        //     var provID = $('#provinsi').val();
        //     if ('null' != provID) {
        //         $(function() {
        //             let provID = $('#provinsi').val();

        //             $.ajax({
        //                 type: 'POST',
        //                 dataType: "html",
        //                 url: "{{route('getkabupaten-operator')}}",
        //                 data: {
        //                     provID: provID
        //                 },
        //                 cache: false,

        //                 success: function(msg) {
        //                     $('#kabupaten').html(msg);
        //                     $("#kecamatan").html(
        //                         "<select class='form-control form-select' name='kecamatan' id='kecamatan'><option>Pilih Kecamatan</option></select>"
        //                     );
        //                     $("#kelurahan").html(
        //                         "<select class='form-control form-select' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>"
        //                     );
        //                 },

        //                 error: function(data) {
        //                     console.log('error: ', data)
        //                 },

        //             })
        //         })
        //     }

        //     $(function() {
        //         var kabID = $('#kabupaten').val();
        //         if ('null' != kabID) {
        //             $(function() {
        //                 let kabID = $('#kabupaten').val();

        //                 setTimeout(function() {
        //                     $.ajax({
        //                         type: 'POST',
        //                         dataType: "html",
        //                         url: "{{route('getkecamatan-operator')}}",
        //                         data: {
        //                             kabID: kabID
        //                         },
        //                         cache: false,

        //                         success: function(msg) {
        //                             $('#kecamatan').html(msg);
        //                             $("#kelurahan").html(
        //                                 "<select class='form-control form-select' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>"
        //                             );
        //                         },

        //                         error: function(data) {
        //                             console.log('error: ', data)
        //                         },

        //                     })
        //                 }, 250);
        //             })
        //         }

                $(function() {
                    var kecID = $('#kecamatan').val();
                    if ('null' != kecID) {
                        $(function() {

                            setTimeout(function() {
                                $.ajax({
                                    type: 'POST',
                                    dataType: "html",
                                    url: "{{route('getkelurahan-operator')}}",
                                    data: {
                                        kecID: kecID
                                    },
                                    cache: false,

                                    success: function(msg) {
                                        $('#kelurahan')
                                            .html(msg);
                                    },

                                    error: function(data) {
                                        console.log(
                                            'error: ',
                                            data)
                                    },

                                })
                            }, 500);
                        })
                    }
                })
            })
    //     })

    // })
    ;

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>