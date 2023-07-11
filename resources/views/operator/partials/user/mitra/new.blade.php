<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title" style="text-transform:capitalize">{{str_replace('_', ' ', $jenis)}} - Pengguna Baru</h3>
                    <p class="text-subtitle text-muted">Daftar {{str_replace('_', ' ', $jenis)}} - pengguna baru yang tercatat di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="text-transform:capitalize">{{str_replace('_', ' ', $jenis)}} - Pengguna Baru</li>
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
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_user)
                            <tr>
                                <td>{{ $data_user->id }}</td>
                                <td>{{ $data_user->username }}</td>
                                <td>{{ $data_user->no_wa }}</td>
                                <td>{{ $data_user->nama }}</td>
                                <td class="text-center">
                                    <form action="{{route('mitra_edit-operator', ['jenis' => $jenis])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data_user->id }}">
                                        <button class="btn btn-outline-warning btn-sm" role="submit" style="margin: 0.15rem 0;"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                    {{-- <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#editMitra{{ $data_user->id }}"><i class="fa-solid fa-pen-to-square"></i></button> --}}
                                    <a href="{{route('mitra_toggle-operator',['id' => $data_user->id])}}?jenis={{$jenis}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Nonaktifkan"><i class="fa-solid fa-power-off"></i></a>
                                </td>
                            </tr>
                            <!-- modal edit -->
                            {{-- @include('operator.partials.modals.edit_mitra') --}}
                            <!-- end modal edit -->
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