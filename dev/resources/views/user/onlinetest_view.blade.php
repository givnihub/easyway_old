@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @if($viewType!='webview')
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @endif
        @php
$can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_view", "1")->count();
$can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_add", "1")->count();
$can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_edit", "1")->count();
$can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",
$perm_cat_id)->where("can_delete", "1")->count();
@endphp
         <style>
             .text-success{
                 font-weight: bold;
             }
             </style>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"> Online Exam</h3>
                                <div class="box-tools pull-right">
                                    <a href="javascript:void()" onclick="history.back()" class="btn btn-info"> Back</a>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="aa">
                                    <h4 class="text-center font-weight-bold">{{$res->exam}}</h4>
                                    <!--./row-->
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <dl class="row mb10">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Total Attempt</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$res->attempt}}</dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Attempted</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$total_attempt->attempt}}</dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6"> Exam From</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">

                                                            {{date('d-m-Y H:i:s',strtotime($res->exam_from))}} </dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">
                                                            Exam To</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">
                                                            {{date('d-m-Y H:i:s',strtotime($res->exam_to))}}
                                                        </dd>

                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Duration</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$res->duration}}</dd>



                                                    </div>
                                                </div>
                                                <!--lcol-lg-6-->
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Passing (%)</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$res->passing_percentage}}</dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Total Questions</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$total_question}}</dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Marks</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$res->marks}}</dd>
                                                        <dt class="col-sm-6 col-xs-12 col-md-6 col-lg-6">Negative Marks</dt>
                                                        <dd class="col-sm-6 col-xs-12 col-md-6 col-lg-6">{{$res->negative_marks}}</dd>

                                                    </div>
                                                </div>
                                                <!--lcol-lg-6-->
                                            </dl>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <ul class="qulist_circle">
                                                <li><i class="fa fa-check-circle-o text-success"></i>Correct Answer</li>
                                                <li><i class="fa fa-dot-circle-o text-success"></i>Correct Answer but not attempted</li>
                                                <li><i class="fa fa-times-circle-o text-danger"></i>Wrong Answer</li>
                                                <!-- <li><i class="fa fa-dot-circle-o"></i>Right</li> -->
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                              
                                <div class="hrexamfirstrow"></div>
                                <div class="row">

                                    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3"><span class="font-weight-bold">Total Exam Marks: </span> {{$total_marks=$total_question*$res->marks}}</div>

                                    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3"><span class="font-weight-bold">Total Negative Marks: </span> {{$score->negative_marks}}</div>
                                    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3"><span class="font-weight-bold">Total Scored Marks: </span> {{$score->total_marks}}</div>

                                    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3">
                                        <span class="font-weight-bold">Score (%):</span> {{($score->total_marks*$total_marks)/100}} </div>
                                    <div class="col-sm-6 col-xs-12 col-md-3 col-lg-3"><span class="font-weight-bold">Exam Rank: </span>
                                        Pending </div>
                                </div>
                                <div class="hrexamfirstrow"></div>
                                @if($res->attempt>$total_attempt->attempt)
                                <div class="row no-print ">
                                    <div class="col-xs-12 ">
                                        <a href="{{url('user/startexam')}}/{{$res->id}}"  class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait"><i class="fa fa-bullhorn"></i> Start Exam</a>
                                    </div>
                                </div>
                                @else
                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <a href="#"  class="btn btn-danger pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Please wait"><i class="fa fa-bullhorn"></i> Exceed The Limit</a>
                                    </div>
                                </div>
                                 @endif
                                 <div class="hrexamfirstrow"></div>
                                <div class="row">
                                    @php $i=1 @endphp
                                    @foreach($given_exam as $runs)
                                    
                                    <?php 
                                    
                                    
                                    $question = DB::table("questions")->where("id", $runs->onlineexam_question_id)->first();
 
                                    $correct = $question->correct;
                                    $given_ans = $runs->select_option;

                                    ?>
                                    <div class="col-xs-12 col-md-12 section-box">
                                        <div>
                                            <p>
                                                <span class="font-weight-bold">Q.{{$i++}} </span>
                                                {{preg_replace("/&nbsp;/",'', $question->question)}}
                                            </p>
                                            <p>
                                                <b>Subject:</b>
                                                <?php
                                                $subject = DB::table("subjects")->where("id", $question->subject)->first(['name', 'code']);
                                                $subject->name;

                                                ?> </p>

                                            <div class="@if($given_ans=='opt_a')  text text-danger @endif @if($correct=='opt_a')  text text-success @endif @if($correct=='opt_a' && $given_ans=='opt_a')  text text-success  @endif ">
                                                <i class="@if($correct=='opt_a') fa fa-check-circle-o @else fa fa-dot-circle-o @endif"></i> {{preg_replace("/&nbsp;/",'', $question->opt_a)}} </div>
                                            <div class="@if($given_ans=='opt_b')  text text-danger @endif @if($correct=='opt_b')  text text-success @endif @if($correct=='opt_b' && $given_ans=='opt_b') text text-success @endif ">
                                                <i class="@if($correct=='opt_b') fa fa-check-circle-o @else fa fa-dot-circle-o @endif"></i> {{preg_replace("/&nbsp;/",'', $question->opt_b)}} </div>
                                            <div class="@if($given_ans=='opt_c')  text text-danger @endif @if($correct=='opt_c')  text text-success @endif @if($correct=='opt_c' && $given_ans=='opt_c') text text-success @endif ">
                                                <i class="@if($correct=='opt_c') fa fa-check-circle-o @else fa fa-dot-circle-o @endif"></i> {{preg_replace("/&nbsp;/",'', $question->opt_c)}} </div>
                                            <div class="@if($given_ans=='opt_d')  text text-danger @endif @if($correct=='opt_d')  text text-success @endif @if($correct=='opt_d' && $given_ans=='opt_d') text text-success @endif ">
                                                <i class="@if($correct=='opt_d') fa fa-check-circle-o @else fa fa-dot-circle-o @endif"></i> {{preg_replace("/&nbsp;/",'', $question->opt_d)}} </div>
                                            @if($question->opt_e!='')
                                            <div class="@if($given_ans=='opt_e')  text text-danger @endif @if($correct=='opt_e')  text text-success @endif @if($correct=='opt_e' && $given_ans=='opt_e') text text-success @endif ">
                                                <i class="@if($correct=='opt_e') fa fa-check-circle-o @else fa fa-dot-circle-o @endif"></i> {{preg_replace("/&nbsp;/",'', $question->opt_e)}} </div>
                                            @endif


                                            <p>

                                                <b>Explanation :{{$question->explanation}}</b>
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            
                                <div class="hrexamtopbottom"></div>
                     
                               


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal -->






        @include('admin.include.footer')