@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            <a class="navbar-brand" style="padding-left:0.25rem" href='/ambilinapps/{{$back}}'><i class="fa-solid fa-chevron-left"></i></a>
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{$target}}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <!--content-->
   
    <div  class="justify-content-center d-flex" style="width:100%; min-height:90.62vh; padding-top:1rem;">
        <iframe src={{$link}} frameborder="0" style="overflow:hidden;width:100%" ></iframe>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}