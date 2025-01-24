<?php

namespace App\Http\Controllers;

error_reporting();

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Chat extends Controller
{
    public function index(Request $req)
    {

        $data =  $req->session()->get('userInfo');
        $data['userid'] = $data['id'];
        return view('chat.index', $data);
    }
    public function all(Request $req)
    {
        $data =  $req->session()->get('userInfo');
        $data['userid'] = $data['id'];
        $data['type'] = 'all';
        return view('chat.index', $data);
    }
    public function searchuser(Request $req)
    {
        $data['stafflist'] = DB::table("staff")->where('name', 'like', '%' . $req->input('keyword') . '%')->get();
        $data['student'] = DB::table("students")->where('firstname', 'like', '%' . $req->input('keyword') . '%')->get();
        return view("chat.users", $data);
    }
    public function adduser(Request $req)
    {
        $data =  $req->session()->get('userInfo');
        $req_from_id = $data['id'];
        $req_to_id = $req->input('user_id');
        $type = $req->input('user_type');
        $data = array(
            'chat_user_one' => $req_from_id,
            'chat_user_two' => $req_to_id,
            'type' => $type
        );
        $check = DB::table("chat_connections")->where("chat_user_one", $req_from_id)->where("chat_user_two", $req_to_id)->count();
        if ($check > 0) {
            echo 'You are already connected';
            exit;
        }
        $insert = DB::table("chat_connections")->insert($data);
        if ($insert) {
            echo 'You are now connected';
        } else {
            echo 'Some error occured';
        }
    }
    public function myuser(Request $req)
    {
        $userinfo = $req->session()->get('userInfo');
        $id = $userinfo['id'];


        if ($req->input('type') == 'all') {

            $data['list'] = DB::table("chat_connections")->get();
            $data['type'] = 'all';
        } else {

            $data['type'] = 'single';
            $data['list'] = DB::table("chat_connections")->where("chat_user_one", $id)->get();
            $data['request'] = DB::table("chat_connections")->where("chat_user_two", $id)->get();
        }

        return view('chat.myuser', $data);
    }
    public function getChatsUpdates(Request $req)
    {

        return view('chat.getChatsUpdates');
    }
    public function getChatRecord(Request $req)
    {
        $chat_connection_id = $req->input('chat_connection_id');
        $userinfo = $req->session()->get('userInfo');
        $chat_user_id = $data['userid'] = $userinfo['id'];
        $arraydata = array(
            'is_read' => 1
        );
        DB::table("chat_messages")->where("chat_user_id", "<>", $chat_user_id)->update($arraydata);
        $data['list'] = DB::table("chat_messages")->where("chat_connection_id", $chat_connection_id)->get();
        return view('chat.getChatsUpdates', $data);
    }
    public function newMessage(Request $req)
    {
        $chat_connection_id = $req->input('chat_connection_id');
        $userinfo = $req->session()->get('userInfo');
        $chat_user_id = $userinfo['id'];
        $data = array(
            'chat_connection_id' => $chat_connection_id,
            'chat_user_id' => $chat_user_id,
            'message' => $req->input('message'),
            'created_at' => $req->input('time'),
        );
        $insert = DB::table("chat_messages")->insert($data);
    }
    public function chatUpdate(Request $req)
    {
        $chat_connection_id = $req->input('chat_connection_id');
        $userinfo = $req->session()->get('userInfo');
        $userid = $data['userid'] = $userinfo['id'];
        $res = $data['update'] = DB::table("chat_messages")->where("chat_connection_id", $chat_connection_id)->where("is_read", 0)->where("chat_user_id", "<>", $userid)->orderBy("id", "desc")->first();
        $arraydata = array(
            'is_read' => 1
        );
        DB::table("chat_messages")->where("id", $res->id)->where("chat_user_id", "<>", $userid)->update($arraydata);
        return view('chat.lastChatUpdate', $data);
    }
    public function getChatNotification(Request $req)
    {
        // print_r($req->input());
    }

     public function LiveChat(Request $req, $id, $videoId)
    {
        $data['userId'] = $id;
        $data['videoId'] = $videoId;
        $data['users']=DB::table('students')->where('id',$id)->first(['firstname']);
        return view('chat/LiveChat', $data);
    }

    public function newLiveMessage(Request $req)
    {
        $videoId = $req->input('videoId');
        $userId = $req->input('userId');
        

        $data = array(
            'chat_user_id' => $userId,
            'video_id' => $videoId,
            'message' => trim($req->input('message')),
            'created_at' => date('Y-m-d H:i:s'),
            'is_read'=>$userId
          
        );

        $insert = DB::table("liveStreamMessage")->insert($data);
    }


     public function chatLiveStreamMessage(Request $req)
    {
        $userId = $req->input('userId');
        $videoId = $req->input('videoId');


        $row = DB::table("liveStreamMessage as c")
            ->leftJoin("students as u", "u.id", "=", "c.chat_user_id")
            ->where("c.video_id", $videoId)
            ->whereRaw("NOT FIND_IN_SET($userId, is_read)")
            ->limit(1)->orderBy('c.id', 'desc')->get(['c.id', 'c.chat_user_id', 'c.video_id', 'c.message', 'c.is_first', 'c.is_read', 'c.created_at', 'u.firstname']);


        foreach ($row as $run) {
            $is_read = $run->is_read . ',' . $userId;
            $is_read;
            $datas = array(
                'is_read' => $is_read
            );
            $update = DB::table('liveStreamMessage')->where('id', $run->id)->update($datas);
            $chat_type = ($run->chat_user_id != $userId) ? 'sent' : 'replies';

        ?>
            <li class="<?= $chat_type ?>">
                <p><?= $run->message ?>
                    <br />

                    <span><?= $run->firstname ?></span>
                    <br />
                    <span class="<?= $chat_type ?> <?php $chat_type=='replies'?'time_date_send':'time_date_recieved' ?>"> <?= $run->created_at ?></span>
                </p>


            </li>
<? }
    }
    
    public function allLiveStreamMessage(Request $req)
    {
        $userId = $req->input('userId');
        $videoId = $req->input('videoId');
        $row = DB::table("liveStreamMessage as c")
            ->leftJoin("students as u", "u.id", "=", "c.chat_user_id")
            ->where("c.video_id", $videoId)->orderBy('c.id', 'asc')->get(['c.id', 'c.chat_user_id', 'c.video_id', 'c.message', 'c.is_first', 'c.is_read', 'c.created_at', 'u.firstname']);


        foreach ($row as $run) {
            $uid = $run->id;
            $checkIsRead = $query = DB::table('liveStreamMessage')
                ->where('id', $uid)
                ->whereRaw("FIND_IN_SET($userId, is_read)")
                ->count();
            if ($checkIsRead == 0) {
                $is_read = $run->is_read . ',' . $userId;
                $is_read;
                $datas = array(
                    'is_read' => $is_read
                );
                $update = DB::table('liveStreamMessage')->where('id', $uid)->update($datas);
            }



            $chat_type = ($run->chat_user_id != $userId) ? 'sent' : 'replies';

?>
            <li class="<?= $chat_type ?>">
                <p><?= $run->message ?>
                    <br />

                    <span><?= $run->firstname ?></span>
                    <br />
                    <span class="<?= $chat_type ?> <?php $chat_type=='replies'?'time_date_send':'time_date_recieved' ?>"> <?= $run->created_at ?></span>
                </p>


            </li>
        <? }
    }
}
