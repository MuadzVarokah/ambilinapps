<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
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
use App\Models\Harga_lama;
use App\Models\Harga_Pelapak;
use App\Models\Hapus_akun;
use App\Models\Kat_user;
use App\Models\Lupa_password;
use App\Models\Lokasi_jenis;
use App\Models\Notifikasi;
use App\Models\Notifikasi_Raw;
use App\Models\Pangkat;
use App\Models\Paskas;
use App\Models\Rating;
use App\Models\Sebar;
use App\Models\Waste_date;
use App\Models\Waste_time;
use App\Models\WP_Lokasi;
use App\Models\Paskas_ditolak;
use App\Models\Sebar_ditolak;
use App\Http\Controllers\notificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class operator_postController extends BaseController
{
    protected $notificationController;
    public function __construct(notificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    /* user */
    public function edit_user(Request $req)
    { //use input type hidden for id and back
        $req->validate([
            'id'                => 'nullable', //hidden, default = 'new'
            'back'              => 'nullable', //hidden, no_default, not_null
            'username'          => 'required',
            'no_wa'             => 'required',
            'verified'          => 'required',
            'kat_user'          => 'required',
            'email'             => 'nullable',
            // 'harga_produk'      => 'required',
            'nama'              => 'required',
            'nama_lengkap'      => 'required',
            'tgl_lahir'         => 'required',
            'sex'               => 'nullable',
            'idpekerjaan'       => 'nullable',
            'idpendidikan'      => 'nullable',
            'alamat_lokasi'     => 'required',
            'idprov'            => 'nullable',
            'idkab'             => 'nullable',
            'idkec'             => 'nullable',
            'idkel'             => 'nullable',
            'kodepos'           => 'nullable',
            // 'foto_diri'         => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'no_ktp'            => 'required',
            // 'ktp'               => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'kta'               => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            // 'no_rek'         => 'nullable',
            // 'idbank'         => 'nullable',
            // 'an_rek'         => 'required',
        ]);
        if ($req->id == 'new') {
            $idnew = null;
        } else {
            $idnew = $req->id;
        }

        /* move files */
        if (!empty(request()->file('ktp'))) {
            $ktpName = "ktp-" . time() . '_' . request()->file('ktp')->getClientOriginalName();
            $ktpdestination = 'public/img/ktp';
            $req->file('ktp')->move($ktpdestination, $ktpName);
        } else {
            $ktpName = null;
        }

        if (!empty(request()->file('kta'))) {
            $ktaName = "kta-" . time() . '_' . request()->file('kta')->getClientOriginalName();
            $ktadestination = 'public/img/kta';
            $req->file('kta')->move($ktadestination, $ktaName);
        } else {
            $ktaName = null;
        }

        if (!empty(request()->file('foto_diri'))) {
            $fotoName = "foto-" . time() . '_' . request()->file('foto_diri')->getClientOriginalName();
            $fotodestination = 'public/img/foto';
            $req->file('foto_diri')->move($fotodestination, $fotoName);
        } else {
            $fotoName = null;
        }

        if (empty($req->sex)) {
            if (empty($req->oldsex)) {
                $gender = null;
            } else {
                $gender = $req->oldsex;
            }
        } else {
            $gender = $req->sex;
        }

        // if(empty($req->idprov)){
        //     $prov = null;
        // } else {
        //     $prov = $req->idprov;
        // }
        // if(empty($req->idkab)){
        //     $kab = null;
        // } else {
        //     $kab = $req->kab;
        // }
        // if(empty($req->idkec)){
        //     $prov = null;
        // } else {
        //     $prov = $req->kab;
        // }
        // if(empty($req->kab)){
        //     $prov = null;
        // } else {
        //     $prov = $req->kab;
        // }

        /* move files end */
        $data = User::updateOrInsert(
            ['id' => $idnew],
            [
                'username'         => $req->username,
                'no_wa'             => $req->no_wa,
                'verified'          => $req->verified,
                'kat_user'          => $req->kat_user,
                'email'             => $req->email,
                // 'harga_produk'      => $req->harga_produk,
                'nama'              => $req->nama,
                'nama_lengkap'      => $req->nama_lengkap,
                'tgl_lahir'         => $req->tgl_lahir,
                'sex'               => $gender,
                'idpekerjaan'       => $req->idpekerjaan,
                'idpendidikan'      => $req->idpendidikan,
                'alamat_lokasi'     => $req->alamat_lokasi,
                'idprov'            => $req->idprov,
                'idkab'             => $req->idkab,
                'idkec'             => $req->idkec,
                'idkel'             => $req->idkel,
                'kodepos'           => $req->kodepos,
                'foto_diri'         => $fotoName,
                'no_ktp'            => $req->no_ktp,
                'ktp'               => $ktpName,
                'kta'               => $ktaName
            ]
        );
        if (!empty($req->jenis)) {
            return redirect()->route($req->back, ['jenis' => $req->jenis])->with('success', 'data berhasil disimpan');
        } else {
            return redirect()->route($req->back)->with('success', 'data berhasil disimpan');
        }
    }

    public function toggle_user($id, Request $req)
    {
        $user = User::where('id', $id)->first();
        if ($user->delete == 'tidak') {
            $user->delete = 'ya';
        } else {
            $user->delete = 'tidak';
        }
        $user->save();
        // dd(get_defined_vars(), $req->jenis);
        return redirect()->route('mitra_new-operator', ['jenis' => $req->jenis])->with('warning', 'mitra ' . $user->nama . ' berhasil dinonaktifkan');
    }

    public function verif_user($id, Request $req)
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $verif = $req->verifikasi;
        $user = User::where('id', $id)->first();
        $user->verified = $req->verifikasi;
        $user->save();
        if ($req->verifikasi == 2) {
            $notif = 1;
        } elseif ($req->verifikasi == 3) {
            $notif = 3;
        }
        Notifikasi::create([
            "id_user"       => $id,
            "id_notif"      => $notif,
            "waktu_catat"   => $now,
        ]);
        if ($req->verifikasi == 2) {
            $toast = 'success';
            $message = 'diterima';
        } else {
            $toast = 'warning';
            $message = 'ditolak';
        }
        // dd(get_defined_vars(), $req->jenis);

        $device_token = User::where('id', $id)->pluck('device_token')->first();
        if ($device_token) {
            $title_notif    = "Profil";
            $message_notif  = "Selamat, akun anda telah diverivikasi";
            $url_notif      = route('dashboard');
            $this->notificationController->send_notification_FCM($device_token, $title_notif, $message_notif, $url_notif);
        }

        return redirect()->route('mitra_verifying-operator', ['jenis' => $req->jenis])->with($toast, 'verifikasi mitra ' . $user->nama . ' berhasil ' . $message);
    }

    public function verif_rating($id, Request $req)
    {
        $valid = $req->validasi;
        $rating = Rating::where('id', $id);
        $rating->valid = $valid;
        $rating->save();
        return route()->with('validasi berhasil tersimpan');
    }

    public function del_rank($id)
    {
        Pangkat::where('id', $id)->delete();
        return redirect()->route('gamifikasi-operator')->with('warning', 'pangkat berhasil dihapus');
    }

    public function edit_rank(Request $req)
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $req->validate([
            'pangkat'       => 'required',
            'pangkat_pendek' => 'required',
            'jumlah'        => 'required'
        ]);
        if ($req->id == 'new') {
            $idnew = null;
            $toast = 'success';
            $pesan = 'data berhasil ditambahkan';
            Notifikasi::create([
                "id_user"       => null,
                "id_notif"      => 9,
                "waktu_catat"   => $now,
            ]);
        } else {
            $idnew = $req->id;
            $toast = 'warning';
            $pesan = 'data berhasil diubah';
        }
        Pangkat::updateOrInsert(['id' => $idnew], [
            'pangkat'       => $req->pangkat,
            'jumlah_ambilin' => $req->jumlah,
            'pangkat_pendek' => $req->pangkat_pendek,
        ]);
        return redirect()->route('gamifikasi-operator')->with($toast, $pesan);
    }
    /* user end */


    /* kat user */
    public function tambah_kat(Request $req)
    { //use input type hidden for id
        $req->validate([
            'id'                => 'nullable', //hidden, default = 'new'
            'kat'               => 'required',
            'min_berat'         => 'required',
        ]);

        if ($req->id == 'new') {
            $idnew = '';
        } else {
            $idnew = $req->id;
        }

        $data = Kat_user::updateOrInsert(
            ['id'       => $idnew],
            [
                'kat'      => $req->kat,
                'min_berat' => $req->min_berat
            ]
        );
        return redirect()->route('kategori_user-operator')->with('success', 'data berhasil disimpan');
    }
    /* kat user end*/


    /* lupa password */
    public function lupa_password($id)
    { //use open in new tab for button
        $data = Lupa_password::where('uns_lupa_password.id', $id)->join('uns_user', 'uns_user.id', 'uns_lupa_password.user_id')
            ->select('uns_lupa_password.*', 'uns_user.no_wa')->first();
        $text = rawurlencode('permintaan reset password anda telah kami terima. Silahkan buka laman ini untuk melanjutkan ' . $data->link);
        // dd($data);
        // $forgot           = Lupa_password::find($id);
        $data->status        = 2;
        $data->save();

        return redirect('https://api.whatsapp.com/send?phone=62' . substr($data->no_wa, 1) . '&text=' . $text . '');
    }
    /* lupa password end */


    /* hapus akun */
    public function nonaktifkan()
    { //use get with slug -> ?id=id_user&back=nama_route
        $id = implode('', Arr::flatten(request(['id'])));
        $user = User::find($id);
        $user->hapus = 'ya';
        $user->save();
        $back = implode('', Arr::flatten(request(['back'])));
        return redirect()->route($back)->with('success', 'data berhasil dinonaktifkan');
    }

    public function hapus_akun()
    { //use get with slug->?id=id_user
        $id = implode('', Arr::flatten(request(['id'])));
        Carbon::setLocale('id');
        $now  = Carbon::now();
        $data = User::where('id', $id)->first();
        $delete = Hapus_akun::create([
            'id_user'       => $data->id,
            'username'      => $data->username,
            'no_wa'         => $data->no_wa,
            'kat_user'      => $data->kat_user,
            'nama'          => $data->nama,
            'tanggal_hapus' => $now
        ]);
        User::find($id)->delete();
        return redirect()->route('hapus_akun-operator')->with('warning', 'data berhasil dihapus');
    }
    /* hapus akun end */


    /* ambilin */
    public function edit_ambilin($jenis, Request $req)
    {
        $req->validate([
            "tgl"     => "required",
            "waktu"   => "required",
        ]);

        if ($req->id == 'new') {
            $idnew = null;
        } else {
            $idnew = $req->id;
        }

        Ambilin::updateOrInsert(['id' => $idnew], [
            "tgl_ambil"     => $req->tgl,
            "waktu_ambil"   => $req->waktu,
        ]);

        $toast = 'warning';
        $message = "Data Ambilin " . $idnew . " berhasil disimpan";

        return redirect()->route('ambilin-operator', ['jenis' => $jenis])->with($toast, $message);
    }

    public function post_layanan(Request $req)
    { //use input type hidden for id
        if ($req->id == 'new') {
            $idnew = null;
            $toast = 'success';
            $pesan = 'data berhasil ditambahkan';
        } else {
            $idnew = $req->id;
            $toast = 'warning';
            $pesan = 'data berhasil diubah';
        }

        if ($req->jenis == 'tgl') {
            $req->validate([
                'id'                => 'nullable', //hidden, default = 'new'
                'tgl'               => 'required',
                'aktif'             => 'nullable',
            ]);
            $back = 'tanggal_layanan-operator';
            Waste_date::updateOrInsert(
                ['id' => $idnew],
                [
                    'tgl' => $req->tgl,
                    'aktif' => $req->aktif
                ]
            );
        } elseif ($req->jenis == 'waktu') {
            $req->validate([
                'id'                => 'nullable', //hidden, default = 'new'
                'waktu'               => 'required',
                'aktif'             => 'nullable',
            ]);
            $back = 'waktu_layanan-operator';
            Waste_time::updateOrInsert(
                ['id' => $idnew],
                [
                    'waktu' => $req->waktu,
                    'aktif' => $req->aktif,
                ]
            );
        }
        return redirect()->route($back)->with($toast, $pesan);
    }

    public function toggle_layanan(Request $req)
    {
        if ($req->aktif == 'N') {
            $pesan  = "data berhasil dimatikan";
            $toast = "warning";
        } elseif ($req->aktif == 'Y') {
            $pesan = "data berhasil dinyalakan";
            $toast = 'success';
        }
        if ($req->jenis == 'tanggal') {
            $return = 'tanggal_layanan-operator';
            // dd(Waste_date::where('id', $req->id)->first());
            // Waste_date::where('id', $req->id)->delete();
            $data = Waste_date::where('id', $req->id)->first();
            $data->aktif = $req->aktif;
            $data->save();
        } elseif ($req->jenis == 'waktu') {
            $return = 'waktu_layanan-operator';
            // dd(Waste_time::where('id', $req->id)->first());
            // Waste_time::where('id', $req->id)->delete();
            $data = Waste_time::where('id', $req->id)->first();
            $data->aktif = $req->aktif;
            $data->save();
        }
        return redirect()->route($return)->with($toast, $pesan);
    }

    public function hapus_layanan()
    {
        if ($req->jenis == 'tanggal') {
            // dd(Waste_date::where('id', $req->id)->first());
            // Waste_date::where('id', $req->id)->delete();
            $data = Waste_date::where('id', $req->id)->delete();
        } elseif ($req->jenis == 'waktu') {
            // dd(Waste_time::where('id', $req->id)->first());
            // Waste_time::where('id', $req->id)->delete();
            $data = Waste_time::where('id', $req->id)->delete();
        }
        return redirect()->route('tanggal_layanan-operator')->with('warning', 'data berhasil dihapus');
    }

    public function delete_barkas($id, Request $req)
    {
        if ($req->delete == 'ambilin') {
            $data = Ambilin::where('id', $id)->first();
            // dd($data, $req->jenis, $id, $req->delete);
            $data->hapus = 1;
            $data->status = 9;
            $data->save();
        } elseif ($req->delete == 'paskas') {
            $data = Paskas::where('id', $id)->first();
            // dd($data, $req->jenis, $id, $req->delete);
            $data->hapus = 1;
            $data->status = 9;
            $data->save();
        } elseif ($req->delete == 'sebar') {
            $data = Sebar::where('id', $id)->first();
            // dd($data, $req->jenis, $id, $req->delete);
            $data->hapus = 1;
            $data->status = 9;
            $data->save();
        }

        $device_token = User::where('id', $data->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title_notif    = ucfirst($req->delete);
            $message_notif  = ucfirst($req->delete) . " anda telah dihapus";
            $url_notif      = route('dashboard');
            $this->notificationController->send_notification_FCM($device_token, $title_notif, $message_notif, $url_notif);
        }

        return redirect()->route('ambilin-operator', ['jenis' => $req->jenis])->with('warning', '' . $req->delete . ' id ' . $id . ' berhasil dipending  untuk penghapusan');
    }

    public function set_kolektor(Request $req)
    {
        // dd($req);
        Carbon::setLocale('id');
        $now = Carbon::now();
        $data = Ambilin::where('id', $req->id_ambilin)->first();

        if ($data->status == 1 || ($data->status == 2 && $req->id != 'new')) {
            $data->status = 2;
            $data->save();
        } else {
            if ($data->status == 2) {
                $reason = 'terbooking';
            } elseif ($data->status == 3) {
                $reason = 'terambil';
            } elseif ($data->status == 4) {
                $reason = 'dibatalkan pemilik';
            } elseif ($data->status == 9) {
                $reason = 'dihapus pemilik';
            }
            return redirect()->route('ambilin-operator', ['jenis' => $req->jenis])->with('danger', 'ambilin id ' . $req->id_ambilin . 'telah' . $reason);
        }

        if ($req->id == 'new') {
            $newid = null;
        } else {
            $newid = $req->id;
        }

        Booking::updateorinsert(['id' => $newid], [
            'ambilin_id'    => $req->id_ambilin,
            'kolektor_id'   => $req->id_kolektor,
            'waktu_catat'   => $now,
        ]);
        Notifikasi::create([
            "id_user"       => $req->id_user,
            "id_notif"      => 2,
            "waktu_catat"   => $now,
        ]);

        $device_token = User::where('id', $data->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title      = "Ambilin";
            $message    = "Permintaan Ambilin anda diterima oleh kolektor, silahkan tunggu sampah anda diambil";
            $url_notif  = route('ambilin');
            $this->notificationController->send_notification_FCM($device_token, $title, $message, $url_notif);
        }

        return redirect()->route('ambilin-operator', ['jenis' => $req->jenis])->with('warning', 'ambilin id ' . $req->id_ambilin . ' berhasil dibooking');
    }
    /* ambilin end */


    /* barkas */
    public function verifikasi_barkas(Request $req)
    {
        // dd($req);
        Carbon::setLocale('id');
        $now = Carbon::now();
        if ($req->back == 'ambilin') {
            $data = Ambilin::where('id', $req->id)->first();
            if ($req->verif == 'ditolak') {
                $data->verifikasi = 'ditolak';
                $data->save();
                $toast = 'warning';
                $notif = 8;
                $pesan = 'verifikasi berhasil ditolak';
                $status = 'ditolak';
            } elseif ($req->verif == 'diterima') {
                $data->verifikasi = 'diterima';
                $data->save();
                $notif = 2;
                $toast = 'success';
                $pesan = 'verifikasi berhasil diterima';
                $status = 'diterima';
            }
            $rute = 'ambilin-operator';
            // dd($req, $data, $toast, $pesan);
            // $data->verifikasi = $req->verif;
            // $data->save();
        } elseif ($req->back == 'paskas') {
            $data = Paskas::where('id', $req->id)->first();
            if ($req->verif == '3') {
                $data->status_publikasi = '3';
                $data->save();
                $notif = 6;
                $toast = 'warning';
                $pesan = 'verifikasi berhasil ditolak';
                $status = 'ditolak';
            } elseif ($req->verif == '2') {
                $data->status_publikasi = '2';
                $data->save();
                $notif = 3;
                $toast = 'success';
                $pesan = 'verifikasi berhasil diterima';
                $status = 'diterima';
            }
            $rute = 'barkas-operator';
            // dd($req, $data, $toast, $pesan);
            $data->status_publikasi = $req->verif;
            $data->save;
        } elseif ($req->back == 'sebar') {
            $data = Sebar::where('id', $req->id)->first();
            if ($req->verif == '3') {
                $data->status_publikasi = '3';
                $data->save();
                $notif = 7;
                $toast = 'warning';
                $pesan = 'verifikasi berhasil ditolak';
                $status = 'ditolak';
            } elseif ($req->verif == '2') {
                $notif = 4;
                $data->status_publikasi = '2';
                $data->save();
                $toast = 'success';
                $pesan = 'verifikasi berhasil diterima';
                $status = 'diterima';
            }
            $rute = 'barkas-operator';
            // dd($req, $data, $toast, $pesan);
            $data->status_publikasi = $req->verif;
            $data->save;
        }
        Notifikasi::create([
            "id_user"       => $req->id_user,
            "id_notif"      => $notif,
            "waktu_catat"   => $now,
        ]);

        $device_token = User::where('id', $data->wp_id)->pluck('device_token')->first();
        if ($device_token) {
            $title_notif    = ucfirst($req->back);
            $message_notif  = "Permintaan " . $req->back . " anda " . $status;
            $url_notif      = route('ambilin');
            $this->notificationController->send_notification_FCM($device_token, $title_notif, $message_notif, $url_notif);
        }

        return redirect()->route($rute, ['jenis' => $req->jenis, 'status' => $req->status])->with($toast, $pesan);
    }

    public function tolak_barkas(Request $req)
    {
        $req->validate([
            'fitur'         => 'required', 
            'id'            => 'required', 
            'id_user'       => 'required', 
            'status'        => 'required', 
            'alasan_tolak'  => 'required', 
        ]);

        Carbon::setLocale('id');
        $now = Carbon::now();

        if ($req->fitur == 'paskas') {
            Paskas_ditolak::create([
                'paskas_id'     => $req->id,
                'alasan'        => $req->alasan_tolak,
                'status'        => 1,
                'waktu_catat'   => $now,
            ]);
        } elseif ($req->fitur == 'sebar') {
            Sebar_ditolak::create([
                'sebar_id'     => $req->id,
                'alasan'        => $req->alasan_tolak,
                'status'        => 1,
                'waktu_catat'   => $now,
            ]);
        }

        return redirect(route('ambilin-verif').'?id='.$req->id.'&back='.$req->fitur.'&jenis='.$req->fitur.'&status='.$req->status.'&verif=3&id_user='.$req->id_user);
    }
    /* barkas end */


    /* harga */
    public function post_harga(Request $req)
    { //use input type hidden for id
        Carbon::setLocale('id');
        $now = Carbon::now();
        if (!empty(request()->file('foto'))) {
            $fotoName = "" . time() . '_' . request()->file('foto')->getClientOriginalName();
            $destination = '../berkas';
            $req->file('foto')->move($destination, $fotoName);
        } elseif (!empty($req->foto)) {
            $fotoName = $req->foto;
        } else {
            $fotoName = null;
        }

        if($req->id == 'new'){
            if($req->kat_user == '1'){
                $req->mitra = "mitra";
            } elseif($req->kat_user == '2') {
                $req->mitra = "kolektor";
            } elseif($req->kat_user == '3') {
                $req->mitra = "bank sampah";
            } elseif($req->kat_user == '4') {
                $req->mitra = "pelapak";
            }
        }

        // dd($req);
        if ($req->mitra == "pelapak" || $req->kat_user == '4') {
            $req->mitra = "pelapak";
            $req->validate([
                'id'            => 'nullable', //hidden, default = 'new'
                'nama'          => 'required',
                'harga_down'    => 'required',
                'harga_top'     => 'required'
            ]);


            if ($req->id == 'new') {
                $idnew = null;
                $toast = 'success';
                $pesan = "data berhasil ditambahkan, silahkan aktifkan harga terlebih dahulu";
                $aktif = '0';
            } else {
                $idnew = $req->id;
                $toast = 'warning';
                $pesan = 'data berhasil diubah';
                $aktif = $req->aktif;
                // $oldfoto = Harga_Pelapak::
            }
            
            Harga_Pelapak::updateorinsert(
                ['id' => $idnew],
                [
                    'foto'          => $fotoName,
                    'nama'          => $req->nama,
                    'harga_down'    => $req->harga_down,
                    'harga_top'      => $req->harga_top,
                    'aktif'         => $aktif,
                    'waktu_catat'   => $now,
                ]
            );

        } elseif($req->mitra != "pelapak") {
            $req->validate([
                'id'            => 'nullable', //hidden, default = 'new'
                'kat_user'      => 'required',
                'nama'          => 'required',
                // 'berat_poin'    => 'nullable',
                'harga_down'    => 'required',
                'harga_top'     => 'required'
            ]);

            if ($req->id == 'new') {
                $idnew = null;
                $toast = 'success';
                $pesan = "data berhasil ditambahkan, silahkan aktifkan harga terlebih dahulu";
                $aktif = '0';
            } else {
                $idnew = $req->id;
                $toast = 'warning';
                $pesan = 'data berhasil diubah';
                $aktif = $req->aktif;

                Harga_lama::create([
                    'id'            => null,
                    'id_waste'      => $req->id,
                    'waktu_catat'   => $now,
                    'old_top'       => $req->old_top,
                    'old_down'      => $req->old_down,
                ]);
            }

            Harga::updateorinsert(
                ['id' => $idnew],
                [
                    'kat_user'      => $req->kat_user,
                    'foto'          => $fotoName,
                    'nama'          => $req->nama,
                    'berat_poin'    => $req->berat_poin,
                    'harga_down'    => $req->harga_down,
                    'harga_top'      => $req->harga_top,
                    'aktif'         => $aktif,
                    'waktu_catat'   => $now,
                ]
            );
        }

        $to     = $req->mitra;
        $back   = 'harga_sampah_mitra-operator';
        return redirect()->route($back, ["mitra" => $to])->with($toast, $pesan);
    }

    public function toggle_harga(Request $req)
    {
        $back = 'harga_sampah_mitra-operator';
        if($req->jenis == 'pelapak'){
            $data_raw = Harga_Pelapak::where('id', $req->id);
        } else{
            $data_raw = Harga::where('id', $req->id);
        }
        $data = $data_raw->first();
        if ($data->aktif == '1') {
            $data->aktif = '0';
            $toast = 'warning';
            $pesan = 'harga berhasil dinonaktifkan';
        } else {
            $data->aktif = '1';
            $toast = 'success';
            $pesan = 'harga berhasil diaktifkan';
        }
        $data->save();
        // dd($data, file_exists('../berkas/'.$data->foto));        
        // if (!empty($data->foto) && file_exists('../berkas/'.$data->foto)) {
        //     unlink(public_path('../berkas/' . $data->foto . ''));
        // }
        // $data_raw->delete();
        return redirect()->route($back, ["mitra" => $req->jenis])->with($toast, $pesan);
    }
    /* harga end */

    /* wp_lokasi */
    public function toggle_lokasi(Request $req, $jenis)
    {
        $data = WP_Lokasi::where('id', $req->id)->first();
        $data->aktif = $req->aktif;
        // dd($data);
        $data->save();
        return redirect()->route('wp_lokasi-operator', ['jenis' => $jenis])->with('warning', 'data berhasil dinonaktifkan');
    }

    public function confirm_hapus_lokasi()
    {
        return redirect()->route()->with('warning', 'data berhasil dihapus');
    }

    public function hapus_lokasi(Request $req, $jenis)
    {
        $data = WP_Lokasi::where('id', $req->id)->first();
        $data->hapus = "1";
        $data->save();
        return redirect()->route('wp_lokasi-operator', ['jenis' => $jenis])->with('warning', 'data berhasil dihapus');
    }

    public function post_lokasi_jenis(Request $req)
    {
        $req->validate([
            'id'         => 'nullable', //hidden, default = 'new'
            'jenis'      => 'required',
        ]);

        if ($req->id == 'new') {
            $idnew = null;
            $toast = 'success';
            $pesan = 'jenis lokasi berhasil ditambahkan';
        } else {
            $idnew = $req->id;
            $toast = 'warning';
            $pesan = 'jenis lokasi berhasil diubah';
        }

        Lokasi_jenis::updateOrInsert(
            ['id' => $idnew],
            ['jenis_lokasi'    => $req->jenis]
        );
        return redirect()->route('wp_lokasijenis-operator')->with($toast, $pesan);
    }
    /* wp_lokasi_end */

    public function post_notif_raw(Request $req)
    {
        $req->validate([
            'judul' => 'required|max:255',
            'isi'   => 'required|max:255',
            'theme' => 'required',
        ]);

        $edit = Notifikasi_Raw::where('id', $req->id)->first();
        $edit->judul    = $req->judul;
        $edit->isi      = $req->isi;
        $edit->theme    = $req->theme;
        $edit->save();


        $toast = 'success';
        $pesan = "notifikasi berhasil diubah";
        return redirect()->route('notifikasi-operator')->with($toast, $pesan);
    }
}
