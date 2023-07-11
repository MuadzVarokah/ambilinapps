@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <!--content-->
    <div style="width:100%">
        <div class="container" style="padding-top:1rem">
            
            @foreach ($notifikasi as $data)
                <div class="alert alert-{{ $data->theme }}">
                    <small>
                        <b>{{ $data->judul }}</b> | {{ $translated_now }} <br>
                        {{$data->isi}} <br>
                    </small>
                </div>
            @endforeach

            {{-- <div class="alert alert-danger">
                <small>
                    <b>verifikasi user</b> | 20 Des 22 08:09<br>
                    Selamat yaa..., akun anda sudah terverifikasi<br>
                </small>
            </div>

            <div class="alert alert-success">
                <small>
                    <b>ambilin</b> | 20 Des 22 08:09<br>
                    Terimakasih telah request layanan ambil sampah, tunggu kolektor kami ya...<br>

                </small>
            </div>

            <div class="alert alert-info">
                <small>
                    <b>Paskas</b> | 20 Des 22 08:09<br>
                    Selamat, Barang Paskas Anda sudah publish<br>
                </small>
            </div>

            <div class="alert alert-warning">
                <small>
                    <b>Sebar</b> | 20 Des 22 08:09<br>
                    Selamat, Barang Sebar sudah publish<br>
                </small>
            </div> --}}
            <div class="mx-auto justify-content-center d-flex">
                {{ $notifikasi->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var now = '<?php echo "$now"; ?>';
        setInterval(function() {
            $.ajax({
                type: "GET",
                url: "https://ambilin.com/ambilinapps/notif-cek/" + now +"", // You add the id of the post and the update datetime to the url as well
                success: function(response) {
                    // If not false, update the post
                    if (response) {
                        location.reload();
                    }
                }
            });
        }, 60000); // Do this every 60 seconds
    });
    </script>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
