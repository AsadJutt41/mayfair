<?php

namespace App\CPU;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Support_helpers
{
    public static function send_suppport_notification($fcm_token,$notification)
    {
        $key = 'AAAAgfVU3Eg:APA91bGHUGK-WPFR-rEHz14vF2vI_xqKhuIcItV2Pu7EKA6SVQ95FAGUcElTAQXB8LPM53D1MvTGa0Cn0iCOGS2T7ROfphPGt8RRhqj6DJxW-56M5UxZy7VjwzPQZZXlLF9eC48T-rUo';
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = ["authorization: key=".$key."",
            "content-type: application/json",
        ];


        $postdata =0;

        $image =$notification['Image']  ?? 'default';

        $postdata = '{
            "to" : "' . $fcm_token . '",
            "data" : {
                "title":"' . $notification['title'] . '",
                "body" : "' . $notification['body'] . '",
                "image" : "' . $image . '",
                "is_read": 0
            }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);
        return $result;

    }

    public static function suppport_notification_campiagn($fcmtoken,$msg)
    {
        $key = 'AAAAgfVU3Eg:APA91bGHUGK-WPFR-rEHz14vF2vI_xqKhuIcItV2Pu7EKA6SVQ95FAGUcElTAQXB8LPM53D1MvTGa0Cn0iCOGS2T7ROfphPGt8RRhqj6DJxW-56M5UxZy7VjwzPQZZXlLF9eC48T-rUo';
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = ["authorization: key=".$key."",
            "content-type: application/json",
        ];

        $postdata = 0;
        $token = array_filter($fcmtoken, function($a) {
            return trim($a) !== "";
        });

        if (!empty($token)) {

            foreach ($token as $fcm) {
                $postdata = '{
                    "to" : "' . $fcm . '",
                    "data" : {
                        "title":"' . $msg['title'] . '",
                        "body" : "' . $msg['body'] . '",
                        "is_read": 0
                    }
                }';
                $ch = curl_init();
                $timeout = 120;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

                // Get URL content
                $result = curl_exec($ch);
                // close handle to release resources
                curl_close($ch);
            }
        }
        return true;
    }


}


