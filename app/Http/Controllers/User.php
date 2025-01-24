<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Controller
{
    public function index(Request $req)
    {
      
        $userinfo = $req->session()->get('userInfo');
        $email = $userinfo['email'];
        $role = $userinfo['role'];
        $data['role_id'] = $role;
        
          $checkBlocked=DB::table('students')->where("email",$email)->where("status",1)->count();
          if($checkBlocked){
              echo '<h1><center>You are blocked.Please connect to the management.</center></h1>';
              exit;
          }
        
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        if ($role != 'student') {
            $teacher_id = $userinfo['id'];
            $is_superadmin = DB::table("roles")->where("id", $role)->where("is_superadmin", 1)->count();
            if ($is_superadmin > 0) {
                $data['courses'] = DB::table("course_teacher")->select('course_id')->distinct()->get();
            } else {
                $data['courses'] = DB::table("course_teacher")->where("teacher_id", $teacher_id)->get();
            }
            return view('user.allcourse', $data);
        } else {
            $data['courses'] = DB::table("courses")->where('status', 1)->orderBy("position", "asc")->get();
            $data['purchased_courses'] = DB::table("course_payment")->where('email', $email)->where('status', 'captured')->get();
            $data['related_courses'] = DB::table("course_payment")->where("email", $email)->distinct()->get(['tradegroup_id']);
            return view('user.studentcourse', $data);
        }
    }
    public function onlinetest(Request $req)
    {
        $userinfo = $req->session()->get('userInfo');
        $email = $userinfo['email'];
        $role = $userinfo['role'];
        $data['role_id'] = $role;
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        // $data['list'] = DB::table("course_payment")->where('email', $email)->where('status','captured')->get();

        $data['list'] = DB::table("courses as c")
            ->join("course_payment as p", "p.course_id", "=", "c.id")
            ->where("p.email", $email)
            ->where("p.status", "captured")
            ->get(['c.id', 'c.title']);
        return view('user.onlinetest', $data);
    }
    public function onlinetest_view(Request $req, $id)
    {
        $userinfo = $req->session()->get('userInfo');
        $email = $userinfo['email'];
        $student_id = $userinfo['id'];
        $role = $userinfo['role'];
        $data['role_id'] = $role;
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        $data['total_attempt'] = DB::table("attempt_quize")->where("examid", $id)->where("student_id", $student_id)->first(['attempt']);


        $data['score'] = DB::table("student_score_tb")->where("examid", $id)->where("student_id", $student_id)->orderBy("id", "desc")->first();
        $data['res'] = DB::table("onlineexam")->where("id", $id)->first();

        $data['total_question'] = DB::table("onlineexam_questions")->where("examid", $id)->count();
        $data['given_exam'] = DB::table("onlineexam_student_results")->where("examid", $id)->where("onlineexam_student_id", $student_id)->get();
        $data['viewType']=$req->input('type');
        return view('user.onlinetest_view', $data);
    }
    public function startexam(Request $req, $id)
    {
        $userinfo = $req->session()->get('userInfo');
        $student_id = $userinfo['id'];
        $role = $userinfo['role'];
        $data['role_id'] = $role;
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        $data2 = array(
            'examid' => $id,
            'student_id' => $student_id,
            'attempt' => 1,
        );
        $count_attempt = DB::table("attempt_quize")->where("examid", $id)->where("student_id", $student_id)->first();
        $attempt = $count_attempt->attempt;

        if (!is_null($attempt)) {
            $data2 = array(
                'examid' => $id,
                'student_id' => $student_id,
                'attempt' => $attempt + 1,
            );
            $update_attempt = DB::table("attempt_quize")->where("examid", $id)->where("student_id", $student_id)->update($data2);
        } else {
            $update_attempt = DB::table("attempt_quize")->insert($data2);
        }
        $data['setting'] = DB::table('general_setting')->first(['admin_logo']);
        $data['total_question'] = DB::table("onlineexam_questions")->where("examid", $id)->count();
        $data['res'] = DB::table("onlineexam_questions")->where("examid", $id)->get();
        $data['exam'] = DB::table("onlineexam")->where("id", $id)->first();
        return view('user.startexam', $data);
    }
    public function teacher_review(Request $req)
    {
        $userinfo = $req->session()->get('userInfo');
        $student_id = $userinfo['id'];
        $role = $userinfo['role'];
        $data['role_id'] = $role;
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'comment' => $req->input('comment'),
                'rate' => $req->input('rate'),
                'staff_id' => $req->input('staff_id'),
                'role' => $req->input('role'),
                'user_id' => $student_id
            );
            $insert = DB::table("staff_rating")->insert($data);
            if ($insert) {


                $req->session()->flash('success', 'Your review is added succesfully.');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $data['student_id'] = $student_id;
        $data['list'] = DB::table('staff')->where('status', 1)->where('role', 2)->get();
        return view('user.teacher_review', $data);
    }

    public function changepass(Request $req)
    {
        $userinfo = $req->session()->get('userInfo');
        $role = $userinfo['role'];
        $id = $userinfo['id'];

        $data['role_id'] = $role;
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_pass = trim($req->input('current_pass'));
            $users = DB::table('staff')->where('id', $id)->first();
            $passcheck = Hash::check(request('current_pass'), $users->password);
            if ($passcheck) {
                $password = trim($req->input('new_pass'));
                $confirm_pass = trim($req->input('confirm_pass'));
                $req->validate(
                    ['confirm_pass' => 'required|same:new_pass']

                );
                $data = array(
                    'password' => Hash::make($password),
                );
                if ($role == 'student') {
                    $update =  DB::table('students')->where('id', $id)->update($data);
                } else {
                    $update =  DB::table('staff')->where('id', $id)->update($data);
                }

                if ($update == 1) {
                    $req->session()->flash('success', 'Password is updated now.');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $req->session()->flash('error', 'Your current password is wrong.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        return view('user.changepass');
    }
    public function profile(Request $req)
    {
        $userinfo = $req->session()->get('userInfo');
        $id = $userinfo['id'];
        $data['res'] = DB::table('students')->where("id", $id)->first();
        return view('user.profile', $data);
    }
    public function ufpassword(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $email = trim($req->input('username'));

            $check = DB::table("students")->where("email", $email)->count();
            if ($check > 0) {
                $pin = rand(1111, 9999);
                $data = array(
                    "pin" => $pin
                );
                DB::table("students")->where("email", $email)->update($data);
                $users = DB::table("students")->where("email", $email)->first(['firstname', 'lastname']);
                $name = $users->firstname . ' ' . $users->lastname;
                $link = url('reset_password/') . '/' . base64_encode($email) . '/' . $pin;

                $title = "Reset your password.";
                $data = ['name' => $name, 'email' => $email, 'body' => $link, 'title' => $title];
                $user['to'] = $email;
                $user['title'] = $title;
                Mail::send('mail.ufpassword', $data, function ($message) use ($user) {
                    $message->to($user['to']);
                    $message->subject($user['title']);
                });

                if (Mail::failures()) {
                    $req->session()->flash('error', 'Some error occured.');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('success', 'Email has been sent to your email address.');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $req->session()->flash('error', 'This email address is not found.');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $data['setting'] = DB::table("general_setting")->first(['title', 'small_logo', 'admin_logo']);
        return view('user.ufpassword', $data);
    }

    public function reset_password(Request $req, $email, $pin)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = $req->input('password');
            $confirm_pass = $req->input('confirm_password');
            $email = $req->input('email');

            $req->validate(
                ['confirm_password' => 'required|same:password']

            );

            $data = array(
                'password' => Hash::make($password),
            );
            $data2 = array(
                'pin' => 0,
            );
            $update =  DB::table('students')->where('email', $email)->update($data);
            $updatepin =  DB::table('students')->where('email', $email)->update($data2);

            $req->session()->flash('success', 'Password has been changed now.');
            return redirect(url('userlogin'));
        }

        $check = DB::table("students")->where("email", base64_decode($email))->first(['id', 'email', 'pin']);
        $data['pin'] = $pin;
        $data['email'] = base64_decode($email);

        if ($check->pin != $pin) {
            $req->session()->flash('error', 'Link is expired.');
            return redirect(url('ufpassword'));
        }

        $data['setting'] = DB::table("general_setting")->first(['title', 'small_logo', 'admin_logo']);
        return view('user.ufpassword', $data);
    }
    public function webviewTest(Request $req, $cid, $id)
    {

        $record = DB::table("students")->where("id", $id)->where("status", 0)->first(['id', 'email', 'role']);
        $datas = array(
            'id' => $record->id,
            'email' => $record->email,
            'role' => 'student',
         );
        $req->session()->put('userInfo', $datas);
        

        return redirect('user/onlineexam/view/'.$cid.'?type=webview');

     
    }
}
