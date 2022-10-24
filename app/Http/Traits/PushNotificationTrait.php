<?php

namespace App\Http\Traits;

trait PushNotificationTrait {

        public  function pushNotificationSend($fcmToken,$title,$message,$action_url=null){
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $notification = [
            'title'	=> $title,
            'body' 	=> $message,
            'sound' =>'default',
            'icon'=>'/logo.png',
            'alert' => true,
            'channelId'=>'merchantbay',
            'click_action'=>$action_url
            ];
            $payload = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        =>$fcmToken, //single token
            'priority' =>'high',
            'sound'=>'default',
            'notification' => $notification
            ];
            $headers = [
            'Authorization: key=' . env('API_ACCESS_KEY'),
            'Content-Type: application/json'
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            $result = curl_exec($ch);
            curl_close($ch);
            $aa =  $result;
        }
}