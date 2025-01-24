<?php

namespace App\Http\Controllers;

error_reporting(0);

use App\Models\BatchModel;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\TradegroupModel;
use App\Models\TradeModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Razorpay\Api\Api;
use Exception;
use Mail;

class HomeApi extends Controller
{
    public function index(Request $req)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //  $checkLoggedIn=DB::table('students')->where('email',$req->input('username'))->where('device_id',"!=",$req->input('device_id'))->count();
                // $checkLoggedIn=DB::table('students')->where('email',$req->input('username'))->where('device_id',"!=",$req->input('device_id'))->count();
            //   if($checkLoggedIn>0){
            //      $response = array(
            //         'success' => false,
            //         'message' => 'Already logged in. on another device.'
            //     );
            //      return $response;
            //   } 

            $validator = Validator::make($req->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ]));
            }
            $users = DB::table('students')
                ->where('email', $req->input('username'))->first(['students.id', 'students.password']);
            if ($users) {
                $passcheck = Hash::check(request('password'), $users->password);
                if ($passcheck) {
                    $row = DB::table('students')
                        ->leftJoin("classes", "students.class_id", "=", "classes.id")
                        ->where('email', $req->input('username'))->first(['students.id', 'students.roll_no', 'students.refrence_no', 'students.admission_no', 'students.class_id', 'students.batch_id', 'students.tradegroup', 'students.trade', 'students.firstname', 'students.lastname', 'students.gender', 'students.dob', 'students.photo', 'students.mobileno', 'students.email', 'students.device_id', 'students.registration_type', 'students.pay_status', 'students.type', 'classes.class']);
                    $is_login = array(
                        'device_id' => trim($req->input('device_id')),
                        'is_loggedin' => 1,
                        'deviceToken' => $req->input('deviceToken'),

                    );
                    DB::table("students")->where("email", $req->input('username'))->update($is_login);
                          $data=array(
                        'uid'=>$row->id,
                        'deviceToken'=>trim($req->input('deviceToken')),
                        'deviceId'=>trim($req->input('device_id')),
                        'loginType'=>'android'
                    );
                        
                        $insertIntoAuthHistory=DB::table('auth_history')->insert($data);
                    $response = array(
                        'success' => true,
                        'data' => $row,
                        'message' => 'Logged in succesfully.'
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' => 'Some error occured.'
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Not found any record.'
                );
            }

            return $response;
        }
    }
    public function registration(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $validator = Validator::make($req->all(), [
                'firstname' => 'required',
                'mobileno' => 'required|unique:students,mobileno',
                'email' => 'required|unique:students,email',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ]));
            }


            $refrence_no =  substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $last_admission_no = DB::select('select id from students  order by id desc limit 1');
            $rs = DB::select('select adm_prefix,adm_start_from,adm_no_digit from general_setting where id=1');

            if (empty($last_admission_no)) {
                $admission_no = sprintf("%02d", 1);
            } else {
                $admission_no = sprintf("%02d", $last_admission_no[0]->id + 1);
            }
            $digit =  $rs[0]->adm_no_digit;
            $admission_no = $rs[0]->adm_prefix . sprintf("%0" . $digit . "d", $rs[0]->adm_start_from . $admission_no);

            if (empty($last_admission_no)) {
                $rollno = sprintf("%02d", 1);
            } else {
                $rollno = sprintf("%02d", $last_admission_no[0]->id + 1);
            }

            $roll_no = trim($req->input('rollno')) . date("y") . 'R' . $rollno;

            $photo_url = '';
            if ($req->file('file') != '') {
                $req->validate([
                    'file' => 'mimes:png,jpg,jpeg,webp|max:2048'
                ]);
                $photo = $req->file('file')->getClientOriginalName();
                $photo_url = $req->file('file')->move('public/uploads/student_documents/online_admission_doc', $photo);
            }
            $data = array(
                'type' => trim($req->input('type')),
                'class_id' => trim($req->input('class_id')) == '' ? 0 : trim($req->input('class_id')),
                'batch_id' => trim($req->input('batch_id')) == '' ? 0 : trim($req->input('batch_id')),
                'tradegroup' => trim($req->input('tradegroup')) == '' ? 0 : trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')) == '' ? 0 : trim($req->input('trade')),
                'firstname' => trim($req->input('firstname')),
                'mobileno' => trim($req->input('mobileno')),
                'email' => trim($req->input('email')),
                'gender' => trim($req->input('gender')),
                'username' => trim($req->input('username')),
                'photo' => $photo_url,
                'roll_no' => $roll_no,
                'admission_no' => $admission_no,
                'refrence_no' => $refrence_no,
                'plain_pass' => $req->input('password'),
                'password' => Hash::make($req->input('password')),

            );
            $insert =  DB::table('students')->insert($data);
            //get last inserted id
            $id = DB::getPdo()->lastInsertId();
            if ($insert) {
                $users = DB::table("students")->where("id", $id)->first();

                $response = array(
                    'success' => true,
                    'data' => $users,
                    'message' => 'Registration successful.',
                    'response' => 'Thanks for registration. Please note your reference number ' . $refrence_no . ' for further communication..!!'
                );
                // $response = array(
                //     'success' => true,
                //     'data' => $data_array,
                //     'message' => 'Registration successful.',
                //     'response' => 'Thanks for registration. Please note your reference number ' . $refrence_no . ' for further communication..!!'
                // );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Some error occured.'
                );
            }
            return $response;
        }
    }
    public function tradegroup(Request $req)
    {
        $tradegroup = new TradegroupModel;
        return $tradegroup::where("status", '1')->get(['id', 'name']);
    }
    public function trade(Request $req, $groupid)
    {
        $trade = new TradeModel;
        return $trade::where("tradegroup", $groupid)->where("status", 1)->get(['name', 'id']);
    }

    public function class(Request $req)
    {
        $class = new ClassModel();
        return $class_arr = $class::where("is_active", 'yes')->get(['id', 'class', 'batches']);
    }
    public function batches(Request $req)
    {
        $batch_id = explode(",", $req->input('batch_id'));
        $batch_array = array();
        for ($i = 0; $i < count($batch_id); $i++) {
            $batch = DB::table("batches")->where("id", $batch_id[$i])->first(['id', 'batch']);
            array_push($batch_array, $batch);
        }
        return $batch_array;
    }


    public function coursesCategory(Request $req)
    {

        $row = DB::table("course_type")->where("status", "1")->orderBy("position")->get(['id', 'type', 'url', 'description', 'feature_image']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }


        return $response;
    }
    public function popularcourse(Request $req)
    {
        $email = $req->input('email');
        $data = [];
          $checkBlocked=DB::table("students")->where('email',$email)->where("status",1)->count();
        if($checkBlocked>0){
            $response = array(
                'success' => true,
                'data' => [],
                'message' => 'You are blocked',

            );
            return $response;
            exit;
        }
        $keyword = $req->input('keyword');
        if ($req->input('type') == 'allCourses') {
            if ($keyword != '') {

                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")

                    ->where("c.status", "1")
                    ->where("c.title", "like", '%' . $keyword . '%')
                    ->orderBy("c.position")
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            } else {
                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")
                    ->where("c.status", "1")
                    ->orderBy("c.position")
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            }
        } elseif ($req->input('type') == 'all') {

            if ($keyword != '') {
                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")
                    ->where("c.status", "1")
                    ->where("c.title", "like", '%' . $keyword . '%')
                    ->orderBy("c.view_count", "Desc")
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            } else {
                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")
                    ->where("c.status", "1")
                    ->orderBy("c.view_count", "Desc")
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            }
        } else {
            if ($keyword != '') {

                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")
                    ->where("c.status", "1")
                    ->where("c.title", "like", '%' . $keyword . '%')
                    ->orderBy("c.view_count", "Desc")
                    ->limit(4)
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            } else {
                $row = Db::table("courses as c")
                    ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
                    ->leftJoin("trade", "c.trade_id", "=", "trade.id")
                    ->where("c.status", "1")
                    ->orderBy("c.view_count", "Desc")
                    ->limit(4)
                    ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
            }
        }

        if ($row) {
            foreach ($row as $run) {
                $checkPayment = DB::table("course_payment")->where("email", $email)->where("course_id", $run->id)->where("status", "captured")->count();
                $datas = array(
                    'id' => $run->id,
                    'title' => $run->title,
                    'description' => $run->description,
                    'course_thumbnail' => $run->course_thumbnail,
                    'course_url' => $run->course_url,
                    'video_id' => $run->video_id,
                    'price' => $run->price,
                    'discount' => $run->discount,
                    'expiry' => $run->expiry,
                    'validity' => $run->validity,
                    'tradegroupName' => $run->tradegroupName,
                    'tradegroup_id' => $run->tradegroup_id,
                    'trade_id' => $run->trade_id,
                    'tradeName' => $run->tradeName,
                    'purchased' => $checkPayment

                );
                array_push($data, $datas);
            }

            $response = array(
                'success' => true,
                'data' => $data,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }
    public function coursebycategory(Request $req, $id)
    {
        $email = $req->input('email');
          $checkBlocked=DB::table("students")->where('email',$email)->where("status",1)->count();
        if($checkBlocked>0){
            $response = array(
                'success' => true,
                'data' => [],
                'message' => 'You are blocked',

            );
            return $response;
            exit;
        }
        $data = [];
        $row = Db::table("courses as c")
            ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
            ->leftJoin("trade", "c.trade_id", "=", "trade.id")
            ->where("c.status", "1")
            ->where("c.course_type", $id)
            ->orderBy("c.position")
            ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
        if ($row) {
            foreach ($row as $run) {
                $checkPayment = DB::table("course_payment")->where("email", $email)->where("course_id", $run->id)->where("status", "captured")->count();
                $datas = array(
                    'id' => $run->id,
                    'title' => $run->title,
                    'description' => $run->description,
                    'course_thumbnail' => $run->course_thumbnail,
                    'course_url' => $run->course_url,
                    'video_id' => $run->video_id,
                    'price' => $run->price,
                    'discount' => $run->discount,
                    'expiry' => $run->expiry,
                    'validity' => $run->validity,
                    'tradegroupName' => $run->tradegroupName,
                    'tradegroup_id' => $run->tradegroup_id,
                    'trade_id' => $run->trade_id,
                    'tradeName' => $run->tradeName,
                    'purchased' => $checkPayment

                );
                array_push($data, $datas);
            }
            $response = array(
                'success' => true,
                'data' => $data,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function demovideos(Request $req, $course_id)
    {
        $row = DB::table("demo_videos")->where("course_id", $course_id)->where("status", "1")->get(['id', 'title', 'video_id', 'description']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function parentfolder(Request $req, $course_id)
    {
        $row = DB::table("folders")->where("course_id", $course_id)->where("status", "1")->where("parent_folder_id", 0)->orderBy("order_id")->get(['id', 'folder_id', 'folders', 'course_id', 'parent_folder_id']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function subfolder(Request $req, $course_id, $folder_id)
    {
        //count videos,testseries,documents


        $allData = array();
        if ($folder_id == 0) {
            $row = DB::table("folders")->where("course_id", $course_id)->where("status", "1")->where("parent_folder_id", $folder_id)->orderBy("order_id")->get(['id', 'folder_id', 'folders', 'course_id', 'parent_folder_id']);
        } else {
            $row = DB::table("folders")->where("status", "1")->where("parent_folder_id", $folder_id)->orderBy("order_id")->get(['id', 'folder_id', 'folders', 'course_id', 'parent_folder_id']);
        }

        foreach ($row as $run) {

            if ($run->parent_folder_id == 0) {
                $folder_id = $run->folder_id;
            } else {
                $folder_id = $run->folder_id;
            }


            $parent_folder = DB::table("folders")->where("parent_folder_id", $folder_id)->get();
            $all_videos = DB::table("videos")->where("folder_id", $folder_id)->count();
            $all_document = DB::table("course_document")->where("folder_id", $folder_id)->count();
            $testseries = DB::table("course_exam")->where("folder_id", $folder_id)->count();
            foreach ($parent_folder as $runs) {
                $all_videos +=  DB::table("videos")->where("folder_id", $runs->folder_id)->count();
                $all_document +=  DB::table("course_document")->where("folder_id", $runs->folder_id)->count();
                $testseries += DB::table("course_exam")->where("folder_id", $runs->folder_id)->count();
                $subfolders = DB::table("folders")->where("parent_folder_id", $runs->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                foreach ($subfolders as $runs2) {
                    $all_videos +=  DB::table("videos")->where("folder_id", $runs2->folder_id)->count();
                    $all_document +=  DB::table("course_document")->where("folder_id", $runs2->folder_id)->count();
                    $testseries += DB::table("course_exam")->where("folder_id", $runs2->folder_id)->count();

                    $subfolders2 = DB::table("folders")->where("parent_folder_id", $runs2->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders2 as $run3) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs3->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs3->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs3->folder_id)->count();
                    }
                    $subfolders3 = DB::table("folders")->where("parent_folder_id", $runs3->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders3 as $run4) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs4->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs4->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs4->folder_id)->count();
                    }
                    $subfolders4 = DB::table("folders")->where("parent_folder_id", $runs4->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders4 as $run5) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs5->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs5->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs5->folder_id)->count();
                    }
                }
            }




            array_push($allData, array("id" => $run->id, "folder_id" => $run->folder_id, "folders" => $run->folders, "parent_folder_id" => $run->parent_folder_id, "videos" => $all_videos, "documents" => $all_document, "testseries" => $testseries));
        }



        if ($row) {
            $response = array(
                'success' => true,
                'data' => $allData,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }
    public function contents(Request $req, $course_id, $folder_id)
    {

        $videos = DB::table("videos")->where("folder_id", $folder_id)->orderBy("order_id")->get(['id', 'video_id', 'folder_id', 'course_id', 'title', 'status', 'description', 'is_live']);
        $documents = DB::table("course_document")->where("folder_id", $folder_id)->orderBy("order_id")->get(['id', 'doc_name', 'folder_id', 'document', 'download_status', 'status', 'description']);
        $testseries = DB::table("course_exam")
            ->leftJoin("onlineexam", "course_exam.exam_id", "=", "onlineexam.id")

            ->where("course_exam.folder_id", $folder_id)->get(['course_exam.id', 'course_exam.exam_id', 'onlineexam.exam as title', 'onlineexam.marks', 'onlineexam.negative_marks', 'attempt', 'course_exam.status']);
        if ($videos || $documents || $testseries) {
            $response = array(
                'success' => true,
                'videos' => $videos,
                'documents' => $documents,
                'testseries' => $testseries,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }
    public function logout(Request $req)
    {
        $is_login = array(
            'device_id' => null,
            'is_loggedin' => 0,

        );
        DB::table("students")->where("id", $req->input('id'))->update($is_login);
        $response = array(
            'success' => true,
            'message' => 'Logged out succesfully.',
        );
        return $response;
    }

    public function filterCourse(Request $req)
    {
        $row = DB::table('course_type')->where('status', 1)->where('filter', 1)->orderBy('position')->get(['id', 'type', 'url', 'feature_image']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function coursePayment(Request $req)
    {
        
        $amount=$req->input('amount');
        $paymentId= $req->input('razorpay_payment_id');
        $data = array(
            'course_id' => $req->input('courseid'),
            'tradegroup_id' => $req->input('tradegroup_id'),
            'trade_id' => $req->input('trade_id'),
            'payment_id' =>$paymentId,
            'status' => $req->input('pay_status'),
            'method' => 'online',
            'contact' => $req->input('mobile'),
            'email' => $req->input('email'),
            'amount' =>$amount,
            'discountCoupon' => $req->input('discountCoupon'),
            'coursePrice' => $req->input('coursePrice'),
            'couponCode' => $req->input('couponCode'),
          

        );
       $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
       $res = $api->payment->fetch($paymentId);
        $paystatus = $res['status'];
        if ($paystatus == 'authorized') {
            $api->payment->fetch($paymentId)->capture(array('amount' => ($amount*100), 'currency' => 'INR'));
        }
        $check = DB::table('course_payment')->where('email', $req->input('email'))->where("course_id", $req->input('courseid'))->count();
        if ($check <= 0) {
            $insert = DB::table("course_payment")->insert($data);
            if ($insert) {
                $response = array(
                    'success' => true,
                    'data'=>$res,
                    'message' => 'Course purchased successfully.',
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Some error occured.',

                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Already purchased this course.',

            );
        }

        return $response;
    }

    public function myPurchased(Request $req, $id)
    {

        $row = Db::table("course_payment as cp")
            ->leftJoin("courses as c", "c.id", "=", "cp.course_id")
            ->leftJoin("tradegroup", "c.tradegroup_id", "=", "tradegroup.id")
            ->leftJoin("trade", "c.trade_id", "=", "trade.id")
              ->leftJoin("students as s","s.email","=","cp.email")
            ->where("cp.status", "captured")
            ->where("cp.email", $id)
               ->where("s.status",0)
            ->orderBy("c.position")
            ->get(['c.id', 'c.title', 'c.description', 'c.course_thumbnail', 'c.course_url', 'c.video_id', 'c.price', 'c.discount', 'c.expiry', 'c.validity', 'tradegroup.name as tradegroupName', 'c.tradegroup_id', 'c.trade_id', 'trade.name as tradeName']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function AdmissionPayment(Request $req)
    {

        $razorpay_payment_id = $req->input('razorpay_payment_id');

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $res = $api->payment->fetch($razorpay_payment_id);

        $data = array(
            'razorpay_payment_id' => $res['id'],
            'status' => $res['status'],
            'method' => $res['method'],
            'card_id' => $res['card_id'],
            'captured' => $res['captured'],
            'uid' => $req->input('uid'),
            'amount' => $res['amount'] / 100,


        );
        $insert = DB::table("online_admission_payment")->insert($data);
        $data2 = array(
            'pay_status' => 1
        );
        DB::table("students")->where("id", $req->input('uid'))->update($data2);
        if ($insert) {
            $response = array(
                'success' => true,
                'message' => 'Payment successful.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Some error occured.',

            );
        }
        return $response;
    }

    public function userInfo(Request $req, $id)
    {


        $row = DB::table('students')
            ->leftJoin("classes", "students.class_id", "=", "classes.id")
            ->where('students.id', $id)->first(['students.id', 'students.roll_no', 'students.refrence_no', 'students.admission_no', 'students.class_id', 'students.batch_id', 'students.tradegroup', 'students.trade', 'students.firstname', 'students.lastname', 'students.gender', 'students.dob', 'students.photo', 'students.mobileno', 'students.email', 'students.device_id', 'students.registration_type', 'students.pay_status', 'students.type', 'classes.class']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Not found any records.'
            );
        }
        return $response;
    }


    public function staff(Request $req)
    {
        $row = DB::table('staff')
            ->leftJoin("department", "staff.department", "=", "department.id")
            ->leftJoin("staff_designation", "staff.designation", "=", "staff_designation.id")
            ->where('staff.status', 1)->orderBy('staff.name')->get(['staff.id', 'staff.name', 'staff.surname', 'staff.image', 'department.department', 'staff_designation.designation']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function chat_connections(Request $req, $teacherid, $studentid)
    {
        $data = array(
            'chat_user_one' => $teacherid,
            'chat_user_two' => $studentid,
            'type' => 'students'
        );
        $check = DB::table("chat_connections")->where("chat_user_one", $teacherid)->where("chat_user_two", $studentid)->count();
        if ($check <= 0) {
            $insert = DB::table("chat_connections")->insert($data);
            $connectionId = DB::getPdo()->lastInsertId();
            if ($insert) {
                $response = array(
                    'success' => true,
                    'connectionId' => $connectionId,
                    'message' => 'Connection created successfully.',

                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Some error occured.',

                );
            }
        } else {
            $connectionId = DB::table("chat_connections")->where("chat_user_one", $teacherid)->where("chat_user_two", $studentid)->first(['id']);
            $response = array(
                'success' => true,
                'connectionId' => $connectionId->id,
                'message' => 'Already connected.',

            );
        }



        return $response;
    }

    public function chat_messages(Request $req)
    {
        $data = array(
            'chat_user_id' => $req->input('userid'),
            'chat_connection_id' => $req->input('connectionid'),
            'message' => $req->input('message')
        );


        $insert = DB::table("chat_messages")->insert($data);
        if ($insert) {
            $response = array(
                'success' => true,
                'message' => 'Message has been sent.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function get_messages(Request $req, $id)
    {
        $row = DB::table("chat_messages")->where("chat_connection_id", $id)->orderBy('id', 'desc')->get();
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Data fetched succesfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function chatUpdate(Request $req, $connectionId, $senderid)
    {

        $count = DB::table("chat_messages")->where("chat_connection_id", $connectionId)->where("is_read_mobile", 0)->where("chat_user_id", "<>", $senderid)->orderBy("id", "desc")->count();
        if ($count > 0) {
            $row = DB::table("chat_messages")->where("chat_connection_id", $connectionId)->where("is_read_mobile", 0)->where("chat_user_id", "<>", $senderid)->orderBy("id", "desc")->first();


            $arraydata = array(
                'is_read_mobile' => 1
            );
            DB::table("chat_messages")->where("id", $row->id)->where("chat_user_id", "<>", $senderid)->update($arraydata);
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Data fetched succesfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Not found any data.',

            );
        }


        return $response;
    }

    public function menus(Request $req)
    {

        $row = array([
            'id' => 1,
            'name' => 'Home',
            'url' => 'Home',
        ], [
            'id' => 2,
            'name' => 'Govt. Job',
            'url' => 'govtjob',
        ], [
            'id' => 3,
            'name' => 'Latest news',
            'url' => 'news',
        ], [
            'id' => 4,
            'name' => 'Apprenticeship',
            'url' => 'apprenticeship',
        ], [
            'id' => 5,
            'name' => 'Syllabus',
            'url' => 'sylabuss',
        ], [
            'id' => 6,
            'name' => 'Blog',
            'url' => 'blog',
        ], [
            'id' => 7,
            'name' => 'Important links',
            'url' => 'importantlinks',
        ], [
            'id' => 8,
            'name' => 'Private Job',
            'url' => 'privatejob',
        ]);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }


        return $response;
    }

    public function pages(Request $req, $title)
    {

        $row = DB::table("notice_tb")->where("$title", "1")->where("is_active", "1")->orderBy("position")->get(['id', 'title', 'url', 'short_description', 'image', 'cdate', $title]);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Fetched data successfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',
            );
        }

        return $response;
    }

    public function related(Request $req, $id, $title)
    {
        $row = DB::table("notice_tb")->where("id", $id)->first(['id', 'title', 'url', 'description', 'short_description', 'image', 'cdate']);
        $related = DB::table("notice_tb")->where("$title", "1")->where("is_active", "1")->orderBy("position")->get(['id', 'title', 'url', 'short_description', 'image', 'cdate']);
        $description = preg_replace('/(&nbsp|amp|quot|lt|gt|;|<([^>]+)>)/', '', $row->description);
        $arr = array("id" => $row->id, "image" => $row->image, "short_description" => $row->short_description, "description" => $description, "cdate" => $row->cdate);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $arr,
                'related' => $related,
                'message' => 'Fetched data successfully.',
            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function sendLiveStreamMessage(Request $req)
    {
        $data = array(
            'chat_user_id' => $req->input('chat_user_id'),
            'video_id' => $req->input('video_id'),
            'message' => $req->input('message'),
            'created_at' => date('Y-m-d H:i:s')
        );


        $insert = DB::table("liveStreamMessage")->insert($data);
        if ($insert) {
            $response = array(
                'success' => true,
                'message' => 'Message has been sent.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function chatLiveStreamMessage(Request $req, $id)
    {
        $row = DB::table("liveStreamMessage as c")
            ->leftJoin("students as u", "u.id", "=", "c.chat_user_id")
            ->where("c.video_id", $id)->limit(10)->orderBy('id', 'desc')->get(['c.id', 'c.chat_user_id', 'c.video_id', 'c.message', 'is_first', 'is_read', 'c.created_at', 'u.firstname']);
        if ($row) {
            $response = array(
                'success' => true,
                'data' => $row,
                'message' => 'Data fetched succesfully.',

            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

    public function courseViewCounts(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $courseId = $req->input('courseId');
            $userId = $req->input('userId');
            $count = DB::table('course_payment as p')
                ->where('course_id', $courseId)->where('email', $req->input('email'))->where('status', 'captured')->count();


            $data = array(
                'courseid' => $req->input('courseId'),
                'userid' => $req->input('userId'),
                'cdate' => date('Y-m-d H:i:s')
            );
            if ($count > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Data Already inserted.',

                );
            } else {
                $insert = DB::table('courseViewCount')->insert($data);
                if ($insert) {
                    $response = array(
                        'success' => true,
                        'message' => 'Data inserted succesfully.',

                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' => 'Some error occured.',

                    );
                }
            }


            return $response;
        }
    }

    // public function liveVideos(Request $req, $id)
    // {
    //     $keyword = $req->input('keyword');
    //     if ($keyword != '') {
    //         $row = Db::table("course_payment as cp")
    //             ->join("folders as f", "f.course_id", "=", "cp.course_id")
    //             ->join("videos as v", "v.folder_id", "=", "f.folder_id")
    //             ->where("cp.status", "captured")
    //             ->where("cp.email", $id)
    //             ->where("v.title", "like", '%' . $keyword . '%')
    //             // ->where("v.status", 1)
    //             ->where("v.is_live", 'yes')
    //             ->orderBy("v.order_id")
    //             ->get(['v.id', 'v.title', 'v.video_id', "DATE_FORMAT([v.live_date],'%Y-%m-%d %h:%i:%s') "]);
    //     } else {
    //         $folders_array = array();
    //         $videos_list = array();
    //         $video_merge = [];
    //         //find folders with courseid and then find the parent folders of folder
    //         //then store the folder_id and then fetch the data from videos
    //         $row = DB::table("course_payment as cp")
    //             ->join("folders as f", "f.course_id", "=", "cp.course_id")
    //             ->where("cp.status", "captured")
    //             ->where("cp.email", $id)
    //             // ->where("v.status", 1)
    //             ->get(['cp.id', 'f.folder_id']);
    //         foreach ($row as $run) {
    //             array_push($folders_array, $run->folder_id);
    //             $parent_folder = DB::table("folders")->where('parent_folder_id', $run->folder_id)->get(['folder_id']);
    //             foreach ($parent_folder as $prun) {
    //                 array_push($folders_array, $prun->folder_id);
    //             }
    //         }
    //         $folders_ids = array_unique($folders_array);
    //         foreach ($folders_ids as $rows) {
    //             $videos = DB::table('videos')->where('folder_id', $rows)->where("is_live", "yes")->get(['id', 'title', 'live_date', 'is_live', 'video_id']);
    //             if (count($videos) > 0) {
    //                 foreach ($videos as $runv) {
    //                     array_push($videos_list, $runv);
    //                 }
    //             }
    //         }
    //     }

    //     if ($videos_list) {
    //         $response = array(
    //             'success' => true,
    //             'data' => $videos_list,
    //             'message' => 'Fetched data successfully.',
    //         );
    //     } else {
    //         $response = array(
    //             'success' => false,
    //             'data' => [],
    //             'message' => 'Some error occured.',

    //         );
    //     }

    //     return $response;
    // }

 public function liveVideos(Request $req, $id)
    {
        $keyword = $req->input('keyword');
        $checkBlocked=DB::table("students")->where('email',$id)->where("status",1)->count();
        if($checkBlocked>0){
            $response = array(
                'success' => true,
                'data' => [],
                'message' => 'You are blocked',

            );
            return $response;
            exit;
        }
            $folders_array = array();
            $videos_list = array();
            $video_merge = [];
            //find folders with courseid and then find the parent folders of folder
            //then store the folder_id and then fetch the data from videos
            // $row = DB::table("course_payment as cp")
            //     ->join("folders as f", "f.course_id", "=", "cp.course_id")
            //     ->where("cp.status", "captured")
            //     ->where("cp.email", $id)
            //     // ->where("v.status", 1)
            //     ->get(['cp.id', 'f.folder_id']);
            // foreach ($row as $run) {
            //     array_push($folders_array, $run->folder_id);
            //     $parent_folder = DB::table("folders")->where('parent_folder_id', $run->folder_id)->get(['folder_id']);
            //     foreach ($parent_folder as $prun) {
            //         array_push($folders_array, $prun->folder_id);
            //     }
            // }
            // $folders_ids = array_unique($folders_array);
            // foreach ($folders_ids as $rows) {
            //     $videos = DB::table('videos')->where('folder_id', $rows)->where("is_live", "yes")->get(['id', 'title', 'live_date', 'is_live', 'video_id']);
            //     if (count($videos) > 0) {
            //         foreach ($videos as $runv) {
            //             array_push($videos_list, $runv);
            //         }
            //     }
            // }
    
          $row=DB::table("course_payment as cp")->where("email",$id)->get(['course_id']);
          foreach($row as $run){
              $folders=DB::table("folders")->where("course_id",$run->course_id)->get(['folder_id','parent_folder_id','folders']);
              foreach($folders as $frun){
                
                    $folder_id=$frun->folder_id;
                        $videos = DB::table('videos')->where('folder_id', $folder_id)->where("is_live", "yes")->get(['id', 'title', 'live_date', 'is_live', 'video_id']);
                if (count($videos) > 0) {
                    foreach ($videos as $runv) {
                        if(!in_array($runv,$videos_list)){
                            
                            array_push($videos_list, $runv);
                        }
                    }
                }
                    
                    $child_folders= $folders=DB::table("folders")->where("parent_folder_id",$folder_id)->get(['folder_id','parent_folder_id','folders']);
                    foreach($child_folders as $parent_fol){
                           $videos = DB::table('videos')->where('folder_id', $parent_fol->folder_id)->where("is_live", "yes")->get(['id', 'title', 'live_date', 'is_live', 'video_id']);
                if (count($videos) > 0) {
                    foreach ($videos as $runv) {
                        if(!in_array($runv,$videos_list)){
                            
                            array_push($videos_list, $runv);
                        }
                    }
                }
                         $child_folder=DB::table("folders")->where("parent_folder_id",$parent_fol->folder_id)->get(['folder_id','parent_folder_id','folders']);
                         foreach($child_folder as $chfolder){
                             $videos = DB::table('videos')->where('folder_id', $chfolder->folder_id)->where("is_live", "yes")->get(['id', 'title', 'live_date', 'is_live', 'video_id']);
                if (count($videos) > 0) {
                    foreach ($videos as $runv) {
                        if(!in_array($runv,$videos_list)){
                            
                            array_push($videos_list, $runv);
                        }
                    }
                }
                         }
                    }
                    
                  
              }
          
             
          }
    
        if ($videos_list) {
            $response = array(
                'success' => true,
                'data' => $videos_list,
                'message' => 'Fetched data successfully.',
            );
        } else {
            $response = array(
                'success' => false,
                'data' => [],
                'message' => 'Some error occured.',

            );
        }

        return $response;
    }

  public function forgotPassword(Request $req)
    {
        $number = trim($req->input('number'));

        $check = DB::table("students")->where("mobileno", 'like', '%' . $number . '%')->count();
        if ($check > 0) {
            //send otp 
            $toNumber = "+91" . $number;
            $otp = rand(1000, 9999);
            $apiKey = '5be01103-2857-11ee-addf-0200cd936042';
            $sendSms = 'https://2factor.in/API/V1/' . $apiKey . '/SMS/' . $toNumber . '/' . $otp;


            //send otp 
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $sendSms,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                // echo "cURL Error #:" . $err;
                $response = array(
                    'error' => true,
                    'message' => 'Some error occured.',
                    'data' => $err
                );
                return $response;
            } else {
                $datas = array(
                    'number' => $number,
                    'otp' => $otp
                );
                $insertOtp = DB::table('otp_history')->insert($datas);
            }
            //end otp funtion
            $data = array(
                "pin" => $otp
            );
            DB::table("students")->where("mobileno", $number)->update($data);
            $users = DB::table("students")->where("mobileno", $number)->first(['firstname', 'lastname', 'pin']);
            $check = $users;
            $message = 'Sent OTP successfully.';
            $success = true;
        } else {
            $message = 'This mobileno is not found.';
            $success = false;
        }
        $response = array(
            'success' => $success,
            'data' => $check,
            'message' => $message,
        );

        return $response;
    }
    public function verifyPayment(Request $req,$paymentId){

        $secret='9eaVYX37Qwj39nbdlV94y5ui';
        $key_id='rzp_live_wJGpkxo3RYNzoB';
        $api = new Api($key_id, $secret);
        $response = $api->payment->fetch($paymentId);
        print_r($response);



    }
    
    
    
     public function paymentVerification(Request $req){

        $secret='9eaVYX37Qwj39nbdlV94y5ui';
        $key_id='rzp_live_wJGpkxo3RYNzoB';
          $razorpay_payment_id=$req->input('razorpay_payment_id');
        $api = new Api($key_id, $secret);
        $response = $api->payment->fetch($razorpay_payment_id);
       $status=true;
       $message='Payment verified';
            $data=array(
            'course_id'=>$req->input('courseid'),
            'tradegroup_id'=>$req->input('tradegroup_id'),
            'trade_id'=>$req->input('trade_id'),
            'payment_id'=>$req->input('razorpay_payment_id'),
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
          $status=true;
          $message='Inserted succesfully';
         } else {
            $status=false;
            $message='Some error occured';
         }
        }
        $response = array(
            'success' => $status,
            'message' => $message,
        );
        
    return $response;
}

 public function loginInfo(Request $req,$uid)
    {
       $fetchRecords=DB::table('auth_history')->where('uid',$uid)->orderBy('id','DESC')->first(['id','uid','deviceId','deviceToken']);
        if($fetchRecords){
             $response = array(
            'data'=>$fetchRecords,
            'success' => true,
            'message' => 'Record found successfully',
        );
         }else{
             $response = array(
            'success' => false,
            'message' => 'No records found',
        );
         }

        return $response;
    }
    public function resetPassword(Request $req){

        $check=DB::table('students')->where('mobileno',$req->input('number'))->where('pin',$req->input('otp'))->count();
        if($check>0){
            $data=array(
               'password'=>Hash::make($req->input('confirm_password')),
                'pin'=>null,
                'plain_pass'=>$req->input('confirm_password'),
            );

            $update=DB::table('students')->where('mobileno',$req->input('number'))->update($data);
             $response = array(
                'status' => true,
                'message' => 'Password reset successfully.Login Now',
            );
        }else{
             $response = array(
                'status' => false,
                'message' => 'Please check your OTP',
            );
        }
 return $response;

    }
    
     public function downloadYoutubeApi(Request $req)
    {
        $youtubeVideo = $req->input('videoId');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://youtube86.p.rapidapi.com/api/youtube/links",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'url' => 'https://www.youtube.com/watch?v=' . $youtubeVideo
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-Forwarded-For: 70.41.3.18",
                "x-rapidapi-host: youtube86.p.rapidapi.com",
                "x-rapidapi-key: c38e194d80msh337204533f733dcp16c7e7jsn93e0385590c1"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            $res = array(
                'success' => false,
                'data' => 'Some error occured.',
            );
        } else {
            $data = json_decode($response, true);
            // Step 3: Access the `urls` array
            $urls = $data[0]['urls'];
            // Step 4: Access the first URL in the `urls` array
            $firstUrl = $urls[0]['url'];
            // Display the first URL

            $res = array(
                'success' => true,
                'data' => $firstUrl,
            );
        }
        return $res;
    }
    
    
    public function getCoupons(Request $req,$courseId,$couponCode){
          $couponCode= strtok($couponCode, '-');
        $checkCoupon=DB::table('courses')->where('id',$courseId)->where('couponCode',$couponCode)->first(['id','price']);
        if($checkCoupon->id){
            $coupon=DB::table('coupon')->where('couponCode',$couponCode)->first();
              $price = $checkCoupon->price;
              $discount = $coupon->off;
              $payableAmount = round($price - ($price * $discount / 100));
              $response = array(
                'data' => $coupon,
                'payableAmount' => $payableAmount,
                'error' => false,
                'message' => 'Coupon applied successfully',
            );
        }else{
            $response = array(
                'error' => true,
                'message' => 'Invalid coupon code entered',
            );
        }

        return $response;
    }

}
