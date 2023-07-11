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
                        
                        <h5 class="form-label">Lampiran Foto Lokasi</h5>
                        <hr>

                        @if(isset($wp_lokasi->foto_lokasi))
                        <div class="mtb-4">
                            <img alt="{{$wp_lokasi->foto_lokasi}}" src="{!! asset('public/img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi) !!}" style="max-width: 100%"/>
                        </div>
                        <form action="{{ route('remove_foto_lokasi') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="font-size: 80%; margin-top: 10px;">Hapus Gambar</button>
                        </form>
                        @endif

                        <form action="{{ route('post_lokasi_3') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Foto Lokasi -->
                            <label class="form-label" for="foto_lokasi" style="padding-top: 10px">Unggah Foto Lokasi</label>
                            <input type="file" class="form-control" id="foto_Lokasi" name="foto_lokasi" {{ (!empty($wp_lokasi->foto_lokasi)) ? "disabled" : ''}} />
                            

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- <div class="mt-3 mb-3">
                                <p style="font-size: 80%; color: #ff0000;">Kolom dengan tanda bintang (*) wajib diisi</p>
                            </div> --}}

                            <!-- Submit button -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('tambah_lokasi_2') }}" type="button" class="btn btn-danger btn-lg btn-block"
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