<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function index(Request $req)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($req->file('files') != '') {

                $group_attachment = $req->file('files')->getClientOriginalName();
                $group_attachment_url = $req->file('files')->move('public/uploads/attachment', $group_attachment);
            }

            $files = [
                public_path('uploads/attachment/' . $group_attachment),

            ];

            if ($req->input('type') == 'groupe') {
                for ($i = 0; $i < count($req->input('user')); $i++) {
                    $count = DB::table("staff")->where("role", $req->input('user')[$i])->count();
                    if ($count > 0) {
                        //for students
                        if($req->input('user')[$i]=='7'){
                            $user = DB::table("students")->where('status',0)->get(['email', 'firstname', 'lastname']);
                            foreach($user as $userEmail){
                                $name = $userEmail->firstname . ' ' . $userEmail->lastname;
                                $email = $userEmail->email;
                                $data = ['name' => $name, 'email' => $email, 'body' => $req->input('group_message'), 'title' => $req->input('group_title')];
                                $user['to'] = $email;
                                $user['title'] = $req->input('group_title');
                                Mail::send('mail.index', $data, function ($messages) use ($user, $files) {
                                    $messages->to($user['to']);
                                    $messages->subject($user['title']);
                                    foreach ($files as $file) {
                                        $messages->attach($file);
                                    }
                                });
                            }
                       
                        }else{
                            //for staff
                            $user = DB::table("staff")->where("role", $req->input('user')[$i])->where("status",1)->get(['email', 'name', 'surname']);
                            foreach($user as $userEmail){
                                $name = $userEmail->name . ' ' . $userEmail->surname;
                                $email = $userEmail->email;
                                $data = ['name' => $name, 'email' => $email, 'body' => $req->input('group_message'), 'title' => $req->input('group_title')];
                                $user['to'] = $email;
                                $user['title'] = $req->input('group_title');
                                Mail::send('mail.index', $data, function ($messages) use ($user, $files) {
                                    $messages->to($user['to']);
                                    $messages->subject($user['title']);
                                    foreach ($files as $file) {
                                        $messages->attach($file);
                                    }
                                });
                            }
                       
                        }
                       
                      
                    }
                }
            }
            if (Mail::failures()) {
                echo '1';
            } else {
                echo '0';
                unlink($group_attachment_url);
               
            }
        }
    }
}
