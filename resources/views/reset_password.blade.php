@extends('layouts.default')

@section('content')
<!-- Navbar -->
@include('partials.navbar_back')
<!-- Navbar end -->
<!--content-->
<div style="width:100%">
    <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert">
        <div class="row">
            <div class="col-12" style="padding:0%;">
                <div class="col" style="text-align: center">
                    <div class="container">
                        <p style="font-size: 90%">Ganti password anda secara rutin untuk meningkatkan keamanan dari akun anda.</p>
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
                    @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form class="form" action="{{route('post_password')}}" method="post">
                    @csrf
                        <div class="form-outline mb-4">
                            <input type="password" id="password_lama" name="password_lama" class="form-control form-control-lg" style="background-color:white;" required/>
                            <label class="form-label" for="password_lama">Password Lama</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control form-control-lg" style="background-color:white;" required/>
                            <label class="form-label" for="password">Password Baru</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" style="background-color:white;" required/>
                            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg btn-block" style="text-transform: capitalize; font-size: 100%; font-weight: bold; padding: 1rem 0;">Ganti</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
    <!-- Content End -->
@endsection 
{{-- @include('partials.shortcut') --}}