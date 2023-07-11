@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <!--content-->
    @php
        $partials = "";
        if($jenis == "epr"){
        $partials = "partials.poin_epr";
        }elseif ($jenis == "lt") {
        $partials = "partials.poin_lt";
        }
    @endphp
    @include($partials)

    <div class="container">
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <table class="table table-striped table-borderless text-center" style=" width: 100%;">
            <tr> 
                <td class="align-middle" style="font-weight:500">Barang</td>
                <td class="align-middle" style="margin: 0">Harga</td>
                <td class="align-middle" style="margin: 0">Nilai Tukar</td>
                <td class="align-middle" style="margin: 0">Jumlah</td>
                <td class="align-middle" style="margin: 0">Aksi</td>
            </tr>
            @foreach($tukar as $tukar)
            <tr> 
                <form style="margin:0;" action="{{route('post_tukar', ['jenis' => $tukar->tipe,'id' => $tukar->id])}}" method="post">
                    @csrf
                    <td class="align-middle" style="font-weight:500">{{$tukar->jenis}}</td>
                    <td class="align-middle" style="margin: 0; font-weight: 500;">{{$tukar->harga}} 
                        @if($jenis == 'lt') 
                        <img style='width: 20px; height: 20px; padding-bottom: 2px; padding-right: 2px;' src='https://ambilin.com/ambilinapps/public/img/poin.png'/> 
                        @elseif ($jenis == 'epr') 
                        <img style='width: 20px; height: 20px; padding-bottom: 2px; padding-right: 2px;' src='https://ambilin.com/ambilinapps/public/img/coin-epr.png'/> 
                        @endif</td>
                    <td class="align-middle" style="margin: 0"><sup><b>Rp.</b></sup> {{ number_format($tukar->nilai_tukar, 0, ',', '.') }}</td>
                    <td class="align-middle d-flex justify-content-center" style="margin: 0;">
                        {{-- <input class="form-control" type="number" style="border-radius: 0; text-align: center;" max='{{$lt}}' maxlength="3" placeholder="..." required/> --}}
                        <input class="form-control" type="text" style="border-radius: 0; text-align: center;" name="jumlah" onkeypress="return hanyaAngka(event)" maxlength="3" placeholder="..." required/>
                    </td>
                    <td><button type="submit" class="btn btn-success" style="text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0.5rem;">tukar</button></td>
                </form>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- Content End -->
    <script>
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
@endsection
{{-- @include('partials.shortcut') --}}