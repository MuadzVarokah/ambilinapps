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
                        <form action="{{ route('update_wa') }}" method="POST">
                            @csrf
                            <h5 class="form-label">Nomor WhatsApp Baru</h5>
                            <hr>
                            <div class="alert alert-danger" role="alert">
                                <h5>Perhatian!</h5>
                                <hr>
                                <p style="font-size: 80%">Mengubah Nomor WhatsApp akan mempengaruhi cara masuk anda, selalu ingat perubahan yang anda lakukan!</p>
                            </div>
                            <!-- no_hp input -->
                            <div class="form-outline mb-4">
                                <input type="text" name="no_wa" id="no_wa" value="{{ $user->no_wa }}" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;"/>
                                <label class="form-label" for="no_wa">Nomor WhatsApp <font color='#ff0000'>*</font></label>
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
                                    onclick="return confirm('Apakah anda yakin ingin mengubah Nomor WhatsApp?');">Ubah</button>
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
