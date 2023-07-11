@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    @include('operator.partials.toast')
    <!-- Navbar end -->
    <!--content-->
    <div style="width:100%">
        <div class="container" style="padding-top:1rem">
            <!-- Jarak Tampil Paskas & Sebar - Mitra -->
            @if (auth()->user()->kat_user == 1 || auth()->user()->kat_user == 3)
                <div class="alert alert-warning" role="alert" style="text-align: justify;">
                    Jarak tampil digunakan untuk mengatur daftar barang bekas pada Paskas dan Sebar yang tersedia pada radius yang ditentukan
                </div>
                <div class="card" style="background-color: whitesmoke">
                    <div class="card-body">
                        <h4>Paskas dan Sebar</h4>
                        <hr>
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto" style="font-weight: 600">Radius</div>
                            <div class="col-auto">
                                <a href="#" style="color: gray; text-decoration:none" data-bs-toggle="modal" data-bs-target="#radiusModal">
                                    {{ $jarak_tampil }} Km <i class="fa-solid fa-chevron-right" style="color: gray;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Jarak Tampil Ambilin - Kolektor -->
            @elseif (auth()->user()->kat_user == 2)
                <div class="alert alert-warning" role="alert" style="text-align: justify;">
                    Jarak tampil digunakan untuk mengatur daftar ambilin yang tersedia pada radius yang ditentukan
                </div>
                <div class="card" style="background-color: whitesmoke">
                    <div class="card-body">
                        <h4>Ambilin</h4>
                        <hr>
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto" style="font-weight: 600">Radius</div>
                            <div class="col-auto">
                                <a href="#" style="color: gray; text-decoration:none" data-bs-toggle="modal" data-bs-target="#radiusModal">
                                    {{ $jarak_tampil }} Km <i class="fa-solid fa-chevron-right" style="color: gray;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="radiusModal" tabindex="-1" aria-labelledby="radiusModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="radiusModalLabel">Radius (Km)</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('post_jarak_tampil') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input class="form-control" type="number" name="jarak_tampil" value="{{ $jarak_tampil }}"
                                    min="1" max="99">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
