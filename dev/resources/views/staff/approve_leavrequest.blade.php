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
                                <h3 class="box-title titlefix">Approve Leave Request</h3> </small>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tab-pane active table-responsive no-padding">
                                            <div class="download_label">Approve Leave Request</div>
                                            <table class="table table-striped table-bordered table-hover example">
                                                <thead>

                                                    <th>Staff</th>
                                                    <th>Leave Type</th>
                                                    <th>Leave Date</th>
                                                    <th>Days</th>
                                                    <th>Apply Date</th>
                                                    <th>Status</th>
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
                                                        <td><span data-toggle="popover" class="detail_popover" data-original-title="" title="<?= $row->employee_remark ?>" style="text-transform:capitalize"><small class='label label-<?php if ($row->status == 'approve') {
                                                                                                                                                                                                                                            echo 'success';
                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                            echo 'warning';
                                                                                                                                                                                                                                        } ?>'><?= $row->status ?></small></span>


                                                        </td>
                                                        <td class="pull-right no-print">
                                                            @if($can_view>0)
                                                            <a data-placement="left" href="#leavedetails" onclick="getRecord('<?= $row->id ?>','<?= $row->applied_by ?>','<?= $row->leave_type ?>','<?= $row->leave_days ?>','<?= $row->applieddate ?>','<?= $row->status ?>','<?= $row->employee_remark ?>','<?= $row->admin_remark ?>')" role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="View"><i class="fa fa-reorder"></i></a>
                                                            @endif
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

        <div id="leavedetails" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Details</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <form role="form" method="post" id="leavedetails_form" action="{{url('admin/staff/approve_leaverequest')}}">
                                @csrf

                                <div class="col-md-12 table-responsive">
                                    <table class="table mb0 table-striped table-bordered examples">
                                        <tr>
                                            <th width="15%">Name</th>
                                            <td width="35%"><span id='name'></span></td>
                                            <th>Leave Type</th>
                                            <td><span id="leave_type"></span>
                                                <input id="leave_request_id" name="leave_request_id" placeholder="" type="hidden" class="form-control" />
                                                <span class="text-danger"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Leave</th>
                                            <td><span id='leave_from'></span> - <label> </label><span id='leave_to'> </span> (<span id='days'></span>)
                                                <span class="text-danger"></span></td>
                                            <th>Apply Date</th>
                                            <td><span id="applied_date"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <label class="radio-inline">
                                                    <input type="radio" value="pending" name="status" checked>Pending </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="approve" name="status">Approve </label>
                                                <label class="radio-inline">
                                                    <input type="radio" value="disapprove" name="status">Disapprove
                                                </label>
                                                <span class="text-danger"></span>
                                            </td>

                                            <th>Reason</th>
                                            <td><span id="remark"> </span></td>
                                        </tr>
                                        <tr>
                                            <th>Note</th>
                                        </tr>
                                        <tr>
                                            <td colspan=" 4">
                                                <div id="reason">
                                                    <textarea class="form-control" style="resize: none;" rows="2" id="detailremark" name="detailremark" placeholder=""></textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="4">
                                            @if($can_add>0)
                                                <button type="submit" style="width: auto;" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> Save</button>
                                           @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script type="text/javascript">
            function getRecord(id, applied_by, leave_type, leave_days, applieddate, status, employee_remark, admin_remark) {

                $('input:radio[name=status]').attr('checked', false);

                $('input[name="leave_request_id"]').val(id);

                $('#name').html(applied_by);

                $('#leave_type').html(leave_type);
                $('#days').html(leave_days + ' Days');
                $('#remark').html(employee_remark);
                $('#applied_date').html(applieddate);
                $("#detailremark").html(admin_remark);

                if (status == 'approve') {
                    $('input:radio[name=status]')[1].checked = true;

                } else if (status == 'pending') {
                    $('input:radio[name=status]')[0].checked = true;

                } else if (status == 'disapprove') {
                    $('input:radio[name=status]')[2].checked = true;

                }
                $('#leavedetails').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            };
        </script>
        @include('admin.include.footer');