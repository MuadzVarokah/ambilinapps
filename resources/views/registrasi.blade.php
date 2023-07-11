@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
    <div class="container">
        <section class="vh-100">
            <div class="container py-4 h-100">
                <div class="row d-flex align-items-start justify-content-center h-100">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        {{-- <p class="text-center">Daftar Sebagai Member</p>
                        <br> --}}
                        <form action="registrasi" method="post">
                            @csrf
                            <!-- Nama input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="nama" id="nama" class="form-control form-control-lg @error('nama') is-ivalid @enderror"
                                    style="background-color:white;" required/>
                                <label class="form-label" for="nama">Nama Panggilan</label>
                            </div>
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <!-- no_wa input -->
                            <div class="form-outline mb-4">
                                {{-- <input type="text" name="no_wa" id="no_wa" class="form-control form-control-lg @error('no_wa') is-ivalid @enderror"
                                    style="background-color:white;" minlength="9" maxlength="14" onkeypress="return hanyaAngka(event)" required/> --}}
                                <input type="tel" name="no_wa" id="no_wa" class="form-control form-control-lg @error('no_wa') is-ivalid @enderror"
                                pattern="[0-9]{}" maxlength="14" minlength="9" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                                <label class="form-label" for="no_wa">Nomor WhatsApp</label>
                            </div>
                            @error('no_wa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password" class="form-control form-control-lg @error('password') is-ivalid @enderror"
                                    style="background-color:white;" minlength="6" required/>
                                <label class="form-label" for="password">Password</label>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            <!-- Konf-Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control form-control-lg @error('password_confirmation') is-ivalid @enderror" style="background-color:white;" minlength="6" required/>
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            {{-- <hr> --}}
                            <div>
                                <label class="form-label" for="kat_user">Daftar Sebagai:</label>
                                <div class="row d-flex justify-content-around">
                                    @foreach ($kat as $kat1)
                                    @if ($loop->first)
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kat_user" id="{{$kat1->id}}" value="{{$kat1->id}}" checked/>
                                            <label class="form-check-label" for="{{$kat1->id}}" style="font-weight: 600;">{{$kat1->kat}}</label>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kat_user" id="{{$kat1->id}}" value="{{$kat1->id}}"/>
                                            <label class="form-check-label" for="{{$kat1->id}}" style="font-weight: 600;">{{$kat1->kat}}</label>
                                        </div>
                                    </div>                                        
                                    @endif
                                    @endforeach
                                    {{-- <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kat_user" id="1" value="1" checked/>
                                            <label class="form-check-label" for="1" style="font-weight: 600;">Member (Mitra)</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kat_user" id="3" value="3"/>
                                            <label class="form-check-label" for="3" style="font-weight: 600;">Bank Sampah</label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kat_user" id="2" value="2"/>
                                            <label class="form-check-label" for="2" style="font-weight: 600;">Kolektor</label>
                                        </div>
                                    </div> --}}
                                </div>
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

                            <script>
                                function hanyaAngka(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode
                                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                                        return false;
                                    return true;
                                }
                            </script>

                            <!-- Submit button -->
                            <br>
                            <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 100%; font-weight: bold; padding: 1rem 0;">Registrasi</button>

                            <div class="d-flex justify-content-start align-items-start mb-4" style="padding-top: 10px">
                                <p>Sudah punya akun? Silahkan <a class="text-success" href="/ambilinapps">login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
