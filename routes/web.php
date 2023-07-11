<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\loginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {return view('welcome');});

// login
Route::get('/', 'App\Http\Controllers\loginController@index')->name('login')->middleware('guest');
Route::post('/login', 'App\Http\Controllers\loginController@login');
Route::get('/logout', 'App\Http\Controllers\loginController@logout')->name('logout');
Route::get('/registrasi', 'App\Http\Controllers\loginController@laman_registrasi')->name('registrasi')->middleware('guest');
Route::post('/registrasi', 'App\Http\Controllers\loginController@registrasi')->middleware('guest');

Route::get('/forgot', 'App\Http\Controllers\loginController@forgot')->name('forgot')->middleware('guest');
Route::post('/forgot', 'App\Http\Controllers\loginController@post_forgot')->name('post_forgot')->middleware('guest');
Route::get('/lupa_password/{token}', 'App\Http\Controllers\loginController@lupa_password')->name('lupa_password');
Route::post('/update_password', 'App\Http\Controllers\loginController@update_password')->name('update_password');

Route::get('/reset', 'App\Http\Controllers\loginController@reset_password')->name('reset_password')->middleware('auth');
Route::post('/reset', 'App\Http\Controllers\loginController@post_password')->name('post_password')->middleware('auth');

Route::post('/save-push-notification-token', 'App\Http\Controllers\loginController@savePushNotificationToken')->name('save-push-notification-token')->middleware('auth');
Route::get('/send-notification', 'App\Http\Controllers\notificationController@send_notification_FCM')->name('send_notification')->middleware('auth');

