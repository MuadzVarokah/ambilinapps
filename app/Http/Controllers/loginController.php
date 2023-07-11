<?php
// if ($user->kat_user == 2) {
//     /* ambilin */
//     $sum_amb_raw = DB::table('uns_ambilin_booking')
//         ->where('uns_ambilin_booking.kolektor_id', auth()->user()->id)
//         ->join('ambilin', 'ambilin.id', 'uns_ambilin_booking.ambilin_id')
//         ->where('ambilin.status', 4);
//     $sum_amb = $sum_amb_raw->count();
//     $count_amb_raw = $sum_amb_raw
//         ->select('uns_ambilin_booking.id')
//         ->get();
//     $count_amb = count($count_amb_raw);
//     $level = DB::table('uns_pangkat')->where('jumlah_ambilin' ,'<=', $count_amb)->orderby('id','DESC')->first();
//     } elseif ($user->kat_user == 1) {
//     $sum_amb_raw = DB::table('ambilin')
//         ->where('ambilin.wp_id', auth()->user()->id);
//     $sum_amb = $sum_amb_raw->count();
//     $count_amb_raw = $sum_amb_raw
//         ->where('ambilin.status', 4)
//         ->select('id')
//         ->get();
//     $count_amb = count($count_amb_raw);
//     $level = DB::table('uns_pangkat')->where('jumlah_ambilin' ,'<=', $count_amb)->orderby('id','DESC')->first();
//     }

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Models\Forgot;
use Carbon\Carbon;

class loginController extends Controller
{
    public function index()
    {
        Cache::flush();
        return view('index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username'  =>  'required',
            'password'  =>  'required',
        ]);
        // dd('berhasil login');
        $remember_me = $request->has('remember') ? true : false;
        /* login as admin */
        // dd(!empty (auth()->user()->delete) == 'tidak') ;
        if (Auth::guard('weboperator')->attempt(['email' => $request->username, 'password' => $request->password])) {
            // dd(auth()->user());
            $request->session()->regenerate();
            return redirect()->route('index-operator');
        }
        // elseif (Auth::guard('weboperator')->attempt(['id_login' => $request->username, 'password' => $request->password], $remember_me)) {
        //     $request->session()->regenerate();
        //     return redirect()->route('admin');
        // }

