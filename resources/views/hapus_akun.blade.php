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
                        <form action="{{ route('post_hapus_akun', ['id'=>auth()->user()->id])}}" method="POST">
                            @csrf
                            <h5 class="form-label">Konfirmasi Penghapusan Akun</h5>
                            <hr>
                            <div class="alert alert-danger" role="alert">
                                <h5>Perhatian!</h5>
                                <hr>
                                <p style="font-size: 80%">
                                    Menghapus akun juga akan membuat data yang tersimpan pada akun anda juga ikut terhapus. <br>
                                    Anda memiliki waktu 1 bulan untuk membatalkan penghapusan, jika tetap ingin melanjutkan silahkan isi konfirmasi Nomor WhatsApp dan Kata Sandi di bawah ini.
                                </p>
                            </div>

                            @if(session()->has('error'))
                            <br>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <br>
                            @endif

                            <!-- no_hp input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;" required/>
                                <label class="form-label" for="username">Nomor WhatsApp/KTA <font color='#ff0000'>*</font></label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password" class="form-control form-control-lg" style="background-color:white;" required/>
                                <label class="form-label" for="password">Kata Sandi <font color='#ff0000'>*</font></label>
                            </div>

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
                                <div class="col">
                                    <a href="{{ route('profile') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        Batal</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;"
                                    onclick="return confirm('Akun yang sudah terhapus tidak dapat dikembalikan.\nAnda memiliki waktu 1 bulan untuk membatalkan penghapusan,\napakah anda yakin tetap ingin menghapus akun?');">
                                    Hapus</button>
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
