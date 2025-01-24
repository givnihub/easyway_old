@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
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
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom theme-shadow">
                            <ul class="nav nav-tabs pull-right">

                                <li><a href="#tab_students" data-toggle="tab">Student</a></li>
                                <li class="active"><a href="#tab_system" data-toggle="tab">System</a></li>

                                <li class="pull-left header"> Modules</li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane table-responsive active" id="tab_system">
                                    <div class="download_label">Modules</div>
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>

                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <tr>
                                                <td>{{$row->title}}</td>
                                                <td class="relative">
                                                    <div class="material-switch pull-right">
@if($can_edit>0)
                                                        <input id="system{{$row->id}}" name="someSwitchOption001" type="checkbox" data-role="system" class="chk" data-rowid="{{$row->id}}" @if($row->system=='1') value="checked" checked='checked' @endif/>
                                                        <label for="system{{$row->id}}" class="label-success"></label>
                                                   @endif
                                                    </div>

                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane table-responsive" id="tab_students">
                                    <div class="download_label">Users</div>
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>

                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $row)
                                            <tr>
                                                <td>{{$row->title}}</td>
                                                <td class="relative">
                                                    <div class="material-switch pull-right">
@if($can_edit>0)
                                                        <input id="student{{$row->id}}" name="someSwitchOption001" type="checkbox" data-role="student" class="chk" data-rowid="{{$row->id}}" @if($row->student=='1') value="checked" checked='checked' @endif/>
                                                        <label for="student{{$row->id}}" class="label-success"></label>
               @endif
                                                    </div>

                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                        </tbody>
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
                        if (!confirm('Are you sure?')) {
                            $(this).removeAttr('checked');

                        } else {
                            var status = "1";
                            if (role == 'system') {
                                changeStatus(rowid, status, role);

                            }  else if (role == 'student') {

                                changeStudentStatus(rowid, status, role);

                            }


                        }

                    } else if (!confirm('Are you sure?')) {
                        $(this).prop("checked", true);
                    } else {
                        var status = "0";
                        if (role == 'system') {
                            changeStatus(rowid, status, role);

                        } else if (role == 'student') {

                            changeStudentStatus(rowid, status, role);

                        }
                    }
                });
            });

            function changeStatus(rowid, status, role) {
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:"{{url('master/module')}}",
                    data: {
                        'id': rowid,
                        'status': status,
                        'role': role
                    },
                   // dataType: "json",
                    success: function(data) {
                        successMsg(data);
                        window.location.reload();
                    }
                });
            }

            function changeStudentStatus(rowid, status, role) {
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:"{{url('master/module')}}",
                    data: {
                        'id': rowid,
                        'status': status,
                        'role': role
                    },
                  //  dataType: "json",
                    success: function(data) {
                        successMsg(data);
                        window.location.reload();
                    }
                });
            }

            function changeParentStatus(rowid, status, role) {

                var base_url = '{{url('')}}/';

                $.ajax({
                    type: "POST",
                    url: base_url + "admin/module/changeStudentStatus",
                    data: {
                        'id': rowid,
                        'status': status,
                        'role': role
                    },
                    dataType: "json",
                    success: function(data) {
                        successMsg(data.msg);
                        window.location.reload();
                    }
                });
            }
        </script>
        @include('admin.include.footer')