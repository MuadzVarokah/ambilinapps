@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <!--content-->
    @if (!empty($harga_naik))
        @include('partials.harga_naik')
    @endif
    <div class="container">
        <section>
            @if (auth()->user()->kat_user == 2)
                <div class="container py-4" style="padding-bottom:1rem">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless" style="margin: 0;">
                            <tr>
                                <td style="padding-left: 0; padding-right: 0;">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $norm }} position-relative text-center" style="padding:0.5rem 0.75rem"
                                                aria-current="{{ $aria_n }}" href="{{ route('harga') }}">
                                                Harga Kolektor
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                                <td style="padding-left: 0; padding-right: 0;">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $bs }} position-relative text-center" style="padding:0.5rem 0.75rem"
                                                aria-current="{{ $aria_bs }}" href="{{ route('harga_bs') }}">
                                                Bank Sampah
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                                <td style="padding-left: 0; padding-right: 0;">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $mit }} position-relative text-center" style="padding:0.5rem 0.75rem"
                                                aria-current="{{ $aria_m }}" href="{{ route('harga_mitra') }}">
                                                Harga Mitra
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                                <td style="padding-left: 0; padding-right: 0;">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $pel }} position-relative text-center" style="padding:0.5rem 0.75rem"
                                                aria-current="{{ $aria_p }}" href="{{ route('harga_pelapak') }}">
                                                Harga Pelapak
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endif
            {{-- <table class="table table-striped table-borderless" style=" width: 100%">
                    @foreach ($cat_barang as $barang)
                        @php
                            $foto = $barang->foto;
                            $imgurl = "https://ambilin.com/berkas/" . $foto ."";
                        @endphp 
                        <tr class="row">
                            <td class="col-4 d-flex align-items-center justify-content-center">
                                <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style="max-height: 120px">
                    
                    
                        </td>
                        <td class="col-8">
                            <h5>{{$barang->nama}}</h5>
                            <p style="margin: 0">Estimasi harga per kilogram:</p>
                            <p style="margin: 0">Rp. {{ number_format($barang->harga_down, 0, ',', '.') }} - Rp. {{ number_format($barang->harga_top, 0, ',', '.') }}</p>
                        </td>
                    </tr>
                    @endforeach
                </table> --}}
            <table class="table table-borderless" style=" width: 100%">
                @foreach ($cat_barang as $barang)
                    @php
                        $foto = $barang->foto;
                        $imgurl = 'https://ambilin.com/berkas/' . $foto . '';
                    @endphp
                    <tr>
                        <td>
                            <div class="card border border-0" style="background-color: #dcdddd;">
                                <div class="row g-0">
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $barang->nama }}</h5>
                                            <p class="card-text" style="margin: 0">Estimasi harga per kilogram:</p>
                                            <p class="card-text" style="margin: 0">Rp.
                                                {{ number_format($barang->harga_down, 0, ',', '.') }} - Rp.
                                                {{ number_format($barang->harga_top, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <img src="{{ $imgurl }}" class="img-fluid" alt="{{ $barang->nama }}"
                                            style="padding: 0.4rem; max-height: 120px; border-radius:10%">
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
    </div>
    </section>
    </div>
    <div class="container mx-auto justify-content-center d-flex mb-7" style="width:100%">
        {{ $cat_barang->links('pagination::bootstrap-4') }}
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
