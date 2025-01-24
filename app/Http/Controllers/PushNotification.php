<?php

namespace App\Http\Controllers;
error_reporting(0);
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PushNotification extends Controller
{
    public function sendPushNotification(Request $req)
    {
		$cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
		$data['perm_cat_id']= $cat_id->id;
		$data['role_id']=session()->get('userInfo')['role'];
		$data['tradegroup'] = DB::table("tradegroup")->where("status",1)->get();
        return view('admin/pushnotification',$data);
    }
	public function pushNotificationSend(Request $req){
		
		$data=[];
		$data['title']= trim($req->input('title'));

		$data['message']=trim($req->input('message'));

		$tokens = [];
		 
		if($req->input('tradegroup')=='all'){
			$row=DB::table('students')->get(['deviceToken']);
			 
			 foreach($row as $run){
				array_push($tokens,$run->deviceToken);
			 }
		 
		}elseif($req->input('trade')!=''){
			$row=DB::table('students')->where('trade',$req->input('trade'))->get(['deviceToken']);
			foreach($row as $run){
				array_push($tokens,$run->deviceToken);
			 }
		}
 	
		$response = $this->sendFirebasePush($tokens,$data);
		$req->session()->flash('success', 'Notifications sent successfully');
		redirect($_SERVER['HTTP_REFERER']);
	}
    
        public function sendFirebasePush($tokens, $data)
	    {

	        $serverKey = 'AAAAKIZVM-Y:APA91bGw_7jkD9ysofeVIL7kT6e7z_LEfsNGYapYMvDYRaxADs5XxGgX03qvO_mphYHCBMLUQtM-wCmxfWVhpZTKeyQRgoN0cPLeGdequMNnMInOo7JXvYK5EoeD2ivpaItSG5CxDaje';
	        
	        // prep the bundle
	        $msg = array
	        (
	            'message'   => $data['message'],
	            'title' => $data['title'],
	        );
			 
 
	        $notifyData = [
                 "body" => $data['message'],
                 "title"=> $data['title']
            ];

	          $registrationIds = $tokens;
		 
			  $chunks = array_chunk($tokens, 1000);

	        if(count($tokens) > 1){
				foreach ($chunks as $chunk) {
                $fields = array
                (
					'registration_ids' => $chunk, //  for  multiple users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
			 
				$res = $this->sendFCMRequest($fields, $serverKey);
			}
		}
            else{
                 

				$fields = array
                (
                    'to' => $registrationIds[0], //  for  only one users
                    'notification'  => $notifyData,
                    'data'=> $msg,
                    'priority'=> 'high'
                );
				$res = $this->sendFCMRequest($fields, $serverKey);
            }
	            
			 session()->flash('success', 'Notification sent successfully.');
            return redirect($_SERVER['HTTP_REFERER']);
	    }

private function sendFCMRequest($fields, $serverKey)
{
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
    // $headers[] = 'Content-Type: application/json';
    // $headers[] = 'Authorization: key=' . $serverKey;

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    // $result = curl_exec($ch);
    // if ($result === FALSE) {
    //     die('FCM Send Error: ' . curl_error($ch));
    // }
    // curl_close($ch);
    // return $result;
}
}
