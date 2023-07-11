@extends('layouts.default')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <style>
        html,
        body {
            height: 100%;
        }
    </style>
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
    <!--content-->
    {{-- <div style="height: 100%"> --}}
    <div id="map" style="height: 85vh"></div>
    {{-- </div> --}}
    <div class="card fixed-bottom border border-0 rounded-0"
        style="width: 100%; border-top-left-radius: var(--bs-border-radius-2xl)!important; border-top-right-radius: var(--bs-border-radius-2xl)!important;">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    @if ((auth()->user()->foto_diri != null) && file_exists('public/img/foto/'.$data->foto_diri))
                        <div style="height: 2.5rem; width: 2.5rem; border-radius: 50%;
                            background-image: url({!! asset('public/img/foto/' . $data->foto_diri) !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $data->nama }}">
                        </div>
                    @else
                        <div style="height: 2.5rem; width: 2.5rem; border-radius: 50%;
                            background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $data->nama }} kosong">
                        </div>
                    @endif
                </div>
                <div class="col-auto">
                    <div class="row">
                        <div class="col-12"><h6 style="margin: 0; text-align: justify;">{{ $data->nama }}</h6></div>
                        <div class="col-12"><p style="margin:0; text-align: justify; color:darkgrey; font-size: small">{{ $level->pangkat }}</p></div>
                    </div>
                </div>
                <div class="col-12"><hr style="height: 2px; margin: 0.75rem 0;"></div>
                <div class="col-12">
                    <p style="text-align: justify; color:darkgrey; font-size: small">{{ $data->alamat_lokasi }}, {{ $data->kel }}, {{ $data->kec }}, {{ $data->kab }}, {{ $data->prov }} {{ $data->kode_pos }}</p>
                </div>
                {{-- <div class="col-12">
                    <button class="btn btn-primary btn-sm w-100 rounded-pill" style="text-transform: capitalize;">
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto"></div>
                            <div class="col-auto">Lihat rute melalui Google</div>
                            <div class="col-auto"><i class="fa-solid fa-chevron-right"></i></div>
                        </div>
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
    <script>
        var map = L.map('map').setView([{!! $data->lokasi_x !!}, {!! $data->lokasi_y !!}], 15);

        // var tiles = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        //     attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
        // }).addTo(map);
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

        // var marker = L.marker([-6.2062592, 106.8302336], markerOptions).addTo(map);

        if (!navigator.geolocation) {
            console.log("Your browser doesn't support geolocation feature!");
            var marker = L.marker([{!! $data->lokasi_x !!}, {!! $data->lokasi_y !!}], markerOptions).addTo(map);
        } else {
            navigator.geolocation.getCurrentPosition(getPosition);
        };

        function getPosition(position) {
            lat = position.coords.latitude
            long = position.coords.longitude

            L.Routing.control({
                waypoints: [
                    L.latLng([lat, long]),
                    L.latLng([{!! $data->lokasi_x !!}, {!! $data->lokasi_y !!}])
                ],
                routeWhileDragging: false,
                draggableWaypoints: false,
                addWaypoints: false,
                createMarker: function (i, waypoint, n) {

                    // Creating a custom icon
                    var lokasiIcon = L.icon({
                            iconUrl: "{!! asset('public/img/lokasi.png') !!}",
                            iconSize: [50, 50]
                        });
                    var geolocationIcon = L.icon({
                            iconUrl: "{!! asset('public/img/lokasi_geolocation.png') !!}",
                            iconSize: [34, 50]
                        });

                    var marker_icon = null
                    if (i == 0) {
                        // This is the first marker, indicating start
                        marker_icon = geolocationIcon
                    } else if (i == n -1) {
                        //This is the last marker indicating destination
                        marker_icon = lokasiIcon
                    }

                    const marker = L.marker(waypoint.latLng, {
                    icon: marker_icon
                });
                return marker;
                }
            }).addTo(map);
        }
    </script>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
