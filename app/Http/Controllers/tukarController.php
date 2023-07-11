<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Poin_usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class tukarController extends BaseController
{
    public function index()
    {
        $page = 'Tukar Poin';
        $back='dashboard';
        return view('tukar_poin',compact('page','back'));
    }
    public function tukar($jenis)
    {
        $page = 'Tukar Poin';
        $back = 'tukar-poin';
        $raw_now = Carbon::now();
        $carb_now = $raw_now->translatedFormat('l, d F Y');
        $harga_lt = DB::table('uns_tukar')
            ->where('tipe', 'ambilin-lt')
            ->select('harga', 'nilai_tukar as nilai')
            ->first();
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 3);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->get();
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
        }
        $count_amb = count($count_amb_raw);
        $sum_lt = ($count_amb / $harga_lt->harga) * $harga_lt->nilai;
        if (auth()->user()->kat_user != 2) {
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
        }
        if (auth()->user()->kat_user == 2) {
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
        }
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
        $lt = $sum_lt - $usage_lt;
        $epr = $sum_epr - $usage_epr;
        // dd($count_amb,$usage_lt,$sum_lt);
        $tukar = DB::table('uns_tukar')->where('tipe', $jenis)->where('aktif', 'aktif')->get();
        return view('tukar', compact('back', 'page', 'carb_now', 'tukar', 'jenis', 'count_amb', 'sum_lt', 'lt', 'epr', 'sum_epr'));
    }

    public function post_tukar(Request $request, $jenis, $id)
    {
        // dd($request->jumlah, $jenis, $id);
        $request->validate([
            'jumlah' => 'required',
        ]);

        $harga_lt = DB::table('uns_tukar')
            ->where('tipe', 'ambilin-lt')
            ->select('harga', 'nilai_tukar as nilai')
            ->first();
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 3);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->get();
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
        }
        $count_amb = count($count_amb_raw);
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
        $lt = $sum_lt - $usage_lt;

        if (auth()->user()->kat_user != 2) {
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
                $sum_epr_array[] = $sumeprraw->jumlah/$sumeprraw->harga ;
            }
            $sum_epr = array_sum($sum_epr_array);
        }
        if (auth()->user()->kat_user == 2) {
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
        }
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
        $epr = $sum_epr - $usage_epr;

        $waktu_catat = Carbon::now();

        // $jenis = DB::table('uns_tukar')->where('id', $id)->first();
        $poin = '';
        if ($jenis == 'lt') {
            $poin = $lt;
        } else if ($jenis == 'epr') {
            $poin = $epr;
        }
        $harga = DB::table('uns_tukar')->where('id', $id)->first();
        // dd($poin, $id, $harga);
        if ($request->jumlah >= 1) {
            if (($request->jumlah * $harga->harga) <= $poin) {
                Poin_usage::Create([
                    'user_id'       => auth()->user()->id,
                    'jenis'         => $jenis,
                    'tukar_id'      => $id,
                    'jumlah'        => $request->jumlah,
                    'waktu_catat'   => $waktu_catat,
                ]);
                return redirect()->route('tukar_poin_jenis', ['jenis' => $jenis])->with('success', 'Penukaran berhasil');
            } else {
                return redirect()->route('tukar_poin_jenis', ['jenis' => $jenis])->with('error', 'Penukaran gagal, Poin anda tidak mencukupi untuk melakukan transaksi');
            }
        } else {
            return redirect()->route('tukar_poin_jenis', ['jenis' => $jenis])->with('error', 'Tidak dapat melakukan transaksi dengan jumlah transaksi dibawah 1');
        }
    }
}
