<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room_Chat;
use App\Models\Notifikasi;
use App\Models\Log;
use App\Models\Chat;
use App\Http\Controllers\notificationController;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;


class pesanController extends BaseController
{
    protected $notificationController;
    public function __construct(notificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function index()
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $page = 'Daftar Pesan';
        $back = 'dashboard';
        $room = db::table('uns_room_chat')
            ->where('uns_room_chat.id1', auth()->user()->id)
            ->orWhere('uns_room_chat.id2', auth()->user()->id)
            ->join('uns_chat', 'uns_chat.id_room', 'uns_room_chat.id')
            ->join('uns_user as user1', 'user1.id', 'uns_room_chat.id1')
            ->join('uns_user as user2', 'user2.id', 'uns_room_chat.id2')
            ->select(
                'uns_chat.id_room',
                'uns_chat.chat',
                'uns_chat.waktu_catat',
                'uns_room_chat.id1',
                'uns_room_chat.id2',
                'user1.foto_diri as foto_diri1',
                'user2.foto_diri as foto_diri2',
                'user1.nama as nama1',
                'user2.nama as nama2'
            )
            ->orderBy('uns_chat.waktu_catat', 'DESC')
            ->distinct('uns_chat.id_room', 'uns_chat.chat')
            ->get()
            ->groupBy('id_room');
        // $mynotif_count = $mynotif_raw->count();
        // $pesanlog = Log::where('id_user',auth()->user()->id)->where('akses','Chat')->orderby('waktu_catat','desc')->get()->groupby('ket');
        $pesanlog = Log::where('id_user', auth()->user()->id)->where('akses', 'Chat')->orderby('waktu_catat', 'desc')->get()->unique($key = 'ket', $strict = false);
        $counter = array();
        // foreach($pesanlog as $ket=>$value){
        // foreach($value->slice(0,1) as $log){
        foreach ($pesanlog as $log) {
            $target = (int) $log->ket;
            $counter[$target] = Chat::where('id_pengirim', $target)->where('id_penerima', auth()->user()->id)->where('waktu_catat', '>=', $log->waktu_catat)->count();
        }
        // }
        // }
        // dd($counter, $pesanlog);
        // if (auth()->user()->kat_user == 1) {
        //     $room_raw = DB::table('uns_room_chat')
        //     ->where('id_mitra', auth()->user()->id)
        //     ->get();

        //     $data_chat = array();
        //     foreach ($room_raw as $rr) {
        //         $chat = DB::table('uns_chat')
        //         ->where('id_room', $rr->id)
        //         ->orderBy('waktu_catat', 'DESC')
        //         ->join('uns_room_chat', 'uns_room_chat.id', 'uns_chat.id_room')
        //         ->join('uns_user', 'uns_user.id', 'uns_room_chat.id_kolektor')
        //         ->select('uns_chat.*', 'uns_room_chat.id_kolektor', 'uns_user.nama', 'uns_user.foto_diri')
        //         ->first();

        //         $data_chat[] = $chat;
        //     }
        //     $keys = array_column($data_chat, 'waktu_catat');
        //     array_multisort($keys, SORT_DESC, $data_chat);

        // } else if (auth()->user()->kat_user == 2) {
        //     $room_raw = DB::table('uns_room_chat')
        //     ->where('id_kolektor', auth()->user()->id)
        //     ->get();

        //     $data_chat = array();
        //     foreach ($room_raw as $rr) {
        //         $chat = DB::table('uns_chat')
        //         ->where('id_room', $rr->id)
        //         ->orderBy('waktu_catat', 'DESC')
        //         ->join('uns_room_chat', 'uns_room_chat.id', 'uns_chat.id_room')
        //         ->join('uns_user', 'uns_user.id', 'uns_room_chat.id_mitra')
        //         ->select('uns_chat.*', 'uns_room_chat.id_mitra', 'uns_user.nama', 'uns_user.foto_diri')
        //         ->first();

        //         $data_chat[] = $chat;
        //     }
        //     $keys = array_column($data_chat, 'waktu_catat');
        //     array_multisort($keys, SORT_DESC, $data_chat);
        // }
        // dd($room);

        // $data_chat = db::table('uns_chat')        
        // ->where('id_pengirim', auth()->user()->id)                
        // ->orWhere('id_penerima', auth()->user()->id)
        // ->orderBy('waktu_catat','DESC')->distinct('id_room')->get();



        // $room1 = DB::table('uns_room_chat')
        // ->where('id1', auth()->user()->id)                
        // ->get();

        // $room2 = DB::table('uns_room_chat')
        // ->where('id2', auth()->user()->id)
        // ->get();

        // $room = array();
        // foreach ($room1 as $r1) {
        //     $room[] = $r1;
        // }
        // foreach ($room2 as $r2) {
        //     $room[] = $r2;
        // }

        // $data_chat = array();
        // foreach ($room as $r) {
        //     $rc = DB::table('uns_room_chat')
        //     ->where('id', $r->id)
        //     ->first();

        //     if($rc->id1 == auth()->user()->id) {
        //         // $chat = $r->id.'-1';
        //         $chat = DB::table('uns_chat')
        //         ->where('id_room', $r->id)
        //         ->orderBy('waktu_catat', 'DESC')
        //         ->join('uns_room_chat', 'uns_room_chat.id', 'uns_chat.id_room')
        //         ->join('uns_user', 'uns_user.id', 'uns_room_chat.id2')
        //         ->select('uns_chat.*', 'uns_room_chat.id1', 'uns_room_chat.id2', 'uns_user.nama', 'uns_user.foto_diri')
        //         ->orderBy('waktu_catat','DESC')
        //         ->first();
        //     } elseif($rc->id2 == auth()->user()->id) {
        //         // $chat = $r->id.'-2';
        //         $chat = DB::table('uns_chat')
        //         ->where('id_room', $r->id)
        //         ->orderBy('waktu_catat', 'DESC')
        //         ->join('uns_room_chat', 'uns_room_chat.id', 'uns_chat.id_room')
        //         ->join('uns_user', 'uns_user.id', 'uns_room_chat.id1')
        //         ->select('uns_chat.*', 'uns_room_chat.id1', 'uns_room_chat.id2', 'uns_user.nama', 'uns_user.foto_diri')
        //         ->orderBy('waktu_catat','DESC')
        //         ->first();
        //     }

        //     $data_chat[] = $chat;
        // }
        // $keys = array_column($data_chat, 'waktu_catat');
        // array_multisort($keys, SORT_DESC, $data_chat);

        // dd($data_chat);
        return view('pesan_menu', compact('page', 'back', 'room', 'pesanlog', 'counter','now', 'today', 'yesterday'));
    }

