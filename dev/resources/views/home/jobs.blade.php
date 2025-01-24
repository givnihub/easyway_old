@include('home.include.head')

<body>

    @include('home.include.header')
    @include('home.include.menu')
    <div class="toper">
        <section class="bredcrumb" style="background:url('{{$course_type->feature_image}}');background-size: 100% 100%;">

        </section>
        <style type="text/css">
            .thumbnail a img {
                height: 200px;
                width: 100%;
            }

            .thumbnail a h2 {
                margin: 0;
                font-size: 21px;
            }

            .blink_me {
                animation: blinker 1s linear infinite;
                color: red;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }
        </style>
        <section>
            <div class="container mt-5">
                <div class="row">
                <?php  $currentdate= date('Y-m-d H:i:s');?>
                    @foreach($live as $row)
                    <?php $total_question = DB::table("onlineexam_questions")->where("examid", $row->id)->count(); ?>
                    <div class="col-md-3 thumbnail">

                        <h2>{{$row->exam}} <span class="blink_me">Live</span>

                            <span class="countdown{{$row->id}}" style="float:right;"></span>
                        </h2>

                        <p>Start From : {{date('d/m/Y H:i:s',strtotime($row->exam_from))}}

                     <?php 
$datetime_1 = $currentdate; 
$datetime_2 = date('Y-m-d H:i:s',strtotime($row->exam_from)); 
 
$start_datetime = new DateTime($datetime_1); 
$diff = $start_datetime->diff(new DateTime($datetime_2)); 
// echo $diff->d.' Days<br>'; 
// echo $diff->h.' Hours<br>'; 
// echo $diff->i.' Minutes<br>'; 
// echo $diff->s.' Seconds<br>';
  $timeleft="$diff->i:$diff->s";
 
   $daysdiff = $diff->format("%R%s");
 

                ?>


                        </p>
                        <p>End To : {{date('d/m/Y H:i:s',strtotime($row->exam_to))}}</p>
                        <p>Duration : {{$row->duration}}</p>
                        <p>Mark Per Question : {{$row->marks}}</p>
                        @if($row->is_neg_marking==1)
                        <p>Negative Mark Per Question : {{$row->negative_marks}}</p>
                        @endif
                        <p>Total Questions : {{$total_question}}</p>
                        <p>Passing (in %) : {{$row->passing_percentage}}</p>
                        <p>{{$row->description}}</p>
                        @if($userinfo['id']=='')
                        <a href="{{url('userlogin')}}"> <button class="btn btn-primary">Join Now</button></a>
                        @else
                       <a href="{{url('user/onlineexam/view/')}}/{{$row->id}}?type=live" target="_blank"> <button class="btn btn-primary">Start Now</button></a>
                        @endif
                    </div>

<!-- timer -->
@if($diff->d<=0 && $diff->h<=0 && $daysdiff>0)
<script>
     var timer2 = "{{$timeleft}}";
     var interval = setInterval(function() {

         var timer = timer2.split(':');
         //by parsing integer, I avoid all extra string processing
         var minutes = parseInt(timer[0], 10);
         var seconds = parseInt(timer[1], 10);
         --seconds;
         minutes = (seconds < 0) ? --minutes : minutes;
         if (minutes < 0) clearInterval(interval);
         seconds = (seconds < 0) ? 59 : seconds;
         seconds = (seconds < 10) ? '0' + seconds : seconds;
         //minutes = (minutes < 10) ?  minutes : minutes;
         $('.countdown{{$row->id}}').html(minutes + ':' + seconds);
         timer2 = minutes + ':' + seconds;
     }, 1000);
 </script>
 @endif
<!-- end timer -->
                    @endforeach
                    @foreach($list as $row)
                    <div class="col-md-3 thumbnail">
                        <a href="{{url('read')}}/{{$row->url}}">
                            <img src="{{$row->image}}" class="img-responsive feature_image_url">
                            <h2>{{$row->title}}</h2>
                            <p>{{$row->short_description}}</p>
                            <p class="btn btn-primary">Read More</p>
                        </a>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>
    </div>
    </div>

    @include('home.include.footer')

   