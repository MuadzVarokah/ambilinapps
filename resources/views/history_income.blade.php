@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    @if ($fitur != 'ambilin' && $fitur != 'lt')
        @php
            $navFitur = $fitur;
        @endphp
    @elseif($fitur == 'ambilin')
        @php
            $navFitur = 'lt';
        @endphp
    @endif
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">income</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/ambilinapps/history/{{ $navFitur }}/outcome">outcome</a>
        </li>
    </ul>
    <!-- Navbar end -->

    <!-- Content -->
    <div class="container" style="padding-top:1rem; padding-bottom:5rem">
        <table class="table table-borderless table-sm" style="text-align:center; width:100%;font-size:75%">
            <thead>
                <tr>
                    @if ($fitur == 'epr')
                        <th style="width:5%">No</th>
                        <th style="width:22%">Jenis</th>
                        <th style="width:16%">Merek</th>
                        <th style="width:25%">Tanggal</th>
                        <th style="width:14%">Jumlah</th>
                        <th style="width:18%">Berat/poin</th>
                    @elseif($fitur == 'ambilin')
                        <th style="width:5%">No</th>
                        <th style="width:25%">Status</th>
                        <th style="width:35%">Lokasi</th>
                        <th style="width:35%">Tanggal</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $n = 0;
                @endphp

                @if ($fitur == 'ambilin')
                    @foreach ($data as $item)
                    {{-- {{dd($data)}} --}}
                        @php
                            $n++;
                        @endphp
                        <tr>
                            <td style="width:5%">{{ $n }}</td>
                            @if ($item->status_id == 1)
                                @if ($item->tgl < $today)
                                    <td cstyle="width:22%">
                                        <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                    </td>
                                @else
                                    <td cstyle="width:22%">
                                        <div class="badge text-bg-warning">{{ $item->status }}</div>
                                    </td>
                                @endif
                            @elseif ($item->status_id == 2)
                                <td style="width:22%">
                                    <div class="badge text-bg-primary">{{ $item->status }}</div>
                                    @if ($item->tgl < $today)
                                        </br>
                                        <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                    @endif
                                </td>
                            @elseif ($item->status_id == 3)
                                <td style="width:22%">
                                    <div class="badge text-bg-success">{{ $item->status }}</div>
                                </td>
                            @elseif ($item->status_id == 4)
                                <td style="width:22%">
                                    <div class="badge text-bg-secondary">{{ $item->status }}</div>
                                </td>
                            @endif
                            <td style="width:21%">{{ $item->alamat_lokasi }}</td>
                            <td style="width:25%">{{ \Carbon\Carbon::parse($item->tgl)->translatedFormat('l, d F Y') }},
                                </br> ({{ $item->waktu }})</td>
                        </tr>
                    @endforeach
                    <tr style="border" class="table-active">
                        <td colspan="3">total poin LT</td>
                        <td>({{ $count_amb }} / {{ $income_data->harga }} * {{ $income_data->nilai_tukar }}) =
                            {{ ($count_amb / $income_data->harga) * $income_data->nilai_tukar }}</td>
                    </tr>
                @endif

                @if ($fitur == 'epr')
                    @foreach ($income as $item)
                        @php
                            $n++;
                            if ($fitur == 'epr' && empty($item->merek)) {
                                $merek = $item->induk;
                            } else {
                                $merek = $item->merek;
                            }
                        @endphp

                        <tr>
                            <td style="width:5%">{{ $n }}</td>
                            <td style="width:22%">{{ $item->jenis }}</td>
                            <td style="width:21%">{{ $merek }}</td>
                            <td style="width:25%">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                            </td>
                            <td style="width:14%">{{ $item->jumlah }} Kg</td>
                            <td style="width:18%">{{ $item->harga }} Kg</td>
                        </tr>
                    @endforeach
                    <tr style="border" class="table-active">
                        <td colspan="4">total</td>
                        <td>{{ $juml_income }} Kg</td>
                        <td>{{ $sum_epr }} poin</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if ($fitur == 'ambilin')
        <div class="container mx-auto justify-content-center d-flex mb-7" style="width:100%">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
        @else
        <div class="container mx-auto justify-content-center d-flex mb-7" style="width:100%">
            {{ $income->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
    <!-- Content End -->
@endsection
{{-- @include('partials.shortcut') --}}
