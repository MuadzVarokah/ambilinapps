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
                        <form action="{{ route('post_data_1') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5 class="form-label">Data Diri</h5>
                            <hr>
                            <!-- No KTP -->
                            <div class="form-outline mb-4">
                                <input type="text" name="no_ktp" id="no_ktp" value="{{ $user->no_ktp ?? '' }}{{ old('no_ktp') }}" class="form-control form-control-lg" minlength="16" maxlength="16" onkeypress="return hanyaAngka(event)" style="background-color:white;" required/>
                                <label class="form-label" for="noktp">Nomor KTP <font color='#ff0000'>*</font></label>
                            </div>

                            <!-- Nama input -->
                            {{-- <div class="form-outline mb-4">
                                <input type="text" name="nama" id="nama" value="{{ $user->nama ?? '' }}{{ old('nama') }}" class="form-control form-control-lg" style="background-color:white;" required/>
                                <label class="form-label" for="nama">Nama Panggilan</label>
                            </div> --}}

                            <!-- Nama Lengkap input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    class="form-control form-control-lg" value="{{ $user->nama_lengkap ?? '' }}{{ old('nama_lengkap') }}" style="background-color:white;" required/>
                                <label class="form-label" for="nama_lengkap">Nama Lengkap <font color='#ff0000'>*</font></label>
                            </div>

                            <!-- no_hp input -->
                            {{-- <div class="form-outline mb-4">
                                <input type="text" name="no_wa" id="no_wa" value="{{ $user->no_wa ?? '' }}{{ old('no_wa') }}" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;"/>
                                <label class="form-label" for="no_wa">Nomor HP</label>
                            </div> --}}

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="email" value="{{ $user->email ?? '' }}{{ old('email') }}" class="form-control form-control-lg" style="background-color:white;"/>
                                <label class="form-label" for="email">email</label>
                            </div>

                            <!-- TL & JK input -->
                            <div class="row d-flex justify-content-between">
                                <div class="col-auto" style="padding-top: 10px">
                                    <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir"
                                    class="form-control form-control-md" value="{{ $user->tgl_lahir ?? '' }}"/>
                                </div>
                                <div class="col-auto" style="padding-top: 10px">
                                    <label class="form-label" for="jk">Jenis Kelamin</label>
                                    <div class="row" style="padding-top: 5px">
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="L" value="L" {{{ (isset($user->sex) && $user->sex == 'L') ? "checked" : "" }}}/>
                                                <label class="form-check-label" for="L">L</label>
                                              </div>
                                              
                                              <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sex" id="P" value="P" {{{ (isset($user->sex) && $user->sex == 'P') ? "checked" : "" }}}/>
                                                <label class="form-check-label" for="P">P</label>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pekerjaan -->
                            <label class="form-label" for="idpekerjaan" style="padding-top: 10px">Pekerjaan</label>
                            <select class="form-select" name="idpekerjaan" id="idpekerjaan">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach ($pekerjaan as $kerja)
                                <option value="{{ $kerja->id }}"{{{ (isset($user->idpekerjaan) && $user->idpekerjaan == $kerja->id) ? "selected=\"selected\"" : "" }}}>{{$kerja->pekerjaan}}</option>
                                @endforeach
                            </select>

                            <!-- Pendidikan -->
                            <label class="form-label" for="idpendidikan" style="padding-top: 10px">Pendidikan Terakhir</label>
                            <select class="form-select" name="idpendidikan">
                                <option value="">Pilih Pendidikan</option>
                                @foreach ($pendidikan as $didik)
                                <option value="{{ $didik->id }}"{{{ (isset($user->idpendidikan) && $user->idpendidikan == $didik->id) ? "selected=\"selected\"" : "" }}}>{{$didik->pendidikan}}</option>
                                @endforeach
                            </select>

                            <!-- Foto Diri -->
                            {{-- <label class="form-label" for="file_foto_diri" style="padding-top: 10px">Unggah Foto Diri</label>
                            <input type="file" class="form-control" id="file_foto_diri" name="file_foto_diri" value="{{ $user->file_foto_diri ?? '' }}"/> --}}

                            @if ($errors->any())
                            <div class="form-outline mt-4">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <div class="mt-3 mb-3">
                                <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                              </div>

                            <!-- Submit button -->
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    {{-- <button type="submit" class="btn btn-danger btn-lg btn-block" style="font-size: 80%">< Kembali</button> --}}
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
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
@endsection
