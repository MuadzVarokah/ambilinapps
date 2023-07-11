<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title" style="text-transform: capitalize;">Jenis Lokasi User</h3>
                    <p class="text-subtitle text-muted">Jenis lokasi User yang tercatat di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize;">Jenis Lokasi User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Datatable -->
        <section class="section">
            <div class="card">
                <div class="card-header text-end">
                    <button class="btn btn-success btn-sm" style="margin: 0 0.5rem;" data-bs-toggle="modal" data-bs-target="#tambahJenisLokasi"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah</button>
                  </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive text-center" id="table1" style="font-size: 90%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Jenis Lokasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_wp_jenislokasi)
                            <tr>
                                <td>{{ $data_wp_jenislokasi->id }}</td>
                                <td>{{ $data_wp_jenislokasi->jenis_lokasi }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#editJenisLokasi{{ $data_wp_jenislokasi->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    {{-- <a href="#" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a> --}}
                                </td>
                            </tr>
                            <!-- modal edit -->
                            @include('operator.partials.modals.edit_jenis_lokasi')
                            <!-- end modal edit -->
                            @endforeach
                        </tbody>
                    </table>
                    <!-- modal tambah -->
                    @include('operator.partials.modals.tambah_jenis_lokasi')
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