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
            <section class="content-header">
                <h1><i class="fa fa-sitemap"></i> Human Resource </h1>
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
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Leaves </h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <small class="pull-right"><a href="#addleave" onclick="addLeave()" role="button" class="btn btn-primary btn-sm checkbox-toggle pull-right edit_setting" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">Apply
                                            Leave</a></small>
                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tab-pane active table-responsive no-padding">
                                            <div class="download_label">Leaves</div>
                                            <table class="table table-striped table-bordered table-hover example">
                                                <thead>
                                                    <th>Staff</th>
                                                    <th>Leave Type</th>
                                                    <th>Leave Date</th>
                                                    <th>Days</th>
                                                    <th>Apply Date</th>
                                                    <th>Status</th>
                                                    <th>Admin Remark</th>
                                                    <th class="text-right no-print">Action</th>

                                                </thead>
                                                <tbody>
                                                    @foreach($list as $row)
                                                    <tr>

                                                        <td><span data-toggle="popover" class="detail_popover" data-original-title="" title=""><?= $row->applied_by ?></span>

                                                        </td>
                                                        <td><?= $row->leave_type ?> </td>
                                                        <td><?= $row->leave_from ?> - <?= $row->leave_to ?></td>

                                                        <td><?= $row->leave_days ?></td>
                                                        <td><?= $row->applieddate ?></td>
                                                        <td><span data-toggle="popover" class="detail_popover" data-original-title="" title="<?= $row->employee_remark ?>" style="text-transform:capitalize"><small class='label label-warning'><?= $row->status ?></small></span>
                                                        </td>
                                                        <td><?= $row->admin_remark ?></span>
                                                        </td>
                                                        <td class="pull-right no-print">
                                                            @if($can_delete>0)
                                                            <a href="{{url('admin/staff/leaverequest?delid=')}}<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a>
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
            </section>
        </div>



        <div id="addleave" class="modal fade " role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add&nbsp;Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form role="form" id="addleave_form" method="post" enctype="multipart/form-data" action="{{url('admin/staff/leaverequest')}}">
                                @csrf
                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label>Apply Date</label>
                                    <input type="date" id="applieddate" name="applieddate" value="" class="form-control" required>
                                </div>
                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-6 ">
                                    <label>
                                        Available Leave</label><small class="req"> *</small>
                                    <div id="leavetypeddl">
                                        <select name="leave_type" id="leave_type1" class="form-control">
                                            <option value="festival_leave">Festival (<?= $res[0]->festival_leave ?>)
                                            </option>
                                            <option value="emergency_leave">Emergency (<?= $res[0]->emergency_leave ?>)
                                            </option>
                                            <option value="regular_leave">Regular (<?= $res[0]->regular_leave ?>)
                                            </option>

                                        </select>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label>Leave From Date</label><small class="req"> *</small>

                                    <input type="date" id="leave_from_date" name="leave_from_date" class="form-control" required>

                                    <!-- /.input group -->
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label>Leave To Date</label><small class="req"> *</small>

                                    <input type="date" id="leave_to_date" name="leave_to_date" class="form-control" required>

                                    <!-- /.input group -->
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>Reason</label><br />
                                    <textarea name="reason" id="reason" style="resize: none;" rows="4" class="form-control"></textarea>

                                </div>
                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>Attach Document</label>
                                    <input type="file" id="file" name="userfile" class="filestyle form-control">

                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <button type="submit" class="btn btn-primary submit_addLeave pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                        Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function addLeave() {
                $('#addleave').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
        </script>


        @include('admin.include.footer');