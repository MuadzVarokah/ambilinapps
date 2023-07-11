<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Harga;
use App\Models\Harga_Pelapak;
use App\Models\Log;
use App\Models\Notifikasi;
use App\Models\User;

// use Illuminate\Support\Facades\Redis;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        /* fixed variables */
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
        // $addWeek = Carbon::now()->addWeek()->format('Y-m-d H:i:s');
        // $subWeek = Carbon::now()->subWeek()->format('Y-m-d H:i:s');
        // $addMonth = Carbon::now()->addMonth()->format('Y-m-d H:i:s');
        // $subMonth = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
        // $addYear = Carbon::now()->addYear()->format('Y-m-d H:i:s');
        // $subYear = Carbon::now()->subYear()->format('Y-m-d H:i:s');
        // dd($addWeek, $subWeek, $addMonth, $subMonth, $addYear, $subYear);

        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        /* -  -  - */

        $operator = db::table('ngadminin')->where('aktif', 'ya')->inrandomorder()->first();

        $mynotif_raw = Notifikasi::where(function ($query) {
            $query->where('id_user', auth()->user()->id)
                ->orWhere('id_user', null);
        });
        $mynotif_get = $mynotif_raw->orderby('waktu_catat', 'desc')->first();
        // $mynotif_count = $mynotif_raw->count();
        $notiflog = Log::where('id_user', auth()->user()->id)->where('akses', 'Notifikasi')->orderby('waktu_catat', 'desc')->pluck('waktu_catat')->first();
        if (!empty($notiflog)) {
            $notif_unread = $mynotif_raw
                ->where('waktu_catat', '>=', $notiflog)
                ->first();
        } else {
            $notif_unread = $mynotif_raw
                ->first();
        }
        // dd($notiflog,$mynotif_get, $notif_unread);
        $pesanlog = Log::where('id_user', auth()->user()->id)->where('akses', 'Chat')->orderby('waktu_catat', 'desc')->first();
        if (!empty($pesanlog)) {
            $chat_unread = Chat::where('id_penerima', auth()->user()->id)->where('waktu_catat', '>=', $pesanlog->waktu_catat)->first();
        } else {
            $chat_unread = Chat::where('id_penerima', auth()->user()->id)->first();
        }
        // $notifikasi = $mynotif_raw->get();
        // dd($notiflog,$notif_unread,$mynotif_get);
        /* berat counter */
        if ($user->kat_user == 2) {
            $berat_minggu = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $weekStartDate)
                ->where('waktuubah', '<=', $weekEndDate)
                ->sum('uns_berat.berat');
            $berat_bulan = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $monthStartDate)
                ->where('waktuubah', '<=', $monthEndDate)
                ->sum('uns_berat.berat');
            $berat_tahun = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $yearStartDate)
                ->where('waktuubah', '<=', $yearEndDate)
                ->sum('uns_berat.berat');
        } else {
            $berat_minggu = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
                ->join('ambilin', 'ambilin.wp_id', 'uns_user.id')
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $weekStartDate)
                ->where('waktuubah', '<=', $weekEndDate)
                ->sum('uns_berat.berat');
            $berat_bulan = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
                ->join('ambilin', 'ambilin.wp_id', 'uns_user.id',)
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $monthStartDate)
                ->where('waktuubah', '<=', $monthEndDate)
                ->sum('uns_berat.berat');
            $berat_tahun = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
                ->join('ambilin', 'ambilin.wp_id', 'uns_user.id')
                ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
                ->select('uns_berat.berat', 'ambilin.waktuubah')
                ->where('ambilin.status', 3)
                ->where('waktuubah', '>=', $yearStartDate)
                ->where('waktuubah', '<=', $yearEndDate)
                ->sum('uns_berat.berat');
        }

        // $berat_raw = $id
        //     ->join('ambilin', 'ambilin.wp_id', '=', 'uns_user.id')
        //     ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
        //     ->select('uns_berat.berat', 'ambilin.waktucatat');
        // $berat = $berat_raw->get();
        // $berat_minggu = $berat_raw
        //     ->where('waktucatat', '>', $subWeek)
        //     ->where('waktucatat', '<', $addWeek)
        //     ->sum('uns_berat.berat');
        // $berat_bulan = $berat_raw
        //     ->where('waktucatat', '>', $subMonth)
        //     ->where('waktucatat', '<', $addMonth)
        //     ->sum('uns_berat.berat');
        // $berat_tahun = $berat_raw
        //     ->where('waktucatat', '>', $subYear)
        //     ->where('waktucatat', '<', $addYear)
        //     ->sum('uns_berat.berat');
        /* -  -  - */

        /* point counter */
        if ($user->kat_user == 2) {
            /* ambilin */
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 3);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->get();
            $count_amb = count($count_amb_raw);
            $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();
            $next_level = DB::table('uns_pangkat')->where('jumlah_ambilin', '>', $count_amb)->orderby('id')->first();
            if (!empty($next_level->jumlah_ambilin)) {
                $exp_left = $next_level->jumlah_ambilin - $count_amb;
            } else {
                $exp_left = 0;
            }
            if (empty($next_level->jumlah_ambilin)) {
                $width = 100;
            } elseif ($exp_left > 0) {
                $width = (($next_level->jumlah_ambilin - $exp_left) / $next_level->jumlah_ambilin) * 100;
            } else {
                $width = 0;
            }
            /* lt */
            $harga_lt = DB::table('uns_tukar')
                ->where('tipe', 'ambilin-lt')
                ->select('harga', 'nilai_tukar as nilai')
                ->first();
            $sum_lt = ($count_amb / $harga_lt->harga) * $harga_lt->nilai;
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
            $point_lt = $sum_lt - $usage_lt;
            /* epr */
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
                $sum_epr_array[] = $sumeprraw->jumlah / $sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
            // dd($sum_epr,$half,$summary);
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
            $point_epr = $sum_epr - $usage_epr;
        } elseif ($user->kat_user != 2) {
            /* ambilin */
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $count_amb = count($count_amb_raw);
            $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();
            $next_level = DB::table('uns_pangkat')->where('jumlah_ambilin', '>', $count_amb)->orderby('id')->first();
            if (!empty($next_level->jumlah_ambilin)) {
                $exp_left = $next_level->jumlah_ambilin - $count_amb;
            } else {
                $exp_left = 0;
            }
            if ($exp_left > 0) {
                $width = (($next_level->jumlah_ambilin - $exp_left) / $next_level->jumlah_ambilin) * 100;
            } elseif ($count_amb == 0) {
                $width = 0;
            } else {
                $width = 100;
            }
            // dd($count_amb,$width,$exp_left,$next_level,$level);
            // dd($count_amb, $level, $next_level);
            /* lt */
            $harga_lt = DB::table('uns_tukar')
                ->where('tipe', 'ambilin-lt')
                ->select('harga', 'nilai_tukar as nilai')
                ->first();
            $sum_lt = ($count_amb / $harga_lt->harga) * $harga_lt->nilai;
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
            $point_lt = $sum_lt - $usage_lt;
            /* epr */
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
                $sum_epr_array[] =  $sumeprraw->jumlah / $sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
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
                $sum_epr_array[] = $sumeprraw->jumlah / $sumeprraw->harga;
            }
            $sum_epr = array_sum($sum_epr_array);
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
            $point_epr = $sum_epr - $usage_epr;
        }

        $kat_user = $id
            ->join('uns_kat_user', 'uns_kat_user.id', '=', 'uns_user.kat_user')
            ->select('uns_kat_user.*')
            ->first();
        if (empty($user->kat_user)) {
            $cat_barang = DB::table('waste_cat')
                ->where('waste_cat.aktif', '1')
                ->inRandomOrder()->get();
            $harga_naik = DB::table('waste_cat')
                ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
                ->where('waste_cat.aktif', '1')
                ->where('waste_cat.waktu_catat', '>',  $today)
                ->where('waste_cat.waktu_catat', '<', $tomorrow)
                ->select(
                    'waste_cat.foto',
                    'waste_cat.nama',
                    'waste_cat.harga_down',
                    'waste_cat.harga_top',
                    'uns_harga_lama.old_down',
                    'uns_harga_lama.old_top',
                    'uns_harga_lama.waktu_catat'
                )
                ->get();
        } else {
            $cat_barang = DB::table('waste_cat')
                    ->where('waste_cat.aktif', '1')
                    ->where('kat_user', auth()->user()->kat_user)
                    ->inRandomOrder()->get();
                $harga_naik = DB::table('waste_cat')
                    ->where('waste_cat.aktif', '1')
                    ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
                    ->where('kat_user', auth()->user()->kat_user)
                    ->where('waste_cat.waktu_catat', '>',  $today)
                    ->where('waste_cat.waktu_catat', '<', $tomorrow)
                    ->select(
                        'waste_cat.foto',
                        'waste_cat.nama',
                        'waste_cat.harga_down',
                        'waste_cat.harga_top',
                        'uns_harga_lama.old_down',
                        'uns_harga_lama.old_top',
                        'uns_harga_lama.waktu_catat'
                    )
                    ->get();
            
            // if ($user->kat_user != 1) {
            //     $cat_barang = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->where('kat_user', '!=', 1)
            //         ->inRandomOrder()->get();
            //     $harga_naik = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
            //         ->where('kat_user', '!=', 1)
            //         ->where('waste_cat.waktu_catat', '>',  $today)
            //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
            //         ->select(
            //             'waste_cat.foto',
            //             'waste_cat.nama',
            //             'waste_cat.harga_down',
            //             'waste_cat.harga_top',
            //             'uns_harga_lama.old_down',
            //             'uns_harga_lama.old_top',
            //             'uns_harga_lama.waktu_catat'
            //         )
            //         ->get();
            // } else {
            //     $cat_barang = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->where('kat_user', 1)
            //         ->inRandomOrder()->get();
            //     $harga_naik = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
            //         ->where('kat_user', 1)
            //         ->where('waste_cat.waktu_catat', '>',  $today)
            //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
            //         ->select(
            //             'waste_cat.foto',
            //             'waste_cat.nama',
            //             'waste_cat.harga_down',
            //             'waste_cat.harga_top',
            //             'uns_harga_lama.old_down',
            //             'uns_harga_lama.old_top',
            //             'uns_harga_lama.waktu_catat'
            //         )
            //         ->get();
            // }
        }

        /* harga naik */

        /* -  -  - */
        return view(
            'dashboard',
            compact(
                'now',
                'raw_now',
                'berat_minggu',
                'berat_bulan',
                'berat_tahun',
                'cat_barang',
                'count_amb',
                'harga_naik',
                'kat_user',
                'level',
                'next_level',
                'exp_left',
                'today',
                'user',
                'sum_amb',
                'point_epr',
                'point_lt',
                'width',
                'operator',
                'notif_unread',
                'chat_unread'
            )
        );
    }

    public function chat_check($datetime)
    {
        $post = Chat::where('id_penerima', auth()->user()->id)->orderBy('waktu_catat', 'DESC')->firstOrFail();
        if ($post->waktu_catat > $datetime) {
            return $post;
        }

        return false;
    }
    public function notif_check($datetime)
    {
        // $chat = Chat::where('id_penerima', auth()->user()->id)->orderBy('waktu_catat', 'DESC')->firstOrFail();
        $post = Notifikasi::where(function ($query) {
            $query->where('id_user', auth()->user()->id)
                ->orWhere('id_user', null);
        })
            ->orderBy('waktu_catat', 'DESC')->firstOrFail();
        // $post = $chat->union($notif);
        if ($post->waktu_catat > $datetime) {
            return $post;
        }

        return false;
    }

    public function iframe($target)
    {
        $link = '';
        $back = "";
        if ($target == 'tentang') {
            $link = 'https://ambilin.com/1.0/Profil/';
        }
        if ($target == 'privacy') {
            $link = 'https://ambilin.com/blog/kebijakan-privacy/';
        }
        if ($target == 'ambilinpedia') {
            $link = 'https://ambilin.com/ambilinpedia/';
        }
        if ($target == 'info') {
            $link = 'https://ambilin.com/blog/profil-ambilin/';
        }
        return view('iframe', compact('link', 'target', 'back'));
    }

    public function harga()
    {
        $page = 'Daftar Harga';
        $back = 'dashboard';

        /* fixed variables */
        $raw_now = Carbon::now();
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $tomorrow = Carbon::tomorrow()->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        /* */

        if (empty($user->kat_user)) {
            $cat_barang = DB::table('waste_cat')
                ->where('waste_cat.aktif', '1')
                ->orderby('nama')
                ->paginate(
                    $perPage = 5,
                    $columns = ['*'],
                    $pageName = 'cat_barang'
                );
            $harga_naik = DB::table('waste_cat')
                ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
                ->where('waste_cat.aktif', '1')
                ->where('waste_cat.waktu_catat', '>',  $today)
                ->where('waste_cat.waktu_catat', '<', $tomorrow)
                ->select(
                    'waste_cat.foto',
                    'waste_cat.nama',
                    'waste_cat.harga_down',
                    'waste_cat.harga_top',
                    'uns_harga_lama.old_down',
                    'uns_harga_lama.old_top',
                    'uns_harga_lama.waktu_catat'
                )
                ->get();
        } else {
            $cat_barang = Harga::where('kat_user', auth()->user()->kat_user)
                        ->where('waste_cat.aktif', '1')
                        ->paginate($perPage = 5, $columns = ['*'], $pageName = 'cat_barang');
            $harga_naik = Harga::where('waste_cat.aktif','1')
                    ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
                    ->where('kat_user', auth()->user()->kat_user)
                    ->where('waste_cat.waktu_catat', '>',  $today)
                    ->where('waste_cat.waktu_catat', '<', $tomorrow)
                    ->select(
                        'waste_cat.foto',
                        'waste_cat.nama',
                        'waste_cat.harga_down',
                        'waste_cat.harga_top',
                        'uns_harga_lama.old_down',
                        'uns_harga_lama.old_top',
                        'uns_harga_lama.waktu_catat',
                    )
                    ->get();
            // if ($user->kat_user == 1) {
            //     $cat_barang = DB::table('waste_cat')
            //         ->where('kat_user', 1)
            //         ->where('waste_cat.aktif', '1')
            //         ->orderby('nama')
            //         ->paginate(
            //             $perPage = 5,
            //             $columns = ['*'],
            //             $pageName = 'cat_barang'
            //         );
            //     $harga_naik = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
            //         ->where('kat_user', 1)
            //         ->where('waste_cat.waktu_catat', '>',  $today)
            //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
            //         ->select(
            //             'waste_cat.foto',
            //             'waste_cat.nama',
            //             'waste_cat.harga_down',
            //             'waste_cat.harga_top',
            //             'uns_harga_lama.old_down',
            //             'uns_harga_lama.old_top',
            //             'uns_harga_lama.waktu_catat'
            //         )
            //         ->get();
            // } else {
            //     $cat_barang = DB::table('waste_cat')
            //         ->where('kat_user', '!=', 1)
            //         ->where('waste_cat.aktif', '1')
            //         ->orderby('nama')
            //         ->paginate(
            //             $perPage = 5,
            //             $columns = ['*'],
            //             $pageName = 'cat_barang'
            //         );
            //     $harga_naik = DB::table('waste_cat')
            //         ->where('waste_cat.aktif', '1')
            //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
            //         ->where('kat_user', '!=', 1)
            //         ->where('waste_cat.waktu_catat', '>',  $today)
            //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
            //         ->select(
            //             'waste_cat.foto',
            //             'waste_cat.nama',
            //             'waste_cat.harga_down',
            //             'waste_cat.harga_top',
            //             'uns_harga_lama.old_down',
            //             'uns_harga_lama.old_top',
            //             'uns_harga_lama.waktu_catat'
            //         )
            //         ->get();
            // }
            $norm = 'active';
            $aria_n = 'page';
            $mit = '';
            $aria_m = 'false';
            $pel = '';
            $aria_p = 'false';
            $bs = '';
            $aria_bs = 'false';
        }
        return view('harga', compact('back', 'page', 'cat_barang', 'harga_naik','norm','aria_n','mit','aria_m','pel','aria_p','bs','aria_bs'));
    }
    public function harga_bs()
    {
        $page = 'Daftar Harga Bank Sampah';
        $back = 'dashboard';

        /* fixed variables */
        $raw_now = Carbon::now();
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $tomorrow = Carbon::tomorrow()->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        /* */

        $cat_barang = DB::table('waste_cat')
            ->where('kat_user', 3)
            ->where('waste_cat.aktif', '1')
            ->orderby('nama')
            ->paginate(
                $perPage = 5,
                $columns = ['*'],
                $pageName = 'cat_barang'
            );
            $norm = '';
            $aria_n = 'false';
            $mit = '';
            $aria_m = 'false';
            $pel = '';
            $aria_p = 'false';
            $bs = 'active';
            $aria_bs = 'page';
        return view('harga', compact('back', 'page', 'cat_barang','norm','aria_n','mit','aria_m','pel','aria_p','bs','aria_bs'));
    }

    public function harga_mitra()
    {
        $page = 'Daftar Harga Mitra';
        $back = 'dashboard';

        /* fixed variables */
        $raw_now = Carbon::now();
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $tomorrow = Carbon::tomorrow()->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        /* */

        $cat_barang = DB::table('waste_cat')
            ->where('kat_user', 1)
            ->where('waste_cat.aktif', '1')
            ->orderby('nama')
            ->paginate(
                $perPage = 5,
                $columns = ['*'],
                $pageName = 'cat_barang'
            );
            $norm = '';
            $aria_n = 'false';
            $mit = 'active';
            $aria_m = 'page';
            $pel = '';
            $aria_p = 'false';
            $bs = '';
            $aria_bs = 'false';
        return view('harga', compact('back', 'page', 'cat_barang','norm','aria_n','mit','aria_m','pel','aria_p','bs','aria_bs'));
    }
    public function harga_pelapak()
    {
        $page = 'Daftar Harga Pelapak';
        $back = 'dashboard';

        /* fixed variables */
        $raw_now = Carbon::now();
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $tomorrow = Carbon::tomorrow()->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        /* */
        $cat_barang = Harga_Pelapak::where('aktif', '1')
        ->orderby('nama')
        ->paginate(
            $perPage = 5,
            $columns = ['*'],
            $pageName = 'cat_barang'
        );
        $norm = '';
        $aria_n = 'false';
        $mit = '';
        $aria_m = 'false';
        $pel = 'active';
        $aria_p = 'page';
        $bs = '';
        $aria_bs = 'false';
        // if (empty($user->kat_user)) {
        //     $cat_barang = DB::table('waste_cat')
        //         ->where('waste_cat.aktif', '1')
        //         ->orderby('nama')
        //         ->paginate(
        //             $perPage = 5,
        //             $columns = ['*'],
        //             $pageName = 'cat_barang'
        //         );
        //     $harga_naik = DB::table('waste_cat')
        //         ->where('waste_cat.aktif', '1')
        //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
        //         ->where('waste_cat.waktu_catat', '>',  $today)
        //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
        //         ->select(
        //             'waste_cat.foto',
        //             'waste_cat.nama',
        //             'waste_cat.harga_down',
        //             'waste_cat.harga_top',
        //             'uns_harga_lama.old_down',
        //             'uns_harga_lama.old_top',
        //             'uns_harga_lama.waktu_catat'
        //         )
        //         ->get();
        // } else {
        //     $cat_barang = DB::table('waste_cat')->where('kat_user', $user->kat_user)
        //         ->where('waste_cat.aktif', '1')
        //         ->orderby('nama')
        //         ->paginate(
        //             $perPage = 5,
        //             $columns = ['*'],
        //             $pageName = 'cat_barang'
        //         );
        //     $harga_naik = DB::table('waste_cat')
        //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'waste_cat.id')
        //         ->where('waste_cat.aktif', '1')
        //         ->where('kat_user', $user->kat_user)
        //         ->where('waste_cat.waktu_catat', '>',  $today)
        //         ->where('waste_cat.waktu_catat', '<', $tomorrow)
        //         ->select(
        //             'waste_cat.foto',
        //             'waste_cat.nama',
        //             'waste_cat.harga_down',
        //             'waste_cat.harga_top',
        //             'uns_harga_lama.old_down',
        //             'uns_harga_lama.old_top',
        //             'uns_harga_lama.waktu_catat'
        //         )
        //         ->get();
        // }
        return view('harga', compact('back', 'page', 'cat_barang', 'norm','aria_n','mit','aria_m','pel','aria_p','bs','aria_bs'));
    }

    public function epr()
    {
        $page = 'EPR | Kumpulin Sampah Produk Pabrikan';
        $induk = DB::table('uns_perusahaan_induk')
            ->where('aktif', 'Y')
            ->orderby('waktu_catat')
            ->get();
        return view('epr', compact('page', 'induk'));
    }

    public function epr_merek($id)
    {
        $page = 'EPR | Kumpulin Sampah Produk Pabrikan';
        $per_induk = DB::table('uns_perusahaan_induk')->where('id', $id)->first();
        $data = DB::table('uns_merek')
            ->where('induk_id', $id)
            ->where('aktif', 'Y')
            ->orderby('waktu_catat')
            ->get();
        return view('epr', compact('per_induk', 'page', 'id', 'data'));
    }

    public function epr_produk($id, $id2)
    {
        $tipe = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->select('uns_kat_user.kat as kategori')
            ->join('uns_kat_user', 'uns_kat_user.id', 'uns_user.kat_user')
            ->first();
        $page = 'EPR | Kumpulin Sampah Produk Pabrikan';
        $raw_now = Carbon::now();
        $now = $raw_now->translatedFormat('l, d F Y');
        $per_induk = DB::table('uns_perusahaan_induk')->where('id', $id)->first();
        $data_raw = DB::table('uns_sampah-merek')
            ->where('uns_sampah-merek.merek_id', $id2)
            ->where('uns_sampah.aktif', 'Y')
            ->join('uns_sampah', 'uns_sampah.id', '=', 'uns_sampah-merek.sampah_id')
            ->join('uns_merek', 'uns_merek.id', '=', 'uns_sampah-merek.merek_id')
            ->join('uns_epr_harga', 'uns_epr_harga.id', '=', 'uns_sampah-merek.harga_id')
            ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
            ->select(
                'uns_sampah.nama as sampah',
                'uns_perusahaan_induk.nama as induk',
                'uns_perusahaan_induk.id as induk_id',
                'uns_perusahaan_induk.waktu_catat',
                'uns_merek.merek as merek',
                'uns_epr_harga.poin_epr'
            );
        $data = $data_raw->get();
        $merek = $data_raw->first();
        $history_raw = DB::table('uns_epr_history')
            ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
            ->where('uns_sampah-merek.merek_id', $id2)
            // ->where('uns_sampah.aktif', 'Y')
            ->join('uns_sampah', 'uns_sampah.id',  'uns_sampah-merek.sampah_id')
            ->join('uns_merek', 'uns_merek.id',  'uns_sampah-merek.merek_id')
            ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
            ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
            ->select(
                'uns_sampah.nama as sampah',
                'uns_perusahaan_induk.nama as induk',
                'uns_perusahaan_induk.id as induk_id',
                'uns_perusahaan_induk.waktu_catat',
                'uns_merek.merek as merek',
                'uns_epr_harga.poin_epr',
                'uns_ambilin_booking.kolektor_id',
                'ambilin.wp_id',
                'uns_epr_history.jumlah',
                'uns_epr_history.id as epr_id'
            )
            ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
            ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
            ->join('uns_berat', 'uns_berat.id_ambilin', 'ambilin.id')
            // ->distinct('uns_epr_history.id')
        ;
        // $test = $history_raw->get();
        // dd($test);
        $totalsum = $history_raw->sum('uns_epr_history.jumlah');

        if (auth()->user()->kat_user == 1 || auth()->user()->kat_user == 3) {
            $mysum = $history_raw->where('ambilin.wp_id', auth()->user()->id)->sum('uns_epr_history.jumlah');
            $history = $history_raw->where('ambilin.wp_id', auth()->user()->id)->get();
        }
        if (auth()->user()->kat_user == 2) {
            $mysum = $history_raw->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)->sum('uns_epr_history.jumlah');
            $history = $history_raw->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)->get();
        }

        // dd($history);
        return view('epr', compact('per_induk', 'page', 'id2', 'data', 'now', 'merek', 'mysum', 'totalsum', 'tipe'));
    }

    /* Jarak Tampil */
    public function jarak_tampil() {
        $page = 'Jarak Tampil';
        $back = 'dashboard';
        if (!empty(auth()->user()->jarak_tampil)) {
            $jarak_tampil = auth()->user()->jarak_tampil;
        } else {
            $jarak_tampil = 10;
        }
        return view('jarak_tampil',compact('page', 'back', 'jarak_tampil'));
    }

    public function post_jarak_tampil(Request $request) {
        $request->validate([
            "jarak_tampil"  => "required",
        ]);

        $user               = User::find(auth()->user()->id);
        $user->jarak_tampil = $request->jarak_tampil;
        $user->save();
        return redirect()->route('jarak_tampil')->with('success', 'Data berhasil disimpan');
    }
    /* END Jarak Tampil */

    public function notifikasi()
    {
        $page = 'Notifikasi';
        $back = 'dashboard';
        Carbon::SetLocale('id');
        $now = Carbon::now();
        $today = Carbon::today();
        $lstmon = $today->subMonth();
        $translated_now = Carbon::now()->translatedformat('H:i l, d F Y');
        $mynotif_raw = Notifikasi::where(function ($query) {
            $query->where('id_user', auth()->user()->id)
                ->orWhere('id_user', null);
        })->where('waktu_catat', '>', $lstmon)->join('uns_notif_raw', 'uns_notif_raw.id', 'uns_notif.id_notif');
        // $mynotif_count = $mynotif_raw->count();
        $notifikasi = $mynotif_raw->orderby('waktu_catat', 'desc')->paginate(5)->onEachSide(0);
        Log::Create([
            'id_user'       =>  auth()->user()->id,
            'akses'         =>  $page,
            'ket'           =>  null,
            'waktu_catat'   =>  $now,
        ]);
        // dd($page);
        return view('notifikasi', compact('page', 'back', 'notifikasi', 'translated_now', 'now'));
    }

    public function test(){
        $data = db::table('ambilin')->where('verifikasi','proses')->whereNot('status', 1)->whereNot('status', 4)->whereNot('status', 9)->get();
        // $data = db::table('ambilin')->join('uns_berat','uns_berat.id_ambilin','ambilin.id')->where('ambilin.status', 2)->whereNotNull('uns_berat.berat_riil')->get();
        dd($data);
    }
}
