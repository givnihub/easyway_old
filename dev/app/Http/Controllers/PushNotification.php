<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PushNotification extends Controller
{
    public function sendPushNotification(Request $req)
    {
        return view('admin/pushnotification');
    }
    public function pushNotification()
	    {
                
	        $data=[];
	        $data['message']= "Hello All";

	        $data['booking_id']="my booking booking_id";
	        
            $tokens = [];
             $tokens[] = 'fzb159ZzTna8Yso01L2T7_:APA91bHqovui6oNyQrd2Znoq3Z69In1AQbGjxy8AmD5gsVxehC5_oPPlePCs5GtY6gxAr58_YrXPnDpTBDxrgmCBO567E1c2KwgzPT535noh1TTKBQgVTfspyM19xDkI_w0Xz654saSJ';
	        $response = $this->sendFirebasePush($tokens,$data);

	    }
        public function sendFirebasePush($tokens, $data)
	    {

	        $serverKey = 'AAAAKIZVM-Y:APA91bGw_7jkD9ysofeVIL7kT6e7z_LEfsNGYapYMvDYRaxADs5XxGgX03qvO_mphYHCBMLUQtM-wCmxfWVhpZTKeyQRgoN0cPLeGdequMNnMInOo7JXvYK5EoeD2ivpaItSG5CxDaje';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => $data['message'],
	            'booking_id' => $data['booking_id'],
	        );

	        $notifyData = [
                 "body" => $data['message'],
                 "title"=> "Port App"
            ];

	        $registrationIds = $tokens;
	        
	        if(count($tokens) > 1){
                $fields = array
                (
                    'registration_ids' => $registrationIds, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
            }
            else{
                
                $fields = array
                (
                    'to' => $registrationIds[0], //  for  only one users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
            }
	            
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key='. $serverKey;

	        $ch = curl_init();
	        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	        curl_setopt( $ch,CURLOPT_POST, true );
	        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        $result = curl_exec($ch );
	        if ($result === FALSE) 
	        {
	            die('FCM Send Error: ' . curl_error($ch));
	        }
	        curl_close( $ch );
	        return $result;
	    }
}
