@extends('layouts.default')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar_umum')
    <!-- Navbar end -->
    <!--content-->
    <div class="container" style="padding-top:1rem">
        <table class="table table-borderless table-sm" style="text-align:center; width:100%">
            <tr>
                <td style="width: 50%">
                    <p>Tanggal pendaftaran</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td style="width: 40%">
                    <p style="font-size:80%"><b>{{ \Carbon\Carbon::parse($user->waktu_catat)->translatedFormat('l, d F Y') }}</b></p>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table table-borderless table-sm " style="text-align:center; width:100%;">
            <tr>
                <td style="width: 50%">
                    <p>Jumlah transaksi ambilin</p>
                </td>
                <td>
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $sum_amb }}</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <p>Total poin loyalty</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $sum_lt }}</b></p>
                </td>

            </tr>
            <tr>
                <td style="width: 50%">
                    <p>Total penggunaan poin loyalty</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $usage_lt }}</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <p>Poin loyalty saat ini</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $point_lt }}</b></p>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table table-borderless table-sm" style="text-align:center; width:100%">
            <tr>
                <td style="width: 50%">
                    <p>Total poin EPR</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $sum_epr }}</b></p>
                </td>

            </tr>
            <tr>
                <td style="width: 50%">
                    <p>Total penggunaan poin EPR</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td>
                    <p><b>{{ $usage_epr }}</b></p>
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <p>Poin EPR saat ini</p>
                </td>
                <td style="width: 10%">
                    <p>:</p>
                </td>
                <td style="">
                    <p><b>{{ $point_epr }}</b></p>
                </td>
            </tr>
        </table>
        <center>
            <div class="row">
                <div class="col">
                    <a class="btn btn-success" href="history/ambilin/income">History poin lt</a>
                </div>
                <div class="col">
                    <a class="btn btn-success" href="history/epr/income">History poin epr</a>
                </div>
            </div>
        </center>
    </div>
    <!--content end-->
@endsection
{{-- @include('partials.shortcut') --}}
