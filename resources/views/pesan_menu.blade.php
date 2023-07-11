@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <style>
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
    </style>
    <!--content-->
    <div class="container-fluid" style="width:100%; padding: 0; padding-bottom: 2rem">
        <table class="table table-sm table-hover" style="width: 100%">
            @php
            $list = $room;    
            @endphp
            @foreach($list as $id_room=>$room)
                @foreach ($room->slice(0,1) as $item)
                @php
                    if($item->id1 == auth()->user()->id){
                        $id_target = $item->id2;
                        $foto = $item->foto_diri2;
                        $nama = $item->nama2;
                    } elseif($item->id2 == auth()->user()->id){
                        $id_target = $item->id1;
                        $foto = $item->foto_diri1;
                        $nama = $item->nama1;
                    }
                @endphp
                <tr class='clickable-row' data-href='{{route('chat', ['id' => $id_target])}}' style='height: 1.5rem;'>
                    <td style="white-space: nowrap; width: 1%;">
                        <div class="col-md-12 col-sm-12" style="padding: 0.5rem 0.5rem;">
                            @if (!empty($foto) && file_exists('public/img/foto/'.$foto))
                                <div style="height: 3.5rem; width: 3.5rem; border-radius: 50%;
                                background-image: url({!! asset('public/img/foto/'.$foto) !!});
                                background-size: cover; background-position: center;"
                                class="img-thumbnail" alt="{{ $nama }}">
                                </div>
                            @else
                                <div style="height: 3.5rem; width: 3.5rem; border-radius: 50%;
                                background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                                background-size: cover; background-position: center;"
                                class="img-thumbnail" alt="ambilin">
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="align-middle" style="max-width: 0;">
                        <div class="row d-flex justify-content-between">
                            <div class="col-7" style="height:2.1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word; font-size: 1.25rem; font-weight: 600;">{{ $nama }}</div>
                            <div class="col-auto d-flex align-items-end">
                                <p style="margin:0; font-size: 80%; text-align: right; padding: 0 5px;">
                                    <small class="text-muted">
                                        {{-- {{ \Carbon\Carbon::parse($item->waktu_catat)->translatedFormat('h:i d/m/y') }} --}}
                                        @if(\Carbon\Carbon::parse($item->waktu_catat)->format('Y-m-d') == $today)
                                            {{ \Carbon\Carbon::parse($item->waktu_catat)->translatedFormat('h:i') }}
                                        @elseif(\Carbon\Carbon::parse($item->waktu_catat)->format('Y-m-d') == $yesterday)
                                            Kemarin
                                        @else
                                        {{ \Carbon\Carbon::parse($item->waktu_catat)->translatedFormat('d/m/y') }} 
                                        @endif
                                    </small>
                                </p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-9 text-muted" style="height: 1.6rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">{!! $item->chat !!}</div>
                            {{-- {{dd($id_target)}} --}}
                            @if (array_key_exists($id_target,$counter)&&(!empty($counter[$id_target])||$counter[$id_target] > 0))
                                <div class="col-auto d-flex justify-content-end align-items-center"><span class="badge text-bg-success rounded-5">{{$counter[$id_target]}}</span></div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endforeach
        {{-- <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert">
            <div class="row">
                <div class="col-12" style="padding:0%;">
                    <div class="col" style="text-align: center">
                        <div class="container">
                            <p style="font-size: 90%">Jika anda memerlukan panduan atau menemukan masalah pada aplikasi,
                                silahkan kontak kami melalui tombol Whatsapp berikut.</p>
                        </div>
                    </div>
                </div>
                <hr>
                <center>
                    <div style="padding:0%;">
                        <a href="https://api.whatsapp.com/send?phone=6281229505900" type="button"
                            class="btn btn-success btn" target="_blank" aria-disabled="true"
                            style="width: auto; height: 100%; text-transform: capitalize;"><i class="fab fa-whatsapp"
                                style="color: #FFFFFF;"></i>&nbsp;Whatsapp Admin</a>
                    </div>
                </center>
            </div>
        </div> --}}
            {{-- @for ($i = 0; $i <= 11; $i++)
            <tr class='clickable-row' data-href='{{route('chat', ['id' => $i])}}'>
                <td style="white-space: nowrap;">
                    <div class="col-md-12 col-sm-12" style="padding: 0.5rem 0.5rem;"> --}}
                        {{-- @if ($user->foto_diri != null)
                            <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                            background-image: url({!! asset('public/img/foto/'.$user->foto_diri) !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $user->nama }}">
                            </div>
                        @else --}}
                            {{-- <div style="height: 3.5rem; width: 3.5rem; border-radius: 50%;
                            background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail">
                            </div> --}}
                        {{-- @endif --}}
                    {{-- </div>
                </td>
                <td>
                    <div class="row d-flex justify-content-between" style="padding-top: 0.5rem">
                        <div class="col-9"><h5>Lorem, ipsum dolor. {{$i}}</h5></div>
                        <div class="col-3"><p><small class="text-muted">Lorem</small></p></div>
                        <div class="col-12"><p class="text-muted" style="margin: 0;">Lorem ipsum dolor sit amet.</p></div>
                    </div>
                </td>
            </tr>
            @endfor --}}
            {{-- @foreach ($data_chat as $room)
                @if (auth()->user()->kat_user == 1)
                    @php $id_target = $room->id_kolektor @endphp
                @elseif (auth()->user()->kat_user == 2)
                    @php $id_target = $room->id_mitra @endphp
                @endif --}}
            {{-- @foreach ($data_chat as $room)
                @if ($room->id1 == auth()->user()->id)
                    @php $id_target = $room->id2 @endphp
                @elseif ($room->id2 == auth()->user()->id)
                    @php $id_target = $room->id1 @endphp
                @endif
            <tr class='clickable-row' data-href='{{route('chat', ['id' => $id_target])}}'>
                <td style="white-space: nowrap;">
                    <div class="col-md-12 col-sm-12" style="padding: 0.5rem 0.5rem;">
                        @if ($room->foto_diri != null)
                            <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                            background-image: url({!! asset('public/img/foto/'.$room->foto_diri) !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $room->nama }}">
                            </div>
                        @else
                            <div style="height: 3.5rem; width: 3.5rem; border-radius: 50%;
                            background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                            background-size: cover; background-position: center;"
                            class="img-thumbnail">
                            </div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="row d-flex justify-content-between" style="padding-top: 0.5rem">
                        <div class="col-9"><h5>{{ $room->nama }}</h5></div>
                        <div class="col-3"><p style="margin:0; font-size: 80%; text-align: right; padding: 0 5px;">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($room->waktu_catat)->translatedFormat('h:i d/m/y') }}</small>
                        </p></div>
                        <div class="col-12"><p class="text-muted" style="margin: 0;">{{ $room->chat }}</p></div>
                    </div>
                </td>
            </tr>
            @endforeach --}}
        </table>
    </div>
    <!-- Content End -->
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });

        
        $(document).ready(function() {
            var now =  '<?php echo "$now";?>';
            setInterval(function() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cek-pesan',['datetime'=>$now])}}", // You add the id of the post and the update datetime to the url as well
                    success: function(response) {
                        // If not false, update the post
                        if (response) {
                            location.reload();
                        }
                    }
                });
            }, 5000); // Do this every 5 seconds
        });
//         var LAST_UPDATED_AT = 
//         setInterval(function() {
//        $.get('checkIfModelUpdated',
//     //    {updated_at: LAST_UPDATED_AT},
//        function(data) {
//            if (JSON.parse(data) == true) 
//                 // refresh your page
//                 location.reload();
//        });
//    }, 1000);
    </script>
    {{-- @include('partials.shortcut') --}}
@endsection