// Profile
Route::get('/profile', 'App\Http\Controllers\profilController@index')->name('profile')->middleware('auth');
Route::get('/lengkapi-data-1', 'App\Http\Controllers\profilController@create_data_1')->name('create_data_1')->middleware('auth');
Route::post('/lengkapi-data-1', 'App\Http\Controllers\profilController@post_data_1')->name('post_data_1')->middleware('auth');
Route::get('/lengkapi-data-2', 'App\Http\Controllers\profilController@create_data_2')->name('create_data_2')->middleware('auth');
Route::post('/lengkapi-data-2', 'App\Http\Controllers\profilController@post_data_2')->name('post_data_2')->middleware('auth');
Route::get('/lengkapi-data-3', 'App\Http\Controllers\profilController@create_data_3')->name('create_data_3')->middleware('auth');
Route::post('/lengkapi-data-3', 'App\Http\Controllers\profilController@post_data_3')->name('post_data_3')->middleware('auth');
Route::post('/remove-ktp', 'App\Http\Controllers\profilController@remove_ktp')->name('remove_ktp')->middleware('auth');
Route::get('/lengkapi-data-4', 'App\Http\Controllers\profilController@create_data_4')->name('create_data_4')->middleware('auth');
Route::post('/lengkapi-data-4', 'App\Http\Controllers\profilController@post_data_4')->name('post_data_4')->middleware('auth');
Route::post('/remove-foto', 'App\Http\Controllers\profilController@remove_foto')->name('remove_foto')->middleware('auth');
Route::get('/lengkapi-data-5', 'App\Http\Controllers\profilController@create_data_5')->name('create_data_5')->middleware('auth');
Route::post('/lengkapi-data-5', 'App\Http\Controllers\profilController@post_data_5')->name('post_data_5')->middleware('auth');
Route::post('/back-to-profile', 'App\Http\Controllers\profilController@back_to_profile')->name('back_to_profile')->middleware('auth');
Route::post('/getkabupaten', 'App\Http\Controllers\profilController@getKabupaten')->name('getkabupaten');
Route::post('/getkecamatan', 'App\Http\Controllers\profilController@getKecamatan')->name('getkecamatan');
Route::post('/getkelurahan', 'App\Http\Controllers\profilController@getKelurahan')->name('getkelurahan');
Route::post('/getkelurahan2/{id}', 'App\Http\Controllers\profilController@getKelurahan2')->name('getkelurahan2');
Route::get('/edit-datadiri', 'App\Http\Controllers\profilController@edit_datadiri')->name('edit_datadiri')->middleware('auth');
Route::post('/edit-datadiri', 'App\Http\Controllers\profilController@update_datadiri')->name('update_datadiri')->middleware('auth');
Route::get('/edit-foto', 'App\Http\Controllers\profilController@edit_foto')->name('edit_foto')->middleware('auth');
Route::post('/edit-foto', 'App\Http\Controllers\profilController@update_foto')->name('update_foto')->middleware('auth');
Route::get('/edit-wa', 'App\Http\Controllers\profilController@edit_wa')->name('edit_wa')->middleware('auth');
Route::post('/edit-wa', 'App\Http\Controllers\profilController@update_wa')->name('update_wa')->middleware('auth');
Route::get('/edit-domisili', 'App\Http\Controllers\profilController@edit_domisili')->name('edit_domisili')->middleware('auth');
Route::post('/edit-domisili', 'App\Http\Controllers\profilController@update_domisili')->name('update_domisili')->middleware('auth');
Route::post('/getkabupaten3', 'App\Http\Controllers\profilController@getKabupaten3')->name('getkabupaten3');
Route::get('/tambah-lokasi-1', 'App\Http\Controllers\profilController@tambah_lokasi_1')->name('tambah_lokasi_1')->middleware('auth');
Route::post('/tambah-lokasi-1', 'App\Http\Controllers\profilController@post_lokasi_1')->name('post_lokasi_1')->middleware('auth');
Route::get('/tambah-lokasi-2', 'App\Http\Controllers\profilController@tambah_lokasi_2')->name('tambah_lokasi_2')->middleware('auth');
Route::post('/tambah-lokasi-2', 'App\Http\Controllers\profilController@post_lokasi_2')->name('post_lokasi_2')->middleware('auth');
Route::get('/tambah-lokasi-3', 'App\Http\Controllers\profilController@tambah_lokasi_3')->name('tambah_lokasi_3')->middleware('auth');
Route::post('/tambah-lokasi-3', 'App\Http\Controllers\profilController@post_lokasi_3')->name('post_lokasi_3')->middleware('auth');
Route::post('/remove-foto-lokasi', 'App\Http\Controllers\profilController@remove_foto_lokasi')->name('remove_foto_lokasi')->middleware('auth');
Route::get('/tambah-lokasi-4', 'App\Http\Controllers\profilController@tambah_lokasi_4')->name('tambah_lokasi_4')->middleware('auth');
Route::post('/tambah-lokasi-4', 'App\Http\Controllers\profilController@post_lokasi_4')->name('post_lokasi_4')->middleware('auth');
Route::post('/remove-lampiran_denah', 'App\Http\Controllers\profilController@remove_lampiran_denah')->name('remove_lampiran_denah')->middleware('auth');
Route::get('/detail-lokasi/{id}', 'App\Http\Controllers\profilController@detail_lokasi')->name('detail_lokasi')->middleware('auth');
Route::get('/edit-detail-lokasi/{id}', 'App\Http\Controllers\profilController@edit_detail_lokasi')->name('edit_detail_lokasi')->middleware('auth');
Route::post('/edit-detail-lokasi/{id}', 'App\Http\Controllers\profilController@post_detail_lokasi')->name('update_detail_lokasi')->middleware('auth');
Route::get('/edit-foto-lokasi/{id}', 'App\Http\Controllers\profilController@edit_foto_lokasi')->name('edit_foto_lokasi')->middleware('auth');
Route::post('/edit-foto-lokasi/{id}', 'App\Http\Controllers\profilController@update_foto_lokasi')->name('update_foto_lokasi')->middleware('auth');
Route::get('/edit-denah-lokasi/{id}', 'App\Http\Controllers\profilController@edit_denah_lokasi')->name('edit_denah_lokasi')->middleware('auth');
Route::post('/edit-denah-lokasi/{id}', 'App\Http\Controllers\profilController@update_denah_lokasi')->name('update_denah_lokasi')->middleware('auth');
Route::get('/nonaktifkan-lokasi/{id}', 'App\Http\Controllers\profilController@nonaktifkan_lokasi')->name('nonaktifkan_lokasi')->middleware('auth');
Route::get('/aktifkan-lokasi/{id}', 'App\Http\Controllers\profilController@aktifkan_lokasi')->name('aktifkan_lokasi')->middleware('auth');
Route::get('/edit-ktp', 'App\Http\Controllers\profilController@edit_ktp')->name('edit_ktp')->middleware('auth');
Route::post('/edit-ktp', 'App\Http\Controllers\profilController@update_ktp')->name('update_ktp')->middleware('auth');
Route::get('/ajukan-verifikasi/{id}', 'App\Http\Controllers\profilController@ajukan_verifikasi')->name('ajukan_verifikasi')->middleware('auth');
Route::get('/hapus-akun', 'App\Http\Controllers\profilController@hapus_akun')->name('hapus_akun')->middleware('auth');
Route::post('/hapus-akun/{id}', 'App\Http\Controllers\profilController@post_hapus_akun')->name('post_hapus_akun')->middleware('auth');
Route::post('/hapus-lokasi/{id}', 'App\Http\Controllers\profilController@hapus_lokasi')->name('hapus_lokasi')->middleware('auth');

