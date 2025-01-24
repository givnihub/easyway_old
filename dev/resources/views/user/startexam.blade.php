@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <?php $userinfo = session()->get('userInfo'); ?>
    <div class="wrapper">

        <style type="text/css">
            .btn-blue {
                background: blue;
                border: 1px solid blue;
                color: #fff;
            }

            .btn-danger {
                color: #fff;
            }
        </style>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="questionmodal">
                    <form id="regiration_form" action="{{url('exam/submit_exam')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div id="onlineexample" class="modal fade in" role="dialog" aria-hidden="false" style="display: block;">
                            <div class="modal-dialog modal-dialogfullwidth">
                                <!-- Modal content-->
                                <div class="modal-content modal-contentfull">
                                    <div class="modal-header">

                                        <div class="questionlogo"><img src="{{asset('')}}{{$setting->admin_logo}}" alt="Easy Way Global"></div>
                                    </div>
                                    <div class="exambgtop">
                                        <h3>{{$exam->exam}}</h3>
                                        <div class="exambgright">
                                            <div class="timeclock">
                                                <i class="fa fa-clock-o"></i>
                                                <div id="box_header" class="inlineblock valign-middle">00:00:00</div>
                                            </div>
                                            <button type="submit" class="btn btn-info btn-sm save_exam_btn">Submit </button>
                                        </div>
                                    </div>
                                    <!-- ./exambgtop -->
                                    <div class="modal-body">
                                        <span id="spanFileName"></span>
                                        <div class="row question_container">

                                            <div class="col-md-9 col-sm-9">

                                                <input type="hidden" name="marks" value="{{$exam->marks}}">
                                                <input type="hidden" name="negative_marks" value="{{$exam->negative_marks}}">
                                                <input type="hidden" name="onlineexam_student_id" value="{{$userinfo['id']}}">
                                                <input type="hidden" name="is_quiz" value="{{$exam->is_quiz}}">
                                                <input type="hidden" name="examid" value="{{$exam->id}}">
                                                <div class="question_list">
                                                    <?php $i = 1; ?>
                                                    @foreach($res as $row)
                                                    <?php $question = DB::table("questions")->where("id", $row->question_id)->first(['question', 'opt_a', 'opt_b', 'opt_c', 'opt_d', 'opt_e', 'correct']) ?>
                                                    <fieldset id="question_{{$i}}" @if($i==0) style="display: block;" @endif>
                                                        <input type="hidden" name="total_rows[]" value="{{$row->question_id}}">
                                                        <input type="hidden" name="question_id_{{$i}}" value="{{$row->question_id}}">

                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-12">
                                                                <h3 class="mt0">Question:{{$i}}</h3>
                                                            </div>
                                                            <div class="col-md-8 col-sm-12">
                                                                <div class="text-right">
                                                                    <span class="ques_marks text text-danger valign-sub">(Marks: {{$exam->marks}}, Negative Marks: {{$exam->negative_marks}})</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="quizscroll">
                                                            {{preg_replace("/&nbsp;/",'', $question->question)}}
                                                            <div class="radiocontainer">
                                                                <label>
                                                                    <input type="radio" name="radio{{$i}}" value="opt_a" autocomplete="off"> {{preg_replace("/&nbsp;/",'',$question->opt_a)}} </label>

                                                                <label>
                                                                    <input type="radio" name="radio{{$i}}" value="opt_b" autocomplete="off">{{preg_replace("/&nbsp;/",'',$question->opt_b)}} </label>

                                                                <label>
                                                                    <input type="radio" name="radio{{$i}}" value="opt_c" autocomplete="off">{{preg_replace("/&nbsp;/",'',$question->opt_c)}} </label>

                                                                <label>
                                                                    <input type="radio" name="radio{{$i}}" value="opt_d" autocomplete="off">{{preg_replace("/&nbsp;/",'',$question->opt_d)}}</label>
                                                                @if($question->opt_e!='')
                                                                <label>
                                                                    <input type="radio" name="radio{{$i}}" value="opt_e" autocomplete="off">{{preg_replace("/&nbsp;/",'',$question->opt_e)}} </label>
                                                                @endif
                                                            </div> <!-- ./radiocontainer -->
                                                        </div>
                                                        <!--./quizscroll-->

                                                    </fieldset>
                                                    @php $i++ @endphp
                                                    @endforeach

                                                </div>

                                            </div><!-- ./col-md-12-->
                                            <div class="col-md-3 col-sm-3">
                                                <div class="quizscroll">
                                                    <h3 class="mt0 btn btn-danger"> Question Map</h3>
                                                    <?php $j = 1; ?>
                                                    @foreach($res as $run)

                                                    <button type="button" class="btn btn-default question_switcher @if($j==1) activeqbtn @endif" data-qustion_no="{{$j}}">{{$j}}</button>
                                                    @php $j++; @endphp
                                                    @endforeach


                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="quizfooter">
                                <input type="button" name="next" class="next qbtn-markreview btn btn-info" value="Mark For Review">
                                <input type="button" name="next" class="next qbtn-previous" value="Previous" style="display: none;" autocomplete="off">
                                <input type="button" name="next" class="next qbtn-next" value="Next" autocomplete="off">
                            </div>
                            <!-- ./quizfooter -->
                        </div>
                        <!--./-->
                    </form>
                </div>
            </section>
        </div>

    </div>

