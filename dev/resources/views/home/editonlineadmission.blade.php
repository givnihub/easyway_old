@include('home.include.head')
<body>
    @include('home.include.header')
    @include('home.include.menu')
    <div class="toper container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="entered mt10">Edit Online Admission</h3>
            </div>
        </div>
        <form id="form1" class="spaceb60 spacet40 onlineform" action="{{url('student/create')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="uid" value="<?= $res[0]->id ?>">
            <div class="printcontent">
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
                    <h4 class="pagetitleh2">Basic Details</h4>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Class</label><small class="req"> *</small>
                            <select id="class_id" name="class_id" class="form-control" required />
                            <option value="">Select</option>
                            @foreach($class as $row)
                            <option value="<?= $row->id ?>" <?php if ($row->id == $res[0]->class_id) {
                                                                echo 'selected';
                                                            } ?>><?= $row->class ?></option>
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
                            <option value="<?= $res[0]->batch_id ?>" selected><?php $batch = DB::select('select batch from batches where id=' . $res[0]->batch_id);
                                                                                echo $batch[0]->batch;
                                                                                ?></option>
                            </select>
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>First Name</label><small class="req"> *</small>
                            <input id="firstname" name="firstname" placeholder="" type="text" class="form-control" value="<?= $res[0]->firstname ?>" autocomplete="off" />
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label><small class="req"> *</small>
                            <input id="lastname" name="lastname" placeholder="" type="text" class="form-control" value="<?= $res[0]->lastname ?>" required />
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputFile"> Gender</label><small class="req">
                                *</small>
                            <select class="form-control" name="gender" required>
                                <option value="">Select</option>
                                <option value="Male" <?php if ($res[0]->gender == 'Male') {
                                                            echo 'selected';
                                                        } ?>>Male</option>
                                <option value="Female" <?php if ($res[0]->gender == 'Female') {
                                                            echo 'selected';
                                                        } ?>>Female</option>
                            </select>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date of Birth</label><small class="req"> *</small>
                            <input id="dob" name="dob" placeholder="" type="date" class="form-control " value="<?= $res[0]->dob ?>" required />
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mobile Number</label><small class="req"> *</small>
                            <input id="mobileno" name="mobileno" placeholder="" type="text" class="form-control mobileno" value="<?= $res[0]->mobileno ?>" maxlength="10" minlength="10" required />
                            <span class="text-danger">@error('mobileno'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label><small class="req"> *</small>
                            <input id="email" name="email" placeholder="" type="email" class="form-control" value="<?= $res[0]->email ?>" required readonly />
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Admission Date</label>
                            <input id="admission_date" name="admission_date" placeholder="" type="date" class="form-control " value="<?php if ($res[0]->admission_date != '') {
                                                                                                                                            echo $res[0]->admission_date;
                                                                                                                                        } else {
                                                                                                                                            echo date('Y-m-d');
                                                                                                                                        } ?>" required readonly />
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Aadhaar Number</label><small class="req"> *</small>
                            <input id="aadhaar" name="aadhaar" placeholder="" type="text" class="form-control " value="<?= $res[0]->aadhaar ?>" maxlength="14" required />
                            <span class="text-danger">@error('aadhaar'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputFile">Student Photo</label><small class="req"> *</small>
                            <div><input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                            <span class="text-danger">@error('file'){{$message}}@enderror</span>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputFile">Pincode</label>
                            <div><input class=" form-control" type='text' value="<?= $res[0]->pincode ?>" name='pincode' minlength="6" maxlength="6" />
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>


                </div>


                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">State</label>
                            <div><select class=" form-control" id="state_id" name='state_id' />
                                <option value="">Select State</option>
                                @foreach($state as $state_row)
                                <option value="<?= $state_row->id ?>" @if($state_row->id==$res[0]->state_id) selected @endif><?= $state_row->name ?></option>

                                @endforeach
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">City</label>
                            <div><select class=" form-control" id="city_id" name='city_id' />
                                <option value="">Select City</option>
                                @if($res[0]->city_id!='')
                                <option value="<?= $res[0]->city_id ?>" selected><?php $rowss = DB::select('select city from cities where id=' . $res[0]->city_id);
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
                            <textarea class="address form-control" name='address' id="address" rows="2"><?= $res[0]->address ?></textarea>

                            <span class="text-danger"></span>
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
                                    <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="<?= $res[0]->father_name ?>" required />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Father Phone</label>
                                    <input id="father_phone" name="father_phone" placeholder="" type="text" maxlength="10" minlength="10" class="mobileno form-control" value="<?= $res[0]->father_phone ?>" required />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="box-group collapsed-box">
                    <div class="panel box collapsed-box border0 mb0">

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
                                                <option value="<?= $run->id ?>" @if($run->id==$res[0]->hostel_id) selected @endif>
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
                                                @if($res[0]->hostel_room_id!='')
                                                <option value="<?= $res[0]->hostel_room_id ?>" selected><?php $hostRow = DB::select('select id,room_no from hostel_rooms where id=' . $res[0]->hostel_room_id);
                                                                                                        echo $hostRow[0]->room_no ?></option>
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
                                                                <td><input type="text" name='first_title' value="<?= $res[0]->first_title ?>" class="form-control" placeholder=""></td>
                                                                <td>
                                                                    <input class="filestyle form-control" type='file' name='first_doc' id="doc1">
                                                                    <span class="text-danger">@error('first_doc'){{$message}}@enderror</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2.</td>
                                                                <td><input type="text" name='second_title' value="<?= $res[0]->second_title ?>" class="form-control" placeholder=""></td>
                                                                <td>
                                                                    <input class="filestyle form-control" type='file' name='second_doc' id="doc1">
                                                                    <span class="text-danger">@error('second_doc'){{$message}}@enderror</span>
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
                                                                <td><input type="text" name='third_title' value="<?= $res[0]->third_title ?>" class="form-control" placeholder=""></td>
                                                                <td>
                                                                    <input class="filestyle form-control" type='file' name='third_doc' id="doc1">
                                                                    <span class="text-danger">@error('third_doc'){{$message}}@enderror</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4.</td>
                                                                <td><input type="text" name='fourth_title' value="<?= $res[0]->fourth_title ?>" class="form-control" placeholder=""></td>
                                                                <td>
                                                                    <input class="filestyle form-control" type='file' name='fourth_doc' id="doc1">
                                                                    <span class="text-danger">@error('fourth_doc'){{$message}}@enderror</span>
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
                <!--./row-->



                <!--./printcontent-->
                <div class="">
                    <div class="form-group pull-right">

                        <button type="submit" class="onlineformbtn">Edit & Save</button>
                    </div>
                </div>
            </div>
            <!--./row-->
        </form>

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
    </div>
    </div>
    @include('home.include.footer');