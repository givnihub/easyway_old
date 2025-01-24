@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();
        @endphp
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/dist/css/course_addon.css')}}">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <span id="message"></span>
                        <div class="box box-primary">
                            <div class="box-header with-border pb0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <h3 class="box-title header_tab_style">Course List</h3>
                                    </div>
                                    <div class="col-lg-8 col-md-9 col-sm-8">
                                        @if($can_add>0)
                                        <div class="nav-tabs-custom mb0 pull-right">
                                            <a type="button" class="btn btn-sm btn-primary miusttop5" href="{{url('admin/addcourse')}}"><i class="fa fa-plus"></i> Create
                                                Course</a>

                                        </div>
                                        @endif
                                   
                                    </div>
                                </div>
                            </div>
                            <div id="course_detail_tab" class="tabcontent">
                                <section class="content">


                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                <div class="tab-pane active table-responsive no-padding">
                                                   


                                                    <table class="table table-striped table-bordered table-hover example">
                                                        <thead>
                                                            <th>Id</th>
                                                            <th>Title</th>
                                                            <th>Trade Group</th>
                                                            <th>Trade</th>
                                                            <th>Validity(In Month)</th>
                                                            <th>Tag</th>
                                                            <th>Type</th>

                                                            <th>Status</th>
                                                            <th>Position</th>

                                                            <th class="text-right no-print">Action</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($course as $run)
                                                            <?php $row = DB::table("courses")->where("id", $run->course_id)->first();      ?>
                                                            <tr>
                                                                <td><?= $row->id ?></span>
                                                                </td>
                                                                <td><?= $row->title ?> </td>
                                                                <td><?php
                                                                    if ($row->tradegroup_id) {
                                                                        $res = DB::select('select name from tradegroup where id=' . $row->tradegroup_id);
                                                                        echo $res[0]->name;
                                                                    }

                                                                    ?></td>
                                                                <td><?php
                                                                    $trade_id = explode(",", $row->trade_id);
                                                                    for ($i = 0; $i < count($trade_id); $i++) {
                                                                        $res = DB::table('trade')->where("id", $trade_id[$i])->first();
                                                                        echo $res->name . ' , ';
                                                                    }


                                                                    ?></td>
                                                                <td><?= $row->validity > 0 ? $row->validity : $row->expiry; ?></td>
                                                                <td><?= $row->tag; ?></td>

                                                                <td><?= $row->free_course ? 'Free' : 'Paid' ?></td>
                                                                <td>
                                                               <?php if($role_id==7){?>

                                                             
                                                                <a  @if($can_edit>0) href="{{url('admin/course/?id=')}}{{$row->id}}&status={{$row->status}}" @endif>
                                                                        <small class='label label-<?php if ($row->status == '1') {
                                                                                                        echo 'success';
                                                                                                    } else {
                                                                                                        echo 'warning';
                                                                                                    } ?>'><?= $row->status ? 'Published' : 'Unpublished' ?></small></span>
                                                                    </a>

                                                               <? }else{?>
                                                                <small class='label label-<?php if ($row->status == '1') {
                                                                                                        echo 'success';
                                                                                                    } else {
                                                                                                        echo 'warning';
                                                                                                    } ?>'><?= $row->status ? 'Published' : 'Unpublished' ?></small></span>
                                                               
                                                               <?}
                                                                ?>
                                                                </td>
                                                                <td><input type="number" value="{{$row->position}}" data-id="{{$row->id}}" class="position" min="0" style="width:70px;" @if($can_edit!='1') disabled @endif></td>
                                                                <td class="pull-right no-print">
                                                                      @if($can_view>0)
                                                                    <a data-placement="left" href="{{url('admin/course/enrolledStudents')}}/{{$row->id}}" role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="View enrolled students"><i class="fa fa-eye"></i></a>
                                                                    @endif
                                                                    @if($can_edit>0)
                                                                    <a data-placement="left" href="{{url('admin/addcourse')}}?uid={{$row->id}}" role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit Content"><i class="fa fa-pencil"></i></a>
                                                                    @endif
                                                                    @if($can_add>0)
                                                                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$row->id}}" role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add Content"><i class="fa fa-plus"></i></a>
@endif
@if($can_delete>0)
                                                                    <a href="{{url('admin/course?delid=')}}<?= $row->id ?>" onclick="return confirm ('Are you sure...?')" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
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
                            <!--./col-lg-3-->

                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.position').on('change', function() {
                let id = $(this).attr('data-id');
                let position = $(this).val();
                let table = 'courses';
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/position')}}",
                    data: {
                        id: id,
                        position: position,
                        table: table
                    },
                    success: function(data) {
                        $('#message').html(data);
                    },

                });
            });
            $('#course_detail_tab').show();

        });
    </script>

    @include('admin.include.footer');