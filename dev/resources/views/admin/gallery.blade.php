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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?=@session('success')?>.
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?=@session('error')?>.
                    </div>
                    @endif
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Gallery List</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <a href="gallery/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>

                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class>
                                        <div class="mailbox-controls">
                                            <div class="pull-right">
                                            </div><!-- /.pull-right -->
                                        </div>
                                        <div class="mailbox-messages">
                                            <div class="download_label"> Gallery List</div>
                                            <table class="table table-striped table-bordered table-hover example">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>URL</th>
                                                        <th class="text-right no-print">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($list as $row)
                                                    <tr id="12">
                                                        <td class="mailbox-name">
                                                            <a href="#"><?= $row->title ?></a>
                                                        </td>
                                                        <td class="mailbox-name"> <a href="../gallery/<?=str_replace(" ", "-", strtolower($row->title)); ?>" target="_blank"><?= $row->title ?></a>
                                                        </td>

                                                        <td class="mailbox-date pull-right no-print">
                                                            @if($can_edit>0)
                                                            <a data-placement="left" href="gallery/create?id=<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            @endif
                                                            @if($can_delete>0)
                                                            <a data-placement="left" href="gallery?id=<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table><!-- /.table -->
                                        </div><!-- /.mail-box-messages -->
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('admin.include.footer');