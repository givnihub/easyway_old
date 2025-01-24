@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();

        @endphp
        <style type="text/css">
            .table .pull-right {
                text-align: initial;
                width: auto;
                float: right !important;
            }
        </style>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-gears"></i> System Settings </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-md-12">
                        <div class="nav-tabs-custom theme-shadow">
                            <ul class="nav nav-tabs pull-right">

                                <li><a href="{{url('admin/users/staff')}}">Staff</a></li>

                                <li><a href="{{url('admin/users')}}">Student</a></li>

                                <li class="pull-left header">Users</li>
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane active table-responsive" id="tab_students">
                                    <div class="download_label">Users</div>
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">

                                        @if(Request::segment(3)!='')

                                        <thead>
                                            <tr>
                                                <th>StaffId</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                                <th>Phone</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($staff as $row)

                                            <tr>
                                                <td><?= $row->employee_id ?></td>
                                                <td>
                                                    <a @if($can_view>0) href="{{url('admin/staff/profile?id=')}}<?= $row->id ?>" @endif><?= $row->name ?> {{$row->surname}}</a>
                                                </td>
                                                <td>{{$row->email}}</td>
                                                <td><?php $res = DB::select('select name from roles where id=' . $row->role);
                                                    echo $res[0]->name ?>


                                                </td>
                                                <td><?php $res = DB::select('select department from department where id=' . $row->department);
                                                    echo $res[0]->department ?></td>
                                                <td><?php $res = DB::select('select designation from staff_designation where id=' . $row->designation);
                                                    echo $res[0]->designation ?></td>
                                                <td><?= $row->contact_no ?></td>
                                                <td class="relative">
                                                    <div class="material-switch pull-right">
                                                        @if($can_edit>0)
                                                        <input id="check{{$row->id}}" name="someSwitchOption001" type="checkbox" data-role="staff" class="chk" data-rowid="{{$row->id}}" value="checked" @if($run->status==0) checked='checked' @endif />
                                                        <label for="check{{$row->id}}" class="label-success"></label>
                                                        @endif
                                                    </div>
                                                </td>


                                            </tr>

                                            @endforeach

                                        </tbody>
                                        @else
                                        <thead>
                                            <tr>
                                                <th>Admission No</th>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>Class</th>
                                                <th>Father Name</th>
                                                <th>Mobile Number</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($students as $run)

                                            <tr>
                                                <td>{{$run->admission_no}}</td>
                                                <td>
                                                    <a @if($can_view>0) href="{{url('student/view')}}/{{$run->id}}" target="_blank" @endif>{{$run->firstname}} {{$run->lastname}}</a>
                                                </td>

                                                <td>{{$run->email}}</td>
                                                <td>

                                                    <?php
                                                    $batchRow = DB::select('select batch from batches where id=' . $run->batch_id);
                                                    $classRow = DB::select('select class from classes where id=' . $run->class_id);

                                                    ?>
                                                    {{ $classRow[0]->class}} ({{ $batchRow[0]->batch; }})
                                                </td>
                                                <td>{{$run->father_name}}</td>
                                                <td>{{$run->mobileno}}</td>
                                                <td class="relative">
                                                    <div class="material-switch pull-right">
                                                        @if($can_edit>0)
                                                        <input id="check{{$run->id}}" name="someSwitchOption001" type="checkbox" data-role="student" class="chk" data-rowid="{{$run->id}}" value="checked" @if($run->status==0) checked='checked' @endif />
                                                        <label for="check{{$run->id}}" class="label-success"></label>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            @endforeach

                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {

                $(document).on('click', '.chk', function() {
                    var checked = $(this).is(':checked');
                    var rowid = $(this).data('rowid');
                    var role = $(this).data('role');

                    if (checked) {
                        if (!confirm('Are you sure you active account?')) {
                            $(this).removeAttr('checked');
                        } else {
                            var status = 0;
                            changeStatus(rowid, status, role);

                        }
                    } else if (!confirm('Are you sure you deactive account?')) {
                        $(this).prop("checked", true);
                    } else {
                        var status = 1;
                        changeStatus(rowid, status, role);

                    }
                });
            });

            function changeStatus(rowid, status, role) {

                $.ajax({
                    type: "GET",
                    url: "{{url('admin/users/changeStatus')}}",
                    data: {
                        'id': rowid,
                        'status': status,
                        'role': role
                    },
                    // dataType: "json",
                    success: function(data) {
                        successMsg(data);
                    }
                });
            }
        </script>
        @include('admin.include.footer')