<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Harga Sampah Rumah Tangga & Bank Sampah</h3>
                    <p class="text-subtitle text-muted">Harga sampah kolektor & bank sampah yang tercatat di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Harga Sampah Kolektor & Bank Sampah
                            </li>
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
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Harga (per kg)</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_user)
                                <tr>
                                    <td>{{ $data_user->id }}</td>
                                    <td>
                                        <img src="https://ambilin.com/berkas/{{ $data_user->foto }}"
                                            alt="{{ $data_user->foto }}" style="max-height: 5rem;">
                                    </td>
                                    <td>{{ $data_user->nama }}</td>
                                    <td>Rp. {{ $data_user->harga_down }} - Rp. {{ $data_user->harga_top }}</td>
                                    <td>
                                        @if ($data_user->aktif == '1')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Mati</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;"
                                            data-bs-toggle="modal" data-bs-target="#edit{{ $data_user->id }}"><i
                                                class="fa-solid fa-pen-to-square"></i></button>
                                        @if ($data_user->aktif == '1')
                                            <a href="{{ route('harga_sampah_toggle-operator') }}?jenis=kolektor&id={{ $data_user->id }}"
                                                onclick="return confirm('apakah anda yakin?')"
                                                class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Matikan">
                                                <i class="fa fa-power-off">
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ route('harga_sampah_toggle-operator') }}?jenis=kolektor&id={{ $data_user->id }}"
                                                onclick="return confirm('apakah anda yakin?')"
                                                class="btn btn-outline-success btn-sm" style="margin: 0.15rem 0;"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Aktifkan">
                                                <i class="fa fa-power-off"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                @include('operator.partials.modals.edit_harga_sampah')
                                <!-- Modal Edit End -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
