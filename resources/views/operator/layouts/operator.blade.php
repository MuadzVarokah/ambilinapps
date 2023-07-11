<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Operator Ambilin</title>
    <link rel="icon" href="{!! asset('public/img/logo-white.png') !!}" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('public/operator/css/bootstrap.css') !!}">

    <link rel="stylesheet" href="{!! asset('public/operator/vendors/iconly/bold.css') !!}">

    <link rel="stylesheet" href="{!! asset('public/operator/vendors/perfect-scrollbar/perfect-scrollbar.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/operator/vendors/bootstrap-icons/bootstrap-icons.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/operator/css/app.css') !!}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    {{-- <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script> --}}
    {{-- <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="{!! asset('public/operator/vendors/toastify/toastify.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/operator/vendors/choices.js/choices.min.css') !!}" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> --}}
    {{-- <link rel="shortcut icon" href="{!! asset('public/img/logo_tanistore.png') !!}" type="image/x-icon"> --}}
    <?php session_start(); ?>
</head>

<body>
    <style>
        a {color: #176e41;}
        a:hover {color: #198754;}

        .text-muted {color: grey !important}

        .dropdown-item:focus:active {background-color: #176e41;}

        li.sidebar-item {margin: 0;}

        .form-control[readonly] {background-color: transparent !important;}

        body {line-height: 1.35;}
    </style>

    <div id="app">
        @yield('content')
    </div>

    {{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}

    <script src="{!! asset('public/operator/vendors/perfect-scrollbar/perfect-scrollbar.min.js') !!}"></script>
    <script src="{!! asset('public/operator/js/bootstrap.bundle.min.js') !!}"></script>

    {{-- <script src="{!! asset('public/operator/vendors/apexcharts/apexcharts.js') !!}"></script> --}}
    {{-- <script src="{!! asset('public/operator/js/pages/dashboard.js') !!}"></script> --}}

    <!-- toastify -->
    <script src="{!! asset('public/operator/vendors/toastify/toastify.js') !!}"></script>

    <!-- Include Choices JavaScript -->
    <script src="{!! asset('public/operator/vendors/choices.js/choices.min.js') !!}"></script>

    <script src="{!! asset('public/operator/js/main.js') !!}"></script>
    {{-- <script src="https://kit.fontawesome.com/5014e491f0.js" crossorigin="anonymous"></script> --}}
</body>

</html>