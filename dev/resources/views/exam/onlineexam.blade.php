@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">

        @include('admin.include.header');
        @include('admin.include.sidebar');
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
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Tutorial </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    @if(session('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?= @session('success') ?>.
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?= @session('error') ?>.
                    </div>
                    @endif
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Online Exam List</h3>

                                @if($read!='1')
                                <div class="box-tools pull-right">
                                    @if($can_add>0)
                                    <span class="btn btn-primary btn-sm pull-right question-btn" data-recordid="0"><i
                                            class="fa fa-plus"></i> Add Exam</span>
                                    @endif
                                    <a href="{{url('admin/onlineexam?type=')}}quize"><button
                                            class="btn btn-sm  @if($_GET['type']=='quize') btn-success @else btn-primary @endif">Quize</button></a>
                                    <a href="{{url('admin/onlineexam?type=')}}live"><button
                                            class="btn btn-sm @if($_GET['type']=='live') btn-success @else btn-primary @endif"">Live</button></a> 
<a href=" {{url('admin/onlineexam?type=')}}onlinetest"><button
                                                class="btn btn-sm @if($_GET['type']=='onlinetest') btn-success @else btn-primary @endif"">Online Test</button></a> 
<a href=" {{url('admin/onlineexam?type=')}}all"><button
                                                    class="btn btn-sm @if($_GET['type']=='') btn-success @elseif($_GET['type']=='all') btn-success @else btn-primary @endif"">All</button></a> &nbsp;

</div>
@endif
</div><!-- /.box-header -->
<div class=" box-body">
                                                    <div class="download_label">Online Exam List</div>
                                                    <div class="mailbox-controls">
                                                        <div class="pull-right">
                                                        </div><!-- /.pull-right -->
                                                    </div>
                                                    <div class="mailbox-messages">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-striped table-bordered table-hover example">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Exam</th>
                                                                        <th>Type</th>
                                                                        <th>Questions</th>
                                                                        <th>Attempt</th>
                                                                        <th>Exam From</th>
                                                                        <th>Exam To</th>
                                                                        <th>Duration</th>
                                                                        @if($read!='1')
                                                                        <th>Exam Publish</th>
                                                                        <th>Result Publish</th>
                                                                        @endif
                                                                        <th class="text-right">
                                                                            Action </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($list as $row)

                                                                    <?php $total_question = DB::table("onlineexam_questions")->where("examid", $row->id)->count(); ?>
                                                                    <tr>
                                                                        <td>{{$row->exam}} </td>
                                                                        <td>@if($row->is_live==1) Live , @endif
                                                                            @if($row->onlinetest==1) Online Test ,
                                                                            @endif @if($row->is_quiz==1) Quize @endif
                                                                        </td>
                                                                        <td> {{$total_question}}</td>

                                                                        <td>
                                                                            {{$row->attempt}}

                                                                        </td>
                                                                        <td>
                                                                            {{date('d/m/Y',strtotime($row->exam_from))}}

                                                                        </td>
                                                                        <td>
                                                                            {{date('d/m/Y',strtotime($row->exam_to))}}

                                                                        </td>
                                                                        <td>
                                                                            {{$row->duration}}

                                                                        </td>
                                                                        @if($read!='1')
                                                                        <td>@if($row->publish_exam_notification==1)
                                                                            <input type="checkbox" name="exam_publish"
                                                                                @if($can_edit!='1' ) disabled @endif
                                                                                checked> @else <input type="checkbox"
                                                                                name="exam_publish" @if($can_edit!='1' )
                                                                                disabled @endif> @endif</td>
                                                                        <td>@if($row->publish_result==1) <input
                                                                                type="checkbox" name="result_publish"
                                                                                checked @if($can_edit!='1' ) disabled
                                                                                @endif> @else <i
                                                                                class="fa fa-exclamation-circle"></i>
                                                                            @endif</td>
                                                                        @endif

                                                                        <td class=" dt-body-right">
                                                                            @if($read!='1')
                                                                            @if($can_add>0)
                                                                            <a href="{{url('exam/onlineexam/assign/')}}/{{$row->id}}"
                                                                                data-toggle="tooltip"
                                                                                class="btn btn-default btn-xs" title=""
                                                                                view="" student=""
                                                                                data-original-title="Assign"><i
                                                                                    class="fa fa-tag"></i></a>
                                                                            @endif
                                                                            @if($can_view>0)
                                                                            <a type="button"
                                                                                class="btn btn-default btn-xs"
                                                                                href="{{url('exam/onlineexam/addquestion/')}}/{{$row->id}}"
                                                                                data-is_quiz="0" title="Add"
                                                                                question=""><i
                                                                                    class="fa fa-question-circle"></i></a>
                                                                            @endif
                                                                            @if($can_edit)
                                                                            <button type="button" data-toggle="tooltip"
                                                                                class="btn btn-default btn-xs question-btn"
                                                                                data-recordid="{{$row->id}}" title=""
                                                                                data-original-title="Edit"><i
                                                                                    class="fa fa fa-pencil"></i></button>
                                                                            @endif
                                                                            @if($can_view>0)
                                                                            <a href="{{url('exam/getExamQuestions')}}?examid={{$row->id}}"
                                                                                class="btn btn-default btn-xs exam_ques_list"
                                                                                data-toggle="tooltip"
                                                                                data-recordid="{{$row->id}}"
                                                                                data-loading-text="<i class=&quot; fa fa-spinner fa-spin&quot;  ></i>"
                                                                                title="Exam Questions List"
                                                                                target="_blank"><i
                                                                                    class="fa fa-file-text-o"></i></a>
                                                                            @endif
                                                                            @if($can_view>0)
                                                                            <a href="{{url('exam/onlineexam/printexam')}}/{{$row->id}}"
                                                                                class="btn btn-default btn-xs"
                                                                                data-toggle="tooltip"
                                                                                title="Print Exam"> <i
                                                                                    class="fa fa-print"></i></a>
                                                                            @endif
                                                                            @if($can_delete>0)
                                                                            <a href="{{url('admin/onlineexam')}}?delid={{$row->id}}"
                                                                                class="btn btn-default btn-xs"
                                                                                data-toggle="tooltip" title="Delete"
                                                                                onclick="return confirm('Are you sure...?')"><i
                                                                                    class="fa fa fa-trash"></i></a>
                                                                            @endif
                                                                            @if($can_edit>0)
                                                                            <a href="{{url('admin/onlineexam')}}?id={{$row->id}}&status={{$row->is_active}}"
                                                                                class="btn btn-default btn-xs"
                                                                                data-toggle="tooltip"
                                                                                title="Change status"><i
                                                                                    class="@if($row->is_active==1)fa fa-check @else fa fa-remove @endif"></i></a>
                                                                            @endif
                                                                            @else
                                                                            @if($can_view>0)
                                                                            <a data-placement="left"
                                                                                href="{{url('user/onlineexam/view/')}}/{{$row->id}}"
                                                                                class="btn btn-default btn-xs"
                                                                                data-toggle="tooltip" title="View">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                            @endif
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table><!-- /.table -->
                                                        </div>
                                                    </div><!-- /.mail-box-messages -->
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Exam</h4>
                                </div>
                                <form action="{{url('admin/onlineexam')}}" method="POST" id="formsubject">
                                    @csrf
                                    <div id="ajax_response">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="load"
                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Save</button>
                                    </div>
                            </div>

                            </form>
                        </div>
                    </div>



                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <script>
        $(document).on('click', '.question-btn', function() {
            let uid = $(this).attr('data-recordid');
            $('#myModal').modal('show');
            $.ajax({
                url: '{{url("exam/ajax_addexam")}}',
                type: "GET",
                data: {
                    'uid': uid,
                },

                success: function(data) {
                    $('#ajax_response').empty();
                    $('#ajax_response').html(data);

                },

            });

        });

        //question list
        </script>
        @include(' admin.include.footer');