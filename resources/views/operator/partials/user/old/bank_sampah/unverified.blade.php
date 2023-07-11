<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Bank Sampah - Ditolak</h3>
                    <p class="text-subtitle text-muted">Daftar bank sampah - ditolak yang tercatat di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bank Sampah - ditolak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Datatable -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="table1" style="font-size: 90%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>No wa</th>
                                {{-- <th>Email</th> --}}
                                <th>Nama</th>
                                {{-- <th>Nama Lengkap</th> --}}
                                {{-- <th>Tanggal Lahir</th> --}}
                                {{-- <th>Sex</th> --}}
                                {{-- <th>Pekerjaan</th> --}}
                                {{-- <th>Pendidikan</th> --}}
                                <th>Alamat</th>
                                {{-- <th>Kodepos</th> --}}
                                {{-- <th>Foto Diri</th> --}}
                                {{-- <th>NIK</th> --}}
                                {{-- <th>Foto KTP</th> --}}
                                {{-- <th>Hapus</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_user)
                            <tr>
                                <td>{{ $data_user->id }}</td>
                                <td>{{ $data_user->username }}</td>
                                <td>{{ $data_user->no_wa }}</td>
                                {{-- <td>{{ $data_user->email }}</td> --}}
                                <td>{{ $data_user->nama }}</td>
                                {{-- <td>{{ $data_user->nama_lengkap }}</td> --}}
                                {{-- <td>{{ $data_user->tgl_lahir }}</td> --}}
                                {{-- <td>{{ $data_user->sex }}</td> --}}
                                {{-- <td>{{ $data_user->idpekerjaan }}</td> --}}
                                {{-- <td>{{ $data_user->idpendidikan }}</td> --}}
                                <td>
                                    @if (!empty($data_user->alamat_lokasi))
                                        {{ $data_user->alamat_lokasi }}
                                        @if (!empty($data_user->idkel))
                                            , {{ $data_user->kel }}
                                            @if (!empty($data_user->idkec))
                                                , {{ $data_user->kec }}
                                                @if (!empty($data_user->idkab))
                                                    , {{ $data_user->kab }}
                                                    @if (!empty($data_user->idprov))
                                                        , {{ $data_user->prov }}
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                {{-- <td>{{ $data_user->kodepos }}</td> --}}
                                {{-- <td>
                                    @php
                                        $foto_diri = 'img/foto/'.$data_user->foto_diri;
                                        if (!empty($data_user->foto_diri) && file_exists('public/img/foto/'.$data_user->foto_diri)) {
                                            $foto_diri = 'img/foto/'.$data_user->foto_diri;
                                        }
                                    @endphp
                                    <img src="{{ asset($foto_diri) }}" loading="lazy" alt="" style="max-width: 10rem;">
                                </td>
                                <td>{{ $data_user->no_ktp }}</td> --}}
                                {{-- <td>
                                    @php
                                        $foto_ktp = 'public/img/ktp/'.$data_user->foto_ktp;
                                        if (!empty($data_user->foto_ktp) && file_exists('public/img/ktp/'.$data_user->foto_ktp)) {
                                            $foto_ktp = 'public/img/ktp/'.$data_user->foto_ktp;
                                        }
                                    @endphp
                                    <img src="{{ asset($foto_ktp) }}" loading="lazy" alt="" style="max-width: 10rem;">
                                </td> --}}
                                {{-- <td class="text-center">
                                    @if ($i % 2 == 0)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td> --}}
                                <td class="text-center">
                                    <button class="btn btn-outline-info btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal tooltip" data-bs-target="#edit" data-bs-placement="top" title="Detail"><i class="fa-solid fa-info"></i></button>
                                    <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Nonaktifkan"><i class="fa-solid fa-power-off"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal info -->
            {{-- @include('admin.partials.ukm_tani.modal_info_pemilik') --}}
            <!-- END Modal info -->

            <!-- Modal edit -->
            {{-- @include('admin.partials.ukm_tani.modal_edit_ukm_tani') --}}
            <!-- END Modal edit -->

        </section>
        <!-- END Datatable -->
    </div>
</div>

<!-- simple datatables -->
<script src="{!! asset('public/operator/vendors/simple-datatables/simple-datatables.js') !!}"></script>

<script type="text/javascript">
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>