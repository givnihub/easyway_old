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
                    <i class="fa fa-building-o"></i> Hostel </h1>
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
                                <h3 class="box-title">Add Hostel</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form id="form1" action="{{url('admin/hostel')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    <input type="hidden" value="<?= $res[0]->id ?>" name="uid">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hostel Name</label><small class="req"> *</small>
                                        <input autofocus="" id="amount" name="hostel_name" placeholder="" type="text" class="form-control" value="<?= $res[0]->hostel_name ?>" required />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label><small class="req"> *</small>

                                        <select id="type" name="type" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Girls" <?php if ($res[0]->type == 'Girls') {
                                                                        echo 'selected';
                                                                    } ?>>Girls</option>
                                            <option value="Boys" <?php if ($res[0]->type == 'Boys') {
                                                                        echo 'selected';
                                                                    } ?>>Boys</option>
                                            <option value="Combine" <?php if ($res[0]->type == 'Combine') {
                                                                        echo 'selected';
                                                                    } ?>>Combine</option>
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input id="amount" name="address" placeholder="" type="text" class="form-control" value="<?= $res[0]->address ?>" required />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Intake</label>
                                        <input id="amount" name="intake" placeholder="" type="number" class="form-control" value="<?= $res[0]->intake ?>" required />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder="" required><?= $res[0]->description ?></textarea>
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
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Hostel List</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages table-responsive">
                                    <div class="download_label">Hostel List</div>
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th>Hostel Name </th>
                                                <th>Type </th>
                                                <th>Address </th>
                                                <th>Intake</th>
                                                <th class="text-right no-print">
                                                    Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?= $row->hostel_name ?></a>

                                                    <div class="fee_detail_popover" style="display: none">
                                                        <p class="text text-info"><?= $row->description ?></p>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name"> <?= $row->type ?></td>
                                                <td class="mailbox-name"> <?= $row->address ?></td>
                                                <td class="mailbox-name"> <?= $row->intake ?></td>
                                                <td class="mailbox-date pull-right no-print">
                                                    @if($can_edit>0)
                                                    <a data-placement="left" href="{{url('admin/hostel?uid=')}}<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    @endif
                                                    @if($can_delete>0)
                                                    <a data-placement="left" href="{{url('admin/hostel?delid=')}}<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
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
                    <!--/.col (left) -->

                </div>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <!--/.col (right) -->
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->



        @include('admin.include.footer');