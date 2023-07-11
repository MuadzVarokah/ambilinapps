<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class historyController extends BaseController
{
    public function index()
    {
    }
    public function statistik()
    {
        /* main page */
        $page = 'Statistik';
        $back = 'dashboard';
        $user = DB::table('uns_user')
            ->where('uns_user.id', auth()->user()->id)
            ->select('waktu_catat')
            ->first();

        /* if user == 1 */
        if (auth()->user()->kat_user != 2) {
            /* ambilin */
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('ambilin.id')
                ->get();
            /* ambilin end  */
        }
        /* user = mitra end */

        /* if user == kolektor */
        if (auth()->user()->kat_user == 2) {
            /* total ambilin dilakukan */
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id');
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('ambilin.id')
                ->get();
            /* total ambilin end */
        }
        $count_amb = count($count_amb_raw);
        $sum_amb = $sum_amb_raw->count();
        /* user kolektor end */

        /* total loyalty */
        $harga_lt = DB::table('uns_tukar')
            ->where('tipe', 'ambilin-lt')
            ->where('aktif', 'aktif')
            ->select('harga', 'nilai_tukar as nilai')
            ->first();
        $sum_lt = ($count_amb / $harga_lt->harga) * $harga_lt->nilai;
        /* total loyalty end */

        /* if user == mitra */
        if (auth()->user()->kat_user != 2) {
            /* sum epr */
            $sum_epr_raw = DB::table('uns_epr_history')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.wp_id', auth()->user()->id)
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
                ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
                ->select('uns_epr_harga.poin_epr as harga', 'uns_epr_history.jumlah as jumlah')
                ->get();
            $sum_epr_array = array();
            foreach ($sum_epr_raw as $sumeprraw) {
                $sum_epr_array[] = $sumeprraw->jumlah/$sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
            /* sum EPR end */
        }
        /* user mitra end */

        /*  if user == kolektor */
        if (auth()->user()->kat_user == 2) {
            /* total epr */
            $sum_epr_raw = DB::table('uns_epr_history')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
                ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
                ->select('uns_epr_harga.poin_epr as harga', 'uns_epr_history.jumlah as jumlah')
                ->get();
            $sum_epr_array = array();
            foreach ($sum_epr_raw as $sumeprraw) {
                $sum_epr_array[] = $sumeprraw->jumlah/$sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
            /* total epr end */
        }
        /* user kolektor end */

        /* penggunaan LT, sama untuk kedua akun */
        $usage_lt_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'lt')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga')
            ->get();
        $usage_lt_array = array();
        foreach ($usage_lt_raw as $usageltraw) {
            $usage_lt_array[] = $usageltraw->jml * $usageltraw->harga;
        }
        $usage_lt = array_sum($usage_lt_array);
        /* penggunaan LT end */

        /* penggunaan EPR, sama untuk kedua akun */
        $usage_epr_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'epr')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga')
            ->get();
        $usage_epr_array = array();
        foreach ($usage_epr_raw as $usageeprraw) {
            $usage_epr_array[] = $usageeprraw->jml * $usageeprraw->harga;
        }
        $usage_epr = array_sum($usage_epr_array);
        /* penggunaan EPR end */

        /* poin tersedia kedua akun */
        $point_lt = $sum_lt - $usage_lt;
        $point_epr = $sum_epr - $usage_epr;
        /* poin tersedia kedua akun end */
        return view(
            'statistik',
            compact('count_amb', 'user', 'sum_amb', 'back', 'page', 'sum_lt', 'sum_epr', 'usage_epr', 'usage_lt', 'point_lt', 'point_epr')
        );
    }

    public function epr($tipe)
    {
        $fitur = 'epr';
        $page = 'History EPR';
        $back = 'statistik';
        /* detail income epr */
        /* user mitra */
        if (auth()->user()->kat_user != 2) {
            $income_raw = DB::table('uns_user')
                ->select('uns_user.id')
                ->where('uns_user.id', auth()->user()->id)
                ->join('ambilin', 'ambilin.wp_id', 'uns_user.id')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.ambilin_id', 'ambilin.id')
                ->join('uns_epr_history', 'uns_epr_history.booking_id', 'uns_ambilin_booking.id')
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_sampah', 'uns_sampah.id', '=', 'uns_sampah-merek.sampah_id')
                ->join('uns_merek', 'uns_merek.id', '=', 'uns_sampah-merek.merek_id')
                ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', '=', 'uns_sampah-merek.harga_id')
                ->select(
                    'uns_epr_history.jumlah',
                    'uns_epr_history.waktu_catat as tanggal',
                    'uns_sampah.nama as jenis',
                    'uns_perusahaan_induk.nama as induk',
                    'uns_merek.merek',
                    'uns_epr_harga.poin_epr as harga'
                );
            $income = $income_raw->orderby('uns_epr_history.waktu_catat', 'DESC')->paginate(10);
        }
        /* user mitra end */
        // $test = db::table('uns_epr_history')->join('uns_sampah-merek','uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')->where('uns_sampah-merek.merek_id',4)->get();dd($test);
        /* user kolektor */

        if (auth()->user()->kat_user == 2) {
            $income_raw = DB::table('uns_user')
                ->where('uns_user.id', auth()->user()->id)
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.kolektor_id', 'uns_user.id')
                ->join('uns_epr_history', 'uns_epr_history.booking_id', 'uns_ambilin_booking.id')
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_sampah', 'uns_sampah.id', '=', 'uns_sampah-merek.sampah_id')
                ->join('uns_merek', 'uns_merek.id', '=', 'uns_sampah-merek.merek_id')
                ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', '=', 'uns_sampah-merek.harga_id')
                ->select(
                    'uns_epr_history.jumlah',
                    'uns_epr_history.waktu_catat as tanggal',
                    'uns_sampah.nama as jenis',
                    'uns_perusahaan_induk.nama as induk',
                    'uns_merek.merek',
                    'uns_epr_harga.poin_epr as harga',
                    'uns_ambilin_booking.kolektor_id',
                    'uns_ambilin_booking.id'
                );
            $income = $income_raw->orderby('uns_epr_history.waktu_catat', 'DESC')->paginate(10);
        } 
        // dd($income);
        // dd($income);
        $juml_income = $income_raw->sum('jumlah');
        /* user kolektor end */
        /* detail income epr end*/


        /* detail outcome epr kedua akun */
        $outcome_raw = DB::table('uns_poin_usage')
            ->where('user_id', auth()->user()->id)
            ->where('uns_tukar.tipe', 'epr')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select(
                'uns_poin_usage.waktu_catat as tanggal',
                'uns_poin_usage.jumlah as jumlah',
                'uns_tukar.jenis as nama',
                'uns_tukar.harga',
                'uns_tukar.nilai_tukar',
                'uns_tukar.satuan'
            );
        $outcome = $outcome_raw->orderby('uns_poin_usage.waktu_catat', 'DESC')->paginate(10);
        $sum_outcome = $outcome_raw->sum('jumlah');
        /* detail outcome epr end */

        /* outcome poin epr kedua akun*/
        $juml_outcome_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'epr')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga', 'uns_tukar.nilai_tukar as nilai')
            ->get();
        $juml_outcome_array = array();
        foreach ($juml_outcome_raw as $jumloutcomeraw) {
            $juml_outcome_array[] = $jumloutcomeraw->jml * $jumloutcomeraw->harga;
        }
        $juml_outcome = array_sum($juml_outcome_array);
        /* outcome poin epr end */


        /* income poin epr */
        if (auth()->user()->kat_user != 2) {
            /* user mitra */
            $sum_epr_raw = DB::table('uns_epr_history')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.wp_id', auth()->user()->id)
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
                ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
                ->select('uns_epr_harga.poin_epr as harga', 'uns_epr_history.jumlah as jumlah')
                ->get();
            $sum_epr_array = array();
            foreach ($sum_epr_raw as $sumeprraw) {
                $sum_epr_array[] = $sumeprraw->jumlah/$sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
        }   /* user mitra end*/

        if (auth()->user()->kat_user == 2) {
            /* user kolektor */
            $sum_epr_raw = DB::table('uns_epr_history')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
                ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
                ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
                ->select('uns_epr_harga.poin_epr as harga', 'uns_epr_history.jumlah as jumlah')
                ->get();
            $sum_epr_array = array();
            foreach ($sum_epr_raw as $sumeprraw) {
                $sum_epr_array[] = $sumeprraw->jumlah/$sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
        }   /* user kolektor end */
        /* income poin epr end */

        $juml_uang_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'epr')
            ->where('terambil', '0')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga', 'uns_tukar.nilai_tukar as nilai')
            ->get();
        $juml_uang_array = array();
        foreach ($juml_outcome_raw as $jumloutcomeraw) {
            $juml_uang_array[] = $jumloutcomeraw->nilai * $jumloutcomeraw->jml;
        }
        $juml_uang = array_sum($juml_uang_array);

        if ($tipe == 'income') {
            return view('history_income', compact('sum_epr', 'juml_income', 'income', 'tipe', 'fitur', 'back', 'page'));
        }
        if ($tipe == 'outcome') {
            return view('history_outcome', compact('sum_outcome','juml_uang', 'juml_outcome', 'outcome', 'tipe', 'fitur', 'back', 'page'));
        }
    }

    public function lt($tipe)
    {
        $fitur = 'lt';
        $page = 'History LT';
        $back = 'statistik';
        if (auth()->user()->kat_user == 2) {
            $count_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 3)
                ->select('ambilin.id')
                ->get();
        } if (auth()->user()->kat_user != 2) {
            $count_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
        }
        $count_amb = count($count_amb_raw);
        $outcome_raw = DB::table('uns_poin_usage')
            ->where('user_id', auth()->user()->id)
            ->where('uns_tukar.tipe', 'lt')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select(
                'uns_poin_usage.waktu_catat as tanggal',
                'uns_poin_usage.jumlah as jumlah',
                'uns_tukar.jenis as nama',
                'uns_tukar.harga',
                'uns_tukar.nilai_tukar',
                'uns_tukar.satuan'
            );
        $outcome = $outcome_raw->orderby('uns_poin_usage.waktu_catat', 'DESC')->paginate(10);
        $sum_outcome = $outcome_raw->sum('jumlah');
        $juml_outcome_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'lt')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga', 'uns_tukar.nilai_tukar as nilai')
            ->get();
        $juml_outcome_array = array();
        foreach ($juml_outcome_raw as $jumloutcomeraw) {
            $juml_outcome_array[] = $jumloutcomeraw->jml * $jumloutcomeraw->harga;
        }
        $juml_outcome = array_sum($juml_outcome_array);

        $juml_uang_raw = DB::table('uns_poin_usage')
            ->where('uns_poin_usage.user_id', auth()->user()->id)
            ->where('uns_poin_usage.jenis', 'lt')
            ->where('terambil', '0')
            ->join('uns_tukar', 'uns_tukar.id', 'uns_poin_usage.tukar_id')
            ->select('uns_poin_usage.jumlah as jml', 'uns_tukar.harga as harga', 'uns_tukar.nilai_tukar as nilai')
            ->get();
        $juml_uang_array = array();
        foreach ($juml_outcome_raw as $jumloutcomeraw) {
            $juml_uang_array[] = $jumloutcomeraw->nilai * $jumloutcomeraw->jml;
        }
        $juml_uang = array_sum($juml_uang_array);

        $income_data = DB::table('uns_tukar')
            ->where('jenis', 'lt')->first();
        $juml_income = ($count_amb / $income_data->harga) * $income_data->nilai_tukar;
        $sum_lt = $juml_income - $juml_outcome;
        // dd(get_defined_vars());
        if ($tipe == 'income') {
            return view('history_income', compact('sum_lt', 'juml_income', 'tipe', 'fitur', 'back', 'page'));
        }
        if ($tipe == 'outcome') {
            return view('history_outcome', compact('sum_outcome','juml_uang', 'juml_outcome', 'outcome', 'tipe', 'fitur', 'back', 'page'));
        }
    }

    public function ambilin()
    {
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $fitur = 'ambilin';
        $page = 'History Ambilin';
        $back = 'statistik';
        if (auth()->user()->kat_user == 2) {
            $count_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 3)
                ->select('ambilin.id')
                ->get();
            $data_raw = DB::table('uns_ambilin_booking')
                /* uns_user - ambilin booking */
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                /* user - ambilin */
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status' ,'<', 4)
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->join('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->join('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->join('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->join('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'uns_status.nama AS status',
                    'waste_date.tgl',
                    'ambilin.waktucatat',
                    'waste_time.waktu',
                    'wp_lokasi.alamat_lokasi',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel'
                );
        } elseif (auth()->user()->kat_user != 2) {
            $count_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $data_raw = DB::table('ambilin')
                /* uns_berat - ambilin */
                ->where('ambilin.wp_id', auth()->user()->id)
                /* user - ambilin */
                ->join('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->where('ambilin.status' ,'<', 4)
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->join('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->join('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->join('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->join('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'uns_status.nama AS status',
                    'waste_date.tgl',
                    'ambilin.waktucatat',
                    'waste_time.waktu',
                    'wp_lokasi.alamat_lokasi',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel'
                );
        }
        $count_amb = count($count_amb_raw);
        $income_data = DB::table('uns_tukar')
            ->where('jenis', 'lt')->first();
        $data = $data_raw->orderby('ambilin.status', 'DESC')->orderby('waste_date.tgl', 'DESC')->orderby('waste_time.waktu')->paginate(10);
        // dd($data);
        $count_amb = count($count_amb_raw);
        return view('history_income', compact('today', 'count_amb', 'income_data', 'data', 'fitur', 'page', 'back'));
    }
}
