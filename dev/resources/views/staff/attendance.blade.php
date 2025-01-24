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
        <style type="text/css">
            .radio {
                padding-left: 20px;
            }

            .radio label {
                display: inline-block;
                vertical-align: middle;
                position: relative;
                padding-left: 5px;
            }

            .radio label::before {
                content: "";
                display: inline-block;
                position: absolute;
                width: 17px;
                height: 17px;
                left: 0;
                margin-left: -20px;
                border: 1px solid #cccccc;
                border-radius: 50%;
                background-color: #fff;
                -webkit-transition: border 0.15s ease-in-out;
                -o-transition: border 0.15s ease-in-out;
                transition: border 0.15s ease-in-out;
            }

            .radio label::after {
                display: inline-block;
                position: absolute;
                content: " ";
                width: 11px;
                height: 11px;
                left: 3px;
                top: 3px;
                margin-left: -20px;
                border-radius: 50%;
                background-color: #555555;
                -webkit-transform: scale(0, 0);
                -ms-transform: scale(0, 0);
                -o-transform: scale(0, 0);
                transform: scale(0, 0);
                -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
                -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
                -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
                transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
            }

            .radio input[type="radio"] {
                opacity: 0;
                z-index: 1;
            }

            .radio input[type="radio"]:focus+label::before {
                outline: thin dotted;
                outline: 5px auto -webkit-focus-ring-color;
                outline-offset: -2px;
            }

            .radio input[type="radio"]:checked+label::after {
                -webkit-transform: scale(1, 1);
                -ms-transform: scale(1, 1);
                -o-transform: scale(1, 1);
                transform: scale(1, 1);
            }

            .radio input[type="radio"]:disabled+label {
                opacity: 0.65;
            }

            .radio input[type="radio"]:disabled+label::before {
                cursor: not-allowed;
            }

            .radio.radio-inline {
                margin-top: 0;
            }

            .radio-primary input[type="radio"]+label::after {
                background-color: #337ab7;
            }

            .radio-primary input[type="radio"]:checked+label::before {
                border-color: #337ab7;
            }

            .radio-primary input[type="radio"]:checked+label::after {
                background-color: #337ab7;
            }

            .radio-danger input[type="radio"]+label::after {
                background-color: #d9534f;
            }

            .radio-danger input[type="radio"]:checked+label::before {
                border-color: #d9534f;
            }

            .radio-danger input[type="radio"]:checked+label::after {
                background-color: #d9534f;
            }

            .radio-info input[type="radio"]+label::after {
                background-color: #5bc0de;
            }

            .radio-info input[type="radio"]:checked+label::before {
                border-color: #5bc0de;
            }

            .radio-info input[type="radio"]:checked+label::after {
                background-color: #5bc0de;
            }

            @media (max-width:767px) {
                .radio.radio-inline {
                    display: inherit;
                }
            }
        </style>
 
        <div class="content-wrapper" style="min-height: 946px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><i class="fa fa-sitemap"></i> Human Resource</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
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
                    @if($attendance[0]->id!='')
                    <div class="alert alert-success">
                        Attendance Already Submitted You Can Edit Record
                    </div>

