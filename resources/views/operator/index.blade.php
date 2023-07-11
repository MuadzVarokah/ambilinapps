@extends('operator.layouts.operator')

@section('content')
<style>
    .title {
        color: #39a835;
    }
</style>
    @include('operator.partials.sidebar')
    <div id="main" class='layout-navbar'>
        @include('operator.partials.topbar')
        @include('operator.partials.toast')
        @include($page)

        {{-- <!-- Dashboard --> 
        @if ($active == 'dashboard')
            @include('operator.partials.dashboard')
        <!-- END Dashboard --> 

        <!-- User -->
        <!-- Mitra --> 
        @elseif ($active == 'mitra new')
            @include('operator.partials.user.mitra.new')
        @elseif ($active == 'mitra verifying')
            @include('operator.partials.user.mitra.verifying')
        @elseif ($active == 'mitra verified')
            @include('operator.partials.user.mitra.verified')
        @elseif ($active == 'mitra unverified')
            @include('operator.partials.user.mitra.unverified')
        <!-- Kolekor -->    
        @elseif ($active == 'kolektor new')
            @include('operator.partials.user.kolektor.new')
        @elseif ($active == 'kolektor verifying')
            @include('operator.partials.user.kolektor.verifying')
        @elseif ($active == 'kolektor verified')
            @include('operator.partials.user.kolektor.verified')
        @elseif ($active == 'kolektor unverified')
            @include('operator.partials.user.kolektor.unverified')
        <!-- Bank Sampah --> 
        @elseif ($active == 'bank sampah new')
            @include('operator.partials.user.bank_sampah.new')
        @elseif ($active == 'bank sampah verifying')
            @include('operator.partials.user.bank_sampah.verifying')
        @elseif ($active == 'bank sampah verified')
            @include('operator.partials.user.bank_sampah.verified')
        @elseif ($active == 'bank sampah unverified')
            @include('operator.partials.user.bank_sampah.unverified')
        <!-- Kategori User --> 
        @elseif ($active == 'kategori user')
            @include('operator.partials.user.kategori_user')
        <!-- Lupa Password --> 
        @elseif ($active == 'lupa password')
            @include('operator.partials.user.lupa_password')
        <!-- END User -->

        <!-- Fitur -->
        <!-- Ambilin --> 
        @elseif ($active == 'order ambilin')
            @include('operator.partials.fitur.ambilin.order_ambilin')
        @elseif ($active == 'tanggal layanan')
            @include('operator.partials.fitur.ambilin.tanggal_layanan')
        @elseif ($active == 'waktu layanan')
            @include('operator.partials.fitur.ambilin.waktu_layanan')
        <!-- Paskas --> 
        @elseif ($active == 'paskas')
            @include('operator.partials.fitur.paskas')
        <!-- Sebar --> 
        @elseif ($active == 'sebar')
            @include('operator.partials.fitur.sebar')
            <!-- Harga Sampah --> 
        @elseif ($active == 'harga sampah mitra')
            @include('operator.partials.fitur.harga_sampah.mitra')
        @elseif ($active == 'harga sampah kolektor')
            @include('operator.partials.fitur.harga_sampah.kolektor')
        <!-- END Fitur -->
        @endif --}}
    </div>
@endsection
