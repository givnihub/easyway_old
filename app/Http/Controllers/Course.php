<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseModel;

class Course extends Controller
{
    public function index(Request $req)
    {
        if ($req->input('delid') != '') {
            $deletedfolder = DB::table('folders')->Where('course_id', '=', $req->input('delid'))->delete();
            $deletedcourse = DB::table('courses')->Where('id', '=', $req->input('delid'))->delete();
            $deletedcourseteacher = DB::table('course_teacher')->where('course_id', '=', $req->input('delid'))->delete();
 
            $req->session()->flash('success', 'Folder Deleted succesfully...');
            return redirect('admin/course');
            //  exit;
        }
        if ($req->input('id') != '') {
            if ($req->input('status') == '0') {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array(
                'status' => $status
            );
            $update = DB::table("courses")->where('id', $req->input('id'))->update($data);
            return redirect($_SERVER['HTTP_REFERER']);
        }

        // $course = CourseModel::all();
        $userInfo = $req->session()->get('userInfo');
        $role = $userInfo['role'];
        $teacher_id = $userInfo['id'];
        $is_superadmin = DB::table("roles")->where("id", $role)->where("is_superadmin", 1)->count();
        if ($is_superadmin > 0) {
            $data['course'] = DB::table("course_teacher")->select('course_id')->distinct()->orderBy("course_id")->get();
        } else {
            $data['course'] = DB::table("course_teacher")->where("teacher_id", $teacher_id)->orderBy("course_id")->get();
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        return view('course.index', $data);
    }
    public function addcourse(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($req->input('uid') != '') {
                $check = DB::table("courses")->where("id", $req->input('uid'))->get()->first();
                $course_thumbnail_url = $check->course_thumbnail;
            }

            if ($req->file('course_thumbnail') != '') {
                $course_thumbnail = $req->file('course_thumbnail')->getClientOriginalName();
                $course_thumbnail_url = $req->file('course_thumbnail')->move('public/uploads/course', $course_thumbnail);
            }
            $trade_id = implode(",", $req->input('trade_id'));

            $data = array(
                'title' => trim($req->input('title')),
                'course_type' => trim($req->input('course_type')),
                'tradegroup_id' => trim($req->input('tradegroup_id')),
                'trade_id' => $trade_id,
                'validity' => trim($req->input('validity')),
                'expiry' => trim($req->input('expiry')),
                'liveclass' => trim($req->input('liveclass')),
                'course_provider' => trim($req->input('course_provider')),
                'course_url' => trim($req->input('course_url')),
                'price' => trim($req->input('course_price')),
                'discount' => trim($req->input('course_discount')),
                'free_course' => trim($req->input('free_course')),
                'description' => trim($req->input('description')),
                'course_thumbnail' => $course_thumbnail_url,
                'tag' => trim($req->input('tag'))
            );

            if ($req->input('uid') != '') {
                $insert =  DB::table('courses')->where("id", $req->input('uid'))->update($data);
                DB::table("course_teacher")->where("course_id", $req->input('uid'))->delete();
                for ($i = 0; $i < count($req->input('teacher')); $i++) {
                    $data2 = array(
                        'teacher_id' => $req->input('teacher')[$i],
                        'course_id' => $req->input('uid'),
                    );
                    DB::table('course_teacher')->insert($data2);
                }
                $req->session()->flash('success', 'Course updated successfully...');
                return redirect('admin/course');
            } else {
                $insert =  DB::table('courses')->insert($data);
                $id = DB::getPdo()->lastInsertId();
                for ($i = 0; $i < count($req->input('teacher')); $i++) {
                    $data = array(
                        'teacher_id' => $req->input('teacher')[$i],
                        'course_id' => $id,
                    );
                    DB::table('course_teacher')->insert($data);
                }
                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect('admin/addcontent/' . $id);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
        if ($req->input('uid') != '') {

            $data['res'] = DB::table("courses")->where("id", $req->input('uid'))->get()->first();
        }

        $userInfo = $req->session()->get('userInfo');
        $role = $userInfo['role'];
        $data['is_superadmin'] = DB::table("roles")->where("id", $role)->where("is_superadmin", 1)->count();
        $data['teacher_id'] = $userInfo['id'];

        $data['staff'] = DB::table('staff')->where('status', '1')->get();
        $data['tradegroup'] = DB::table('tradegroup')->where('status', 1)->get();
        $data['course_type'] = DB::table('course_type')->where('status', '1')->get();
        return view('course.addcourse', $data);
    }
    public function addcontent(Request $req, $id)
    {
        $data['list'] = DB::table("courses")->where("id", $id)->get();
        $data['folder'] = DB::table("folders")->where('parent_folder_id', '0')->where('course_id', $id)->get();
        if ($req->input('delfolder') != '') {

            $deleted = DB::table('folders')->where('id', '=', $req->input('delfolder'))->delete();
            $req->session()->flash('success', 'Folder Deleted succesfully...');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        if ($req->input('fid') != '') {
            $data['ress'] = DB::table("folders")->where('id', $req->input('fid'))->get()->first();
        }
        if ($req->input('docid') != '') {
            $data['doc'] = DB::table("course_document")->where('id', $req->input('docid'))->get()->first();
        }
        if ($req->input('videoid') != '') {
            $data['video'] = DB::table("videos")->where('id', $req->input('videoid'))->get()->first();
        }
        return view('course.addcontent', $data);
    }
    public function createfolder(Request $req)
    {
            $folderid = trim($req->input('id')) . random_int(00000000, 99999999).idate('d').idate('H').idate('m');
        $data = array(
            'course_id' => trim($req->input('id')),
            'folders' => trim($req->input('folder')),
            'folder_id' => $folderid
        );

        if ($req->input('folderid') != '') {
            $data = array(
                'course_id' => trim($req->input('id')),
                'folders' => trim($req->input('folder')),

            );

            $update =  DB::table('folders')->where('id', $req->input('folderid'))->update($data);
            $req->session()->flash('success', 'Folder updated successfully...');
            return redirect('admin/addcontent/' . $req->input('id'));
            exit;
        }
        $insert =  DB::table('folders')->insert($data);
        if ($insert) {
            $req->session()->flash('success', 'Folder created successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
        } else {
            $req->session()->flash('error', 'Some error occured while creating folders...');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function adddocument(Request $req)
    {

        if ($req->input('docid') != '') {
            $check = DB::table("course_document")->where("id", $req->input('docid'))->get()->first();
            $document_url = $check->document;
            if ($req->file('document') != '') {
                $documentname = $req->file('document')->getClientOriginalName();
                $file_type = $req->file('document')->extension();
                if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg' || $file_type == 'JPG' || $file_type == 'PNG' || $file_type == 'webp' || $file_type == 'docx' || $file_type == 'pdf') {
                    $document_url =  $req->file('document')->move('public/uploads/documents', $documentname);
                } else {
                    echo 'Please choose only png,pdf,docx,jpeg,jpg,webp files...';
                    exit;
                }
            }
            $data = array(
                'course_id' => trim($req->input('course_id')),
                'folder_id' => trim($req->input('folder_id')),
                'doc_name' => trim($req->input('doc_name')),
                'description' => trim($req->input('description')),
                'document' => $document_url
            );
            $update = DB::table('course_document')->where("id", $req->input('docid'))->update($data);

            echo 'Document Updated successfully...';
            exit;
        }
        for ($i = 0; $i < count($req->file('document')); $i++) {
            $document = $req->file('document')[$i];
            if ($document != '') {
                $documentname =  $document->getClientOriginalName();
                $file_type = $document->extension();
                if ($file_type == 'jpg' || $file_type == 'png' || $file_type == 'jpeg' || $file_type == 'JPG' || $file_type == 'PNG' || $file_type == 'webp' || $file_type == 'docx' || $file_type == 'pdf') {
                    $document_url =  $document->move('public/uploads/documents', $documentname);
                } else {
                    echo 'Please choose only png,pdf,docx,jpeg,jpg,webp files...';
                    exit;
                }
            }
            $data = array(
                'course_id' => trim($req->input('course_id')),
                'folder_id' => trim($req->input('folder_id')),
                'doc_name' => trim($req->input('doc_name')),
                'description' => trim($req->input('description')),
                'document' => $document_url
            );
            $last_id = DB::table("course_document")->orderBy("id", "desc")->limit('1')->first(['order_id']);
            $data['order_id'] = $last_id->order_id + 1;
            $insert = DB::table('course_document')->insert($data);
        }
        if ($insert) {
            echo 'Document uploaded successfully...';
        } else {
            echo 'Some error occured while uploading documents...';
        }
    }
    public function subfolder(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           $folderid = trim($req->input('course_id')) . random_int(00000000, 99999999).idate('d').idate('H').idate('m');
            $data = array(
                'course_id' => trim($req->input('course_id')),
                'folders' => trim($req->input('folder_id')),
                'parent_folder_id' => trim($req->input('parent_folder_id')),
                'folder_id' => $folderid
            );
            $insert =  DB::table('folders')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Folder created successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured while creating folders...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function viewcontents(Request $req, $id)
    {
        $data['list'] = DB::table("courses")->where("id", $id)->get();
        return view('course/viewcontent', $data);
    }
    public function importcontents(Request $req, $id)
    {
        $res = $data['folder'] = DB::table("folders")->where("course_id", $id)->where("status", 1)->get();

        $data['list'] = DB::table("courses")->where("id", $id)->get();
        return view('course.importcontents', $data);
    }
    public function import(Request $req)
    {
        //map folder and courseid
        $course_id = $req->input('coursid');
        if ($req->input('folderid') != 0) {
            for ($i = 0; $i < count($req->input('folderid')); $i++) {
                $folderid = $req->input('folderid')[$i];
                $count = DB::table("folders")->where("folder_id", $folderid)->where("course_id", $course_id)->count();
                $foldername = DB::table("folders")->where("folder_id", $folderid)->get()->first();
                $data = array(
                    'course_id' => $course_id,
                    'folder_id' => $folderid,
                    'parent_folder_id' => $req->input('parent_folder_id'),
                    'folders' => $foldername->folders
                );
                 if ($count <= 0) {
                    $insert = DB::table("folders")->insert($data);
                }else{
                    $req->session()->flash('error', 'This course is already exists...');
                }
            }
        }
        //map testseries
        if ($req->input('examid') != 0) {
            for ($i = 0; $i < count($req->input('examid')); $i++) {
                $exam_id = $req->input('examid')[$i];
                $count = DB::table("course_exam")->where("course_id", $course_id)->where("exam_id", $exam_id)->count();
                $data = array(
                    'course_id' => $course_id,
                    'exam_id' => $exam_id,
                    'folder_id' => $req->input('parent_folder_id')
                );
                if ($count <= 0) {
                    $insert = DB::table("course_exam")->insert($data);
                }
            }
        }
        //map course and documentid
        if ($req->input('docids') != 0) {
            for ($i = 0; $i < count($req->input('docids')); $i++) {
                $docids = $req->input('docids')[$i];
                $docs = DB::table("course_document")->where("id", $docids)->first();
                $count = DB::table("course_document")->where("course_id", $course_id)->where("doc_name", $docs->doc_name)->count();
                $data = array(
                    'course_id' => $course_id,
                    'folder_id' => $req->input('parent_folder_id'),
                    'doc_name' => $docs->doc_name,
                    'description' => $docs->description,
                    'document' => $docs->document,
                    'download_status' => $docs->download_status,
                    'order_id' => $docs->order_id + 1,
                );
                if ($count <= 0) {
                    $insert = DB::table("course_document")->insert($data);
                }
            }
        }
        //map videos and courseid
        if ($req->input('videoids') != 0) {
            for ($i = 0; $i < count($req->input('videoids')); $i++) {
                $videoids = $req->input('videoids')[$i];
                $video = DB::table('videos')->where("id", $videoids)->first(['video_id', 'title', 'description', 'order_id']);
                $count = DB::table("videos")->where("course_id", $course_id)->where("video_id", $videoids)->count();
                $data = array(
                    'course_id' => $course_id,
                    'video_id' => $video->video_id,
                    'folder_id' => $req->input('parent_folder_id'),
                    'title' => $video->title,
                    'description' => $video->description,
                    'order_id' => $video->order_id + 1,
                );
                if ($count <= 0) {
                    $insert = DB::table("videos")->insert($data);
                }
            }
        }
        $req->session()->flash('success', 'Inserted successfully...');
        return redirect($_SERVER['HTTP_REFERER']);
    }



    public function demovideo(Request $req, $id)
    {
        if ($req->input('delid') != '') {
            $deleted = DB::table('demo_videos')->Where('id', $req->input('delid'))->delete();
            $req->session()->flash('success', 'Video Deleted succesfully...');
            return redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
        if ($req->input('id') != '') {
            if ($req->input('status') == '1') {
                $status = 0;
            } else {
                $status = 1;
            }
            $data = array(
                'status' => $status,
            );
            DB::table("demo_videos")->where("id", $req->input('id'))->update($data);
            $req->session()->flash('success', 'Status updated successfully...');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'course_id' => $req->input('course_id'),
                'title' => trim($req->input('title')),
                'video_id' => trim($req->input('video_id')),
                'description' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $req->input('description')),
            );
            if ($req->input('uid') != '') {
                $update = DB::table("demo_videos")->where("id", $req->input('uid'))->update($data);
                $req->session()->flash('success', 'Demo video updated successfully...');
                return redirect('admin/demovideo/' . $req->input('course_id'));
                exit;
            }
            $insert = DB::table("demo_videos")->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Demo video added successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('Error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($req->input('uid') != '') {
            $data['res'] = DB::table("demo_videos")->where("id", $req->input('uid'))->get()->first();
        }
        $data['list'] = DB::table("courses")->where("id", $id)->get();
        $data['videos'] = DB::table("demo_videos")->where("course_id", $id)->get();
        return view('course.demovideo', $data);
    }
    public function details(Request $req, $id)
    {
        $res = $data['res'] = DB::table("courses")->where('id', $id)->first();
        $data['payType'] = DB::table("course_payment")->where("course_id", $id)->count();
        $data['demovideos'] = DB::table("demo_videos")->where('course_id', $id)->get();
        $data2 = array(
            'view_count' => $res->view_count + 1,
        );
        $userInfo = $req->session()->get('userInfo');
        $data['role_id'] = $userInfo['role'];
        DB::table("courses")->where("id", $id)->update($data2);
      
            if($userInfo['role']=='student'){
            $data3=array(
                'courseid'=>$id,
                'userid'=>$userInfo['id'],
                   'cdate'=>date('Y-m-d H:i:s')
            );
            $insertCourseViewCount=DB::table('courseViewCount')->insert($data3);
        } 
        
        return view('course.details', $data);
    }
    public function startlesson(Request $req, $id)
    {
        $userInfo = $req->session()->get('userInfo');
        $email = $userInfo['email'];
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        $payment_status = DB::table("course_payment")->where("email", $email)->where("course_id", $id)->where("status", "captured")->count();
        if ($payment_status > 0) {
            $data['list'] = DB::table("courses")->where("id", $id)->first();
            return view('course.startlesson', $data);
        } else {
            $req->session()->flash('Error', 'Please purchased the course first...');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function course_category(Request $req)
    {
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'type' => trim($req->input('title')),
                'description' => trim($req->input('description')),
                'url' => trim($req->input('url')),
                'meta_title' => trim($req->input('meta_title')),
                'meta_keyword' => trim($req->input('meta_keywords')),
                'meta_description' => trim($req->input('meta_description')),
                'feature_image' => trim($req->input('image')),
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('course_type')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('admin/course-category');
            } else {
                $req->validate([
                    'title' => 'required|unique:course_type,type',
                ]);
                $insert =  DB::table('course_type')->insert($data);
                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
        if (!empty($req->input('uid'))) {
            $status = $req->input('status');
            if ($status == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $data = array(
                'status' => $status
            );
            $update = Db::table("course_type")->where("id", $req->input('uid'))->update($data);
            return redirect('admin/course-category');
        }
        if ($req->input('delid')) {
            $delete = Db::table("course_type")->where("id", $req->input('delid'))->delete();
            $req->session()->flash('success', 'Deleted successfully...');
            return redirect('admin/course-category');
        }
        if (!empty($req->input('id'))) {
            $data['list'] = DB::table("course_type")->get();
            $data['row'] = DB::select('select * from course_type where id=' . $req->input('id'));
            return view('course.course_category', $data);
        } else {
            $data['list'] = DB::table("course_type")->get();
            return view('course.course_category', $data);
        }
    }

    public function report(Request $req)
    {
        return view('course.report');
    }
    public function reportType(Request $req, $type)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($type == 'coursepurchase') {
                $search_type = $data['search_type'] = $req->input('search_type');
                $payment_type = $data['payment_type'] = $req->input('payment_type');

                if ($search_type == 'today') {
                    $date = "DATE_FORMAT(p.cdate, '%Y-%m-%d') = CURDATE()";
                } elseif ($search_type == 'this_week') {
                    $date = 'YEARWEEK(p.cdate) = YEARWEEK(NOW())';
                } elseif ($search_type == 'last_week') {
                    $date = 'YEARWEEK(p.cdate) = YEARWEEK(NOW())-1';
                } elseif ($search_type == 'this_month') {
                    $date = 'month(p.cdate)';
                } elseif ($search_type == 'last_month') {
                    $date = 'month(p.cdate)=month(now())-1';
                } elseif ($search_type == 'last_3_month') {
                    $date = 'p.cdate > now() - INTERVAL 3 MONTH';
                } elseif ($search_type == 'last_6_month') {
                    $date = 'p.cdate > now() - INTERVAL 6 MONTH';
                } elseif ($search_type == 'last_12_month') {
                    $date = 'p.cdate > now() - INTERVAL 12 MONTH';
                } elseif ($search_type == 'this_year') {
                    $date = 'year(p.cdate)';
                } elseif ($search_type == 'last_year') {
                    $date = 'month(p.cdate)=year(now())-1';
                } elseif ($search_type == 'period') {

                    $date_from = $data['date_from'] = $req->input('date_from');
                    
                
                    $date_to  = $data['date_to'] = $req->input('date_to');
                   $date = 'p.cdate >= "' . $date_from . '" AND DATE(p.cdate) <= "' . $date_to . '"';
                }
                if ($payment_type == 'Offline') {
                    $condition = "$date and p.method='Offline'";
                } elseif ($payment_type == 'Online') {
                    $condition = "$date and p.method!='Offline'";
                } else {
                    $condition = "$date";
                }
                $data['student_course'] = DB::select("select p.*,c.title,s.firstname,s.lastname,s.admission_no,s.id as studentid from course_payment as p LEFT JOIN courses as c ON c.id=p.course_id LEFT JOIN students as s ON s.email=p.email where $condition");
                return view('course.report', $data);
                exit;
            }
        }
        if ($type == 'coursesellreport') {
            $data['list'] = DB::table("courses")->get(['title', 'id', 'tradegroup_id', 'trade_id', 'created_by']);
            return view('course.coursesellreport', $data);
        } elseif ($type == 'trendingreport') {
            $data['list'] = DB::table("courses")->orderBy("view_count", "desc")->get(['title', 'id', 'tradegroup_id', 'trade_id', 'created_by', 'view_count', 'price', 'discount']);
            return view('course.coursesellreport', $data);
        } elseif ($type == 'notpurchase') {
          $res=  $data['list'] = DB::table("students")
          ->leftJoin('course_payment', 'course_payment.email', '=', 'students.email')
          ->whereNull('course_payment.email')
          ->get([ 'students.id', 'students.firstname', 'students.lastname', 'students.email', 'students.admission_no', 'students.mobileno','students.cdate','students.status','students.type']);
          return view('course.coursesellreport', $data);
        }else {
            return view('course.report');
        }
    }
     public function viewReport(Request $req,$id){
         $courseid = $id;
       
        $data['list'] = DB::select("select p.*,c.title,s.firstname,s.lastname,s.admission_no,s.id as studentid,s.mobileno,c.title from course_payment as p LEFT JOIN courses as c ON c.id=p.course_id LEFT JOIN students as s ON s.email=p.email where p.course_id=$courseid");
        return view('course.ajax_selldata', $data);
    }
    public function countView(Request $req,$id){
      
              $data['list'] = DB::table("courseViewCount as cnt")
            ->Join('students as s', 's.id', '=', 'cnt.userid')
            ->Join('courses as c', 'c.id', '=', 'cnt.courseid')
            ->groupBy('cnt.userid')
            ->where('cnt.courseid', $id)
            ->get(['cnt.id', 'c.title','s.id as studentid', 's.firstname', 's.email', 's.mobileno', 'cnt.cdate','cnt.courseid']);

        return view('course.countView', $data);
   }
   
   
   public function enrolledStudents(Request $req,$id){
    $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
    $data['perm_cat_id']= $cat_id->id;
    $data['role_id']=session()->get('userInfo')['role'];
        $data['list']=DB::table("course_payment as p")
        ->join("students as s","s.email","=","p.email")
        ->where("p.course_id",$id)->get(['p.id','p.status','p.cdate','s.firstname','p.method']);
        return view('course.enrolledStudents',$data);
   }
}