/* Fitur */ 
Route::get('/dashboard', 'App\Http\Controllers\Controller@index')->name('dashboard')->middleware('auth');
Route::get('/chat-cek/{datetime}', 'App\Http\Controllers\Controller@chat_check')->name('cek-chat-menu');
Route::get('/notif-cek/{datetime}', 'App\Http\Controllers\Controller@notif_check')->name('cek-notif-menu');

Route::get('/jarak_tampil', 'App\Http\Controllers\Controller@jarak_tampil')->name('jarak_tampil')->middleware('auth');
Route::post('/jarak_tampil', 'App\Http\Controllers\Controller@post_jarak_tampil')->name('post_jarak_tampil')->middleware('auth');

Route::get('/epr', 'App\Http\Controllers\Controller@epr')->name('epr')->middleware('auth');
Route::get('/epr/{id}', 'App\Http\Controllers\Controller@epr_merek')->name('epr_induk')->middleware('auth');
Route::get('/epr/{id}/{id2}', 'App\Http\Controllers\Controller@epr_produk')->name('epr_produk')->middleware('auth');
Route::get('/harga', 'App\Http\Controllers\Controller@harga')->name('harga');
Route::get('/harga-mitra', 'App\Http\Controllers\Controller@harga_mitra')->name('harga_mitra')->middleware('auth');
Route::get('/harga-pelapak', 'App\Http\Controllers\Controller@harga_pelapak')->name('harga_pelapak')->middleware('auth');
Route::get('/harga-bs', 'App\Http\Controllers\Controller@harga_bs')->name('harga_bs')->middleware('auth');
Route::get('iframe/{link}','App\Http\Controllers\Controller@iframe')->name('iframe')->middleware('auth');
Route::get('/notifikasi','App\Http\Controllers\Controller@notifikasi')->name('notifikasi')->middleware('auth');

