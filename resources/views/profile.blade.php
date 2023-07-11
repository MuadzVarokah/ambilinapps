@extends('layouts.default')
@section('content')
    @foreach ($user as $user)
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style='background-color:#176e41'>
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="dashboard"><i class="fa-solid fa-chevron-left"></i></a>
                {{-- <h5 class="navbar-brand" style="margin:0">Profil mitra "(status)"</h5> --}}
                <center>
                    <div class="row justify-content-center d-flex" style="color: white;">
                        @auth
                            <div class="col-md-12">
                                <h6 style="margin-bottom:0 !important">Profil mitra</h6>
                            </div>
                            @if ($user->kat_user != null)
                                <div class="col-md-12">
                                    <p style="margin-bottom:0% !important; font-size: 90%">{{ $kat->kat }}
                                        {{-- | {{ $jenis->jenis_lokasi }} --}}
                                        </strong>
                                    </p>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <p style="margin-bottom:0% !important; font-size: 90%">-</strong></p>
                                </div>
                            @endif

                        @endauth
                    </div>
                </center>
                <p style="padding:0 12px">&nbsp;</p>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->

        <style>
            p {
                font-size: 90%;
                margin: 0;
            }
        </style>

        <!-- overview -->
        <div class="container">
            @if (session()->has('success'))
                <div aria-live="polite" aria-atomic="true" class="position-relative" style="color: #000000">
                    <div class="toast-container p-3 top-0 start-50 translate-middle-x"
                        data-original-class="toast-container p-3">
                        <div class="toast fade show">
                            <div class="toast-header">
                                <div style="padding-right: 5px;">
                                    <img src="{!! asset('public/img/logo-green.png') !!}" class="bd-placeholder-img" alt="Ambilin"
                                        style="height: 20px; width: auto;">
                                </div>
                                {{-- <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg> --}}
                                <strong class="me-auto">Ambilin</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div aria-live="polite" aria-atomic="true" class="position-relative" style="color: #000000">
                    <div class="toast-container p-3 top-0 start-50 translate-middle-x"
                        data-original-class="toast-container p-3">
                        <div class="toast fade show">
                            <div class="toast-header">
                                <div style="padding-right: 5px;">
                                    <img src="{!! asset('public/img/logo-green.png') !!}" class="bd-placeholder-img" alt="Ambilin"
                                        style="height: 20px; width: auto;">
                                </div>
                                {{-- <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg> --}}
                                <strong class="me-auto">Ambilin</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row" style="padding: 10px 0;">
                <div class="col-5 d-flex align-items-center justify-content-center">
                    @php
                        $foto_diri = 'https://ambilin.com/img/png/ambilin.png';
                        if (!empty($user->foto_diri) && file_exists('public/img/foto/' . $user->foto_diri)) {
                            $foto_diri = 'public/img/foto/' . $user->foto_diri;
                        }
                    @endphp
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <img src="{!! asset($foto_diri) !!}" class="img-fluid" alt="{{ $user->nama }}"
                                style="max-height: 120px">
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-center" style="padding-top: 0.15rem">
                            <a href="edit-foto" role="button" class="btn btn-warning btn-sm">
                                <p style="font-size: 80%; text-transform: capitalize;"><i
                                        class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Foto</p>
                            </a>
                        </div>
                    </div>
                    {{-- @if ($user->foto_diri != null)
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <img src="{!! asset('public/img/foto/'.$user->foto_diri) !!}" class="img-fluid" alt="{{ $user->nama }}"
                                    style="max-height: 120px">
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center" style="padding-top: 0.15rem">
                                <a href="edit-foto" role="button" class="btn btn-warning btn-sm"><p style="font-size: 80%; text-transform: capitalize;"><i
                                    class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Foto</p></a>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <img src="{!! asset('https://ambilin.com/img/png/ambilin.png') !!}" class="img-fluid" alt="{{ $user->nama }} kosong"
                                style="max-height: 120px">
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center" style="padding-top: 0.15rem">
                                <a href="edit-foto" role="button" class="btn btn-warning btn-sm"><p style="font-size: 80%; text-transform: capitalize;"><i
                                    class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Foto</p></a>
                            </div>
                        </div>
                    @endif --}}
                </div>
                <div class="col-7">
                    @if ($user->kat_user == 1)
                        <h6 style="margin: 0;"><i class="fa-brands fa-whatsapp text-success"></i>
                            {{ auth()->user()->username }} &nbsp;
                            <a href="edit-wa" role="button"><i class="fa-solid fa-pen-to-square text-warning"
                                    style="text-shadow: 1px 1px #dcdddd;"></i></a>
                        </h6>
                    @else
                        @if ($user->kta != null)
                            <h6 style="margin: 0;">KTA : {{ auth()->user()->username }}</h6>
                        @else
                            <h6 style="margin: 0;">KTA : -</h6>
                        @endif
                    @endif
                    <p>{{ auth()->user()->nama }}</p>
                    <hr>
                    <p disabled>Anggota Sejak</p>
                    <p disabled>{{ $waktu_catat }}</p>
                </div>
            </div>
        </div>
        <!-- overview end-->

        <!-- Accordion Data -->
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
                                    <td>
                                        <p>Nama Lengkap</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    <td>
                                        <p><b>
                                                @if ($user->nama_lengkap == null)
                                                    {{ $user->nama }}
                                                @else
                                                    {{ $user->nama_lengkap }}
                                                @endif
                                            </b></p>
                                    </td>
                                </tr>
                                @if ($user->kat_user != 1)
                                    <tr>
                                        <td>
                                            <p>Nomor WA</p>
                                        </td>
                                        <td>
                                            <p>:</p>
                                        </td>
                                        <td>
                                            <p><b>{{ $user->no_wa }}</b></p>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        <p>Email</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->email != null)
                                        <td>
                                            <p><b>{{ $user->email }}</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <p>Pekerjaan</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->idpekerjaan != null)
                                        <td>
                                            <p><b>{{ $pekerjaan->pekerjaan }}</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <p>Pendidikan</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->idpendidikan != null)
                                        <td>
                                            <p><b>{{ $pendidikan->pendidikan }}</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <p>Jenis Kelamin</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->sex != null)
                                        @if ($user->sex == 'L')
                                            <td>
                                                <p><b>Laki-laki</b></p>
                                            </td>
                                        @else
                                            <td>
                                                <p><b>Perempuan</b></p>
                                            </td>
                                        @endif
                                    @else
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>
                                        <p>Tanggal Lahir</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->tgl_lahir != null)
                                        @php $tgl_lahir=date_create($user->tgl_lahir); @endphp
                                        <td>
                                            <p><b>{{ \Carbon\Carbon::parse($user->tgl_lahir)->format('d F Y') }}</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @endif
                                </tr>
                                @if ($user->kat_user == 1)
                                    @if ($user->verified != 0)
                                        <tr>
                                            <td colspan="3">
                                                <a href="edit-datadiri" role="button" class="btn btn-warning"
                                                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                                                    <i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Data Diri</p></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                                <tr>
                                    <td colspan="3">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Domisili</p>
                                    </td>
                                    <td>
                                        <p>:</p>
                                    </td>
                                    @if ($user->alamat_lokasi == null)
                                        <td>
                                            <p class="text-danger"><b>Data belum diinputkan</b></p>
                                        </td>
                                    @else
                                        <td>
                                            <p>
                                                {{ $user->alamat_lokasi }}
                                                @if (!empty($kel))
                                                    {{ $kel->name }},
                                                @endif
                                                @if (!empty($kec))
                                                    {{ $kec->name }},
                                                @endif
                                                @if (!empty($kab))
                                                    {{ $kab->name }},
                                                @endif
                                                @if (!empty($prov))
                                                    {{ $prov->name }}
                                                @endif
                                                {{ $user->kodepos }}
                                            </p>
                                        </td>
                                    @endif
                                </tr>
                                @if ($user->kat_user == 1)
                                    @if ($user->verified != 0)
                                        <tr>
                                            <td colspan="3">
                                                <a href="{{ route('edit_domisili') }}" role="button"
                                                    class="btn btn-warning"
                                                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                                                    <i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Domisili</p></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @if ($user->kat_user != 2)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelLokasiPengambilan-heading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelLokasiPengambilan-collapse" aria-expanded="false"
                                aria-controls="panelLokasiPengambilan-collapse">
                                <b>Lokasi Pengambilan</b>
                            </button>
                        </h2>
                        <div id="panelLokasiPengambilan-collapse" class="accordion-collapse collapse"
                            aria-labelledby="panelLokasiPengambilan-heading">
                            <div class="accordion-body">
                                <div class="alert alert-warning" role="alert">
                                    <p>Layanan pengambilah sampah saat ini hanya tersedia untuk kota Semarang</p>
                                </div>

                                @if (auth()->user()->verified < 2)
                                    <div class="alert alert-danger" role="alert">
                                        <p>Lokasi pengambilan dapat ditambahkan setelah akun anda diverifikasi</p>
                                    </div>
                                @endif

                                @if ($user->verified == 2)
                                    <a href="{{ route('tambah_lokasi_1') }}" role="button" class="btn btn-success"
                                        style="width: 100%;text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 1rem;">
                                        <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah Lokasi</a>
                                @else
                                    <button role="button" class="btn btn-secondary" disabled
                                        style="width: 100%;text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 1rem;">
                                        <i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah Lokasi</button>
                                @endif
                                <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                    <tr>
                                        <td colspan="3">
                                            <hr>
                                        </td>
                                    </tr>
                                    @foreach ($lokasi_ambil as $lokasi)
                                        @if (empty($lokasi->wp_id))
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Jenis Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p class="text-danger"><b>Data belum ada</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Nama Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p class="text-danger"><b>Data belum ada</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Alamat Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p class="text-danger"><b>Data belum ada</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Jenis Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p><b>{{ $lokasi->jenis_lokasi }}</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Nama Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p><b>{{ $lokasi->nama_lokasi }}</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Alamat Tempat</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                <td>
                                                    <p><b>{{ $lokasi->alamat_lokasi }}
                                                            {{-- {{ $kel_ambil->name }}, {{ $kec_ambil->name }},
                                                {{ $kab_ambil->name }}, {{ $prov_ambil->name }} {{ $lokasi->kode_pos }} --}}
                                                        </b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 35%">
                                                    <p>Status</p>
                                                </td>
                                                <td>
                                                    <p>:</p>
                                                </td>
                                                @if ($lokasi->aktif == 'Y')
                                                    <td><span class="badge text-bg-success">Aktif</span></td>
                                                @else
                                                    <td><span class="badge text-bg-danger">Nonaktif</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width: 100%">
                                                    <center style="padding-top: 10px;">
                                                        <div class="row d-flex justify-content-between"
                                                            style="width: 100%">
                                                            <div class="col">
                                                                <a href="detail-lokasi/{{ $lokasi->id }}"
                                                                    role="button" class="btn btn-info btn-sm"
                                                                    style="width: 100%;">
                                                                    <p style="font-size: 90%; text-transform: capitalize;">
                                                                        <i class="fa-solid fa-info"></i>&nbsp;&nbsp;Detail
                                                                    </p>
                                                                </a>
                                                            </div>
                                                            <div class="col">
                                                                @if ($lokasi->aktif == 'Y')
                                                                    <a href="{{ route('nonaktifkan_lokasi', ['id' => $lokasi->id]) }}"
                                                                        role="button" class="btn btn-danger btn-sm"
                                                                        style="width: 100%;">
                                                                        <p
                                                                            style="font-size: 90%; text-transform: capitalize;">
                                                                            <i
                                                                                class="fa-regular fa-circle-xmark"></i>&nbsp;&nbsp;Nonaktifkan
                                                                        </p>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('aktifkan_lokasi', ['id' => $lokasi->id]) }}"
                                                                        role="button" class="btn btn-success btn-sm"
                                                                        style="width: 100%;">
                                                                        <p
                                                                            style="font-size: 90%; text-transform: capitalize;">
                                                                            <i
                                                                                class="fa-regular fa-circle-check"></i>&nbsp;&nbsp;Aktifkan
                                                                        </p>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            {{-- <div class="col-auto">
                                                        <a href="edit-lokasi/{{$lokasi->id}}" role="button" class="btn btn-warning btn-sm" style="width: 100%;"><p style="font-size: 90%; text-transform: capitalize;"><i
                                                            class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah</p></a>
                                                    </div> --}}
                                                        </div>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- berkas ktp sementara dicomment -->
                {{--
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelBerkasKTP-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelBerkasKTP-collapse" aria-expanded="false"
                            aria-controls="panelBerkasKTP-collapse" style="margin-bottom: 0">
                            <b>Berkas KTP</b>
                        </button>
                    </h2>
                    <div id="panelBerkasKTP-collapse" class="accordion-collapse collapse"
                        aria-labelledby="panelBerkasKTP-heading">
                        <div class="accordion-body">
                            @if ($user->verified == 1 || $user->verified == 2)
                            <div class="alert alert-warning" role="alert">
                                <p>Mohon hubungi petugas atau admin untuk mengubah data ktp</p>
                            </div>
                            @endif
                            <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                @if ($user->ktp != null)
                                    <tr>
                                        <td colspan="3">
                                            <img src="{!! asset('public/img/ktp/'.$user->ktp) !!}" class="img-fluid"
                                                alt="ktp {{ $user->nama }}" style="max-height: 80%"></br>
                                        </td>
                                    </tr>
                                @endif
                                @if ($user->no_ktp != null)
                                    <tr>
                                        <td><p>NIK</p></td>
                                        <td><p>:</p></td>
                                        <td><p><b>{{ $user->no_ktp }}</b></p></td>
                                    </tr>
                                @endif
                                @if (($user->no_ktp && $user->ktp) == null)
                                <tr>
                                    <td colspan="3">
                                        <div class="alert alert-danger" role="alert">
                                            Anda belum memasukkan data KTP
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if ($user->kat_user == 1)
                                    @if ($user->verified == 3)
                                    <tr>
                                        <td colspan="3">
                                            <a href="{{route('edit_ktp')}}" role="button" class="btn btn-warning" style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                                                <i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Ubah Berkas KTP</a>
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                            </table>
                        </div>
                    </div>
                </div> --}}
                @if ($user->kat_user != 1)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelBerkasKTA-heading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelBerkasKTA-collapse" aria-expanded="false"
                                aria-controls="panelBerkasKTA-collapse" style="margin-bottom: 0">
                                <b>Berkas KTA</b>
                            </button>
                        </h2>
                        <div id="panelBerkasKTA-collapse" class="accordion-collapse collapse"
                            aria-labelledby="panelBerkasKTA-heading">
                            <div class="accordion-body">
                                @if ($user->verified == 1 || $user->verified == 2)
                                    <div class="alert alert-warning" role="alert">
                                        <p>Mohon hubungi petugas atau admin untuk mengubah data ktA</p>
                                    </div>
                                @endif
                                <table class="table table-borderless table-sm" style="margin-bottom: 0px;">
                                    @if ($user->kta != null)
                                        <tr>
                                            <td colspan="3">
                                                <img src="{!! asset('public/img/kta/' . $user->kta) !!}" class="img-fluid"
                                                    alt="ktp {{ $user->nama }}" style="max-height: 80%"></br>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($user->kta == null)
                                        <tr>
                                            <td colspan="3">
                                                <div class="alert alert-danger" role="alert">
                                                    Anda belum memiliki KTA
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    @if ($user->kat_user == 1)
        <div class="container" style="padding-top: 10px; padding-bottom: 1rem;">
            @if ($user->verified == 0)
                <a href="lengkapi-data-1" role="button" class="btn btn-warning"
                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                    <i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Lengkapi Data Diri
                </a>
            @elseif ($user->verified == 1)
                <div class="alert alert-warning" role="alert">
                    <i class="fa-solid fa-hourglass-half"></i>&nbsp;&nbsp;Verifikasi data diri anda sedang diproses!
                </div>
            @elseif ($user->verified == 2)
                <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-check"></i>&nbsp;&nbsp;Akun anda telah terverifikasi
                </div>
            @elseif ($user->verified == 3)
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Verifikasi akun anda ditolak
                    <hr>
                    <p style="font-size: 90%;">Silahkan periksa kembali data diri anda, setelah itu tekan tombol ajukan
                        verivikasi di bawah ini.</p>
                </div>
                <a class="btn btn-success" href="{{ route('ajukan_verifikasi', ['id' => auth()->user()->id]) }}"
                    role="button" onclick="return confirm('Apakah anda yakin ingin mengajukan verifikasi?');"
                    style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
                    <i class="fa-solid fa-file-arrow-up"></i>&nbsp;&nbsp;Ajukan verifikasi!
                </a>
            @endif
        </div>
    @elseif ($user->kat_user == 2)
        @if ($user->verified == 0)
            <div style="padding:1rem; padding-top:1rem; padding-bottom:0.5rem">
                <div class="alert alert-danger" role="alert" style="margin: 0;">
                    <div class="row">
                        <div class="col-1 d-flex align-items-center"><i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="col-11">
                            <p style="font-size: 90%; margin: 0;">Lengkapi data diri anda dengan cara datang ke Bintari
                                sembari membawa KTP anda agar dapat menggunakan fitur yang tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($user->verified == 2)
            <div style="padding:1rem; padding-top:1rem; padding-bottom:0.5rem">
                <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-check"></i>&nbsp;&nbsp;Akun anda telah terverifikasi
                </div>
            </div>
        @endif
    @endif
    <div class="container" style="padding-top: 10px; padding-bottom: 5rem;">
        {{-- <p class="text-danger">fitur hapus saat ini sedang dalam perbaikan</p> --}}
        <a href="{{ route('hapus_akun') }}" role="button" class="btn btn-danger"
            style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
            <i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Hapus Akun</a>
    </div>
@endsection
{{-- @include('partials.shortcut') --}}
