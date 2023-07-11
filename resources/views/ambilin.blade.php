@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    @include('operator.partials.toast')
    <!-- Navbar end -->
    <style>
        p {
            margin: 0;
        }
    </style>
    <!--content-->
    <div class='container' style="width:100%;padding-bottom:3.5rem">
        @if (auth()->user()->kat_user != 2)
            @include('partials.mitra.ambilin')
        @else
            @include('partials.kolektor.ambilin')
        @endif
        <div class="container mx-auto justify-content-center d-flex mt-2 mb-2" style="width:100%">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
