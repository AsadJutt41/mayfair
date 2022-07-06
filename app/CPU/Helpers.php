<?php
namespace App\CPU;
use Illuminate\Support\Facades\Session;

class Helpers

{
    public static function send_push_notif_to_device($fcm_token, $data)
    {
        $key = "AAAAQVtu3ew:APA91bHD09HIiUBlIcs0V2B8kQNkLDtarDMk-glX6EU0pR4I6oesjN_He98QDwOkOAuk2FF2PJlHXamWEvLl4c3JkeJlPeLvWh_LPCrjdGhSyfFI5MtCuuzbx9HbvEPluxQ59XU2_rYJ";
        $url = "https://fcm.googleapis.com/fcm/send";

        $header = ["authorization: key=".$key."",
            "content-type: application/json",
        ];
         $data = [
            "to" => $fcm_token,
            "notification" => [
                "title" => $data['title'],
                "body" => $data['body'],
            ]
        ];
        $dataString = json_encode($data);
        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}