Route::get('/ambilin', 'App\Http\Controllers\ambilinController@ambilin')->name('ambilin')->middleware('auth');
Route::get('/ambilin-kolektor/{x}/{y}', 'App\Http\Controllers\ambilinController@ambilin_kolektor')->name('ambilin_kolektor')->middleware('auth');
Route::get('/ambilin-ambil/{id}', 'App\Http\Controllers\ambilinController@ambilin_ambil')->name('ambilin_ambil')->middleware('auth');
Route::get('/ambilin-baru', 'App\Http\Controllers\ambilinController@ambilin_baru')->name('ambilin_baru')->middleware('auth');
Route::post('/ambilin-baru', 'App\Http\Controllers\ambilinController@ambilin_post')->name('post_ambilin')->middleware('auth');
// Route::get('/ambilin-baru/{$id}', 'App\Http\Controllers\ambilinController@ambilin_edit')->name('ambilin_baru')->middleware('auth');
// Route::post('/ambilin-baru/{$id}', 'App\Http\Controllers\ambilinController@ambilin_edit_post')->name('post_ambilin')->middleware('auth');
Route::get('/ambilin-batal', 'App\Http\Controllers\ambilinController@ambilin_batal')->name('ambilin_batal')->middleware('auth');
Route::get('/ambilin-kolektor-dibatalkan/{x}/{y}', 'App\Http\Controllers\ambilinController@ambilin_kolektor_dibatalkan')->name('ambilin_kolektor_dibatalkan')->middleware('auth');
Route::get('/ambilin-edit/{id}', 'App\Http\Controllers\ambilinController@ambilin_edit')->name('ambilin_edit')->middleware('auth');
Route::post('/ambilin-post-gambar', 'App\Http\Controllers\ambilinController@ambilin_post_gambar')->name('ambilin_post_gambar')->middleware('auth');
Route::post('/ambilin-post-waktu', 'App\Http\Controllers\ambilinController@ambilin_post_waktu')->name('ambilin_post_waktu')->middleware('auth');
Route::post('/ambilin-post-lokasi', 'App\Http\Controllers\ambilinController@ambilin_post_lokasi')->name('ambilin_post_lokasi')->middleware('auth');
Route::post('/ambilin-post-deskripsi', 'App\Http\Controllers\ambilinController@ambilin_post_deskripsi')->name('ambilin_post_deskripsi')->middleware('auth');
Route::post('/ambilin-post-barang', 'App\Http\Controllers\ambilinController@ambilin_post_barang')->name('ambilin_post_barang')->middleware('auth');
Route::get('/ambilin-hapus-barang/{id_barang}', 'App\Http\Controllers\ambilinController@ambilin_hapus_barang')->name('ambilin_hapus_barang')->middleware('auth');
Route::post('/ambilin-hapus/{id}', 'App\Http\Controllers\ambilinController@ambilin_hapus')->name('ambilin_hapus')->middleware('auth');
Route::get('/ambilin-kolektor-batal/{id}', 'App\Http\Controllers\ambilinController@ambilin_kolektor_batal')->name('ambilin_kolektor_batal')->middleware('auth');
Route::get('/ambilin-mitra-batal/{id}', 'App\Http\Controllers\ambilinController@ambilin_mitra_batal')->name('ambilin_mitra_batal')->middleware('auth');
Route::get('/ambilin-riwayat', 'App\Http\Controllers\ambilinController@ambilin_riwayat')->name('ambilin_riwayat')->middleware('auth');
Route::get('/ambilin-kolektor-riwayat/{x}/{y}', 'App\Http\Controllers\ambilinController@ambilin_kolektor_riwayat')->name('ambilin_kolektor_riwayat')->middleware('auth');
Route::get('/ambilin-terambil/{id}', 'App\Http\Controllers\ambilinController@ambilin_terambil')->name('ambilin_terambil')->middleware('auth');
Route::get('/ambilin-tersedia/{x}/{y}', 'App\Http\Controllers\ambilinController@ambilin_tersedia')->name('ambilin_tersedia')->middleware('auth');
Route::get('/ambilin-verifikasi/{id_ambilin}/{id_booking}', 'App\Http\Controllers\ambilinController@ambilin_verifikasi')->name('ambilin_verifikasi')->middleware('auth');
Route::post('/ambilin-verifikasi/{id_ambilin}/{id_booking}', 'App\Http\Controllers\ambilinController@ambilin_verifikasi_post')->name('ambilin_verifikasi_post')->middleware('auth');
Route::get('/lihat-rating-kolektor/{id_booking}', 'App\Http\Controllers\ambilinController@lihat_rating_kolektor')->name('lihat_rating_kolektor')->middleware('auth');
Route::get('/beri-rating-kolektor/{id_booking}', 'App\Http\Controllers\ambilinController@beri_rating_kolektor')->name('beri_rating_kolektor')->middleware('auth');
Route::post('/post-ratingku/{id_booking}/{id_ambilin}', 'App\Http\Controllers\ambilinController@ratingku_post')->name('post_ratingku')->middleware('auth');
Route::get('/lihat-rating-mitra/{id_ambilin}', 'App\Http\Controllers\ambilinController@lihat_rating_mitra')->name('lihat_rating_mitra')->middleware('auth');
Route::get('/beri-rating-mitra/{id_ambilin}', 'App\Http\Controllers\ambilinController@beri_rating_mitra')->name('beri_rating_mitra')->middleware('auth');
Route::post('/post-ratingku-mitra/{id_ambilin}', 'App\Http\Controllers\ambilinController@ratingku_mitra_post')->name('post_ratingku_mitra')->middleware('auth');
Route::post('/post-rating/{id_a}/{id_k}', 'App\Http\Controllers\ambilinController@rating_post')->name('post_rating')->middleware('auth');
Route::post('/direction/{id}', 'App\Http\Controllers\ambilinController@direction')->name('direction_ambilin')->middleware('auth');
Route::post('/direction/{fitur}/{id}', 'App\Http\Controllers\barkasController@direction')->name('direction')->middleware('auth');

Route::get('/map/{id}', 'App\Http\Controllers\ambilinController@map')->name('map_ambilin')->middleware('auth');
Route::get('/map/{fitur}/{id}', 'App\Http\Controllers\barkasController@map')->name('map_barkas')->middleware('auth');

Route::get('/mitra/{fitur}/{id}', 'App\Http\Controllers\ambilinController@detail_mitra')->name('mitra')->middleware('auth');
Route::get('/kolektor/{id}', 'App\Http\Controllers\ambilinController@detail_kolektor')->name('kolektor')->middleware('auth');

