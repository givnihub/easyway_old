<?php

namespace App\Http\Controllers;

error_reporting(0);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Master extends Controller
{
    public function tradegroup(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('tradegroup')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id = DB::table("submenu")->where("link", 'LIKE', "%" . $req->segment('2') . "%")->first(['id']);
        $data['perm_cat_id'] = $cat_id->id;
        $data['role_id'] = session()->get('userInfo')['role'];

        $data['list'] = DB::table('tradegroup')->get();
        return view('admin.tradegroup', $data);
    }
    public function tradegroupCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'name' => trim($req->input('name'))
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('tradegroup')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/tradegroup');
                exit;
            } else {
                $req->validate([
                    'name' => 'required|unique:tradegroup,name',
                ]);


                $insert =  DB::table('tradegroup')->insert($data);

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
            $data['res'] = DB::select('select * from tradegroup where id=' . $req->input('id'));

            return view('admin.tradegroupCreate', $data);
        } else {
            return view('admin.tradegroupCreate');
        }
    }
    public function trade(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('trade')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::select('select * from trade order by id desc');
        return view('admin.trade', $data);
    }
    public function tradeCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup'))
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('trade')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/trade');
                exit;
            } else {
                $req->validate([
                    'name' => 'required',
                    'tradegroup' => 'required',

                ]);


                $insert =  DB::table('trade')->insert($data);

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
            $data['res'] = DB::select('select * from trade where id=' . $req->input('id'));
            $data['list'] = DB::select('select * from tradegroup order by name asc');
            return view('admin.tradeCreate', $data);
        } else {
            $data['list'] = DB::select('select * from tradegroup order by name asc');
            return view('admin.tradeCreate', $data);
        }
    }
    public function subject(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('subject')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::select('select * from subject order by id desc');
        return view('admin.subject', $data);
    }
    public function subjectCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade'))
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('subject')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/subject');
                exit;
            } else {
                $req->validate([
                    'name' => 'required',
                    'tradegroup' => 'required',
                    'trade' => 'required',

                ]);


                $insert =  DB::table('subject')->insert($data);

                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }

        $data['list'] = DB::select('select * from tradegroup order by name asc');
        if ($req->input('id') != '') {
            $data['res'] = DB::select('select * from subject where id=' . $req->input('id'));
        }

        return view('admin.subjectCreate', $data);
    }
    public function chapter(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('chapter')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::select('select * from chapter order by id desc');
        return view('admin.chapter', $data);
    }
    public function chapterCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')),
                'subject' => trim($req->input('subject'))
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('chapter')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/chapter');
                exit;
            } else {
                $req->validate([
                    'name' => 'required|unique:chapter,name',
                    'tradegroup' => 'required',
                    'trade' => 'required',
                    'subject' => 'required',

                ]);


                $insert =  DB::table('chapter')->insert($data);

                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }

        $data['list'] = DB::select('select * from tradegroup order by name asc');
        if ($req->input('id') != '') {
            $data['res'] = DB::select('select * from chapter where id=' . $req->input('id'));
        }

        return view('admin.chapterCreate', $data);
    }


    public function topic(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('topics')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::select('select * from topics order by id desc');
        return view('admin.topic', $data);
    }
    public function topicCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')),
                'subject' => trim($req->input('subject')),
                'chapter' => trim($req->input('chapter'))
            );
            if (!empty($req->input('uid'))) {
                $update =  DB::table('topics')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/topic');
                exit;
            } else {
                $req->validate([
                    'name' => 'required|unique:topics,name',
                    'tradegroup' => 'required',
                    'trade' => 'required',
                    'subject' => 'required',
                    'chapter' => 'required',

                ]);


                $insert =  DB::table('topics')->insert($data);

                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }

        $data['list'] = DB::select('select * from tradegroup order by name asc');
        if ($req->input('id') != '') {
            $data['res'] = DB::select('select * from topics where id=' . $req->input('id'));
        }

        return view('admin.topicCreate', $data);
    }

    public function videolibrary(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('videolibrary')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::table('videolibrary')->get();
        return view('admin.videolibrary', $data);
    }
    public function videolibraryCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //update uvid
            if (!empty($req->input('uid'))) {
                $check = DB::select('select * from videolibrary where id=' . $req->input('uid'));
                if ($req->file('uvid') != '') {
                    $uvid = time() . $req->file('uvid')->getClientOriginalName();
                    $file_type = $req->file('uvid')->extension();
                    if ($file_type == 'mp4' || $file_type == 'mov') {
                        $uvid = $req->file('uvid')->move('public/uploads/videolibrary', $uvid);
                    } else {
                        $req->session()->flash('error', 'Please choose only mp4 or .mov files...');
                        return redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $uvid = $check[0]->uvid;
                }

                $data = array(
                    'name' => trim($req->input('name')),
                    'tradegroup' => trim($req->input('tradegroup')),
                    'trade' => trim($req->input('trade')),
                    'subject' => trim($req->input('subject')),
                    'chapter' => trim($req->input('chapter')),
                    'topic' => trim($req->input('topic')),
                    'uvid' => $uvid,
                    'vid' => trim($req->input('vid')),
                    'duration' => trim($req->input('duration')),
                );
                $update =  DB::table('videolibrary')->where('id', $req->input('uid'))->update($data);
                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/videolibrary');
                exit;
            }




            if ($req->file('uvid') != '') {
                $uvid = time() . $req->file('uvid')->getClientOriginalName();
                $file_type = $req->file('uvid')->extension();
                if ($file_type == 'mp4' || $file_type == 'mov') {
                    $uvid = $req->file('uvid')->move('public/uploads/videolibrary', $uvid);
                } else {
                    $req->session()->flash('error', 'Please choose only mp4 or .mov files...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }


            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')),
                'subject' => trim($req->input('subject')),
                'chapter' => trim($req->input('chapter')),
                'topic' => trim($req->input('topic')),
                'uvid' => $uvid,
                'vid' => trim($req->input('vid')),
                'duration' => trim($req->input('duration')),
            );

            $req->validate([
                'name' => 'required|unique:videolibrary,name',
                'tradegroup' => 'required',
                'trade' => 'required',
                'subject' => 'required',
                'chapter' => 'required',
                'topic' => 'required',
                'vid' => 'required',
                'duration' => 'required',

            ]);
            $insert =  DB::table('videolibrary')->insert($data);

            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $data['list'] = DB::select('select * from tradegroup order by name asc');
        if ($req->input('id') != '') {
            $data['res'] = DB::select('select * from videolibrary where id=' . $req->input('id'));
        }

        return view('admin.videolibraryCreate', $data);
    }

    public function videolibraryview(Request $req)
    {
        $data['res'] = DB::select('select * from videolibrary where id=' . $req->input('id'));
        return view('admin.videolibraryView', $data);
    }
    public function studymaterials(Request $req)
    {
        if (!empty($req->input('id'))) {
            $deleted = DB::table('studymaterials')->where('id', '=', $req->input('id'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
       $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::select('select * from studymaterials order by id desc');
        return view('admin.studymaterials', $data);
    }

    public function studymaterialsCreate(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            //update uvid
            if (!empty($req->input('uid'))) {
                $check = DB::select('select * from studymaterials where id=' . $req->input('uid'));
                if ($req->file('docs') != '') {
                    $docs = $req->file('docs')->getClientOriginalName();
                    $file_type = $req->file('docs')->extension();
                    if ($file_type == 'pdf' || $file_type == 'doc' || $file_type == 'docx' || $file_type == 'txt') {
                        $docs = $req->file('docs')->move('public/uploads/documents', $docs);
                    } else {
                        $req->session()->flash('error', 'Please uploads only documents...');
                        return redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $docs = $check[0]->docs;
                }

                $data = array(
                    'name' => trim($req->input('name')),
                    'tradegroup' => trim($req->input('tradegroup')),
                    'trade' => trim($req->input('trade')),
                    'subject' => trim($req->input('subject')),
                    'chapter' => trim($req->input('chapter')),
                    'topic' => trim($req->input('topic')),
                    'docs' => $docs,

                );
                $update =  DB::table('studymaterials')->where('id', $req->input('uid'))->update($data);
                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/studymaterials');
                exit;
            }


            if ($req->file('docs') != '') {
                $docs = $req->file('docs')->getClientOriginalName();
                $file_type = $req->file('docs')->extension();
                if ($file_type == 'pdf' || $file_type == 'doc' || $file_type == 'docx' || $file_type == 'txt') {
                    $docs = $req->file('docs')->move('public/uploads/documents', $docs);
                } else {
                    $req->session()->flash('error', 'Please uploads only documents...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }


            $data = array(
                'name' => trim($req->input('name')),
                'tradegroup' => trim($req->input('tradegroup')),
                'trade' => trim($req->input('trade')),
                'subject' => trim($req->input('subject')),
                'chapter' => trim($req->input('chapter')),
                'topic' => trim($req->input('topic')),
                'docs' => $docs,

            );


            // $req->validate([
            //     'name' => 'required|unique:studymaterials,name',
            //     'tradegroup' => 'required',
            //     'trade' => 'required',
            //     'subject' => 'required',
            //     'chapter' => 'required',
            //     'topic' => 'required',
            //    'docs'=>'required'

            // ]);

            $insert =  DB::table('studymaterials')->insert($data);

            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }

        $data['list'] = DB::select('select * from tradegroup order by name asc');
        if ($req->input('id') != '') {
            $data['res'] = DB::select('select * from studymaterials where id=' . $req->input('id'));
        }
        return view('admin.studymaterialsCreate', $data);
    }
    public function feetype(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'type' => $req->input('name'),
                'code' => $req->input('code'),
                'description' => $req->input('description'),
            );
            if ($req->input('uid') != '') {
                $update =  DB::table('feetype')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/feetype');
            }
            $insert =  DB::table('feetype')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($req->input('uid') != '') {
            $data['res'] = DB::table('feetype')->where('id', $req->input('uid'))->get()->first();
        }
        if ($req->input('delid') != '') {
            $deleted = DB::table('feetype')->where('id', '=', $req->input('delid'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
            return redirect('master/feetype');
        }
        $data['list'] = DB::table('feetype')->get();
        return view('fee.feetype', $data);
    }

    public function feegroup(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'name' => $req->input('name'),

                'description' => $req->input('description'),
            );
            if ($req->input('uid') != '') {
                $update =  DB::table('fee_groups')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/feegroup');
            }
            $insert =  DB::table('fee_groups')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($req->input('uid') != '') {
            $data['res'] = DB::table('fee_groups')->where('id', $req->input('uid'))->get()->first();
        }
        if ($req->input('delid') != '') {
            $deleted = DB::table('fee_groups')->where('id', '=', $req->input('delid'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
            return redirect('master/feegroup');
        }
        $data['list'] = DB::table('fee_groups')->get();
        return view('fee.feegroup', $data);
    }

    public function feediscount(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array(
                'name' => $req->input('name'),
                'code' => $req->input('code'),
                'amount' => $req->input('amount'),
                'description' => $req->input('description'),
            );
            if ($req->input('uid') != '') {
                $update =  DB::table('fees_discounts')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/feediscount');
            }
            $insert =  DB::table('fees_discounts')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($req->input('uid') != '') {
            $data['res'] = DB::table('fees_discounts')->where('id', $req->input('uid'))->get()->first();
        }
        if ($req->input('delid') != '') {
            $deleted = DB::table('fees_discounts')->where('id', '=', $req->input('delid'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
            return redirect('master/feediscount');
        }
        $data['list'] = DB::table('fees_discounts')->get();
        return view('fee.feediscount', $data);
    }

    public function feediscount_assign(Request $req, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            if ($req->input('save') == 'save') {

                $deleted = DB::table('student_fees_discounts')->where('fees_discount_id', '=', $req->input('feediscount_id'))->delete();
                for ($i = 0; count($req->input('student_session_id')) > $i; $i++) {

                    $data = array(
                        'student_id' => $req->input('student_session_id')[$i],
                        'fees_discount_id' => $req->input('feediscount_id'),
                    );
                    $insert =  DB::table('student_fees_discounts')->insert($data);
                }
                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect('master/feediscount');
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }

            $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ' and type=1 and status=0) order by firstname asc');
        }
        $data['fees'] = DB::table('fees_discounts')->where('id', $id)->get()->first();
        $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
        return view('fee/feediscount_assign', $data);
    }

    public function feemaster(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $data = array(
                'fee_groups_id' => trim($req->input('fee_groups_id')),
                'feetype_id' => trim($req->input('feetype_id')),
                'due_date' => trim($req->input('due_date')),
                'amount' => trim($req->input('amount')),
                'account_type' => trim($req->input('account_type')),
                'fine_percentage' => trim($req->input('fine_percentage')),
                'fine_amount' => trim($req->input('fine_amount')),
            );
            if ($req->input('uid') != '') {
                $update =  DB::table('feemasters')->where('id', $req->input('uid'))->update($data);

                $req->session()->flash('success', 'Updated successfully...');
                return redirect('master/feemaster');
            }

            $check = DB::table('feemasters')->where('fee_groups_id', $req->input('fee_groups_id'))->where('feetype_id', $req->input('feetype_id'))->count();
            if ($check > 0) {
                $req->session()->flash('error', 'This combination is already exists...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
            $insert =  DB::table('feemasters')->insert($data);
            if ($insert) {
                $req->session()->flash('success', 'Inserted successfully...');
                return redirect($_SERVER['HTTP_REFERER']);
            } else {
                $req->session()->flash('error', 'Some error occured...');
                return redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($req->input('delid') != '') {
            $deleted = DB::table('feemasters')->where('id', '=', $req->input('delid'))->delete();
            $req->session()->flash('success', 'Deleted succesfully...');
            return redirect('master/feemaster');
        }
        if ($req->input('uid') != '') {
            $data['res'] = DB::table("feemasters")->get()->first();
        }

        $data['group'] = DB::table("fee_groups")->get();
        $data['feetype'] = DB::table("feetype")->get();
        $data['list'] = DB::table("feemasters")->get();
        return view('fee.feemaster', $data);
    }

    public function feemaster_assign(Request $req, $id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($req->input('save') == 'save') {

                $deleted = DB::table('student_fees_master')->where('fee_group_id', '=', $req->input('feegroup_id'))->delete();
                for ($i = 0; count($req->input('student_id')) > $i; $i++) {
                    $data = array(
                        'student_id' => $req->input('student_id')[$i],
                        'fee_group_id' => $req->input('feegroup_id'),
                        'amount' => $req->input('amount'),
                    );
                    $insert =  DB::table('student_fees_master')->insert($data);
                }
                if ($insert) {
                    $req->session()->flash('success', 'Inserted successfully...');
                    return redirect('master/feemaster');
                } else {
                    $req->session()->flash('error', 'Some error occured...');
                    return redirect($_SERVER['HTTP_REFERER']);
                }
            }

            $data['rows'] = DB::select('select * from students where (class_id=' . $req->input('class_id') . ' and batch_id=' . $req->input('batch_id') . ' and type=1 and status=0) order by firstname asc');
        }
        $data['fees'] = DB::table('feemasters')->where('id', $id)->get()->first();
        $data['class'] = DB::table('classes')->where('is_active', 'yes')->get();
        return view('fee/feemaster_assign', $data);
    }
    public function calendar_events(Request $req)
    {
        return view('admin.calendar_events');
    }
    public function module(Request $req)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $role = $req->input('role');
            $data = array(
                $role => $req->input('status')
            );
            $update = DB::table("menu")->where("id", $req->input('id'))->update($data);

            echo 'Status updated now.';
            exit;
        }
        $cat_id= DB::table("submenu")->where("link",'LIKE', "%".$req->segment('2')."%")->first(['id'])  ;
        $data['perm_cat_id']= $cat_id->id;
        $data['role_id']=session()->get('userInfo')['role'];
        $data['list'] = DB::table("menu")->get();
        return view('user.module', $data);
    }
    public function sendemail(Request $req)
    {
        $data['list'] = DB::table("roles")->where("is_active", "1")->get();
        $data['class'] = DB::table("classes")->where("is_active", "yes")->get();
        return view('admin.mail', $data);
    }
}
