@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_back')
    <!-- Navbar end -->
    <style>
        p {
            margin: 0;
        }

        .card-img-top {
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .rate {
            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 1em;
            font-size: 50px;
            font-weight: 300;
            color: rgb(250, 165, 0);
            cursor: pointer;
            display: flex;
            justify-content: center
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1 !important
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            /* opacity: 0.4 */
            opacity: 1
        }
    </style>
    <div class="container" style="padding-top: 2rem;">
        <div class="d-flex justify-content-center">
            <div class="card rounded-circle" style="width: 8rem; height: 8rem;">
                @if (!empty($data->foto_diri) && file_exists('public/img/foto/' . $data->foto_diri))
                    <img src="{!! asset('public/img/foto/' . $data->foto_diri) !!}" class="card-img-top rounded-circle" alt="{{ $data->nama }}">
                @else
                    <img src="{!! asset('https://ambilin.com/img/png/ambilin.png') !!}" class="card-img-top rounded-circle" alt="{{ $data->nama }} kosong">
                @endif
            </div>
        </div>
        <h4 style="margin: 0; margin-top:0.5rem; text-align: center;">{{ $data->nama }}</h4>
        <div class="row d-flex justify-content-center">
            @if ($status == 'beri')
                <div class="rate">
                    @php
                        $oldDate = \Carbon\Carbon::parse($data->tgl)->format('Y-m-d H:i:s');
                        $weekAfter = \Carbon\Carbon::parse($booking->waktu_booking)
                            ->addWeek()
                            ->format('Y-m-d H:i:s');
                        $today = \Carbon\Carbon::today()->format('Y-m-d H:i:s');
                    @endphp

                    <form action="{{ route('post_ratingku', ['id_booking' => $booking->id, 'id_ambilin' => $booking->ambilin_id]) }}" method="POST">
                        @csrf
                        <div class="col-auto">
                            <div class="rating">
                                {{-- {{dd($ada)}} --}}
                                <input type="radio" name="rating" value="5" id="rate5" @if(!empty($rating_ku) && $rating_ku->rating == 5) checked @endif>
                                <label for="rate5">☆</label>
                                <input type="radio"name="rating" value="4" id="rate4" @if(!empty($rating_ku) && $rating_ku->rating == 4) checked @endif>
                                <label for="rate4">☆</label>
                                <input type="radio" name="rating" value="3" id="rate3" @if(!empty($rating_ku) && $rating_ku->rating == 3) checked @endif>
                                <label for="rate3">☆</label>
                                <input type="radio" name="rating" value="2" id="rate2" @if(!empty($rating_ku) && $rating_ku->rating == 2) checked @endif>
                                <label for="rate2">☆</label>
                                <input type="radio" name="rating" value="1" id="rate1" @if(!empty($rating_ku) && $rating_ku->rating == 1) checked @endif>
                                <label for="rate1">☆</label>
                            </div>
                        </div>
                        <div class="col-12">
                            @if(!empty($rating_ku))
                            <div id='reason_form'>
                            @else
                            <div id='reason_form' class="visually-hidden">
                            @endif
                                <textarea type="text" name="reason" id="reason" class="form-control rounded-0" rows="5" placeholder="Yuk bantu kolektor ini menjadi lebih baik">@if(!empty($rating_ku)){{ $rating_ku->keterangan }}@endif</textarea>
                                <p class="visually-hidden" id="info_required" style="font-weight: 600;">Komentar wajib diisi</p>
                                <br>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto">
                                        <button class="btn btn-success rounded-1" type="submit" style="text-transform: capitalize; font-weight: 600;"><i class="fa-regular fa-paper-plane"></i>&nbsp;&nbsp;@if(!empty($rating_ku))Perbarui @else Kirim @endif</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>
                        const toggle1 = document.querySelector('#rate1');
                        const toggle2 = document.querySelector('#rate2');
                        const toggle3 = document.querySelector('#rate3');
                        const toggle4 = document.querySelector('#rate4');
                        const toggle5 = document.querySelector('#rate5');
                        const reason_form = document.querySelector('#reason_form');
                        const reason = document.querySelector('#reason');
                        const info = document.querySelector('#info_required');
                        // const star = document.querySelector('#requiredd');


                        toggle1.addEventListener('click', function(e) {
                            // toggle the type attribute
                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'flex-fill' :
                                'flex-fill';
                            // const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                            const infotype = info.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                            reason_form.setAttribute('class', type);
                            // star.setAttribute('class', startype);
                            info.setAttribute('class', infotype);
                            reason.setAttribute('required', '');
                        });

                        toggle2.addEventListener('click', function(e) {
                            // toggle the type attribute
                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'flex-fill' :
                                'flex-fill';
                            // const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                            const infotype = info.getAttribute('class') === 'tvisually-hidden' ? 'text-danger' : 'text-danger';
                            reason_form.setAttribute('class', type);
                            // star.setAttribute('class', startype);
                            info.setAttribute('class', infotype);
                            reason.setAttribute('required', '');
                        });

                        toggle3.addEventListener('click', function(e) {
                            // toggle the type attribute
                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'flex-fill' :
                                'flex-fill';
                            // const startype = star.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                            const infotype = info.getAttribute('class') === 'visually-hidden' ? 'text-danger' : 'text-danger';
                            reason_form.setAttribute('class', type);
                            // star.setAttribute('class', startype);
                            info.setAttribute('class', infotype);
                            reason.setAttribute('required', '');
                        });

                        toggle4.addEventListener('click', function(e) {
                            // toggle the type attribute
                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'flex-fill' :
                                'flex-fill';
                            // const startype = star.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' : 'visually-hidden';
                            const infotype = info.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' : 'visually-hidden';
                            reason_form.setAttribute('class', type);
                            // star.setAttribute('class', startype);
                            info.setAttribute('class', infotype);
                            reason.removeAttribute('required');
                        });

                        toggle5.addEventListener('click', function(e) {
                            // toggle the type attribute
                            const type = reason_form.getAttribute('class') === 'visually-hidden' ? 'flex-fill' :
                                'flex-fill';
                            // const startype = star.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' : 'visually-hidden';
                            const infotype = info.getAttribute('class') === 'visually-hidden' ? 'visually-hidden' : 'visually-hidden';
                            reason_form.setAttribute('class', type);
                            // star.setAttribute('class', startype);
                            info.setAttribute('class', infotype);
                            reason.removeAttribute('required');
                        });
                    </script>
                </div>
            @else
                <div>
                    <br>
                    <p style="text-align: center; color:darkgrey;">{{ \Carbon\Carbon::parse($rating_ku->waktu_catat)->format("Y-m-d H:i") }}</p>
                    <h1 style="margin: 0; text-align: center;">
                        @php
                            $rating = (float)$rating_ku->rating;
                            $num = number_format($rating, 0, ',', '.');
                            if (fmod($rating, 1) == 0.00) {
                                if ($num < 5) {$minus = 5 - $num;}
                            } else {
                                if ($num < 4) {$minus = 4 - $num;}
                            };
                        @endphp
                        @for ($i = 0; $i < $num; $i++)
                            <i class="fa-solid fa-star text-warning"></i>
                        @endfor
                        @if (fmod($rating, 1) !== 0.00)
                            <i class="fa-solid fa-star-half-stroke text-warning"></i>
                        @endif
                        @if (!empty($minus))
                            @for ($i = 0; $i < $minus; $i++)
                                <i class="fa-regular fa-star text-warning"></i>
                            @endfor
                        @endif
                    </h1>
                    {{-- <p style="margin:0; text-align: center; color:darkgrey;">
                        &nbsp;{{number_format($rating, 1, ',', '.')}}/5,0
                    </p> --}}
                    <br>
                    @if (!empty($rating_ku->keterangan))
                        <div class="container">
                            <h6 style="text-align: center">Keterangan :</h6>
                            <p style="text-align: center">{{ $rating_ku->keterangan }}</p>
                            <br>
                        </div>
                    @endif
                    @if (($today) <= (\Carbon\Carbon::parse($ambilin->waktuubah)->addWeeks(1)->format("Y-m-d H:i:s")))
                    <div class="row d-flex justify-content-center">
                        <div class="col-auto">
                            <a class="btn btn-outline-warning rounded-1" href="{{ route('beri_rating_kolektor', ['id_booking' => $booking->id]) }}" style="text-transform: capitalize; font-weight: 600;"><i class="fa-regular fa-pen-to-square"></i>&nbsp;&nbsp;Ubah Penilaian</a>
                        </div>
                    </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <!-- Content End -->
@endsection
