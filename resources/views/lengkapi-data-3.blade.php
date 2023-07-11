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
                        
                        <h5 class="form-label">Foto KTP</h5>
                        <hr>

                        @if(isset($user->ktp))
                        <div class="mtb-4">
                            <img alt="{{$user->ktp}}" src="{!! asset('public/img/ktp/'.$user->ktp) !!}" style="max-width: 100%"/>
                        </div>
                        @endif

                        @if(isset($user->ktp))
                        <form action="{{ route('remove_ktp') }}" method="post">
                            @csrf
                        <button type="submit" class="btn btn-danger" style="font-size: 80%; margin-top: 10px;">Hapus Gambar</button>
                        </form>
                        @endif

                        <form action="{{ route('post_data_3') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- No KTP -->
                            {{-- <div class="form-outline">
                                <input type="text" name="noktp" id="noktp" class="form-control form-control-lg" minlength="16" maxlength="16" onkeypress="return hanyaAngka(event)" style="background-color:white;"/>
                                <label class="form-label" for="noktp">Nomor KTP</label>
                            </div> --}}

                            <!-- Foto KTP -->
                            <label class="form-label" for="ktp" style="padding-top: 10px">Unggah Foto KTP <font color='#ff0000'>*</font></label>
                            <input type="file" class="form-control" id="ktp" name="ktp" {{ (!empty($user->ktp)) ? "disabled" : ''}} />
                            
                            

                            {{-- <br>
                            <h5 class="form-label" style="padding-top: 20px">Berkas Bank</h5>
                            <hr>
                            <!-- Bank -->
                            <label class="form-label" for="idbank">Nama Bank</label>
                            <select class="form-select" name="idbank" id="idbank">
                                <option selected>Pilih Bank</option>
                                @foreach ($bank as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->nama }}</option>
                                @endforeach
                            </select>

                            <!-- No Rekening -->
                            <div style="padding-top: 15px">
                            <div class="form-outline">
                                <input type="text" name="no_rek" id="no_rek" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;"/>
                                <label class="form-label" for="no_rek">Nomor Rekening</label>
                            </div>
                            </div>

                            <!-- Atas nama -->
                            <div style="padding-top: 15px">
                            <div class="form-outline">
                                <input type="text" name="an_rek" id="an_rek" class="form-control form-control-lg" style="background-color:white;"/>
                                <label class="form-label" for="an_rek">Rekening Atas Nama</label>
                            </div>
                            </div> --}}

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
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
                                    <a href="{{ route('create_data_2') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        <i class="fa-solid fa-chevron-left"></i> Kembali</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                        style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Selanjutnya <i class="fa-solid fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
