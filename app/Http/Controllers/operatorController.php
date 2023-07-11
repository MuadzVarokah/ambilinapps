<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Alasan_ambilin;
use App\Models\Ambilin;
use App\Models\User;
use App\Models\Berat;
use App\Models\Booking;
use App\Models\EPR_History;
use App\Models\Harga;
use App\Models\Hapus;
use App\Models\Kat_user;
use App\Models\Lupa_password;
use App\Models\Pangkat;
use App\Models\Paskas;
use App\Models\Rating;
use App\Models\Sebar;
use App\Models\Waste_date;
use App\Models\Waste_time;
use App\Models\WP_Lokasi;
use App\Models\Notifikasi_Raw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class operatorController extends BaseController
{
    /* counts */
    public function index()
    {
        $active = 'dashboard';
        $page = 'operator.partials.dashboard';

        Carbon::SetLocale('id');
        $raw_now = Carbon::now();
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $tomorrow = Carbon::tomorrow()->format("Y-m-d H:i:s");

        $now = $raw_now->translatedFormat('l, d F Y');
        $weekStartDate = $raw_now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $raw_now->endOfWeek()->format('Y-m-d H:i');
        $monthStartDate = $raw_now->startOfMonth()->format('Y-m-d H:i');
        $monthEndDate = $raw_now->endOfMonth()->format('Y-m-d H:i');
        $yearStartDate = $raw_now->startOfYear()->format('Y-m-d H:i');
        $yearEndDate = $raw_now->endOfYear()->format('Y-m-d H:i');
        // dd($weekStartDate, $weekEndDate, $monthStartDate, $monthEndDate, $yearStartDate, $yearEndDate);

        $cnt_ambilin = Ambilin::count();
        $amb_aktif = Ambilin::where('hapus', '0')->count();
        $cnt_mitra = User::where('kat_user', 1)->count();
        $mtr_aktif = User::where('kat_user', 1)->where('verified', 2)->where('delete', 'tidak')->count();
        $cnt_kolektor = User::where('kat_user', 2)->count();
        $kltr_aktif = User::where('kat_user', 2)->where('verified', 2)->where('delete', 'tidak')->count();
        $cnt_bs = User::where('kat_user', 3)->count();
        $bs_aktif = User::where('kat_user', 3)->where('verified', 2)->where('delete', 'tidak')->count();

        /** Data Berat */
        $berat_minggu = Ambilin::join('uns_berat', 'uns_berat.id_ambilin', 'ambilin.id')
            ->select('uns_berat.berat', 'ambilin.waktuubah')
            ->where('ambilin.status', 3)
            ->where('waktuubah', '>=', $weekStartDate)
            ->where('waktuubah', '<=', $weekEndDate)
            ->sum('uns_berat.berat_riil');
        $berat_bulan = Ambilin::join('uns_berat', 'uns_berat.id_ambilin', 'ambilin.id')
            ->select('uns_berat.berat', 'ambilin.waktuubah')
            ->where('ambilin.status', 3)
            ->where('waktuubah', '>=', $monthStartDate)
            ->where('waktuubah', '<=', $monthEndDate)
            ->sum('uns_berat.berat_riil');
        $berat_tahun = Ambilin::join('uns_berat', 'uns_berat.id_ambilin', 'ambilin.id')
            ->select('uns_berat.berat', 'ambilin.waktuubah')
            ->where('ambilin.status', 3)
            ->where('waktuubah', '>=', $yearStartDate)
            ->where('waktuubah', '<=', $yearEndDate)
            ->sum('uns_berat.berat_riil');
        // dd($berat_minggu, $berat_bulan, $berat_tahun);
        /** */

        /** Chart */
        //Labels
        $this_month = Carbon::today()->month;
        $num_label = array();
        $label = array();
        for($i = 0; $i <= 8; $i++) {
            array_push($num_label, Carbon::today()->subMonth($i)->month);
            array_push($label, Carbon::today()->subMonth($i)->translatedFormat('F'));
        }
        // dd($num_label, $label);

        //Ambilin Raw
        $ambilin_all = Ambilin::selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        $ambilin_sukses = Ambilin::where('status', 3)
            ->selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        // dd($ambilin_all->pluck('data'), $ambilin_sukses->pluck('data'));

        //Paskas Raw
        $paskas_all = Paskas::selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        $paskas_lolos = Paskas::whereIn('status_publikasi', [2,4])
            ->selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        $paskas_laku = Paskas::where('status_publikasi', 4)
            ->selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        // dd($paskas_all, $paskas_lolos, $paskas_laku);

        //Sebar Raw
        $sebar_all = Sebar::selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        $sebar_lolos = Sebar::whereIn('status_publikasi', [2,4])
            ->selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        $sebar_laku = Sebar::where('status_publikasi', 4)
            ->selectRaw('year(waktucatat) tahun, month(waktucatat) bulan, monthname(waktucatat) nama_bulan, count(*) data')
            ->groupBy('tahun', 'bulan', 'nama_bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
        // dd($paskas_all, $paskas_lolos, $paskas_laku);

        //Processed data
        $data_ambilin_all = array();
        $data_ambilin_sukses = array();
        $data_paskas_all = array();
        $data_paskas_lolos = array();
        $data_paskas_laku = array();
        $data_sebar_all = array();
        $data_sebar_lolos = array();
        $data_sebar_laku = array();
        foreach($num_label as $num) {
            //Ambilin
            $val_ambilin_all = $ambilin_all->where('bulan', $num)->pluck('data')->first();
            if(empty($val_ambilin_all)) {
                $val_ambilin_all = 0;
            }
            array_push($data_ambilin_all, $val_ambilin_all);

            $val_ambilin_sukses = $ambilin_sukses->where('bulan', $num)->pluck('data')->first();
            if(empty($val_ambilin_sukses)) {
                $val_ambilin_sukses = 0;
            }
            array_push($data_ambilin_sukses, $val_ambilin_sukses);

            //Paskas
            $val_paskas_all = $paskas_all->where('bulan', $num)->pluck('data')->first();
            if(empty($val_paskas_all)) {
                $val_paskas_all = 0;
            }
            array_push($data_paskas_all, $val_paskas_all);

            $val_paskas_lolos = $paskas_lolos->where('bulan', $num)->pluck('data')->first();
            if(empty($val_paskas_lolos)) {
                $val_paskas_lolos = 0;
            }
            array_push($data_paskas_lolos, $val_paskas_lolos);
            
            $val_paskas_laku = $paskas_laku->where('bulan', $num)->pluck('data')->first();
            if(empty($val_paskas_laku)) {
                $val_paskas_laku = 0;
            }
            array_push($data_paskas_laku, $val_paskas_laku);

            //Sebar
            $val_sebar_all = $sebar_all->where('bulan', $num)->pluck('data')->first();
            if(empty($val_sebar_all)) {
                $val_sebar_all = 0;
            }
            array_push($data_sebar_all, $val_sebar_all);

            $val_sebar_lolos = $sebar_lolos->where('bulan', $num)->pluck('data')->first();
            if(empty($val_sebar_lolos)) {
                $val_sebar_lolos = 0;
            }
            array_push($data_sebar_lolos, $val_sebar_lolos);
            
            $val_sebar_laku = $sebar_laku->where('bulan', $num)->pluck('data')->first();
            if(empty($val_sebar_laku)) {
                $val_sebar_laku = 0;
            }
            array_push($data_sebar_laku, $val_sebar_laku);
        }
        return view('operator/index', compact(
            'active',
            'cnt_ambilin',
            'amb_aktif',
            'cnt_mitra',
            'mtr_aktif',
            'cnt_kolektor',
            'kltr_aktif',
            'cnt_bs',
            'bs_aktif',
            'page',
            'label',
            'data_ambilin_all',
            'data_ambilin_sukses',
            'data_paskas_all',
            'data_paskas_lolos',
            'data_paskas_laku',
            'data_sebar_all',
            'data_sebar_lolos',
            'data_sebar_laku',
            'now',
            'berat_minggu',
            'berat_bulan',
            'berat_tahun'
        ));
    }
    /* counts end */

    /* user */
    /* mitra */
    public function tambah_user() {
        $active = 'tambah user';
        $page = 'operator.partials.user.tambah_user';
        $pekerjaan = DB::table('pekerjaan')->get();
        $pendidikan = DB::table('pendidikan')->get();
        // $provinsi = DB::table('indonesia_provinces')->get();
        /* Kota Semarang */
        $provinsi = DB::table('indonesia_provinces')->where('id', 33)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', 3374)->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        /* End Kota Semarang */
        $kat = Kat_user::all();
        return view('operator/index', compact('active', 'page', 'pekerjaan', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'kat'));
    }

    public function getKabupaten(Request $request)
    {
        $provID = $request->provID;
        $kabupaten = DB::table('indonesia_cities')->where('province_id', $provID)->get();

        if ($provID == 'TRUE') {
            echo "<select class='form-control form-select' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                echo "<option value='$kab->id'>$kab->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-control form-select' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                echo "<option value='$kab->id'>$kab->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKecamatan(Request $request)
    {
        $kabID = $request->kabID;
        $kecamatan = DB::table('indonesia_districts')->where('city_id', $kabID)->get();

        if ($kabID == 'TRUE') {
            echo "<select class='form-control form-select' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                echo "<option value='$kec->id'>$kec->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-control form-select' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                echo "<option value='$kec->id'>$kec->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKelurahan(Request $request)
    {
        $kecID = $request->kecID;
        $kelurahan = DB::table('indonesia_villages')->where('district_id', $kecID)->get();

        if ($kecID == 'TRUE') {
            echo "<select class='form-control form-select' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                echo "<option value='$kel->id'>$kel->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-control form-select' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                echo "<option value='$kel->id'>$kel->name</option>";
            }
            echo "</select>";
        }
    }

    public function mitra_new($jenis)
    {
        $page = 'operator.partials.user.mitra.new';
        $pekerjaan = DB::table('pekerjaan')->get();
        $pendidikan = DB::table('pendidikan')->get();
        $provinsi = DB::table('indonesia_provinces')->get();
        if($jenis == 'rumah_tangga'){
            $active = 'mitra new';

            $data = User::where('uns_user.kat_user', 1)
                ->where('uns_user.verified', 0)
                ->where('uns_user.delete', 'tidak')
                ->join('uns_verified', 'uns_verified.id', 'uns_user.verified')
                ->select('uns_user.*','uns_verified.verified')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'bank_sampah'){
            $active = 'bank sampah new';
            // $page = 'operator.partials.user.bank_sampah.new';
            $data = User::where('uns_user.kat_user', 3)
                ->where('uns_user.verified', 0)
                ->where('uns_user.delete', 'tidak')
                ->select('uns_user.*')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'kolektor') {
            $active = 'kolektor new';
            // $page = 'operator.partials.user.kolektor.new';
            $data = User::where('uns_user.kat_user', 2)
                ->where('uns_user.verified', 0)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        }

        return view('operator/index', compact('active', 'data', 'page', 'jenis', 'pekerjaan', 'pendidikan', 'provinsi'));
    }

    public function mitra_verifying($jenis)
    {
        $page = 'operator.partials.user.mitra.verifying';
        if($jenis == 'rumah_tangga'){
            $active = 'mitra verifying';
            $data = User::where('uns_user.kat_user', 1)
                ->where('uns_user.verified', 1)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                // ->leftjoin('wp_lokasi', 'wp_lokasi.wp_id', '=', 'ambilin.idlokasi')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'bank_sampah') {
            $active = 'bank sampah verifying';
            // $page = 'operator.partials.user.bank_sampah.verifying';
            $data = User::where('uns_user.kat_user', 3)
                ->where('uns_user.verified', 1)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        }
        return view('operator/index', compact('active', 'data', 'page', 'jenis'));
    }

    public function mitra_verified($jenis)
    {
            $page = 'operator.partials.user.mitra.verified';
            if($jenis == 'rumah_tangga'){
            $active = 'mitra verified';
            $data = User::where('uns_user.kat_user', 1)
                ->where('uns_user.verified', 2)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'bank_sampah') { 
            $active = 'bank sampah verified';
            // $page = 'operator.partials.user.bank_sampah.verified';
            $data = User::where('uns_user.kat_user', 3)
                ->where('uns_user.verified', 2)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'kolektor'){
            $active = 'kolektor verified';
            // $page = 'operator.partials.user.kolektor.verified';
            $data = User::where('uns_user.kat_user', 2)
                ->where('uns_user.verified', 2)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        }
        return view('operator/index', compact('active', 'data', 'page', 'jenis'));
    }

    public function mitra_unverified($jenis)
    {
        $page = 'operator.partials.user.mitra.unverified';
        if($jenis == 'rumah_tangga'){
            $active = 'mitra unverified';
            $data = User::where('uns_user.kat_user', 1)
                ->where('uns_user.verified', 3)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'bank_sampah') {
            $active = 'bank sampah unverified';
            // $page = 'operator.partials.user.bank_sampah.unverified';
            $data = User::where('uns_user.kat_user', 3)
                ->where('uns_user.verified', 3)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        } elseif($jenis == 'kolektor'){
            $active = 'kolektor unverified';
            // $page = 'operator.partials.user.kolektor.unverified';
            $data = User::where('uns_user.kat_user', 2)
                ->where('uns_user.verified', 3)
                ->where('uns_user.delete', 'tidak')
                ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
                ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
                ->select(
                    'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                    'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
                ->orderby('uns_user.id', 'desc')
                ->get();
        }

        return view('operator/index', compact('active', 'data', 'page', 'jenis'));
    }

    public function mitra_edit($jenis, Request $request) {
        // $request->validate([
        //     'id'    => 'required',
        // ]);
        // dd($jenis, $request->id);
        $page = 'operator.partials.user.mitra.mitra_edit';
        if($jenis == 'rumah_tangga') {
            $active = 'mitra new';
        } elseif ($jenis == 'bank_sampah') {
            $active = 'bank sampah new';
        } elseif ($jenis == 'kolektor') {
            $active = 'kolektor new';
        }
        $pekerjaan = DB::table('pekerjaan')->get();
        $pendidikan = DB::table('pendidikan')->get();
        // $provinsi = DB::table('indonesia_provinces')->get();
        /* Kota Semarang */
        $provinsi = DB::table('indonesia_provinces')->where('id', 33)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', 3374)->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        /* End Kota Semarang */
        $kat = Kat_user::all();
        $data = User::where('uns_user.id', $request->id)->first();
        return view('operator/index', compact('active', 'page', 'pekerjaan', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'kat', 'data', 'jenis'));
    }
    /* mitra end */

    /* kolektor */
    // public function kolektor_new()
    // {
    //     $active = 'kolektor new';
    //     $page = 'operator.partials.user.kolektor.new';
    //     $data = User::where('uns_user.kat_user', 2)
    //         ->where('uns_user.verified', 0)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }

    // public function kolektor_verifying()
    // {
    //     $active = 'kolektor verifying';
    //     $page = 'operator.partials.user.kolektor.verifying';
    //     $data = User::where('uns_user.kat_user', 2)
    //         ->where('uns_user.verified', 1)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }

    // public function kolektor_verified()
    // {
    //     $active = 'kolektor verified';
    //     $page = 'operator.partials.user.kolektor.verified';
    //     $data = User::where('uns_user.kat_user', 2)
    //         ->where('uns_user.verified', 2)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }

    // public function kolektor_unverified()
    // {
    //     $active = 'kolektor unverified';
    //     $page = 'operator.partials.user.kolektor.unverified';
    //     $data = User::where('uns_user.kat_user', 2)
    //         ->where('uns_user.verified', 3)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }
    /* kolektor end */

    /* bank sampah */
    // public function bank_sampah_new()
    // {
    //     $active = 'bank sampah new';
    //     $page = 'operator.partials.user.bank_sampah.new';
    //     $data = User::where('uns_user.kat_user', 3)
    //         ->where('uns_user.verified', 0)
    //         ->where('uns_user.delete', 'tidak')
    //         ->select('uns_user.*')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }

    // public function bank_sampah_verifying()
    // {
    //     $active = 'bank sampah verifying';
    //     $page = 'operator.partials.user.bank_sampah.verifying';
    //     $data = User::where('uns_user.kat_user', 3)
    //         ->where('uns_user.verified', 1)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }

    // public function bank_sampah_verified()
    // {
    //     $active = 'bank sampah verified';
    //     $page = 'operator.partials.user.bank_sampah.verified';
    //     $data = User::where('uns_user.kat_user', 3)
    //         ->where('uns_user.verified', 2)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data','page'));
    // }

    // public function bank_sampah_unverified()
    // {
    //     $active = 'bank sampah unverified';
    //     $page = 'operator.partials.user.bank_sampah.unverified';
    //     $data = User::where('uns_user.kat_user', 3)
    //         ->where('uns_user.verified', 3)
    //         ->where('uns_user.delete', 'tidak')
    //         ->leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
    //         ->orderby('uns_user.id', 'desc')
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }
    /* bank sampah end */
    /* request hapus */
    public function request_hapus()
    {
        $active = 'request hapus';
        $page = 'operator.partials.user.request_hapus';
        $data = User::where('uns_user.delete', 'ya')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
            ->select(
                'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec', 'indonesia_villages.name As kel')
            ->orderby('uns_user.id', 'desc')
            ->get();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    public function akun_terhapus()
    {
        $active = 'akun terhapus';
        $page = 'operator.partials.user.akun_terhapus';
        $data = Hapus::join('uns_kat_user','uns_kat_user.id','uns_deleted_user.kat_user')
            ->orderby('id', 'desc')
            ->get();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* request hapus end */

    public function gamifikasi(){
        $active = 'gamifikasi';
        $page = 'operator.partials.user.gamifikasi';
        $data = Pangkat::all();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* user end */

    /* kat user */
    public function kategori_user()
    {
        $active = 'kategori user';
        $page = 'operator.partials.user.kategori_user';
        $data = Kat_user::all();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* kat user end */

    /* lupa password */
    public function lupa_password()
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $yesterday = Carbon::yesterday();
        $active = 'lupa password';
        $page = 'operator.partials.user.lupa_password';
        $data = Lupa_password::join('uns_user','uns_user.id','uns_lupa_password.user_id')
        // ->join('uns_verified', 'uns_verified.id', 'uns_user.verified')
        ->join('uns_status_lupa','uns_status_lupa.id','uns_lupa_password.status')
        ->select('uns_lupa_password.*', 'uns_user.username', 'uns_user.nama', 'uns_status_lupa.status as stat')
        ->orderby('uns_lupa_password.updated_at','DESC')
        ->orderby('uns_status_lupa.status')
        ->get();
        $expired = Lupa_password::where('status',2)->where('updated_at', '<', $yesterday)->get();
        // dd($expired);
        foreach($expired as $setstat){
            $setstat->status = 0;
            $setstat->save();
        }
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* lupa password end */

    /* ambilin */
    public function ambilin($jenis) {
        Carbon::setLocale('id');
        $today = Carbon::today();
        $active = 'ambilin '.$jenis;
        $page = 'operator.partials.fitur.ambilin.ambilin';
        if($jenis == 'request') {
            $data_raw = Ambilin::where('ambilin.status', 1)->where('ambilin.verifikasi','proses')->where('ambilin.hapus','0');
        } elseif ($jenis == 'tersedia') {
            $data_raw = Ambilin::where('ambilin.status', 1)->where('ambilin.verifikasi','diterima')->where('ambilin.hapus','0');
        } elseif ($jenis == 'proses') {
            $data_raw = Ambilin::where('ambilin.status', 2)->where('ambilin.hapus','0');
        } elseif ($jenis == 'terambil') {
            $data_raw = Ambilin::where('ambilin.status', 3)->where('ambilin.hapus','0');
        } elseif ($jenis == 'ditolak') {
            $data_raw = Ambilin::where('ambilin.verifikasi','ditolak')->where('ambilin.hapus','0');
        } elseif ($jenis == 'dibatalkan') {
            $data_raw = Ambilin::where('status', 4)->where('ambilin.hapus','0');
        } elseif ($jenis == 'dihapus') {
            $data_raw = Ambilin::where('ambilin.hapus', '1')->orWhere('ambilin.status', 9);
        }
        $data = $data_raw
        ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
        ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
        ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
        ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
        ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
        ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
        ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
        ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
        ->select(
            'ambilin.id as barkas_id', 'ambilin.*',
            'uns_user.nama',
            'waste_date.tgl',
            'waste_time.waktu',
            'wp_lokasi.nama_lokasi', 'wp_lokasi.alamat_lokasi',
            'indonesia_provinces.name AS prov',
            'indonesia_cities.name AS kab',
            'indonesia_districts.name AS kec',
            'indonesia_villages.name As kel'
            )
        ->get();
        $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
        $user = User::leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
            ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
            ->select(
                'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec', 'indonesia_villages.name AS kel')
            ->get();
        // if(($jenis == 'request') || ($jenis == 'tersedia')) {
        //     return view('operator/index', compact('active', 'data', 'page', 'sampah', 'jenis', 'user'));
        // } elseif (($jenis == 'proses') || ($jenis == 'terambil') ||  ($jenis == 'dibatalkan') || ($jenis == 'dihapus')) {
            $kolektor = Booking::join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
            ->select('uns_user.id as user_id', 'uns_user.*', 'uns_ambilin_booking.*')
            ->get();
            $tgl = Waste_date::where('aktif', 'Y')->get();
            $waktu = Waste_time::where('aktif', 'Y')->get();
            if (($jenis == 'request') || ($jenis == 'tersedia') || ($jenis == 'proses') || ($jenis == 'ditolak')) {
                $list_kolektor = User::where('kat_user', 2)->where('verified', 2)->get();
                return view('operator/index', compact('active', 'data', 'page', 'sampah', 'kolektor','jenis', 'user', 'list_kolektor', 'today', 'tgl', 'waktu'));
            } else if ($jenis == 'dihapus') {
                $alasan_hapus = DB::table('uns_alasan_ambilin')->get();
                return view('operator/index', compact('active', 'data', 'page', 'sampah', 'kolektor','jenis', 'user', 'alasan_hapus', 'today', 'tgl', 'waktu'));
            }
            return view('operator/index', compact('active', 'data', 'page', 'sampah', 'kolektor','jenis', 'user', 'today', 'tgl', 'waktu'));
        // }
    }
    // public function ambilin_request()
    // {
    //     $active = 'ambilin request';
    //     $page = 'operator.partials.fitur.ambilin.ambilin';
    //     $data = Ambilin::where('status', 1)
    //     ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //     ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
    //     ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
    //     ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
    //     ->select('ambilin.id as id_ambilin', 'ambilin.*', 'uns_user.nama as user_nama', 'waste_date.tgl', 'waste_time.waktu', 'wp_lokasi.*')
    //     ->get();
    //     $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
    //     return view('operator/index', compact('active', 'data', 'page', 'sampah'));
    // }
    // public function ambilin_tersedia()
    // {
    //     $active = 'ambilin tersedia';
    //     $page = 'operator.partials.fitur.ambilin.ambilin';
    //     $data = Ambilin::where('status', 1)
    //     ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //     ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
    //     ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
    //     ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
    //     ->select('ambilin.id as id_ambilin', 'ambilin.*', 'uns_user.nama as user_nama', 'waste_date.tgl', 'waste_time.waktu', 'wp_lokasi.*')
    //     ->get();
    //     $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
    //     return view('operator/index', compact('active', 'data', 'page', 'sampah'));
    // }
    // public function ambilin_proses()
    // {
    //     $active = 'ambilin proses';
    //     $page = 'operator.partials.fitur.ambilin.ambilin';
    //     $data = Ambilin::where('status', 2)
    //     ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //     ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
    //     ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
    //     ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
    //     ->select('ambilin.id as id_ambilin', 'ambilin.*', 'uns_user.nama as user_nama', 'waste_date.tgl', 'waste_time.waktu', 'wp_lokasi.*')
    //     ->get();
    //     $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
    //     $kolektor = Booking::join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
    //     ->select('uns_user.id as user_id', 'uns_user.*', 'uns_ambilin_booking.*')
    //     ->get();
    //     return view('operator/index', compact('active', 'data', 'page', 'sampah', 'kolektor'));
    // }
    // public function ambilin_terambil()
    // {
    //     $active = 'ambilin terambil';
    //     $page = 'operator.partials.fitur.ambilin.ambilin';
    //     $data = Ambilin::where('status', 3)
    //     ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //     ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
    //     ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
    //     ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
    //     ->select('ambilin.id as id_ambilin', 'ambilin.*', 'uns_user.nama as user_nama', 'waste_date.tgl', 'waste_time.waktu', 'wp_lokasi.*')
    //     ->get();
    //     $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
    //     return view('operator/index', compact('active', 'data', 'page', 'sampah'));
    // }
    // public function ambilin_dibatalkan()
    // {
    //     $active = 'ambilin dibatalkan';
    //     $page = 'operator.partials.fitur.ambilin.ambilin';
    //     $data = Ambilin::where('status', 4)
    //     ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //     ->join('waste_date', 'waste_date.id', 'ambilin.tgl_ambil')
    //     ->join('waste_time', 'waste_time.id', 'ambilin.waktu_ambil')
    //     ->join('wp_lokasi', 'wp_lokasi.id', 'ambilin.idlokasi')
    //     ->select('ambilin.id as id_ambilin', 'ambilin.*', 'uns_user.nama as user_nama', 'waste_date.tgl', 'waste_time.waktu', 'wp_lokasi.*')
    //     ->get();
    //     $sampah = Berat::join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')->get();
    //     return view('operator/index', compact('active', 'data', 'page', 'sampah'));
    // }
    public function tanggal_layanan()
    {
        $active = 'tanggal layanan';
        $page = 'operator.partials.fitur.ambilin.tanggal_layanan';
        $data = Waste_date::orderBy('tgl', 'DESC')->get();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    public function waktu_layanan()
    {
        $active = 'waktu layanan';
        $page = 'operator.partials.fitur.ambilin.waktu_layanan';
        $data = Waste_time::all();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* ambilin end */

    /* barkas */
    public function barkas($jenis, $status)
    {
        $active = $jenis.' '.$status;
        $page = 'operator.partials.fitur.barkas';
        $barkas_ditolak = DB::table('uns_'.$jenis.'_ditolak')->select($jenis.'_id')->groupBy($jenis.'_id')->pluck($jenis.'_id')->toArray();
        // dd($barkas_ditolak);
        if ($status == 'proses') {
            $data_raw = DB::table($jenis)->where($jenis.'.hapus', '0')->where($jenis.'.status_publikasi', 1)->whereNotIn($jenis.'.id', $barkas_ditolak);
        } elseif ($status == 'pengajuan ulang') {
            $data_raw = DB::table($jenis)->where($jenis.'.hapus', '0')->where($jenis.'.status_publikasi', 1)->whereIn($jenis.'.id', $barkas_ditolak);
        } elseif ($status == 'lolos') {
            $data_raw = DB::table($jenis)->where($jenis.'.hapus', '0')->where($jenis.'.status_publikasi', 2);
        } elseif ($status == 'tidak lolos') {
            $data_raw = DB::table($jenis)->where($jenis.'.hapus', '0')->where($jenis.'.status_publikasi', 3);
        } elseif ($status == 'hapus') {
            $data_raw = DB::table($jenis)->where($jenis.'.hapus', '1');
        }
        $data = $data_raw
            ->join('uns_user', 'uns_user.id', $jenis.'.wp_id')
            ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', $jenis.'.kondisi')
            ->join('barkas_jenis', 'barkas_jenis.id', $jenis.'.fungsi')
            ->join('wp_lokasi', 'wp_lokasi.id', $jenis.'.idlokasi')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                $jenis.'.id as barkas_id', $jenis.'.*',
                'uns_user.nama',
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.jenis',
                'wp_lokasi.nama_lokasi', 'wp_lokasi.alamat_lokasi',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel'
                )
            ->get();
        $user = User::leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
            ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
            ->select(
                'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec', 'indonesia_villages.name AS kel')
            ->get();
        if ($status == 'hapus') {
            $alasan_hapus = DB::table('uns_alasan_'.$jenis)->get();
            return view('operator/index', compact('active', 'data', 'page', 'user', 'alasan_hapus', 'jenis','status'));
        } else if ($status == 'pengajuan ulang') {
            $alasan_ditolak = DB::table('uns_'.$jenis.'_ditolak')->orderBy('id', 'DESC')->get();
            return view('operator/index', compact('active', 'data', 'page', 'user', 'alasan_ditolak', 'jenis','status'));
        } else {
            return view('operator/index', compact('active', 'data', 'page', 'user', 'jenis','status'));   
        }
    }
    // public function paskas($jenis)
    // {
    //     $active = 'paskas '.$jenis;
    //     $page = 'operator.partials.fitur.paskas.paskas';
    //     if ($jenis == 'proses') {
    //         $data_raw = Paskas::where('paskas.hapus', '0')->where('paskas.status_publikasi', 1);
    //     } elseif ($jenis == 'lolos') {
    //         $data_raw = Paskas::where('paskas.hapus', '0')->where('paskas.status_publikasi', 2);
    //     } elseif ($jenis == 'tidak lolos') {
    //         $data_raw = Paskas::where('paskas.hapus', '0')->where('paskas.status_publikasi', 3);
    //     } elseif ($jenis == 'hapus') {
    //         $data_raw = Paskas::where('paskas.hapus', '1');
    //     }
    //     $data = $data_raw
    //         ->join('uns_user', 'uns_user.id', 'paskas.wp_id')
    //         ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'paskas.kondisi')
    //         ->join('barkas_jenis', 'barkas_jenis.id', 'paskas.fungsi')
    //         ->join('wp_lokasi', 'wp_lokasi.id', 'paskas.idlokasi')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
    //         ->select(
    //             'paskas.id as paskas_id', 'paskas.*',
    //             'uns_user.nama',
    //             'uns_barkas_kondisi.kondisi',
    //             'barkas_jenis.jenis',
    //             'wp_lokasi.nama_lokasi', 'wp_lokasi.alamat_lokasi',
    //             'indonesia_provinces.name AS prov',
    //             'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec',
    //             'indonesia_villages.name As kel'
    //             )
    //         ->get();
    //     $user = User::leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name AS kel')
    //         ->get();
    //     if ($jenis == 'hapus') {
    //         $alasan_hapus = DB::table('uns_alasan_paskas')->get();
    //         return view('operator/index', compact('active', 'data', 'page', 'user', 'alasan_hapus'));
    //     } else {
    //         return view('operator/index', compact('active', 'data', 'page', 'user'));   
    //     }
    // }
    // public function sebar($jenis)
    // {
    //     $active = 'sebar '.$jenis;
    //     $page = 'operator.partials.fitur.sebar.sebar';
    //     if ($jenis == 'proses') {
    //         $data_raw = Sebar::where('sebar.hapus', '0')->where('sebar.status_publikasi', 1);
    //     } elseif ($jenis == 'lolos') {
    //         $data_raw = Sebar::where('sebar.hapus', '0')->where('sebar.status_publikasi', 2);
    //     } elseif ($jenis == 'tidak lolos') {
    //         $data_raw = Sebar::where('sebar.hapus', '0')->where('sebar.status_publikasi', 3);
    //     } elseif ($jenis == 'hapus') {
    //         $data_raw = Sebar::where('sebar.hapus', '1');
    //     }
    //     $data = $data_raw
    //         ->join('uns_user', 'uns_user.id', 'sebar.wp_id')
    //         ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'sebar.kondisi')
    //         ->join('barkas_jenis', 'barkas_jenis.id', 'sebar.fungsi')
    //         ->join('wp_lokasi', 'wp_lokasi.id', 'sebar.idlokasi')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
    //         ->select(
    //             'sebar.id as sebar_id', 'sebar.*',
    //             'uns_user.nama',
    //             'uns_barkas_kondisi.kondisi',
    //             'barkas_jenis.jenis',
    //             'wp_lokasi.nama_lokasi', 'wp_lokasi.alamat_lokasi',
    //             'indonesia_provinces.name AS prov',
    //             'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec',
    //             'indonesia_villages.name As kel'
    //             )
    //         ->get();
    //     $user = User::leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
    //         ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
    //         ->select(
    //             'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
    //             'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec', 'indonesia_villages.name AS kel')
    //         ->get();
    //     if ($jenis == 'hapus') {
    //         $alasan_hapus = DB::table('uns_alasan_sebar')->get();
    //         return view('operator/index', compact('active', 'data', 'page', 'user', 'alasan_hapus'));
    //     } else {
    //         return view('operator/index', compact('active', 'data', 'page', 'user'));   
    //     }
    // }
    /* barkas end */

    /* harga */
    public function harga_sampah_tambah()
    {
        $active = 'harga sampah tambah';
        $page = 'operator.partials.fitur.harga_sampah.tambah';
        return view('operator/index', compact('active', 'page'));
    }
    public function harga_sampah($mitra)
    {
        $active = 'harga sampah '.$mitra;
        $page = 'operator.partials.fitur.harga_sampah.mitra';
        if ($mitra == 'mitra') {
            $data_raw = Harga::where('kat_user', 1);
        } elseif ($mitra == 'bank sampah') {
            $data_raw = Harga::where('kat_user', 3);
        } elseif ($mitra == 'kolektor') {
            $data_raw = Harga::where('kat_user', 2);
        } elseif ($mitra == 'pelapak') {
            $data_raw = DB::table('harga_pelapak');
        };
        $data = $data_raw->get();
        return view('operator/index', compact('active', 'data', 'page', 'mitra'));
    }
    // public function harga_sampah_mitra()
    // {
    //     $active = 'harga sampah mitra';
    //     $page = 'operator.partials.fitur.harga_sampah.mitra';
    //     $data = Harga::where('kat_user', 1)
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }
    // public function harga_sampah_kolektor()
    // {
    //     $active = 'harga sampah kolektor';
    //     $page = 'operator.partials.fitur.harga_sampah.kolektor';
    //     $data = Harga::where('kat_user', 2)
    //         ->get();
    //     return view('operator/index', compact('active', 'data', 'page'));
    // }
    /* harga end */

    /* WP Lokasi */
    public function wp_lokasijenis()
    {
        $active = 'wp lokasi jenis';
        $page = 'operator.partials.fitur.waste_producer.wp_lokasijenis';
        $data = DB::table('wp_lokasijenis')->get();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    public function wp_lokasi($jenis)
    {
        $active = $jenis;
        $page = 'operator.partials.fitur.waste_producer.wp_lokasi';
        if ($jenis == 'wp lokasi') {
            $data_raw = WP_Lokasi::where('wp_lokasi.hapus', '0');
        } elseif ($jenis == 'wp lokasi hapus') {
            $data_raw = WP_Lokasi::where('wp_lokasi.hapus', '1');
        }
        $data = $data_raw
            ->join('uns_user', 'uns_user.id', 'wp_lokasi.wp_id')
            ->join('wp_lokasijenis', 'wp_lokasijenis.id', 'wp_lokasi.idlokasijenis')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                'wp_lokasi.*',
                'uns_user.nama',
                'wp_lokasijenis.jenis_lokasi',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel'
                )
            ->get();
        $user = User::leftjoin('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
            ->leftjoin('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
            ->select(
                'uns_user.*','pekerjaan.pekerjaan','pendidikan.pendidikan',
                'indonesia_provinces.name AS prov', 'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec', 'indonesia_villages.name AS kel')
            ->get();
        if ($jenis == 'wp lokasi hapus') {
            $alasan_hapus = DB::table('uns_alasan_lokasi')->get();
            return view('operator/index', compact('active', 'data', 'page', 'user', 'alasan_hapus','jenis'));
        }
        return view('operator/index', compact('active', 'data', 'page', 'user','jenis'));
    }
    /* WP Lokasi end */

    /* Notifikasi */
    public function notifikasi()
    {
        $active = 'notifikasi';
        $page = 'operator.partials.fitur.notifikasi';
        $data = Notifikasi_raw::orderby('judul', 'asc')->get();
        // $data = DB::table('uns_notif_raw')->get();
        return view('operator/index', compact('active', 'data', 'page'));
    }
    /* Notifikasi end */

    /* rating */

    /* rating end */
}
