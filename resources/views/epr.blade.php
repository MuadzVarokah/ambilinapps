@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
<!--content-->
<div style="width:100%">
    <div class="container" style="padding-top:1rem">
        <div class="row">
            @if(isset($induk))
            {{-- {{dd($induk)}} --}}
                @foreach($induk as $induk)
                    @php
                        $imgurl = "public/img/merek/" . $induk->logo ."";
                    @endphp
                <div class="square col-6 d-flex align-items-center justify-content-center" style="padding-bottom:1.5rem">
                    <a href="epr/{{$induk->id}}" style="text-align:center;text-decoration:none;color:black;">
                        <img src="{{$imgurl}}" class="img-fluid" alt={{$induk->nama}} style="max-height: 3.5rem; max-width:100%;object-fit: cover">
                    </br>{{$induk->nama}}
                    </a>
                </div>
                @endforeach
            @elseif(isset($id))
            {{-- {{dd($data)}} --}}
                @foreach($data as $data)
                    @php
                        $logo = $data->logo;
                        $alter = $data->merek;
                        $merk = $data->merek;
                        if (empty($data->merek)){
                            $merk = 'semua merek';
                            $logo = $per_induk->logo;
                            $alt = $per_induk->nama;
                        } if (empty($data->logo)) {
                            $logo = $per_induk->logo;
                        }
                        $imgurl = '/ambilinapps/public/img/merek/' . $logo .'';
                    @endphp
                        <div class="col-6 d-flex align-items-center justify-content-center">
                        <a href='{{$id}}/{{$data->id}}' style='text-align:center;text-decoration:none;color:black;'>
                            <img src='{{$imgurl}}' class='img-fluid' alt={{$alter}} style='max-height: 120px; max-width:80%;object-fit: cover'>
                        </br>{{$merk}}
                        </a>
                    </div>
                @endforeach
                @elseif(isset($id2))
                @include('partials.berat_epr')
                {{-- {{dd($data)}} --}}
                <div class="container">
                    {{-- {{dd(get_defined_vars());}} --}}
                    <table class='table table-striped table-borderless text-center' style='width: 100%'>
                        <tr>   
                            <td class="align-middle" style='font-weight:500; width:50%'>Nama barang</td>
                            <td class="align-middle" style='margin: 0'>Berat/EPR</br>(Kg)</td>
                            @php
                                $kat_str = strtolower($tipe->kategori);
                            @endphp
                            {{-- @if($kat_str == 'kolektor')
                            <td class="align-middle">Jumlah</td>
                            <td class="align-middle">Aksi</td>
                            @endif --}}
                        </tr>
                        {{-- {{dd($data)}} --}}
                        @foreach($data as $sampah)
                        @php
                        if (empty($sampah->merek)){
                            $merk2 = $sampah->induk;
                        } elseif (strtolower($sampah->merek) == 'semua merek'){
                            $merk2 = $sampah->induk;
                        } else{
                            $merk2 = $sampah->merek;
                        }
                        @endphp
                        <tr style="font-size: 90%;">
                            <form style="margin:0;" action="#" method="post">
                                <td class="align-middle" style='font-weight:500'>{{$sampah->sampah}} {{$merk2}}</td>
                                <td class="align-middle" style="margin: 0">{{$sampah->poin_epr}}</td>
                                {{-- @if($kat_str == 'kolektor')
                                    <td class="align-middle d-flex justify-content-center" style="margin: 0;">
                                        <input class="form-control" type="text" style="border-radius: 0; text-align: center;" name="jumlah" onkeypress="return hanyaAngka(event)" maxlength="4" placeholder="..." required/>
                                    </td>
                                    <td class="align-middle"><button type="submit" class="btn btn-success" style="text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0.5rem;">tukar</button></td>
                                @endif --}}
                            </form>
                        </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Content End -->
@endsection
 {{-- @include('partials.shortcut') --}}
