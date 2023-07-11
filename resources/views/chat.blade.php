@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid d-flex justify-content-start">
            <!-- Navbar brand -->
            <a class="navbar-brand" href="{{route('pesan_menu')}}"><i class="fa-solid fa-chevron-left"></i></a>
            {{-- <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{$page}}</p>
            <p style="padding:0 12px">&nbsp;</p> --}}
            @if (!empty($profile->foto_diri) && file_exists('public/img/foto/'.$profile->foto_diri))
                <div style="height: 30px; width: 30px; border-radius: 50%; margin: 5px;
                background-image: url({!! asset('public/img/foto/' . $profile->foto_diri) !!});
                background-size: cover; background-position: center;"
                    alt="{{ $profile->nama }}" class="img-thumbnail"></div>
            @else
                <div style="height: 30px; width: 30px; border-radius: 50%; margin: 5px;
                background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                background-size: cover; background-position: center;"
                    class="img-thumbnail"></div>
            @endif
            <p class="navbar-brand" style="margin: 0 5px; font-size:100%;font-weight:500">{{ $profile->nama }}</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar end -->
    <style>
        html,
        body {
            overflow-x: hidden;
            width: 100%;
        }

        #chat .form-control {
            border-color: transparent;
        }

        #chat .form-control:focus {
            border-color: transparent;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>
    <!--content-->
    <div class="container-fluid" style="width:100%; min-height: 100%; padding: 0;" id="scroller">
        <section style="background-color: #eee;">
            <div class="row d-flex justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">

                    <div class="card" id="chat" style="border: 0; outline: 0; min-height: 100vh;">
                        <div class="card-body" data-mdb-perfect-scrollbar="true"
                            style="position: relative; margin: 3.5rem 0;">

                            @if (isset($chat))
                                @foreach ($chat as $pesan)
                                    @if ($pesan->id_pengirim == auth()->user()->id)
                                        <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                            <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end"
                                                style="width: 4rem; margin: 0; font-size: 70%">
                                                @if(\Carbon\Carbon::parse($pesan->waktu_catat)->format('Y-m-d') == $today)
                                                    Hari ini
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}
                                                @elseif(\Carbon\Carbon::parse($pesan->waktu_catat)->format('Y-m-d') == $yesterday)
                                                    Kemarin
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}
                                                @else
                                                {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('d/m/y') }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}   
                                                @endif
                                            </p>
                                            <p class="small p-2 mb-1 text-white rounded-3"
                                                style="background-color: #176e41; width: fit-content; max-width: 100%; word-wrap: break-word; word-break: break-word;">
                                                {!! $pesan->chat !!}</p>
                                        </div>
                                    @elseif ($pesan->id_penerima == auth()->user()->id)
                                        <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                            <p class="small p-2 mb-1 rounded-3"
                                                style="background-color: #f5f6f7; width: fit-content; max-width: 100%; word-wrap: break-word; word-break: break-word;">
                                                {!! $pesan->chat !!}</p>
                                            <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end"
                                                style="width: 4rem; margin: 0; font-size: 70%;">
                                                @if(\Carbon\Carbon::parse($pesan->waktu_catat)->format('Y-m-d') == $today)
                                                    Hari ini
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}
                                                @elseif(\Carbon\Carbon::parse($pesan->waktu_catat)->format('Y-m-d') == $yesterday)
                                                    Kemarin
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}
                                                @else
                                                {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('d/m/y') }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($pesan->waktu_catat)->translatedFormat('h:i') }}   
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            {{-- <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">Hi</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Kemarin<br>23:58</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">How are you ...???</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Kemarin<br>23:58</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">What are you doing
                                    tomorrow? Can we come up a bar? Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod distinctio nulla vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod distinctio nulla vel?Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod distinctio nulla vel?</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Kemarin<br>23:58</p>
                            </div> --}}

                            {{-- <div class="divider d-flex align-items-center mb-4">
                                <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
                            </div> --}}

                            {{-- <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:06</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">Hiii, I'm
                                    good.</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:06</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">How are
                                    you doing?</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:06</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">Long time
                                    no see! Tomorrow office. will be free on sunday.</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">Okay</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Hari ini<br>00:07</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">We will go on
                                    Sunday?</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Hari ini<br>00:07</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:09</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">That's
                                awesome!</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:09</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">I will
                                    meet you Sandon Square sharp at 10 AM</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:09</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">Is that
                                    okay?</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">Okay i will meet
                                    you on Sandon Square</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Hari ini<br>00:11</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:11</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">Do you
                                    have pictures of Matley Marriage?</p>
                            </div>

                            <div class="d-flex flex-row justify-content-start mt-2 b-2">
                                <p class="small p-2 mb-1 rounded-3" style="background-color: #f5f6f7; width: fit-content; max-width: 100%;">Sorry I don't
                                    have. i changed my phone.</p>
                                <p class="small ps-2 pb-1 rounded-3 text-muted d-flex align-items-end" style="width: 4rem; margin: 0; font-size: 70%;">Hari ini<br>00:13</p>
                            </div>

                            <div class="d-flex flex-row justify-content-end mt-2 mb-2">
                                <p class="small pe-2 pb-1 rounded-3 text-muted d-flex justify-content-end align-items-end" style="width: 4rem; margin: 0; font-size: 70%">Hari ini<br>00:15</p>
                                <p class="small p-2 mb-1 text-white rounded-3" style="background-color: #176e41; width: fit-content; max-width: 100%;">Okay
                                    then see you on sunday!!</p>
                            </div> --}}

                        </div>
                    </div>
                    <div class="card-footer fixed-bottom d-flex justify-content-start align-items-center p-3"
                        style="background-color: #eee">
                        {{-- <input type="text" class="form-control" name="pesan" id="pesan"
                                placeholder="Ketik pesan">
                            <div type="text" class="form-control" name="pesan" id="pesan"
                                placeholder="Ketik pesan" contenteditable="true"></div> --}}
                        <style>
                            textarea {
                                resize: none;
                                overflow: hidden;
                                min-height: 50px;
                                max-height: 64px;
                            }

                            textarea:focus {
                                outline: 1px solid #176e41;
                            }
                        </style>
                        <form action="{{ route('post_chat', ['id' => $id]) }}" method="post" id="kirim_pesan"
                            class="d-flex w-100">
                            @csrf
                            <textarea name="pesan" class="form-control-sm flex-fill overflow-auto" id="pesan" rows="1"
                                placeholder="Ketik pesan" oninput="auto_grow(this)" maxlength="255"></textarea>
                            {{-- <a class="ms-3 text-muted" href="#!"><i class="fas fa-paperclip"></i></a> --}}
                            <a class="ms-3 d-flex align-items-center" href="javascript:$('#kirim_pesan').submit();"
                                style="text-decoration: none;"><i class="fas fa-paper-plane"
                                    style="color:#176e41; font-size: 100%;"></i></a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Content End -->
    <script>
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }

        const scrollingElement = document.getElementById("scroller");

        const config = {
            childList: true
        };

        const callback = function(mutationsList, observer) {
            for (let mutation of mutationsList) {
                if (mutation.type === "childList") {
                    window.scrollTo(0, document.body.scrollHeight);
                }
            }
        };

        const observer = new MutationObserver(callback);
        observer.observe(scrollingElement, config);

        // $(document).ready(function() {
        // var pageRefresh = 15000; //5 s
        //     setInterval(function() {
        //         refresh();
        //     }, pageRefresh);
        // });

        // $( document ).ready(function() {
        // function refresh() {
        //     $("#chat").load(window.location.href+ "#chat");
        // }
        // });

        $(document).ready(function() {
            var id_update = '<?php echo "$singleroom";?>';
            var now =  '<?php echo "$carb_now";?>';
            setInterval(function() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cek-chat-room',['id_room'=>$singleroom,'datetime'=>$carb_now])}}", // You add the id of the post and the update datetime to the url as well
                    success: function(response) {
                        // If true, update the post
                        if (response) {
                            location.reload();
                        }
                    }
                });
            }, 5000); // Do this every 5 seconds
        });
    </script>
@endsection