Route::get('/detail/{fitur}/{id}', 'App\Http\Controllers\barkasController@detail')->name('detail')->middleware('auth');
Route::post('/hapus/{fitur}/{id}', 'App\Http\Controllers\barkasController@hapus_fitur')->name('hapus_fitur')->middleware('auth');
Route::get('/ajukan_ulang/{fitur}/{id}', 'App\Http\Controllers\barkasController@ajukan_ulang_barkas')->name('ajukan_ulang')->middleware('auth');
Route::post('/laku/{fitur}/{id}', 'App\Http\Controllers\barkasController@laku')->name('laku')->middleware('auth');
Route::get('/aktifkan/{fitur}/{id}', 'App\Http\Controllers\barkasController@aktifkan_fitur')->name('aktifkan_fitur')->middleware('auth');
Route::get('/nonaktifkan/{fitur}/{id}', 'App\Http\Controllers\barkasController@nonaktifkan_fitur')->name('nonaktifkan_fitur')->middleware('auth');
Route::get('/paskas/{x}/{y}', 'App\Http\Controllers\barkasController@paskas')->name('paskas')->middleware('auth');
Route::get('/paskas', 'App\Http\Controllers\barkasController@paskas_kosong')->name('paskas_kosong')->middleware('auth');
Route::get('/paskas-baru', 'App\Http\Controllers\barkasController@paskas_baru')->name('paskas_baru')->middleware('auth');
Route::post('/paskas-baru', 'App\Http\Controllers\barkasController@paskas_post')->name('post_paskas')->middleware('auth');
Route::get('/paskas-jualan', 'App\Http\Controllers\barkasController@paskas_jualan')->name('paskas_jualan')->middleware('auth');
Route::get('/paskas-sedekah/{id}', 'App\Http\Controllers\barkasController@paskas_sedekah')->name('paskas_sedekah')->middleware('auth');
Route::get('/sebar/{x}/{y}', 'App\Http\Controllers\barkasController@sebar')->name('sebar')->middleware('auth');
Route::get('/sebar', 'App\Http\Controllers\barkasController@sebar_kosong')->name('sebar_kosong')->middleware('auth');
Route::get('/sebar-baru', 'App\Http\Controllers\barkasController@sebar_baru')->name('sebar_baru')->middleware('auth');
Route::post('/sebar-baru', 'App\Http\Controllers\barkasController@sebar_post')->name('post_sebar')->middleware('auth');
Route::get('/sebar-ku', 'App\Http\Controllers\barkasController@sebarku')->name('sebarku')->middleware('auth');
Route::get('/barkas-hapus-gambar/{fitur}/{id}', 'App\Http\Controllers\barkasController@barkas_hapus_gambar')->name('barkas_hapus_gambar')->middleware('auth');
Route::post('/barkas-tambah-gambar/{fitur}', 'App\Http\Controllers\barkasController@barkas_tambah_gambar')->name('barkas_tambah_gambar')->middleware('auth');
Route::post('/barkas-edit-gambar-utama/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_gambar_utama')->name('barkas_edit_gambar_utama')->middleware('auth');
Route::post('/barkas-edit-gambar/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_gambar')->name('barkas_edit_gambar')->middleware('auth');
Route::post('/barkas-edit-judul/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_judul')->name('barkas_edit_judul')->middleware('auth');
Route::post('/barkas-edit-harga', 'App\Http\Controllers\barkasController@barkas_edit_harga')->name('barkas_edit_harga')->middleware('auth');
Route::post('/barkas-edit-jenis/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_jenis')->name('barkas_edit_jenis')->middleware('auth');
Route::post('/barkas-edit-kondisi/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_kondisi')->name('barkas_edit_kondisi')->middleware('auth');
Route::post('/barkas-edit-lokasi/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_lokasi')->name('barkas_edit_lokasi')->middleware('auth');
Route::post('/barkas-edit-deskripsi/{fitur}', 'App\Http\Controllers\barkasController@barkas_edit_deskripsi')->name('barkas_edit_deskripsi')->middleware('auth');

// Route::get('/tukar-poin', function($page = 'Tukar Poin',$back='/ambilinapps/dashboard') {return view('tukar_poin',compact('page','back'));});
Route::get('/tukar-poin', 'App\Http\Controllers\tukarController@index')->name('tukar-poin')->middleware('auth');
Route::get('/tukar-poin/{jenis}', 'App\Http\Controllers\tukarController@tukar')->name('tukar_poin_jenis')->middleware('auth');
Route::post('/tukar-poin/{jenis}/{id}', 'App\Http\Controllers\tukarController@post_tukar')->name('post_tukar')->middleware('auth');
/* fitur end */

