@if($type=='all')
@foreach($list as $run)

<?php

if ($run->type != 'students') {
   $user = DB::table("staff")->where('id', $run->chat_user_two)->first();
   $name = $user->name;
   $image = $user->image;
} else {

   $user = DB::table("students")->where('id', $run->chat_user_two)->first();
   $name =  $user->firstname . '&nbsp' . $user->lastname;
   $image = $user->photo;
}

$lastmessage = DB::table("chat_messages")->where("chat_connection_id", $run->id)->orderBy("id", "desc")->get()->first();
$count = DB::table("chat_messages")->where("chat_connection_id", $run->id)->where("is_read", 0)->where("chat_user_id", "<>", $run->chat_user_one)->count();
?>
<li class="contact" data-chat-connection-id="{{$run->id}}" data-chat_to_user="{{$run->chat_user_two}}">
   <div class="wrap">
      <img src="{{asset('')}}{{$image}}" alt="">
      <div class="meta">
         <p class="name">
            {{$name}} ({{$run->type}})</p>


         <p class="preview">
            @if($lastmessage=='')
            <span>You: </span> you are now connected on chat</p>
         @else
         <span>Message: </span> {{$lastmessage->message}}</p>
         @endif
      </div>
   </div>
   @if($count>0)
   <span class="chatbadge notification_count">{{$count}}</span>
   @endif
</li>


@endforeach
@endif
<!-- 
  connection request  -->
@if($type=='single')
@foreach($request as $run)

<?php
if ($run->type != 'Student') {
   $user = DB::table("staff")->where('id', $run->chat_user_one)->get()->first();
   $name = $user->name;
   $image = $user->image;
} else {
   $user = DB::table("students")->where('id', $run->chat_user_one)->get()->first();
   $name = $user->firstname . '&nbsp' . $user->lastname;
   $image = $user->photo;
}
$lastmessage = DB::table("chat_messages")->where("chat_connection_id", $run->id)->orderBy("id", "desc")->get()->first();
$count = DB::table("chat_messages")->where("chat_connection_id", $run->id)->where("is_read", 0)->where("chat_user_id", "<>", $run->chat_user_two)->count();
?>
<li class="contact" data-chat-connection-id="{{$run->id}}" data-chat_to_user="{{$run->chat_user_one}}">
   <div class="wrap">
      <img src="{{asset('')}}{{$image}}" alt="">
      <div class="meta">
         <p class="name">
            {{$name}} ({{$run->type}})</p>


         <p class="preview">
            @if($lastmessage=='')
            <span>You: </span> you are now connected on chat</p>
         @else
         <span>Message: </span> {{$lastmessage->message}}</p>
         @endif
      </div>
   </div>
   @if($count>0)
   <span class="chatbadge notification_count">{{$count}}</span>
   @endif

</li>


@endforeach
@endif