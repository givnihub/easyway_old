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
        <style>
            .w-5 {
                display: none;
            }

            .dataTables_paginate {
                display: none;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS</h1>
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
                                    <h3 class="box-title titlefix">Question Bank</h3>
                                    <div class="box-tools pull-right">
                                     
                                        @if($can_add>0)
                                        <a href="#" class="btn btn-sm btn-primary import-question" data-toggle="modal" data-target="#myQuesImportModal"><i class="fa fa-plus"></i> Import</a>
                                        <a href="{{url('exam/addquestion')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Question</a>
@endif
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="download_label">Question Bank</div>
                                    <div class="mailbox-controls">
                                        <div class="pull-right">
                                        </div>
                                    </div>
                                    <form method="get" action="">
                             <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-4">
                                            <label>Search by keyword</label>
                                                <input type="text" name="search" value="" id="search_btn" class="form-control" placeholder="Search question by title">

                                            </div>


                                            <div class="form-group col-md-4">
                                            <label for="tradegroup">Trade Group</label><small class="req">*</small>
                                            <select class="form-control" name="tradegroup" id="tradegroup" required>
                                                <option value="">Select</option>
                                                @foreach($tradegroup as $row)
                                                <option value="{{$row->id}}" @if($row->id==$tradegroupid) selected
                                                    @endif>{{$row->name}}</option>

                                                @endforeach
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="trade">Trade</label><small class="req"> *</small>
                                            <select class="form-control" name="trade" id="trade" required>
                                                <option value="">Select</option>
                                                @if($tradeid!='')
                                                <?php

                                                $run = DB::table('trade')->where('id', $tradeid)->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger class_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subject">Subject</label>
                                            <select id="subject" name="subject" class="form-control" required>
                                                <option value="">Select</option>
                                                @if($subjectid!='')
                                                <?php

                                                $run = DB::table('subject')->where('id', $subjectid)->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="chapter">Chapter</label><small class="req"> *</small>
                                            <select class="form-control" name="chapter" id="chapter" required>
                                                <option value="">Select</option>
                                                @if($chapterid!='')
                                                <?php
                                                $run = DB::table('chapter')->where('id', $chapterid)->first();
                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="topic">Topic</label><small class="req"> *</small>
                                            <select class="form-control" name="topic" id="topic" required>
                                                <option value="">Select</option>
                                                @if($topicid!='')
                                                <?php

                                                $run = DB::table('topics')->where('id', $topicid)->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                    </div>

                                            <div class="col-lg-6">
                                              
                                            <button type="submit" class="btn btn-info btn-sm post_search_submit">Search</button>
                                               
                                            </div>
                                   
                                           
                            </div>
                            </form>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">

                                       
                                    <form method="post" action="{{url('exam/bulkdelete')}}" enctype="multipart/form-data">
                            @csrf
                            @if($can_delete>0)
                            <div style="float: right;">
                                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-trash"></i> Bulk Delete</button>
                                        </div>
                                        @endif
                                        <br/>
                                        <br/>
                                    <div class="mailbox-messages" id="tag_container">

                                    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover example">
        <thead>
            <tr>
                <th><input type="checkbox" id="mastercheck"></th>
                <th>Q.ID</th>
                <th>Trade Group</th>
                <th>Trade</th>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Topic</th>
                <th>Question</th>
                <th class="text-right">
                    Action </th>
            </tr>
        </thead>
        <tbody>
        @foreach($list as $row)

                <tr>
                    <td> <input type="checkbox" value="{{$row->id}}" class="checkboxids" name="checkboxid[]"></td>
                    <td>{{$row->id}}</td>
                    <td>
                        <?php $res = DB::table('tradegroup')->where("id", $row->tradegroup)->get()->first();
                        echo $res->name;
                        ?>

                    </td>
                    <td> <?php $res = DB::table('trade')->where("id", $row->trade)->get()->first();
                            echo $res->name;
                            ?> </td>
                    <td><?php $res = DB::table('subject')->where("id", $row->subject)->get()->first();
                        echo $res->name;
                        ?> </td>
                    <td><?php $res = DB::table('chapter')->where("id", $row->chapter)->get()->first();
                        echo $res->name;
                        ?></td>
                    <td><?php $res = DB::table('topics')->where("id", $row->topic)->get()->first();
                        echo $res->name;
                        ?></td>
                    <td>{!!substr($row->question,0,100)!!}....</td>
                    <td class="text-right">
                        @if($can_view>0)
                        <a target="_blank" href="{{url('exam/question/read')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="View">
                            <i class="fa fa-eye"></i></a>
                        @endif
                        @if($can_edit>0)
                        <a href="{{url('exam/addquestion')}}?qid={{$row->id}}" data-placement="left" class="btn btn-default btn-xs question-btn-edit" data-toggle="tooltip" id="load" data-recordid="58" title="Edit"><i class="fa fa-pencil"></i>

                        </a>
                        @endif
                        @if($can_delete>0)
                        <a data-placement="left" href="{{url('admin/question')}}?delid={{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?')"><i class="fa fa-remove"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
                                    </div>
                                    </div><!-- /.mail-box-messages -->

                                    </form>
                                    </div>
                                </div>
                                </div>
                       

                    </div>
                    <!--/.col (left) -->

                </div>
                <div id="myQuesImportModal" class="modal fade" role="dialog">

                    <div class="modal-dialog">

                        <!-- Modal content-->

                        <div class="modal-content">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <a class="btn btn-primary pull-right btn-xs mt5" href="{{asset('public/uploads/documents/questionformat.csv')}}" download/><i class="fa fa-download"></i> </a>

                                <h4 class="modal-title"> Import Question</h4>

                            </div>

                            <form action="{{url('exam/addquestion')}}" method="POST" id="formimportquestion" enctype="multipart/form-data">
                <input type="hidden" name="fileupload" value="fileupload">
                            @csrf
                                <div class="modal-body add_question_import_body">


                                    <div class="form-group ">

                                        <label for="tradegroup">Trade Group</label><small class="req">*</small>

                                        <select class="form-control" name="tradegroup" id="tradegroup2">

                                            <option value="">Select</option>

                                            @foreach($tradegroup as $run)
                                            <option value="{{$run->id}}"> {{$run->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text text-danger subject_id_error"></span>
                                    </div>
                                    <div class="form-group ">
                                        <label for="trade">Trade</label><small class="req"> *</small>
                                        <select class="form-control" name="trade" id="trade2">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text text-danger class_id_error"></span>
                                    </div>
                                    <div class="form-group ">
                                        <label for="subject">Subject</label>
                                        <select id="subject2" name="subject" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group ">
                                        <label for="chapter">Chapter</label><small class="req"> *</small>
                                        <select class="form-control" name="chapter" id="chapter2">
                                            <option value="">Select</option>
                                        </select>
                                        <span class="text text-danger subject_id_error"></span>
                                    </div>
                                    <div class="form-group ">
                                        <label for="topic">Topic</label><small class="req"> *</small>
                                        <select class="form-control" name="topic" id="topic2">

                                            <option value="">Select</option>

                                        </select>

                                        <span class="text text-danger subject_id_error"></span>

                                    </div>
                                    <div class="form-group">

                                        <label for="exampleInputEmail1"> Attach File</label>

                                        <input id="my-file-selector" name="file" placeholder="" type="file" class="filestyle form-control" value="" />

                                        <span class="text-danger"></span>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Upload</button>

                                </div>

                        </div>

                        </form>

                    </div>

                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        
        <!--//for import questions-->
        
        <script>
            $(document).ready(function() {
                $('#tradegroup2').change(function() {
                    let groupid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/trade")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,

                        },

                        success: function(data) {
                            $('#trade2').empty();
                            $('#trade2').append(data);

                        },

                    });
                });

                $('#trade2').change(function() {
                    let groupid = $('#tradegroup2').val();

                    let tradeid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/subject")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,
                            'tradeid': tradeid

                        },
                        success: function(data) {
                            $('#subject2').empty();
                            $('#subject2').append(data);

                        }
                    });
                });

                $('#subject2').change(function() {
                    let groupid = $('#tradegroup2').val();
                    let tradeid = $('#trade2').val();
                    let subjectid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/chapter")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,
                            'tradeid': tradeid,
                            'subjectid': subjectid,

                        },

                        success: function(data) {
                            $('#chapter2').empty();
                            $('#chapter2').append(data);

                        }

                    });
                });
                $('#chapter2').change(function() {
                    let chapterid = $(this).val();
                    let groupid = $('#tradegroup2').val();
                    let tradeid = $('#trade2').val();
                    let subjectid = $('#subject2').val();
                    $.ajax({
                        url: '{{url("ajax/topic")}}',
                        type: "GET",
                        data: {
                            'chapterid': chapterid,
                            'groupid': groupid,
                            'tradeid': tradeid,
                            'subjectid': subjectid,

                        },

                        success: function(data) {
                            $('#topic2').empty();
                            $('#topic2').append(data);

                        }

                    });
                });
            });
        </script>
        
        <!--end for import queston-->
        <script>
            $(document).ready(function() {
                $('#tradegroup').change(function() {
                    let groupid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/trade")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,

                        },

                        success: function(data) {
                            $('#trade').empty();
                            $('#trade').append(data);

                        },

                    });
                });

                $('#trade').change(function() {
                    let groupid = $('#tradegroup').val();

                    let tradeid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/subject")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,
                            'tradeid': tradeid

                        },
                        success: function(data) {
                            $('#subject').empty();
                            $('#subject').append(data);

                        }
                    });
                });

                $('#subject').change(function() {
                    let groupid = $('#tradegroup').val();
                    let tradeid = $('#trade').val();
                    let subjectid = $(this).val();
                    $.ajax({
                        url: '{{url("ajax/chapter")}}',
                        type: "GET",
                        data: {
                            'groupid': groupid,
                            'tradeid': tradeid,
                            'subjectid': subjectid,

                        },

                        success: function(data) {
                            $('#chapter').empty();
                            $('#chapter').append(data);

                        }

                    });
                });
                $('#chapter').change(function() {
                    let chapterid = $(this).val();
                    let groupid = $('#tradegroup').val();
                    let tradeid = $('#trade').val();
                    let subjectid = $('#subject').val();
                    $.ajax({
                        url: '{{url("ajax/topic")}}',
                        type: "GET",
                        data: {
                            'chapterid': chapterid,
                            'groupid': groupid,
                            'tradeid': tradeid,
                            'subjectid': subjectid,

                        },

                        success: function(data) {
                            $('#topic').empty();
                            $('#topic').append(data);

                        }

                    });
                });
            });
        </script>
        @if($_GET['tradegroup']=='')
        <script>
            $(document).ready(function(){
                var page = 1;
                fetch_data(page);
            });
        </script>
        @endif
        <script>
            $(document).ready(function() {
            
                $('#search_btn').change(function() {

                    let keywords = $(this).val();
                    $.ajax({
                        url: "{{url('admin/question')}}?keywords=" + keywords,
                        success: function(data) {
                            $('#tag_container').empty().html(data);
                            location.hash = page;
                        }
                    });

                });
            });
            $(window).on('hashchange', function() {
                if (window.location.hash) {
                    var page = window.location.hash.replace('#', '');
                    if (page == Number.NaN || page <= 0) {
                        return false;
                    } else {
                        fetch_data(page);
                    }
                }
            });

            $(document).on('click', '.pagination a', function(event) {

                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var url = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                fetch_data(page);
            });

            function fetch_data(page) {

                $.ajax({
                    url: "{{url('admin/question')}}?page=" + page,
                    success: function(data) {
                        $('#tag_container').empty().html(data);
                        location.hash = page;
                    }
                });
            }
            $(document).on('click', '#mastercheck', function() {

                if ($(this).prop("checked")) {

                    $(".checkboxids").prop("checked", true);

                } else {

                    $(".checkboxids").prop("checked", false);

                }

            });
        </script>
        @include('admin.include.footer');