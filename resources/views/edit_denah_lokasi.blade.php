@extends('layouts.default')

@section('content')
{{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCx0EKlhFQxtCkftinhjGf3BqFMy7oyF4Q&callback=initMap&libraries=&v=weekly" defer></script> --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        
                        <h5 class="form-label">Lampiran Foto Denah Lokasi</h5>
                        <hr>

                        <form action="{{ route('update_denah_lokasi', ['id' => $wp_lokasi->id]) }}" method="POST">
                            @csrf

                            {{-- @if(isset($wp_lokasi->lampiran_denah))
                            <div class="mtb-4">
                                <label class="form-label" style="padding-top: 10px">Foto Denah Lokasi Lama</label></br>
                                <img alt="{{$wp_lokasi->lampiran_denah}}" src="{!! asset('public/img/wp_lokasi/lampiran_denah/'.$wp_lokasi->lampiran_denah) !!}" style="max-width: 100%"/>
                                <input name="foto_lama" type="hidden" value="{{$wp_lokasi->lampiran_denah}}" />
                            </div>
                            @endif

                            <!-- Foto Lokasi -->
                            <label class="form-label" for="lampiran_denah" style="padding-top: 10px">Unggah Foto Denah Lokasi</label>
                            <input type="file" class="form-control" id="lampiran_denah" name="lampiran_denah" /> --}}

                            @if (!empty($wp_lokasi->lokasi_x) && !empty($wp_lokasi->lokasi_y))
                                <div id="map" style="width: 100%;"></div>
                            @endif
                            <div id="map2" style="width: 100%;"></div>
                            <div class="row" style="padding-top: 1rem;">
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">X</span>
                                        <input class="form-control" name="lokasi_x" readonly value='{{ $wp_lokasi->lokasi_x ?? '' }}' id='latitude' required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Y</span>
                                        <input class="form-control" name="lokasi_y" readonly value='{{ $wp_lokasi->lokasi_y ?? '' }}' id='longitude' required>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <a type="button" class="btn btn-info" id="get-location" 
                                style="width: 100%; text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                Dapatkan Lokasi Saat Ini</a>
                            </div>
                            <script>
                                /* Gmaps */
                                // $("#get-location").click(() => {
                                //     if (!navigator.geolocation) {
                                //         return alert("Geolocation is not supported.")
                                //     } else {

                                //     navigator.geolocation.getCurrentPosition((position) => {
                                //         document.getElementById("latitude").value = position.coords.latitude;
                                //         document.getElementById("longitude").value = position.coords.longitude;
                                //     });

                                //     document.getElementById("map").style.height = "20rem";
                                    
                                //     setTimeout( function(){initMap();},1500 );
                                //     };
                                // });

                                // var xValue = document.getElementById("latitude").value;
                                // var yValue = document.getElementById("longitude").value;
                                
                                // async function initMap() {

                                //     const myLocation = {
                                //         lat: parseFloat(document.getElementById("latitude").value),
                                //         lng: parseFloat(document.getElementById("longitude").value),

                                //     };

                                //     console.log(document.getElementById("latitude").value);
                                //     console.log(document.getElementById("longitude").value);

                                //     const map = new google.maps.Map(document.getElementById("map"), {
                                //         zoom: 12,
                                //         center: myLocation,
                                //     });

                                //     const marker = new google.maps.Marker({
                                //         position: myLocation,
                                //         map,
                                //         title: "Lokasi Saya",
                                //     });
                                // }

                                // if (yValue && xValue) {
                                //     document.getElementById("map").style.height = "20rem";
                                // }
                                /* End Gmaps */

                                /* OSM */
                                $("#get-location").click(() => {
                                    if (!navigator.geolocation) {
                                        return alert("Geolocation is not supported.")
                                    } else {
                                        navigator.geolocation.getCurrentPosition(getPosition);
                                    };
                                });

                                function getPosition(position) {
                                    lat = position.coords.latitude;
                                    lang = position.coords.longitude;
                                    document.getElementById("latitude").value = position.coords.latitude;
                                    document.getElementById("longitude").value = position.coords.longitude;
                                    mapId = document.getElementById("map");
                                    if (mapId) {
                                        mapId.style.display = "none";
                                    }
                                    document.getElementById("map2").style.display = "block";
                                    
                                    var container = L.DomUtil.get('map2');
                                    if(container != null){
                                        container._leaflet_id = null;
                                    }

                                    document.getElementById("map2").style.height = "20rem";
                                    var map2 = L.map('map2').setView([lat, lang], 15);
                                    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                    }).addTo(map2);

                                    // Icon options
                                    var iconOptions = {
                                        iconUrl: "{!! asset('public/img/lokasi.png') !!}",
                                        iconSize: [50, 50]
                                    }

                                    // Creating a custom icon
                                    var customIcon = L.icon(iconOptions);

                                    // Creating Marker Options
                                    var markerOptions = {
                                        title: "Lokasi Pengambilan",
                                        clickable: true,
                                        icon: customIcon
                                    }

                                    var marker = L.marker([lat, lang], markerOptions);
                                    if (marker) {
                                        map2.removeLayer(marker);
                                    }
                                    marker.addTo(map2);
                                }

                                var xValue = document.getElementById("latitude").value;
                                var yValue = document.getElementById("longitude").value;
                                // console.log(xValue, yValue);

                                if (xValue && yValue) {
                                    document.getElementById("map2").style.display = "none";
                                    document.getElementById("map").style.display = "block";
                                    document.getElementById("map").style.height = "20rem";
                                    var map = L.map('map').setView([xValue, yValue], 15);
                                    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                    }).addTo(map);

                                    // Icon options
                                    var iconOptions = {
                                        iconUrl: "{!! asset('public/img/lokasi.png') !!}",
                                        iconSize: [50, 50]
                                    }

                                    // Creating a custom icon
                                    var customIcon = L.icon(iconOptions);

                                    // Creating Marker Options
                                    var markerOptions = {
                                        title: "Lokasi Pengambilan",
                                        clickable: true,
                                        icon: customIcon
                                    }

                                    var marker = L.marker([xValue, yValue], markerOptions);
                                    if (marker) {
                                        map.removeLayer(marker);
                                    }
                                    marker.addTo(map);
                                }
                                /* END OSM */
                            </script>
                            

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
