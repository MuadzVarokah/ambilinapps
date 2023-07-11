<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class notificationController extends BaseController
{
    function send_notification_FCM($device_token, $title, $message, $url_notif)
    {
        $SERVER_API_KEY = env('FCM_KEY');

        $data = [
            "to" => $device_token,
            "notification" =>
                [
                    "title"         => $title,
                    "body"          => $message,
                    "click_action"  => $url_notif,
                    'url'           => $url_notif,
                    "type"          => 'basic',
                    "icon"          => 'https://ambilin.com/ambilinapps/public/img/logo-white.png',
                    "sound"         => asset('public/audio/notification.mp3')
                ],
        ];
        $dataString = json_encode($data);
  
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
  
        $ch = curl_init();
  
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
  
        curl_exec($ch);
        // $response = curl_exec($ch);
        // return $response;
    
    }
}
