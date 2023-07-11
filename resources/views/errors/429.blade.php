<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ambilin</title>
    <!-- MDB icon -->
    <link rel="icon" href="{!! asset('public/img/logo-white.png') !!}" type="image/x-icon" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{!! asset('public/css/mdb.min.css') !!}" />
    <!-- Style -->
    <link rel="stylesheet" href="{!! asset('public/css/style.css') !!}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<style>
    .btn-success {
        --bs-btn-color: #fff;
        --bs-btn-bg: #176e41;
        --bs-btn-border-color: #176e41;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #137347;
        --bs-btn-hover-border-color: #126c43;
        --bs-btn-focus-shadow-rgb: 60,153,110,0.5;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #126c43;
        --bs-btn-active-border-color: #11653f;
        --bs-btn-active-shadow: inset 0 3px 5pxrgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #176e41;
        --bs-btn-disabled-border-color: #176e41;
        box-shadow: 0 4px 9px -4px #176e41;
    }
    html, body {
        height: 100%;
    }
</style>

<body>
    <!-- Start your project here-->
    <div class="container d-flex align-items-center" style="height: 100%">
        <section>
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-6">
                        <img src="{!! asset('public/img/ambilin-error.png') !!}" class="img-fluid" alt="Ambilin">
                    </div>
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="row d-flex justify-content-center align-items-center">
                                <h2 class="col-12 text-center" style="font-size: 5rem; font-weight:600; margin: 0;">429</h2>
                                <p class="col-12 text-center" style="font-size: 1.5rem; font-weight:400; margin: 0; padding-bottom: 0.5rem;">Too Many Requests</p>
                                <hr style="text-align: center; width: 75%;">
                                <p class="col-12 text-center" style="font-size: 1rem; font-weight:600; margin: 0; padding-bottom: 1rem;">Terjadi kesalahan, silahkan</p>
                                <div class="row w-100 d-flex justify-content-center align-items-center">
                                    <div class="col-sm-12 col-md-5 d-flex justify-content-center" style="padding: 0.5rem;">
                                        <a href="{{ route('dashboard') }}" type="button" class="btn btn-success btn-lg btn-block"
                                        style="text-transform: none; font-size: 90%; font-weight: 600; padding: 0.5rem 0.5rem; width: auto;">
                                            Kembali ke Beranda</a>
                                    </div>
                                    <div class="col-sm-12 col-md-2 d-flex justify-content-center">
                                        - atau -
                                    </div>
                                    <div class="col-sm-12 col-md-5 d-flex justify-content-center" style="padding: 0.5rem;">
                                        <a href="https://api.whatsapp.com/send?phone=6281229505900" type="button" class="btn btn-success btn-lg btn-block"
                                        style="text-transform: none; font-size: 90%; font-weight: 600; padding: 0.5rem 0.5rem; width: auto;">
                                            Hubungi Admin</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="{!! asset('public/js/mdb.min.js')!!}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/5014e491f0.js" crossorigin="anonymous"></script>
</body>

</html>
