@extends('layouts.default')

@section('content')
<!-- Navbar -->
@include('partials.navbar_back')
<!-- Navbar end -->
<!--content-->
<div class="container">
    <section class="vh-100">
        <div class="container py-4 h-100">
            <div class="row d-flex align-items-start justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <p class="text-center">Jangan khawatir, anda dapat mengubah password di sini</p>
                    <br>
                        @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                          <br>
                        @endif
                              
                        <form class="form" action="{{route('post_forgot')}}" method="post">
                            @csrf
                        <div class="form-outline mb-4">
                            <input type="text" id="momor_wa" name="no_wa" class="form-control form-control-lg" onkeypress="return hanyaAngka(event)" style="background-color:white;" maxlength="14" required/>
                            <label class="form-label" for="momor_wa">Isi nomor WhatsApp</label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 100%; font-weight: bold; padding: 1rem 0;">Kirim</button>
                        </form>

                        <script>
                            function hanyaAngka(evt) {
                                var charCode = (evt.which) ? evt.which : event.keyCode
                                if (charCode > 31 && (charCode < 48 || charCode > 57))
                                    return false;
                                return true;
                            }
                        </script>
                              
                </div>
            </div>
        </div>
    </section>
</div>
    <!-- Content End -->
@endsection 