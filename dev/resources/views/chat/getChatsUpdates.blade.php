<li class="text text-center" style="margin: 0px;">
    <h4 class="chattitle"><span class="">you are now connected on chat</span></h4>
</li>
 
@foreach($list as $run)
<?php

$chat_type = ($run->chat_user_id != $userid) ? 'sent' : 'replies';
$date_time = ($run->chat_user_id != $userid) ? 'time_date' : 'time_date_send';

?>

<li class="{{$chat_type}}">
    <p>{{$run->message}}</p>
    <span class="{{$date_time}}"> {{$run->created_at}}</span>
</li>


@endforeach