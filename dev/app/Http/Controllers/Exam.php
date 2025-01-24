<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\ExamModel;

class Exam extends Controller
{
    public function index(Request $req)
    {
        if ($req->input('delid') != '') {
            $delexam = DB::table("onlineexam")->where("id", $req->input('delid'))->delete();
            $delexamquestion = DB::table("onlineexam_questions")->where("examid", $req->input('delid'))->delete();
            $req->session()->flash('success', 'Exam deleted succesfully...');
        }
        if ($req->input('id') != '') {
            if ($req->input('status') == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $data = array(
                'is_active' => $status
            );
            DB::table("onlineexam")->where("id", $req->input('id'))->update($data);
            $req->session()->flash('success', 'Status is changed succesfully...');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            $data = array(
                'is_quiz' => trim($req->input('is_quiz')),
                'is_live' => trim($req->input('is_live')),
                'onlinetest' => trim($req->input('onlinetest')),
                'exam' => trim($req->input('exam')),
                'exam_from' => trim($req->input('exam_from')),
                'exam_to' => trim($req->input('exam_to')),
                'auto_publish_date' => trim($req->input('auto_publish_date')),
                'duration' => trim($req->input('duration')),
                'attempt' => trim($req->input('attempt')),
                'passing_percentage' => trim($req->input('passing_percentage')),
                'is_active' => trim($req->input('is_active')),
                'publish_result' => trim($req->input('publish_result')),
                'is_neg_marking' => trim($req->input('is_neg_marking')),
                'is_marks_display' => trim($req->input('is_marks_display')) ? trim($req->input('is_marks_display')) : 0,
                'is_random_question' => trim($req->input('is_random_question')) ? trim($req->input('is_random_question')) : 0,
                'marks' => trim($req->input('marks')),
                'negative_marks' => trim($req->input('negative_marks')),
                'description' => trim($req->input('description')),
            );

            if ($req->input('uid') != '') {
                $insert = DB::table('onlineexam')->where("id", $req->input('uid'))->update($data);
                $req->session()->flash('success', 'Exam updated succesfully...');
                return redirect($_SERVER['HTTP_REFERER']);
                exit;
            }
            $insert = DB::table('onlineexam')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Exam created succesfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if($req->input('type')=='live'){
            $data['list'] = DB::table("onlineexam")->where("is_live",1)->get();
        }elseif($req->input('type')=='onlinetest'){
            $data['list'] = DB::table("onlineexam")->where("onlinetest",1)->get();
        }elseif($req->input('type')=='quize'){
            $data['list'] = DB::table("onlineexam")->where("is_quiz",1)->get();
        }else{
            $data['list'] = DB::table("onlineexam")->get();
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        return view('exam.onlineexam', $data);
    }
   public function question(Request $req)
    {
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        $tradegroup= $data['tradegroupid'] = $_GET['tradegroup'];
        $trade= $data['tradeid'] = $_GET['trade'];
        $subject= $data['subjectid'] = $_GET['subject'];
        $chapter= $data['chapterid'] = $_GET['chapter'];
        $topic= $data['tradegroupid'] = $_GET['topic'];
   if($tradegroup!='' && $trade!='' && $subject!='' && $chapter!='' && $topic!=''){
    $data['tradegroup'] = DB::table("tradegroup")->where("status", 1)->get();
    $data['list'] = DB::table("questions")->where('tradegroup',$tradegroup)->where('trade',$trade)->where('subject',$subject)->where('chapter',$chapter)->where('topic',$topic)->get();
   
      return view('exam.question', $data);   
 
}
    
        
        Paginator::useBootstrap();
        DB::enableQueryLog();
        $keywords = trim($req->input('keywords'));
        if ($req->input('delid')) {

            $del = DB::table("questions")->where("id", $req->input('delid'))->delete();
            $req->session()->flash('success', 'Questions deleted succesfully...');
        }
        if ($keywords != '') {
          $data['list'] = DB::table("questions as q")
          ->select('q.*')
            ->leftJoin('tradegroup as tg', 'tg.id', '=', 'q.tradegroup')
            ->leftJoin('trade as t', 't.id', '=', 'q.trade')
            ->leftJoin('subject as s', 's.id', '=', 'q.subject')
            ->leftJoin('chapter as ch', 'ch.id', '=', 'q.chapter')
            ->leftJoin('topics as top', 'top.id', '=', 'q.topic')
            ->where("q.question", 'like', '%' . $keywords . '%')
            ->orWhere("tg.name", 'like', '%' . $keywords . '%')
            ->orWhere("t.name", 'like', '%' . $keywords . '%')
            ->orWhere("s.name", 'like', '%' . $keywords . '%')
            ->orWhere("ch.name", 'like', '%' . $keywords . '%')
            ->orWhere("top.name", 'like', '%' . $keywords . '%')
            ->paginate(100);
             
            return view('exam.question_ajax', $data);
        } else {

            $data['tradegroup'] = DB::table("tradegroup")->where("status", 1)->get();
            $data['list'] = DB::table("questions")->paginate(20);
      
            if ($req->input('page')) {
                return view('exam.question_ajax', $data);
            } else {
                return view('exam.question', $data);
            }
        }
    }

    public function addquestion(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($req->input('fileupload') != '') {
                if ($req->file('file') != '') {
                    $file = $req->file('file')->getClientOriginalName();
                    $file_url = $req->file('file')->move('public/uploads/documents', $file);
                }
                $count = 0;
                $file = fopen($file_url, "r");
                while (($row = fgetcsv($file)) !== FALSE) {
                    $count++;
                    if ($count == 1) {
                        continue;
                    }

                    $data = array(
                        'tradegroup' => trim($req->input('tradegroup')),
                        'trade' => trim($req->input('trade')),
                        'subject' => trim($req->input('subject')),
                        'chapter' => trim($req->input('chapter')),
                        'topic' => trim($req->input('topic')),
                        'question' => trim($row[0]),
                        'opt_a' => trim($row[1]),
                        'opt_b' => trim($row[2]),
                        'opt_c' => trim($row[3]),
                        'opt_d' => trim($row[4]),
                        'opt_e' => trim($row[5]),
                        'correct' => trim($row[6]),
                        'explanation' => trim($row[7]),

                    );
                    $insert = DB::table("questions")->insert($data);
                }

                if ($insert) {
                    $req->session()->flash('success', 'Questions inserted succesfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
                exit;
            }

            $data = array(
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')),
                'subject' => trim($req->input('subject')),
                'chapter' => trim($req->input('chapter')),
                'topic' => trim($req->input('topic')),
                'question' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('question'))),
                'opt_a' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('option_a'))),
                'opt_b' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('option_b'))),
                'opt_c' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('option_c'))),
                'opt_d' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('option_d'))),
                'opt_e' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('option_e'))),
                'explanation' => preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', ($req->input('explanation'))),
                'correct' => trim($req->input('answer')),


            );
            if ($req->input('uid') != '') {
                $insert = DB::table("questions")->where("id", $req->input('uid'))->update($data);
                exit;
            }
            $insert = DB::table("questions")->insert($data);
            if ($insert) {
                echo '<div class="alert alert-success" role="alert">
               Question added succesfully...
              </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
               Some error occured....
              </div>';
            }

            exit;
        }
        if ($req->input('qid') != '') {
            $data['res'] = DB::table("questions")->where("id", $req->input('qid'))->first();
        }
        if ($req->input('viewid') != '') {
            $data['view'] = 'view';
            $data['res'] = DB::table("questions")->where("id", $req->input('viewid'))->first();
        }
        $data['list'] = DB::table("tradegroup")->where("status", 1)->get();
        return view('exam.addquestion', $data);
    }

    public function bulkdelete(Request $req)
    {

        for ($i = 0; $i < count($req->input('checkboxid')); $i++) {
            $delid = $req->input('checkboxid')[$i];
            $deleted = DB::table('questions')->where('id', '=', $delid)->delete();
        }
        $req->session()->flash('success', 'Questions deleted succesfully...');
        return redirect($_SERVER['HTTP_REFERER']);
    }
    public function assignexam(Request $req, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($req->input('assign') != '') {
                $delete = DB::table('onlineexam_students')->where("onlineexam_id", $req->input('examid'))->where("class_id", $req->input('class_id'))->where("batch_id", $req->input('batch_id'))->delete();
                for ($i = 0; $i < count($req->input('students_id')); $i++) {
                    $data = array(
                        'onlineexam_id' => $req->input('examid'),
                        'student_id' => $req->input('students_id')[$i],
                        'course_name' => $req->input('course_name'),
                        'class_id' => $req->input('class_id'),
                        'batch_id' => $req->input('batch_id'),
                    );

                    $insert = DB::table("onlineexam_students")->insert($data);
                }
                if ($insert) {
                    $req->session()->flash('success', 'Exam assigned succesfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured.May be student is already assigned...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }

            $data['students'] = DB::table("students")->where("class_id", $req->input('class_id'))->where("batch_id", $req->input('batch_id'))->where("status", 0)->get();
            $data['class_id'] = $req->input('class_id');
            $data['batch_id'] = $req->input('batch_id');
            $data['exam'] = DB::table("onlineexam")->where("id", $id)->first();
        }

        $data['list'] = DB::table("classes")->where("is_active", 'yes')->get();
        return view('exam.assign', $data);
    }
    public function assignexam_addquestion(Request $req, $id)
    {
        $data['list'] = DB::table("tradegroup")->where("status", 1)->get();
        return view('exam.assignexam_addquestion', $data);
    }
    public function examquestion(Request $req)
    {
        Paginator::useBootstrap();
        DB::enableQueryLog();
        $tradegroup = $req->input('tradegroup');
        $trade = $req->input('trade');
        $subject = $req->input('subject');
        $chapter = $req->input('chapter');
        $topic = $req->input('topic');

        if ($tradegroup != '' && $trade != '' && $subject != '' && $chapter != '' && $topic != '') {
            $data['examid'] = $req->input('examid');
            $data['list'] = DB::table("questions")->where("tradegroup", $tradegroup)->where("trade", $trade)->where("subject", $subject)->where("chapter", $chapter)->where("topic", $topic)->paginate(100);
            return view('exam.examquestion', $data);
        }
        $keywords = trim($req->input('keywords'));
        if ($keywords != '') {
            $data['examid'] = $req->input('examid');
            $data['list'] = DB::table("questions")->where("question", 'like', '%' . $keywords . '%')->paginate(100);
            return view('exam.examquestion', $data);
        } else {
            $data['examid'] = $req->input('examid');
            $data['tradegroup'] = DB::table("tradegroup")->where("status", 1)->get();
            $data['list'] = DB::table("questions")->paginate(100);
            return view('exam.examquestion', $data);
        }
    }
    public function addExamQuestion(Request $req)
    {
        for ($i = 0; $i < count($req->input('checkboxid')); $i++) {
            $qid = $req->input('checkboxid')[$i];
            $data = array(
                'question_id' => $qid,
                'examid' => $req->input('examid'),
            );
            $count = DB::table("onlineexam_questions")->where("question_id", $qid)->where("examid", $req->input('examid'))->count();
            if ($count > 0) {
                continue;
            }
            $insert = DB::table("onlineexam_questions")->insert($data);
        }
        if ($insert) {
            echo '<div class="alert alert-success">
            <strong>Success!</strong> Question added succesfully.
          </div>';
        } else {
            echo '<div class="alert alert-danger">
            <strong>Error!</strong> Some error occured.May be this question is already available.
          </div>';
        }
    }
    public function ajax_addexam(Request $req)
    {
        if ($req->input('uid') != '') {
            $data['res'] = DB::table("onlineexam")->where("id", $req->input('uid'))->first();
        }
        return view('exam.ajax_addexam', $data);
    }
    public function getExamQuestions(Request $req)
    {
        if ($req->input('delid') != '') {
            $delete = DB::table("onlineexam_questions")->where("id", $req->input('delid'))->delete();
            $req->session()->flash('success', 'Question deleted succesfully...');
        }
        $data['list'] = DB::table("onlineexam_questions")->where("examid", $req->input('examid'))->get();
        return view('exam.getExamQuestions', $data);
    }
    public function printexam(Request $req, $id)
    {
        $data['list'] = DB::table("onlineexam_questions")->where('examid', $id)->get();
        return view('exam.printexam', $data);
    }
    public function course_addexam(Request $req, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $delete = DB::table("course_exam")->where("folder_id", $req->input('folderid'))->delete();
            for ($i = 0; $i < count($req->input('exam')); $i++) {
                $data = array(
                    'exam_id' => $req->input('exam')[$i],
                    'course_id' => $req->input('add_courseexam_id'),
                    'folder_id' => $req->input('folderid'),
                );
                $insert = DB::table("course_exam")->insert($data);
            }
            if ($insert) {
                $req->session()->flash('success', 'Exam created succesfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $data['course_id'] = $id;
        $data['folderid'] = $req->input('folderid');
        if ($req->input('type') == 'view') {
            $data['read'] = 1;
            $data['list'] = DB::table('course_exam')
                ->leftjoin(
                    'onlineexam',
                    'onlineexam.id',
                    '=',
                    DB::raw('course_exam.exam_id')
                )->where("folder_id", $req->input('folderid'))->where("onlineexam.is_active", "1")
                ->get();

            return view('exam.onlineexam', $data);
            exit;
        } else {
            $data['list'] = DB::table("onlineexam")->where("is_active", "1")->get();
        }
        return view('exam.addexam', $data);
    }
    public function submit_exam(Request $req)
    {
        $studentid = $req->input('onlineexam_student_id');
        $is_quiz = $req->input('is_quiz');
        $examid = $req->input('examid');
        $marks = $req->input('marks');
        $negative_marks_per_question = $req->input('negative_marks');
        $total_marks = 0;
        $negative_marks = 0;
        $examattempt_id = $studentid . $examid . uniqid();
        $delete = DB::table("onlineexam_student_results")->where("examid", $examid)->where("onlineexam_student_id", $studentid)->delete();
        for ($i = 1; $i <= count($req->input('total_rows')); $i++) {
            $qid = $req->input('question_id_' . $i);
            $answer = $req->input('radio' . $i);
            if ($answer != '') {
                $question = DB::table("questions")->where("id", $qid)->first(['correct']);
                $correct_mark = $question->correct;
                if ($correct_mark == $answer) {
                    $total_marks += $marks;
                } else {
                    $negative_marks += $negative_marks_per_question;
                }
            }


            $data = array(
                'examattempt_id' => $examattempt_id,
                'onlineexam_student_id' => $studentid,
                'examid' => $examid,
                'onlineexam_question_id' => $qid,
                'select_option' => $answer,
            );
            $insert = DB::table('onlineexam_student_results')->insert($data);
        }


        $data = array(
            'total_marks' => $total_marks,
            'negative_marks' => $negative_marks,
            'examid' => $examid,
            'student_id' => $studentid,
            'examattempt_id' => $examattempt_id
        );

        $insert = DB::table('student_score_tb')->insert($data);
        $req->session()->flash('success', 'Answeres submitted succesfully...');
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        return redirect('user/onlineexam/view/'.$examid);
    }
    public function read_question(Request $req, $id)
    {
        $data['res'] = DB::table("questions")->where("id", $id)->first();
        return view('exam.read_question', $data);
    }

    public function onlineexam_webview(Request $req,$cid,$id){
        return view('exam.testseries_webview');
    }
}