// Pesan
Route::get('/pesan', 'App\Http\Controllers\pesanController@index')->name('pesan_menu')->middleware('auth');
Route::get('/pesan-cek/{datetime}', 'App\Http\Controllers\pesanController@room_check')->name('cek-pesan');
Route::get('/pesan/{id}', 'App\Http\Controllers\pesanController@chat')->name('chat')->middleware('auth');
Route::post('/pesan/{id}', 'App\Http\Controllers\pesanController@post_chat')->name('post_chat')->middleware('auth');
Route::get('/pesan/chat/{id_room}/{datetime}', 'App\Http\Controllers\pesanController@update_check')->name('cek-chat-room');
// update_check

// Route::get('/checkIfModelUpdated', function() {
//     $model = Chat::get();
//     // $updatedAt = Request::get('updated_at');
//     return json_encode($model->waktu_catat);
// });
// Route::get('/checkIfModelUpdated/{id}', function($id) {
//     $model = Chat::find($id);
//     // $updatedAt = Request::get('updated_at');
//     return json_encode($model->waktu_catat);
// });
// Pesan End

/* history */
Route::get('/statistik', 'App\Http\Controllers\historyController@statistik')->name('statistik')->middleware('auth');
Route::get('/history/ambilin/{tipe}', 'App\Http\Controllers\historyController@ambilin')->name('history')->middleware('auth');
Route::get('/history/epr/{tipe}', 'App\Http\Controllers\historyController@epr')->name('history')->middleware('auth');
Route::get('/history/lt/{tipe}', 'App\Http\Controllers\historyController@lt')->name('history')->middleware('auth');
/* history end */

// Route::get('/tukar-lt', 'App\Http\Controllers\Controller@tukar_lt')->middleware('auth');
// Route::get('/tukar-epr', 'App\Http\Controllers\Controller@tukar_epr')->middleware('auth');
// Route::get('/tukar-lt', 'App\Http\Controllers\Controller@lt')->middleware('auth');
// Route::get('/tukar-epr', 'App\Http\Controllers\Controller@epr')->middleware('auth');

/* admin */

Route::get('/operator','App\Http\Controllers\operatorController@index')->name('index-operator')->middleware('auth:weboperator');
/* User */
//Mitra
Route::get('/operator/tambah_user','App\Http\Controllers\operatorController@tambah_user')->name('tambah_user-operator')->middleware('auth:weboperator');
Route::post('/operator/tambah_user/','App\Http\Controllers\operator_postController@edit_user')->name('post_user-operator')->middleware('auth:weboperator');
Route::post('/operator/getkabupaten', 'App\Http\Controllers\operatorController@getKabupaten')->name('getkabupaten-operator')->middleware('auth:weboperator');
Route::post('/operator/getkecamatan', 'App\Http\Controllers\operatorController@getKecamatan')->name('getkecamatan-operator')->middleware('auth:weboperator');
Route::post('/operator/getkelurahan', 'App\Http\Controllers\operatorController@getKelurahan')->name('getkelurahan-operator')->middleware('auth:weboperator');

Route::get('/operator/{jenis}/new','App\Http\Controllers\operatorController@mitra_new')->name('mitra_new-operator')->middleware('auth:weboperator');
Route::get('/operator/{jenis}/verifying','App\Http\Controllers\operatorController@mitra_verifying')->name('mitra_verifying-operator')->middleware('auth:weboperator');
Route::get('/operator/{jenis}/verified','App\Http\Controllers\operatorController@mitra_verified')->name('mitra_verified-operator')->middleware('auth:weboperator');
Route::get('/operator/{jenis}/unverified','App\Http\Controllers\operatorController@mitra_unverified')->name('mitra_unverified-operator')->middleware('auth:weboperator');
Route::post('/operator/{jenis}/edit','App\Http\Controllers\operatorController@mitra_edit')->name('mitra_edit-operator')->middleware('auth:weboperator');
// Route::get('/operator/mitra_new','App\Http\Controllers\operatorController@mitra_new')->name('mitra_new-operator')->middleware('auth:weboperator');
// Route::get('/operator/mitra_verifying','App\Http\Controllers\operatorController@mitra_verifying')->name('mitra_verifying-operator')->middleware('auth:weboperator');
// Route::get('/operator/mitra_verified','App\Http\Controllers\operatorController@mitra_verified')->name('mitra_verified-operator')->middleware('auth:weboperator');
// Route::get('/operator/mitra_unverified','App\Http\Controllers\operatorController@mitra_unverified')->name('mitra_unverified-operator')->middleware('auth:weboperator');

