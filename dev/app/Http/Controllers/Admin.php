<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function PHPSTORM_META\type;
use App\Models\UserModel;

class Admin extends Controller
{
   public function __construct()
   {
      $this->users = new UserModel();
   }
   public function index(Request $req)
   {
      return view('admin.dashboard');
   }
   public function enquiry(Request $req)
   {
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table("enquiry")->get();
      return view('admin.enquiry', $data);
   }
   public function media(Request $req)
   {
      if (empty($req->input('video_url')) && empty($req->file('files'))) {
         $req->session()->flash('error', 'URL field is required');
         return redirect('admin/media');
      }
      $vid_url = $req->input('video_url');
      if ($req->file('files') != '') {
         $imagescount = count($req->file('files'));
            $dir_path = 'uploads/gallery/media/';


         for ($i = 0; $i < $imagescount; $i++) {
            $img_name = $req->file('files')[$i]->getClientOriginalName();
            $file_size = $req->file('files')[$i]->getSize();
            $file_type = $req->file('files')[$i]->extension();
            if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg' || $file_type == 'JPG' || $file_type == 'PNG' || $file_type == 'webp' || $file_type == 'gif') {
               $file_type = 'image/' . $file_type;
            } elseif ($file_type == 'mp4' || $file_type == '.mov') {
               $file_type = 'video/' . $file_type;
            } else {
               $file_type = $file_type;
            }
            $req->file('files')[$i]->move('public/uploads/gallery/media', $img_name);

            $data = array(
               'img_name' => $img_name,
               'file_size' => $file_size,
               'file_type' => $file_type,
               'dir_path' => $dir_path,
               'vid_url' => $vid_url,
            );

            $insert =  DB::table('front_cms_media_gallery')->insert($data);
            //   $insert = DB::getQueryLog();
            //   dd($insert);
         }
      } else {
         $data = array(
            'file_type' => 'video',
            'vid_url' => $vid_url,
         );
         $insert =  DB::table('front_cms_media_gallery')->insert($data);
      }

