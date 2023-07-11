@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            <form action="{{route('back_to_profile')}}" method="post" id="back_to_profile">
                @csrf
                <a class="navbar-brand" href="#" type="submit" onclick="document.getElementById('back_to_profile').submit()"><i class="fa-solid fa-chevron-left"></i></a>
            </form>
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{$page}}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <form action="{{ route('post_lokasi_1') }}" method="POST">
                            @csrf
                            <h5 class="form-label">Alamat Pengambilan</h5>
                            <hr>
                            {{-- <input type="hidden" name="wp_id" value="{{auth()->user()->id}}"/> --}}

                            <!-- Provinsi -->
                            <label class="form-label" for="provinsi">Provinsi <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="provinsi" id="provinsi" disabled>
                                {{-- <option selected>Pilih Provinsi</option> --}}
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov->id }}" {{{ (isset($prov->id) && $prov->id == 33) ? "selected=\"selected\"" : "" }}}>{{ $prov->name }}</option>
                                @endforeach
                            </select>
                            {{-- <select class="form-select" name="provinsi" id="provinsi" disabled>
                                <option value="{{$prov->id}}" selected>{{$prov->name}}</option>
                            </select> --}}
                            <input type="hidden" name="idprov" value="33"/>

                            <!-- Kabupaten -->
                            <label class="form-label" for="kabupaten" style="padding-top: 10px">Kabupaten/Kota <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kabupaten" id="kabupaten" disabled>
                                @foreach ($kabupaten as $kab)
                                    <option value="{{ $kab->id }}" {{{ (isset($kab->id) && $kab->id == 3374) ? "selected=\"selected\"" : "" }}}>{{ $kab->name }}</option>
                                @endforeach
                            </select>
                            {{-- <select class="form-select" name="provinsi" id="provinsi" disabled>
                                <option value="{{$kab->id}}" selected>{{$kab->name}}</option>
                            </select> --}}
                            <input type="hidden" name="idkab" value="3374"/>

                            <!-- Kecamatan -->
                            <label class="form-label" for="kecamatan" style="padding-top: 10px">Kecamatan <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kecamatan" id="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatan as $kec)
                                <option value="{{$kec->id}}" {{{ (isset($wp_lokasi->idkec) && $wp_lokasi->idkec == $kec->id) ? "selected=\"selected\"" : "" }}}>{{$kec->name}}</option>
                                @endforeach
                            </select>

                            <!-- Kelurahan -->
                            <label class="form-label" for="kelurahan" style="padding-top: 10px">Kelurahan <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kelurahan" id="kelurahan">
                                <option value="">Pilih Kelurahan</option>
                            </select>

                            <!-- Alamat -->
                            <label class="form-label" for="alamat_lokasi" style="padding-top: 10px">Alamat <font color='#ff0000'>*</font></label>
                            <textarea name="alamat_lokasi" aria-label="alamat_lokasi" name="alamat_lokasi" class="form-control" rows="3" placeholder="Alamat Lokasi..."
                                required>{{ $wp_lokasi->alamat_lokasi ?? '' }}</textarea>

                            <!-- Kode Pos -->
                            <div class="form-outline mt-3 mb-4">
                                <input type="text" name="kode_pos" id="kode_pos" class="form-control form-control-lg"
                                    minlength="5" maxlength="5" onkeypress="return hanyaAngka(event)"
                                    style="background-color:white;" value="{{ $wp_lokasi->kode_pos ?? '' }}"/>
                                <label class="form-label" for="kode_pos">Kode Pos</label>
                            </div>

                            <!-- Nama Lokasi -->
                            <div class="form-outline mt-">
                                <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control form-control-lg"
                                    style="background-color:white;" value="{{ $wp_lokasi->nama_lokasi ?? '' }}"/>
                                <label class="form-label" for="nama_lokasi">Nama Lokasi <font color='#ff0000'>*</font></label>
                            </div>
                            <div class="mb-4">
                                <p style="font-size: 80%;" class="text-secondary">Nama lokasi dapat berupa Rumah, Kantor, dan lain sebagainya</p>
                            </div>

                            <!-- Jenis Lokasi -->
                            <label class="form-label" for="jenis_lokasi" style="padding-top: 10px">Jenis Lokasi <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="idlokasijenis" id="jenis_lokasi" required>
                                <option value="">Pilih Jenis Lokasi</option>
                                @foreach ($jenis_lokasi as $lokjenis)
                                <option value="{{$lokjenis->id}}" {{{ (isset($wp_lokasi->idlokasijenis) && $wp_lokasi->idlokasijenis == $lokjenis->id) ? "selected=\"selected\"" : "" }}}>{{$lokjenis->jenis_lokasi}}</option>
                                @endforeach
                            </select>

                            <!-- Alamat -->
                            <label class="form-label" for="catatan" style="padding-top: 10px">Catatan</label>
                            <textarea name="catatan" aria-label="catatan" name="catatan" class="form-control" rows="3" placeholder="Catatan Lokasi..."></textarea>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-3 mb-3">
                              <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                            </div>

                            <!-- Submit button -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    {{-- <a href="{{ route('profile') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Batal</a> --}}
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Selanjutnya <i class="fa-solid fa-chevron-right"></i></button>
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

    <script>
        $(function () {
          $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
          });
      
        //   $(function() {
        //     $('#provinsi').on('change', function() {
        //       let provID = $('#provinsi').val();
                
        //       $.ajax({
        //         type : 'POST',
        //         dataType: "html",
        //         url : "getkabupaten",
        //         data : {provID:provID},
        //         cache : false,
      
        //         success: function(msg) {
        //           $('#kabupaten').html(msg);
        //           $("#kecamatan").html("<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'><option>Pilih Kecamatan</option></select>");
        //           $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
        //         },
      
        //         error: function(data){
        //           console.log('error: ', data)
        //         },
      
        //       })
        //     })
        //   })

      
        //   $(function() {
        //     $('#kabupaten').on('change', function() {
        //       let kabID = $('#kabupaten').val();
      
        //       $.ajax({
        //         type : 'POST',
        //         dataType: "html",
        //         url : "getkecamatan",
        //         data : {kabID:kabID},
        //         cache : false,
      
        //         success: function(msg) {
        //           $('#kecamatan').html(msg);
        //           $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
        //         },
      
        //         error: function(data){
        //           console.log('error: ', data)
        //         },
      
        //       })
        //     })
        //   })


          $(function() {
            $('#kecamatan').on('change', function() {
              let kecID = $('#kecamatan').val();
      
              $.ajax({
                type : 'POST',
                dataType: "html",
                url : "getkelurahan",
                data : {kecID:kecID},
                cache : false,
      
                success: function(msg) {
                  $('#kelurahan').html(msg);
                },
      
                error: function(data){
                  console.log('error: ', data)
                },
      
              })
            })
          })

          $(function() {
            var kecID = $('#kecamatan').val();
            if ('null' != kecID) {$(function() {
              let kecID = $('#kecamatan').val();
      
              $.ajax({
                type : 'POST',
                dataType: "html",
                url : "getkelurahan",
                data : {kecID:kecID},
                cache : false,
      
                success: function(msg) {
                  $('#kelurahan').html(msg);
                },
      
                error: function(data){
                  console.log('error: ', data)
                },
      
              })
            })}
          })
      
        });
      
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        
      </script>

      
@endsection
