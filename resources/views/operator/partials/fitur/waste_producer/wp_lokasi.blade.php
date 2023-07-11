<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">
<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title" style="text-transform: capitalize;">Lokasi User @if($active == 'wp lokasi hapus')yang dihapus @endif</h3>
                    <p class="text-subtitle text-muted">Lokasi User yang @if($active == 'wp lokasi')tercatat @elseif('wp lokasi hapus')dihapus @endif di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize;">Lokasi User @if($active == 'wp lokasi hapus')yang dihapus @endif</li>
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
                                <th>User</th>
                                <th>Foto Lokasi</th>
                                <th>Jenis Lokasi</th>
                                <th>Nama Lokasi</th>
                                <th>Alamat Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $user_id = []; @endphp
                            @foreach ($data as $data_wp_lokasi)
                            @php $user_id[] = $data_wp_lokasi->wp_id; @endphp
                            <tr>
                                <td>{{ $data_wp_lokasi->id }}</td>
                                <td>{{ $data_wp_lokasi->wp_id }} - {{ $data_wp_lokasi->nama }} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detail{{ $data_wp_lokasi->wp_id }}"><i class="fa-solid fa-circle-info text-info"></i></a></td>
                                {{-- <td>{{ $data_wp_lokasi->foto_lokasi }}</td> --}}
                                @php
                                    $foto_lokasi = 'public/img/logo-green.png';
                                    if (!empty($data_wp_lokasi->foto_lokasi) && file_exists('public/img/wp_lokasi/foto_lokasi/'.$data_wp_lokasi->foto_lokasi)) {
                                        $foto_lokasi = 'public/img/wp_lokasi/foto_lokasi/'.$data_wp_lokasi->foto_lokasi;
                                    }
                                @endphp
                                <td class="text-center"><img src="{{ asset($foto_lokasi) }}" alt="{{ $data_wp_lokasi->nama_lokasi }}" style="max-height: 6.5rem;"></td>
                                <td>{{ $data_wp_lokasi->jenis_lokasi }}</td>
                                <td>{{ $data_wp_lokasi->nama_lokasi }}</td>
                                <td>{{ $data_wp_lokasi->alamat_lokasi }}, {{ $data_wp_lokasi->prov }}, {{ $data_wp_lokasi->kab }}, {{ $data_wp_lokasi->kec }}, {{ $data_wp_lokasi->kel }}</td>
                                <td>
                                    @if ($data_wp_lokasi->aktif == 'Y')
                                    <a href="{{route('toggle_lokasi-operator',['jenis'=>$jenis])}}?id={{$data_wp_lokasi->id}}&aktif=N" style="text-decoration:none">
                                        <span class="badge bg-success">Aktif</span>
                                    </a>
                                    @elseif ($data_wp_lokasi->aktif == 'N')delete_lokasi-operator
                                    <a href="{{route('toggle_lokasi-operator',['jenis'=>$jenis])}}?id={{$data_wp_lokasi->id}}&aktif=Y" style="text-decoration:none">
                                        <span class="badge bg-success">Mati</span>
                                    </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-info btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#detailWPLokasi{{ $data_wp_lokasi->id }}"><i class="fa-solid fa-eye"></i></button>
                                    @if ($active == 'wp lokasi')
                                    {{-- <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-solid fa-pen-to-square"></i></button> --}}
                                    <a href="{{route('delete_lokasi-operator',['jenis'=>$jenis])}}?id={{$data_wp_lokasi->id}}&aktif=N" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- modal detail -->
                    @include('operator.partials.modals.detail_wp_lokasi')
                    <!-- modal detail end -->
                    <!-- Detail User -->
                    @foreach ($user->whereIn('id', array_unique($user_id)) as $data_user)
                    @include('operator.partials.modals.detail_user')
                    @endforeach
                    <!-- END Detail User -->
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