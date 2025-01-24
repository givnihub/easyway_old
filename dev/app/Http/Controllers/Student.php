<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Student extends Controller
{
   public function create(Request $req)
   {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        
         if ($req->input('uid') != '') {

            $check = DB::table("students")->where("id", $req->input('uid'))->get()->first();
            $photo_url = $check->photo;
            $first_doc_url = $check->first_doc;
            $second_doc_url = $check->second_doc;
            $third_doc_url = $check->third_doc;
            $fourth_doc_url = $check->fourth_doc;


            if ($req->file('file') != '') {
               $req->validate([
                  'file' => 'mimes:png,jpg,jpeg,webp|max:2048'
               ]);
               $photo = $req->file('file')->getClientOriginalName();
               $photo_url = $req->file('file')->move('public/uploads/student_documents/online_admission_doc', $photo);
            }
            if ($req->file('first_doc') != '') {
               $req->validate([
                  'first_doc' => 'mimes:png,jpg,jpeg,webp|max:2048'
               ]);
               $first_doc = $req->file('first_doc')->getClientOriginalName();
               $first_doc_url = $req->file('first_doc')->move('public/uploads/student_documents/online_admission_doc', $first_doc);
            }
            if ($req->file('second_doc') != '') {
               $req->validate([
                  'second_doc' => 'mimes:png,jpg,jpeg,webp|max:2048'
               ]);
               $second_doc = $req->file('second_doc')->getClientOriginalName();
               $second_doc_url = $req->file('second_doc')->move('public/uploads/student_documents/online_admission_doc', $second_doc);
            }
            if ($req->file('third_doc') != '') {
               $req->validate([
                  'third_doc' => 'mimes:png,jpg,jpeg,webp|max:2048'
               ]);
               $third_doc = $req->file('third_doc')->getClientOriginalName();
               $third_doc_url = $req->file('third_doc')->move('public/uploads/student_documents/online_admission_doc', $third_doc);
            }
            if ($req->file('fourth_doc') != '') {
               $req->validate([
                  'fourth_doc' => 'mimes:png,jpg,jpeg,webp|max:2048'
               ]);
               $fourth_doc = $req->file('fourth_doc')->getClientOriginalName();
               $fourth_doc_url = $req->file('fourth_doc')->move('public/uploads/student_documents/online_admission_doc', $fourth_doc);
            }
            $data = array(
               'class_id' => trim($req->input('class_id')),
               'batch_id' => trim($req->input('batch_id')),
               'firstname' => trim($req->input('firstname')),
               'lastname' => trim($req->input('lastname')),
               'gender' => trim($req->input('gender')),
               'dob' => trim($req->input('dob')),
               'mobileno' => trim($req->input('mobileno')),
               // 'email' => trim($req->input('email')),
               'admission_date' => trim($req->input('admission_date')),
               'address' => trim($req->input('address')),
               'father_name' => trim($req->input('father_name')),
               'father_phone' => trim($req->input('father_phone')),
               'hostel_id' => trim($req->input('hostel_id')),
               'hostel_room_id' => trim($req->input('hostel_room_id')),
               'first_title' => trim($req->input('first_title')),
               'second_title' => trim($req->input('second_title')),
               'third_title' => trim($req->input('third_title')),
               'fourth_title' => trim($req->input('fourth_title')),
               'photo' => $photo_url,
               'first_doc' => $first_doc_url,
               'second_doc' => $second_doc_url,
               'third_doc' => $third_doc_url,
               'fourth_doc' => $fourth_doc_url,
               'aadhaar' => trim($req->input('aadhaar')),
               'pincode' => trim($req->input('pincode')),
               'state_id' => trim($req->input('state_id')),
               'city_id' => trim($req->input('city_id')),
               'form_status' => 1
            );
            if ($req->input('save') == 'save') {
               $data2 = array(
                  'roll_no' => $req->input('roll_no'),
               );
               $data = array_merge($data, $data2);
            }
            if ($req->input('save') == 'enroll') {
               $data2 = array(
                  'roll_no' => $req->input('roll_no'),
                  'enrolled_status' => 1
               );
               $data = array_merge($data, $data2);
            }

            $update =  DB::table('students')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Record Updated successfully...');
            if ($req->input('submittedby') == 'admin') {
               if($req->input('redirect_type')==0){
                  return redirect(url('student/offlinestudent'));
               }else{
                  return redirect(url('student/onlinestudent'));
               }
              
            } else {
               return redirect('online_admission_review');
            }

            exit;
         }


         if ($req->file('file') != '') {
            $photo = $req->file('file')->getClientOriginalName();
            $photo_url = $req->file('file')->move('public/uploads/student_documents/online_admission_doc', $photo);
         }
         if ($req->file('first_doc') != '') {
            $first_doc = $req->file('first_doc')->getClientOriginalName();
            $first_doc_url = $req->file('first_doc')->move('public/uploads/student_documents/online_admission_doc', $first_doc);
         }
         if ($req->file('second_doc') != '') {
            $second_doc = $req->file('second_doc')->getClientOriginalName();
            $second_doc_url = $req->file('second_doc')->move('public/uploads/student_documents/online_admission_doc', $second_doc);
         }
         if ($req->file('third_doc') != '') {
            $third_doc = $req->file('third_doc')->getClientOriginalName();
            $third_doc_url = $req->file('third_doc')->move('public/uploads/student_documents/online_admission_doc', $third_doc);
         }
         if ($req->file('fourth_doc') != '') {
            $fourth_doc = $req->file('fourth_doc')->getClientOriginalName();
            $fourth_doc_url = $req->file('fourth_doc')->move('public/uploads/student_documents/online_admission_doc', $fourth_doc);
         }

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

         $roll_no = trim($req->input('admission_no')) . date("y") . 'R' . $rollno;
         $req->validate([
            'roll_no' => 'required|unique:students,roll_no',
            'admission_no' => 'required|unique:students,admission_no',
            'aadhaar' => 'required|unique:students,aadhaar',
            'email' => 'required|unique:students,email',
            'mobileno' => 'required|unique:students,mobileno',
         ]);
         $data = array(
            'roll_no' => trim($req->input('roll_no')) == '' ? $roll_no : trim($req->input('roll_no')),
            'class_id' => trim($req->input('class_id')),
            'batch_id' => trim($req->input('batch_id')),
            'firstname' => trim($req->input('firstname')),
            'lastname' => trim($req->input('lastname')),
            'gender' => trim($req->input('gender')),
            'dob' => trim($req->input('dob')),
            'mobileno' => trim($req->input('mobileno')),
            'email' => trim($req->input('email')),
            'admission_date' => trim($req->input('admission_date')),
            'address' => trim($req->input('address')),
            'father_name' => trim($req->input('father_name')),
            'father_phone' => trim($req->input('father_phone')),
            'hostel_id' => trim($req->input('hostel_id')),
            'hostel_room_id' => trim($req->input('hostel_room_id')),
            'first_title' => trim($req->input('first_title')),
            'second_title' => trim($req->input('second_title')),
            'third_title' => trim($req->input('third_title')),
            'fourth_title' => trim($req->input('fourth_title')),
            'admission_no' => $admission_no,
            'photo' => $photo_url,
            'first_doc' => $first_doc_url,
            'second_doc' => $second_doc_url,
            'third_doc' => $third_doc_url,
            'fourth_doc' => $fourth_doc_url,
            'aadhaar' => trim($req->input('aadhaar')),
            'pincode' => trim($req->input('pincode')),
            'state_id' => trim($req->input('state_id')),
            'city_id' => trim($req->input('city_id')),
            'type' => trim($req->input('type')),
         );

         $insert =  DB::table('students')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Admission successful...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }

      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      $data['hostel'] = DB::table('hostel')->where('is_active', 'yes')->get();
      $data['state'] = DB::select('select id,name from states  order by name asc');
      return view('student.create', $data);
   }
   public function search(Request $req)
   {
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         if ($req->input('search_text') != '') {
            $keyword = $req->input('search_text');

            $data['rows'] = DB::select('select * from students where (firstname like "%' . $keyword . '%" or mobileno like "%' . $keyword . '%" or admission_no like "%' . $keyword . '%" or email like "%' . $keyword . '%")  order by firstname asc');
         } else {
            $data['batches'] = DB::select('select batch from batches where id=' . $req->input('batch_id'));
            $data['classes'] = DB::select('select class from classes where id=' . $req->input('class_id'));
            $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ' and status=0 and enrolled_status=1 and form_status=1 and pay_status=1) order by firstname asc');
         }
      }
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      return view('student/search', $data);
   }

   public function view(Request $req, $id)
   {

      $res = $data['row'] = DB::table('students')->where('id', $id)->first();
      $data['rfee'] = DB::table('online_admission_payment')->where('uid', $id)->first();
      $data['course'] = DB::table('course_payment')
         ->leftJoin('courses', 'courses.id', '=', 'course_payment.course_id')
         ->where('course_payment.email', $res->email)->get(['courses.title', 'course_payment.amount', 'course_payment.cdate']);


      $data['reason'] = DB::table('disable_reason')->get();
      return view('student/view', $data);
   }
   public function disable_reason(Request $req)
   {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'disable_reasone' => trim($req->input('reason')),
            'disable_at' => trim($req->input('disable_date')),
            'disable_note' => trim($req->input('note')),
            'status' => 1,

         );
         $update =  DB::table('students')->where('id', $req->input('student_id'))->update($data);
         if ($update) {
            echo '1';
         } else {
            echo '0';
         }
      }

      if ($req->input('type') == 'enable') {
         $data = array(
            'disable_reasone' => '',
            'disable_at' => '',
            'disable_note' => '',
            'status' => 0,

         );
         echo  $update =  DB::table('students')->where('id', $req->input('studentid'))->update($data);
      }
   }

   public function disablestudentslist(Request $req)
   {
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         if ($req->input('search_text') != '') {
            $keyword = $req->input('search_text');

            $data['rows'] = DB::select('select * from students where (firstname like "%' . $keyword . '%" or mobileno like "%' . $keyword . '%" or admission_no like "%' . $keyword . '%" or email like "%' . $keyword . '%") and status=1 order by firstname asc');
         } else {

            $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ') and status=1 order by firstname asc');
         }
      }
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      return view('student/search', $data);
   }

   public function onlinestudent(Request $req)
   {
      if ($req->input('delid') != '') {
         $deleted = DB::table('students')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         redirect($_SERVER['HTTP_REFERER']);
      }
      $data['type'] = 'online';
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      $data['list'] = DB::table("students")->where("type", "1")->get();
      return view('student/onlinestudent', $data);
   }

   public function offlinestudent(Request $req)
   {
      if ($req->input('delid') != '') {
         $deleted = DB::table('students')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         redirect($_SERVER['HTTP_REFERER']);
      }
      $data['type'] = 'offline';
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      $data['list'] = DB::table("students")
      ->where("type", "0")
      // ->Where("pay_status", "0")
      // ->Where("form_status", "0")
      // ->Where("enrolled_status", "0")
      ->get();
      return view('student/onlinestudent', $data);
   }

   public function edit(Request $req, $id)
   {

      $data['res'] = DB::table('students')->where('id', $id)->get()->first();
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      $data['hostel'] = DB::table('hostel')->where('is_active', 'yes')->get();
      $data['state'] = DB::select('select id,name from states  order by name asc');
      return view('student.create', $data);
   }
   public function multiclass(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ' and status=0 and type=1) order by firstname asc');
      }
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      return view('student.multiclass', $data);
   }
   public function savemulticlass(Request $req)
   {
      $delete = DB::select('delete  from multi_class_students where student_id=' . $req->input('student_id'));
      $class_id = $req->input('class_id');
      for ($i = 0; count($class_id) > $i; $i++) {
         $data = array(
            'student_id' => $req->input('student_id'),
            'class_id' => $req->input('class_id')[$i],
            'batch_id' => $req->input('batch_id')[$i],

         );


         $insert =  DB::table('multi_class_students')->insert($data);
      }
      if ($insert) {
         echo '1';
      } else {
         echo '0';
      }
   }
   public function bulkdelete(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         if ($req->input('delete') == 'bulkdelete') {

            for ($i = 0; count($req->input('studentid')) > $i; $i++) {
               $delid = $req->input('studentid')[$i];
               $deleted = DB::table('students')->where('id', '=', $delid)->delete();
               $req->session()->flash('success', 'Deleted succesfully...');
            }


            return redirect($_SERVER['HTTP_REFERER']);
         }

         $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ') order by firstname asc');
      }
      $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
      $data['perm_cat_id'] = $cat_id->id;
      $data['role_id'] = session()->get('userInfo')['role'];
      $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
      return view('student.bulkdelete', $data);
   }
}
