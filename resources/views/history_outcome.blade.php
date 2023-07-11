@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    @if ($fitur != 'ambilin' && $fitur != 'lt')
        @php
            $navFitur = $fitur;    
        @endphp
    @elseif($fitur == 'lt')
        @php
            $navFitur = 'ambilin';    
        @endphp
    @endif
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="/ambilinapps/history/{{ $navFitur }}/income">income</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">outcome</a>
        </li>
    </ul>
    {{-- {{dd(get_defined_vars())}} --}}
    <!-- Navbar end -->

    <!-- Content -->
    <div class="container" style="padding-top:1rem">
        <table class="table table-borderless table-sm" style="text-align:center; width:100%;font-size:75%">
            <thead>
                <tr>
                    @if ($fitur == 'epr')
                        <th style="width:5%">No</th>
                        <th style="width:24%">Nama</th>
                        <th style="width:16%">Nominal</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:15%">harga</th>
                        <th style="width:30%">Tanggal</th>
                    
                    @elseif($fitur == 'lt')
                        <th style="width:5%">No</th>
                        <th style="width:24%">Nama</th>
                        <th style="width:16%">Nominal</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:15%">harga</th>
                        <th style="width:30%">Tanggal</th>

                    @elseif($fitur == 'ambilin')
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($fitur == 'ambilin')
                @endif
                @php
                    $n = 0;
                @endphp

                @if ($fitur == 'lt')
                    @foreach ($outcome as $data)
                        @php
                            $n++;
                        @endphp
                        <tr>
                            <td style="width:5%">{{ $n }}</td>
                            <td style="width:22%">{{ $data->nama }}</td>
                            <td style="width:21%">Rp. {{ $data->nilai_tukar }}</td>
                            <td style="width:14%">{{ $data->jumlah }}x</td>
                            <td style="width:18%">{{ $data->harga }} poin</td>
                            <td style="width:25%">
                                {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                    @endforeach
                    <tr style="border" class="table-active">
                        <td colspan='2'>total</td>
                        <td>Rp. {{$juml_uang}}</td>
                        <td>{{count($outcome)}}x</td>
                        <td>{{ $juml_outcome }} poin</td>
                        <td></td>
                    </tr>
                @endif


                @if ($fitur == 'epr')
                    @foreach ($outcome as $data)
                        @php
                            $n++;
                        @endphp
                        <tr>
                            <td style="width:5%">{{ $n }}</td>
                            <td style="width:22%">{{ $data->nama }}</td>
                            <td style="width:21%">Rp. {{ $data->nilai_tukar }}</td>
                            <td style="width:14%">{{ $data->jumlah }}x</td>
                            <td style="width:18%">{{ $data->harga }} poin</td>
                            <td style="width:25%">
                                {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                    @endforeach
                    <tr style="border" class="table-active">
                        <td colspan="2">total</td>
                        <td>Rp. {{$juml_uang}}</td>
                        <td>{{ $sum_outcome }}x</td>
                        <td>{{ $juml_outcome }} poin</td>
                        <td></td>
                    </tr>
                @endif

            </tbody>
        </table>
        <div class="container mx-auto justify-content-center d-flex mb-7" style="width:100%">
            {{ $outcome->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
