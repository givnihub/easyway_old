<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use Illuminate\Support\Facades\DB; 
class RazorpayPaymentController extends Controller
{
    public function index(Request $req)
    {       
        
        $data['setting']=DB::select('select admin_logo from general_setting');
         $data['row']=DB::select('select * from students where id='.$req->input('studentid'));
        return view('razorpay.razorpayView',$data);
    }

    public function store(Request $req)
    {
       
        $input = $req->all();
 
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if($req->input('courseid')!=''){
           
            $redirectUrl='payment/response?courseid='.$req->input('courseid').'&razorpay_payment_id='.$req->input('razorpay_payment_id');
        }else{
             
             $redirectUrl='payment/response?uid='.$req->input('uid').'&razorpay_payment_id='.$req->input('razorpay_payment_id');
        }
        
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
               
            } catch (Exception $e) {
                // return  $e->getMessage();
                Session::put('errors',$e->getMessage());
                $req->session()->flash('Error', 'Some error occured..!!');
                return redirect($redirectUrl);

            }
        }
        $req->session()->flash('success', 'Payment successful..!!');
        return redirect($redirectUrl);
    
    }
    public function response(Request $req)
    {

 
        $razorpay_payment_id=$req->input('razorpay_payment_id');

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
       
        $response = $api->payment->fetch($razorpay_payment_id);
        $courseDetails=DB::table("courses")->where("id",$req->input('courseid'))->first();
        if($req->input('courseid')!=''){
            $data=array(
            'course_id'=>$req->input('courseid'),
            'tradegroup_id'=>$courseDetails->tradegroup_id,
            'trade_id'=>$courseDetails->trade_id,
            'payment_id'=>$response['id'],
            'status'=>$response['status'],
            'method'=>$response['method'],
            'contact'=>$response['contact'],
            'email'=>$response['email'],
            'amount'=>$response['amount']/100,
               
            );
              $check=DB::table('course_payment')->where('payment_id',$razorpay_payment_id)->count();
 
            if($check<=0){
            
        $insert=DB::table("course_payment")->insert($data);
        if ($insert) {
            $req->session()->flash('success', 'Payment successful..!!');
         } else {
            $req->session()->flash('error', 'Some error occured...');
         }
        }

        //course payment success
      
        $data['setting']=DB::table('general_setting')->get()->first();
        $data['payment']=DB::table('course_payment')->where('payment_id',$razorpay_payment_id)->first();
        return view('razorpay.razorpayResponseCourses',$data);

        }else{
       $uid=$req->input('uid');
        $data=array(
            'razorpay_payment_id'=>$response['id'],
            'status'=>$response['status'],
            'method'=>$response['method'],
            'card_id'=>$response['card_id'],
            'captured'=>$response['captured'],
             'uid'=>$req->input('uid'),
             'amount'=>$response['amount']/100,
        );
      
         $check=DB::table('online_admission_payment')->where('razorpay_payment_id',$razorpay_payment_id)->count();
 
         if($check>0){
              
           }else{
            $req->session()->flash('success', 'Payment successful..!!');
            $insert =  DB::table('online_admission_payment')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Payment successful..!!');
             } else {
                $req->session()->flash('error', 'Some error occured...');
             }
           } 
           $data['setting']=DB::select('select admin_logo from general_setting');
           $res=$data['payment']=DB::table('online_admission_payment')->where('razorpay_payment_id',$razorpay_payment_id)->first();
           if($res->status=='captured'){
            $data2=array(
                'pay_status'=>1
               );
            $update =  DB::table('students')->where('id', $uid)->update($data2);
           }
      
         
       return view('razorpay.razorpayResponse',$data);
    }
       
    }

    public function coursePayment(Request $req,$id){
        $userinfo= $req->session()->get('userInfo');
          $email=$userinfo['email'];
        $data['userinfo']=DB::table("students")->where("email",$email)->first();
        $data['res']=DB::table("courses")->where("id",$id)->first();
        $data['setting']=DB::table('general_setting')->first('admin_logo');
        return view('razorpay.coursePayment',$data);
    }

    public function online_admission(Request $req){
       
        $data=array(
            'razorpay_payment_id'=>'offline',
            'uid'=>$req->input('student_id'),
            'amount'=>$req->input('amount'),
            'status'=>'captured',
            'method'=>'offline',
            'card_id'=>'null',
            'captured'=>'1',
            'note'=>$req->input('fee_note'),
           
        );
        $insert=DB::table("online_admission_payment")->insert($data);
        $data2=array(
            'pay_status'=>1
        );
        DB::table("students")->where("id",$req->input('student_id'))->update($data2);
       if($insert){
        $req->session()->flash('success', 'Payment inserted successfully...');
        return redirect($_SERVER['HTTP_REFERER']);
       }else{
        $req->session()->flash('error', 'Some error occured');
        return redirect($_SERVER['HTTP_REFERER']);
       }
    }
    
    
    public function webhooks(Request $req){
        echo 'webhook called';
    }
    
     public function autoCapture(Request $req){
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $data = DB::table('course_payment')
        ->where('method', '!=', 'offline')
        ->where('status', '!=', 'captured')
        ->whereBetween('cdate', [now()->subDays(7), now()])
        ->get(['id', 'status', 'payment_id', 'email', 'cdate','amount']);
    
           foreach($data as $row){
        
            $res = $api->payment->fetch($row->payment_id);
            $paystatus = $res['status'];
            if ($paystatus == 'authorized') {
                $api->payment->fetch($row->payment_id)->capture(array('amount' => ($row->amount * 100), 'currency' => 'INR'));
            }

            $data2=array(
                'status'=>'captured',
                'method'=>'online'
            );
                $update =  DB::table('course_payment')->where('id', $row->id)->update($data2);

               }
           echo 'Course allowed succesffully go back and do not hit refresh';
           exit;
     }
}
