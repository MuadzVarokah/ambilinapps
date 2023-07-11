<div class="card border border-0 rounded-5" style="margin-top: -5rem; height: 19rem; background-color: #176e41;">
    <div class="card-body d-flex justify-content-between" style="color: white; padding-top: 5.5rem;">
        <div style="padding: 0 11px;"></div>
        <center>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <img src="{!! asset('public/img/ambilin_text_white.png') !!}" class="img-fluid" alt="Ambilin" style="max-height: 2.5rem;">
                </div>
                <div class="col-md-12 col-sm-12" style="padding-top: 0.5rem;">
                    {{-- @php
                        ob_start();
                    @endphp --}}
                    @if(session()->has('notif'))
                    <div aria-live="polite" aria-atomic="true" class="position-relative" style="color: #000000">
                        <div class="toast-container p-3 top-0 start-50 translate-middle-x" data-original-class="toast-container p-3">
                          <div class="toast fade show">
                            <div class="toast-header">
                                <div style="padding-right: 5px;">
                                    <img src="{!! asset('public/img/logo-green.png') !!}" class="bd-placeholder-img" alt="Ambilin" style="height: 20px; width: auto;">
                                </div>
                              {{-- <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg> --}}
                              <strong class="me-auto">Ambilin</strong>
                              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                {{ session('notif') }}
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                    {{-- @if (session()->has('request_notif')) --}}

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    {{-- <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase.js"></script> --}}
                    <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js"></script>
                    <script src="https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js"></script>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            // var token = Website2APK.getFirebaseDeviceToken();
                            // alert(token);

                            const config = {
                                apiKey: "AIzaSyBCgMdI7nz_rqBP1lOn6q2BLp0ZKxikFS0",
                                authDomain: "ambilin-d55fc.firebaseapp.com",
                                projectId: "ambilin-d55fc",
                                storageBucket: "ambilin-d55fc.appspot.com",
                                messagingSenderId: "601300765463",
                                appId: "1:601300765463:web:68f0c29aa4df1da43d0552",
                                measurementId: "G-EJ8P5GS4GQ"
                            };
                            firebase.initializeApp(config);
                            const messaging = firebase.messaging();
                            
                            messaging
                                .requestPermission()
                                .then(function () {
                                    var token = messaging.getToken({ vapidKey: 'BHIZNhRpE4FYsdB35NO5d0DLE0tIgJfJDOIFNE65aXFwvZyZegGKmYoR8LNl3RigfbpjSqCkV1mfdNRwgBUnYM4' });
                                    return token;
                                })
                                .then(function(token) {
                                    // $.ajaxSetup({
                                    //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                                    // });
                                    // console.log(token);
                                    $.ajax({
                                        url: '{{ route('save-push-notification-token') }}',
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "fcm_token": token
                                        },
                                        dataType: 'JSON',

                                        success: function (response) {
                                            console.log(response);
                                        },

                                        error: function (err) {
                                            console.log("Can't do because: " + err);
                                        },
                                    });
                                })
                                .catch(function (err) {
                                    console.log("Unable to get permission to notify.", err);
                                });
                        
                            messaging.onMessage(function(payload) {
                                const noteTitle = payload.notification.title;
                                const noteOptions = {
                                    body: payload.notification.body,
                                    icon: payload.notification.icon,
                                };
                                new Notification(noteTitle, noteOptions);
                            });
                        });
                    </script>

                    {{-- @endif --}}
                    @if (($user->foto_diri != null) && file_exists('public/img/foto/'.$user->foto_diri))
                        <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                  background-image: url({!! asset('public/img/foto/' . $user->foto_diri) !!});
                  background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $user->nama }}">
                        </div>
                    @else
                        <div style="height: 4.5rem; width: 4.5rem; border-radius: 50%;
                  background-image: url({!! asset('https://ambilin.com/img/png/ambilin.png') !!});
                  background-size: cover; background-position: center;"
                            class="img-thumbnail" alt="{{ $user->nama }} kosong">
                        </div>
                    @endif
                </div>
                <div class="col-md-12 col-sm-12" style="padding-top: 0.5rem;">
                    <h5 style="color: white; margin: 0;">{{ $user->nama }}</h5>
                </div>
                @if(auth()->user()->verified > 1)
                    <div class="col-md-12 col-sm-12">
                        <p style="color: white; font-size: 80%; font-weight: 100; margin: 0;">{{$level->pangkat}}</p>
                    </div>
                @endif
            </div>
        </center>

        <!--offcanvas-->
        <button class="navbar-toggler d-flex align-item-start" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
            style="font-size: 150%; padding-top: 11px;">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel" style="color:white; background-color:#176e41; width: 14rem;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                    <a class="navbar-brand" href="{{ url('dashboard') }}">
                        <img class="img-fluid logo_img" id="logo_img" src="{!! asset('public/img/ambilin_text_white.png') !!}"
                            style="width: auto; height: 2rem">
                    </a>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <strong>
                            {{-- @php
                  $nama = "Budi Haryanto";
                  $id = "123456789012"; 
                  @endphp
                  @if (!empty($nama) && !empty($id))
                  <a class="nav-link active" aria-current="page" href="profile">Profilku</a>
                  <a class="nav-link active" aria-current="page" href="reset">Ganti Password</a>
                  <a class="nav-link active" aria-current="page" onclick="rating()">Beri Rating</a>
                  <a class="nav-link active text-danger" aria-current="page" href="{{ route('logout') }}">Logout</a>
                  <hr>
                  @endif
                  <a class="nav-link active" aria-current="page" href="#">Tentang Ambilin</a>
                  <a class="nav-link active" aria-current="page" href="#">Ketentuan Privasi</a>
                  <a class="nav-link active text-danger" aria-current="page" href="#">Tutup Aplikasi</a> --}}
                            @auth
                                <a class="nav-link active" aria-current="page" href="profile">Profilku</a>
                                <a class="nav-link active" aria-current="page" href="{{ route('jarak_tampil') }}">Jarak Tampil</a>
                                <a class="nav-link active" aria-current="page" href="reset">Ganti Password</a>
                                <a class="nav-link active" aria-current="page"
                                   onclick="rating()">Beri Rating</a>
                                <a class="nav-link active text-danger" aria-current="page"
                                    href="{{ route('logout') }}">Logout</a>
                                <hr>
                                {{-- <iframe class="nav-link active" src="https://ambilin.com/1.0/Profil" frameborder="0">Tentang Ambilin</iframe> --}}
                                {{-- <a class="nav-link active" aria-current="page" href="https://ambilin.com/1.0/Profil">Tentang Ambilin</a>
                  <a class="nav-link active" aria-current="page" href="https://ambilin.com/blog/kebijakan-privacy/">Ketentuan Privasi</a> --}}
                                <a class="nav-link active" aria-current="page" href="iframe/tentang">Tentang Ambilin</a>
                                <a class="nav-link active" aria-current="page" href="iframe/privacy">Ketentuan Privasi</a>
                                {{-- <a class="nav-link active text-danger" aria-current="page" onclick="myTutup()">Tutup Aplikasi</a> --}}
                                <a class="nav-link active" aria-current="page"><button class="text-danger"
                                        style="background-color: transparent;border: none;outline: none;"
                                        onclick="myTutup()"><b>Tutup Aplikasi</b></button></a>
                            @else
                                <a class="nav-link active text-warning" aria-current="page"
                                    href="{{ route('login') }}">Login</a>
                                <hr>
                                <a class="nav-link active" aria-current="page" href="https://ambilin.com/1.0/Profil">Tentang
                                    Ambilin</a>
                                <a class="nav-link active" aria-current="page"
                                    href="https://ambilin.com/blog/kebijakan-privacy/">Ketentuan Privasi</a>
                                {{-- <a class="nav-link active text-danger" aria-current="page" onclick="myTutup()">Tutup Aplikasi</a> --}}
                                <a class="nav-link active" aria-current="page"><button class="btn btn-danger"
                                        onclick="myTutup()"><b>Tutup Aplikasi</b></button>
                                @endauth
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
        <!--offcanvas end-->

        <script>
            function myTutup() {
                Website2APK.exitApp();
            }
			
			function rating() {
                Website2APK.rateUs();
            }
        </script>

    </div>
</div>
