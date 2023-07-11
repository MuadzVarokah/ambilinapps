@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <form action="{{ route('update_domisili') }}" method="POST">
                            @csrf
                            <h5 class="form-label">Alamat Tempat Tinggal</h5>
                            <hr>
                            {{-- Seluruh Provinsi --}}
                            {{-- <!-- Provinsi -->
                            <label class="form-label" for="provinsi">Provinsi <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="provinsi" id="provinsi">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($prov as $prov)
                                    <option value="{{ $prov->id }}" {{{ (isset($user->idprov) && $user->idprov == $prov->id) ? "selected=\"selected\"" : "" }}}>{{ $prov->name }}</option>
                                @endforeach
                            </select>

                            <!-- Kabupaten -->
                            <label class="form-label" for="kabupaten" style="padding-top: 10px">Kabupaten/Kota <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kabupaten" id="kabupaten">
                                <option value="{{$user->idkab}}">Pilih Kabupaten</option>
                            </select>

                            <!-- Kecamatan -->
                            <label class="form-label" for="kecamatan" style="padding-top: 10px">Kecamatan <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kecamatan" id="kecamatan">
                                <option value="{{$user->idkec}}">Pilih Kecamatan</option>
                            </select> --}}
                            {{-- END Seluruh Provinsi --}}

                            {{-- Kota Semarang --}}
                            @if (($user->idprov == $provinsi2->id) && ($user->idkab == $kabupaten2->id))
                              <!-- Provinsi -->
                              <label class="form-label" for="provinsi">Provinsi <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="provinsi" id="provinsi" disabled>
                                <option value="{{ $provinsi->id }}" selected>{{ $provinsi->name }}</option>
                              </select>
                              <input type="hidden" name="provinsi" value="{{ $provinsi->id }}"/>

                              <!-- Kabupaten -->
                              <label class="form-label" for="kabupaten" style="padding-top: 10px">Kabupaten <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="kabupaten" id="kabupaten" disabled>
                                <option value="{{ $kabupaten->id }}" selected>{{ $kabupaten->name }}</option>
                              </select>
                              <input type="hidden" name="kabupaten" value="{{ $kabupaten->id }}"/>

                              <!-- Kecamatan -->
                              <label class="form-label" for="kecamatan" style="padding-top: 10px">Kecamatan <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="kecamatan" id="kecamatan">
                                  <option selected>Pilih Kecamatan</option>
                                  @foreach ($kecamatan2 as $kec)
                                      <option value="{{ $kec->id }}" {{{ (isset($user->idkec) && $user->idkec == $kec->id) ? "selected=\"selected\"" : "" }}}>{{ $kec->name }}</option>
                                  @endforeach
                              </select>
                            @elseif (($user->idprov != $provinsi2->id) || ($user->idkab != $kabupaten2->id))
                              <!-- Provinsi -->
                              <label class="form-label" for="provinsi">Provinsi <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="provinsi" id="provinsi">
                                @if ($provinsi->id == $provinsi2->id)
                                  <option value="{{ $provinsi->id }}" selected>{{ $provinsi->name }}</option>
                                @else
                                  <option value="{{ $provinsi->id }}" selected>{{ $provinsi->name }}</option>
                                  <option value="{{ $provinsi2->id }}">{{ $provinsi2->name }}</option>
                                @endif
                              </select>

                              <!-- Kabupaten -->
                              <label class="form-label" for="kabupaten" style="padding-top: 10px">Kabupaten <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="kabupaten" id="kabupaten">
                                <option value="{{$user->idkab}}">Pilih Kabupaten</option>
                              </select>

                              <!-- Kecamatan -->
                              <label class="form-label" for="kecamatan" style="padding-top: 10px">Kecamatan <font color='#ff0000'>*</font></label>
                              <select class="form-select" name="kecamatan" id="kecamatan">
                                <option value="{{$user->idkec}}">Pilih Kecamatan</option>
                              </select>
                            @endif
                            
                            {{-- END Kota Semarang --}}

                            <!-- Kelurahan -->
                            <label class="form-label" for="kelurahan" style="padding-top: 10px">Kelurahan <font color='#ff0000'>*</font></label>
                            <select class="form-select" name="kelurahan" id="kelurahan">
                                <option value="{{$user->idkel}}">Pilih Kelurahan</option>
                            </select>

                            <!-- Alamat -->
                            <label class="form-label" for="alamat" style="padding-top: 10px">Alamat <font color='#ff0000'>*</font></label>
                            <textarea name="alamat" aria-label="alamat" name="alamat" class="form-control" rows="3" placeholder="Alamat..."
                                required>{{ $user->alamat_lokasi ?? '' }}</textarea>

                            <!-- Kode Pos -->
                            <div class="form-outline mt-3 mb-4">
                                <input type="text" name="kodepos" id="kodepos" class="form-control form-control-lg"
                                    minlength="5" maxlength="5" onkeypress="return hanyaAngka(event)"
                                    style="background-color:white;" value="{{ $user->kodepos ?? '' }}"/>
                                <label class="form-label" for="kodepos">Kode Pos</label>
                            </div>

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
                                    <a href="{{ route('profile') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Batal</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">Ubah</button>
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
      
          $(function() {
            $('#provinsi').on('change', function() {
              let provID = $('#provinsi').val();
                
              $.ajax({
                type : 'POST',
                dataType: "html",
                url : "getkabupaten3",
                data : {
                  provID:provID,
                  kabID:{{$user->idkab}},
                },
                cache : false,
      
                success: function(msg) {
                  $('#kabupaten').html(msg);
                  $("#kecamatan").html("<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'><option>Pilih Kecamatan</option></select>");
                  $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
                },
      
                error: function(data){
                  console.log('error: ', data)
                },
      
              })
            })
          })
      
          $(function() {
            $('#kabupaten').on('change', function() {
              let kabID = $('#kabupaten').val();
      
              $.ajax({
                type : 'POST',
                dataType: "html",
                url : "getkecamatan",
                data : {kabID:kabID},
                cache : false,
      
                success: function(msg) {
                  $('#kecamatan').html(msg);
                  $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
                },
      
                error: function(data){
                  console.log('error: ', data)
                },
      
              })
            })
          })

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
            var provID = $('#provinsi').val();
            if ('null' != provID) {$(function() {
              let provID = $('#provinsi').val();

              // console.log('get kabupaten');
              $.ajax({
                type : 'POST',
                dataType: "html",
                url : "getkabupaten3",
                data : {
                  provID:provID,
                  kabID:{{$user->idkab}},
                },
                cache : false,
      
                success: function(msg) {
                  $('#kabupaten').html(msg);
                  $("#kecamatan").html("<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'><option>Pilih Kecamatan</option></select>");
                  $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
                },
      
                error: function(data){
                  console.log('error: ', data)
                },
      
              })
            })}

            $(function kabupaten() {
                var kabID = $('#kabupaten').val();
                if ('null' != kabID) {$(function() {
                let kabID = $('#kabupaten').val();
        
                setTimeout( function(){
                  // console.log('get kecamatan');
                  $.ajax({
                      type : 'POST',
                      dataType: "html",
                      url : "getkecamatan",
                      data : {kabID:kabID},
                      cache : false,
          
                      success: function(msg) {
                      $('#kecamatan').html(msg);
                      $("#kelurahan").html("<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'><option>Pilih Kelurahan</option></select>");
                      },
          
                      error: function(data){
                      console.log('error: ', data)
                      },
          
                  })
                },250 );
                })}

                $(function kecamatan() {
                    var kecID = $('#kecamatan').val();
                    if ('null' != kecID) {$(function() {
            
                    setTimeout( function(){
                      // console.log('get kelurahan');
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
                    }, 500 );
                    })}
                })
            })
          })
      
        });
      
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        });
        
      </script>

      
@endsection