Route::get('/operator/mitra_toggle/{id}','App\Http\Controllers\operator_postController@toggle_user')->name('mitra_toggle-operator')->middleware('auth:weboperator');
Route::get('/operator/mitra_verif/{id}','App\Http\Controllers\operator_postController@verif_user')->name('mitra_verif-operator')->middleware('auth:weboperator');

//Kolektor
// Route::get('/operator/kolektor_new','App\Http\Controllers\operatorController@kolektor_new')->name('kolektor_new-operator')->middleware('auth:weboperator');
// Route::get('/operator/kolektor_verifying','App\Http\Controllers\operatorController@kolektor_verifying')->name('kolektor_verifying-operator')->middleware('auth:weboperator');
// Route::get('/operator/kolektor_verified','App\Http\Controllers\operatorController@kolektor_verified')->name('kolektor_verified-operator')->middleware('auth:weboperator');
// Route::get('/operator/kolektor_unverified','App\Http\Controllers\operatorController@kolektor_unverified')->name('kolektor_unverified-operator')->middleware('auth:weboperator');
//Bank Sampah
// Route::get('/operator/bank_sampah_new','App\Http\Controllers\operatorController@bank_sampah_new')->name('bank_sampah_new-operator')->middleware('auth:weboperator');
// Route::get('/operator/bank_sampah_verifying','App\Http\Controllers\operatorController@bank_sampah_verifying')->name('bank_sampah_verifying-operator')->middleware('auth:weboperator');
// Route::get('/operator/bank_sampah_verified','App\Http\Controllers\operatorController@bank_sampah_verified')->name('bank_sampah_verified-operator')->middleware('auth:weboperator');
// Route::get('/operator/bank_sampah_unverified','App\Http\Controllers\operatorController@bank_sampah_unverified')->name('bank_sampah_unverified-operator')->middleware('auth:weboperator');
//Kategori User
Route::get('/operator/kategori_user','App\Http\Controllers\operatorController@kategori_user')->name('kategori_user-operator')->middleware('auth:weboperator');
Route::post('/operator/kategori_user','App\Http\Controllers\operator_postController@tambah_kat')->name('kategori_tambah-operator')->middleware('auth:weboperator');
//Lupa Password
Route::get('/operator/lupa_password','App\Http\Controllers\operatorController@lupa_password')->name('lupa_password-operator')->middleware('auth:weboperator');
Route::get('/operator/lupa_password/{id}','App\Http\Controllers\operator_postController@lupa_password')->name('post_lupa-operator')->middleware('auth:weboperator');
//Gamifikasi
Route::get('/operator/gamifikasi','App\Http\Controllers\operatorController@gamifikasi')->name('gamifikasi-operator')->middleware('auth:weboperator');
Route::post('/operator/gamifikasi/ubah','App\Http\Controllers\operator_postController@edit_rank')->name('post_gamifikasi-operator')->middleware('auth:weboperator');
Route::get('/operator/gamifikasi/{id}','App\Http\Controllers\operator_postController@del_rank')->name('hapus_gamifikasi-operator')->middleware('auth:weboperator');
/* END User */

