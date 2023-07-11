<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title" style="text-transform: capitalize">{{$active}}</h3>
                    <p class="text-subtitle text-muted"><span style="text-transform: capitalize">{{$active}}</span> yang ada pada Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize">{{$active}}</li>
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
                                <th>Pemilik</th>
                                <th>Foto</th>
                                <th>Judul</th>
                                {{-- <th>Deskripsi</th> --}}
                                <th>Kondisi</th>
                                <th>Jenis</th>
                                @if ($jenis != 'sebar')
                                <th>Harga</th>
                                @endif
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $user_id = []; @endphp
                            @foreach ($data as $data_barkas)
                            @php $user_id[] = $data_barkas->wp_id; @endphp
                            <tr>
                                <td>{{ $data_barkas->barkas_id }}</td>
                                <td>{{ $data_barkas->wp_id }} - {{ $data_barkas->nama }} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detail{{ $data_barkas->wp_id }}"><i class="fa-solid fa-circle-info text-info"></i></a></td>
                                <td class="text-center">
                                    <img src="{{ asset('public/img/'.$jenis.'/'.$data_barkas->foto) }}" alt="{{$data_barkas->foto}}" style="max-height: 10rem;">
                                </td>
                                <td>{{ $data_barkas->judul }}</td>
                                {{-- <td>{{ $data_barkas->deskripsi }}</td> --}}
                                <td>{{ $data_barkas->kondisi }}</td>
                                <td>{{ $data_barkas->jenis }}</td>
                                @if ($jenis != 'sebar')
                                <td>Rp. {{ $data_barkas->harga }}</td>
                                @endif
                                <td>{{ $data_barkas->idlokasi }} - {{ $data_barkas->nama_lokasi }} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailLokasi{{ $data_barkas->barkas_id }}"><i class="fa-solid fa-circle-info text-info"></i></a></td>
                                <td>
                                    @if ($data_barkas->aktif == 1)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-danger">Mati</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-info btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#detailBarkas{{ $data_barkas->barkas_id }}"><i class="fa-solid fa-eye"></i></button>
                                    {{-- <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-solid fa-pen-to-square"></i></button> --}}
                                    @if ($data_barkas->hapus != 1)
                                    <a href="{{route('delete_barkas-operator',['id'=>$data_barkas->barkas_id])}}?jenis={{$active}}&delete={{$jenis}}" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Detail Barkas -->
                    @include('operator.partials.modals.detail_barkas')
                    <!-- END Detail Barkas -->
                    <!-- Detail Lokasi -->
                    @include('operator.partials.modals.detail_lokasi_barkas')
                    <!-- END Detail Lokasi -->
                    {{-- {{dd(array_unique($user_id))}} --}}
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