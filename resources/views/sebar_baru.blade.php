@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/locales/LANG.js"></script>
    <div class="container" style="padding-bottom:2rem">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <style>
                            .is-invalid {
                                margin-bottom: 1rem;
                            }

                            .invalid-feedback {
                                width: auto;
                                margin-top: -1rem;
                            }

                            .form-select.is-invalid~.invalid-feedback {
                                width: auto;
                                margin-top: -1rem;
                            }
                        </style>
                        <form action="{{route('post_sebar')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="alert alert-warning" role="alert">
                                Saat ini Pasar Barang Bekas baru untuk Semarang Raya, terimakasih
                            </div>
                            <hr>
                            <!-- Foto Sampah -->
                            <label class="form-label" for="file_foto_sampah">Unggah Foto/Gambar Sampah <font color='#ff0000'>*</font></label>
                            {{-- <input type="file" class="form-control" id="file_foto_sampah" name="foto"/> --}}
                            
                            <div class="position-relative">
                                <div class="form-group">
                                    <style>
                                        .input-group>.btn {padding-top: 0.7rem;}
                                    </style>
                                    <div class="file-loading">
                                        <input id="file_foto_sampah" type="file" name="foto[]" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true" multiple>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $("#file_foto_sampah").fileinput({
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
                                        maxFileCount: 10,
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

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <p class="text-secondary" style="font-size: 80%; margin: 0;" disabled>Sertakan foto barang bekas dengan ukuran maksimal 4 MB, bisa menggunakan file dari whatsapp atau hasil capture</p>

                            <!-- Nama Barang Bekas input -->
                            <label class="form-label" for="barang_bekas" style="padding-top: 10px">Nama Barang Bekas <font color='#ff0000'>*</font></label>
                            <input type="text" name="judul" id="barang_bekas" class="form-control @error('judul') is-invalid @enderror" style="background-color:white;" placeholder="Nama barang bekas" required/>
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Keterangan input -->
                            <label class="form-label" for="keterangan" style="padding-top: 10px">Keterangan</label>
                            <textarea name="deskripsi" aria-label="keterangan" class="form-control" rows="3" placeholder="Keterangan..."></textarea>
                            <p class="text-secondary" style="font-size: 80%; margin: 0;" disabled>Berikan informasi yang mudah dipahami sesuai kondisi barang, sehiingga tidak terjadi kesalahpahaman</p>

                            <!-- Kondisi Fisik -->
                            <label class="form-label" for="kondisi_fisik" style="padding-top: 10px">Kondisi Fisik <font color='#ff0000'>*</font></label>
                            <select class="form-select @error('kondisi') is-invalid @enderror" aria-label="kondisi_fisik" name="kondisi">
                                <option> Pilih kondisi barang </option>
                                @foreach ($kondisi as $kondisi)
                                <option value={{$kondisi->id}}>{{$kondisi->kondisi}}</option>                                    
                                @endforeach
                            </select>
                            @error('kondisi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Fungsi Utama -->
                            <label class="form-label" for="fungsi_utama" style="padding-top: 10px">Fungsi Utama <font color='#ff0000'>*</font></label>
                            <select class="form-select @error('fungsi') is-invalid @enderror" aria-label="fungsi_utama" name="fungsi">
                                <option> Pilih jenis barang </option>
                                @foreach ($fungsi as $fungsi)
                                <option value={{$fungsi->id}}>{{$fungsi->jenis}}</option>
                                @endforeach
                            </select>
                            @error('fungsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Lokasi -->
                            <label class="form-label" for="lokasi" style="padding-top: 10px">Lokasi Pengambilan <font color='#ff0000'>*</font></label>
                            {{-- {{dd($lokasi)}} --}}
                            @if (count($lokasi) === 0)
                                <select class="form-select" aria-label="lokasi" name="lokasi_pengambilan" disabled>
                                    <option value=""> Pilih lokasi pengambilan barang </option>
                                </select>
                                <p class="text-secondary" style="text-align: justify; font-size: 80%; padding-top: 5px;">Lokasi pengambilan barang anda kosong, silahkan tambahkan <a href="{{route('tambah_lokasi_1')}}" style="color: #91bc06;">di sini</a> atau aktifkan lokasi pengambilan <a href="{{route('profile')}}" style="color: #91bc06;">di sini</a></p>
                            @else
                                <select class="form-select @error('lokasi_pengambilan') is-invalid @enderror" aria-label="lokasi" name="lokasi_pengambilan">
                                <option value=""> Pilih lokasi pengambilan barang </option>
                                    @foreach ($lokasi as $lok)
                                        <option value="{{$lok->id}}" {{{ ((null !== old('lokasi_pengambilan')) && old('lokasi_pengambilan') == $lok->id) ? "selected=\"selected\"" : "" }}}>{{$lok->nama_lokasi}}</option>        
                                    @endforeach
                                </select>
                                @error('lokasi_pengambilan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @endif
                            <p class="text-secondary" style="text-align: justify; font-size: 80%" disabled>Informasi lokasi yang ditampilkan di aplikasi tidak akan detail hanya nama kecamatan dan kota/kab</p>

                            {{-- @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <div class="mt-3 mb-3">
                                <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                            </div>

                            <!-- Submit button -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a type="button" href="paskas-jualan" class="btn btn-danger btn-lg btn-block" style="text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Batal</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Tambah</button>
                                </div>
                            </div>

                            <script>
                                function hanyaAngka(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode
                                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                                        return false;
                                    return true;
                                }
                            </script>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
{{-- //@include('partials.shortcut') --}}