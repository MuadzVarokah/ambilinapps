@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <div class="container">
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
                        <form action="{{route('post_ambilin')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <div class="alert alert-warning" role="alert" style="margin: 0;">
                                <h6><i class="fa-solid fa-triangle-exclamation text-danger"></i> Perhatian!</h6>
                                <hr style="margin: 0.5rem 0;">
                                <blink><p style="font-size: 80%; margin: 0; font-weight: 600;">Yuk unggah sampah pilahan anda dengan berat minimal {{$berat_min}} kg agar kolektor tertarik untuk mengambilnya</p></blink>
                            </div>
                            @if (count($lokasi) === 0)
                            <br>
                            <div class="alert alert-danger" role="alert" style="margin: 0;">
                            <blink><p style="font-size: 80%; margin: 0; font-weight: 600;">Lokasi pengambilan barang anda kosong, silahkan tambahkan <a href="{{route('tambah_lokasi_1')}}" style="color: #91bc06;">di sini</a> atau aktifkan lokasi pengambilan <a href="{{route('profile')}}" style="color: #91bc06;">di sini</a> terlebih dahulu</p></blink>
                                </div>
                            @endif
                            <!-- Foto Sampah -->
                            <label class="form-label" for="foto" style="padding-top: 10px">Unggah Foto/Gambar Sampah <font color='#ff0000'>*</font></label>
                            {{-- <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" value="{{old('foto')}}"/> --}}

                            <div class="position-relative">
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
                                <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
                                <div class="form-group">
                                    <style>
                                        .input-group>.btn {padding-top: 0.7rem;}
                                    </style>
                                    <div class="file-loading">
                                        <input id="foto-ambilin" type="file" name="foto" class="@error('foto') is-invalid @enderror" data-browse-on-zone-click="true">
                                    </div>
                                </div>
                                <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js" type="text/javascript"></script>
                                <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js" type="text/javascript"></script>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                                <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>
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

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="text-secondary" style="font-size: 80%; margin: 0; padding-top: 0.3rem;" disabled>Upload foto dengan ukuran maksimal 4 MB</p>

                            <!-- Keterangan -->
                            <label class="form-label" style="padding-top: 10px">Keterangan</label>
                            <textarea name="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Deskripsi...">{{ old('keterangan') }}</textarea>
                            
                            <hr style="margin-top: 1.5rem">

                            <!-- Tanggal ambil -->
                            <label class="form-label" for="tanggal_ambil" style="padding-top: 10px">Tanggal pengambilan <font color='#ff0000'>*</font></label>
                            <select class="form-select  @error('tgl_ambil') is-invalid @enderror" aria-label="tanggal_ambil" name="tgl_ambil">
                            <option value=""> Pilih tanggal pengambilan barang </option>
                                @foreach($tanggal as $tanggal)
                                <option value="{{$tanggal->id}}" {{{ ((null !== old('tgl_ambil')) && old('tgl_ambil') == $tanggal->id) ? "selected=\"selected\"" : "" }}} >{{ \Carbon\Carbon::parse($tanggal->tgl)->translatedFormat('l, d F Y') }}</option>
                                @endforeach
                            </select>
                            @error('tgl_ambil')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Waktu -->
                            <label class="form-label" for="waktu_ambil" style="padding-top: 10px">Waktu Pengambilan <font color='#ff0000'>*</font></label>
                            <select class="form-select @error('waktu_ambil') is-invalid @enderror" aria-label="waktu_ambil" name="waktu_ambil">
                            <option value=""> Pilih waktu pengambilan barang </option>
                                @foreach($waktu as $waktu)
                                <option value="{{$waktu->id}}" {{{ ((null !== old('waktu_ambil')) && old('waktu_ambil') == $waktu->id) ? "selected=\"selected\"" : "" }}} >{{$waktu->waktu}}</option>
                                @endforeach
                            </select>
                            @error('waktu_ambil')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Lokasi -->
                            <label class="form-label" for="lokasi" style="padding-top: 10px">Lokasi Pengambilan <font color='#ff0000'>*</font></label>
                            {{-- {{dd($lokasi)}} --}}
                            @if (count($lokasi) === 0)
                                <select class="form-select" aria-label="lokasi" name="idlokasi" disabled>
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
                            
                            <hr style="margin-top: 1.5rem">

                            <table class="table table-borderless table-sm" id="dynamicTable" style="margin: 0;">
                                <tr>
                                    <td class="col-7"><label class="form-label" for="jenis_sampah" style="margin: 0;">Jenis Sampah <font color='#ff0000'>*</font></label></td>
                                    <td class="col-4"><label class="form-label" for="berat" style="margin: 0;">Berat (kg) <font color='#ff0000'>*</font></label></td>
                                    <td class="text-center col-1"><label class="form-label" for="berat" style="margin: 0;">Aksi</label></td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <select class="form-select @error('sampah.0.jenis') is-invalid @enderror" name="sampah[0][jenis]">
                                        <option value=""> Pilih jenis sampah </option>
                                            @foreach($jenis as $jns)
                                            <option value="{{$jns->id}}" {{{ ((null !== old('jenis')) && old('jenis') == $jns->id) ? "selected=\"selected\"" : "" }}} style="font-size: 90%">{{$jns->nama}}</option>
                                            @endforeach
                                        </select>
                                        @error('sampah.0.jenis')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        {{-- {{dd($jenis)}} --}}
                                        {{-- {{{ ((null !== old('jenis')) && old('jenis') == $jenis->id) ? 'selected=\'selected\'' : '' }}} --}}
                                    </td>
                                    <td>
                                        {{-- <input type="text" min="1" name="sampah[0][berat]" class="form-control"
                                            minlength="1" maxlength="6" onkeypress="return hanyaAngka(event)"
                                            style="background-color:white;" value="{{ old('berat') }}" placeholder="berat..." required/> --}}
                                        <input type="number" min="1" max="99" name="sampah[0][berat]" class="form-control"
                                            style="background-color:white;" value="{{ old('berat') }}" placeholder="berat..." required>
                                        @error('sampah.0.berat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-primary" name="add" id="add"><i class="fa-solid fa-plus"></i></button>
                                    </td>
                                </tr>
                            </table>

                            <script type="text/javascript">
   
                                var i = 0;
                                   
                                $("#add").click(function(){
                               
                                    ++i;
                               
                                    $("#dynamicTable").append("<tr><td><select class='form-select @error('sampah."+i+".jenis') is-invalid @enderror' name='sampah["+i+"][jenis]'><option value=''> Pilih jenis sampah </option><?php foreach($jenis as $jns){?><option value='{{$jns->id}}'>{{$jns->nama}}</option><?php } ?></select>@error('sampah."+i+".jenis')<div class='invalid-feedback'>{{ $message }}</div>@enderror</td><td><input type='number' min='1' max='99' name='sampah["+i+"][berat]' class='form-control' style='background-color:white;' value='{{ old("berat") }}'' placeholder='berat...'' required>@error('sampah."+i+".berat')<div class='invalid-feedback'>{{ $message }}</div>@enderror</td><td class='align-middle text-center'><button type='button' class='btn btn-danger remove-tr' name='remove-tr' id='remove-tr'><i class='fa-solid fa-xmark'></i></button></td></tr>");
                                    // $("#dynamicTable").append("<tr><td><select class='form-select @error('sampah."+i+".jenis') is-invalid @enderror' name='sampah["+i+"][jenis]'><option value=''> Pilih jenis sampah </option><?php foreach($jenis as $jns){?><option value='{{$jns->id}}'>{{$jns->nama}}</option><?php } ?></select></td><td><input type='text' min='1' name='sampah["+i+"][berat]' class='form-control' minlength='1' maxlength='6' onkeypress='return hanyaAngka(event)' style='background-color:white;' value='{{ old("berat") }}' placeholder='berat...' required/></td><td class='align-middle text-center'><button type='button' class='btn btn-danger remove-tr' name='remove-tr' id='remove-tr'><i class='fa-solid fa-xmark'></i></button></td></tr>");
                                });
                               
                                $(document).on('click', '.remove-tr', function(){  
                                     $(this).parents('tr').remove();
                                });  
                               
                            </script>

                            {{-- <div class="row">
                                <div class="col-8">
                                    <!-- Jenis Sampah -->
                                    <label class="form-label" for="jenis_sampah" style="padding-top: 10px">Jenis Sampah <font color='#ff0000'>*</font></label>
                                    <select class="form-select" aria-label="jenis_sampah" name="jenis">
                                    <option value=""> Pilih jenis sampah </option>
                                        @foreach($jenis as $jenis)
                                        <option value="{{$jenis->id}}" {{{ ((null !== old('jenis')) && old('jenis') == $jenis->id) ? "selected=\"selected\"" : "" }}} >{{$jenis->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div  class="col-4">
                                    <!-- Berat -->
                                    <div class="mt-2 mb-2">
                                        <label class="form-label" for="berat">Berat (gr) <font color='#ff0000'>*</font></label>
                                        <input type="number" min="0" name="berat" id="berat" class="form-control"
                                            minlength="1" maxlength="6" onkeypress="return hanyaAngka(event)"
                                            style="background-color:white;" value="{{ old('berat') }}" placeholder="Isi berat barang..."/>
                                    </div>
                                </div>    
                            </div> --}}
                            
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}

                            <div class="mt-3">
                                <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                            </div>

                            <!-- Submit button -->
                            <br>
                            <div class="row mb-3">
                                <div class="col">
                                    <a type="button" href="ambilin" class="btn btn-danger btn-lg btn-block" style="text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Batal</a>
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
{{-- @include('partials.shortcut') --}}