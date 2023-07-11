<!--harga naik-->
@if($harga_naik->count()>0)
<div class="container" style="padding: 0.5rem 0">
    <div class="col-12 d-flex justify-content-center" style="padding: 0.5rem 0;">
        <h6 style="color: #176e41; font-weight: bold;">Harga sampah yang lagi naik hari ini:</h6>
    </div>
    {{-- <table class="table table-striped table-borderless" style="width: 100%">
        @foreach($harga_naik as $barang)
        <!--average calc-->
        @php
            $foto = $barang->foto;
            $imgurl = "https://ambilin.com/berkas/" . $foto ."";
            $av = (($barang->harga_top/$barang->old_top) * 100);
            $percentage = number_format($av, 1, '.', '');
            // $av_old = ($barang->old_down + $barang->old_top)/2;
            // $av_new = ($barang->harga_down + $barang->harga_top)/2;
            // $percentage = number_format((float)(($av_old/$av_new) * 100), 1, '.', '');
        @endphp 
        <!--average calc end-->

        <tr class="row">
            <td class="col-4 d-flex align-items-center justify-content-center">
                <img src="{{$imgurl}}" class="img-fluid" alt="{{$foto}}" style="max-height: 120px">
            </td>
            <td class="col-8">
                <h5>{{$barang->nama}}</h5>
                <p style="margin: 0">Harga tertinggi per kilogram:</p>
                Rp. {{ number_format($barang->old_top, 0, ',', '.') }}
                <!-- <p style="margin: 0">Rp. {{ number_format($barang->old_down, 0, ',', '.') }} - Rp. {{ number_format($barang->old_top, 0, ',', '.') }} |  (± Rp. {{ number_format($av_old, 0, ',', '.') }})</p> -->
                <p style="margin: 0">Naik {{$percentage}}% menjadi:</p>
                Rp. {{ number_format($barang->harga_top, 0, ',', '.') }}
                <!-- <p style="margin: 0">Rp. {{ number_format($barang->harga_down, 0, ',', '.') }} - Rp. {{ number_format($barang->harga_top, 0, ',', '.') }} | (± Rp. {{ number_format($av_new, 0, ',', '.') }})</p> -->
            </td>
        </tr>
        @endforeach
    </table> --}}
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
            @php $count = -1; @endphp
            @foreach ($harga_naik as $barang)
                @php $count++; @endphp
                <?php if ($count == 0) { ?>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $count ?>" class="active" aria-current="true"></button>
                <?php } else if ($count != 0) { ?>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $count ?>"></button>
                <?php } ?>
            @endforeach
        </div>
        <div class="carousel-inner">
            @php $count = -1; @endphp
            @foreach ($harga_naik as $barang)
            @php
                $count++;
                $foto = $barang->foto;
                $imgurl = "https://ambilin.com/berkas/" . $foto ."";
                $av = (($barang->harga_top/$barang->old_top) * 100);
                $percentage = number_format($av, 1, '.', '');
                // $av_old = ($barang->old_down + $barang->old_top)/2;
                // $av_new = ($barang->harga_down + $barang->harga_top)/2;
                // $percentage = number_format((float)(($av_old/$av_new) * 100), 1, '.', '');
            @endphp
            <?php if ($count == 0) { ?>
            <div class="carousel-item active">
            <?php } else if ($count != 0) { ?>
            <div class="carousel-item">
            <?php } ?>
                <div class="card border border-0 rounded-5" style="background-color: #90bc31; margin: 0 0.75rem;">
                    <div class="card-body row g-0">
                        <div class="col-4 d-flex justify-content-end">
                            <img src="{{$imgurl}}" class="img-fluid" alt="{{$barang->nama}}" style="max-height: 180px;border-radius:10%;">
                        </div>
                        <div class="col-8">
                        <div style="color: white; text-shadow: 1px 1px #176e41; font-weight: bold; padding: 0.5rem;">
                            <h5 class="card-title">{{$barang->nama}}</h5>
                            <!-- <p class="card-text" style="margin: 0">Harga tertinggi per kilogram:</p> 
                                Rp. {{ number_format($barang->old_top, 0, ',', '.') }} -->
                            <p class="card-text" style="margin: 0">Naik {{$percentage}}% menjadi:</p>
                            Rp. {{ number_format($barang->harga_top, 0, ',', '.') }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
</div>
{{-- <div class="container mx-auto justify-content-center d-flex mb-3" style="width:100%">
    {{ $harga_naik->links('pagination::bootstrap-4') }}
</div> --}}
@else
<!-- kosong -->
@endif
<!--harga naik end-->