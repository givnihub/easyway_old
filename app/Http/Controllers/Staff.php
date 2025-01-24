<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class Staff extends Controller
{
   public function designation(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'designation' => trim($req->input('designation')),
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('staff_designation')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/designation');
         }
         $req->validate([
            'designation' => 'required|unique:staff_designation,designation',

         ]);
         $insert =  DB::table('staff_designation')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/designation');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/designation');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from staff_designation where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('staff_designation')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/designation');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from staff_designation order by id asc');
      return view('staff.designation', $data);
   }

   public function department(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {


         $data = array(
            'department' => trim($req->input('department')),

         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('department')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/department');
         }
         $req->validate([
            'department' => 'required|unique:department,department',
         ]);
         $insert =  DB::table('department')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/department');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/department');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from department where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('department')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/department');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from department order by id asc');
      return view('staff.department', $data);
   }

   public function leavetype(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'type' => trim($req->input('type')),
         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('leave_types')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/leavetypes');
         }
         $req->validate([
            'type' => 'required|unique:leave_types,type',


         ]);
         $insert =  DB::table('leave_types')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/leavetypes');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/leavetypes');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from leave_types where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('leave_types')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/leavetypes');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from leave_types order by id asc');
      return view('staff.leavetype', $data);
   }
   public function roles(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $data = array(
            'name' => trim($req->input('name')),

         );
         if ($req->input('uid') != '') {
            $insert =  DB::table('roles')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/roles');
         }
         $req->validate([
            'name' => 'required|unique:roles,name',


         ]);
         $insert =  DB::table('roles')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect('admin/roles');
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect('admin/roles');
         }
      }
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from roles where id=' . $req->input('uid'));
      }
      if ($req->input('delid') != '') {
         $deleted = DB::table('roles')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect('admin/roles');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];

      $data['list'] = DB::select('select * from roles order by id asc');
      return view('staff.roles', $data);
   }
   public function staff(Request $req)
   {

      if ($req->delid != '') {
         $type = $req->input('type');
         $delid = $req->input('delid');
         $data = array(
            $type => ''
         );

         DB::table('staff')->where('id', $delid)->update($data);
         $req->session()->flash('success', 'Document deleted successfully...');
         return redirect($_SERVER['HTTP_REFERER']);
         exit;
      }
      $data['role'] = DB::select('select * from roles order by id asc');
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $search_text = $req->input('search_text');

         $role = $req->input('role');
         if ($role != '') {
            $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where role=' . $role . ' and status=1 order by id asc');
         }
         if ($search_text != '') {
            $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where name like "%' . $search_text . '%" OR surname like "%' . $search_text . '%" and status=1 order by id asc');
         }
      } else {
         $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where status=1 order by id asc');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      return view('staff.staff', $data);
   }
   public function staffCreate(Request $req)
   {


      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         if ($req->file('photo') != '') {
            $photo = $req->file('photo')->getClientOriginalName();
            $photo_url = $req->file('photo')->move('public/uploads/staff_documents', $photo);
         }
         if ($req->file('resume') != '') {
            $resume = $req->file('resume')->getClientOriginalName();
            $resume_url = $req->file('resume')->move('public/uploads/staff_documents', $resume);
         }
         if ($req->file('other_doc') != '') {
            $other_doc = $req->file('other_doc')->getClientOriginalName();
            $other_doc_url = $req->file('other_doc')->move('public/uploads/staff_documents', $other_doc);
         }
         if ($req->file('joining_letter') != '') {
            $joining_letter = $req->file('joining_letter')->getClientOriginalName();
            $joining_letter_url = $req->file('joining_letter')->move('public/uploads/staff_documents', $joining_letter);
         }
         if ($req->file('resignation_letter') != '') {
            $resignation_letter = $req->file('resignation_letter')->getClientOriginalName();
            $resignation_letter_url = $req->file('resignation_letter')->move('public/uploads/staff_documents', $resignation_letter);
         }
         if ($req->input('uid') != '') {

            $chek = DB::select('select * from staff where id=' . $req->input('uid'));
            if ($req->file('photo') == '') {
               $photo_url = $chek[0]->image;
            }
            if ($req->file('resume') == '') {
               $resume_url = $chek[0]->resume;
            }
            if ($req->file('other_doc') == '') {
               $other_doc_url = $chek[0]->other_document_file;
            }
            if ($req->file('joining_letter') == '') {
               $joining_letter_url = $chek[0]->joining_letter;
            }
            if ($req->file('resignation_letter') == '') {
               $resignation_letter_url = $chek[0]->resignation_letter;
            }
            $data = array(
               'role' => trim($req->input('role')),
               'designation' => trim($req->input('designation')),
               'department' => trim($req->input('department')),
               'name' => trim($req->input('name')),
               'surname' => trim($req->input('surname')),
               'father_name' => trim($req->input('father_name')),
               'mother_name' => trim($req->input('mother_name')),
               'email' => trim($req->input('email')),
               'gender' => trim($req->input('gender')),
               'dob' => trim($req->input('dob')),
               'date_of_joining' => trim($req->input('date_of_joining')),
               'contact_no' => trim($req->input('contactno')),
               'emergency_contact_no' => trim($req->input('emergency_no')),
               'marital_status' => trim($req->input('marital_status')),
               'local_address' => trim($req->input('address')),
               'permanent_address' => trim($req->input('permanent_address')),
               'qualification' => trim($req->input('qualification')),
               'work_exp' => trim($req->input('work_exp')),
               'note' => trim($req->input('note')),
               'commision' => trim($req->input('commision')),
               'code' => trim($req->input('code')),
               'epf_no' => trim($req->input('epf_no')),
               'basic_salary' => trim($req->input('basic_salary')),
               'contract_type' => trim($req->input('contract_type')),
               'shift' => trim($req->input('shift')),
               'location' => trim($req->input('location')),
               'festival_leave' => trim($req->input('festival_leave')),
               'emergency_leave' => trim($req->input('emergency_leave')),
               'regular_leave' => trim($req->input('regular_leave')),
               'account_title' => trim($req->input('account_title')),
               'bank_account_no' => trim($req->input('bank_account_no')),
               'bank_name' => trim($req->input('bank_name')),
               'ifsc_code' => trim($req->input('ifsc_code')),
               'bank_branch' => trim($req->input('bank_branch')),
               'facebook' => trim($req->input('facebook')),
               'twitter' => trim($req->input('twitter')),
               'linkedin' => trim($req->input('linkedin')),
               'instagram' => trim($req->input('instagram')),
               'image' => $photo_url,
               'resume' => $resume_url,
               'other_document_file' => $other_doc_url,
               'joining_letter' => $joining_letter_url,
               'resignation_letter' => $resignation_letter_url,
            );

            $insert =  DB::table('staff')->where('id', $req->input('uid'))->update($data);
            $req->session()->flash('success', 'Updated successfully...');
            return redirect('admin/staff');
            exit;
         }

         $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
         $password = substr($random, 0, 10);

         $data = array(
            'role' => trim($req->input('role')),
            'employee_id' => 'EWGE00' . rand(100, 99999),
            'designation' => trim($req->input('designation')),
            'department' => trim($req->input('department')),
            'name' => trim($req->input('name')),
            'surname' => trim($req->input('surname')),
            'father_name' => trim($req->input('father_name')),
            'mother_name' => trim($req->input('mother_name')),
            'email' => trim($req->input('email')),
            'gender' => trim($req->input('gender')),
            'dob' => trim($req->input('dob')),
            'date_of_joining' => trim($req->input('date_of_joining')),
            'contact_no' => trim($req->input('contactno')),
            'emergency_contact_no' => trim($req->input('emergency_no')),
            'marital_status' => trim($req->input('marital_status')),
            'local_address' => trim($req->input('address')),
            'permanent_address' => trim($req->input('permanent_address')),
            'qualification' => trim($req->input('qualification')),
            'work_exp' => trim($req->input('work_exp')),
            'note' => trim($req->input('note')),
            'commision' => trim($req->input('commision')),
            'code' => trim($req->input('code')),
            'epf_no' => trim($req->input('epf_no')),
            'basic_salary' => trim($req->input('basic_salary')),
            'contract_type' => trim($req->input('contract_type')),
            'shift' => trim($req->input('shift')),
            'location' => trim($req->input('location')),
            'festival_leave' => trim($req->input('festival_leave')),
            'emergency_leave' => trim($req->input('emergency_leave')),
            'regular_leave' => trim($req->input('regular_leave')),
            'account_title' => trim($req->input('account_title')),
            'bank_account_no' => trim($req->input('bank_account_no')),
            'bank_name' => trim($req->input('bank_name')),
            'ifsc_code' => trim($req->input('ifsc_code')),
            'bank_branch' => trim($req->input('bank_branch')),
            'facebook' => trim($req->input('facebook')),
            'twitter' => trim($req->input('twitter')),
            'linkedin' => trim($req->input('linkedin')),
            'instagram' => trim($req->input('instagram')),
            'image' => $photo_url,
            'resume' => $resume_url,
            'other_document_file' => $other_doc_url,
            'joining_letter' => $joining_letter_url,
            'resignation_letter' => $resignation_letter_url,
            'password' => Hash::make($password),
            'text_password' => $password
         );

         $req->validate([
            'email' => 'required|unique:staff,email',
            'role' => 'required',
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',


         ]);


         $insert =  DB::table('staff')->insert($data);

         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            // return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            // return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $data['role'] = DB::select('select * from roles order by id asc');
      $data['designation'] = DB::select('select * from staff_designation order by id asc');
      $data['department'] = DB::select('select * from department order by id asc');
      if ($req->input('uid') != '') {
         $data['res'] = DB::select('select * from staff where id=' . $req->input('uid'));
      }
      return view('staff.staffCreate', $data);
   }

   public function profile(Request $req)
   {
      if($_SERVER['REQUEST_METHOD']=='POST'){
         
         $data=array(
            'disable_at'=>$req->input('date'),
            'reason'=>$req->input('reason'),
            'status'=>$req->input('status'),
         );
         $disable=DB::table("staff")->where("id",$req->input('staff_id'))->update($data);
         $req->session()->flash('success', 'Staff status changed now...');
         return redirect($_SERVER['HTTP_REFERER']); 
      }

      $id = $req->input('id');
      $data['res'] = DB::select('select * from staff where id=' . $id);
      $data['payroll'] = DB::select('select * from staff_payslip where staff_id=' . $id . ' order by id desc limit 1');
      $data['payslip'] = DB::select('select * from staff_payslip where staff_id=' . $id);

      $data['leave_request'] = DB::select('select * from staff_leave_request where staff_id=' . $id . ' and status="approve"');
      $data['staff_attendance'] = DB::select('select * from staff_attendance where staff_id=' . $id);
      return view('staff.profile', $data);
   }
   public function payroll(Request $req)
   {

      if ($req->input('role') != '' && $req->input('month') != '' && $req->input('year') != '') {
         $data['role'] = $req->input('role');
         $data['month'] = $req->input('month');
         $data['year'] = $req->input('year');
         $data['list'] = DB::select('select id,name,surname,employee_id,role,department,designation,contact_no from staff where role=' . $req->input('role'));
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['roles'] = DB::select('select * from roles');
      return view('staff.payroll', $data);
   }
   public function payrollCreate(Request $req, $month, $year, $id)
   {

      $data['res'] = DB::select('select * from staff where id=' . $id);
      return view('staff.payrollCreate', $data);
   }
   public function payslip(Request $req)
   {

      $data = array(
         'allowance_type' => trim(implode(",", $req->input('allowance_type'))),
         'allowance_amount' => trim(implode(",", $req->input('allowance_amount'))),
         'deduction_type' => trim(implode(",", $req->input('deduction_type'))),
         'deduction_amount' => trim(implode(",", $req->input('deduction_amount'))),
         'basic' => trim($req->input('basic')),
         'total_allowance' => trim($req->input('total_allowance')),
         'total_deduction' => trim($req->input('total_deduction')),
         'gross_salary' => trim($req->input('gross_salary')),
         'tax' => trim($req->input('tax')),
         'net_salary' => trim($req->input('net_salary')),
         'staff_id' => trim($req->input('staff_id')),
         'month' => trim($req->input('month')),
         'year' => trim($req->input('year')),
         'status' => trim($req->input('status')),
      );
      $insert =  DB::table('staff_payslip')->insert($data);
      if ($insert) {
         $req->session()->flash('success', 'Payslip generated successfully...');
         return redirect('admin/payroll');
      } else {
         $req->session()->flash('error', 'Some error occured...');
         return redirect($_SERVER['HTTP_REFERER']);
      }
   }
   public function paymentSuccess(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $paymentid = $req->input('paymentid');
         $data = array(
            'payment_mode' => trim($req->input('payment_mode')),
            'payment_date' => trim($req->input('payment_date')),
            'remark' => trim($req->input('remarks')),
            'status' => 'Paid'
         );
         $insert =  DB::table('staff_payslip')->where('id', $paymentid)->update($data);
         $req->session()->flash('success', 'Updated successfully...');
         echo 'success';
         //  return redirect($_SERVER['HTTP_REFERER']);
      }
   }

   public function payrollRevert(Request $req, $month, $year, $id)
   {

      $staffid = $req->input('staff_id');
      $check = DB::select('select role from staff where id=' . $staffid);
      $role = $check[0]->role;
      $status = $req->input('status');

      if ($status == 'Paid') {
         $status = 'generated';
         $data = array(
            'payment_mode' => 'null',
            'payment_date' => 'null',
            'remark' => 'null',
            'status' => $status
         );
         $update =  DB::table('staff_payslip')->where('id', $id)->update($data);
      } else {
         $deleted = DB::table('staff_payslip')->where('id', '=', $id)->delete();
      }

      $req->session()->flash('success', 'Payment reverted successfully...');

      $data['role'] = $role;
      $data['month'] = $month;
      $data['year'] = $year;
      return redirect('admin/payroll?role=' . $role . '&month=' . $month . '&year=' . $year);
      exit;
      // $data['list'] = DB::select('select id,name,surname,employee_id,role,department,designation,contact_no from staff where role=' . $role);


      // $data['roles'] = DB::select('select * from roles');
      // return view('staff.payroll', $data);
      //return redirect($_SERVER['HTTP_REFERER']);
   }

   public function payslipView(Request $req)
   {

      $id = $req->input('payslipid');
      $data['res'] = DB::select('select * from staff_payslip where id=' . $id);
      return view('staff.payslipView', $data);
   }


   public function attendance(Request $req)
   {

      if ($req->input('staff_id') != '') {
         $staffid = $req->input('staff_id');
         foreach ($staffid as $val) {
            $data = array(
               'staff_id' => $val,
               'staff_attendance_type_id' => $req->input('attendencetype' . $val),
               'remark' => $req->input('remark' . $val),
               'date' => $req->input('date'),
               'role' => $req->input('user_id'),
            );
            if ($req->input('type') == '1') {
               $uid = $req->input('uid' . $val);
               $update =  DB::table('staff_attendance')->where('id', $uid)->update($data);
            } else {
               $insert =  DB::table('staff_attendance')->insert($data);
            }
         }

         if (!$insert) {
            $req->session()->flash('success', 'Updated successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $role = $data['user_id'] = $req->input('user_id');
      if ($req->input('date') == '') {
         $data['date'] = date('Y-m-d');
      } else {
         $data['date'] = $req->input('date');
      }


      $data['role'] = DB::select('select * from roles where is_active=0');
      if ($req->input('user_id') != '') {

         $data['attendance'] = DB::select('select id,date from staff_attendance where  role=' . $req->input('user_id') . ' and date="' . $req->input("date") . '"');
         $data['list'] = DB::select('select id,name,surname,employee_id,role from staff where status=1 and role=' . $req->input('user_id'));
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      return view('staff.attendance', $data);
   }
   public function leaverequest(Request $req)
   {
      if ($req->input('delid') != '') {
         $deleted = DB::table('staff_leave_request')->where('id', '=', $req->input('delid'))->delete();
         $req->session()->flash('success', 'Deleted succesfully...');
         return redirect($_SERVER['HTTP_REFERER']);
         exit;
      }
      $userInfo = $req->session()->get('userInfo');

      $id = $userInfo['id'];
      $res = $data['res'] = DB::select('select festival_leave,emergency_leave,regular_leave ,id from staff where id=' . $id);

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $diff = (strtotime($req->input('leave_to_date')) - strtotime($req->input('leave_from_date'))) / 24 / 3600;
         $leavetype = $req->input('leave_type');
         $rest_leave = $res[0]->$leavetype - $diff;
         if ($rest_leave <= 0) {
            $req->session()->flash('error', 'Sorry you exceeded the leave...');
            return redirect($_SERVER['HTTP_REFERER']);
            exit;
         }
         if ($req->file('userfile') != '') {
            $userfile = $req->file('userfile')->getClientOriginalName();
            $document_file = $req->file('userfile')->move('public/uploads/staff_documents', $userfile);
         }
         $data = array(
            'staff_id' => $id,
            'leave_type' => $req->input('leave_type'),
            'leave_from' => $req->input('leave_from_date'),
            'leave_to' => $req->input('leave_to_date'),
            'applieddate' => $req->input('applieddate'),
            'leave_days' => $diff,
            'employee_remark' => trim($req->input('reason')),
            'document_file' => $document_file,
            'status' => 'pending',
            'applied_by' => $userInfo['name'] . ' ' . $userInfo['surname'],
         );
         $insert =  DB::table('staff_leave_request')->insert($data);
         if ($insert) {
            $req->session()->flash('success', 'Inserted successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
         } else {
            $req->session()->flash('error', 'Some error occured...');
            return redirect($_SERVER['HTTP_REFERER']);
         }
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from staff_leave_request where staff_id=' . $id);
      return view('staff.leaverequest', $data);
   }

   public function changepassword(Request $req)
   {
      $id = $req->input('staff_id');

      $password = $req->input('new_pass');
      $confirm_pass = $req->input('password_confirmation');
      $req->validate(
         ['password_confirmation' => 'required|same:new_pass']

      );
      if ($errors) {
         echo '1';
         exit;
      }
      $data = array(
         'password' => Hash::make($password),
      );
      $insert =  DB::table('staff')->where('id', $id)->update($data);
   }
   public function approve_leaverequest(Request $req)
   {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

         $data = array(
            'status' => $req->input('status'),
            'admin_remark' => $req->input('detailremark'),
         );
         $update =  DB::table('staff_leave_request')->where('id', $req->input('leave_request_id'))->update($data);
         $req->session()->flash('success', $req->input('status') . ' successfully...');
         return redirect('admin/staff/approve_leaverequest');
         exit;
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      $data['list'] = DB::select('select * from staff_leave_request');
      return view('staff.approve_leavrequest', $data);
   }

   public function disablestafflist(Request $req)
   {

      if ($req->delid != '') {
         $type = $req->input('type');
         $delid = $req->input('delid');
         $data = array(
            $type => ''
         );

         DB::table('staff')->where('id', $delid)->update($data);
         $req->session()->flash('success', 'Document deleted successfully...');
         return redirect($_SERVER['HTTP_REFERER']);
         exit;
      }
      $data['role'] = DB::select('select * from roles order by id asc');
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
         $search_text = $req->input('search_text');

         $role = $req->input('role');
         if ($role != '') {
            $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where role=' . $role . ' and status=0 order by id asc');
         }
         if ($search_text != '') {
            $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where name like "%' . $search_text . '%" OR surname like "%' . $search_text . '%" and status=0 order by id asc');
         }
      } else {
         $data['list'] = DB::select('select id,name,employee_id,role,department,designation,qualification,image,email,contact_no,emergency_contact_no,commision,code from staff where status=0 order by id asc');
      }
      $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
      $data['perm_cat_id']= $cat_id->id;
      $data['role_id']=session()->get('userInfo')['role'];
      return view('staff.staff', $data);
   }
}
