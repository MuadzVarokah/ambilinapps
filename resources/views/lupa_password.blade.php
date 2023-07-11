@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #176e41;">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            <p style="padding:0 12px">&nbsp;</p>
            <h5 class="navbar-brand" style="margin:0">Ganti Kata Sandi</h5>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <!--content-->
    <div style="width:100%">
        <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert">
            <div class="row">
                <div class="col-12" style="padding:0%;">
                    <div class="col" style="text-align: center">
                        <div class="container">
                            <p style="font-size: 90%">Ubah kata sandi akun anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <section class="vh-100">
            <div class="container py-2 h-100">
                <div class="row d-flex align-items-start justify-content-center h-100">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

                        <form class="form" action="{{ route('update_password') }}" method="POST">
                            @csrf
                            @if (request('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <div class="form-outline mb-4">
                                <input type="text" id="no_wa" name="no_wa" maxlength="14"
                                    class="form-control form-control-lg @error('no_wa') is-ivalid @enderror"
                                    style="background-color:white;" required />
                                <label class="form-label" for="no_wa">No WA</label>
                            </div>
                            @error('no_wa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-outline mb-4">
                                <input type="password" id="pwd_baru" name="password" minlength="6"
                                    class="form-control form-control-lg @error('password') is-ivalid @enderror"
                                    style="background-color:white;" required />
                                <label class="form-label" for="pwd_baru">Password Baru</label>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <div class="form-outline mb-4">
                                <input type="password" id="konf_pwd_baru" name="password_confirmation" minlength="6"
                                    class="form-control form-control-lg @error('password_confirmation') is-ivalid @enderror"
                                    style="background-color:white;" required />
                                <label class="form-label" for="konf_pwd_baru">Konfirmasi Password Baru</label>
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 100%; font-weight: bold; padding: 1rem 0;">Ubah</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Content End -->
@endsection