      if ($insert) {
         $req->session()->flash('success', 'Inserted successfully...');
         return redirect('admin/media');
      } else {
         $req->session()->flash('error', 'Some error occured...');
         return redirect($_SERVER['HTTP_REFERER']);
      }
   }

   public function eventcreate(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


         $data = array(
            'title' => trim($req->input('title')),
            'venue' => trim($req->input('venue')),
            'start_date' => trim($req->input('start_date')),
            'end_date' => trim($req->input('end_date')),
            'description' => trim($req->input('description')),
            'meta_title' => trim($req->input('meta_title')),
            'meta_keywords' => trim($req->input('meta_keywords')),
            'meta_description' => trim($req->input('meta_description')),
            'image' => trim($req->input('image')),
         );
         if (!empty($req->input('uid'))) {
            $update =  DB::table('events_tb')->where('id', $req->input('uid'))->update($data);

            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/events');
         } else {
            $insert =  DB::table('events_tb')->insert($data);
            if ($insert) {
               $req->session()->flash('success', 'Inserted successfully...');
               return redirect($_SERVER['HTTP_REFERER']);
            } else {
               $req->session()->flash('error', 'Some error occured...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }
      }
      if (!empty($req->input('id'))) {
         $type = $req->input('type');
         $data['row'] = DB::select('select * from events_tb where id=' . $req->input('id'));
         return view('admin.eventcreate', $data);
      } else {
         return view('admin.eventcreate');
      }
   }
   public function events(Request $req)
   {
      if (!empty($req->input('id'))) {
         $deleted = DB::table('events_tb')->where('id', '=', $req->input('id'))->delete();
         $req->session()->flash('success', 'Event deleted succesfully...');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from events_tb order by id desc');
      return view('admin/events', $data);
   }
   public function gallery(Request $req)
   {
      if (!empty($req->input('id'))) {
         $deleted = DB::table('gallery_tb')->where('id', '=', $req->input('id'))->delete();
         $req->session()->flash('success', 'Gallery is deleted succesfully...');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from gallery_tb order by id desc');
      return view('admin.gallery', $data);
   }
   public function gallerycreate(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'title' => trim($req->input('title')),
            'description' => trim($req->input('description')),
            'gallery_images' => trim(implode(",", $req->input('gallery_images'))),
            'meta_title' => trim($req->input('meta_title')),
            'meta_keywords' => trim($req->input('meta_keywords')),
            'meta_description' => trim($req->input('meta_description')),
            'image' => trim($req->input('image')),
         );
         if (!empty($req->input('uid'))) {
            $update =  DB::table('gallery_tb')->where('id', $req->input('uid'))->update($data);

            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/gallery');
         } else {
            $insert =  DB::table('gallery_tb')->insert($data);
            if ($insert) {
               $req->session()->flash('success', 'Inserted successfully...');
               return redirect($_SERVER['HTTP_REFERER']);
            } else {
               $req->session()->flash('error', 'Some error occured...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }


         exit;
      }
      if ($req->input('id') != '') {
         $data['row'] = DB::select('select * from gallery_tb where id=' . $req->input('id'));
         return view('admin.galleryCreate', $data);
      } else {
         return view('admin.galleryCreate');
      }
   }

   public function noticecreate(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'title' => trim($req->input('title')),
            'url' => trim($req->input('url')),
            'start_date' => trim($req->input('start_date')),
            'short_description' => trim($req->input('short_description')),
            'description' => trim($req->input('description')),
            'meta_title' => trim($req->input('meta_title')),
            'meta_keywords' => trim($req->input('meta_keywords')),
            'meta_description' => trim($req->input('meta_description')),
            'image' => trim($req->input('image')),
            'news' => trim($req->input('news')),
            'notice' => trim($req->input('notice')),
            'blog' => trim($req->input('blog')),
            'sylabuss' => trim($req->input('sylabuss')),
            'privatejob' => trim($req->input('privatejob')),
            'govtjob' => trim($req->input('govtjob')),
            'importantlinks' => trim($req->input('importantlinks')),
            'testimonials' => trim($req->input('testimonials')),
            'apprenticeship' => trim($req->input('apprenticeship')),
            'institute_gate' => trim($req->input('institute_gate')),

         );

         if (!empty($req->input('uid'))) {
            $update =  DB::table('notice_tb')->where('id', $req->input('uid'))->update($data);

            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/notice');
         } else {
            $insert =  DB::table('notice_tb')->insert($data);
            if ($insert) {
               $req->session()->flash('success', 'Inserted successfully...');
               return redirect($_SERVER['HTTP_REFERER']);
            } else {
               $req->session()->flash('error', 'Some error occured...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }
      }
      if (!empty($req->input('id'))) {
         $type = $req->input('type');
         $data['row'] = DB::select('select * from notice_tb where id=' . $req->input('id'));
         return view('admin.noticecreate', $data);
      } else {
         return view('admin.noticecreate');
      }
   }
   public function notice(Request $req)
   {
      if (!empty($req->input('id'))) {
         $deleted = DB::table('notice_tb')->where('id', '=', $req->input('id'))->delete();
         $req->session()->flash('success', 'Notice deleted succesfully...');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from notice_tb order by id desc');
      return view('admin/notice', $data);
   }
   public function banneraction(Request $req)
   {

      if ($req->input('type') == 'delete') {
         $delete = DB::table('banner_tb')->where('imageid', '=', $req->input('content_id'))->delete();
         if ($delete) {
            echo '1';
         } else {
            echo '0';
         }

         exit;
      } else {
         $imgid = $req->input('content_id');
         $img_name = $req->input('content_name');
         $data = array(
            'imageid' => $imgid,
            'image' => $img_name
         );
         $insert =  DB::table('banner_tb')->insert($data);
         if ($insert) {
            echo '1';
         } else {
            echo '0';
         }
      }
   }
   public function banner(Request $req)
   {
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from banner_tb order by id desc');
      return view('admin.banner', $data);
   }



   public function roomtype(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'room_type' => trim($req->input('room_type')),
            'description' => trim($req->input('description')),
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('room_types')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/roomtype');
         }
         $insert =  DB::table('room_types')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/roomtype');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/roomtype');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from room_types where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('room_types')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/roomtype');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from room_types order by id asc');
      return view('admin.roomtype', $data);
   }
   public function hostel(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'hostel_name' => trim($req->input('hostel_name')),
            'type' => trim($req->input('type')),
            'address' => trim($req->input('address')),
            'intake' => trim($req->input('intake')),
            'description' => trim($req->input('description')),
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('hostel')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/hostel');
         }

         $insert =  DB::table('hostel')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/hostel');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/hostel');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from hostel where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('hostel')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/hostel');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from hostel order by id asc');
      return view('admin.hostel', $data);
   }
   public function hostelroom(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'room_no' => trim($req->input('room_no')),
            'hostel_id' => trim($req->input('hostel_id')),
            'room_type_id' => trim($req->input('room_type_id')),
            'no_of_bed' => trim($req->input('no_of_bed')),
            'cost_per_bed' => trim($req->input('cost_per_bed')),
            'description' => trim($req->input('description')),
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('hostel_rooms')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/hostelroom');
         }

         $insert =  DB::table('hostel_rooms')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/hostelroom');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/hostelroom');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from hostel_rooms where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('hostel_rooms')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/hostelroom');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from hostel_rooms order by id asc');
      $data['hostel'] = DB::select('select * from hostel order by id asc');
      $data['room'] = DB::select('select * from room_types order by id asc');
      return view('admin.hostelroom', $data);
   }

   public function batches(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'batch' => trim($req->input('batch')),

         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('batches')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/batches');
         }
         $insert =  DB::table('batches')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/batches');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/batches');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from batches where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('batches')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/batches');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from batches order by id asc');
      return view('academics.batches', $data);
   }

   public function classes(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'class' => trim($req->input('class')),
            'batches' => implode(",", $req->input('batches'))
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('classes')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/classes');
         } else {
            $req->validate([
               'class' => 'required|unique:classes,class',
            ]);
         }

         $insert =  DB::table('classes')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/classes');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/classes');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from classes where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('classes')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/classes');
      }

      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['class'] = DB::select('select * from classes order by id asc');
      $data['batches'] = DB::select('select * from batches order by id asc');

      return view('academics.classes', $data);
   }

   public function subject(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'name' => trim($req->input('name')),
            'type' => trim($req->input('type')),
            'code' => trim($req->input('code')),

         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('subjects')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/subject');
         }

         $insert =  DB::table('subjects')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/subject');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/subject');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from subjects where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('subjects')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/subject');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from subjects order by id asc');

      return view('academics.subject', $data);
   }
   public function subjectgroup(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'name' => trim($req->input('name')),
            'class' => trim($req->input('class')),
            'batches' => implode(",", $req->input('batches')),
            'subjects' => implode(",", $req->input('subject'))
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('subjectgroup')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/subjectgroup');
         }
         $insert =  DB::table('subjectgroup')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/subjectgroup');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/subjectgroup');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from subjectgroup where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('subjectgroup')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/subjectgroup');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from subjectgroup order by id asc');
      $data['class'] = DB::select('select * from classes order by id asc');
      $data['batches'] = DB::select('select * from batches order by id asc');
      $data['subjects'] = DB::select('select * from subjects order by id asc');

      return view('academics.subjectgroup', $data);
   }
   public function login(Request $req)
   {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


         $req->validate([
            'username' => 'required',
            'password' => 'required',
         ]);

         $users = DB::table('staff')->where('email', $req->input('username'))->where("status", 1)->first();

         $passcheck = Hash::check(request('password'), $users->password);
         if ($passcheck) {
            $data = array(
               'id' => $users->id,
               'name' => $users->name,
               'surname' => $users->surname,
               'email' => $users->email,
               'role' => $users->role,
               'employee_id' => $users->employee_id,
               'is_active' => $users->is_active
            );
            $req->session()->put('userInfo', $data);

            return redirect('admin/dashboard');
         }

         $req->session()->flash('error', 'Some error occured');
         return redirect('admin/login');
      }
    $data['res'] = DB::select('select admin_logo from general_setting where id=1');
      return view('home.login', $data);
   }

   public function logout(Request $req)
   {
      $userInfo = $req->session()->get('userInfo');
      $req->session()->forget('userInfo');
      return redirect('admin/login');
   }
   public function general_settings(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $check = DB::select('select print_logo,admin_logo,small_logo from general_setting where id=' . $req->input('id'));
         $print_logo_url = $check[0]->print_logo;
         $admin_logo_url = $check[0]->admin_logo;
         $small_logo_url = $check[0]->small_logo;
         if ($req->file('print_logo') != '') {
            $print_logo = $req->file('print_logo')->getClientOriginalName();
            $print_logo_url = $req->file('print_logo')->move('public/uploads/certificate', $print_logo);
         }
         if ($req->file('admin_logo') != '') {
            $admin_logo = $req->file('admin_logo')->getClientOriginalName();
            $admin_logo_url = $req->file('admin_logo')->move('public/uploads/certificate', $admin_logo);
         }
         if ($req->file('small_logo') != '') {
            $small_logo = $req->file('small_logo')->getClientOriginalName();
            $small_logo_url = $req->file('small_logo')->move('public/uploads/certificate', $small_logo);
         }

         $data = array(
            'title' => trim($req->input('title')),
            'address' => trim($req->input('address')),
            'phone' => trim($req->input('phone')),
            'whatsapp' => trim($req->input('whatsapp')),
            'email' => trim($req->input('email')),
            'facebook' => trim($req->input('facebook')),
            'twitter' => trim($req->input('twitter')),
            'google' => trim($req->input('google')),
            'instagram' => trim($req->input('instagram')),
            'linkedin' => trim($req->input('linkedin')),
            'youtube' => trim($req->input('youtube')),
            'adm_prefix' => trim($req->input('adm_prefix')),
            'adm_no_digit' => trim($req->input('adm_no_digit')),
            'adm_start_from' => trim($req->input('adm_start_from')),
            'staffid_prefix' => trim($req->input('staffid_prefix')),
            'staffid_no_digit' => trim($req->input('staffid_no_digit')),
            'staffid_start_from' => trim($req->input('staffid_start_from')),
            'print_logo' => $print_logo_url,
            'admin_logo' => $admin_logo_url,
            'small_logo' => $small_logo_url,
         );


         $update =  DB::table('general_setting')->where('id', $req->input('id'))->update($data);
         $req->session()->flash('success', 'Updated successfully...');
         return redirect('admin/general_settings');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['res'] = DB::select('select * from general_setting where id=1');
      return view('admin/general_setting', $data);
   }

   public function disable_reason(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'reason' => trim($req->input('reason')),

         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('disable_reason')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/disable_reason');
         }
         $insert =  DB::table('disable_reason')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/disable_reason');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/disable_reason');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from disable_reason where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('disable_reason')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/disable_reason');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from disable_reason order by id asc');
      return view('student.disable_reason', $data);
   }
   public function permission(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         
         $role_id = $req->input('role_id');

         $check_role = DB::table("roles")->where("id", $role_id)->first(['name']);
   
         if ($check_role->name == "Student") {
            $role_id = 'student';
         }

         $delete = DB::table("roles_permissions")->where("role_id", $role_id)->delete();
         for ($i = 0; $i < count($req->input('per_cat')); $i++) {
            $perm_cat_id = $req->input('roles_permissions_id_' . $req->input('per_cat')[$i]);
            $can_view = $req->input('can_view-perm_' . $req->input('per_cat')[$i]);
            $can_add = $req->input('can_add-perm_' . $req->input('per_cat')[$i]);
            $can_edit = $req->input('can_edit-perm_' . $req->input('per_cat')[$i]);
            $can_delete = $req->input('can_delete-perm_' . $req->input('per_cat')[$i]);
            $data = array(
               'role_id' => $role_id,
               'perm_cat_id' => $perm_cat_id,
               'can_view' => $can_view,
               'can_add' => $can_add,
               'can_edit' => $can_edit,
               'can_delete' => $can_delete,
            );
         
            $insert = DB::table("roles_permissions")->insert($data);
         }
         return redirect($_SERVER['HTTP_REFERER']);
      }
      $data['role'] = DB::table("roles")->where("id", $req->input('id'))->first();
      $data['module'] = DB::table("menu")->where("status", 1)->get();
      return view('admin.permission', $data);
   }
   public function users(Request $req)
   {
      $students = UserModel::all();
      $data = compact('students');
      return view('admin.users')->with($data);
   }
   public function usersStaff(Request $req)
   {
      $staff = DB::table('staff')->get();
      $data = compact('staff');
      return view('admin.users')->with($data);
   }
   public function usersChangeStatus(Request $req)
   {

      $data = array(
         'status' => $req->input('status')
      );
      if ($req->input('role') == 'staff') {
         $update = DB::table('staff')->where("id", $req->input('id'))->update($data);
      } else {
         $update = DB::table('students')->where("id", $req->input('id'))->update($data);
      }

      if ($update) {
         echo 'Status changed succesfully';
      } else {
         echo 'Some error occured';
      }
   }
   public function pages(Request $req)
   {
      if (!empty($req->input('id'))) {
         $deleted = DB::table('front_cms_pages')->where('id', '=', $req->input('id'))->delete();
         $req->session()->flash('success', 'Page deleted succesfully...');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table('front_cms_pages')->get();
      return view('admin.pages', $data);
   }
   public function pagesCreate(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'title' => trim($req->input('title')),
            'page_type' => trim($req->input('content_category')),
            'description' => trim($req->input('description')),
            'url' => trim($req->input('url')),
            'meta_title' => trim($req->input('meta_title')),
            'meta_keyword' => trim($req->input('meta_keywords')),
            'meta_description' => trim($req->input('meta_description')),
            'feature_image' => trim($req->input('image')),
         );
         if (!empty($req->input('uid'))) {
            $update =  DB::table('front_cms_pages')->where('id', $req->input('uid'))->update($data);

            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/pages');
         } else {
            $req->validate([
               'title' => 'required|unique:front_cms_pages,title',
            ]);
            $insert =  DB::table('front_cms_pages')->insert($data);
            if ($insert) {
               $req->session()->flash('success', 'Inserted successfully...');
               return redirect($_SERVER['HTTP_REFERER']);
            } else {
               $req->session()->flash('error', 'Some error occured...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }
      }
      if (!empty($req->input('id'))) {
         $type = $req->input('type');
         $data['row'] = DB::select('select * from front_cms_pages where id=' . $req->input('id'));
         return view('admin.pagecreate', $data);
      } else {
         return view('admin.pagecreate');
      }
   }
   public function video_gallery(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'title' => trim($req->input('title')),
            'video_id' => trim($req->input('video_id')),
         );
         if ($req->input('updateid') != '') {
            $update =  DB::table('video_gallery_tb')->where("id", $req->input('updateid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
         $insert =  DB::table('video_gallery_tb')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::table('video_gallery_tb')->where("id", $req->input('uid'))->first();
      }
      if ($req->input('delid') != '') {
         DB::table('video_gallery_tb')->where("id", $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted successfully...');
         return redirect($_SERVER['HTTP_REFERER']);
      }
      $data['list'] = DB::table('video_gallery_tb')->get();
      return view('admin.video_gallery', $data);
   }
   public function menu(Request $req)
   {
if($req->input('delid')!=''){
   $delete=DB::table('menu')->where('id',$req->input('delid'))->delete();
}

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'title' => trim($req->input('title')),
            'icon' => trim($req->input('icon')),
            'submenu' => trim($req->input('submenu')),
         );
         if ($req->input('uid') != '') {
            $insert = DB::table("menu")->where("id", $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated Successfully...');
            return redirect('admin/menu');
         } else {
            $insert = DB::table("menu")->insert($data);
         }

         $req->session()->flash('success', 'Inserted Successfully...');
         return redirect($_SERVER['HTTP_REFERER']);
      }
      if ($req->input('id') != '') {
         $data['res'] = DB::table("menu")->where("id", $req->input('id'))->first();
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table("menu")->get();
      return view('user.menu', $data);
   }

   public function submenu(Request $req)
   {
      if($req->input('delid')!=''){
         $delete=DB::table('submenu')->where('id',$req->input('delid'))->delete();
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'menu_id' => trim($req->input('menu_id')),
            'title' => trim($req->input('title')),
            'icon' => trim($req->input('icon')),
            'link' => trim($req->input('link')),
         );
         if ($req->input('uid') != '') {
            $insert = DB::table("submenu")->where("id", $req->input('uid'))->update($data);
            echo '<div class="alert alert-success" role="alert">
            Updated succesfully...
           </div>';

            exit;
         } else {
            $insert = DB::table("submenu")->insert($data);
            echo '<div class="alert alert-success" role="alert">
           Inserted succesfully...
          </div>';
            exit;
         }
      }
      if ($req->input('id') != '') {
         $data['res'] = DB::table("submenu")->where("id", $req->input('id'))->first();
      }
      $data['menu'] = DB::table("menu")->get();
      $data['list'] = DB::table("submenu")->get();
      return view('user.submenu', $data);
   }

   public function allow_courses(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


         $course = DB::table("courses")->where("id", $req->input('courseid'))->first();
         $user = DB::table("students")->where("id", $req->input('student_id'))->first();
         $amount = $req->input('amount');
         $price = $course->price - ($course->price * ($course->discount / 100));
         $data = array(
            'course_id' => $course->id,
            'tradegroup_id' => $course->tradegroup_id,
            'trade_id' => $course->trade_id,
            'payment_id' => 'offline',
            'status' => 'captured',
            'method' => 'offline',
            'contact' => $user->mobileno,
            'email' => $user->email,
            'amount' => $price,
            'discount' => $req->input('discount'),

         );
         $if_exists = DB::table("course_payment")->where("course_id", $course->id)->where("email", $user->email)->where("status", "captured")->count();
         if ($if_exists > 0) {
            $req->session()->flash('success', 'This course is already allowed...');
            return redirect($_SERVER['HTTP_REFERER']);
            exit;
         }
         $insert = DB::table("course_payment")->insert($data);
         $course_payment_id = DB::getPdo()->lastInsertId();
         $data2 = array(
            'amount' => $amount,
            'course_payment_id' => $course_payment_id,
            'payment_mode_fee' => $req->input('payment_mode_fee'),
            'fee_note' => $req->input('fee_note')
         );
         $insert = DB::table("offline_course_payment")->insert($data2);
         if ($insert) {
            $req->session()->flash('success', 'Course allowed successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      if($req->input('courseid')!='' && $req->input('email')!=''){
         $deleted=DB::table("course_payment")->where("course_id",$req->input('courseid'))->where("email",$req->input('email'))->delete();
         if($deleted){
            $req->session()->flash('success', 'Course unpaid successfully');
            return redirect(url('admin/allow-courses'));
         }
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      $data['courses'] = DB::table('courses')->get();
      return view('course.allow_courses', $data);
   }
   
   //allow course for online
   public function allow_courses_online(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         
         $course = DB::table("courses")->where("id", $req->input('courseid'))->first();
         $user = DB::table("students")->where("id", $req->input('student_id'))->first();
         $amount = $req->input('amount');
         $price = $course->price - ($course->price * ($course->discount / 100));
         $data = array(
            'course_id' => $course->id,
            'tradegroup_id' => $course->tradegroup_id,
            'trade_id' => $course->trade_id,
            'payment_id' => 'offline',
            'status' => 'captured',
            'method' => 'offline',
            'contact' => $user->mobileno,
            'email' => $user->email,
            'amount' => $price,
            'discount' => $req->input('discount'),

         );
         $if_exists = DB::table("course_payment")->where("course_id", $course->id)->where("email", $user->email)->where("status", "captured")->count();
         if ($if_exists > 0) {
            $req->session()->flash('success', 'This course is already allowed...');
            return redirect($_SERVER['HTTP_REFERER']);
            exit;
         }
         $insert = DB::table("course_payment")->insert($data);
         $course_payment_id = DB::getPdo()->lastInsertId();
         $data2 = array(
            'amount' => $amount,
            'course_payment_id' => $course_payment_id,
            'payment_mode_fee' => $req->input('payment_mode_fee'),
            'fee_note' => $req->input('fee_note')
         );
         $insert = DB::table("offline_course_payment")->insert($data2);
         if ($insert) {
            $req->session()->flash('success', 'Course allowed successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['tradegroup'] = DB::table("tradegroup")->where("status",1)->get();
      $data['courses'] = DB::table('courses')->get();
      return view('course.allow_courses_online', $data);
   }
   //end allow course for online
   public function allow_courses_list(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         if ($req->input('discount')) {
            $data2 = array(
               'discount' => trim($req->input('discount')),
            );

            DB::table("course_payment")->where("id", $req->input('course_payment_id'))->update($data2);
         }

         $data = array(
            'course_payment_id' => $req->input('course_payment_id'),
            'amount' => $req->input('amount'),
            'payment_mode_fee' => $req->input('payment_mode_fee'),
            'fee_note' => $req->input('fee_note'),
         );
         $insert = DB::table("offline_course_payment")->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Payment added successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('offline_course_payment')->where('id', '=', $req->input('delid'))->delete();
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table("course_payment")->where("method", "offline")->get();
      return view('course.allowed_courses_list', $data);
   }
   public function generalcall(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {

         $data = array(
            'name' => trim($req->input('name')),
            'contact' => trim($req->input('contact')),
            'date' => trim($req->input('date')),
            'description' => trim($req->input('description')),
            'follow_up_date' => trim($req->input('follow_up_date')),
            'call_dureation' => trim($req->input('call_dureation')),
            'note' => trim($req->input('note')),
            'call_type' => trim($req->input('call_type')),
         );
         if ($req->input('id') != '') {
            $insert =  DB::table('general_calls')->where("id", $req->input('id'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/generalcall');
         } else {
            $insert =  DB::table('general_calls')->insert($data);
         }
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      if ($req->input('id') != '') {
         $data['res'] = DB::table("general_calls")->where("id", $req->input('id'))->first();
      }
      if ($req->input('delid') != '') {
         $delete = DB::table("general_calls")->where("id", $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted successfully...');
         return redirect('admin/generalcall');
      }
      
   $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
     $data['perm_cat_id']= $cat_id->id;
     $data['role_id']=session()->get('userInfo')['role'];

 
      $data['list'] = DB::table("general_calls")->get();
      return view('admin.generalcall', $data);
   }

   public function complaint(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         if ($req->input('uid')) {
            $check = DB::table("complaint")->where('id', $req->input('uid'))->first(['image']);
            $filename = $check->image;
         }
         if ($req->file('file') != '') {
            $filename = $req->file('file')->getClientOriginalName();
            $file_type = $req->file('file')->extension();
            if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg' || $file_type == 'JPG' || $file_type == 'PNG' || $file_type == 'webp' || $file_type == 'docx' || $file_type == 'pdf') {
               $file = $req->file('file')->move('public/uploads/gallery', $filename);
            } else {
               $req->session()->flash('error', 'Please choose only png,pdf,docx,jpeg,jpg,webp files...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }

         $data = array(
            'complaint_type' => trim($req->input('complaint')),
            'source' => trim($req->input('source')),
            'name' => trim($req->input('name')),
            'contact' => trim($req->input('contact')),
            'description' => trim($req->input('description')),
            'action_taken' => trim($req->input('action_taken')),
            'staff_id' => trim($req->input('assigned')),
            'note' => trim($req->input('note')),
            'image' => $filename,

         );
         if ($req->input('uid')) {
            $update = DB::table("complaint")->where("id", $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Complaint updated successfully...');
            return redirect('admin/complaint');
         } else {
            $insert = DB::table("complaint")->insert($data);
            if ($insert) {
               $req->session()->flash('success', 'Complaint added successfully...');
               return redirect($_SERVER['HTTP_REFERER']);
            } else {
               $req->session()->flash('error', 'Some error occured...');
               return redirect($_SERVER['HTTP_REFERER']);
            }
         }
      }
      if ($req->input('uid')) {
         $data['res'] = DB::table("complaint")->where("id", $req->input('uid'))->first();
      }
      if ($req->input('delid')) {
         DB::table("complaint")->where("id", $req->input('delid'))->delete();
         $req->session()->flash('success', 'Complaint deleted successfully...');
         return redirect('admin/complaint');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['complaint_type'] = DB::table("complaint_type")->get();
      $data['source'] = DB::table("source")->get();
      $data['staff'] = DB::table("staff")->where("status", '1')->get(['id','name','surname']);
      $data['list'] = DB::table("complaint")->orderBy("id", 'DESC')->get();
      return view('admin.complaint', $data);
   }

   public function my_complaint(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'complaint_id' => trim($req->input('complaint_id')),
            'reply' => trim($req->input('reply')),
         );
         $insert = DB::table("complaint_reply")->insert($data);
         $data2 = array(
            'action_taken' => 'yes'
         );
         $update = DB::table("complaint")->where("id", $req->input('complaint_id'))->update($data2);
         if ($insert) {
            $req->session()->flash('success', 'Complaint reply added successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $userInfo = $req->session()->get('userInfo');
      $uid = $userInfo['id'];
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table("complaint")->where("staff_id", $uid)->get();
      return view('admin.my_complaint', $data);
   }

   public function frontmenu(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'menu' => $req->input('menu'),
            'description' => $req->input('description'),
            'slug' => strtolower(preg_replace('/  */', '-', $req->input('menu'))),

         );
         if ($req->input('uid') != '') {
            $run = DB::table('front_cms_menus')->where('id', $req->input('uid'))->update($data);
         } else {
            $run =  DB::table('front_cms_menus')->insert($data);
         }

         if ($run) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/frontmenu');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::table('front_cms_menus')->where("id", $req->input('uid'))->first();
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::table('front_cms_menus')->get();
      return view('admin/front_menu', $data);
   }

   public function addmenuitem(Request $req, $id)
   {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
         $page_id = $req->input('page_id') ? $req->input('page_id') : 0;
         $data = array(
            'menu_id' => $req->input('menu_id'),
            'menu' => $req->input('menu'),
            'ext_url' => $req->input('ext_url'),
            'ext_url_link' => $req->input('ext_url_link'),
            'page_id' => $page_id,
            'open_new_tab' => $req->input('open_new_tab'),
         );
         if ($req->input('uid') != '') {
            $run = DB::table('front_cms_menu_items')->where("id", $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect(url('admin/addmenuitem/' . $id));
         }
         $run = DB::table('front_cms_menu_items')->insert($data);
         if ($run) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $data['pages'] = DB::table("front_cms_pages")->get();
      $data['menu'] = DB::table("front_cms_menu_items")->where('parent_id', 0)->where('menu_id', $id)->orderBy('weight')->get();
      $data['res'] = DB::table('front_cms_menu_items')->where('id', $req->input('uid'))->first();
      return view('admin/addmenuitem', $data);
   }

   public function updateMenu(Request $req)
   {

      $order  = ($req->input('order'));

      $weight = 1;
      $array  = array();
      foreach ($order as $o_key => $o_value) {

         $array[] = array('id' => $o_value['id'], 'parent_id' => 0, 'weight' => $weight);
         if (isset($o_value['children'])) {
            $weight++;
            foreach ($o_value['children'] as $key => $value) {

               $array[] = array('id' => $value['id'], 'parent_id' => $o_value['id'], 'weight' => $weight);
               $weight++;
            }
         }
         $weight++;
      }

      foreach ($array as $run => $value) {

         $data = array(
            'parent_id' => $value['parent_id'],
            'weight' => $value['weight'],
         );
         $update = DB::table('front_cms_menu_items')->where('id', $value['id'])->update($data);
      }
   }
   public function deleteMenu(Request $req)
   {
      $id = $req->input('id');
      $delete = DB::table('front_cms_menu_items')->where('id', $id)->delete();
      if ($delete) {
         echo '1';
      } else {
         echo '0';
      }
   }
}
