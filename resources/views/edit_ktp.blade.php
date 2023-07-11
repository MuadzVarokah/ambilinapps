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
                        
                        <h5 class="form-label">Berkas KTP</h5>
                        <hr>

                        <form action="{{ route('update_ktp') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Foto Lama -->
                            @if(isset($user->ktp))
                            <div class="mtb-4">
                                <label class="form-label" style="padding-top: 10px">Foto Lama</label></br>
                                <img alt="{{$user->ktp}}" src="{!! asset('public/img/ktp/'.$user->ktp) !!}" style="max-width: 100%"/>
                                <input name="foto_lama" type="hidden" value="{{$user->ktp}}" />
                            </div>
                            @endif

                            <!-- Foto KTP -->
                            <label class="form-label" for="ktp" style="padding-top: 10px">Unggah Foto KTP <font color='#ff0000'>*</font></label>
                            <input type="file" class="form-control" id="ktp" name="ktp"/>

                            <!-- No KTP -->
                            <div class="form-outline mt-4 mb-4">
                                <input type="text" name="no_ktp" id="no_ktp" value="{{ $user->no_ktp }}" class="form-control form-control-lg" minlength="16" maxlength="16" onkeypress="return hanyaAngka(event)" style="background-color:white;" required/>
                                <label class="form-label" for="noktp">Nomor KTP <font color='#ff0000'>*</font></label>
                            </div>
                            
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
                                    <a href="{{ route('profile') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Batal</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
