<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title" style="text-transform: capitalize;">{{ $active }}</h3>
                    <p class="text-subtitle text-muted"><span style="text-transform: capitalize;">{{ $active }}</span> yang tercatat di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize;">{{ $active }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Datatable -->
        <section class="section">
            <div class="card">
                <div class="card-header text-end">
                    <button class="btn btn-success btn-sm" style="margin: 0 0.5rem;" data-bs-toggle="modal" data-bs-target="#tambahTglLayanan"><i class="fa-solid fa-calendar-plus"></i>&nbsp;&nbsp;Tambah</button>
                  </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive text-center" id="table1" style="font-size: 90%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_tgl_layanan)
                            <tr>
                                <td>{{ $data_tgl_layanan->id }}</td>
                                <td>{{ $data_tgl_layanan->tgl }}</td>
                                <td>
                                    @if ($data_tgl_layanan->aktif == 'N')
                                    <span class="badge bg-danger">Mati</span>
                                    @else
                                    <span class="badge bg-success">Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#editTglLayanan{{ $data_tgl_layanan->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    @if ($data_tgl_layanan->aktif == 'N')
                                    <a href="{{route('toggle_layanan')}}?id={{$data_tgl_layanan->id}}&jenis=tanggal&aktif=Y" onclick="return confirm('apakah anda yakin?')"
                                        class="btn btn-outline-success btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Aktifkan"><i class="fa fa-power-off"></i></a>
                                    @elseif ($data_tgl_layanan->aktif == 'Y')
                                    <a href="{{route('toggle_layanan')}}?id={{$data_tgl_layanan->id}}&jenis=tanggal&aktif=N" onclick="return confirm('apakah anda yakin?')"
                                        class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Matikan"><i class="fa fa-power-off"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <!-- modal edit -->
                            @include('operator.partials.modals.edit_tgl_layanan')
                            <!-- end modal edit -->
                            @endforeach
                        </tbody>
                    </table>
                    <!-- modal tambah -->
                    @include('operator.partials.modals.tambah_tgl_layanan')
                    <!-- end modal tambah -->
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