    public function chat($id)
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $carb_now = Carbon::now()->addSecond(5);
        $back = 'pesan_menu';
        $profile = DB::table('uns_user')
            ->where('id', $id)
            ->select('uns_user.id', 'uns_user.nama', 'uns_user.foto_diri')
            ->first();
        // $chat = DB::table('uns_chat')->where('id_room', $id)->get();
        // if (auth()->user()->kat_user == 1) {
        //     $room = DB::table('uns_room_chat')->where('id_mitra', auth()->user()->id)->where('id_kolektor', $id)->first();
        // } else if (auth()->user()->kat_user == 2) {
        //     $room = DB::table('uns_room_chat')->where('id_mitra', $id)->where('id_kolektor', auth()->user()->id)->first();
        // }

        if (auth()->user()->id < $id) {
            $id_sm = auth()->user()->id;
            $id_lg = $id;
        } else {
            $id_sm = $id;
            $id_lg = auth()->user()->id;
        }

        $room = Room_Chat::firstOrCreate([
            'id1' => $id_sm,
            'id2' => $id_lg,
        ]);
        // $room = DB::table('uns_room_chat')
        // ->where('id1', auth()->user()->id)->where('id2', $id)
        // ->orWhere('id1', $id)->where('id2', auth()->user()->id)
        // ->first();

        $singleroom = $room->id;
        if (!empty($room)) {
            $chat = DB::table('uns_chat')->where('id_room', $room->id)->get();
            Log::Create([
                'id_user'       =>  auth()->user()->id,
                'akses'         =>  "Chat",
                'ket'           =>  $id,
                'waktu_catat'   =>  $now,
            ]);
            return view('chat', compact('back', 'profile', 'chat', 'id', 'carb_now', 'room', 'singleroom', 'today', 'yesterday'));
        } else {
            return view('chat', compact('back', 'profile', 'id', 'carb_now', 'room', 'singleroom'));
        }
        // return view('chat', compact('profile', 'back', 'chat'));
    }

    public function update_check($id_room, $datetime)
    {
        $post = Chat::where('id_room', $id_room)->orderBy('waktu_catat', 'DESC')->firstOrFail();
        if ($post->waktu_catat > $datetime) {
            return $post;
        }

        return false;
    }

    public function room_check($datetime)
    {
        $post = Chat::where('id_penerima', auth()->user()->id)->orderBy('waktu_catat', 'DESC')->firstOrFail();
        if ($post->waktu_catat > $datetime) {
            return $post;
        }

        return false;
    }

    public function post_chat(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|max:255',
        ]);

        // if (auth()->user()->kat_user == 1) {
        //     $room = DB::table('uns_room_chat')->where('id_mitra', auth()->user()->id)->where('id_kolektor', $id)->first();
        // } else if (auth()->user()->kat_user == 2) {
        //     $room = DB::table('uns_room_chat')->where('id_mitra', $id)->where('id_kolektor', auth()->user()->id)->first();
        // }

        $room = DB::table('uns_room_chat')
            ->where('id1', auth()->user()->id)->where('id2', $id)
            ->orWhere('id1', $id)->where('id2', auth()->user()->id)
            ->first();

        if (!empty($room)) {
            Chat::Create([
                'id_room'       => $room->id,
                'id_pengirim'   => auth()->user()->id,
                'id_penerima'   => $id,
                'chat'          => nl2br("$request->pesan"),
                'waktu_catat'   => Carbon::now(),
            ]);
        } else {
            if (auth()->user()->kat_user < $id) {
                $room_chat = Room_Chat::Create([
                    'id1'   =>  auth()->user()->id,
                    'id2'   =>  $id,
                ])->id;
            } else if ($id < auth()->user()->kat_user) {
                $room_chat = Room_Chat::Create([
                    'id1'   =>  $id,
                    'id2'   =>  auth()->user()->id,
                ])->id;
            }

            Chat::Create([
                'id_room'       => $room_chat,
                'id_pengirim'   => auth()->user()->id,
                'id_penerima'   => $id,
                'chat'          => nl2br("$request->pesan"),
                'waktu_catat'   => Carbon::now(),
            ]);
        }

        $device_token = User::where('id', $id)->pluck('device_token')->first();
        if ($device_token) {
            $title_notif    = User::where('id', auth()->user()->id)->pluck('nama')->first();
            $message_notif  = $request->pesan;
            $url_notif      = route('chat', ['id' => auth()->user()->id]);
            $this->notificationController->send_notification_FCM($device_token, $title_notif, $message_notif, $url_notif);
        }

        return redirect()->route('chat', ['id' => $id]);
    }
}
