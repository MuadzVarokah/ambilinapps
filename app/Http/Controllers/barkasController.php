<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Paskas;
use App\Models\Sebar;
use App\Models\Alasan_paskas;
use App\Models\Alasan_sebar;
use App\Models\Paskas_sedekah;
use App\Models\Paskas_foto;
use App\Models\Sebar_foto;
use App\Models\Paskas_laku;
use App\Models\Sebar_laku;
use App\Http\Controllers\notificationController;
use File;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class barkasController extends BaseController
{
    protected $notificationController;
    public function __construct(notificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function index()
    {
    }

    public function paskas($x, $y)
    {
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }

        $filter = Paskas::filter(request(['search','jenis','kondisi']));
        $jenis = db::table('barkas_jenis')->get();
        $kondisi = db::table('uns_barkas_kondisi')->get();
        $page = 'PASKAS | Pasar Barang Bekas';
        $current = route('paskas', ['x' => $x, 'y' => $y]);
        $back = 'dashboard';
        $barang = $filter
            ->where('status_publikasi', 2)
            ->where('paskas.hapus', '!=', '1')
            ->where('paskas.aktif', 1)
            ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'paskas.kondisi')
            ->join('barkas_jenis', 'barkas_jenis.id', 'paskas.fungsi')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', 'paskas.idlokasi')
            ->select(
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.jenis AS fungsi',
                'paskas.kondisi AS id_kondisi',
                'paskas.deskripsi',
                'paskas.judul',
                'paskas.harga',
                'paskas.foto',
                'paskas.id'
            )
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil)
            ->get();
        // ->paginate(5);
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id');
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->where('ambilin.status', 3)
                ->get();
            $count_amb = count($count_amb_raw);
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $count_amb = count($count_amb_raw);
        }
        $fil_jenis= DB::table('barkas_jenis')->where("id",'=',(request("jenis")))->first();
        $fil_kondisi= DB::table('uns_barkas_kondisi')->where("id",'=',(request("kondisi")))->first();
        $fil_kata = (request("search"));

        Session::put('paskas_url', request()->fullUrl());

        return view('paskas', compact('back', 'page', 'barang','jenis','kondisi','fil_jenis','fil_kata','fil_kondisi','current','count_amb'));
    }

    public function paskas_kosong()
    {
        $filter = Paskas::filter(request(['search','jenis','kondisi']));
        $jenis = db::table('barkas_jenis')->get();
        $kondisi = db::table('uns_barkas_kondisi')->get();
        $page = 'PASKAS | Pasar Barang Bekas';
        $current = route('paskas_kosong');
        $back = 'dashboard';
        $barang = 'kosong';
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id');
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->where('ambilin.status', 3)
                ->get();
            $count_amb = count($count_amb_raw);
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $count_amb = count($count_amb_raw);
        }
        $fil_jenis= DB::table('barkas_jenis')->where("id",'=',(request("jenis")))->first();
        $fil_kondisi= DB::table('uns_barkas_kondisi')->where("id",'=',(request("kondisi")))->first();
        $fil_kata = (request("search"));

        Session::put('paskas_url', request()->fullUrl());

        return view('paskas', compact('back', 'page', 'barang','jenis','kondisi','fil_jenis','fil_kata','fil_kondisi','current','count_amb'));
    }

    public function paskas_baru()
    {
        $back = 'paskas_jualan';
        $page = 'Jual Barang Bekas di PARKAS';
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $lokasi = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)->where('aktif', 'Y')->get();
        $fungsi = DB::table('barkas_jenis')->get();
        $kondisi = DB::table('uns_barkas_kondisi')->get();
        return view('paskas_baru', compact('back', 'page', 'id', 'lokasi', 'fungsi', 'kondisi'));
    }

    public function paskas_post(Request $request)
    {
        // dd($request->file('foto.1'));
        $request->validate([
            'foto.*' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'judul' => 'required|max:50',
            'deskripsi' => 'nullable|max:255',
            'kondisi' => 'required',
            'fungsi' => 'required',
            'harga' => 'required',
            'lokasi_pengambilan' => 'required',
        ]);

        $firstPic = $request->file('foto.0');
        $firstFileName = time() . '_' . $firstPic->getClientOriginalName();
        $firstDestination = 'public/img/paskas';
        $firstPic->move($firstDestination, $firstFileName);

        $id = Paskas::Create([
            'wp_id'         => auth()->user()->id,
            'foto'          => $firstFileName,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'kondisi'       => $request->kondisi,
            'fungsi'        => $request->fungsi,
            'harga'         => $request->harga,
            'idlokasi'      => $request->lokasi_pengambilan,
            'aktif'         => 1,
            'status_publikasi'  => 1,
            'waktucatat'    =>  Carbon::now(),
        ])->id;

        foreach($request->file('foto') as $key => $foto) {
            if($key > 0) {
                // dd($key, $foto);
                $otherPic = $request->file('foto.'.$key);
                $otherFileName = time() . '_' . $otherPic->getClientOriginalName();
                $otherDestination = 'public/img/paskas';
                $otherPic->move($otherDestination, $otherFileName);

                Paskas_foto::create([
                    'paskas_id' => $id,
                    'foto'      => $otherFileName
                ]);
            }
        }

        return redirect()->route('paskas_jualan');
    }

    public function paskas_jualan()
    {
        $user = DB::table('uns_user')->where("id", auth()->user()->id)->first();
        $paskas = new Paskas();
        $semua = $paskas->getPaskasFromStatus(TRUE)->get();
        $proses_cek = $paskas->getPaskasFromStatus(1)->get();
        $lolos_cek = $paskas->getPaskasFromStatus(2)->get();
        $tidak_lolos_cek = $paskas->getPaskasFromStatus(3)->get();
        $barang_laku = $paskas->getPaskasFromStatus(4)
            ->join('uns_paskas_laku', 'uns_paskas_laku.paskas_id', 'paskas.id')
            ->addSelect('uns_paskas_laku.harga as harga_kesepakatan')
            ->get();
        // dd($semua, $proses_cek, $lolos_cek, $tidak_lolos_cek, $barang_laku);
        return view('paskas_jualan', compact('semua', 'proses_cek', 'lolos_cek', 'tidak_lolos_cek', 'barang_laku', 'user'));
    }

    /* detail barang paskas & sebar */
    public function detail($fitur, $id)
    {
        // dd(auth()->user());
        $today = Carbon::today()->format("Y-m-d H:i:s");
        $user = DB::table('uns_user')->where("id", auth()->user()->id)->first();
        $data_raw = DB::table($fitur);
        $data_all = $data_raw->get();
        if ($fitur == 'paskas') {
            $data = $data_raw->where('paskas.id', $id)
                ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'paskas.kondisi')
                ->join('barkas_jenis', 'barkas_jenis.id', 'paskas.fungsi')
                ->leftjoin('uns_user', 'uns_user.id', 'paskas.wp_id')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'paskas.idlokasi')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                'paskas.status_publikasi',
                'paskas.judul',
                'paskas.harga',
                'paskas.wp_id',
                'paskas.aktif',
                'paskas.foto',
                'paskas.kondisi AS id_kondisi',
                'paskas.deskripsi',
                'paskas.status_publikasi',
                'paskas.waktucatat',
                'uns_user.foto_diri',
                'uns_user.nama',
                'uns_barkas_kondisi.id as id_kondisi',
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.id as id_jenis',
                'barkas_jenis.jenis',
                'wp_lokasi.alamat_lokasi',
                'wp_lokasi.id as id_lokasi',
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'indonesia_provinces.name AS prov',
                'indonesia_cities.name AS kab',
                'indonesia_districts.name AS kec',
                'indonesia_villages.name As kel')
                ->first();
            $foto = Paskas_foto::where('paskas_id', $id)->get();

            if($data->status_publikasi == 4) {
                $info_tambahan = DB::table('uns_paskas_laku')
                    ->where('paskas_id', $id)
                    ->first();
            } else if ($data->status_publikasi == 3) {
                $info_tambahan = DB::table('uns_paskas_ditolak')
                    ->where('paskas_id', $id)
                    ->where('status', 1)
                    ->first();
            };
        } else {
            $data = $data_raw->where('sebar.id', $id)
                ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'sebar.kondisi')
                ->join('barkas_jenis', 'barkas_jenis.id', 'sebar.fungsi')
                ->leftjoin('uns_user', 'uns_user.id', 'sebar.wp_id')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'sebar.idlokasi')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'sebar.judul',
                    'sebar.wp_id',
                    'sebar.aktif',
                    'sebar.foto',
                    'sebar.kondisi AS id_kondisi',
                    'sebar.deskripsi',
                    'sebar.status_publikasi',
                    'sebar.waktucatat',
                    'uns_user.foto_diri',
                    'uns_user.nama',
                    'uns_barkas_kondisi.id as id_kondisi',
                    'uns_barkas_kondisi.kondisi',
                    'barkas_jenis.id as id_jenis',
                    'barkas_jenis.jenis',
                    'wp_lokasi.alamat_lokasi',
                    'wp_lokasi.id as id_lokasi',
                    'wp_lokasi.lokasi_x',
                    'wp_lokasi.lokasi_y',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel')
                ->first();
                $foto = Sebar_foto::where('sebar_id', $id)->get();

                if($data->status_publikasi == 4) {
                    $info_tambahan = DB::table('uns_sebar_laku')
                        ->where('sebar_id', $id)
                        ->first();
                } else if ($data->status_publikasi == 3) {
                    $info_tambahan = DB::table('uns_sebar_ditolak')
                        ->where('sebar_id', $id)
                        ->where('status', 1)
                        ->first();
                };
        }

        $count_amb = count(
            DB::table('ambilin')
                ->where('ambilin.wp_id', $data->wp_id)
                ->where('ambilin.status', 3)
                ->get()
        );
        $pangkat = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('id', 'DESC')->first();
        $attribute = $pangkat->pangkat;

        $jenis = DB::table('barkas_jenis')->get();
        $kondisi = DB::table('uns_barkas_kondisi')->get();
        $lokasi = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)->where('aktif', 'Y')->get();
        
        // dd($data_raw,$id,$data_all,$data);
        // dd($fitur);
        if(($data->status_publikasi == 4) || ($data->status_publikasi == 3)) {
            return view('detail', compact('user', 'data', 'fitur', 'id','today', 'attribute', 'foto', 'jenis', 'kondisi', 'lokasi', 'info_tambahan'));
        } else {
            return view('detail', compact('user', 'data', 'fitur', 'id','today', 'attribute', 'foto', 'jenis', 'kondisi', 'lokasi'));
        }
    }
    /* -  -  - */

    /* hapus barang paskas & sebar */
    public function hapus_fitur(Request $request, $fitur, $id) {
        // DB::table($fitur)->delete($id);
        $request->validate([
            'alasan'   => 'required',
        ]);

        if ($fitur == 'paskas') {
            $paskas          = Paskas::find($id);
            $paskas->hapus   = '1';
            $paskas->save();

            Alasan_paskas::Create([
                'paskas_id'     =>  $id,
                'alasan'        =>  $request->alasan,
                'waktu_catat'   =>  Carbon::now(),
            ]);

            return redirect()->route('paskas_jualan');
        } else {
            $sebar          = Sebar::find($id);
            $sebar->hapus   = '1';
            $sebar->save();

            Alasan_sebar::Create([
                'sebar_id'      =>  $id,
                'alasan'        =>  $request->alasan,
                'waktu_catat'   =>  Carbon::now(),
            ]);

            return redirect()->route('sebarku');
        }
    }
    /* - - - */

    /* paskas & sebar laku */
    public function laku(Request $request, $fitur, $id) {
        Carbon::setLocale('id');
        $now = Carbon::now();

        if ($fitur == 'paskas') {
            $paskas                     = Paskas::find($id);
            $paskas->status_publikasi   = '4';
            $paskas->save();

            Paskas_laku::create([
                'paskas_id'     => $id,
                'harga'         => $request->harga,
                'keterangan'    => $request->keterangan,
                'waktu_catat'   => $now,
            ]);

            $back = 'paskas_jualan';
        } else if ($fitur == 'sebar') {
            $sebar                      = Sebar::find($id);
            $sebar->status_publikasi    = '4';
            $sebar->save();

            Sebar_laku::create([
                'paskas_id'     => $id,
                'keterangan'    => $request->keterangan,
                'waktu_catat'   => $now,
            ]);

            $back = 'sebarku';
        }
        return redirect()->route($back);
        // return redirect()->route('detail', ['fitur' => $fitur, 'id' => $id]);
    }
    /* - - - */

    /* ajukan ulang paskas & sebar */
    public function ajukan_ulang_barkas($fitur, $id) {
        if ($fitur == 'paskas') {
            $paskas                     = Paskas::find($id);
            $paskas->status_publikasi   = '1';
            $paskas->save();

            DB::table('uns_paskas_ditolak')
                ->where('paskas_id', $id)
                ->where('status', 1)
                ->update(['status' => 0]);

            $back = 'paskas_jualan';
        } else {
            $sebar                      = Sebar::find($id);
            $sebar->status_publikasi    = '1';
            $sebar->save();

            DB::table('uns_sebar_ditolak')
                ->where('sebar_id', $id)
                ->where('status', 1)
                ->update(['status' => 0]);

            $back = 'sebarku';
        }
        return redirect()->route($back);
    }
    /* - - - */

    /* aktifkan barang paskas & sebar */
    public function aktifkan_fitur($fitur, $id) {
        if ($fitur == 'paskas') {
            $paskas         = Paskas::find($id);
            $paskas->aktif  = '1';
            $paskas->save();
        } else {
            $sebar          = Sebar::find($id);
            $sebar->aktif   = '1';
            $sebar->save();
        }
        return redirect()->route('detail', ['fitur' => $fitur, 'id' => $id]);
    }
    /* - - - */

    /* nonaktifkan barang paskas & sebar */
    public function nonaktifkan_fitur($fitur, $id) {
        if ($fitur == 'paskas') {
            $paskas         = Paskas::find($id);
            $paskas->aktif  = '0';
            $paskas->save();
        } else {
            $sebar          = Sebar::find($id);
            $sebar->aktif   = '0';
            $sebar->save();
        }
        return redirect()->route('detail', ['fitur' => $fitur, 'id' => $id]);
    }
    /* - - - */

    
    public function sebar($x, $y)
    {
        if (!empty(auth()->user()->jarak_tampil)) {
            $lokasi_tampil = auth()->user()->jarak_tampil;
        } else {
            $lokasi_tampil = 10;
        }

        $page = 'Sebar | Sedekah Barang Bekas';
        $back = 'dashboard';
        $filter = Sebar::filter(request(['search','jenis','kondisi']));
        $jenis = db::table('barkas_jenis')->get();
        $kondisi = db::table('uns_barkas_kondisi')->get();
        $current = route('sebar', ['x' => $x, 'y' => $y]);
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id');
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->where('ambilin.status', 3)
                ->get();
            $count_amb = count($count_amb_raw);
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $count_amb = count($count_amb_raw);
        }

        $barang = $filter
            ->where('sebar.hapus', '!=', '1')
            ->where('status_publikasi', 2)
            ->where('sebar.aktif', 1)
            ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'sebar.kondisi')
            ->join('barkas_jenis', 'barkas_jenis.id', 'sebar.fungsi')
            ->leftjoin('wp_lokasi', 'wp_lokasi.id', 'sebar.idlokasi')
            ->select(
                'wp_lokasi.lokasi_x',
                'wp_lokasi.lokasi_y',
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.jenis AS fungsi',
                'sebar.kondisi AS id_kondisi',
                'sebar.deskripsi',
                'sebar.judul',
                'sebar.foto',
                'sebar.id'
            )
            ->selectRaw('( 6371 * acos(cos(radians(?)) * cos(radians(wp_lokasi.lokasi_x)) * cos(radians(wp_lokasi.lokasi_y) - radians(?) ) + sin(radians(?)) * sin(radians(wp_lokasi.lokasi_x)) ) ) AS distance', [$x, $y, $x])
            ->having("distance", "<=", $lokasi_tampil)
            ->get();

        $fil_jenis= DB::table('barkas_jenis')->where("id",'=',(request("jenis")))->first();
        $fil_kondisi= DB::table('uns_barkas_kondisi')->where("id",'=',(request("kondisi")))->first();
        $fil_kata = (request("search"));

        Session::put('sebar_url', request()->fullUrl());

        return view('sebar', compact('back', 'page', 'barang', 'count_amb','jenis','kondisi','fil_jenis','fil_kata','fil_kondisi','current'));
    }

    public function sebar_kosong()
    {
        $page = 'Sebar | Sedekah Barang Bekas';
        $back = 'dashboard';
        $filter = Sebar::filter(request(['search','jenis','kondisi']));
        $jenis = db::table('barkas_jenis')->get();
        $kondisi = db::table('uns_barkas_kondisi')->get();
        $current = route('sebar_kosong');
        if (auth()->user()->kat_user == 2) {
            $sum_amb_raw = DB::table('uns_ambilin_booking')
                ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
                ->join('ambilin','ambilin.id','uns_ambilin_booking.ambilin_id');
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->select('uns_ambilin_booking.id')
                ->where('ambilin.status', 3)
                ->get();
            $count_amb = count($count_amb_raw);
        }
        if (auth()->user()->kat_user != 2) {
            $sum_amb_raw = DB::table('ambilin')
                ->where('ambilin.wp_id', auth()->user()->id);
            $sum_amb = $sum_amb_raw->count();
            $count_amb_raw = $sum_amb_raw
                ->where('ambilin.status', 3)
                ->select('id')
                ->get();
            $count_amb = count($count_amb_raw);
        }

        $barang = 'kosong';

        $fil_jenis= DB::table('barkas_jenis')->where("id",'=',(request("jenis")))->first();
        $fil_kondisi= DB::table('uns_barkas_kondisi')->where("id",'=',(request("kondisi")))->first();
        $fil_kata = (request("search"));

        Session::put('sebar_url', request()->fullUrl());

        return view('sebar', compact('back', 'page', 'barang', 'count_amb','jenis','kondisi','fil_jenis','fil_kata','fil_kondisi','current'));
    }

    public function sebarku()
    {
        $user = DB::table('uns_user')->where("id", auth()->user()->id)->first();
        $sebar = new Sebar();
        $semua = $sebar->getSebarFromStatus(TRUE);
        $proses_cek = $sebar->getSebarFromStatus(1);
        $lolos_cek = $sebar->getSebarFromStatus(2);
        $tidak_lolos_cek = $sebar->getSebarFromStatus(3);
        $barang_laku = $sebar->getSebarFromStatus(4);
        return view('sebarku', compact('semua', 'proses_cek', 'lolos_cek', 'tidak_lolos_cek', 'barang_laku', 'user'));
    }

    public function sebar_baru()
    {
        $page = 'Sebar Barang Bekas di SEBAR';
        $back = 'sebarku';
        $id = DB::table('uns_user')->where('uns_user.id', auth()->user()->id);
        $lokasi = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)->where('aktif', 'Y')->get();
        $fungsi = DB::table('barkas_jenis')->get();
        $kondisi = DB::table('uns_barkas_kondisi')->get();
        return view('sebar_baru', compact('back', 'page', 'id', 'lokasi', 'fungsi', 'kondisi'));
    }

    public function sebar_post(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'judul' => 'required|max:50',
            'deskripsi' => 'nullable|max:255',
            'kondisi' => 'required',
            'fungsi' => 'required',
            'lokasi_pengambilan' => 'required',
        ]);

        $firstPic = $request->file('foto.0');
        $firstFileName = time() . '_' . $firstPic->getClientOriginalName();
        $firstDestination = 'public/img/sebar';
        $firstPic->move($firstDestination, $firstFileName);

        $id = Sebar::Create([
            'wp_id'         => auth()->user()->id,
            'foto'          => $firstFileName,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'kondisi'       => $request->kondisi,
            'fungsi'        => $request->fungsi,
            'idlokasi'      => $request->idlokasi,
            'aktif'   => 1,
            'status_publikasi'  => 1,
            'waktucatat'    =>  Carbon::now(),
        ])->id;

        foreach($request->file('foto') as $key => $foto) {
            if($key > 0) {
                // dd($key, $foto);
                $otherPic = $request->file('foto.'.$key);
                $otherFileName = time() . '_' . $otherPic->getClientOriginalName();
                $otherDestination = 'public/img/sebar';
                $otherPic->move($otherDestination, $otherFileName);

                Sebar_foto::create([
                    'sebar_id'  => $id,
                    'foto'      => $otherFileName
                ]);
            }
        }

        return redirect()->route('sebarku');
    }

    public function paskas_sedekah($id){
        $data_raw = Paskas::where('id', $id);
        $data = $data_raw->first();
        $paskasFoto = Paskas_foto::where('paskas_id', $id)->get();
        if (isset($data->foto)) {
            File::move(public_path("img/paskas/$data->foto"), public_path("img/sebar/$data->foto"));
            foreach ($paskasFoto as $foto) {
                File::move(public_path("img/paskas/$foto->foto"), public_path("img/sebar/$foto->foto"));
            }
        }

        $sebar_id = Paskas_sedekah::Create([
            'wp_id'             => auth()->user()->id,
            'foto'              => $data->foto,
            'judul'             => $data->judul,
            'deskripsi'         => $data->deskripsi,
            'kondisi'           => $data->kondisi,
            'fungsi'            => $data->fungsi,
            'idlokasi'          => $data->idlokasi,
            'aktif'             => $data->aktif,
            'status_publikasi'  => $data->status_publikasi,
            'hapus'             => $data->hapus,
        ])->id;

        foreach ($paskasFoto as $sebarFoto) {
            Sebar_foto::Create([
                'sebar_id'      => $sebar_id,
                'foto'          => $sebarFoto->foto,
            ]);
        }

        Paskas_foto::where('paskas_id', $id)->delete();
        $delete = $data_raw->delete();
        return redirect()->route('sebarku');
    }

    public function barkas_hapus_gambar($fitur, $id) {
        if($fitur == 'paskas') {
            $barkas = Paskas_foto::where('id', $id)->first();
            unlink(public_path('img/paskas/' . $barkas->foto));
            Paskas_foto::where('id', $id)->delete();
        } else if($fitur == 'sebar') {
            $barkas = Sebar_foto::where('id', $id)->first();
            unlink(public_path('img/sebar/' . $barkas->foto));
            Sebar_foto::where('id', $id)->delete();
        }
        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }

    public function barkas_tambah_gambar(Request $request, $fitur) {
        $request->validate([
            'id'    => 'required',
            'foto'  => 'required|image|mimes:jpeg,png,jpg,webp|max:4096'
        ]);

        $fileName = time() . '_' . request()->foto->getClientOriginalName();
        $destination = 'public/img/'.$fitur;
        $request->file('foto')->move($destination, $fileName);

        if($fitur == 'paskas') {
            Paskas_foto::create([
                'paskas_id' => $request->id,
                'foto'      => $fileName
            ]);
        } else if($fitur == 'sebar') {
            Sebar_foto::create([
                'sebar_id' => $request->id,
                'foto'      => $fileName
            ]);
        }

        return redirect()->back()->with('success', 'Gambar berhasil ditambahkan');
    }

    public function barkas_edit_gambar_utama(Request $request, $fitur) {
        $request->validate([
            'id'    => 'required',
            'foto'  => 'required|image|mimes:jpeg,png,jpg,webp|max:4096'
        ]);

        $fileName = time() . '_' . request()->foto->getClientOriginalName();
        $destination = 'public/img/'.$fitur;
        $request->file('foto')->move($destination, $fileName);

        if($fitur == 'paskas') {
            $barkas = Paskas::where('id', $request->id)->first();
            unlink(public_path('img/paskas/' . $barkas->foto));

            Paskas::where('id', $request->id)
                ->update([
                    'foto'      => $fileName
                ]);
        } else if($fitur == 'sebar') {
            $barkas = Sebar::where('id', $request->id)->first();
            unlink(public_path('img/sebar/' . $barkas->foto));

            Sebar::where('id', $request->id)
                ->update([
                    'foto'      => $fileName
                ]);
        }

        return redirect()->back()->with('success', 'Gambar berhasil diubah');
    }

    public function barkas_edit_gambar(Request $request, $fitur) {
        $request->validate([
            'id'    => 'required',
            'foto'  => 'required|image|mimes:jpeg,png,jpg,webp|max:4096'
        ]);

        $fileName = time() . '_' . request()->foto->getClientOriginalName();
        $destination = 'public/img/'.$fitur;
        $request->file('foto')->move($destination, $fileName);

        if($fitur == 'paskas') {
            $barkas = Paskas_foto::where('id', $request->id)->first();
            unlink(public_path('img/paskas/' . $barkas->foto));

            Paskas_foto::where('id', $request->id)
                ->update([
                    'foto'      => $fileName
                ]);
        } else if($fitur == 'sebar') {
            $barkas = Sebar_foto::where('id', $request->id)->first();
            unlink(public_path('img/sebar/' . $barkas->foto));

            Sebar_foto::where('id', $request->id)
                ->update([
                    'foto'      => $fileName
                ]);
        }

        return redirect()->back()->with('success', 'Gambar berhasil diubah');
    }

    public function barkas_edit_judul(Request $request, $fitur) {
        // dd($request, $fitur);
        $request->validate([
            'id_barkas' => 'required',
            'judul'     => 'required'
        ]);

        if($fitur == 'paskas') {
            Paskas::where('id', $request->id_barkas)
                ->update([
                    'judul' => $request->judul
                ]);
        } else if($fitur == 'sebar') {
            Sebar::where('id', $request->id_barkas)
                ->update([
                    'judul' => $request->judul
                ]);
        }

        return redirect()->back()->with('success', 'Judul berhasil diubah');
    }

    public function barkas_edit_harga(Request $request) {
        $request->validate([
            'id_barkas' => 'required',
            'harga'     => 'required'
        ]);

        Paskas::where('id', $request->id_barkas)
            ->update([
                'harga' => $request->harga
            ]);

        return redirect()->back()->with('success', 'Harga berhasil diubah');
    }

    public function barkas_edit_jenis(Request $request, $fitur) {
        $request->validate([
            'id_barkas' => 'required',
            'idjenis'   => 'required'
        ]);

        if($fitur == 'paskas') {
            Paskas::where('id', $request->id_barkas)
                ->update([
                    'fungsi'    => $request->idjenis
                ]);
        } else if($fitur == 'sebar') {
            Sebar::where('id', $request->id_barkas)
                ->update([
                    'fungsi'    => $request->idjenis
                ]);
        }

        return redirect()->back()->with('success', 'Jenis berhasil diubah');
    }

    public function barkas_edit_kondisi(Request $request, $fitur) {
        $request->validate([
            'id_barkas' => 'required',
            'idkondisi' => 'required'
        ]);

        if($fitur == 'paskas') {
            Paskas::where('id', $request->id_barkas)
                ->update([
                    'kondisi'   => $request->idkondisi
                ]);
        } else if($fitur == 'sebar') {
            Sebar::where('id', $request->id_barkas)
                ->update([
                    'kondisi'   => $request->idkondisi
                ]);
        }

        return redirect()->back()->with('success', 'Kondisi berhasil diubah');
    }

    public function barkas_edit_lokasi(Request $request, $fitur) {
        $request->validate([
            'id_barkas' => 'required',
            'idlokasi'  => 'required'
        ]);

        if($fitur == 'paskas') {
            Paskas::where('id', $request->id_barkas)
                ->update([
                    'idlokasi'   => $request->idlokasi
                ]);
        } else if($fitur == 'sebar') {
            Sebar::where('id', $request->id_barkas)
                ->update([
                    'idlokasi'   => $request->idlokasi
                ]);
        }

        return redirect()->back()->with('success', 'Lokasi berhasil diubah');
    }
    
    public function barkas_edit_deskripsi(Request $request, $fitur) {
        $request->validate([
            'id_barkas' => 'required',
            'deskripsi' => 'nullable'
        ]);

        if($fitur == 'paskas') {
            Paskas::where('id', $request->id_barkas)
                ->update([
                    'deskripsi'   => $request->deskripsi
                ]);
        } else if($fitur == 'sebar') {
            Sebar::where('id', $request->id_barkas)
                ->update([
                    'deskripsi'   => $request->deskripsi
                ]);
        }

        return redirect()->back()->with('success', 'Deskripsi berhasil diubah');
    }

    public function direction(Request $request,$fitur, $id){
        // dd($id);
        $request->validate([
            'lokasi_x' => 'required',
            'lokasi_y' => 'required'
        ]);
        // if($fitur == 'paskas'){
        //     // dd('paskas');
        //     // $data = DB::table('paskas')
        //     // ->where('paskas.id',$id)->join('wp_lokasi', 'wp_lokasi.id', '=', 'paskas.idlokasi')
        //     // ->select('wp_lokasi.lokasi_x','wp_lokasi.lokasi_y')->first();
        // } elseif ($fitur == 'sebar'){
        //     // dd('sebar');
        //     // $data = DB::table('sebar')
        //     // ->where('sebar.id',$id)->join('wp_lokasi', 'wp_lokasi.id', '=', 'sebar.idlokasi')
        //     // ->select('wp_lokasi.lokasi_x','wp_lokasi.lokasi_y')->first();
        // }
        $data = DB::table('wp_lokasi')->where('id',$id)->first();
        $xAwal = $request->lokasi_x;
        $yAwal = $request->lokasi_y;
        $xTarget = $data->lokasi_x;
        $yTarget = $data->lokasi_y;
        $link = "https://www.google.com/maps/dir/".$xAwal.",".$yAwal."/".$xTarget.",".$yTarget."/";
        // return view('iframe', compact('link', 'target'));
        return Redirect::to($link);
    }

    public function map($fitur, $id) {
        // $request->validate([
        //     'id_ambilin' => 'required'
        // ]);
        $page = 'Lokasi Pengambilan';
        $data_raw = DB::table($fitur);
        if ($fitur == 'paskas') {
            $data = $data_raw->where('paskas.id', $id)
            ->join('uns_user', 'uns_user.id', 'paskas.wp_id')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'paskas.idlokasi')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'paskas.wp_id',
                    'uns_user.nama',
                    'uns_user.foto_diri',
                    'wp_lokasi.lokasi_x',
                    'wp_lokasi.lokasi_y',
                    'wp_lokasi.alamat_lokasi',
                    'wp_lokasi.kode_pos',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel')
                ->first();

        } else {
            $data = $data_raw->where('sebar.id', $id)
                ->join('uns_user', 'uns_user.id', 'sebar.wp_id')
                ->leftjoin('wp_lokasi', 'wp_lokasi.id', '=', 'sebar.idlokasi')
                ->leftjoin('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
                ->leftjoin('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
                ->leftjoin('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
                ->leftjoin('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
                ->select(
                    'sebar.wp_id',
                    'uns_user.nama',
                    'uns_user.foto_diri',
                    'wp_lokasi.lokasi_x',
                    'wp_lokasi.lokasi_y',
                    'wp_lokasi.alamat_lokasi',
                    'wp_lokasi.kode_pos',
                    'indonesia_provinces.name AS prov',
                    'indonesia_cities.name AS kab',
                    'indonesia_districts.name AS kec',
                    'indonesia_villages.name As kel',)
                ->first();
        }
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
