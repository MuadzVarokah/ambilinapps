<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <h3 class="title">Dashboard</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Ambilin</h6>
                                        <h6 class="font-extrabold mb-0" style="color: darkslategray"><i class="fa fa-globe text-primary"></i> {{$cnt_ambilin}} | <span><i class="fa fa-power-off text-success"></i></span> {{$amb_aktif}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Mitra</h6>
                                        <h6 class="font-extrabold mb-0" style="color: darkslategray"> <i class="fa fa-globe text-primary"></i> {{$cnt_mitra}} | <span><i class="fa fa-power-off text-success"></i></span> {{$mtr_aktif}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Bank Sampah</h6>
                                        <h6 class="font-extrabold mb-0" style="color: darkslategray"> <i class="fa fa-globe text-primary"></i> {{$cnt_bs}} | <span><i class="fa fa-power-off text-success"></i></span> {{$bs_aktif}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Kolektor</h6>
                                        <h6 class="font-extrabold mb-0" style="color: darkslategray"> <i class="fa fa-globe text-primary"></i> {{$cnt_kolektor}} | <span><i class="fa fa-power-off text-success"></i></span> {{$kltr_aktif}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="card" style="margin: 0;">
                    <div class="card-body">
                        <h5 class="card-title">Chart Log</h5>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <!-- Tabs navs -->
                        <ul class="nav nav-tabs mb-3 mt-3" id="ex-with-icons" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="ambilin-tab" data-bs-toggle="tab" data-bs-target="#ambilin-tab-pane" href="javascrip:void(0)" role="tab" aria-controls="ambilin-tab-pane" aria-selected="true">
                                    Ambilin
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="paskas-tab" data-bs-toggle="tab" data-bs-target="#paskas-tab-pane" href="javascrip:void(0)"data-bs-toggle="tab" data-bs-target="#sebar-tab-pane" href="javascrip:void(0)" role="tab" aria-controls="paskas-tab-pane" aria-selected="false">
                                    Paskas
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="sebar-tab" data-bs-toggle="tab" data-bs-target="#sebar-tab-pane" href="javascrip:void(0)" role="tab" aria-controls="sebar-tab-pane" aria-selected="false">
                                    Sebar
                                </a>
                            </li>
                        </ul>
                        <!-- Tabs navs -->
                        
                        <!-- Tabs content -->
                        <div class="tab-content" id="ex-with-icons-content">
                            <div class="tab-pane fade show active" id="ambilin-tab-pane" role="tabpanel" aria-labelledby="ambilin-tab-pane">
                                <div class="container">
                                    <canvas id="ambilin-chart"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="paskas-tab-pane" role="tabpanel" aria-labelledby="paskas-tab-pane">
                                <div class="container">
                                    <canvas id="paskas-chart"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sebar-tab-pane" role="tabpanel" aria-labelledby="sebar-tab-pane">
                                <div class="container">
                                    <canvas id="sebar-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Tabs content -->

                        @include('operator.partials.chart.chart_dashboard')
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card" style="margin: 0;">
                    <div class="card-body" style="padding-bottom: 0.5rem;">
                        <h5 class="card-title">Berat Ambilin</h5>
                        <p class="card-text">{{ $now }}</p>
                        <hr style="margin-bottom: 0.5rem;">
                        {{-- <h6 class="card-subtitle mb-2 text-muted">Minggu ini</h6>
                        <p class="card-text">5 Kg</p>
                        <h6 class="card-subtitle mb-2 text-muted">Bulan ini</h6>
                        <p class="card-text">25 Kg</p>
                        <h6 class="card-subtitle mb-2 text-muted">Tahun ini</h6>
                        <p class="card-text">250 Kg</p> --}}
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item row d-flex justify-content-between" style="padding-left: 0; padding-right: 0;">
                                <div class="col-auto" style="padding-right: 0">
                                    <h6 class="card-subtitle text-muted" style="margin: 0;">Minggu ini</h6>
                                </div>
                                <div class="col-auto" style="padding-left: 0">
                                    <p class="card-text">{{ $berat_minggu }} Kg</p>
                                </div>
                            </li>
                            <li class="list-group-item row d-flex justify-content-between" style="padding-left: 0; padding-right: 0;">
                                <div class="col-auto" style="padding-right: 0">
                                    <h6 class="card-subtitle text-muted" style="margin: 0;">Bulan ini</h6>
                                </div>
                                <div class="col-auto" style="padding-left: 0">
                                    <p class="card-text">{{ $berat_bulan }} Kg</p>
                                </div>
                            </li>
                            <li class="list-group-item row d-flex justify-content-between" style="padding-left: 0; padding-right: 0;">
                                <div class="col-auto" style="padding-right: 0">
                                    <h6 class="card-subtitle text-muted" style="margin: 0;">Tahun ini</h6>
                                </div>
                                <div class="col-auto" style="padding-left: 0">
                                    <p class="card-text">{{ $berat_tahun }} Kg</p>
                                </div>
                            </li>
                          </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>