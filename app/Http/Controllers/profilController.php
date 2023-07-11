<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WP_Lokasi;
use App\Models\Alasan_lokasi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Paskas;
use App\Models\Sebar;
use App\Models\Hapus_Akun;
use Carbon\Carbon;

class profilController extends BaseController
{
    public function index()
    {
        // $user = DB::table('uns_user')->get();
        $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->get();
        // $jenis = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
        //     ->join('wp_lokasijenis', 'wp_lokasijenis.id', '=', 'uns_user.kat_lokasi')
        //     ->select('wp_lokasijenis.jenis_lokasi')
        //     ->first();
        $kat = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('uns_kat_user', 'uns_kat_user.id', '=', 'uns_user.kat_user')
            ->select('uns_kat_user.kat')
            ->first();
        $catat = Carbon::parse(auth()->user()->waktu_catat);
        $waktu_catat = $catat->translatedFormat('d F Y');
        $pekerjaan = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('pekerjaan', 'pekerjaan.id', '=', 'uns_user.idpekerjaan')
            ->select('pekerjaan.pekerjaan')
            ->first();
        $pendidikan = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('pendidikan', 'pendidikan.id', '=', 'uns_user.idpendidikan')
            ->select('pendidikan.pendidikan')
            ->first();
        $prov = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('indonesia_provinces', 'indonesia_provinces.id', '=', 'uns_user.idprov')
            ->select('indonesia_provinces.name')
            ->first();
        $kab = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('indonesia_cities', 'indonesia_cities.id', '=', 'uns_user.idkab')
            ->select('indonesia_cities.name')
            ->first();
        $kec = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('indonesia_districts', 'indonesia_districts.id', '=', 'uns_user.idkec')
            ->select('indonesia_districts.name')
            ->first();
        $kel = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)
            ->join('indonesia_villages', 'indonesia_villages.id', '=', 'uns_user.idkel')
            ->select('indonesia_villages.name')
            ->first();
        $lokasi_ambil = DB::table('wp_lokasi')->where('wp_id', auth()->user()->id)
            ->where('hapus', '0')
            ->join('wp_lokasijenis', 'wp_lokasijenis.id', '=', 'wp_lokasi.idlokasijenis')
            ->select('wp_lokasi.*', 'wp_lokasijenis.jenis_lokasi')
            ->get();
        // $prov_ambil = DB::table('wp_lokasi')->where('wp_lokasi.wp_id', auth()->user()->id)
        //     ->join('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
        //     ->select('indonesia_provinces.name')
        //     ->get();
        // $kab_ambil = DB::table('wp_lokasi')->where('wp_lokasi.wp_id', auth()->user()->id)
        //     ->join('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
        //     ->select('indonesia_cities.name')
        //     ->get();
        // $kec_ambil = DB::table('wp_lokasi')->where('wp_lokasi.wp_id', auth()->user()->id)
        //     ->join('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
        //     ->select('indonesia_districts.name')
        //     ->get();
        // $kel_ambil = DB::table('wp_lokasi')->where('wp_lokasi.wp_id', auth()->user()->id)
        //     ->join('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
        //     ->select('indonesia_villages.name')
        //     ->get();
        // dd($lokasi_ambil);
        return view('profile',compact(
            'user', 
            // 'jenis', 
            'waktu_catat', 
            'pekerjaan', 
            'pendidikan', 
            'prov', 
            'kab', 
            'kec', 
            'kel', 
            'lokasi_ambil', 
            'kat', 
            // 'prov_ambil', 
            // 'kab_ambil', 
            // 'kec_ambil', 
            // 'kel_ambil'
        ));
    }

    public function create_data_1(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        // $user = User::all();
        $user = $request->session()->get('user');
        $pekerjaan = DB::table('pekerjaan')->get();
        $pendidikan = DB::table('pendidikan')->get();
        return view('lengkapi-data-1',compact('page' ,'user', 'pekerjaan', 'pendidikan'));
    }

    public function post_data_1(Request $request)
    {
        $validatedData = $request->validate([
            'no_ktp' => 'required|unique:uns_user',
            // 'nama' => 'required',
            'nama_lengkap' => 'required',
            // 'no_wa' => 'required|numeric',
            'email' => 'nullable|email|unique:uns_user',
            'tgl_lahir' => 'nullable',
            'sex' => 'nullable',
            'idpekerjaan' => 'nullable',
            'idpendidikan' => 'nullable',
            // 'file_foto_diri' => 'image|file|mimes:jpeg,png,jpg',
        ]);
  
        if(empty($request->session()->get('user'))){
            $user = new User();
            $user->fill($validatedData);
            $request->session()->put('user', $user);
        }else{
            $user = $request->session()->get('user');
            $user->fill($validatedData);
            $request->session()->put('user', $user);
        }

        // dd($user);
  
        return redirect()->route('create_data_2');
    }

    public function create_data_2(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        // $provinsi = DB::table('indonesia_provinces')->get();
        /* Kota Semarang */
        $provinsi = DB::table('indonesia_provinces')->where('id', 33)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', 3374)->first();
        $kecamatan = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        /* End Kota Semarang */
        return view('lengkapi-data-2',compact('page','user', 'provinsi', 'kabupaten', 'kecamatan'));
    }

    public function getKabupaten(Request $request)
    {
        $provID = $request->provID;
        $kabupaten = DB::table('indonesia_cities')->where('province_id', $provID)->get();

        if ($request->session()->get('user') == null) {
            $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)->first();
        } else {
            $user = $request->session()->get('user');
        }

        if ($provID == 'TRUE') {
            echo "<select class='form-select' aria-label='kabupaten' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                $kabfill = (isset($user->idkab) && $user->idkab == $kab->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kab->id' $kabfill>$kab->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kabupaten' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                $kabfill = (isset($user->idkab) && $user->idkab == $kab->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kab->id' $kabfill>$kab->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKecamatan(Request $request)
    {
        $kabID = $request->kabID;
        $kecamatan = DB::table('indonesia_districts')->where('city_id', $kabID)->get();

        if ($request->session()->get('user') == null) {
            $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)->first();
        } else {
            $user = $request->session()->get('user');
        }

        if ($kabID == 'TRUE') {
            echo "<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                $kecfill = (isset($user->idkec) && $user->idkec == $kec->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kec->id' $kecfill>$kec->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                $kecfill = (isset($user->idkec) && $user->idkec == $kec->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kec->id' $kecfill>$kec->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKecamatan2(Request $request)
    {
        $kabID = $request->kabID;
        $kecamatan = DB::table('indonesia_districts')->where('city_id', $kabID)->get();

        $wp_lokasi = DB::table('wp_lokasi')->where('wp_lokasi.id', 55)->first();

        if ($kabID == 'TRUE') {
            echo "<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                $kecfill = (isset($wp_lokasi->idkec) && $wp_lokasi->idkec == $kec->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kec->id' $kecfill>$kec->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kecamatan' name='kecamatan' id='kecamatan'>";
            echo "<option>Pilih Kecamatan</option>";
            foreach ($kecamatan as $kec) {
                $kecfill = (isset($wp_lokasi->idkec) && $wp_lokasi->idkec == $kec->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kec->id' $kecfill>$kec->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKelurahan(Request $request)
    {
        $kecID = $request->kecID;
        $kelurahan = DB::table('indonesia_villages')->where('district_id', $kecID)->get();

        // if ($request->session()->get('user') !== null) {
        //     $user = $request->session()->get('user');
        // }

        // if ((DB::table('uns_user')->where('uns_user.id', auth()->user()->id)) !== null) {
        //     $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)->first();
        // }

        // if ($request->session()->get('wp_lokasi') !== null) {
        //     $wp_lokasi = $request->session()->get('wp_lokasi');
        // }

        $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)->first();

        if ($request->session()->get('user') != null) {
            $user = $request->session()->get('user');
        }

        if ($request->session()->get('wp_lokasi') != null) {
            $wp_lokasi = $request->session()->get('wp_lokasi');
        }

        // $wp_lokasi = DB::table('wp_lokasi')->where('wp_lokasi.id', 55)->first();

        if ($kecID == 'TRUE') {
            echo "<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                if ($request->session()->get('wp_lokasi') != null) {
                    $kelfill = (isset($wp_lokasi->idkel) && $wp_lokasi->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                } else {
                    $kelfill = (isset($user->idkel) && $user->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                }
                echo "<option value='$kel->id' $kelfill>$kel->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                if ($request->session()->get('wp_lokasi') != null) {
                    $kelfill = (isset($wp_lokasi->idkel) && $wp_lokasi->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                } else {
                    $kelfill = (isset($user->idkel) && $user->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                }
                echo "<option value='$kel->id' $kelfill>$kel->name</option>";
            }
            echo "</select>";
        }
    }

    public function getKelurahan2(Request $request, $id)
    {
        $kecID = $request->kecID;
        $kelurahan = DB::table('indonesia_villages')->where('district_id', $kecID)->get();

        $wp_lokasi = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)->first();

        if ($kecID == 'TRUE') {
            echo "<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                $kelfill = (isset($wp_lokasi->idkel) && $wp_lokasi->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kel->id' $kelfill>$kel->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kelurahan' name='kelurahan' id='kelurahan'>";
            echo "<option>Pilih Kelurahan</option>";
            foreach ($kelurahan as $kel) {
                $kelfill = (isset($wp_lokasi->idkel) && $wp_lokasi->idkel == $kel->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kel->id' $kelfill>$kel->name</option>";
            }
            echo "</select>";
        }
    }

    public function post_data_2(Request $request)
    {
        $validatedData = $request->validate([
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required',
            'kodepos' => '',
        ]);

        $validatedData['idprov'] = $validatedData['provinsi'];
        $validatedData['idkab'] = $validatedData['kabupaten'];
        $validatedData['idkec'] = $validatedData['kecamatan'];
        $validatedData['idkel'] = $validatedData['kelurahan'];
        $validatedData['alamat_lokasi'] = $validatedData['alamat'];
  
        $user = $request->session()->get('user');
        $user->fill($validatedData);
        $request->session()->put('user', $user);

        // dd($user);
  
        return redirect()->route('create_data_3');
    }

    public function create_data_3(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        // $bank = DB::table('bank')->get();
        return view('lengkapi-data-3',compact('page','user'));
    }

    public function post_data_3(Request $request)
    {
        $user = $request->session()->get('user');
        if(!isset($user->ktp)){
            $request->validate([
                'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileName = "ktp-" . time() . '_' . request()->ktp->getClientOriginalName();
            $destination = 'public/img/ktp';
            $request->file('ktp')->move($destination, $fileName);
            $user = $request->session()->get('user');
            $user->ktp = $fileName;
            $request->session()->put('user', $user);
        }
        // dd($user);
        return redirect()->route('create_data_4');
    }

    public function remove_ktp(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        unlink(public_path('img/ktp/'.$user->ktp.''));
        $user->ktp = null;
        return view('lengkapi-data-3',compact('page','user'));
    }

    public function create_data_4(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        return view('lengkapi-data-4',compact('page','user'));
    }

    public function post_data_4(Request $request)
    {
        $user = $request->session()->get('user');
        if(!isset($user->foto_diri)){
            $request->validate([
                'foto_diri' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileName = time() . '_' . request()->foto_diri->getClientOriginalName();
            $destination = 'public/img/foto';
            $request->file('foto_diri')->move($destination, $fileName);
            $user = $request->session()->get('user');
            $user->foto_diri = $fileName;
            $request->session()->put('user', $user);
        }
        // dd($user);
        return redirect()->route('create_data_5');
    }

    public function remove_foto(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        if (isset($user->foto_diri)) {
        unlink(public_path('img/foto/'.$user->foto_diri.''));
        }
        $user->foto_diri = null;
        return view('lengkapi-data-4',compact('page','user'));
    }

    public function create_data_5(Request $request)
    {
        $page = 'Lengkapi Data';
        // $back = 'profile';
        $user = $request->session()->get('user');
        $pekerjaan = DB::table('pekerjaan')->where('id', $user->idpekerjaan)->first();
        $pendidikan = DB::table('pendidikan')->where('id', $user->idpendidikan)->first();
        $provinsi = DB::table('indonesia_provinces')->where('id', $user->idprov)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', $user->idkab)->first();
        $kecamatan = DB::table('indonesia_districts')->where('id', $user->idkec)->first();
        $kelurahan = DB::table('indonesia_villages')->where('id', $user->idkel)->first();
        return view('lengkapi-data-5',compact('page','user', 'pekerjaan', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function post_data_5(Request $request)
    {
        $user_req = $request->session()->get('user');
        $user = User::find(auth()->user()->id);
        // $user->username         = $user->no_wa;
        $user->nama_lengkap     = $user_req->nama_lengkap;
        $user->email            = $user_req->email;
        $user->tgl_lahir        = $user_req->tgl_lahir;
        $user->sex              = $user_req->sex;
        $user->verified         = '1';
        $user->idpekerjaan      = $user_req->idpekerjaan;
        $user->idpendidikan     = $user_req->idpendidikan;
        $user->alamat_lokasi    = $user_req->alamat_lokasi;
        $user->idprov           = $user_req->idprov;
        $user->idkab            = $user_req->idkab;
        $user->idkec            = $user_req->idkec;
        $user->idkel            = $user_req->idkel;
        $user->kodepos          = $user_req->kodepos;
        $user->no_ktp           = $user_req->no_ktp;
        $user->ktp              = $user_req->ktp;
        $user->foto_diri        = $user_req->foto_diri;
        // $user = User::findOrFail(auth()->user()->id);
        // $user->fill($request->all());
        // dd($user);
        $user->save();
  
        $request->session()->forget('user');
  
        return redirect()->route('profile');
    }

    public function back_to_profile(Request $request) {
        if ($request->session()->get('user')) {
            $user = $request->session()->get('user');
            if (isset($user->ktp)) {
                unlink(public_path('img/ktp/'.$user->ktp.''));
            }
            if (isset($user->foto_diri)) {
                unlink(public_path('img/foto/'.$user->foto_diri.''));
            }
            $request->session()->forget('user');
        }

        if ($request->session()->get('wp_lokasi')) {
            $wp_lokasi = $request->session()->get('wp_lokasi');
            if (isset($wp_lokasi->lampiran_denah)) {
                unlink(public_path('img/wp_lokasi/lampiran_denah/'.$wp_lokasi->lampiran_denah.''));
            }
            if (isset($wp_lokasi->foto_lokasi)) {
                unlink(public_path('img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi.''));
            }
            $request->session()->forget('wp_lokasi');
        }

        return redirect()->route('profile');
    }

    public function edit_datadiri() {
        $page = 'Ubah Data Diri';
        $back = 'profile';
        $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
        $pekerjaan_list = DB::table('pekerjaan')->get();
        $pendidikan_list = DB::table('pendidikan')->get();
        $pekerjaan = DB::table('pekerjaan')->where('id', $user->idpekerjaan)->first();
        $pendidikan = DB::table('pendidikan')->where('id', $user->idpendidikan)->first();
        $provinsi = DB::table('indonesia_provinces')->where('id', $user->idprov)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', $user->idkab)->first();
        $kecamatan = DB::table('indonesia_districts')->where('id', $user->idkec)->first();
        $kelurahan = DB::table('indonesia_villages')->where('id', $user->idkel)->first();
        return view('edit_datadiri', compact('back','page','user', 'pekerjaan_list', 'pendidikan_list', 'pekerjaan', 'pendidikan', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function update_datadiri(Request $request) {
        $request->validate([
            'nama'          => 'required',
            'nama_lengkap'  => 'required',
            'email'         => 'nullable|email|unique:uns_user,email,'.auth()->user()->id,
            'tgl_lahir'     => 'nullable',
            'sex'           => 'nullable',
            'idpekerjaan'   => 'nullable',
            'idpendidikan'  => 'nullable',
        ]);

        $user                   = User::find(auth()->user()->id);
        $user->nama             = $request->nama;
        $user->nama_lengkap     = $request->nama_lengkap;
        $user->email            = $request->email;
        $user->tgl_lahir        = $request->tgl_lahir;
        $user->sex              = $request->sex;
        $user->idpekerjaan      = $request->idpekerjaan;
        $user->idpendidikan     = $request->idpendidikan;
        $user->save();

        return redirect()->route('profile');
    }

    public function edit_foto() {
        $page = 'Ubah Foto';
        $back = 'profile';
        $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
        return view('edit_foto', compact('back','page','user'));
    }

    public function update_foto(Request $request)
    {
            $request->validate([
                'foto_lama' => 'nullable',
                'foto_diri' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            ]);

            if (isset($request->foto_diri)) {
                $fileName = time() . '_' . request()->foto_diri->getClientOriginalName();
                $destination = 'public/img/foto';
                $request->file('foto_diri')->move($destination, $fileName);
            } else {
                $fileName = null;
            }

            if (isset($request->foto_lama) && file_exists('img/foto/'.$request->foto_lama.'')) {
                unlink(public_path('img/foto/'.$request->foto_lama.''));
            }

            $user                   = User::find(auth()->user()->id);
            $user->foto_diri        = $fileName;
            $user->save();
 
        return redirect()->route('profile');
    }

    public function edit_wa() {
        $page = 'Ubah Nomor WhatsApp';
        $back = 'profile';
        $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
        return view('edit_wa', compact('page','back','user'));
    }

    public function update_wa(Request $request) {
        $request->validate([
            'no_wa'         => 'required|unique:uns_user,no_wa,'.auth()->user()->id,
        ]);

        $user               = User::find(auth()->user()->id);
        $user->username     = $request->no_wa;
        $user->no_wa        = $request->no_wa;
        $user->save();

        return redirect()->route('profile');
    }

    public function edit_domisili() {
        $page = 'Ubah domisili';
        $back = 'profile';
        $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
        $provinsi = DB::table('indonesia_provinces')->where('id', $user->idprov)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', $user->idkab)->first();
        $kecamatan = DB::table('indonesia_districts')->where('id', $user->idkec)->first();
        $kelurahan = DB::table('indonesia_villages')->where('id', $user->idkel)->first();
        /* Kota Semarang */
        $provinsi2 = DB::table('indonesia_provinces')->where('id', 33)->first();
        $kabupaten2 = DB::table('indonesia_cities')->where('id', 3374)->first();
        $kecamatan2 = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        /* End Kota Semarang */
        // $prov = DB::table('indonesia_provinces')->get();
        return view('edit_domisili', compact('page','back','user', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'provinsi2', 'kabupaten2', 'kecamatan2'));
    }

    public function getKabupaten3(Request $request)
    {
        $provID = $request->provID;
        $kabID = $request->kabID;
        if ($provID == 33) {
            $kabupaten = DB::table('indonesia_cities')->where('province_id', $provID)->whereIn('id', [$kabID, 3374])->get();
        } else {
            $kabupaten = DB::table('indonesia_cities')->where('province_id', $provID)->where('id', $kabID)->get();
        }

        if ($request->session()->get('user') == null) {
            $user = DB::table('uns_user')->where('uns_user.id', auth()->user()->id)->first();
        } else {
            $user = $request->session()->get('user');
        }

        if ($provID == 'TRUE') {
            echo "<select class='form-select' aria-label='kabupaten' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                $kabfill = (isset($user->idkab) && $user->idkab == $kab->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kab->id' $kabfill>$kab->name</option>";
            }
            echo "</select>";
        } else {
            echo "<select class='form-select' aria-label='kabupaten' name='kabupaten' id='kabupaten'>";
            echo "<option value=''>Pilih Kabupaten</option>";
            foreach ($kabupaten as $kab) {
                $kabfill = (isset($user->idkab) && $user->idkab == $kab->id) ? 'selected=\'selected\'' : '';
                echo "<option value='$kab->id' $kabfill>$kab->name</option>";
            }
            echo "</select>";
        }
    }

    public function update_domisili(Request $request) {
        $validatedData = $request->validate([
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required',
            'kodepos' => '',
        ]);

        $validatedData['idprov'] = $validatedData['provinsi'];
        $validatedData['idkab'] = $validatedData['kabupaten'];
        $validatedData['idkec'] = $validatedData['kecamatan'];
        $validatedData['idkel'] = $validatedData['kelurahan'];
        $validatedData['alamat_lokasi'] = $validatedData['alamat'];

        $user                   = User::find(auth()->user()->id);
        $user->idprov           = $validatedData['provinsi'];
        $user->idkab            = $validatedData['kabupaten'];
        $user->idkec            = $validatedData['kecamatan'];
        $user->idkel            = $validatedData['kelurahan'];
        $user->alamat_lokasi    = $validatedData['alamat'];
        $user->save();

        return redirect()->route('profile');
    }

    public function tambah_lokasi_1(Request $request) {
        $page = 'Tambah Lokasi Pengambilan';
        // $back = 'profile';
        $wp_lokasi = $request->session()->get('wp_lokasi');
        $provinsi = DB::table('indonesia_provinces')->where('id', 33)->get();
        $kabupaten = DB::table('indonesia_cities')->where('province_id', 33)->get();
        $kecamatan = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        $jenis_lokasi = DB::table('wp_lokasijenis')->get();
        return view('tambah_lokasi_1', compact('page','wp_lokasi', 'provinsi','kabupaten' ,'kecamatan', 'jenis_lokasi'));
    }

    public function post_lokasi_1(Request $request) {
        $validatedData = $request->validate([
            // 'wp_id' => 'required',
            'idprov' => 'required',
            'idkab' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_lokasi' => 'required',
            'kode_pos' => 'nullable',
            'nama_lokasi' => 'required',
            'idlokasijenis' => 'required',
            'catatan' => 'nullable',
        ]);

        // $validatedData['idprov'] = $validatedData['provinsi'];
        // $validatedData['idkab'] = $validatedData['kabupaten'];
        $validatedData['idkec'] = $validatedData['kecamatan'];
        $validatedData['idkel'] = $validatedData['kelurahan'];
        // $validatedData['idlokasijenis'] = $validatedData['Jenis_lokasi'];
  
        if(empty($request->session()->get('wp_lokasi'))){
            $wp_lokasi = new WP_Lokasi();
            $wp_lokasi->fill($validatedData);
            $request->session()->put('wp_lokasi', $wp_lokasi);
        }else{
            $wp_lokasi = $request->session()->get('wp_lokasi');
            $wp_lokasi->fill($validatedData);
            $request->session()->put('wp_lokasi', $wp_lokasi);
        }

        // dd($wp_lokasi);
  
        return redirect()->route('tambah_lokasi_2');
    }

    public function tambah_lokasi_2(Request $request) {
        $page = 'Tambah Lokasi Pengambilan';
        // $back = 'profile';
        $wp_lokasi = $request->session()->get('wp_lokasi');
        return view('tambah_lokasi_2', compact('page','wp_lokasi'));
    }

    public function post_lokasi_2(Request $request)
    {
        $wp_lokasi = $request->session()->get('wp_lokasi');

        $request->validate([
            // 'lampiran_denah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'lokasi_x' => 'required',
            'lokasi_y' => 'required',
        ]);

        $wp_lokasi->lokasi_x = $request->lokasi_x;
        $wp_lokasi->lokasi_y = $request->lokasi_y;
        $request->session()->put('wp_lokasi', $wp_lokasi);
        // if($request->lampiran_denah != null){
        //     $fileName = "denah_" . time() . '_' . request()->lampiran_denah->getClientOriginalName();
        //     $destination = 'public/img/wp_lokasi/lampiran_denah';
        //     $request->file('lampiran_denah')->move($destination, $fileName);
        //     $wp_lokasi = $request->session()->get('wp_lokasi');
        //     $wp_lokasi->lampiran_denah = $fileName;
        //     $request->session()->put('wp_lokasi', $wp_lokasi);
        // }
        // dd($wp_lokasi);
        return redirect()->route('tambah_lokasi_3');
    }

    // public function remove_lampiran_denah(Request $request)
    // {
    //     $page = 'Tambah Lokasi Pengambilan';
    //     // $back = 'profile';
    //     $wp_lokasi = $request->session()->get('wp_lokasi');
    //     unlink(public_path('img/wp_lokasi/lampiran_denah/'.$wp_lokasi->lampiran_denah.''));
    //     $wp_lokasi->lampiran_denah = null;
    //     return view('tambah_lokasi_3',compact('page','wp_lokasi'));
    // }

    public function tambah_lokasi_3(Request $request) {
        $page = 'Tambah Lokasi Pengambilan';
        // $back = 'profile';
        $wp_lokasi = $request->session()->get('wp_lokasi');
        return view('tambah_lokasi_3', compact('page','wp_lokasi'));
    }

    public function post_lokasi_3(Request $request)
    {
        $wp_lokasi = $request->session()->get('wp_lokasi');

        $request->validate([
            'foto_lokasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($request->foto_lokasi != null){
            $fileName = "lokasi_" . time() . '_' . request()->foto_lokasi->getClientOriginalName();
            $destination = 'public/img/wp_lokasi/foto_lokasi';
            $request->file('foto_lokasi')->move($destination, $fileName);
            $wp_lokasi = $request->session()->get('wp_lokasi');
            $wp_lokasi->foto_lokasi = $fileName;
            $request->session()->put('wp_lokasi', $wp_lokasi);
        }
        // dd($user);
        return redirect()->route('tambah_lokasi_4');
    }

    public function remove_foto_lokasi(Request $request)
    {
        $page = 'Tambah Lokasi Pengambilan';
        // $back = 'profile';
        $wp_lokasi = $request->session()->get('wp_lokasi');
        unlink(public_path('img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi.''));
        $wp_lokasi->foto_lokasi = null;
        return view('tambah_lokasi_3',compact('page','wp_lokasi'));
    }

    public function tambah_lokasi_4(Request $request) {
        $page = 'Tambah Lokasi Pengambilan';
        // $back = 'profile';
        $wp_lokasi = $request->session()->get('wp_lokasi');
        $jenis_lokasi = DB::table('wp_lokasijenis')->where('id', $wp_lokasi->idlokasijenis)->first();
        $provinsi = DB::table('indonesia_provinces')->where('id', $wp_lokasi->idprov)->first();
        $kabupaten = DB::table('indonesia_cities')->where('id', $wp_lokasi->idkab)->first();
        $kecamatan = DB::table('indonesia_districts')->where('id', $wp_lokasi->idkec)->first();
        $kelurahan = DB::table('indonesia_villages')->where('id', $wp_lokasi->idkel)->first();
        return view('tambah_lokasi_4', compact('page','wp_lokasi', 'jenis_lokasi', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    public function post_lokasi_4(Request $request)
    {
        $wp_lokasi = $request->session()->get('wp_lokasi');
        WP_Lokasi::Create([
            'wp_id'         =>  auth()->user()->id,
            'aktif'         =>  "Y",
            'lokasi_x'      =>  $wp_lokasi->lokasi_x,
            'lokasi_y'      =>  $wp_lokasi->lokasi_y,
            'foto_lokasi'   =>  $wp_lokasi->foto_lokasi,
            'idlokasijenis' =>  $wp_lokasi->idlokasijenis,
            'nama_lokasi'   =>  $wp_lokasi->nama_lokasi,
            'alamat_lokasi' =>  $wp_lokasi->alamat_lokasi,
            'idprov'        =>  $wp_lokasi->idprov,
            'idkab'         =>  $wp_lokasi->idkab,
            'idkec'         =>  $wp_lokasi->idkec,
            'idkel'         =>  $wp_lokasi->idkel,
            'kode_pos'      =>  $wp_lokasi->kode_pos,
            'catatan'       =>  $wp_lokasi->catatan,
            'lampiran_denah'=>  $wp_lokasi->lampiran_denah,
            'status_lokasi' =>  0,
            'waktu_catat'   =>  Carbon::now(),
        ]);
  
        $request->session()->forget('wp_lokasi');
  
        return redirect()->route('profile');
    }

    public function detail_lokasi($id) {
        $page = 'Detail Lokasi Pengambilan';
        $back = 'profile';
        $wp_lokasi = DB::table('wp_lokasi')->where('id', $id)->first();
        $prov = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)
            ->join('indonesia_provinces', 'indonesia_provinces.id', '=', 'wp_lokasi.idprov')
            ->select('indonesia_provinces.name')
            ->first();
        $kab = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)
            ->join('indonesia_cities', 'indonesia_cities.id', '=', 'wp_lokasi.idkab')
            ->select('indonesia_cities.name')
            ->first();
        $kec = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)
            ->join('indonesia_districts', 'indonesia_districts.id', '=', 'wp_lokasi.idkec')
            ->select('indonesia_districts.name')
            ->first();
        $kel = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)
            ->join('indonesia_villages', 'indonesia_villages.id', '=', 'wp_lokasi.idkel')
            ->select('indonesia_villages.name')
            ->first();
        $jenis_lokasi = DB::table('wp_lokasi')->where('wp_lokasi.id', $id)
            ->join('wp_lokasijenis', 'wp_lokasijenis.id', '=', 'wp_lokasi.idlokasijenis')
            ->select('wp_lokasi.*', 'wp_lokasijenis.jenis_lokasi')
            ->first();
        // dd($wp_lokasi, $prov, $kab, $kec, $kel);
        return view('detail_lokasi', compact('page','back','wp_lokasi', 'prov', 'kab', 'kec', 'kel', 'jenis_lokasi'));
    }

    public function edit_detail_lokasi($id) {
        $page = 'Ubah Lokasi Pengambilan';
        $wp_lokasi = DB::table('wp_lokasi')->where('id', $id)->first();
        $provinsi = DB::table('indonesia_provinces')->where('id', 33)->get();
        $kabupaten = DB::table('indonesia_cities')->where('id', 3374)->get();
        $kecamatan = DB::table('indonesia_districts')->where('city_id', 3374)->get();
        $jenis_lokasi = DB::table('wp_lokasijenis')->get();
        // dd($wp_lokasi);
        return view('edit_detail_lokasi', compact('page','wp_lokasi', 'provinsi', 'kabupaten', 'kecamatan', 'jenis_lokasi'));
    }

    public function post_detail_lokasi(Request $request, $id) {
        $validatedData = $request->validate([
            'idprov' => 'required',
            'idkab' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_lokasi' => 'required',
            'kode_pos' => 'nullable',
            'nama_lokasi' => 'required',
            'idlokasijenis' => 'required',
            'catatan' => 'nullable',
        ]);

        // $validatedData['idprov'] = $validatedData['provinsi'];
        // $validatedData['idkab'] = $validatedData['kabupaten'];
        // $validatedData['idkec'] = $validatedData['kecamatan'];
        // $validatedData['idkel'] = $validatedData['kelurahan'];
        // $validatedData['idlokasijenis'] = $validatedData['Jenis_lokasi'];
  
        $wp_lokasi                  = WP_lokasi::find($id);
        $wp_lokasi->idprov          = $validatedData['idprov'];
        $wp_lokasi->idkab           = $validatedData['idkab'];
        $wp_lokasi->idkec           = $validatedData['kecamatan'];
        $wp_lokasi->idkel           = $validatedData['kelurahan'];
        $wp_lokasi->alamat_lokasi   = $validatedData['alamat_lokasi'];
        $wp_lokasi->kode_pos        = $validatedData['kode_pos'];
        $wp_lokasi->nama_lokasi     = $validatedData['nama_lokasi'];
        $wp_lokasi->idlokasijenis   = $validatedData['idlokasijenis'];
        $wp_lokasi->catatan         = $validatedData['catatan'];
        $wp_lokasi->save();

        // dd($wp_lokasi);
  
        return redirect()->route('detail_lokasi', ['id' => $id]);
    }

    public function edit_foto_lokasi($id) {
        $page = 'Ubah Lokasi Pengambilan';
        $wp_lokasi = DB::table('wp_lokasi')->where('id', $id)->first();
        return view('edit_foto_lokasi', compact('page','wp_lokasi'));
    }

    public function update_foto_lokasi(Request $request, $id)
    {
        $request->validate([
            'foto_lama'   => 'nullable',
            'foto_lokasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if (isset($request->foto_lokasi)) {
            $fileName = time() . '_' . request()->foto_lokasi->getClientOriginalName();
            $destination = 'public/img/wp_lokasi/foto_lokasi';
            $request->file('foto_lokasi')->move($destination, $fileName);
        } else {
            $fileName = null;
        }

        if (isset($request->foto_lama)) {
            unlink(public_path('img/wp_lokasi/foto_lokasi/'.$request->foto_lama.''));
        }

        $wp_lokasi              = WP_lokasi::find($id);
        $wp_lokasi->foto_lokasi = $fileName;
        $wp_lokasi->save();

        return redirect()->route('detail_lokasi', ['id' => $id]);
    }

    public function edit_denah_lokasi($id) {
        $page = 'Ubah Denah Lokasi';
        $wp_lokasi = DB::table('wp_lokasi')->where('id', $id)->first();
        return view('edit_denah_lokasi', compact('page','wp_lokasi'));
    }

    public function update_denah_lokasi(Request $request, $id)
    {
        $request->validate([
            // 'foto_lama'   => 'nullable',
            // 'lampiran_denah' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'lokasi_x' => 'required',
            'lokasi_y' => 'required',
        ]);

        // if (isset($request->lampiran_denah)) {
        //     $fileName = time() . '_' . request()->lampiran_denah->getClientOriginalName();
        //     $destination = 'public/img/wp_lokasi/lampiran_denah';
        //     $request->file('lampiran_denah')->move($destination, $fileName);
        // } else {
        //     $fileName = null;
        // }

        // if (isset($request->foto_lama)) {
        //     unlink(public_path('img/wp_lokasi/lampiran_denah/'.$request->foto_lama.''));
        // }

        $wp_lokasi                  = WP_lokasi::find($id);
        // $wp_lokasi->lampiran_denah  = $fileName;
        $wp_lokasi->lokasi_x        = $request->lokasi_x;
        $wp_lokasi->lokasi_y        = $request->lokasi_y;
        $wp_lokasi->save();

        return redirect()->route('detail_lokasi', ['id' => $id]);
    }

    public function hapus_lokasi(Request $request, $id) {
        // $wp_lokasi = DB::table('wp_lokasi')->where('id', $id)->first();
        // if (isset($wp_lokasi->lampiran_denah)) {
        //     unlink(public_path('img/wp_lokasi/lampiran_denah/'.$wp_lokasi->lampiran_denah.''));
        // }
        // if (isset($wp_lokasi->foto_lokasi)) {
        //     unlink(public_path('img/wp_lokasi/foto_lokasi/'.$wp_lokasi->foto_lokasi.''));
        // }
        // DB::table('wp_lokasi')->delete($id);
        $request->validate([
            'alasan'   => 'required',
            // 'password' => 'required',
        ]);

        // dd(Hash::make($request->password));

        // if (Hash::check('password', Hash::make($request->password))) {
            $wp_lokasi          = WP_lokasi::find($id);
            $wp_lokasi->hapus   = '1';
            $wp_lokasi->save();

            Alasan_lokasi::Create([
                'id_lokasi'     =>  $id,
                'alasan'        =>  $request->alasan,
                'waktu_catat'   =>  Carbon::now(),
            ]);

        //     return redirect()->route('profile')->with('success', 'Hapus Lokasi Pengambilan Berhasil');
        // }
        // return redirect()->route('profile')->with('error', 'Kata Sandi Tidak Sesuai');
        return redirect()->route('profile')->with('success', 'Hapus Lokasi Pengambilan Berhasil');
    }

    public function nonaktifkan_lokasi($id) {
        $wp_lokasi          = WP_lokasi::find($id);
        $wp_lokasi->aktif   = 'N';
        $wp_lokasi->save();
        return redirect()->route('profile');
    }

    public function aktifkan_lokasi($id) {
        $wp_lokasi          = WP_lokasi::find($id);
        $wp_lokasi->aktif   = 'Y';
        $wp_lokasi->save();
        return redirect()->route('profile');
    }

    public function edit_ktp() {
        $page = 'Ubah Berkas KTP';
        $back = 'profile';
        $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
        return view('edit_ktp', compact('back','page','user'));
    }

    public function update_ktp(Request $request)
    {
            $request->validate([
                'foto_lama' => 'required',
                'ktp' => 'nullable|image|mimes:jpeg,png,jpg,svg',
                'no_ktp' => 'required|unique:uns_user,no_ktp,'.auth()->user()->id,
            ]);

            if(isset($request->ktp)){
                $fileName = "ktp-" . time() . '_' . request()->ktp->getClientOriginalName();
                $destination = 'public/img/ktp';
                $request->file('ktp')->move($destination, $fileName);
                unlink(public_path('img/ktp/'.$request->foto_lama.''));
            } else {
                $fileName = $request->foto_lama;
            }

            $user           = User::find(auth()->user()->id);
            $user->ktp      = $fileName;
            $user->no_ktp   = $request->no_ktp;
            $user->save();
 
        return redirect()->route('profile');
    }

    public function ajukan_verifikasi($id) {
        $user           = User::find($id);
        $user->verified = '1';
        $user->save();
        return redirect()->route('profile');
    }

    public function hapus_akun() {
        $page = 'Hapus Akun';
        $back = 'profile';
        return view('hapus_akun', compact('back','page'));
    }

    public function post_hapus_akun_old(Request $request) {
        $request->validate([
            'username'  =>  'required',
            'password'  =>  'required',
        ]);
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $id = auth()->user()->id;
            $user_raw = User::where('uns_user.id',$id);
            $user = $user_raw->first();
            $lokasi = db::table('wp_lokasi')->where('wp_lokasi.wp_id',$id)->get();
            $paskas = db::table('paskas')->where('wp_id',$id)->get();
            $sebar = db::table('sebar')->where('wp_id',$id)->get();
            unlink(public_path('img/ktp/'.$user->ktp.''));
            unlink(public_path('img/foto/'.$user->foto_diri.''));
            foreach($lokasi as $loc){
                unlink(public_path('img/wp_lokasi/foto_lokasi/'.$loc->foto_lokasi.''));
                unlink(public_path('img/wp_lokasi/lampiran_denah/'.$loc->lampiran_denah.''));
            }
            foreach($paskas as $pask){
                unlink(public_path('img/paskas/'.$pask->foto.''));
            }
            foreach($sebar as $seb){
                unlink(public_path('img/sebar/'.$seb->foto.''));
            }
            // dd($id);
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            $user->delete();
    
            return redirect()->route('login')->with('success', 'Akun berhasil terhapus!');
        }
        return back()->with('error', 'Nomor WhatsApp atau Kata Sandi Salah');
    }

    public function post_hapus_akun(Request $request, $id) {
        $own_id = $id;
        $request->validate([
            'username'  =>  'required',
            'password'  =>  'required',
        ]);
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // dd(auth()->user());
            $idnew = auth()->user()->id;
            // dd($idnew, $own_id, $idnew == $own_id);
            if($idnew == $own_id){
                $user = User::where('id',$id)->first();
                $user->delete = 'ya';
                $user->save();
                // Hapus_Akun::Create([
                //     'id_user'           => $id,
                //     'tanggal_hapus'     => Carbon::now()
                // ]);
                // User::
    
                // $exist_paskas = db::table('paskas')->where('wp_id',$id)->count();
                // $exist_sebar = db::table('sebar')->where('wp_id',$id)->count();
                // // dd($exist_paskas,$exist_sebar);
                // if($exist_paskas > 0){
                //     $paskas = Paskas::where('wp_id',$id)->update(['hapus' => '1']);
                // } 
                
                // if($exist_sebar > 0){
                //     $sebar = Sebar::where('wp_id',$id)->update(['hapus' => '1']);
                // }
                
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            } else {
                return back()->with('error', 'Nomor WhatsApp atau Kata Sandi Salah');
            }
            return redirect()->route('login')->with('success', 'Permintaan hapus akun terkirim');
        }
        return back()->with('error', 'Nomor WhatsApp atau Kata Sandi Salah');
    }
}