        /* login as pleb */ elseif (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember_me)) {
            // dd(auth()->user()->delete, auth()->user()->delete == 'tidak') ;
            if (auth()->user()->delete == 'ya') {
                $admin = db::table('ngadminin')->where('aktif', 'ya')->whereNotNull('no_wa')->inRandomOrder()->pluck('no_wa')->first();
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return back()->with('loginError', "akun anda sedang pending penghapusan.<br> Silahkan hubungi operator pada " . $admin . " jika anda merasa ini adalah kesalahan");
            } else {
                // $delete_check = db::table('uns_deleted_user')->where('id_user', auth()->user()->id)->count();
                // dd($delete_check < 1, auth()->user()->delete == 'tidak');
                // if (auth()->user()->delete == 'tidak') {
                // dd(auth()->user()->delete == 'tidak');
                $request->session()->regenerate();
                $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
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
                    $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('jumlah_ambilin', 'DESC')->first();
                } elseif ($user->kat_user != 2) {
                    $sum_amb_raw = DB::table('ambilin')
                        ->where('ambilin.wp_id', auth()->user()->id);
                    $sum_amb = $sum_amb_raw->count();
                    $count_amb_raw = $sum_amb_raw
                        ->where('ambilin.status', 3)
                        ->select('id')
                        ->get();
                    $count_amb = count($count_amb_raw);
                    $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('jumlah_ambilin', 'DESC')->first();
                }

                if (auth()->user()->delete == null) {
                    return redirect()->intended('dashboard')->with('notif', 'Selamat datang kembali ' . $level->pangkat . ' ' . $user->nama . '')->with('request_notif', 'Meminta izin untuk menampilkan notifikasi');
                } else {
                    return redirect()->intended('dashboard')->with('notif', 'Selamat datang kembali ' . $level->pangkat . ' ' . $user->nama . '');
                }
                // } else {
                //     return back()->with('loginError', "akun anda sedang pending penghapusan.\r\nHubungi admin jika anda merasa ini adalah kesalahan");
                // }
            }

            /* check if user is deleted */

            // if(){

        } elseif (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (auth()->user()->delete == 'ya') {
                $admin = db::table('ngadminin')->where('aktif', 'ya')->whereNotNull('no_wa')->inRandomOrder()->pluck('no_wa')->first();
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return back()->with('loginError', "akun anda sedang pending penghapusan.<br> Silahkan hubungi operator pada " . $admin . " jika anda merasa ini adalah kesalahan");
            } else {
                $request->session()->regenerate();
                $user = DB::table('uns_user')->where('id', auth()->user()->id)->first();
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
                    $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('jumlah_ambilin', 'DESC')->first();
                } elseif ($user->kat_user != 2) {
                    $sum_amb_raw = DB::table('ambilin')
                        ->where('ambilin.wp_id', auth()->user()->id);
                    $sum_amb = $sum_amb_raw->count();
                    $count_amb_raw = $sum_amb_raw
                        ->where('ambilin.status', 3)
                        ->select('id')
                        ->get();
                    $count_amb = count($count_amb_raw);
                    $level = DB::table('uns_pangkat')->where('jumlah_ambilin', '<=', $count_amb)->orderby('jumlah_ambilin', 'DESC')->first();
                }

                if (auth()->user()->delete == null) {
                    return redirect()->intended('dashboard')->with('notif', 'Selamat datang kembali ' . $level->pangkat . ' ' . $user->nama . '')->with('request_notif', 'Meminta izin untuk menampilkan notifikasi');
                } else {
                    return redirect()->intended('dashboard')->with('notif', 'Selamat datang kembali ' . $level->pangkat . ' ' . $user->nama . '');
                }
            
            }
            /* check if user is deleted */
            // $delete_check = db::table('uns_deleted_user')->where('id_user', auth()->user()->id)->count();
            // if ( auth()->user()->delete == 'tidak') {
            // dd(auth()->user()->delete == 'tidak');
            // } else {
            //     return back()->with('loginError', 'akun anda sedang pending penghapusan.\nHubungi admin jika anda merasa ini adalah kesalahan');
            // }
        }

        return back()->with('loginError', 'Nomor HP/KTA atau Password Salah');
        // return view('index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('');
    }

    public function laman_registrasi()
    {
        $page = 'Registrasi';
        $kat = db::table('uns_kat_user')->get();
        return view('registrasi', compact('page','kat'));
    }

    public function registrasi(Request $request)
    {
        // Validator::make($request->all(), [
        //     'nama'      => ['required'],
        //     'no_wa'     => ['required', 'unique:uns_user'],
        //     'password'  => ['required', 'confirmed', Password::min(6)],
        // ]);

        $request->validate([
            'nama'      => ['required'],
            'no_wa'     => ['required', 'unique:uns_user'],
            'password'  => ['required', 'confirmed', Password::min(6)],
            'kat_user'  => ['required'],
        ]);

        User::Create([
            'nama'          =>  $request->nama,
            'username'      =>  $request->no_wa,
            'no_wa'         =>  $request->no_wa,
            'password'      =>  Hash::make($request->password),
            'verified'      =>  0,
            'kat_user'      =>  $request->kat_user,
            'waktu_catat'   =>  Carbon::now(),
        ]);

        if (Auth::attempt(['username' => $request->no_wa, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('notif', 'Registrasi anda telah berhasil')->with('request_notif', 'Meminta izin untuk menampilkan notifikasi');
        }

        return redirect('')->with('success', 'Registrasi berhasil');

        // return request()->all();
    }

    public function forgot()
    {
        $page = 'Lupa Password?';
        return view('forgot', compact('page'));
    }

    public function post_forgot(Request $request)
    {
        $request->validate([
            'no_wa' => 'required',
        ]);

        $id = DB::table('uns_user')->where('no_wa', $request->no_wa)
            ->select('id')->first();

        $lupa = DB::table('uns_lupa_password')
            ->where('user_id', $id->id)->get();

        if ($id != null) {
            if ($lupa != null) {
                foreach ($lupa as $lupa) {
                    if ($lupa->status == 1) {
                        $forgot           = Forgot::find($lupa->id);
                        $forgot->status   = 0;
                        $forgot->save();
                    }
                }
            }
            $id_forgot = Forgot::Create([
                'user_id'    => $id->id,
                'status'     => 1,
                'token'      => Str::random(60),
            ])->id;

            $tokenData = DB::table('uns_lupa_password')
                ->where('id', $id_forgot)
                ->select('token')->first();

            // $hash_wa = md5($request->no_wa);

            // Encript
            $ciphering = "BF-CBC"; // Storingthe cipher method
            $iv_length = openssl_cipher_iv_length($ciphering); // Using OpenSSl Encryption method 
            $options   = 0;
            $encryption_iv = '12345678'; // Non-NULL Initialization Vector for encryption 
            $encryption_key = "Ambilin"; // Storing the encryption key 
            $encrypt_wa = urlencode(openssl_encrypt($request->no_wa, $ciphering, $encryption_key, $iv_length, $encryption_iv));
            // End Encript
            // $decryption_iv = '12345678'; // Non-NULL Initialization Vector for encryption 
            // $decryption_key = "Ambilin"; // Storing the encryption key 
            // $decrypt_wa = openssl_decrypt($encrypt_wa, $ciphering, $decryption_key, $options, $decryption_iv);
            // dd($encrypt_wa, $decrypt_wa);

            $link = 'https://ambilin.com/ambilinapps/lupa_password/' . $tokenData->token . '?q=' . $encrypt_wa;

            $lupa_pass  = Forgot::find($id_forgot);
            $lupa_pass->link    = $link;
            $lupa_pass->save();
            // dd($link);
            return redirect(route('login'))->with('success', 'Permintaan ganti kata sandi berhasil terkirim, tautan untuk mengganti kata sandi akan terkirim ke nomor WA anda setelah beberapa saat');
        } else {
            return redirect(route('forgot'))->with('error', 'Nomor WA tidak ditemukan');
        }
    }

    public function lupa_password(Request $request, $token)
    {
        if (($token != null) && ($request->q != null)) {
            // dd($request->q);
            $ciphering = "BF-CBC"; // Storingthe cipher method
            $iv_length = openssl_cipher_iv_length($ciphering); // Using OpenSSl Encryption method 
            $options   = 0;
            $decryption_iv = '12345678'; // Non-NULL Initialization Vector for encryption 
            $decryption_key = "Ambilin"; // Storing the encryption key 
            $decrypt_wa = openssl_decrypt($request->q, $ciphering, $decryption_key, $iv_length, $decryption_iv);

            // dd($decrypt_wa);

            $no_wa = DB::table('uns_user')->where('no_wa', $decrypt_wa)->get();
            $count_wa = $no_wa->count();

            if ($count_wa > 0) {

                $id = DB::table('uns_user')->where('no_wa', $decrypt_wa)
                    ->select('id')->first();
                $forgot = DB::table('uns_lupa_password')->where('user_id', $id->id)
                    ->latest()->first();

                if (isset($forgot->token)) {

                    if ($token == $forgot->token) {
                        $now = Carbon::now();
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $forgot->updated_at);
                        $tomorrow = $date->addDay()->format('Y-m-d H:i:s');

                        if ($now < $tomorrow) {
                            return view('lupa_password');
                        } else {
                            $forgot->status = 0;
                            $forgot->save();
                            return redirect(route('login'))->with('loginError', 'Session expired');
                        }
                    } else {
                        return redirect(route('login'))->with('loginError', 'Session invalid');
                    }
                } else {
                    return redirect(route('login'))->with('loginError', 'Session invalid');
                }
            } else {
                return redirect(route('login'))->with('loginError', 'Session invalid');
            }
        } else {
            return redirect(route('login'));
        }
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'no_wa'     => 'required',
            'q'         => 'required',
            'password'  => ['required', 'confirmed', Password::min(6)],
        ]);

        $ciphering = "BF-CBC"; // Storingthe cipher method
        $iv_length = openssl_cipher_iv_length($ciphering); // Using OpenSSl Encryption method 
        $options   = 0;
        $decryption_iv = '12345678'; // Non-NULL Initialization Vector for encryption 
        $decryption_key = "Ambilin"; // Storing the encryption key 
        $decrypt_wa = openssl_decrypt($request->q, $ciphering, $decryption_key, $options, $decryption_iv);

        $user = DB::table('uns_user')->where('no_wa', $request->no_wa)->first();

        if ($request->no_wa == $decrypt_wa) {
            // dd($request->q);
            // $tomorrow = Carbon::tomorrow();
            // dd($forgot);
            $update_pass                = User::find($user->id);
            $update_pass->password      = Hash::make($request->password);
            $update_pass->save();
            $forgot                     = Forgot::where('user_id',$user->id)->where('status',2)->orderby('created_at','desc')->first(); 
            $forgot->status             = 3;
            $forgot->save();
            return redirect(route('login'))->with('success', 'Kata sandi berhasil diubah');
        } else {
            return back()->with('error', 'Nomor WA tidak sesuai');
        }
    }

    public function reset_password()
    {
        $page = 'Ganti Password';
        return view('reset_password', compact('page'));
    }

    public function post_password(Request $request)
    {
        $request->validate([
            'password_lama'         => ['required', Password::min(6)],
            'password'              => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return redirect(route('reset_password'))->with('error', 'Password Salah');
        }

        if ($request->password_lama != $request->password) {
            $update_pass                = User::find(auth()->user()->id);
            $update_pass->password      = Hash::make($request->password);
            $update_pass->save();

            return redirect(route('dashboard'))->with('success', 'Kata sandi berhasil diubah');
        } else {
            return redirect(route('reset_password'))->with('error', 'Tidak dapat menggunakan kata sandi yang sama');
        }
    }

    public function savePushNotificationToken(Request $request)
    {
        // dd($request);
        $user               = User::find(auth()->user()->id);
        $user->device_token = $request->fcm_token;
        $user->save();
        //dTlhit6Zn78:APA91bGZ57fl19ehuPO4m3KIVGiKwfcYVR72if7e0xIR0t6Pjl9ia10TUv3rZQfvayK7jflRY6Z1Mpuk1APs8HnSFqBIFDkD1Z5u7Qg2eGuw63QD1Zy3TkcP8enrOfg1ucAs2tnccma3
        // auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token berhasil disimpan']);
    }
}
