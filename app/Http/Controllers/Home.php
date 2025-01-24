<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

class Home extends Controller
{
   public function index(Request $req)
   {

      $data['banner'] = DB::table('banner_tb')->orderBy("id", "desc")->get();
      $data['home'] = DB::table('front_cms_pages')->where('url', 'home')->first(['description']);
      $data['news'] = DB::table('notice_tb')->where('news', '1')->orderBy("position", "asc")->get();
      $data['govtjob'] = DB::table('notice_tb')->where('govtjob', '1')->orderBy("id", "desc")->get();
      $data['notice'] = DB::table('notice_tb')->where('notice', '1')->orderBy("id", "desc")->get();
      $data['apprenticeship'] = DB::table('notice_tb')->where('apprenticeship', '1')->orderBy("id", "desc")->get();
      $data['syllabus'] = DB::table('notice_tb')->where('sylabuss', '1')->orderBy("position", "asc")->get();
      $data['importantlink'] = DB::table('notice_tb')->where('importantlinks', '1')->orderBy("id", "desc")->get();
      $data['private_job'] = DB::table('notice_tb')->where('privatejob', '1')->orderBy("id", "desc")->get();
      $data['blogs'] = DB::table('notice_tb')->where('blog', '1')->orderBy("id", "desc")->get();
      $data['livetest'] = DB::table('courses')->where('course_type', '5')->orderBy("id", "desc")->get();
      $data['quize'] =  DB::table('courses')->where('course_type', '7')->orderBy("id", "desc")->get();
      $data['liveclass'] =  DB::table('courses')->where('course_type', '6')->orderBy("id", "desc")->get();
      $data['testimonial'] =  DB::table('notice_tb')->where('testimonials', '1')->orderBy("position", "asc")->limit(4)->get();
      $data['type'] =  DB::table('course_type')->where('status', '1')->orderBy("position", "asc")->get();

      return view('home/index', $data);
   }
   public function userlogin(Request $req)
   {

      //login

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $req->validate([
            'username' => 'required',
            'password' => 'required',
         ]);

         $users = DB::table('students')->where('email', $req->input('username'))->first();
         $passcheck = Hash::check(request('password'), $users->password);
        
   
         if ($passcheck) {
            $data = array(
               'id' => $users->id,
               'email' => $users->email,
               'role' => 'student',

            );
            $req->session()->put('userInfo', $data);

            return redirect('user/studentcourse');
         }

         $req->session()->flash('error', 'Some error occured');
         return redirect('userlogin');
      }


      //end login

