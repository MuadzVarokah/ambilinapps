<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1" /> --}}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{!! asset('public/operator/vendors/toastify/toastify.css') !!}">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
    <!-- Spinner -->
    {{-- <script src="{!! asset('public/src/js/bootstrap-input-spinner/bootstrap-input-spinner.js') !!}"></script> --}}
    
    <?php session_start(); ?>
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
    /* .btn-success-default {
        --bs-btn-color: #fff;
        --bs-btn-bg: #198754;
        --bs-btn-border-color: #198754;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #157347;
        --bs-btn-hover-border-color: #146c43;
        --bs-btn-focus-shadow-rgb: 60,153,110;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #146c43;
        --bs-btn-active-border-color: #13653f;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #198754;
        --bs-btn-disabled-border-color: #198754;
    } */

    html,body {
    text-size-adjust: none;
    -webkit-text-size-adjust: none;
    -ms-text-size-adjust: none;
    -moz-text-size-adjust: none;
    }
</style>

{{-- <body style="background: linear-gradient(to bottom, rgba(240,230,140,0.5) 0%, rgba(51,204,255,0.5)) 100%;"> --}}
<body id="scroller" data-role="page">
    <!-- Start your project here-->
    @yield('content')
    <!-- End your project here-->
    <script src="{!! asset('public/operator/vendors/toastify/toastify.js') !!}"></script>
    <!-- MDB -->
    <script type="text/javascript" src="{!! asset('public/js/mdb.min.js')!!}"></script>
    <!-- Bootstrap -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- ajax -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/5014e491f0.js" crossorigin="anonymous"></script>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
</body>

</html>
