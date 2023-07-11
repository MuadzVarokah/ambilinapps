<link rel="stylesheet" href="{!! asset('public/operator/vendors/simple-datatables/style.css') !!}">

<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="title">Lupa Password</h3>
                    <p class="text-subtitle text-muted">User yang mengajukan lupa password di Ambilin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index-operator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lupa Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- {{dd($data)}} --}}

        <!-- Datatable -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="table1" style="font-size: 90%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Waktu Update</th>
                                <th>Waktu Create</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data_user)
                            <tr>
                                <td>{{ $data_user->id }}</td>
                                <td>{{ $data_user->username }} - {{ $data_user->nama }}</td>
                                {{-- <td>{{ $data_user->verified }}</td> --}}
                                <td>
                                    {{-- {{$data_user->status}} --}}
                                    @if ($data_user->status == 0)
                                        <span class="badge bg-secondary">{{$data_user->stat}}</span>
                                    @elseif($data_user->status == 1)
                                        <span class="badge bg-danger">{{$data_user->stat}}</span>
                                    @elseif($data_user->status == 2)
                                        <span class="badge bg-primary">{{$data_user->stat}}</span>
                                    @elseif($data_user->status == 3)
                                        <span class="badge bg-success">{{$data_user->stat}}</span>
                                    @endif
                                    {{-- @if ($data_user->verified == 'New')
                                        <span class="badge bg-primary">{{$data_user->verified}}</span>
                                    @elseif ($data_user->verified == 'Verifying')
                                        <span class="badge bg-warning">{{$data_user->verified}}</span>
                                    @elseif ($data_user->verified == 'Verified')
                                        <span class="badge bg-success">{{$data_user->verified}}</span>
                                    @elseif ($data_user->verified == 'Unverified')
                                        <span class="badge bg-danger">{{$data_user->verified}}</span>
                                    @endif --}}
                                </td>
                                <td>{{ $data_user->updated_at }}</td>
                                <td>{{ $data_user->created_at }}</td>
                                <td class="text-center">
                                    @if(($data_user->status == 1) || ($data_user->status == 2))
                                    <a href="{{route('post_lupa-operator', ['id' => $data_user->id])}}" class="btn btn-outline-success btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="kirim" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                                    @else
                                    <button disabled class="btn btn-success btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="kirim"><i class="fa-brands fa-whatsapp"></i></button>
                                    @endif
                                    {{-- <button class="btn btn-outline-warning btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-solid fa-pen-to-square"></i></button> --}}
                                    {{-- <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" style="margin: 0.15rem 0;" data-bs-toggle="tooltip" data-bs-placement="top" title="Nonaktifkan"><i class="fa-solid fa-power-off"></i></a> --}}
                                </td>
                            </tr>
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