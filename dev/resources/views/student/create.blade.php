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
                <h1>
                    <i class="fa fa-user-plus"></i> Student Information </h1>
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
                            <!-- <div class="pull-right box-tools impbtntitle">
                                <a href="{{url('')}}/student/import">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Import Student</button>
                                </a>
                            </div> -->
                            <form id="form1" action="{{url('student/create')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <input type="hidden" name="uid" value="{{$res->id}}">
                                <input type="hidden" value="admin" name="submittedby">
                                <input type="hidden" name="redirect_type" value="{{$res->type}}">
                                <div class="">
                                    <div class="bozero">
                                        <h4 class="pagetitleh-whitebg">Student Admission </h4>
                                        <div class="around10">
                                            @csrf
                                            <input type="hidden" name="type" value="0">
                                            <input type="hidden" value="" name="admission_no" id="admission_no">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Roll Number</label>
                                                        <input id="roll_no" name="roll_no" placeholder="" type="text" class="form-control" value="{{$res->roll_no}}" />
                                                        <span class="text-danger">@error('roll_no'){{$message}}@enderror</span>
                                                        <span class="text-danger">@error('admission_no'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Class</label><small class="req">
                                                            *</small>
                                                        <select id="class_id" name="class_id" class="form-control" required />
                                                        <option value="">Select</option>
                                                        @foreach($class as $row)
                                                        <option value="<?= $row->id ?>" <?php if ($row->id == $res->class_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?= $row->class ?>
                                                        </option>
                                                        @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Batch</label><small class="req">
                                                            *</small>
                                                        <select id="batch_id" name="batch_id" class="form-control" required />
                                                        <option value="">Select</option>
                                                        @if($res->batch_id!='')
                                                        <option value="<?= $res->batch_id ?>" selected><?php $batch = DB::select('select batch from batches where id=' . $res->batch_id);
                                                                                                        echo $batch[0]->batch;
                                                                                                        ?></option>
                                                        @endif
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>



                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">First Name</label><small class="req"> *</small>
                                                        <input id="firstname" name="firstname" placeholder="" type="text" class="form-control" value="{{$res->firstname}}" required />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Last Name</label><small class="req"> *</small>
                                                        <input id="lastname" name="lastname" placeholder="" type="text" class="form-control" value="{{$res->lastname}}"  />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile"> Gender</label><small class="req">
                                                            *</small>
                                                        <select class="form-control" name="gender" required>
                                                            <option value="">Select</option>
                                                            <option value="Male" <?php if ($res->gender == 'Male') {
                                                                                        echo 'selected';
                                                                                    } ?>>Male</option>
                                                            <option value="Female" <?php if ($res->gender == 'Female') {
                                                                                        echo 'selected';
                                                                                    } ?>>Female</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Date of Birth</label><small class="req"> *</small>
                                                        <input id="dob" name="dob" placeholder="" type="date" class="form-control" value="{{$res->dob}}"  />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Mobile Number</label><small class="req"> *</small>
                                                        <input id="mobileno" name="mobileno" placeholder="" type="text" class="form-control mobileno" value="{{$res->mobileno}}" maxlength="10" minlength="10" required />
                                                        <span class="text-danger">@error('mobileno'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email</label><small class="req">
                                                            *</small>
                                                        <input id="email" name="email" placeholder="" type="email" class="form-control" value="{{$res->email}}" required />
                                                        <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Admission Date</label>
                                                        <input id="admission_date" name="admission_date" placeholder="" type="date" class="form-control" value="<?php if ($res->admission_date != '') {
                                                                                                                                                                            echo $res->admission_date;
                                                                                                                                                                        } else {
                                                                                                                                                                            echo date('Y-m-d');
                                                                                                                                                                        } ?>" required />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Aadhaar Number</label><small class="req"> *</small>
                                                        <input id="aadhaar" name="aadhaar" placeholder="" type="text" class="form-control " value="{{$res->aadhaar}}" maxlength="14"  />
                                                        <span class="text-danger">@error('aadhaar'){{$message}}@enderror</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Student Photo</label><small class="req"> *</small>
                                                        <div><input class="filestyle form-control" type='file' name='file' id="file" size='20'  />
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Pincode</label>
                                                        <div><input class=" form-control" type='number' value="{{$res->pincode}}" name='pincode' />
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">State</label>
                                                        <div><select class=" form-control" id="state_id" name='state_id' />
                                                            <option value="">Select State</option>
                                                            @foreach($state as $state_row)
                                                            <option value="<?= $state_row->id ?>" @if($state_row->
                                                                id==$res->state_id) selected @endif>
                                                                <?= $state_row->name ?>
                                                            </option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">City</label>
                                                        <div><select class=" form-control" id="city_id" name='city_id' />
                                                            <option value="">Select City</option>
                                                            @if($res->city_id!='')
                                                            <option value="<?= $res->city_id ?>" selected>
                                                                <?php $rowss = DB::select('select city from cities where id=' . $res->city_id);
                                                                echo $rowss[0]->city ?></option>
                                                            @endif
                                                            </select>
                                                        </div>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="address">Address </label>
                                                        <textarea class="address form-control" name='address' id="address" rows="2"><?= $res->address ?></textarea>

                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bozero">
                                        <h4 class="pagetitleh2">Parent Guardian Detail</h4>
                                        <div class="around10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Father Name</label>
                                                        <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="<?= $res->father_name ?>" required />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Father Phone</label>
                                                        <input id="father_phone" name="father_phone" placeholder="" type="text" maxlength="10" minlength="10" class="mobileno form-control" value="<?= $res->father_phone ?>"  />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="box-group collapsed-box">
                                        <div class="panel box collapsed-box border0 mb0">
                                            <div class="addmoredetail-title">

                                                <a data-widget="collapse" data-original-title="Collapse" class="collapsed btn boxplus">
                                                    <i class="fa fa-fw fa-plus"></i>Add More Details </a>

                                            </div>
                                            <div class="box-body">


                                                <div class="tshadow mb25 bozero">
                                                    <h4 class="pagetitleh2">
                                                        Hostel</label> Details</label>
                                                    </h4>

                                                    <div class="row around10">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Hostel</label>

                                                                <select class="form-control" id="hostel_id" name="hostel_id">

                                                                    <option value="">Select</option>
                                                                    @foreach($hostel as $run)
                                                                    <option value="<?= $run->id ?>" @if($run->
                                                                        id==$res->hostel_id) selected @endif>
                                                                        <?= $run->hostel_name ?> </option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Room No</label>
                                                                <select id="hostel_room_id" name="hostel_room_id" class="form-control">
                                                                    <option value="">Select</option>
                                                                    @if($res->hostel_room_id!='')
                                                                    <option value="<?= $res->hostel_room_id ?>" selected>
                                                                        <?php $hostRow = DB::select('select id,room_no from hostel_rooms where id=' . $res->hostel_room_id);
                                                                        echo $hostRow[0]->room_no ?>
                                                                    </option>
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div id='upload_documents_hide_show'>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="tshadow bozero">
                                                                <h4 class="pagetitleh2">Upload Documents</h4>

                                                                <div class="row around10">
                                                                    <div class="col-md-6">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width: 10px">#</th>
                                                                                    <th>Title</th>
                                                                                    <th>Documents</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>1.</td>
                                                                                    <td><input type="text" name='first_title' value="{{$res->first_title}}" class="form-control" placeholder=""></td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='first_doc' id="doc1">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>2.</td>
                                                                                    <td><input type="text" name='second_title' value="{{$res->second_title}}" class="form-control" placeholder=""></td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='second_doc' id="doc1">
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th style="width: 10px">#</th>
                                                                                    <th>Title</th>
                                                                                    <th>Documents</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>3.</td>
                                                                                    <td><input type="text" name='third_title' value="{{$res->third_title}}" class="form-control" placeholder=""></td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='third_doc' id="doc1">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>4.</td>
                                                                                    <td><input type="text" name='fourth_title' value="{{$res->fourth_title}}" class="form-control" placeholder=""></td>
                                                                                    <td>
                                                                                        <input class="filestyle form-control" type='file' name='fourth_doc' id="doc1">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="pull-right ptt10">
                                                <button type="submit" class="btn btn-info" name="save" value="save">Save</button>
                                                <button type="submit" class="btn btn-info" name="save" value="enroll">
                                                    Save And Enroll</button>

                                            </div>
                                        </div>

                                    </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#class_id').change(function() {
                let classid = $(this).val();
                let classtext = $("#class_id option:selected").text().substring(0, 2);
                $('#admission_no').val(classtext);
                $.ajax({
                    url: '{{url("ajax/class_batches")}}',
                    type: "GET",
                    data: {
                        'classid': classid,

                    },
                    success: function(data) {
                        $('#batch_id').empty();
                        $('#batch_id').append(data);

                    }


                });
            });
            $('#hostel_id').change(function() {
                let hostel_id = $(this).val();
                $.ajax({
                    url: '{{url("ajax/hostel_room")}}',
                    type: "GET",
                    data: {
                        'hostel_id': hostel_id,

                    },
                    success: function(data) {
                        $('#hostel_room_id').empty();
                        $('#hostel_room_id').append(data);

                    }


                });
            });
            $('#state_id').change(function() {
                let state_id = $(this).val();
                $.ajax({
                    url: '{{url("ajax/district")}}',
                    type: "GET",
                    data: {
                        'state_id': state_id,

                    },
                    success: function(data) {
                        $('#city_id').empty();
                        $('#city_id').append(data);

                    }


                });
            });
            $('#aadhaar').on('keypress change', function() {
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, "").replace(/\W/gi, '').replace(/(.{4})/g,
                        '$1 ');
                });
            });
            $('.mobileno').on('keypress change', function() {
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, "");
                });
            });
        });
    </script>
    @include('admin.include.footer');