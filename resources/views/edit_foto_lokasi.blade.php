@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        
                        <h5 class="form-label">Lampiran Foto Lokasi</h5>
                        <hr>

                        <form action="{{ route('update_foto_lokasi', ['id' => $wp_lokasi->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(isset($wp_lokasi->foto_lokasi))
                            <div class="mtb-4">
                                <label class="form-label" style="padding-top: 10px">Foto Lokasi Lama</label></br>
                                <img alt="{{$wp_lokasi->foto_lokasi}}" src="{!! asset('public/img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi) !!}" style="max-width: 100%"/>
                                <input name="foto_lama" type="hidden" value="{{$wp_lokasi->foto_lokasi}}" />
                            </div>
                            @endif

                            <!-- Foto Lokasi -->
                            <label class="form-label" for="foto_lokasi" style="padding-top: 10px">Unggah Foto Lokasi</label>
                            <input type="file" class="form-control" id="foto_Lokasi" name="foto_lokasi" />
                            

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
                                    <a href="{{ route('detail_lokasi', ['id' => $wp_lokasi->id]) }}" type="button" class="btn btn-danger btn-lg btn-block"
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
