@php
    $sum = 0;
    $epr_now = 0;
    if(isset($sum_epr)){
        $sum = $sum_epr;
    } else {
        $sum = 0;
    }

    if(isset($lt)){
        $now = $lt;
    } else {
        $epr_now = 0;
    }
@endphp
{{-- <div class="alert alert-success d-flex justify-content-center align-items-center" role="alert">
    <div class="row" style="margin-bottom: 0%">
        <div class="col-12" style="padding:0%;">
            <div class="col" style="text-align: center">
                <div><h5>Pengumpulan Poin EPR ku</h5></div>
                <div style="padding-bottom: 10px; font-size: 90%">{{$carb_now}}</div>
            </div>
        </div>
        <hr>
        <center>
        <div class="row row-cols-2" style="padding:0%;">
            <div class="col">
                    <div style="font-size: 90%">Poinku</div>
                    <div><h5>{{$epr}} <img style="width: 26px; height: 26px; padding-bottom: 4px; padding-right: 4px;" src="https://ambilin.com/ambilinapps/public/img/coin-epr.png"/></h5></div>
            </div>
            <div class="col">
                <div style="font-size: 90%">Total sejauh ini</div>
                <div><h5>{{$sum_epr}}</h5></div>
            </div>
        </div>
        </center>
    </div>
</div> --}}

<div style="padding: 1rem 1rem;">
    <div class="card rounded-3" style="background-color: #d1e7dd; border: 0;">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <h6 style="color: #176e41; font-weight: bold; margin: 0; padding-top: 0.75rem">Pengumpulan Poin EPR ku</h6>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <p style="color: #176e41; font-size: 90%; margin: 0;">{{$carb_now}}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row card-body d-flex justify-content-center">
            <div class="col-5" style="padding: 0">
                <div class="row">
                    <center style="padding: 0">
                    <div class="col-12 d-flex justify-content-center"><p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Poinku saat ini</p></div>
                    <div class="col-12 d-flex justify-content-center"><h1 style="color:#176e41; margin: 0;">
                        {{$epr}} <img style="width: 26px; height: 26px; padding-bottom: 4px; padding-right: 4px;" src="https://ambilin.com/ambilinapps/public/img/coin-epr.png"/>
                    </h1></div>
                    </center>
                </div>
            </div>
            <div class="col-1 d-flex"><div class="vr"></div></div>
            <div class="col-5" style="padding: 0">
                <div class="row">
                    <center style="padding: 0">
                    <div class="col-12 d-flex justify-content-center"><p style="font-size: 80%; font-weight: 600; color:#176e41; margin: 0;">Total sejauh ini</p></div>
                    <div class="col-12 d-flex justify-content-center"><h1 style="color:#176e41; margin: 0;">
                        {{$sum_epr}} <img style="width: 26px; height: 26px; padding-bottom: 4px; padding-right: 4px;" src="https://ambilin.com/ambilinapps/public/img/coin-epr.png"/>
                    </h1></div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>