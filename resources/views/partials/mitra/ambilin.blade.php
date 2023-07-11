<div style="padding-bottom:1rem;padding-top:1rem" class="d-flex justify-content-center">
    <a href="ambilin-baru" role="button" class="btn btn-success"
        style="width: 80%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;">
        ambil pilihanku</a>
</div>
<hr>

<div class="table-responsive">
    <table class="table table-sm table-borderless" style="margin: 0;">
        <tr>
            <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem; width: 1%;">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active position-relative" style="padding:0.5rem 0.75rem" aria-current="page"
                            href="ambilin">
                            Proses
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $count_proses }}
                            </span>
                        </a>

                    </li>
                </ul>
            </td>
            <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem; width: 1%;">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link position-relative" style="padding:0.5rem 0.75rem"
                            href="ambilin-riwayat">riwayat
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $count_riwayat }}
                            </span>
                        </a>
                    </li>
                </ul>
            </td>
            <td style="padding-left: 0; padding-right: 0; padding-top: 0.5rem;">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link position-relative" style="padding:0.5rem 0.75rem"
                            href="ambilin-batal">Dibatalkan
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $count_batal }}
                            </span>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>
    </table>
</div>
<!-- Tes -->
<div class="row">
    @foreach ($data as $ambil)
    <div class="col-lg-4 col-md-6 col-12" style="padding-top:0.5rem;">
        <a href="{{ route('ambilin_edit', ['id' => $ambil->id_ambilin]) }}" style="text-decoration: none;">
            <div class="card" style="background-color: rgb(23, 110, 65, 0.2); color: dimgray;">
                <div class="card-body" style="padding: 0.75rem">
                    <div class="row w-100 d-flex justify-content-start">
                        <div class="col-auto" style="padding-right: 0;">
                            <div style="width: 5rem; height: 5rem;">
                                @php
                                    $foto = rawurlencode($ambil->foto);
                                    $imgurl = 'public/img/ambilin/sampah/' . $foto . '';
                                @endphp
                                @if (!empty($foto) && file_exists('public/img/ambilin/sampah/' . $ambil->foto))
                                    <img src="{!! asset($imgurl) !!}" alt="{{ $ambil->foto }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <img src="https://ambilin.com/img/png/ambilin.png" alt="{{ $ambil->foto }} kosong" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                        </div>
                        <div class="col" style="padding-right: 0;">
                            <div class="row" style="height: 100%;">
                                <div class="col-12">
                                    <p style="font-size: smaller; font-weight: 600; line-height: 1.2; margin: 0; color: black;"
                                        >{{ \Carbon\Carbon::parse($ambil->tgl)->translatedFormat('l, d F Y') }}
                                        <br>
                                        {{ $ambil->waktu }}</p>
                                </div>
                                <div class="col-12 d-flex align-self-end">
                                    @if ($ambil->status_id == 1)
                                        @if ($ambil->tgl < $today)
                                            <td class="align-middle">
                                                <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                            </td>
                                        @elseif($ambil->verifikasi == 'proses')
                                            <td class="align-middle">
                                                <div class="badge text-bg-warning">proses verifikasi</div>
                                            </td>
                                        @elseif($ambil->verifikasi == 'ditolak')
                                            <td class="align-middle">
                                                <div class="badge text-bg-warning">verifikasi ditolak</div>
                                            </td>
                                        @else
                                            <td class="align-middle">
                                                <div class="badge text-bg-warning">{{ $ambil->status }}</div>
                                            </td>
                                        @endif
                                    @elseif ($ambil->status_id == 2)
                                        <td class="align-middle">
                                            <div class="badge text-bg-primary">{{ $ambil->status }}</div>
                                        </td>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin: 0.5rem 0;">
                    @if (!empty($ambil->keterangan))
                        <style>
                            #deskripsi {
                                -webkit-line-clamp: 2;
                                display: -webkit-box;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                white-space: unset;
                            };
                        </style>
                        <p class="text-truncate" style="font-size: small; line-height: 1.2; margin: 0; text-align: justify; color: gray;" id="deskripsi"
                            >{{ $ambil->keterangan }}</p>
                        <hr style="margin: 0.5rem 0;">
                    @endif
                    <div class="row w-100">
                        <div class="col-auto d-flex align-self-center" style="padding-right: 0;"><i class="fa-solid fa-location-dot" style="color: black;"></i></div>
                        <div class="col" style="padding-right: 0;">
                            @if (empty($ambil->idlokasi))
                                <p class="text-danger" style="font-size: smaller; line-height: 1.2; margin: 0; text-align: justify; font-weight: 600;">Data alamat dihapus oleh pemilik barang</p>
                            @else
                                <p style="font-size: smaller; line-height: 1.2; margin: 0; text-align: justify; font-weight: 600; color: black;"
                                    >{{ $ambil->alamat_lokasi }} {{ $ambil->kel }}, {{ $ambil->kec }}, {{ $ambil->kab }}, {{ $ambil->prov }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
<!-- END Tes -->

<!--@foreach ($data as $ambil)
    <div style="padding:0.5rem 1rem">
        <div class="alert alert-secondary d-flex justify-content-center align-items-center" role="alert"
            style="margin:0%">
            <div class="row" style="width:100%;height:auto">
                <div class="col-12" style="padding:0;">
                    @php
                        $foto = rawurlencode($ambil->foto);
                        $imgurl = 'public/img/ambilin/sampah/' . $foto . '';
                    @endphp
                    @if (!empty($foto) && file_exists('public/img/ambilin/sampah/' . $ambil->foto))
                        <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                            style="
                        background:  url({!! asset($imgurl) !!});
                        background-size:cover;
                              background-position: center;
                              padding-top:30%; 
                              width:100%; 
                              max-width: 150%; 
                              min-height:100%;
                              max-height:150%; ">
                            {{-- <img src="{!! $imgurl !!}" id="myImg" class="myImages m-auto"
                            style=" border-radius: 5%;object-fit: cover;max-height:100%; width:100%;"
                            alt={{ $ambil->foto }}> --}}
                        </div>
                    @else
                        <div class="card m-auto d-flex justify-content-center bg-transparent border-0"
                            style="
                        background:  url('https://ambilin.com/img/png/ambilin.png');
                        background-size:cover;
                              background-position: center;
                              padding-top:30%; 
                              width:100%; 
                              max-width: 150%; 
                              min-height:100%;
                              max-height:150%; ">
                            {{-- <img src="{!! $imgurl !!}" id="myImg" class="myImages m-auto"
                            style=" border-radius: 5%;object-fit: cover;max-height:100%; width:100%;"
                            alt={{ $ambil->foto }}> --}}
                        </div>
                    @endif

                </div>
                <div class="col-12" style="padding:0">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td>
                                <p>Jadwal</p>
                            </td>
                            <td>
                                <p>:</p>
                            </td>
                            <td>
                                <p><b>{{ \Carbon\Carbon::parse($ambil->tgl)->translatedFormat('l, d F Y') }},
                                        </br>
                                        ({{ $ambil->waktu }})
                                    </b></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Lokasi Pickup</p>
                            </td>
                            <td>
                                <p>:</p>
                            </td>
                            <td>
                                <p>
                                    @if (empty($ambil->idlokasi))
                                        <p class="text-danger"><b>Data alamat dihapus oleh pemilik barang</b></p>
                                    @else
                                        <b>{{ $ambil->alamat_lokasi }}{{ $ambil->kel }}, {{ $ambil->kec }},
                                            {{ $ambil->kab }}, {{ $ambil->prov }}</b>
                                    @endif
                                </p>
                            </td>
                        </tr>
                        {{-- <tr>
                                <td><p>Jenis</p></td>
                                <td><p>:</p></td>
                                <td><p><b>{{$jenis->jenis}}</b></p>
                    </td>
                    </tr> --}}

                        {{-- <tr>
                                <td><p>Berat</p></td>
                                <td><p>:</p></td>
                                <td><p><b>{{$ambil->id_ambilin}} - {{$berat_raw->where('uns_berat.id_ambilin',$ambil->id_ambilin)->sum('berat')}}</b></p>
                    </td>
                    </tr> --}}

                        {{-- <tr>
                                <td><p>Estimasi Harga</p></td>
                                @php
                                    // $harga_down = $jenis->harga_down;
                                    // $harga_top = $jenis->harga_top;
                                    $count = $jenis_raw->count();
                                    $est_down = $sum_down * $berat/$count;
                                    $est_top = $sum_top * $berat/$count;
                                    $avg = (($est_down + $est_top))/2;
                                @endphp
                                <td><p>:</p></td>
                                <td><p><b>Rp. {{ number_format($est_down, 0, ',', '.') }} - Rp. {{ number_format($est_top, 0, ',', '.') }} | (± Rp. {{ number_format($avg, 0, ',', '.') }})</b></p>
                    </td>
                    </tr> --}}

                        <tr>
                            <td>
                                <p>Status</p>
                            </td>
                            <td>
                                <p>:</p>
                            </td>
                            @if ($ambil->status_id == 1)
                                @if ($ambil->tgl < $today)
                                    <td class="align-middle">
                                        <div class="badge text-bg-danger">Melampaui Jadwal</div>
                                    </td>
                                @elseif($ambil->verifikasi == 'proses')
                                    <td class="align-middle">
                                        <div class="badge text-bg-warning">proses verifikasi</div>
                                    </td>
                                @elseif($ambil->verifikasi == 'ditolak')
                                    <td class="align-middle">
                                        <div class="badge text-bg-warning">verifikasi ditolak</div>
                                    </td>
                                @else
                                    <td class="align-middle">
                                        <div class="badge text-bg-warning">{{ $ambil->status }}</div>
                                    </td>
                                @endif
                            @elseif ($ambil->status_id == 2)
                                <td class="align-middle">
                                    <div class="badge text-bg-primary">{{ $ambil->status }}</div>
                                </td>
                            @endif
                        </tr>

                        @php
                            $ket = '-';
                            if (!empty($ambil->keterangan)) {
                                $ket = $ambil->keterangan;
                            }
                        @endphp

                        <tr>
                            <td>
                                <p>Deskripsi</p>
                            </td>
                            <td>
                                <p>:</p>
                            </td>
                            <td>
                                <p><b>{{ Str::limit($ket, 18) }}</b></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12">
                    @if ($ambil->status_id == 1)
                        <a href="ambilin-edit/{{ $ambil->id_ambilin }}" role="button" class="btn btn-warning"
                            style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                class="fa-solid fa-pencil text-danger"></i>&nbsp;&nbsp;Detail/Ubah Data</a>
                    @elseif($ambil->status_id == 2)
                        <a href="ambilin-edit/{{ $ambil->id_ambilin }}" role="button" class="btn btn-warning"
                            style="width: 100%; text-transform: capitalize; font-size: 90%; font-weight: 600; padding: 0.5rem 0;"><i
                                class="fa-solid fa-circle-info text-primary"></i>&nbsp;&nbsp;Detail</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach -->
