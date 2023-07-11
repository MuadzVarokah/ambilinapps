<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Gamifikasi</h3>
                    <p class="text-subtitle text-muted">Tingkatan user yang ada pada Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gamifikasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Datatable -->
        <section class="section">
            <div class="card">
                <div class="card-header text-end">
                    <button class="btn btn-success btn-sm" style="margin: 0 0.5rem;" data-bs-toggle="modal" data-bs-target="#tambahGamifikasi"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tambah</button>
                  </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="table1" style="font-size: 90%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pangkat</th>
                                <th>Sebutan</th>
                                <th>Jumlah Ambilin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_user)
                            <tr>
                                <td>{{ $data_user->id }}</td>
                                <td>{{ $data_user->pangkat }}</td>
                                <td>{{ $data_user->pangkat_pendek }}</td>
                                <td>{{ $data_user->jumlah_ambilin }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#edit{{ $data_user->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="{{route('hapus_gamifikasi-operator',['id'=>$data_user->id])}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            @include('operator.partials.modals.edit_gamifikasi')
                            <!-- Modal Edit End -->
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Tambah -->
                    @include('operator.partials.modals.tambah_gamifikasi')
                    <!-- Modal Tambah End -->
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