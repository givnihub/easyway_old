 
 
<?php
 
$chat_type = ($update->chat_user_id != $userid) ? 'sent' : 'replies';
$date_time = ($update->chat_user_id != $userid) ? 'time_date' : 'time_date_send';

?>

<li class="{{$chat_type}}">
    <p>{{$update->message}}</p>
    <span class="{{$date_time}}"> {{$update->created_at}}</span>
</li>


 