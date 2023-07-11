@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_paskas')
    <!-- Navbar end -->
    <!--content-->
    @if($count_amb < 3)
    <div class='container'style="width:100%;padding-top:1rem">
        <div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
            @php
                $downcount = 3 - $count_amb;
            @endphp
            <p>Fitur Paskas saat ini belum tersedia.
                Fitur ini akan terbuka setelah anda melakukan transaksi Ambilin sebanyak 3 kali.
                Saat ini anda sudah melakukan transaksi sebanyak {{$count_amb}} kali dan perlu melakukan
                {{$downcount}} transaksi lagi <a href="ambilin"> disini</a>.
            </p>
        </div>
    </div>
    @else
    <div style="width:100%; padding-bottom: 1rem">
        <div style="padding-top:1rem; padding-bottom:1rem" class="container d-flex justify-content-between">
            <a href="{{ route('paskas_jualan') }}" role="button" class="btn btn-success" style="width: 86%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">Jualanku</a>
            <button role="button" class="btn btn-success" style="width: 11%; font-weight: 600;" id="infoPaskasBtn"><i class="fa-solid fa-circle-info"></i></button>
        </div>
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x" style="padding-top: 4.4rem;">
            <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" id="infoPaskas" style="font-weight: 600;">
                <div class="d-flex">
                <div class="toast-body">
                    Produk  Pasar Barang Bekas Pilihan
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            const toastTrigger = document.getElementById('infoPaskasBtn')
            const toastLiveExample = document.getElementById('infoPaskas')
            if (toastTrigger) {
                toastTrigger.addEventListener('click', () => {
                    const toast = new bootstrap.Toast(toastLiveExample)

                    toast.show()
                })
            }
        </script>
        {{-- <div class="alert alert-danger d-flex justify-content-center align-items-center" role="alert">
            <p>Produk Pasar Barang Bekas Pilihan</p>
        </div> --}}
        <div class="container">
            <div class="row" style="margin: 0;">
                <div class="col-auto"
                    style="font-weight:bold; width:auto; margin-top: 0.25rem;">
                    Filter :</div>
                @if (isset($fil_kata))
                    <div class="card col-auto" style="width:auto; margin-top: 0.25rem;">
                        Kata kunci : {{ $fil_kata }}
                    </div>&ensp;
                @endif
                @if (isset($fil_jenis))
                    <div class="card col-auto" style="width:auto; margin-top: 0.25rem;">
                        Jenis : {{ $fil_jenis->jenis }}
                    </div>&ensp;
                @else
                    <div class="card col-auto" style="width:auto; margin-top: 0.25rem;">
                        Jenis : Semua
                    </div>&ensp;
                @endif
                @if (isset($fil_kondisi))
                <div class="card col-auto" style="width:auto; margin-top: 0.25rem;">
                    Kondisi : {{ $fil_kondisi->kondisi }}
                </div>&ensp;
                @else
                <div class="card col-auto" style="width:auto; margin-top: 0.25rem;">
                    Kondisi : Semua
                </div>&ensp;
                @endif
                @if (isset($fil_jenis) || $fil_kata || $fil_kondisi)
                    <div class="card col-auto bg-danger border-danger"
                        style="width:auto; margin-top: 0.25rem;">
                        <a href="{{ url($current) }}" style="text-decoration: none; color:white">Hapus
                            filter<a>
                    </div>&ensp;
                @endif
            </div>
            
            {{-- <table class="table table-striped table-borderless" style=" width: 100%">
            @foreach ($barang as $barang)
            @php
                    $foto = $barang->foto;
                    $imgurl = "public/img/paskas/" . $foto ."";
                @endphp 
                <tr class="row">
                <td class="col-6 d-flex align-items-center justify-content-center">
                    <div class="card bg-transparent" style="border: 0; outline: 0; box-shadow: 0 0 0 0 rgb(0 0 0), 0 0 0 0 rgb(0 0 0); width: 100%;">
                        <div class="card-body" style="padding-top: 0; padding-bottom: 0;">
                            <p class="card-title" style="font-weight:700">{{$barang->judul}}</p>
                            <p class="card-text" style="font-weight:500;margin: 0">Rp. {{ number_format($barang->harga, 0, ',', '.') }}</p>
                            <p class="card-text" style="margin: 0;padding-top:1rem">{{Str::limit($barang->deskripsi,32)}}</p>
                            <p class="card-text" style="margin: 0;padding-top:0.25rem">kondisi: {{$barang->kondisi}}</p>
                            <p class="card-text" style="margin: 0;padding-top:0.25rem">Jenis: {{$barang->fungsi}}</p>
                            <a href="detail/paskas/{{$barang->id}}" class="btn btn-success" style="margin: 0.5rem 0;text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.25rem 1rem;">Detail</a>
                        </div>
                    </div>
                </td>
                <td class="col-6 d-flex align-items-center justify-content-center">
                    <div class="justify-content-center align-items-center" style="width: 100%; height:100%">
                        <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                            style="
                            background-size:cover;
                            background-position: center;
                            width:8rem;
                            height: 12rem;">
                            <img src="{!! $imgurl !!}" id="myImg" class="myImages m-auto"
                                style=" border-radius: 5%;object-fit: cover;height:12rem; width:8rem;"
                                alt={{ $barang->judul }}>
                        </div>
                    </div>
                        <!-- <div class="box" style="
                        background-size:cover;
                        background-position: center;
                        border: 1px black solid;
                        display: table-cell;
                        vertical-align: middle;">
                            <img src="{!! $imgurl !!}" style="
                            object-fit: cover;
                            width:8rem;
                            display:block;
                            margin: 0px auto;"/>
                        </div> -->
                    </div>
                </td>
            </tr>
            @endforeach
            </table> --}}

            <!-- Test -->
            <div class="row d-flex justify-content-center" style="padding: 0.5rem 0;">
            @if ($barang == 'kosong')
                <div class="col-12 d-flex justify-content-center" style="margin: 0.5rem 0; ">
                    <p class="text-secondary">Lokasi tidak ditemukan</p>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <a href="javascript:void(0)" class="btn btn-success btn-small" style="text-transform: capitalize" onclick="getLocationPaskas()">Coba Lagi</a>
                    <script>
                        function getLocationPaskas() {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(showPositionPaskas, noPositionPaskas, {timeout:100});
                            }
                        }

                        function showPositionPaskas(position) {
                            var lat = position.coords.latitude;
                            var long = position.coords.longitude;
                            var url = "{{route('paskas',['x'=>':lat', 'y'=>':long'])}}";
                            url = url.replace(':lat', lat);
                            url = url.replace(':long', long);
                            window.location.replace(url);
                        }

                        function noPositionPaskas() {
                            var url = "{{ route('paskas_kosong') }}";
                            return window.location.replace(url);
                        }
                    </script>
                </div>
            @else
                @php $i = 0; @endphp
                @foreach ($barang as $barang)
                @php $i++; @endphp
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="margin: 0.5rem 0; ">
                        <a href="{{ route('detail', ['fitur' => 'paskas', 'id' => $barang->id]) }}"
                            style="text-decoration: none; color:black;">
                            <div class="card border border-1 h-100" style="background-color: gainsboro;">
                                <div class="card border border-0" style="aspect-ratio: 1 / 1;">
                                    <div class="position-absolute top-0 start-0">
                                        @if ($barang->id_kondisi == 1)
                                            @php $badge_color = 'text-bg-danger'; @endphp
                                        @elseif ($barang->id_kondisi == 2)
                                            @php $badge_color = 'text-bg-warning'; @endphp
                                        @elseif ($barang->id_kondisi == 3)
                                            @php $badge_color = 'text-bg-success'; @endphp
                                        @elseif ($barang->id_kondisi == 4)
                                            @php $badge_color = 'text-bg-info'; @endphp
                                        @endif
                                        <span class="badge {{ $badge_color }}"
                                            style="font-size: 75%; font-weight: 600; margin-left: 0.2rem; text-transform: capitalize;">{{$barang->kondisi}}</span>
                                    </div>
                                    @php
                                        $foto_paskas = "https://ambilin.com/img/png/ambilin.png";
                                        if (!empty($barang->foto) && file_exists('public/img/paskas/' . $barang->foto)) {
                                            $foto_paskas = 'public/img/paskas/' . $barang->foto;
                                        }
                                    @endphp
                                    <img src="{!! asset($foto_paskas) !!}" class="card-img-top"
                                        alt="{{$barang->judul}}"
                                        style="aspect-ratio: 1 / 1; object-fit: cover;">
                                </div>
                                <style>
                                    #nama_barkas {
                                        -webkit-line-clamp: 2;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                        white-space: unset;
                                    }
                                </style>
                                <div class="container"
                                    style="font-size: 75%; letter-spacing: -0.25px; line-height: 1.5; text-align: justify; margin: unset;">
                                    <span class="text-truncate" style="margin:0.25rem 0; font-size: 100%; font-weight: 700;"
                                        id="nama_barkas">{{$barang->judul}}</span>
                                    <hr style="border-top: 1px solid #666666; margin: 0.25rem 0">
                                    <p style="margin:0.25rem 0 0.75rem 0;">{{$barang->fungsi}}</p>
                                    <br>
                                    <div class="position-absolute bottom-0 end-0">
                                        <div class="row">
                                            <div class="col-auto" style="padding-left: unset">
                                                <p class="text-success"
                                                    style="margin: 0 0.5rem 0.25rem 0; font-weight: 600; text-align: end;">
                                                    <small>Rp.</small> {{ number_format($barang->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @if ($i == 0)
                    <div class="col-12 d-flex justify-content-center" style="margin: 0.5rem 0; ">
                        <p class="text-secondary">Barang bekas di sekitar anda kosong</p>
                    </div>
                @endif
            @endif
            </div>
            <!-- Test END -->

            {{-- <div id="myModal" class="modal" style="background-color:rgba(0, 0, 0, 0.75);">
                <nav class="navbar navbar-expand-lg bg-success navbar-dark">
                    <div class="container-fluid">
                        <a class="close" style="color:white; size:125%; padding-left:1rem">
                            <div><i class="fa-solid fa-xmark"></i></div>
                        </a>
                        <p class="navbar-brand" id="caption" style="margin:0; font-size:90%;font-weight:bold"></p>
                        <p style="padding:0 12px">&nbsp;</p>
                    </div>
                    <!-- Container wrapper -->
                </nav>
                <img class="modal-content" id="img">
            </div>

            <script>
                // Get the modal
                var modal = document.getElementById("myModal");

                // Get the image and insert it inside the modal - use its "alt" text as a caption
                var img = document.getElementById("myImg");
                var images = document.getElementsByClassName('myImages');
                var modalImg = document.getElementById("img");
                var captionText = document.getElementById("caption");
                for (var i = 0; i < images.length; i++) {
                    var img = images[i];
                    // and attach our click listener for this image.
                    img.onclick = function(evt) {
                        modal.style.display = "block";
                        modalImg.src = this.src;
                        captionText.innerHTML = this.alt;
                    }
                }

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }
            </script>     --}}
        </div>
        {{-- <div class="container mx-auto justify-content-center d-flex" style="width:100%">
            {{ $barang->links('pagination::bootstrap-4') }}
        </div> --}}
    </div>
    @endif
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
