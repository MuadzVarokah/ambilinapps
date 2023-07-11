<nav class="navbar navbar-dark fixed-bottom" style="width:100%; background-color:#176e41">
    <div class="container-fluid d-flex justify-content-center">
        <div class="row" style="width:100%">
            <a class="col-3 nav-item justify-content-center d-flex" href="{{ route('dashboard') }}"
                style="text-decoration:none; color:white; font-size:80%">
                <center>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-12"><i class="fa-solid fa-home"></i></div>
                        <div class="col-md-12">
                            <p style="margin-bottom:0% !important">beranda</p>
                        </div>
                    </div>
                </center>
            </a>
            <a class="col-3 nav-item justify-content-center d-flex" href="{{ route('iframe', ['link' => 'info']) }}"
                style="text-decoration:none; color:white; font-size:80%">
                <center>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-12"><i class="fa-solid fa-info-circle"></i></div>
                        <div class="col-md-12">
                            <p style="margin-bottom:0% !important">info</p>
                        </div>
                    </div>
                </center>
            </a>
            <a class="col-3 nav-item justify-content-center d-flex" href="{{ route('notifikasi') }}"
                style="text-decoration:none; color:white; font-size:80%">
                <center>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-12 position-relative">
                            <i class="fa-solid fa-bell"></i>
                            <!-- alerts -->
                            @if (!empty($notif_unread))
                                <span
                                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"
                                    style="top: 12.5%!important; left: 57.5%!important; padding: 0.25rem!important;">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                            <!-- alerts -->
                        </div>
                        <div class="col-md-12">
                            <p style="margin-bottom:0% !important">notifikasi</p>
                        </div>
                    </div>
                </center>
            </a>
            <a class="col-3 nav-item justify-content-center d-flex" href="{{ route('pesan_menu') }}"
                style="text-decoration:none; color:white; font-size:80%">
                <center>
                    <div class="row justify-content-center d-flex">
                        <div class="col-md-12 position-relative">
                            <i class="fa-solid fa-commenting"></i>
                            <!-- alerts -->
                            @if (!empty($chat_unread))
                                <span
                                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"
                                    style="top: 12.5%!important; left: 57.5%!important; padding: 0.25rem!important;">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                            <!-- alerts -->
                        </div>
                        <div class="col-md-12">
                            <p style="margin-bottom:0% !important">pesan</p>
                        </div>
                    </div>
                </center>
            </a>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        var now = '<?php echo "$raw_now"; ?>';
        setInterval(function() {
            $.ajax({
                type: "GET",
                url: "{{route('cek-notif-menu',['datetime'=>$raw_now])}}", // You add the id of the post and the update datetime to the url as well
                success: function(response) {
                    // If not false, update the post
                    if (response) {
                        location.reload();
                    }
                }
            });
        }, 60000); // Do this every 60 seconds\
            setInterval(function() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cek-chat-menu',['datetime'=>$raw_now])}}", // You add the id of the post and the update datetime to the url as well
                    success: function(response) {
                        // If not false, update the post
                        if (response) {
                            location.reload();
                        }
                    }
                });
            }, 5000); // Do this every 15 seconds
        });
</script>

@include('partials.hubungi_admin')
