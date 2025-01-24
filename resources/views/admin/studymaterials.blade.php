@include('admin.include.head');
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();
        @endphp
        <div class="content-wrapper">
             
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
                                <h3 class="box-title titlefix">Document List</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <a href="{{url('master/studymaterial/create')}}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-plus"></i> Add</a>

                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">Document List</div>
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Trade Group</th>
                                                    <th>Trade</th>
                                                    <th>Subject</th>
                                                    <th>Chapter</th>
                                                    <th>Topic</th>
                                                    <th class="text-right no-print">
                                                        Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($list as $row)
                                                <tr id="5">
                                                    <td><?= $i++ ?></td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?= $row->name ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?php $groupname = DB::select('select name from tradegroup where id=' . $row->tradegroup);
                                                                    echo $groupname[0]->name;

                                                                    ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?php $groupname = DB::select('select name from trade where id=' . $row->trade);
                                                                    echo $groupname[0]->name;

                                                                    ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?php $res = DB::select('select name from subject where id=' . $row->subject);
                                                                    echo $res[0]->name;

                                                                    ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?php $res = DB::select('select name from chapter where id=' . $row->chapter);
                                                                    echo $res[0]->name;

                                                                    ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <a href="#"><?php $res = DB::select('select name from topics where id=' . $row->topic);
                                                                    echo $res[0]->name;

                                                                    ?></a>
                                                    </td>

                                                    <td class="mailbox-date pull-right no-print">
                                                    @if($can_view>0)   
                                                    <a data-placement="left"
                                                            href="{{asset('')}}<?=$row->docs?>" target="_blank"
                                                            class="btn btn-default btn-xs" data-toggle="tooltip"
                                                            title="" data-original-title="Read">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @endif
                                                        @if($can_edit>0)
                                                        <a data-placement="left"
                                                            href="{{url('master/studymaterial/create/?id=')}}<?= $row->id ?>"
                                                            class="btn btn-default btn-xs" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @endif
                                                        @if($can_delete>0)
                                                        <a data-placement="left"
                                                            href="{{url('master/studymaterials?id=')}}<?= $row->id ?>"
                                                            class="btn btn-default btn-xs" data-toggle="tooltip"
                                                            title="Delete" onclick="return confirm('Delete Confirm?');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
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
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('admin.include.footer');