@endif                    <div class="col-md-12">
                        
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <form id='form1' action="{{url('admin/staffattendance')}}" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Role</label>

                                                <select autofocus="" id="class_id" name="user_id" class="form-control">
                                                    <option value="select">Select</option>
                                                    @foreach($role as $row)
                                                    <option value="<?= $row->id ?>" <?php if ($row->id == $user_id) {
                                                                                        echo 'selected';
                                                                                    } ?>><?= $row->name ?></option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    Attendance Date </label>
                                                <input name="date" placeholder="" type="date" class="form-control" value="<?= $date ?>" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="box-header ptbnull"></div>
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-users"></i> Staff List</h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body">
                                <form action="{{url('admin/staffattendance')}}" id="save_attendance" method="post">
                                    @csrf
                                    <div class="mailbox-controls">
                                        <span class="button-checkbox">
                                            @if($can_add>0)
                                            <button type="button" class="btn btn-sm btn-primary" data-color="primary">Mark As Holiday</button>
                                            @endif
                                            <input type="checkbox" id="checkbox1" class="hidden" name="holiday" value="checked" />
                                        </span>
                                        @if($can_add>0)
                                        <div class="pull-right">
                                            <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Save Attendance"><i class="fa fa-save"></i> Save Attendance </button>
                                        </div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="type" value=<?php if($attendance[0]->id!=''){
                                        echo '1';
                                    }?>>
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="hidden" name="role" value="">
                                    <input type="hidden" name="date" value="<?= $date ?>">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Staff ID</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Attendance</th>
                                                    <th class="text-right">Note</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; 
                     
                                                ?>
                                                @foreach($list as $row)
                                                <?php 
                                                 $atten_row=DB::select('select * from staff_attendance where  staff_id='.$row->id.' and date="'.$date.'"');

                                                ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="staff_id[]" value="<?= $row->id ?>">

                                                        <?= $i++; ?></td>
                                                    <td>
                                                        <?= $row->employee_id ?> </td>
                                                    <td>
                                                        <?= $row->name ?> <?= $row->surname ?> </td>
                                                    <td><?php $rolename = DB::select('select name from roles where id=' . $row->role);
                                                        echo $rolename[0]->name ?></td>
                                                    <td>
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="attendencetype<?= $row->id ?>-0" value="1" name="attendencetype<?= $row->id ?>" <?php if($atten_row[0]->staff_attendance_type_id=='1'){
                                                            echo 'checked';
                                                            }
                                                            if($atten_row[0]->id==''){
                                                                echo 'checked';
                                                            }
                                                            ?>>
                                                            <label for="attendencetype<?= $row->id ?>-0">
                                                                Present
                                                            </label>

                                                        </div>

                                                        <div class="radio radio-info radio-inline">

                                                            <input type="radio" id="attendencetype<?= $i ?>-1" value="2" name="attendencetype<?= $row->id ?>"
                                                            <?php if($atten_row[0]->staff_attendance_type_id=='2'){
                                                            echo 'checked';
                                                            }?>
                                                            >
                                                            <label for="attendencetype<?= $i ?>-1">
                                                                Late
                                                            </label>

                                                        </div>

                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="attendencetype<?= $i ?>-2" value="3" name="attendencetype<?= $row->id ?>" 
                                                            <?php if($atten_row[0]->staff_attendance_type_id=='3'){
                                                            echo 'checked';
                                                            }?>
                                                            >
                                                            <label for="attendencetype<?= $i ?>-2">
                                                                Absent
                                                            </label>

                                                        </div>

                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="attendencetype<?= $i ?>-3" value="4" name="attendencetype<?= $row->id ?>" 
                                                            <?php if($atten_row[0]->staff_attendance_type_id=='4'){
                                                            echo 'checked';
                                                            }?>
                                                            >
                                                            <label for="attendencetype<?= $i ?>-3">
                                                                Half Day
                                                            </label>

                                                        </div>


                                                    </td>
                                                       <input type="hidden" name="uid<?= $row->id ?>" value="<?=$atten_row[0]->id?>"> 
                                                    <td><input type="text" name="remark<?= $row->id ?>" value="<?=$atten_row[0]->remark?>"></td>
                                                </tr>
                                                <?php $i++ ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
            </section>
        </div>

        <script>
            $(document).ready(function() {
                $('#checkbox1').change(function() {
                    if (this.checked) {
                        var returnVal = confirm("Are you sure?");
                        $(this).prop("checked", returnVal);

                        $("input[type=radio]").attr('disabled', true);
                    } else {
                        $("input[type=radio]").attr('disabled', false);
                        $("input[type=radio][value='1']").attr("checked", "checked");

                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                $('.button-checkbox').each(function() {
                    var $widget = $(this),
                        $button = $widget.find('button'),
                        $checkbox = $widget.find('input:checkbox'),
                        color = $button.data('color'),
                        settings = {
                            on: {
                                icon: 'glyphicon glyphicon-check'
                            },
                            off: {
                                icon: 'glyphicon glyphicon-unchecked'
                            }
                        };
                    $button.on('click', function() {
                        $checkbox.prop('checked', !$checkbox.is(':checked'));
                        $checkbox.triggerHandler('change');
                        updateDisplay();
                    });
                    $checkbox.on('change', function() {
                        updateDisplay();
                    });

                    function updateDisplay() {
                        var isChecked = $checkbox.is(':checked');
                        $button.data('state', (isChecked) ? "on" : "off");
                        $button.find('.state-icon')
                            .removeClass()
                            .addClass('state-icon ' + settings[$button.data('state')].icon);
                        if (isChecked) {
                            $button
                                .removeClass('btn-success')
                                .addClass('btn-' + color + ' active');
                        } else {
                            $button
                                .removeClass('btn-' + color + ' active')
                                .addClass('btn-primary');
                        }
                    }

                    function init() {
                        updateDisplay();
                        if ($button.find('.state-icon').length == 0) {
                            $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                        }
                    }
                    init();
                });
            });
        </script>



        @include('admin.include.footer');