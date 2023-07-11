@extends('layouts.default')

@section('content')
    <div class="container">
        <section class="vh-100">
            <div class="container py-5 h-100">
                <div class="row d-flex align-items-center justify-content-center h-100">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="{!! asset('https://ambilin.com/img/png/ambilinlogo_text.png') !!}" class="img-fluid" alt="Ambilin">
                    </div>
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <br>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <br>
                        @endif
                        @if (session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! session('loginError') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <br>
                        @endif
                        <form action="login" method="POST">
                            @csrf
                            <p style="font-size: 90%; color: grey; margin-bottom: 10px;">Login ke akun anda</p>
                            <!-- Username input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="username" id="username"
                                    class="form-control form-control-lg @error('username') is-ivalid @enderror"
                                    style="background-color:#dcdddd;" required />
                                {{-- <input type="tel" name="username" id="username"
                                    class="form-control form-control-lg @error('username') is-ivalid @enderror"
                                    style="background-color:#dcdddd;" pattern="[0-9]{}" maxlength="14" minlength="9"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'required /> --}}
                                <label class="form-label" for="username" style="font-weight: normal;">Nomor telepon atau
                                    KTA*</label>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <!-- Password input -->
                            <div class="input-group mb-4 d-flex justify-content-between">
                                <div class="form-outline flex-fill mb-2">
                                    <input type="password" name="password" id="password"
                                        class="form-control form-control-lg @error('password') is-ivalid @enderror"
                                        style="background-color:#dcdddd;" required />
                                    <label class="form-label" for="username" style="font-weight: normal;">Kata sandi</label>
                                </div>
                                <button class="btn btn-outline-secondary btn-lg mb-2" type="button"
                                    style="padding-left: 0.75rem; padding-right: 0.75rem;" id="togglePassword"
                                    onclick="changeIcon(this)">
                                    <i class="fa fa-eye m-auto"></i>
                                </button>
                            </div>
                            <script>
                                const togglePassword = document.querySelector('#togglePassword');
                                const password = document.querySelector('#password');

                                togglePassword.addEventListener('click', function(e) {
                                    // toggle the type attribute
                                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                                    password.setAttribute('type', type);
                                    // toggle the eye slash icon
                                    // this.classList.toggle('fa-eye-slash');
                                });

                                function changeIcon(anchor) {
                                    var icon = anchor.querySelector("i");
                                    icon.classList.toggle('fa-eye');
                                    icon.classList.toggle('fa-eye-slash');

                                    // anchor.querySelector("span").textContent = icon.classList.contains('fa-eye') ? "Show" : "Hide";
                                }
                            </script>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <p style="font-size: 90%; color: grey;">*Nomor telepon untuk User Ambilin, KTA untuk Mitra
                                Perosok</p>

                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <!-- Checkbox -->
                                <style>
                                    .form-check-input:focus {
                                        border-color: #91ba04;
                                        background-color: #1a7019;
                                        outline: 0;
                                        box-shadow: 0 0 0 0.25rem rgb(145 186 4 / 25%);
                                    }

                                    .form-check-input[type=checkbox]:checked:focus {
                                        background-color: #1a7019;
                                    }

                                    .form-check-input[type=checkbox]:checked {
                                        background-color: #1a7019;
                                        border-color: #91ba04;
                                        background-image: none;
                                    }
                                </style>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="remember"
                                        id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">Ingat Saya</label>
                                </div>
                                <a href="forgot" style="text-decoration: none; color: #91bc06;">Lupa kata sandi?</a>
                            </div>

                            <div class="d-flex justify-content-start align-items-start" style="padding-top: 10px">
                                <p>Belum mendaftar? <a href="registrasi" style="text-decoration: none; color: #91bc06;">Buat
                                        akun baru</a></p>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-lg btn-block mb-4"
                                style="text-transform: capitalize; background-color: #176e41; color: white; font-size: 100%; padding: 1rem 0;">
                                <b>Masuk</b>
                            </button>
                        </form>
                        <div class="mt-4">
                            {{-- <img src="{!! asset('public/img/logo_sponsor.png') !!}" class="img-fluid" alt="Sponsor"> --}}
                            <img src="{!! asset('https://ambilin.com/img/jpg/ambilinbg.jpg') !!}" class="img-fluid" alt="Sponsor">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
