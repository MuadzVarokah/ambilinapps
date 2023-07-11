@if(!empty($per_induk->nama))
    @php
        $merek_str = strtolower($merek->merek);
        $merekini = $per_induk->nama;
        if(!empty($merek->merek && $merek_str != 'semua merek')){
            $merekini = $merek->merek;
        }
    @endphp
    {{-- {{dd(get_defined_vars());}} --}}
<div style="padding: 1rem 1rem; padding-top: 0;">
    <div class="card rounded-3" style="background-color: #d1e7dd; border: 0;">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <h6 style="color: #176e41; font-weight: bold; margin: 0; padding-top: 0.75rem">Total sampah {{$merekini}} terkumpul</h6>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <p style="color: #176e41; font-size: 90%; margin: 0;">{{$now}}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row card-body d-flex justify-content-center">
            <div class="col-5" style="padding: 0">
                <div class="row">
                    <center style="padding: 0">
                    <div class="col-12 d-flex justify-content-center"><p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Total sejauh ini</p></div>
                    <div class="col-12 d-flex justify-content-center"><h1 style="color:#176e41; margin: 0;">
                        @php
                        if($totalsum < 1){
                            $totalsum = $totalsum*1000;
                            $totalsum_unit = 'gr';
                        } elseif ($totalsum > 1000) {
                            $totalsum = $totalsum/1000;
                            $totalsum_unit = 'ton';
                        } else {
                            $totalsum_weight = $totalsum;
                            $totalsum_unit = 'kg';
                        }  
                        @endphp
                        {{$totalsum_weight}}<span style="font-size: 75%">{{$totalsum_unit}}</span>
                    </h1></div>
                    </center>
                </div>
            </div>
            <div class="col-1 d-flex"><div class="vr"></div></div>
            <div class="col-5" style="padding: 0">
                <div class="row">
                    <center style="padding: 0">
                    <div class="col-12 d-flex justify-content-center">
                        <p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Kontribusi anda</p>
                    </div>
                    @php
                        if(!empty($mysum)&&(!empty($totalsum))){
                            $myperc = $mysum/$totalsum*100;
                        } elseif (empty($mysum)) {
                            $mysum = 0;
                            $myperc = 0;
                        } elseif(empty($totalsum)){
                            $mysum = 0;
                            $totalsum = 0;
                            $myperc = 0;
                        }
                        if($mysum < 1){
                            $mysum_weight = $mysum*1000;
                            $mysum_unit = 'gr';
                        } elseif ($mysum > 1000) {
                            $mysum_weight = $mysum/1000;
                            $mysum_unit = 'ton';
                        } else {
                            $mysum_weight = $mysum;
                            $mysum_unit = 'kg';
                        }
                    @endphp
                    <div class="col-12 d-flex justify-content-center">
                        <h1 style="color:#176e41; margin: 0;">
                            {{$mysum_weight}}<span style="font-size: 75%">{{$mysum_unit}}</span> <span style="font-weight:400; font-size:80%; margin:0">({{ number_format($myperc, 1, ',', '.') }}%)</span>
                        </h1>
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
@endif