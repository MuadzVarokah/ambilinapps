<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Ambilin;
use App\Models\User;
use App\Models\Berat;
use App\Models\Harga;
use App\Models\Booking;
use App\Models\EPR_History;
use App\Models\Rating;
use App\Models\Notifikasi;
use App\Models\Alasan_ambilin;
use App\Http\Controllers\notificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class ambilinController extends BaseController
{
    protected $notificationController;
    public function __construct(notificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function index()
    {
    
    }

    public function ambilin()
    {        
        // $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
        // ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
        // ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        // ->count();
        if(auth()->user()->kat_user != 2){
            $count_riwayat = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.status', 3) 
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->orwhere('waste_date.tgl', '<', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.status', 1)
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->count();
            $count_proses_raw = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 2)
            ->orwhere('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 1)
            ->count();
            $count_batal = db::table('ambilin')->select('ambilin.id')
            ->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
            $count_proses = $count_proses_raw;
            // dd($count_proses, $count_riwayat, $count_batal);
        }
        elseif(auth()->user()->kat_user == 2){
            $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 3)->count();
            $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
            $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
        }

        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        // $tgl_ambilin = DB::table('ambilin')
        //     ->where('ambilin.wp_id', auth()->user()->id)
        //     ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        //     ->select('waste_date.tgl')
        //     ->first();
        // if (empty($tgl_ambilin)) {
        //     $tgl_trans = '';
        // } else {
        //     $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        // }
        // $berat_raw = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
        //     ->join('ambilin', 'ambilin.wp_id', '=', 'uns_user.id')
        //     ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
        //     ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
        //     ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
        //     ->select('uns_berat.berat', 'uns_berat.id_ambilin', 'ambilin.waktucatat', 'waste_cat.nama AS jenis', 'waste_cat.harga_down', 'waste_cat.harga_top');
        // //->where('ambilin.waktucatat', $tgl_ambilin)
        // $berat = $berat_raw->sum('berat');
        // $sum_down = $berat_raw->sum('harga_down');
        // $sum_top = $berat_raw->sum('harga_top');
        // $jenis_raw = $berat_raw->get();
        // //dd($jenis_raw);
        // $jenis = $berat_raw->first();
        if ($user->kat_user == 2) {
            //     $booked = DB::table('uns_ambilin_booking')->select('ambilin_id')->get()->toArray();
            //     foreach($booked as $book){
            //         $booked_ambilin[] = $book->ambilin_id;
            // } 
            $data_raw = DB::table('uns_ambilin_booking')
                /* booking - ambilin */
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                /* user - ambilin */
                ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->where('ambilin.status', '=', 2)
                ->where('ambilin.hapus', '!=', '1')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.verifikasi',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'ambilin.idlokasi',
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
            // dd($booked,$data_raw);
            //->union($tgl_ambilin)->union($tgl_trans)->union($berat)->get();
            // ->union($berat)
            // dd($data);

        } elseif ($user->kat_user != 2) {
            $data_raw = DB::table('ambilin')
                /* uns_berat - ambilin */
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.status', '<', 3)
                ->where('ambilin.hapus', '!=', '1')
                ->where(function ($q) {
                    $q->where('ambilin.verifikasi','proses')
                        ->orWhere('ambilin.verifikasi','diterima');
                })
                /* user - ambilin */
                ->join('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->where(function ($q) {
                    $q->where('waste_date.tgl', '>', Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s"))
                        ->orWhere('ambilin.status', 2);
                })
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.id AS id_ambilin',
                    'ambilin.verifikasi',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'uns_status.nama AS status',
                    'waste_date.tgl',
                    'ambilin.waktucatat',
                    'waste_time.waktu',
                    'wp_lokasi.alamat_lokasi',
                    'wp_lokasi.id as idlokasi',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel'
                );
        }

        //$datanew = $data->merge($jenis_raw)->groupby('id_ambilin');
        //dd($datanew);
        //dd($data,$tgl_ambilin,$tgl_trans,$berat);
        $data = $data_raw->orderby('ambilin.status', 'DESC')->orderby('waste_date.tgl')->orderby('waste_time.waktu')->paginate(5);
        // dd($data);
        // return view('ambilin', compact(
        //     'today', 'user', 'back', 'page', 'data', 'tgl_trans', 
        //     'berat', 'berat_raw', 'jenis', 'jenis_raw', 'sum_top', 
        //     'sum_down', 'count_proses', 'count_batal','count_tersedia','count_riwayat'));
        return view('ambilin', compact(
            'today', 'user', 'back', 'page', 'data', 'count_proses', 'count_batal', 'count_riwayat'));
    }

    public function ambilin_kolektor($x, $y)
    {
        // dd($x, $y);
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }

        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';

        /** Count Badge */
        // $count_tersedia = DB::table('ambilin')
        //     ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        //     ->where('waste_date.tgl', '>=', $today)
        //     ->where('verifikasi', 'diterima')
        //     ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
        //     ->where('ambilin.status', '=', 1)
        //     ->select('ambilin.id AS id_ambilin', 'wp_lokasi.lokasi_x', 'wp_lokasi.lokasi_y')
        //     ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
        //     ->having("distance", "<=", $lokasi_tampil)
        //     ->count();
        $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
            ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
            ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            ->select('wp_lokasi.lokasi_x', 'wp_lokasi.lokasi_y')
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil)
            ->count();
        $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 3)->count();
        $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
        $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status',4)->count();
        // $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        //     ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        //     ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        //     ->where(function ($q) {
        //         $q->where('ambilin.status',4)
        //             ->orWhere('ambilin.verifikasi','ditolak');
        //     })->count();
        /** END Count Badge */
        
        /** List Data Ambilin */
        $data = DB::table('uns_ambilin_booking')
            /* booking - ambilin */
            ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
            ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
            /* user - ambilin */
            ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            /* wp - user */
            //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->where('ambilin.status', '=', 2)
            ->where('ambilin.hapus', '!=', '1')
            ->select(
                'ambilin.foto',
                'ambilin.keterangan',
                'ambilin.verifikasi',
                'ambilin.id AS id_ambilin',
                'ambilin.wp_id AS id_wp',
                'ambilin.status AS status_id',
                'ambilin.idlokasi',
                'uns_status.nama AS status',
                'waste_date.tgl',
                'ambilin.waktucatat',
                'waste_time.waktu',
                'wp_lokasi.alamat_lokasi',
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel'
            )
            ->orderby('ambilin.status', 'DESC')
            ->orderby('waste_date.tgl')
            ->orderby('waste_time.waktu')
            // ->get();
            ->paginate(5);
        /** END List Data Ambilin */
        // dd($data);

        Session::put('ambilin_url', request()->fullUrl());

        return view('ambilin', compact('x', 'y', 'today', 'back', 'page', 'data', 'count_proses', 'count_batal', 'count_tersedia', 'count_riwayat'));
    }

    public function ambilin_baru()
    {
        $page = 'Ambilin Sampah Pilahanku';
        $back = 'ambilin';
        $lokasi = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)->where('aktif', 'Y')->get();
        $tanggal = DB::table('waste_date')->where('aktif', 'Y')->get();
        //$tanggal = Carbon::parse($tanggal_raw->tgl)->translatedFormat('l, d F Y');
        $waktu = DB::table('waste_time')->where('aktif', 'Y')->get();
        // $user = DB::table('uns_user')->get();
        $berat_min = db::table('uns_kat_user')->where('id', auth()->user()->kat_user)->pluck('min_berat')->first();

        $jenis = Harga::where('kat_user', auth()->user()->kat_user)->where('waste_cat.aktif', '1')->get();
        // if (auth()->user()->kat_user == 1) {
        //     $jenis = DB::table('waste_cat')
        //     ->where('kat_user', 1)
        //     ->where('waste_cat.aktif', '1')->get();
        // } else if (auth()->user()->kat_user != 1) {
        //     $jenis = DB::table('waste_cat')
        //     ->where('kat_user', 2)
        //     ->where('waste_cat.aktif', '1')->get();
        // }

        // dd($lokasi,$tanggal, $waktu);
        return view('ambilin_baru', compact('back', 'page', 'lokasi', 'tanggal', 'waktu', 'jenis','berat_min'));
    }

    public function ambilin_post(Request $request)
    {
        // dd($request);
        // dd($request->file('foto'));
        $request->validate([
            'foto'                  => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'tgl_ambil'             => 'required',
            'waktu_ambil'           => 'required',
            'lokasi_pengambilan'    => 'required',
            'keterangan'            => 'nullable|max:255',
            'sampah.*.jenis'        => 'required',
            'sampah.*.berat'        => 'required|numeric',
        ]);

        // if()
        $fileName = time() . '_' . request()->foto->getClientOriginalName();
        $destination = 'public/img/ambilin/sampah';
        $request->file('foto')->move($destination, $fileName);

        Carbon::setLocale('id');
        $now = Carbon::now();
        $total = 0;
        foreach ($request->sampah as $key => $value) {
            $total += $value['berat'];
        }
        // dd($total);

        $berat_min = db::table('uns_kat_user')->where('id', auth()->user()->kat_user)->pluck('min_berat')->first();

        $sum_amb_raw = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id);
        $sum_amb = $sum_amb_raw->count();
        $count_amb_raw = $sum_amb_raw
            ->where('ambilin.status', 3)
            ->select('id')
            ->get();
        $count_amb = count($count_amb_raw);

        if ($total >= $berat_min) {
            if($count_amb < 3){
                $verif_amb = 'proses';
            } else {
                $verif_amb = 'diterima';
            }

            $id = Ambilin::Create([
                'status'        => 1,
                'wp_id'         => auth()->user()->id,
                'foto'          => $fileName,
                'tgl_ambil'     => $request->tgl_ambil,
                'waktu_ambil'   => $request->waktu_ambil,
                'idlokasi'      => $request->lokasi_pengambilan,
                'keterangan'    => $request->keterangan,
                'verifikasi'    => $verif_amb,
                'idroling'      => 0,
                'waktucatat'    => $now,
            ])->id;
            foreach ($request->sampah as $key => $value) {
                Berat::Create([
                    'id_ambilin'    => $id,
                    'id_sampah'     => $value['jenis'],
                    'berat'         => $value['berat'],
                ]);
            }

            $user           = User::find(auth()->user()->id);
            $user->count    = ($user->count) + 1;
            $user->save();

            if($verif_amb == 'diterima'){
                Notifikasi::Create([
                    'id_user' => auth()->user()->id,
                    'id_notif' => 2,
                    'waktu_catat' => $now,
                ]);
            } else {
                Notifikasi::Create([
                    'id_user' => auth()->user()->id,
                    'id_notif' => 13,
                    'waktu_catat' => $now,
                ]);
            }

            return redirect()->route('ambilin')->with('success', 'request ambilin berhasil ditambahkan');
        } else {
            return redirect()->route('ambilin_baru')->with('error', 'Berat barang minimal '.$berat_min.' kg');
        }
    }

    public function ambilin_tersedia($x, $y)
    {
        // dd($x, $y);
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }
        // $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
        // ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
        // ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        // ->count();
        $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status', 3)->count();
        $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
        $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status',4)->count();
        // $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        // ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        // ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        // ->where(function ($q) {
        //     $q->where('ambilin.status',4)
        //         ->orWhere('ambilin.verifikasi','ditolak');
        // })->count();

        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        $tgl_ambilin = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id)
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->select('waste_date.tgl')
            ->first();
        if (empty($tgl_ambilin)) {
            $tgl_trans = '';
        } else {
            $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        }

        $data_raw = DB::table('ambilin')
            /* booking - ambilin */
            /* user - ambilin */
            ->join('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('waste_date.tgl', '>=', $today)
            ->where('verifikasi', 'diterima')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            /* wp - user */
            //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->where('ambilin.status', '=', 1)
            ->select(
                'ambilin.foto',
                'ambilin.keterangan',
                'ambilin.id AS id_ambilin',
                'ambilin.wp_id AS id_wp',
                'ambilin.status AS status_id',
                'ambilin.idlokasi',
                'uns_status.nama AS status',
                'waste_date.tgl',
                'ambilin.waktucatat',
                'waste_time.waktu',
                'wp_lokasi.alamat_lokasi',
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel'
            )
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil);
        // dd($booked,$data_raw);
        //->union($tgl_ambilin)->union($tgl_trans)->union($berat)->get();
        // ->union($berat)

        $count_tersedia = $data_raw->count();
        $data = $data_raw->orderby('ambilin.status', 'DESC')->orderby('waste_date.tgl')->orderby('waste_time.waktu')->paginate(5);

        //$datanew = $data->merge($jenis_raw)->groupby('id_ambilin');
        //dd($datanew);
        // dd($data);
        //dd($data,$tgl_ambilin,$tgl_trans,$berat);

        Session::put('ambilin_url', request()->fullUrl());

        return view('ambilin_tersedia', compact('x', 'y','user', 'back', 'page', 'data', 'tgl_trans', 'count_tersedia', 'count_proses', 'count_riwayat','count_batal'));
    }

    public function ambilin_edit($id)
    {
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $ambilin = DB::table('ambilin')
            ->where('ambilin.id', $id);
        $data = $ambilin
            /* user - ambilin */
            ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
            /* wp - user */
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                'uns_user.nama AS nama',
                'uns_user.foto_diri AS foto_diri',
                'ambilin.status as status_id',
                'ambilin.keterangan',
                'ambilin.verifikasi',
                'uns_status.nama as status',
                'ambilin.id AS id_ambilin',
                'ambilin.idlokasi',
                'ambilin.foto',
                'ambilin.wp_id AS id_wp',
                'ambilin.waktucatat',
                'ambilin.waktuubah',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel',
                'waste_date.tgl',
                'waste_time.waktu',
                'wp_lokasi.id AS id_lokasi',
                'wp_lokasi.alamat_lokasi',
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y'
            )
            ->first();
        // $tgl_trans = Carbon::parse($data_tgl->tgl)->translatedFormat('l, d F Y');
        $kolektor = DB::table('uns_ambilin_booking')
            ->where('ambilin_id', $id)
            ->join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
            ->select('uns_user.nama', 'uns_user.foto_diri', 'uns_ambilin_booking.id as booking_id','uns_ambilin_booking.kolektor_id as id','uns_ambilin_booking.waktu_catat as waktu_booking')
            ->first();
        $tb_berat_raw = DB::table('uns_berat')->where('id_ambilin', $id);
        $jenis = count($tb_berat_raw->get());

        if($data->status_id != 3) {
            $berat = $tb_berat_raw->sum('berat');
            $list_sampah = Berat::where('id_ambilin', $id)
                ->join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')
                ->select(
                    'waste_cat.nama',
                    'waste_cat.harga_down',
                    'waste_cat.harga_top',
                    'uns_berat.berat',
                    'uns_berat.id_sampah',
                    'uns_berat.id AS id_berat',
                    )
                ->get();
        } else {
            $berat = $tb_berat_raw->sum('berat_riil');
            $list_sampah = Berat::where('id_ambilin', $id)
                ->join('waste_cat', 'waste_cat.id', 'uns_berat.id_sampah')
                ->select(
                    'waste_cat.nama',
                    'uns_berat.berat_riil',
                    'uns_berat.harga_riil',
                    'uns_berat.id_sampah',
                    'uns_berat.id AS id_berat',
                    )
                ->get();
        }

        $rating_cek = null;
        if (!empty($kolektor) && auth()->user()->kat_user != 2) {
            $rating_raw = db::table('uns_ratings')
                ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_ratings.booking_id')
                ->where('rating', '>', 3)->where('uns_ambilin_booking.kolektor_id',$kolektor->id) //jika rating >3
                ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('uns_ambilin_booking.kolektor_id',$kolektor->id)
                ->select(
                    'uns_ratings.*',
                    'uns_ambilin_booking.id as booking_id',
                    'uns_ambilin_booking.ambilin_id',
                    'uns_ambilin_booking.kolektor_id',
                );
            $rating_avg = $rating_raw->avg('rating');
            $rating_cek = Arr::flatten($rating_raw->pluck('ambilin_id')->toArray());
        } else {
            $rating_raw = db::table('uns_ratings_mitra')
                ->join('ambilin', 'ambilin.id', 'uns_ratings_mitra.ambilin_id')
                ->where('rating', '>', 3)->where('ambilin.wp_id',$data->id_wp) //jika rating >3
                ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('ambilin.wp_id',$data->id_wp)
                ->select(
                    'uns_ratings_mitra.*',
                    'ambilin.wp_id',
                );
            $rating_avg = null;
            $rating_cek = Arr::flatten($rating_raw->pluck('ambilin_id')->toArray());
        }

        $count_amb = count(
            DB::table('ambilin')
                ->where('ambilin.wp_id', $data->id_wp)
                ->where('ambilin.status', 3)
                ->get()
        );
        $pangkat = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();

        if (auth()->user()->kat_user != 2) {
            $attribute = $rating_avg;
            if ($data->status_id == 1) {
                $page = 'Edit Sampah Ambilin';
                $back = 'ambilin';
                if ($data->tgl < Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s")) {
                    $back = 'ambilin_riwayat';
                }
            } elseif ($data->status_id == 2) {
                $page = 'Detail Sampah';
                $back = 'ambilin';
            } elseif ($data->status_id == 3) {
                $page = 'Detail Sampah';
                $back = 'ambilin_riwayat';
            } elseif ($data->status_id == 4) {
                $page = 'Detail Sampah';
                $back = 'ambilin_batal';
            } 
        } elseif (auth()->user()->kat_user == 2) {
            $attribute = $pangkat->pangkat;
            if ($data->status_id == 1) {
                $page = 'Detail Sampah';
                $back = 'ambilin_tersedia';
            }
            if ($data->status_id == 2) {
                $page = 'Detail Sampah';
                $back = 'ambilin';
            } elseif ($data->status_id == 3) {
                $page = 'Detail Sampah';
                $back = 'ambilin_riwayat';
            } elseif ($data->status_id == 4) {
                $page = 'Detail Sampah';
                $back = 'ambilin_batal';
            }
        }
        if ((auth()->user()->kat_user != 2) && ($data->status_id == 1)) {
            $tanggal = DB::table('waste_date')->where('aktif', 'Y')->get();
            $waktu = DB::table('waste_time')->where('aktif', 'Y')->get();
            $lokasi = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)->where('aktif', 'Y')->get();
            $jenis_sampah = Harga::where('kat_user', auth()->user()->kat_user)->where('waste_cat.aktif', '1')->get();
            return view('ambilin_edit', compact('id', 'today', 'data', 'page', 'back', 'jenis', 'berat', 'kolektor', 'attribute', 'list_sampah', 'tanggal', 'waktu', 'lokasi', 'jenis_sampah', 'rating_cek'));
        }

        if(session('ambilin_url')) {
            $back_url = session('ambilin_url');
            return view('ambilin_edit', compact('id', 'today', 'data', 'page', 'back_url', 'jenis', 'berat', 'kolektor', 'attribute', 'list_sampah', 'rating_cek'));
        }

        return view('ambilin_edit', compact('id', 'today', 'data', 'page', 'back', 'jenis', 'berat', 'kolektor', 'attribute', 'list_sampah', 'rating_cek'));
    //     /* if */
    //     if (auth()->user()->kat_user != 2) {
    //         $berat_raw = DB::table('uns_user')
    //             ->where('uns_user.id', auth()->user()->id)
    //             ->join('ambilin', 'ambilin.wp_id', '=', 'uns_user.id')
    //             ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
    //             ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
    //             ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
    //             ->where('ambilin.id', $id)
    //             ->select(
    //                 'uns_berat.id as id_berat',
    //                 'ambilin.status',
    //                 'uns_berat.berat',
    //                 'uns_berat.berat_riil',
    //                 'uns_berat.harga_riil',
    //                 'ambilin.waktucatat',
    //                 'waste_cat.waktu_catat as waste_waktucatat',
    //                 'waste_cat.nama',
    //                 'waste_cat.harga_down',
    //                 'waste_cat.harga_top'
    //             );
    //         //->where('ambilin.waktucatat', $tgl_ambilin)
    //         $berat = $berat_raw->sum('berat');
    //         $berat_riil = $berat_raw->sum('berat_riil');
    //         $total_riil = $berat_raw->sum('harga_riil');
    //         $harga_array = array();
    //         // $sum_down = $berat_raw ->sum('harga_down');
    //         // $sum_top = $berat_raw ->sum('harga_top');
    //         $jenis = $berat_raw->get();
    //         foreach ($jenis as $jinis) {
    //             if (!empty($jinis->berat_riil) && empty($jenis->harga_riil)) {
    //                 $est_down = $jinis->harga_down * $jinis->berat_riil;
    //                 $est_top = $jinis->harga_top * $jinis->berat_riil;
    //             } else {
    //                 $est_down = $jinis->harga_down * $jinis->berat;
    //                 $est_top = $jinis->harga_top * $jinis->berat;
    //             }
    //             if(!empty($jinis->berat_riil) && !empty($jinis->harga_riil)){
    //                 $harga_array[] = $jinis->berat_riil * $jinis->harga_riil;
    //             }elseif(empty($jinis->berat_riil) && !empty($jinis->harga_riil)){
    //                 $harga_array[] = $jinis->berat * $jinis->harga_riil;
    //             }else{
    //                 $harga_array[] = ($est_down + $est_top) / 2;
    //             }
    //         }
    //         // dd($harga_array);
    //         $sum_harga = array_sum($harga_array);
    //         $kolektor = DB::table('uns_ambilin_booking')
    //             ->where('ambilin_id', $id)
    //             ->first();
    //         $rating_raw = db::table('uns_rating')
    //             ->where('rating', '>', 3)->where('kolektor_id',$kolektor->kolektor_id) //jika rating >3
    //             ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('kolektor_id',$kolektor->kolektor_id);
    //         $rating_avg = $rating_raw->avg('rating');
    //         //dd($jenis);

    //     }
    //     if (auth()->user()->kat_user == 2) {
    //         // dd($id,auth()->user()->kat_user);
    //         $berat_raw = DB::table('ambilin')
    //             ->where('ambilin.id', $id)
    //             ->leftjoin('uns_user', 'uns_user.id', 'ambilin.wp_id')
    //             ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
    //             ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
    //             ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
    //             ->select(
    //                 'ambilin.id as id_ambil',
    //                 'uns_berat.id as id_berat',
    //                 'ambilin.status',
    //                 'uns_berat.berat',
    //                 'uns_berat.berat_riil',
    //                 'uns_berat.harga_riil',
    //                 'ambilin.waktucatat',
    //                 'waste_cat.waktu_catat as waste_waktucatat',
    //                 'waste_cat.nama',
    //                 'waste_cat.harga_down',
    //                 'waste_cat.harga_top'
    //             );
    //         $count_amb = count(
    //             DB::table('ambilin')
    //                 ->where('ambilin.wp_id', $mitra->wp_id)
    //                 ->where('ambilin.status', 3)
    //                 ->get()
    //         );
    //         $pangkat = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();
    //         $berat = $berat_raw->sum('berat');
    //         $berat_riil = $berat_raw->sum('berat_riil');
    //         $total_riil = $berat_raw->sum('harga_riil');
    //         // dd($harga_array,$sum_harga);

    //         $jenis = $berat_raw->get();
    //         $harga_array = array();
    //         foreach ($jenis as $jinis) {
    //             if (!empty($jinis->berat_riil) && empty($jenis->harga_riil)) {
    //                 $est_down = $jinis->harga_down * $jinis->berat_riil;
    //                 $est_top = $jinis->harga_top * $jinis->berat_riil;
    //             } else {
    //                 $est_down = $jinis->harga_down * $jinis->berat;
    //                 $est_top = $jinis->harga_top * $jinis->berat;
    //             }
    //             if(!empty($jinis->berat_riil) && !empty($jinis->harga_riil)){
    //                 $harga_array[] = $jinis->berat_riil * $jinis->harga_riil;
    //             }elseif(empty($jinis->berat_riil) && !empty($jinis->harga_riil)){
    //                 $harga_array[] = $jinis->berat * $jinis->harga_riil;
    //             }else{
    //                 $harga_array[] = ($est_down + $est_top) / 2;
    //             }
    //         }
    //         $sum_harga = array_sum($harga_array);
    //         $kolektor = DB::table('uns_ambilin_booking')
    //             ->where('ambilin_id', $id)
    //             ->join('uns_user', 'uns_user.id', 'uns_ambilin_booking.kolektor_id')
    //             ->select('uns_user.nama', 'uns_user.foto_diri', 'uns_ambilin_booking.id as booking_id','uns_ambilin_booking.kolektor_id as id','uns_ambilin_booking.waktu_catat as waktu_booking')
    //             ->first();
    //         if(!empty($kolektor)){
    //             $ada = db::table('uns_rating')->where('kolektor_id', $kolektor->id)->where('mitra_id', auth()->user()->id)->first();
    //         } else{
    //             $ada = '';
    //         }
    // }
    //     /* * */
    //     // dd($id);
    //     $ambilin = DB::table('ambilin')
    //         ->where('ambilin.id', $id);
    //     $data = $ambilin
    //         /* user - ambilin */
    //         ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
    //         ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
    //         ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
    //         ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
    //         ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
    //         /* wp - user */
    //         ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
    //         ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
    //         ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
    //         ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
    //         ->select(
    //             'uns_user.nama AS nama',
    //             'uns_user.foto_diri AS foto_diri',
    //             'ambilin.status as status_id',
    //             'ambilin.keterangan',
    //             'ambilin.verifikasi',
    //             'uns_status.nama as status',
    //             'ambilin.id AS id_ambilin',
    //             'ambilin.idlokasi',
    //             'ambilin.foto',
    //             'ambilin.wp_id AS id_wp',
    //             'ambilin.waktucatat',
    //             'indonesia_provinces.name AS prov',
    //             'indonesia_cities.name AS kab',
    //             'indonesia_districts.name AS kec',
    //             'indonesia_villages.name As kel',
    //             'waste_date.tgl',
    //             'waste_time.waktu',
    //             'wp_lokasi.alamat_lokasi',
    //             'wp_lokasi.lokasi_x',
    //             'wp_lokasi.lokasi_y'
    //         )
    //         ->first();
    //     // dd($data->status_id);
    //     if (auth()->user()->kat_user != 2) {
    //         if ($data->status_id < 3) {
    //             $page = 'Edit Sampah Ambilin';
    //             $back = 'ambilin';
    //             if ($data->tgl < Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s") && $data->status_id == 1) {
    //                 $back = 'ambilin_riwayat';
    //             }
    //         } elseif ($data->status_id == 3) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin_riwayat';
    //         } elseif ($data->status_id == 4) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin_batal';
    //         }
    //     } elseif (auth()->user()->kat_user == 2) {
    //         if ($data->status_id == 1) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin_tersedia';
    //         }
    //         if ($data->status_id == 2) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin';
    //         } elseif ($data->status_id == 3) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin_riwayat';
    //         } elseif ($data->status_id == 4) {
    //             $page = 'Detail Sampah';
    //             $back = 'ambilin_batal';
    //         }
    //     }

    //     if ($data->status_id == 3) {
    //         if (auth()->user()->kat_user != 2) {
    //             $sum_epr_raw = DB::table('uns_epr_history')
    //                 ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
    //                 ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
    //                 ->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.id', $id)
    //                 ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
    //                 ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
    //                 ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
    //                 ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
    //                 ->join('uns_sampah', 'uns_sampah.id', 'uns_sampah-merek.sampah_id')
    //                 ->select(
    //                     'uns_epr_harga.poin_epr as harga',
    //                     'uns_epr_history.jumlah as berat',
    //                     'uns_perusahaan_induk.nama as induk',
    //                     'uns_merek.merek as merek',
    //                     'uns_sampah.nama as sampah'
    //                 );
    //             $detail_epr = $sum_epr_raw->get();
    //             $sum_epr_array = array();
    //             foreach ($detail_epr as $detailepr) {
    //                 $sum_epr_array[] = $detailepr->berat / $detailepr->harga;
    //             }
    //             $sum_epr = array_sum($sum_epr_array);
    //         }
    //         if (auth()->user()->kat_user == 2) {
    //             /* total epr */
    //             $sum_epr_raw = DB::table('uns_epr_history')
    //                 ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_epr_history.booking_id')
    //                 ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
    //                 ->where('uns_ambilin_booking.ambilin_id', $id)
    //                 ->join('uns_sampah-merek', 'uns_sampah-merek.id', 'uns_epr_history.sampah-merek_id')
    //                 ->join('uns_epr_harga', 'uns_epr_harga.id', 'uns_sampah-merek.harga_id')
    //                 ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
    //                 ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
    //                 ->join('uns_sampah', 'uns_sampah.id', 'uns_sampah-merek.sampah_id')
    //                 ->select(
    //                     'uns_epr_harga.poin_epr as harga',
    //                     'uns_epr_history.jumlah as berat',
    //                     'uns_perusahaan_induk.nama as induk',
    //                     'uns_merek.merek as merek',
    //                     'uns_sampah.nama as sampah'
    //                 );
    //             $detail_epr = $sum_epr_raw->get();

    //             $sum_epr_array = array();
    //             foreach ($detail_epr as $detailepr) {
    //                 $sum_epr_array[] = $detailepr->berat / $detailepr->harga;
    //             }
    //             $sum_epr = array_sum($sum_epr_array);
    //             /* total epr end */
    //         }
    //     }

    //     $harga = $berat_raw
    //         ->where('ambilin.waktucatat', '>', 'waste_cat.waktu_catat')
    //         ->select('waste_cat.id', 'ambilin.waktucatat AS ambilin_waktu', 'waste_cat.waktu_catat AS cat_waktu', 'waste_cat.harga_down', 'waste_cat.harga_top')
    //         ->get();
    //     $harga_lama = empty($harga) ? 0 : $berat_raw
    //         ->join('uns_harga_lama', 'uns_harga_lama.id_waste', '=', 'ambilin.id')
    //         ->where('ambilin.waktucatat', '>', 'uns_harga_lama.waktu_catat')
    //         ->latest('uns_harga_lama.waktu_catat')
    //         ->select('uns_harga_lama.id', 'waste_cat.waktu_catat AS cat_waktu', 'uns_harga_lama.old_down', 'uns_harga_lama.old_top')->get();
    //     // dd($id,$berat,$berat_raw,$jenis,$data,$harga,$harga_lama,auth()->user());
    //     if ($data->status_id == 3) {
    //         // dd($kolektor);
    //         return view('ambilin_edit', compact('ada','sum_harga', 'total_riil', 'berat_riil', 'detail_epr', 'sum_epr', 'back', 'today', 'data', 'berat', 'jenis', 'id', 'kolektor', 'page', 'tgl_ambilin', 'tgl_trans'));
    //     } else {
    //         return view('ambilin_edit', compact('sum_harga','back', 'today', 'data', 'berat', 'jenis', 'id', 'kolektor', 'page', 'tgl_ambilin', 'tgl_trans'));
    //     }
    }

    public function ambilin_ambil($id)
    {
        $ambilin            = Ambilin::find($id);
        if($ambilin->status == 1){        
            $ambilin->status    = 2;
            $ambilin->save();
        } else{
            if($ambilin->status == 2){
                $reason = 'terbooking';
            } elseif($ambilin->status == 3){
                $reason = 'terambil';
            } elseif($ambilin->status == 4){
                $reason = 'dibatalkan pemilik';
            } elseif($ambilin->status == 9){
                $reason = 'dihapus pemilik';
            }
            return redirect()->back()->with('danger', 'ambilin tersebut telah'. $reason);
        }

        Carbon::setLocale('id');
        $now = Carbon::now();

        Booking::Create([
            'ambilin_id'    => $id,
            'kolektor_id'   => auth()->user()->id,
            'waktu_catat'   => Carbon::now(),
        ]);

        Notifikasi::Create([
            'id_user' => $ambilin->wp_id,
            'id_notif' => 11,
            'waktu_catat'=> $now,
        ]);

        $device_token = User::where('id', $ambilin->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title      = "Ambilin";
            $message    = "Permintaan Ambilin anda diterima oleh kolektor, silahkan tunggu sampah anda diambil";
            $url_notif  = route('ambilin');
            $this->notificationController->send_notification_FCM($device_token, $title, $message, $url_notif);
        }

        return redirect()->back();
    }

    public function ambilin_kolektor_batal($id)
    {
        $ambilin            = Ambilin::find($id);
        $ambilin->status    = 1;
        $ambilin->save();

        DB::table('uns_ambilin_booking')->where('ambilin_id', $id)->delete();

        $device_token = User::where('id', $ambilin->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title      = "Ambilin";
            $message    = "Permintaan Ambilin anda dibatalkan oleh kolektor, silahkan tunggu kolektor lain untuk mengambil sampah anda";
            $url_notif  = route('ambilin');
            $this->notificationController->send_notification_FCM($device_token, $title, $message, $url_notif);
        }

        return redirect()->back();
    }

    public function ambilin_mitra_batal($id)
    {
        $ambilin            = Ambilin::find($id);
        $ambilin->status    = 4;
        $ambilin->save();

        return redirect()->back();
    }

    public function ambilin_verifikasi($id_ambilin, $id_booking) //kolektor
    {
        $page = 'Verifikasi Ambilin';
        $back = 'ambilin_edit';
        $backslug = ['id'=>$id_ambilin]; 
        $ambilin = DB::table('ambilin')->where('id', $id_ambilin)->first();
        $barang = DB::table('uns_berat')->where('id_ambilin', $ambilin->id)
            ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
            ->select('uns_berat.*', 'waste_cat.id as id_sampah', 'waste_cat.nama', 'waste_cat.harga_down', 'waste_cat.harga_top')
            ->get();
        $kat_user_pemilik = User::where('id', $ambilin->wp_id)->first();
        $jenis_sampah = DB::table('waste_cat')
        ->where('aktif', '1')
        ->where('kat_user', $kat_user_pemilik->kat_user)->get();
        $jenis_sampah_kolektor = DB::table('waste_cat')
        ->where('aktif', '1')
        ->where('kat_user', 2)->get();
        // dd($jenis);
        $epr = DB::table('uns_sampah-merek')
            ->join('uns_sampah', 'uns_sampah.id', 'uns_sampah-merek.sampah_id')
            ->where('uns_sampah.aktif', 'Y')
            ->join('uns_merek', 'uns_merek.id', 'uns_sampah-merek.merek_id')
            ->where('uns_merek.aktif', 'Y')
            ->join('uns_perusahaan_induk', 'uns_perusahaan_induk.id', 'uns_merek.induk_id')
            ->where('uns_perusahaan_induk.aktif', 'Y')
            ->select('uns_sampah-merek.id as id', 'uns_sampah.nama as jenis', 'uns_merek.merek as merek', 'uns_perusahaan_induk.nama as induk')
            ->get();
        // dd($ambilin, $barang);
        return view('ambilin_verifikasi', compact('epr', 'ambilin', 'barang', 'jenis_sampah', 'jenis_sampah_kolektor', 'page', 'back', 'id_ambilin', 'id_booking','backslug'));
    }

    public function ambilin_verifikasi_post(Request $request, $id_ambilin, $id_booking) //kolektor
    {
        $request->validate([
            'barang.*.id_berat' => 'nullable',
            'barang.*.id_sampah' => 'nullable|numeric',
            'barang.*.berat_riil' => 'nullable|numeric',
            'barang.*.harga_riil' => 'nullable|numeric',
            'tambah.*.id_sampah' => 'nullable',
            'tambah.*.berat' => 'nullable|numeric',
            'tambah.*.harga_riil' => 'nullable|numeric',
            'epr.*.sampah-merk_id' => 'nullable',
            'epr.*.jumlah' => 'nullable|numeric',
        ]);

        Carbon::setLocale('id');
        $now = Carbon::now();

        // $data_berat = array();
        // if ($request->barang != null) {
            foreach ($request->barang as $key => $barang) {
                $berat              = Berat::find($barang['id_berat']);
                $berat->id_sampah   = $barang['id_sampah'];
                $berat->berat_riil  = $barang['berat_riil'];
                $berat->harga_riil  = $barang['harga_riil'];
                $berat->save();
                // $data_berat[] = $berat;
            }
        // }

        // dd($data_berat);

        // $data_tambah = array();
        if ($request->tambah != null) {
            foreach ($request->tambah as $key => $tambah) {
                Berat::Create([
                    'id_ambilin'    => $id_ambilin,
                    'id_sampah'     => $tambah['id_sampah'],
                    'berat'         => $tambah['berat'],
                    'berat_riil'    => $tambah['berat'],
                    'harga_riil'    => $tambah['harga_riil'],
                ]);
                // $data_tambah[] = $tambah;
            }
        }

        // dd($data_tambah);

        // $data_epr = array();
        // $i = -1;
        if ($request->epr != null) {
            foreach ($request->epr as $anu => $epr) {
                // $i++;
                EPR_History::Create([
                    'booking_id'        => $id_booking,
                    'sampah-merek_id'   => $epr['sampah-merk_id'],
                    'jumlah'            => $epr['jumlah'],
                    'waktu_catat'       => Carbon::now(),
                ]);
                // $data_epr[] = $epr['sampah-merk_id'];
            }
        }

        // dd($data_epr);
        
        // change status ambilin
        $ambilin            = Ambilin::find($id_ambilin);
        $ambilin->status    = 3;
        $ambilin->waktuubah = $now;
        $ambilin->save();
        //change status ambilin

        //notif
        Notifikasi::create([
            'id_user' => $ambilin->wp_id,
            'id_notif' => 10,
            'waktu_catat' => $now,
        ]);
        //notif end

        $device_token = User::where('id', $ambilin->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title      = "Ambilin";
            $message    = "Sampah anda sudah diambil oleh kolektor, terimakasih sudah menggunakan jasa ambilin";
            $url_notif  = route('ambilin');
            $this->notificationController->send_notification_FCM($device_token, $title, $message, $url_notif);
        }

        if(session('ambilin_url')) {
            return redirect(session('ambilin_url'));
        }

        return redirect()->back();
    }

    /* --- */

    public function ambilin_hapus(Request $request, $id)
    {
        // DB::table('ambilin')->delete($id);
        $request->validate([
            'alasan'   => 'required',
        ]);

        $ambilin            = Ambilin::find($id);
        $ambilin->status    = 9;
        $ambilin->save();

        Alasan_ambilin::Create([
            'id_ambilin'    =>  $id,
            'alasan'        =>  $request->alasan,
            'waktu_catat'   =>  Carbon::now(),
        ]);
        return redirect()->route('ambilin');
    }

    public function ambilin_post_gambar(Request $request)
    {
        $request->validate([
            'id_ambilin'    => 'required',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        //Delete Image from Server
        $ambilin = Ambilin::where('id',$request->id_ambilin)->first();
        unlink(public_path('img/ambilin/sampah/' . $ambilin->foto));

        //Rename & Save image
        $fileName = time() . '_' . request()->foto->getClientOriginalName();
        $destination = 'public/img/ambilin/sampah';
        $request->file('foto')->move($destination, $fileName);

        //Save to Database
        Ambilin::where('id', $request->id_ambilin)
            ->update([
                'foto'  => $fileName
            ]);

        return redirect()->back()->with('success', 'Gambar berhasil diubah');
    }

    public function ambilin_post_waktu(Request $request)
    {
        $request->validate([
            'id_ambilin'    => 'required',
            'tgl_ambil'     => 'required',
            'waktu_ambil'   => 'required',
        ]);

        Ambilin::where('id', $request->id_ambilin)
            ->update([
                'tgl_ambil'     => $request->tgl_ambil,
                'waktu_ambil'   => $request->waktu_ambil
            ]);
        
        return redirect()->back()->with('success', 'Waktu berhasil diubah');
    }

    public function ambilin_post_lokasi(Request $request)
    {
        $request->validate([
            'id_ambilin'    => 'required',
            'idlokasi'      => 'required',
        ]);

        Ambilin::where('id', $request->id_ambilin)
            ->update([
                'idlokasi'  => $request->idlokasi
            ]);
        
        return redirect()->back()->with('success', 'Lokasi berhasil diubah');
    }

    public function ambilin_post_deskripsi(Request $request)
    {
        $request->validate([
            'id_ambilin'    => 'required',
            'keterangan'    => 'nullable',
        ]);

        Ambilin::where('id', $request->id_ambilin)
            ->update([
                'keterangan'    => $request->keterangan
            ]);
        
        return redirect()->back()->with('success', 'Deskripsi berhasil diubah');
    }

    public function ambilin_post_barang(Request $request)
    {
        $request->validate([
            'id_ambilin'    => 'required',
            'id_berat'      => 'nullable',
            'jenis_sampah'  => 'required',
            'berat'         => 'required',
        ]);

        // dd($request->id_berat, $request->id_ambilin, $request->jenis_sampah, $request->berat);

        DB::table('uns_berat')->updateOrInsert(
            ['id' => $request->id_berat, 'id_ambilin' => $request->id_ambilin],
            ['id_sampah' => $request->jenis_sampah, 'berat' => $request->berat]
        );
        return redirect()->back()->with('success', 'Sampah berhasil perbarui');
    }

    public function ambilin_hapus_barang($id_barang)
    {
        DB::table('uns_berat')->delete($id_barang);
        return redirect()->back();
    }

    public function ambilin_riwayat()
    {
        $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
        ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
        ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        ->count();
        if(auth()->user()->kat_user != 2){
            $count_riwayat = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.status', 3) 
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->orwhere('waste_date.tgl', '<', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.status', 1)
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->count();
            $count_proses_raw = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 2)
            ->orwhere('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 1)
            ->count();
            $count_batal = db::table('ambilin')->select('ambilin.id')
            ->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
            $count_proses = $count_proses_raw;
        }
        elseif(auth()->user()->kat_user == 2){
            $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 3)->count();
            $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
            $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
        }
        
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        $tgl_ambilin = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id)
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->select('waste_date.tgl')
            ->first();
        if (empty($tgl_ambilin)) {
            $tgl_trans = '';
        } else {
            $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        }
        $berat_raw = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('ambilin', 'ambilin.wp_id', '=', 'uns_user.id')
            ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
            ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->select('uns_berat.berat', 'ambilin.waktucatat', 'waste_cat.nama AS jenis', 'waste_cat.harga_down', 'waste_cat.harga_top');
        $berat = $berat_raw->sum('berat');
        $sum_down = $berat_raw->sum('harga_down');
        $sum_top = $berat_raw->sum('harga_top');
        $jenis_raw = $berat_raw->get();
        $jenis = $berat_raw->first();
        if (auth()->user()->kat_user != 2) {
            $data_raw = DB::table('ambilin')
                /* kelengkapan ambilin ambilin */
                ->join('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->where('ambilin.status', 3)->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
                ->orwhere('waste_date.tgl', '<', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.status', 1)->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp_lokasi - user */
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.status as status_id',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.idlokasi',
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
        } else if (auth()->user()->kat_user == 2) {
            $data_raw = DB::table('uns_ambilin_booking')

                /* kelengkapan ambilin */
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->where('ambilin.status', 3)->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                // ->orWhere('ambilin.status', 5)->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp_lokasi - user */
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.status as status_id',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.idlokasi',
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
        //->union($tgl_ambilin)->union($tgl_trans)->union($berat)->get();
        //->union($tgl_ambilin,$tgl_trans,$berat)
        $data = $data_raw->orderby('waste_date.tgl', 'DESC')->orderby('waste_time.waktu')->orderby('ambilin.status', 'DESC')->paginate(5);
        // dd($data);
        return view('ambilin_riwayat', compact(
            'back', 'berat', 'data', 'jenis', 'jenis_raw', 
            'page', 'sum_top', 'sum_down', 'tgl_trans', 
            'today', 'user', 'count_tersedia','count_proses',
            'count_riwayat', 'count_proses','count_batal'
        ));
    }

    public function ambilin_kolektor_riwayat($x, $y)
    {
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }
        
        $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
            ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
            ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            ->select('wp_lokasi.lokasi_x', 'wp_lokasi.lokasi_y')
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil)
            ->count();
        $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status', 3)->count();
        $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
        $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status',4)->count();
        // $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        // ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        // ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        // ->where(function ($q) {
        //     $q->where('ambilin.status',4)
        //         ->orWhere('ambilin.verifikasi','ditolak');
        // })->count();
        
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        $tgl_ambilin = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id)
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->select('waste_date.tgl')
            ->first();
        if (empty($tgl_ambilin)) {
            $tgl_trans = '';
        } else {
            $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        }
        
        $data_raw = DB::table('uns_ambilin_booking')
            /* kelengkapan ambilin */
            ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
            ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
            ->where('ambilin.status', 3)->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
            ->where('ambilin.hapus', '!=', '1')
            // ->orWhere('ambilin.status', 5)->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            /* wp_lokasi - user */
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                'ambilin.foto',
                'ambilin.keterangan',
                'ambilin.status as status_id',
                'ambilin.id AS id_ambilin',
                'ambilin.wp_id AS id_wp',
                'ambilin.idlokasi',
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
        //->union($tgl_ambilin)->union($tgl_trans)->union($berat)->get();
        //->union($tgl_ambilin,$tgl_trans,$berat)
        $data = $data_raw->orderby('waste_date.tgl', 'DESC')->orderby('waste_time.waktu')->orderby('ambilin.status', 'DESC')->paginate(5);
        // dd($data);

        Session::put('ambilin_url', request()->fullUrl());

        return view('ambilin_riwayat', compact(
            'x', 'y', 'back', 'data', 'page', 'tgl_trans', 
            'today', 'user', 'count_tersedia','count_proses',
            'count_riwayat', 'count_proses','count_batal'
        ));
    }

    public function ambilin_batal()
    {
        $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
        ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
        ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
        ->count();
        if(auth()->user()->kat_user != 2){
            $count_riwayat = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.status', 3) 
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->orwhere('waste_date.tgl', '<', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.status', 1)
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
            ->count();
            $count_proses_raw = db::table('ambilin')->select('ambilin.id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 2)
            ->orwhere('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where('ambilin.status', 1)
            ->count();
            $count_batal = db::table('ambilin')->select('ambilin.id')
            ->where('ambilin.wp_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
            $count_proses = $count_proses_raw;
        }
        elseif(auth()->user()->kat_user == 2){
            $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 3)->count();
            $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
            $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
            ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
            ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
            ->where(function ($q) {
                $q->where('ambilin.status',4)
                    ->orWhere('ambilin.verifikasi','ditolak');
            })->count();
        }
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        $tgl_ambilin = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id)
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->select('waste_date.tgl')
            ->first();
        if (empty($tgl_ambilin)) {
            $tgl_trans = '';
        } else {
            $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        }
        $berat_raw = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('ambilin', 'ambilin.wp_id', '=', 'uns_user.id')
            ->join('uns_berat', 'uns_berat.id_ambilin', '=', 'ambilin.id')
            ->join('waste_cat', 'waste_cat.id', '=', 'uns_berat.id_sampah')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->select('uns_berat.berat', 'uns_berat.id_ambilin', 'ambilin.waktucatat', 'waste_cat.nama AS jenis', 'waste_cat.harga_down', 'waste_cat.harga_top');
        $berat = $berat_raw->sum('berat');
        $sum_down = $berat_raw->sum('harga_down');
        $sum_top = $berat_raw->sum('harga_top');
        $jenis_raw = $berat_raw->get();
        $jenis = $berat_raw->first();
        if ($user->kat_user == 2) {
            $data_raw = DB::table('uns_ambilin_booking')
                /* booking - ambilin */
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
                ->where('ambilin.status', 4)
                ->where('ambilin.hapus', '!=', '1')
                /* user - ambilin */
                ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'ambilin.idlokasi',
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
        } elseif ($user->kat_user != 2) {
            $data_raw = DB::table('ambilin')
                /* uns_berat - ambilin */
                ->where('ambilin.wp_id', auth()->user()->id)
                ->where('ambilin.hapus', '!=', '1')
                ->where(function ($q) {
                    $q->where('ambilin.status', 4)
                        ->orWhere('ambilin.verifikasi','ditolak');
                })
                /* user - ambilin */
                ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
                ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
                ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
                ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
                /* wp - user */
                //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'ambilin.foto',
                    'ambilin.keterangan',
                    'ambilin.verifikasi',
                    'ambilin.id AS id_ambilin',
                    'ambilin.wp_id AS id_wp',
                    'ambilin.status AS status_id',
                    'ambilin.idlokasi',
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
        $data = $data_raw->orderby('waste_date.tgl')->orderby('waste_time.waktu')->paginate(5);
        return view('ambilin_batal', compact(
            'user', 'back', 'page', 'data', 'tgl_trans', 
            'berat', 'berat_raw', 'jenis', 'jenis_raw', 
            'sum_top', 'sum_down','count_proses','count_tersedia',
            'count_batal','count_riwayat'    
        ));
    }

    public function ambilin_kolektor_dibatalkan($x, $y)
    {
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }
        
        $count_tersedia = db::table('ambilin')->where('ambilin.status',1)->where('verifikasi', 'diterima')
            ->where('ambilin.wp_id', '!=', null)->where('waste_date.tgl', '>=', Carbon::today()->format("Y-m-d H:i:s"))
            ->select('id')->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            ->select('wp_lokasi.lokasi_x', 'wp_lokasi.lokasi_y')
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil)
            ->count();
        $count_riwayat = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status', 3)->count();
        $count_proses = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')->where('ambilin.status', 2)->count();
        $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        ->where('ambilin.status',4)->count();
        // $count_batal = db::table('uns_ambilin_booking')->select('uns_ambilin_booking.id')
        // ->where('kolektor_id', auth()->user()->id)->where('ambilin.hapus', '!=', '1')
        // ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id')
        // ->where(function ($q) {
        //     $q->where('ambilin.status',4)
        //         ->orWhere('ambilin.verifikasi','ditolak');
        // })->count();
        
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $user = $id->first();
        $page = 'Layanan Ambilin Sampah';
        $back = 'dashboard';
        $tgl_ambilin = DB::table('ambilin')
            ->where('ambilin.wp_id', auth()->user()->id)
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->select('waste_date.tgl')
            ->first();
        if (empty($tgl_ambilin)) {
            $tgl_trans = '';
        } else {
            $tgl_trans = Carbon::parse($tgl_ambilin->tgl)->translatedFormat('l, d F Y');
        }

        $data_raw = DB::table('uns_ambilin_booking')
            /* booking - ambilin */
            ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
            ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 4)
            ->where('ambilin.hapus', '!=', '1')
            /* user - ambilin */
            ->leftjoin('uns_user', 'uns_user.id', '=', 'ambilin.wp_id')
            ->join('waste_date', 'waste_date.id', '=', 'ambilin.tgl_ambil')
            ->join('waste_time', 'waste_time.id', '=', 'ambilin.waktu_ambil')
            ->join('uns_status', 'uns_status.id', '=', 'ambilin.status')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            /* wp - user */
            //->join('uns_user', 'uns_user.id', '=', 'wp_lokasi.id')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                'ambilin.foto',
                'ambilin.keterangan',
                'ambilin.id AS id_ambilin',
                'ambilin.wp_id AS id_wp',
                'ambilin.status AS status_id',
                'ambilin.idlokasi',
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
        
        $data = $data_raw->orderby('waste_date.tgl')->orderby('waste_time.waktu')->paginate(5);

        Session::put('ambilin_url', request()->fullUrl());

        return view('ambilin_batal', compact('x', 'y', 'user', 'back', 'page', 'data', 'tgl_trans', 'count_proses','count_tersedia', 'count_batal', 'count_riwayat'));
    }

    public function detail_mitra($fitur, $id){
        $data = db::table('uns_user')
            ->where('uns_user.id', $id)
            ->first();

        $count_amb = count(
            Ambilin::where('ambilin.wp_id', $id)
            ->where('ambilin.status', 3)
            ->get()
        );
        $pangkat = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->pluck('pangkat')->first();

        $rating_raw = DB::table('uns_ratings_mitra')
            ->join('ambilin', 'ambilin.id', 'uns_ratings_mitra.ambilin_id')
            ->where('rating', '>', 3)->where('ambilin.wp_id',$id) //jika rating >3
            ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('ambilin.wp_id',$id)
            ->select(
                'uns_ratings_mitra.*',
                'ambilin.wp_id',
            );
        $rating_avg = $rating_raw->avg('rating');
        $count_rating = count($rating_raw->get());

        $page = 'Detail Mitra';
        return view('detail_mitra',compact('data', 'page', 'pangkat', 'rating_avg', 'count_rating', 'fitur'));
    }

    public function lihat_rating_mitra($id_ambilin) {
        $page = 'Lihat Penilaian untuk Mitra';
        $status = 'lihat';
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");

        $ambilin = Ambilin::where('id', $id_ambilin)->first();

        $data = User::where('uns_user.id', $ambilin->wp_id)->first();

        $rating_ku = DB::table('uns_ratings_mitra')->where('ambilin_id', $id_ambilin)->first();
        // dd($rating_ku->rating);

        return view('rating_mitra', compact('page', 'status', 'today', 'data', 'rating_ku', 'ambilin'));
    }

    public function beri_rating_mitra($id_ambilin) {
        $page = 'Beri Penilaian untuk Mitra';
        $status = 'beri';

        $ambilin = Ambilin::where('id', $id_ambilin)->first();

        $data = User::where('uns_user.id', $ambilin->wp_id)->first();

        $rating_ku = DB::table('uns_ratings_mitra')->where('ambilin_id', $id_ambilin)->first();

        return view('rating_mitra', compact('page', 'status', 'data', 'rating_ku', 'ambilin'));
    }

    public function ratingku_mitra_post(Request $request, $id_ambilin) {
        $request->validate([
            'rating' => 'required',
            'reason' => 'nullable'
        ]);

        $validation = null;
        if($request->rating < 4){
            $validation = 'validasi';
        } elseif($request->rating < 4){
            $validation = null;
        }

        DB::table('uns_ratings_mitra')->updateOrInsert(
            ['ambilin_id' => $id_ambilin],
            [
                'rating' => $request->rating,
                'keterangan' => $request->reason,
                'valid' => $validation
            ]
        );

        return redirect()->route('ambilin_edit',['id' => $id_ambilin])->with('success', 'Data tersimpan! Terima kasih atas masukannya');
    }

    public function detail_kolektor($id){
        $data = db::table('uns_user')
            ->where('uns_user.id',$id)
            ->join('uns_ambilin_booking','uns_ambilin_booking.kolektor_id','uns_user.id')->first();
            // $rating_raw = db::table('uns_rating')
            // ->where('rating', '>', 3)->where('kolektor_id',$id) //jika rating >3
            // ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('kolektor_id',$id);
        $rating_raw = db::table('uns_ratings')
            ->join('uns_ambilin_booking', 'uns_ambilin_booking.id', 'uns_ratings.booking_id')
            ->where('rating', '>', 3)->where('uns_ambilin_booking.kolektor_id',$id) //jika rating >3
            ->orwhere('rating', '<', 4)->where('valid', '=', 'ya')->where('uns_ambilin_booking.kolektor_id',$id)
            ->select(
                'uns_ratings.*',
                'uns_ambilin_booking.id as booking_id',
                'uns_ambilin_booking.ambilin_id',
                'uns_ambilin_booking.kolektor_id',
            );
        $rating_avg = $rating_raw->avg('rating');
        $count_rating = count($rating_raw->get());
        // $ratingku = $rating_raw -> where('mitra_id', auth()->user()->id)->first();

        $pengambilan = Booking::where('uns_ambilin_booking.kolektor_id', $id)
            ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
            ->where('ambilin.status', 3)
            ->select('ambilin.id AS id')
            ->get()->toArray();
        $count_pengambilan = count($pengambilan);

        $angkut = Berat::whereIn('id_ambilin', Arr::flatten($pengambilan))
            ->sum('berat_riil');

        // dd($pengambilan, count($pengambilan), $angkut);

        $page = 'Detail Kolektor';

        return view('detail_kolektor',compact('data', 'page', 'rating_avg', 'count_rating', 'count_pengambilan', 'angkut'));
    }

    public function lihat_rating_kolektor($id_booking) {
        $page = 'Lihat Penilaian untuk Kolektor';
        $status = 'lihat';
        $today = Carbon::today()->addSeconds(-1)->format("Y-m-d H:i:s");

        $booking = Booking::where('id', $id_booking)->first();

        $data = User::where('uns_user.id', $booking->kolektor_id)
        ->join('uns_ambilin_booking','uns_ambilin_booking.kolektor_id','uns_user.id')->first();

        $rating_ku = DB::table('uns_ratings')->where('booking_id', $id_booking)->first();
        // dd($rating_ku->rating);

        $ambilin = Ambilin::where('id', $booking->ambilin_id)->first();

        return view('rating_kolektor', compact('page', 'status', 'today', 'data', 'rating_ku', 'booking', 'ambilin'));
    }

    public function beri_rating_kolektor($id_booking) {
        $page = 'Beri Penilaian untuk Kolektor';
        $status = 'beri';

        $booking = Booking::where('id', $id_booking)->first();

        $data = User::where('uns_user.id', $booking->kolektor_id)
        ->join('uns_ambilin_booking','uns_ambilin_booking.kolektor_id','uns_user.id')->first();

        $rating_ku = DB::table('uns_ratings')->where('booking_id', $id_booking)->first();

        return view('rating_kolektor', compact('page', 'status', 'data', 'rating_ku', 'booking'));
    }

    public function ratingku_post(Request $request, $id_booking, $id_ambilin) {
        $request->validate([
            'rating' => 'required',
            'reason' => 'nullable'
        ]);

        $validation = null;
        if($request->rating < 4){
            $validation = 'validasi';
        } elseif($request->rating < 4){
            $validation = null;
        }

        DB::table('uns_ratings')->updateOrInsert(
            ['booking_id' => $id_booking],
            [
                'rating' => $request->rating,
                'keterangan' => $request->reason,
                'valid' => $validation
            ]
        );

        return redirect()->route('ambilin_edit',['id' => $id_ambilin])->with('success', 'Data tersimpan! Terima kasih atas masukannya');
    }

    public function rating_post(Request $request,$id_k,$id_a){
        $request->validate([
            'rating' => 'required',
            'reason' => 'nullable'
        ]);

        $validation = null;

        if($request->rating < 4){
            $validation = 'validasi';
        } elseif($request->rating < 4){
            $validation = null;
        }

        Rating::updateOrCreate(
            ['kolektor_id' => $id_k,
             'mitra_id' => auth()->user()->id],
            ['rating' => $request->rating,
             'keterangan' => $request->reason,
             'valid' => $validation]
        );

        // $ada = db::table('uns_rating')->where('kolektor_id', $id_k)->where('mitra_id', auth()->user()->id)->first();
        // if($ada == null){
        //     Rating::Create([
        //         'kolektor_id'    => $id_k,
        //         'mitra_id'     => auth()->user()->id,
        //         'rating'         => $request->rating,
        //         'waktu_catat'   => Carbon::now()
        //     ]);
        // }
        //  else {
        //     $rate                         = Rating::where('mitra_id',auth()->user()->id)->where('kolektor_id',$id_k)->firstOrFail();
        //     $rate->kolektor_id            = $id_k;
        //     $rate->rating                 = $request->rating;
        //     $rate->save();
        // }
        return redirect()->route('ambilin_edit',['id' => $id_a])->with('success', 'Data tersimpan! Terima kasih atas masukannya');
    }
    public function direction(Request $request, $id){
        $request->validate([
            'lokasi_x' => 'required',
            'lokasi_y' => 'required'
        ]);
        $data = DB::table('ambilin')
        ->where('ambilin.id',$id)->join('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
        ->select('wp_lokasi.lokasi_x','wp_lokasi.lokasi_y')->first();
        // $xAwal = '-7.7836683';
        // $yAwal = '110.3532337';
        $xAwal = $request->lokasi_x;
        $yAwal = $request->lokasi_y;
        $xTarget = $data->lokasi_x;
        $yTarget = $data->lokasi_y;
        $link = "https://www.google.com/maps/dir/".$xAwal.",".$yAwal."/".$xTarget.",".$yTarget."/";
        // return view('iframe', compact('link', 'target'));
        return Redirect::to($link);
    }

    public function map($id) {
        // $request->validate([
        //     'id_ambilin' => 'required'
        // ]);
        $page = 'Lokasi Pengambilan';
        $data = DB::table('ambilin')
            ->where('ambilin.id', $id)
            ->join('uns_user', 'uns_user.id', 'ambilin.wp_id')
            ->join('wp_lokasi', 'wp_lokasi.id', '=', 'ambilin.idlokasi')
            ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select(
                'ambilin.wp_id',
                'uns_user.nama',
                'uns_user.foto_diri',
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'wp_lokasi.alamat_lokasi',
                'wp_lokasi.kode_pos',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel',
            )
            ->first();
        $count_amb = count(
            DB::table('ambilin')
                ->where('ambilin.wp_id', $data->wp_id)
                ->where('ambilin.status', 3)
                ->get()
        );
        $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();
        return view('map', compact('page', 'data', 'level'));
    }
}
