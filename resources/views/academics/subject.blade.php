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
            <section class="content-header">
                <h1>
                    <i class="fa fa-mortar-board"></i> Academics </h1>
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
                    <div class="col-md-4">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Subject</h3>
                            </div><!-- /.box-header -->
                            <form id="form1" action="{{url('admin/subject')}}" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    @csrf
                                    <input type="hidden" name="uid" value="<?= $res[0]->id ?>">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subject Name</label><small class="req"> *</small>
                                        <input autofocus="" id="name" name="name" placeholder="" type="text" class="form-control" value="<?= $res[0]->name ?>" required />
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="radio-inline">
                                            <input type="radio" value="theory" name="type" <?php if($res[0]->type=='theory'){echo 'checked';} ?>>Theory
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" value="practical" name="type" <?php if($res[0]->type=='practical'){echo 'checked';} ?>>Practical
                                        </label>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subject Code</label>
                                        <input id="category" name="code" placeholder="" type="text" class="form-control" value="<?= $res[0]->code ?>" autocomplete="off" required>
                                        <span class="text-danger"></span>
                                    </div>
                                </div><!-- /.box-body -->
@if($can_add>0)
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
              @endif
                            </form>
                        </div>

                    </div>
                    <!--/.col (right) -->
                    <!-- left column -->
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Subject List</h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive mailbox-messages">
                                    <div class="download_label">Subject List</div>
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>

                                                <th>Subject </th>
                                                <th>Subject Code </th>
                                                <th>Subject Type </th>


                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <tr>
                                                <td class="mailbox-name">
                                                    <?= $row->name ?>
                                                </td>


                                                <td>
                                                    <?= $row->code ?>

                                                </td>
                                                <td>
                                                    <?= $row->type ?>

                                                </td>
                                                <td class="mailbox-date pull-right">
@if($can_edit>0)
                                                    <a data-placement="left" href="{{url('admin/subject?uid=')}}<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
@endif
@if($can_delete>0)
                                                    <a data-placement="left" href="{{url('admin/subject?delid=')}}<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Deleting this class will also delete all students under this Class so be careful as this action is irreversible');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                 @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table><!-- /.table -->



                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
               

                </div>
                
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('admin.include.footer');