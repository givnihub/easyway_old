@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",$perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",$perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",$perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id",$perm_cat_id)->where("can_delete", "1")->count();
        @endphp
        <?php 
  $userinfo= session()->get('userInfo');
  $student_id=$userinfo['id'];
        ?>
        <div class="content-wrapper" style="min-height: 946px;">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        @foreach($list as $run)
                        <?php $course_exam = DB::table("course_exam")->where("course_id", $run->id)->get(); ?>
                        <div id="accordionn" class="panel-group">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h4 class="panel-title display-inline-block plusblock">

                                        <a class="collapsed more-less" role="button" data-toggle="collapse" data-parent="#accordionn" href="#examaccord{{$run->id}}" aria-expanded="false" aria-controls="collapse50" style="font-weight:bold;"><i class="fa fa-plus"></i> {{$run->title}}</a></h4>
                                </div>

                                <div id="examaccord{{$run->id}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="box box-primary">
                                            <div class="box-body">
                                                <div class="table-responsive mailbox-messages">
                                                    <div class="download_label"> Online Exam</div>
                                                    <table class="table table-striped table-bordered table-hover example">
                                                        <thead>
                                                            <tr>
                                                                <th>Exam</th>
                                                                <th>Date From</th>
                                                                <th>Date To</th>
                                                                <th>Duration</th>
                                                                <th>Total Attempt</th>
                                                                <th>Attempted</th>
                                                                <th>Status</th>
                                                                <th class="text-right">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($course_exam as $row)
                                                            <?php $exam = DB::table("onlineexam")->where("id", $row->exam_id)->first();
                                                            $attempt=DB::table("attempt_quize")->where("examid",$exam->id)->where("student_id",$student_id)->first(['attempt']);
                                                            
                                                            ?>
                                                            <tr>
                                                                <td class="mailbox-name">{{$exam->exam}}</td>

                                                                <td class="mailbox-name">
                                                                    {{date('d-m-Y H:i:s',strtotime($exam->exam_from))}} </td>
                                                                <td class="mailbox-name">
                                                                    {{date('d-m-Y H:i:s',strtotime($exam->exam_to))}} </td>
                                                                <td class="mailbox-name">{{$exam->duration}}</td>


                                                                <td class="mailbox-name">{{$exam->attempt}}</td>
                                                                <td class="mailbox-name">{{$attempt->attempt?$attempt->attempt:'0'}}</td>

                                                                <td class="mailbox-name">
                                                                    {{$exam->is_active?'Available':'Not Available'}}
                                                                </td>
                                                                <td class="mailbox-name pull-right">
                                                                @if($can_view>0)   
                                                                <a data-placement="left" href="{{url('user/onlineexam/view/')}}/{{$exam->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
@endif



                                                                </td>

                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        @include('admin.include.footer')