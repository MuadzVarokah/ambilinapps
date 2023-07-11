@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Navbar brand -->
            <form action="{{route('back_to_profile')}}" method="post" id="back_to_profile">
                @csrf
                <a class="navbar-brand" href="#" type="submit" onclick="document.getElementById('back_to_profile').submit()"><i class="fa-solid fa-chevron-left"></i></a>
            </form>
            <p class="navbar-brand" style="margin:0; font-size:90%;font-weight:bold">{{$page}}</p>
            <p style="padding:0 12px">&nbsp;</p>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    <div class="container">
        <section>
            <div class="container py-4">
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                        <form action="{{ route('post_data_5') }}" method="POST">
                            @csrf

                            {{-- {{ dd($user); }} --}}

                            <style>
                                .accordion-button {
                                    color: #41464b;
                                    background-color: #e2e3e5;
                                    border-color: black;
                                }
                    
                                .accordion-button:focus {
                                    z-index: 3;
                                    border-color: #badbcc;
                                    outline: 0;
                                    box-shadow: #d1e7dd;
                                }
                    
                                .accordion-button:not(.collapsed) {
                                    color: #0f5132;
                                    background-color: #d1e7dd;
                                    box-shadow: inset 0 calc(var(--bs-accordion-border-width) * -1) 0 #0f5132;
                                }
                    
                                .accordion-button:not(.collapsed):after {
                                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230c4128'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
                                }
                    
                                button {
                                    margin: 0.2px 0;
                                }
                            </style>

                            <div class="container">
                                <div class="accordion" id="profil">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelDataDiri-heading">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelDataDiri-collapse" aria-expanded="true"
                                                aria-controls="panelDataDiri-collapse" style="margin-top: 0">
                                                <b>Data Diri</b>
                                            </button>
                                        </h2>
                                        <div id="panelDataDiri-collapse" class="accordion-collapse collapse show"
                                            aria-labelledby="panelDataDiri-heading">
                                            <div class="accordion-body">
                                                <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                                    <tr>
                                                        <td><p>No KTP</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{$user->no_ktp}}</b></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td><p>Nama Lengkap</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{$user->nama_lengkap}}</b></p></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td><p>Nomor WA</p>
                                                        </td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $user->no_wa }}</b></p></td>
                                                    </tr> --}}
                                                    @if ($user->email != null)
                                                    <tr>
                                                        <td><p>Email</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $user->email }}</b></p></td>
                                                    </tr>
                                                    @endif
                                                    @if ($user->tgl_lahir != null)
                                                    <tr>
                                                        <td><p>Tanggal Lahir</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $user->tgl_lahir }}</b></p></td>
                                                    </tr>
                                                    @endif
                                                    @if ($user->sex != null)
                                                        @if ($user->sex == 'L')
                                                        <tr>
                                                            <td><p>Jenis Kelamin</p></td>
                                                            <td><p>:</p></td>
                                                            <td><p><b>Laki-laki</b></p></td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <td><p>Jenis Kelamin</p></td>
                                                            <td><p>:</p></td>
                                                            <td><p><b>Perempuan</b></p></td>
                                                        </tr>
                                                        @endif
                                                    
                                                    @endif
                                                    @isset($user->idpekerjaan)
                                                    <tr>
                                                        <td><p>Pekerjaan</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $pekerjaan->pekerjaan }}</b></p></td>
                                                    </tr>
                                                    @endisset
                                                    @isset($user->idpendidikan)
                                                    <tr>
                                                        <td><p>Pendidikan</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $pendidikan->pendidikan }}</b></p></td>
                                                    </tr>
                                                    @endisset
                                                    <tr><td colspan="3"><hr></td></tr>
                                                    <tr>
                                                        <td><p>Domisili</p></td>
                                                        <td><p>:</p></td>
                                                        <td><p><b>{{ $user->alamat_lokasi }} {{ $kelurahan->name }}, {{ $kecamatan->name }},
                                                                {{ $kabupaten->name }}, {{ $provinsi->name }} {{ $user->kodepos }}</b></p></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelBerkasKTP-heading">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelBerkasKTP-collapse" aria-expanded="false"
                                                aria-controls="panelBerkasKTP-collapse" style="margin-bottom: 0">
                                                <b>Berkas Foto</b>
                                            </button>
                                        </h2>
                                        <div id="panelBerkasKTP-collapse" class="accordion-collapse collapse"
                                            aria-labelledby="panelBerkasKTP-heading">
                                            <div class="accordion-body">
                                                <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                                    <tr>
                                                        <td>Foto KTP</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <img alt="{{$user->ktp}}" src="{!! asset('public/img/ktp/'.$user->ktp) !!}" style="max-width: 100%"/>
                                                        </td>
                                                    </tr>
                                                    <tr><td colspan="3"></td></tr>
                                                    <tr>
                                                        <td>Foto Diri</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <img alt="{{$user->foto_diri}}" src="{!! asset('public/img/foto/'.$user->foto_diri) !!}" style="max-width: 100%"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Submit button -->
                            <br>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('create_data_4') }}" type="button" class="btn btn-danger btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                        <i class="fa-solid fa-chevron-left"></i> Kembali</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success btn-lg btn-block"
                                    style="text-transform: capitalize; font-size: 80%; font-weight: 600; padding: 0.5rem 0;">
                                    Verifikasi&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-from-bracket"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