/* Fitur */
Route::get('/operator/delete/{id}','App\Http\Controllers\operator_postController@delete_barkas')->name('delete_barkas-operator')->middleware('auth:weboperator');
//Ambilin
// Route::get('/operator/ambilin_request','App\Http\Controllers\operatorController@ambilin_request')->name('ambilin_request-operator')->middleware('auth:weboperator');
// Route::get('/operator/ambilin_tersedia','App\Http\Controllers\operatorController@ambilin_tersedia')->name('ambilin_tersedia-operator')->middleware('auth:weboperator');
// Route::get('/operator/ambilin_proses','App\Http\Controllers\operatorController@ambilin_proses')->name('ambilin_proses-operator')->middleware('auth:weboperator');
// Route::get('/operator/ambilin_terambil','App\Http\Controllers\operatorController@ambilin_terambil')->name('ambilin_terambil-operator')->middleware('auth:weboperator');
// Route::get('/operator/ambilin_dibatalkan','App\Http\Controllers\operatorController@ambilin_dibatalkan')->name('ambilin_dibatalkan-operator')->middleware('auth:weboperator');
Route::get('/operator/ambilin/{jenis}','App\Http\Controllers\operatorController@ambilin')->name('ambilin-operator')->middleware('auth:weboperator');
Route::post('/operator/ambilin/{jenis}/edit','App\Http\Controllers\operator_postController@edit_ambilin')->name('ambilin_edit-operator')->middleware('auth:weboperator');
Route::post('/operator/ambilin/{jenis}/set','App\Http\Controllers\operator_postController@set_kolektor')->name('ambilin_set-operator')->middleware('auth:weboperator');
Route::get('/operator/tanggal_layanan','App\Http\Controllers\operatorController@tanggal_layanan')->name('tanggal_layanan-operator')->middleware('auth:weboperator');
Route::get('/operator/waktu_layanan','App\Http\Controllers\operatorController@waktu_layanan')->name('waktu_layanan-operator')->middleware('auth:weboperator');
Route::post('/operator/post_layanan','App\Http\Controllers\operator_postController@post_layanan')->name('post_layanan-operator')->middleware('auth:weboperator');
Route::get('/operator/toggle_layanan/','App\Http\Controllers\operator_postController@toggle_layanan')->name('toggle_layanan')->middleware('auth:weboperator');
Route::get('/operator/verifikasi/','App\Http\Controllers\operator_postController@verifikasi_barkas')->name('ambilin-verif')->middleware('auth:weboperator');
Route::post('/operator/tolak/','App\Http\Controllers\operator_postController@tolak_barkas')->name('tolak-barkas')->middleware('auth:weboperator');
//Barkas
Route::get('/operator/barkas/{jenis}/{status}','App\Http\Controllers\operatorController@barkas')->name('barkas-operator')->middleware('auth:weboperator');
//Sebar
// Route::get('/operator/sebar/{jenis}','App\Http\Controllers\operatorController@sebar')->name('sebar-operator')->middleware('auth:weboperator');
// //Paskas
// Route::get('/operator/paskas/{jenis}','App\Http\Controllers\operatorController@paskas')->name('paskas-operator')->middleware('auth:weboperator');
//Harga Sampah
Route::get('/operator/harga_sampah_tambah','App\Http\Controllers\operatorController@harga_sampah_tambah')->name('harga_sampah_tambah-operator')->middleware('auth:weboperator');
Route::get('/operator/harga_sampah/{mitra}','App\Http\Controllers\operatorController@harga_sampah')->name('harga_sampah_mitra-operator')->middleware('auth:weboperator');
// Route::get('/operator/harga_sampah_kolektor','App\Http\Controllers\operatorController@harga_sampah_kolektor')->name('harga_sampah_kolektor-operator')->middleware('auth:weboperator');
Route::get('/operator/harga_sampah_toggle','App\Http\Controllers\operator_postController@toggle_harga')->name('harga_sampah_toggle-operator')->middleware('auth:weboperator');
Route::post('/operator/harga_sampah_post','App\Http\Controllers\operator_postController@post_harga')->name('harga_sampah_post-operator')->middleware('auth:weboperator');
// WP Lokasi
Route::get('/operator/wp-jenis-lokasi','App\Http\Controllers\operatorController@wp_lokasijenis')->name('wp_lokasijenis-operator')->middleware('auth:weboperator');
Route::get('/operator/lokasi/{jenis}','App\Http\Controllers\operatorController@wp_lokasi')->name('wp_lokasi-operator')->middleware('auth:weboperator');
Route::post('/operator/lokasi_jenis/post','App\Http\Controllers\operator_postController@post_lokasi_jenis')->name('post_jenis_lokasi-operator')->middleware('auth:weboperator');
Route::get('/operator/lokasi/{jenis}/toggle','App\Http\Controllers\operator_postController@toggle_lokasi')->name('toggle_lokasi-operator')->middleware('auth:weboperator');
Route::get('/operator/lokasi/{jenis}/delete','App\Http\Controllers\operator_postController@hapus_lokasi')->name('delete_lokasi-operator')->middleware('auth:weboperator');
//Notifikasi
Route::get('/operator/notifikasi','App\Http\Controllers\operatorController@notifikasi')->name('notifikasi-operator')->middleware('auth:weboperator');
Route::post('/operator/notifikasi/ubah','App\Http\Controllers\operator_postController@post_notif_raw')->name('post_notifikasi-operator')->middleware('auth:weboperator');
/* END Fitur */

/* admin end */

/*test*/
Route::get('/dashboard_f',  'App\Http\Controllers\Controller@test');


//Route::get('/forgot/forgotwa', [loginController::class, 'forgotwa']);
//login_end