</body>


<!-- questionmodal -->

<script type="text/javascript">
    $(document).ready(function() {
        var current = 1,
            current_step, next_step, steps, elapsed_seconds;
        steps = 0;
        elapsed_seconds = 0;
        var timer2 = "00:00:00";
        $(document).on('click', '.qbtn-next', function() {

            if ($("div.question_list").find("fieldset:visible").next().is(":last-child")) {
                $('.qbtn-next').toggle();
            }

            current_step = $("div.question_list").find("fieldset:visible");
            next_step = $("div.question_list").find("fieldset:visible").next();


            next_step.show();
            current_step.hide();


            if ($("div.question_list").find("fieldset:visible").prev().length) {
                $('.qbtn-previous').show();
            }

            if ($("div.question_list").find("fieldset:visible").next().length) {
                $('.qbtn-next').show();
            }

            activeQuestionButton();

        });
        $(document).on('click', '.qbtn-markreview', function() {

            if ($("div.question_list").find("fieldset:visible").next().is(":last-child")) {
                $('.qbtn-next').toggle();
            }

            current_step = $("div.question_list").find("fieldset:visible");
            next_step = $("div.question_list").find("fieldset:visible").next();


            next_step.show();
            current_step.hide();


            if ($("div.question_list").find("fieldset:visible").prev().length) {
                $('.qbtn-previous').show();
            }

            if ($("div.question_list").find("fieldset:visible").next().length) {
                $('.qbtn-next').show();
            }

            var qu = $("div.question_list").find("fieldset:visible").attr('id');
            var qustion_n = qu.split("question_");
            var sss = $("button[data-qustion_no='" + qustion_n[1] + "']");
            var prevqu = qustion_n[1] - 1;
            var counts = $('input[name=radio' + prevqu + ']:checked').length;
            if ($('input[name=radio' + prevqu + ']:checked').length > 0) {
                sss.prev().addClass("activeqbtn");
            } else {
                sss.prev().addClass("btn btn-blue text-light");
            }

        });

        $(document).on('click', '.qbtn-previous', function() {

            if ($("div.question_list").find("fieldset:visible").prev().is(":first-child")) {

                $('.qbtn-previous').hide();
            }
            current_step = $("div.question_list").find("fieldset:visible");
            next_step = $("div.question_list").find("fieldset:visible").prev();
            next_step.show();
            current_step.hide();

            if ($("div.question_list").find("fieldset:visible").prev().length) {
                $('.qbtn-previous').show();
            }
            if ($("div.question_list").find("fieldset:visible").next().length) {
                $('.qbtn-next').show();
            }
            activeQuestionButton();
        });


    });

    function activeQuestionButton() {
        var qu = $("div.question_list").find("fieldset:visible").attr('id');
        var qustion_n = qu.split("question_");
        var sss = $("button[data-qustion_no='" + qustion_n[1] + "']");

        var prevqu = qustion_n[1] - 1;
        var counts = $('input[name=radio' + prevqu + ']:checked').length;
        if ($('input[name=radio' + prevqu + ']:checked').length > 0) {
            sss.prev().addClass("activeqbtn");
        } else {
            sss.prev().addClass("btn btn-danger");
        }


    }
</script>
<script type="text/javascript">
    $(document).on('click', '.question_switcher', function() {
        var question_no = $(this).data('qustion_no');

        var btn = $(this).addClass("activeqbbtn");


        var $this = $("div.question_list").find("fieldset#question_" + question_no);

        $("div.question_list").find("fieldset").not($this).hide();
        $this.show();

        if ($("div.question_list").find("fieldset:visible").is(":first-child")) {
            $('.qbtn-previous').hide();
        }

        if ($("div.question_list").find("fieldset:visible").is(":last-child")) {
            $('.qbtn-next').hide();
        }

        if ($("div.question_list").find("fieldset:visible").prev().length) {
            $('.qbtn-previous').show();
        }

        if ($("div.question_list").find("fieldset:visible").next().length) {
            $('.qbtn-next').show();
        }

    });
</script>
<script type="text/javascript">
    var timer2 = '{{$exam->duration}}';
    var interval;
    var timer = function() {
        interval = setInterval(function() {
            $('#box_header').text(get_elapsed_time_string());
        }, 1000);
    };


    function get_elapsed_time_string() {
        function pretty_time_string(num) {
            return (num < 10 ? "0" : "") + num;
        }

        timer111 = timer2.split(':');

        var hours = parseInt(timer111[0], 10);
        var minutes = parseInt(timer111[1], 10);
        var seconds = parseInt(timer111[2], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        seconds = (seconds < 0) ? 59 : seconds;
        hours = (minutes < 0) ? --hours : hours;
        minutes = (minutes < 0) ? 59 : minutes;

        hours = pretty_time_string(hours);
        minutes = pretty_time_string(minutes);
        seconds = pretty_time_string(seconds);

        if (hours < 0)
            clearInterval(interval);

        if ((seconds <= 0) && (minutes <= 0) && (hours <= 0)) {
            clearInterval(interval);
            $("#regiration_form").submit();
        }

        timer2 = hours + ":" + minutes + ":" + seconds;
        var currentTimeString = hours + ":" + minutes + ":" + seconds;

        return currentTimeString;
    }
    timer();
</script>



@include('admin.include.footer')