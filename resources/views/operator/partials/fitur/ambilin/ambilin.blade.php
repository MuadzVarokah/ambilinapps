<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">
{{-- <link rel="stylesheet" href="{!! asset('public/operator/vendors/choices.js/choices.min.css') !!}" /> --}}

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
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="table1" style="font-size: 90%; width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                {{-- <th>Foto</th> --}}
                                <th>User</th>
                                <th>Waktu Ambil</th>
                                <th>Lokasi</th>
                                <th>Keterangan</th>
                                @if (($active == 'ambilin terambil') || ($active == 'ambilin proses') || ($active == 'ambilin dibatalkan') || ($active == 'ambilin dihapus'))
                                    <th>Kolektor</th>
                                @endif
                                @if ($active == 'ambilin dihapus')
                                    <th>Alasan Hapus</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $user_id = []; @endphp
                            @foreach ($data as $data_ambilin)
                            @php $user_id[] = $data_ambilin->wp_id; @endphp
                            <tr>
                                <td>{{ $data_ambilin->barkas_id }}</td>
                                <td>{{ $data_ambilin->wp_id }} - {{ $data_ambilin->nama }} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detail{{ $data_ambilin->wp_id }}"><i class="fa-solid fa-circle-info text-info"></i></a></td>
                                <td>
                                    {{ $data_ambilin->tgl }}, {{ $data_ambilin->waktu }}
                                    <br>
                                    @if (($active == 'ambilin tersedia') || ($active == 'ambilin proses'))
                                        @php $newDate = date("Y-m-d H:i:s", strtotime($data_ambilin->tgl)); @endphp
                                        @if ($newDate < $today)
                                            <div class="badge bg-danger">Melampaui Jadwal</div>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $data_ambilin->idlokasi }} - {{ $data_ambilin->nama_lokasi }} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailLokasi{{ $data_ambilin->barkas_id }}"><i class="fa-solid fa-circle-info text-info"></i></a></td>
                                <td style="overflow-wrap: break-word; white-space: normal; max-width: 0;">{{ $data_ambilin->keterangan }}</td>
                                @if (($active == 'ambilin terambil') || ($active == 'ambilin proses') || ($active == 'ambilin dibatalkan') || ($active == 'ambilin dihapus'))
                                <td>
                                    @if (!empty($kolektor->where('ambilin_id', $data_ambilin->barkas_id)))
                                    @foreach ($kolektor->where('ambilin_id', $data_ambilin->barkas_id) as $data_kolektor)
                                        {{$data_kolektor->user_id}} - {{$data_kolektor->nama}} <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detail{{ $data_kolektor->user_id }}"><i class="fa-solid fa-circle-info text-info"></i></a>
                                        @php $user_id[] = $data_kolektor->user_id; @endphp
                                    @endforeach
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- @elseif ($active == 'ambilin dibatalkan')
                                <td></td> --}}
                                @endif
                                @if ($active == 'ambilin dihapus')
                                <td style="overflow-wrap: break-word; white-space: normal; max-width: 0;">
                                    @foreach ($alasan_hapus->where('id_ambilin', $data_ambilin->barkas_id) as $hapus)
                                        {{ $hapus->alasan }}
                                    @endforeach
                                </td>
                                @endif
                                <td class="text-center">
                                    <button class="btn btn-outline-info btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#detailAmbilin{{ $data_ambilin->barkas_id }}"><i class="fa-solid fa-eye"></i></button>
                                    @if (($active == 'ambilin tersedia') || ($active == 'ambilin proses'))
                                    <button class="btn btn-outline-success btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#editKolektor{{ $data_ambilin->barkas_id }}"><i class="fa-solid fa-hand-holding-heart"></i></button>
                                    <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#editWaktu{{ $data_ambilin->barkas_id }}"><i class="fa-solid fa-clock"></i></button>
                                    @elseif(($active != 'ambilin dihapus') && ($active != 'ambilin request'))
                                    <a href="{{route('delete_barkas-operator',['id'=>$data_ambilin->barkas_id])}}?jenis={{$jenis}}&delete=ambilin" onclick="return confirm('apakah anda yakin?')" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            <!-- modal edit -->
                            @if (($active == 'ambilin tersedia') || ($active == 'ambilin proses'))
                                @include('operator.partials.modals.edit_kolektor_ambilin')
                                @include('operator.partials.modals.edit_waktu_ambilin')
                            @endif
                            <!-- end modal edit -->
                            @endforeach
                        </tbody>
                    </table>
                    <!-- modal detail -->
                    @include('operator.partials.modals.detail_barang_ambilin')
                    <!-- end modal detail -->
                    <!-- Detail Lokasi -->
                    @include('operator.partials.modals.detail_lokasi_barkas')
                    <!-- END Detail Lokasi -->
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

<!-- Include Choices JavaScript -->
{{-- <script src="{!! asset('public/operator/vendors/choices.js/choices.min.js') !!}"></script> --}}

<script type="text/javascript">
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>