      $data['setting'] = DB::table("general_setting")->first(['title', 'small_logo', 'admin_logo']);
      $data['tradegroup'] = DB::table("tradegroup")->where("status", 1)->get();
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      return view('home.userlogin', $data);
   }
   public function login(Request $req)
   {
      return view('home.login');
   }
   public function forgotpassword(Request $req)
   {
      return view('home.forgotpassword');
   }
   public function registration(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
         $req->validate([
            'firstname' => 'required',
            'mobileno' => 'required|unique:students,mobileno',
            'email' => 'required|unique:students,email',
            'gender' => 'required',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',

         ]);
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
         // if ($req->file('file') != '') {
         //    $req->validate([
         //       'file' => 'mimes:png,jpg,jpeg,webp|max:2048'
         //    ]);
         //    $photo = $req->file('file')->getClientOriginalName();
         //    $photo_url = $req->file('file')->move('public/uploads/student_documents/online_admission_doc', $photo);
         // }
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
            // 'photo' => $photo_url,
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
            $data = array(
               'email' => trim($req->input('email')),
               'role' => 'student',
               'id' => $id
            );
            $req->session()->put('userInfo', $data);
            $req->session()->flash('success', 'Thanks for registration. Please note your reference number ' . $refrence_no . ' for further communication..!!');
            return redirect('online_admission_review');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('userlogin');
         }
      }
   }
   public function online_admission_review(Request $req)
   {
      $userinfo = $req->session()->get('userInfo');
      $email = $userinfo['email'];
      $data['res'] = DB::table('students')->where('email', $email)->get();
      return view('home/online_admission_review', $data);
   }
   public function online_admission_print(Request $req, $id)
   {

      $data['res'] = DB::table('students')->where('refrence_no', $id)->get();
      return view('home/online_admission_review', $data);
   }
   public function editonlineadmission(Request $req)
   {
      $userinfo = $req->session()->get('userInfo');
      $email = $userinfo['email'];
      if (empty($email)) {
         return redirect('userlogin');
      }
      $data['res'] = DB::table('students')->where('email', $email)->get();
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      $data['hostel'] = DB::table('hostel')->where('is_active', 'yes')->get();
      $data['state'] = DB::select('select id,name from states  order by name asc');
      return view('home/editonlineadmission', $data);
   }
   public function dynamic_pages(Request $req, $url)
   {

      $data['page'] = DB::table("front_cms_pages")->where('url', $url)->first();
 $data['viewType']=$req->input('type');
      return view('home.dynamic_pages', $data);
   }
   public function all_courses(Request $req, $url)
   {
      $course_type = $data['course_type'] = DB::table("course_type")->where("url", $url)->first(['id', 'type', 'url', 'description', 'feature_image', 'meta_title', 'meta_description', 'meta_keyword']);

      $data['list'] = DB::table("courses")->where("status", 1)->where('course_type', $course_type->id)->orderBy("position", "asc")->get();
      return view('home.all_courses', $data);
   }
   public function blog_details(Request $req, $url)
   {
       
      $type = $data['page'] = DB::table("notice_tb")->where('url', $url)->first();
      
      if ($type->news == 1) {
         $types = 'news';
      } elseif ($type->notice == 1) {
         $types = 'notice';
      } elseif ($type->blog == 1) {
         $types = 'blog';
      } elseif ($type->sylabuss == 1) {
         $types = 'sylabuss';
      } elseif ($type->privatejob == 1) {
         $types = 'privatejob';
      } elseif ($type->govtjob == 1) {
         $types = 'govtjob';
      } elseif ($type->faq == 1) {
         $types = 'faq';
      } elseif ($type->testimonials == 1) {
         $types = 'testimonials';
      } elseif ($type->apprenticeship == 1) {
         $types = 'apprenticeship';
      } elseif ($type->importantlinks == 1) {
         $types = 'importantlinks';
      }

    $data['viewType']=$req->input('type');
    
      $data['all'] = DB::table("notice_tb")->where($types, 1)->where('is_active', 1)->orderByDesc("id")->get();
      return view('home.testimonial', $data);
      // }else{
      //    return view('home.blog-details', $data);
      // }

   }
   public function gallery(Request $req)
   {

      if ($req->segment('1') == 'image-gallery') {
         $data['list'] = DB::table("gallery_tb")->where('status', '1')->first();
         return view('home.image-gallery', $data);
      } else {
         $data['list'] = DB::table("gallery_tb")->where('status', '1')->first();
         $data['video'] = DB::table("videolibrary")->where('status', '1')->get();
         return view('home.video-gallery', $data);
      }
   }

   public function pages(Request $req)
   {
      $url = $req->segment('1');

      if ($req->segment('1') == 'govt-jobs') {
         $data['list'] = DB::table("notice_tb")->where("govtjob", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'apprenticeship') {
         $data['list'] = DB::table("notice_tb")->where("apprenticeship", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'syllabus') {
         $data['list'] = DB::table("notice_tb")->where("sylabuss", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'latest-news') {
         $data['list'] = DB::table("notice_tb")->where("news", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'important-links') {
         $data['list'] = DB::table("notice_tb")->where("importantlinks", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'blogs') {
         $data['list'] = DB::table("notice_tb")->where("blog", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'faq') {
         $data['list'] = DB::table("notice_tb")->where("faq", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'private-job') {
         $data['list'] = DB::table("notice_tb")->where("privatejob", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($req->segment('1') == 'institute-gate') {
         $data['list'] = DB::table("notice_tb")->where("institute_gate", '1')->where("is_active", "1")->orderBy("id", "Desc")->get();
      } elseif ($url == 'live-test') {
         $currentdate = date('Y-m-d H:i:s');
         $run = $data['live'] = DB::table("onlineexam")->where("is_live", '1')
            ->whereDate('exam_from', '<=', $currentdate)
            ->whereDate('exam_to', '>=', $currentdate)
            ->get();


         $data['userinfo'] = $req->session()->get('userInfo');
      }

      $data['course_type'] = DB::table("front_cms_pages")->where("url", $url)->first(['id', 'type', 'url', 'description', 'feature_image', 'meta_title', 'meta_description', 'meta_keyword']);
      return view('home.jobs', $data);
   }



   public function contact_us_submit(Request $req)
   {

      $data = array(
         'name' => trim($req->input('name')),
         'email' => trim($req->input('email')),
         'subject' => trim($req->input('subject')),
         'contact' => trim($req->input('contact')),
         'description' => trim($req->input('description')),

      );
      $insert = DB::table("enquiry")->insert($data);
      if ($insert) {
         $req->session()->flash('success', 'Thank you we will contact you soon....');
         return redirect($_SERVER['HTTP_REFERER']);
      } else {
         return redirect($_SERVER['HTTP_REFERER']);
         return redirect('userlogin');
      }
   }
   public function course_details(Request $req, $id)
   {
      $res = $data['res'] = DB::table("courses")->where('id', $id)->first();

      $data['demovideos'] = DB::table("demo_videos")->where('course_id', $id)->get();
      $data['related_course'] = DB::table("courses")->where("tradegroup_id", $res->tradegroup_id)->where("status", "1")->orderBy("position", "asc")->get();
      $data2 = array(
         'view_count' => $res->view_count + 1,
      );
      DB::table("courses")->where("id", $id)->update($data2);
      return view('home.course_details', $data);
   }

   public function s3imageupload(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $file = $req->file('s3image');
         echo $path = asset($file->getClientOriginalName()) . time();
         \Storage::disk('s3')->put($path, file_get_contents('$file'));
         echo 'file_uploaded';
         exit;
      }
      return view('admin.s3imageupload');
   }
   public function all_coursess(Request $req)
   {
      Paginator::useBootstrap();
      $data['list'] = DB::table('courses as c')
         ->join("tradegroup as tg", "tg.id", "=", "c.tradegroup_id")
         ->join("trade as t", "t.id", "=", "c.trade_id")
         ->where("c.status", 1)->orderByDesc("c.id")->paginate(4, $columns = ['c.id', 'c.title', 'c.price', 'c.discount', 'c.validity', 'c.course_thumbnail', 'tg.name as tradegroup', 't.name as trade']);
      return view('home.all_coursess', $data);
   }
      public function disableLiveClasses(Request $req){
       
      $data=array(
        'is_live'=>'no'
      );
      $run=DB::table('videos')->where("live_date","<" , NOW())->update($data);

      if($run){
         echo 'Live videos disabled';
      }
      exit;
   }
}
