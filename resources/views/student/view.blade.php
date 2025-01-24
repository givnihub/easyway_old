@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <section class="content-header" style="padding-right: 0;">
                        <h1>
                            <i class="fa fa-user-plus"></i> Student Information <small></small></h1>

                    </section>
                </div>
                <!-- /.control-sidebar -->
            </div>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">

                        <div class="box box-primary" @if($row->status=='1') style="background-color:#f0dddd;" @endif>
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="<?php if($row->photo==''){?>

                                        {{asset('public/uploads/student_documents/default_male.jpeg')}}
                                    <?}else{?>
                                        {{asset('')}}<?=$row->photo?> 
                                        <?}?>
                                        " alt="User profile picture">
                                <h3 class="profile-username text-center">{{$row->firstname}} {{$row->lastname}}</h3>

                                <ul class="list-group list-group-unbordered">

                                    <li class="list-group-item listnoback">
                                        <b>Admission No</b> <a class="pull-right text-aqua">{{$row->admission_no}}</a>
                                    </li>
                                    <li class="list-group-item listnoback">
                                        <b>Roll Number</b> <a class="pull-right text-aqua">{{$row->roll_no}}</a>
                                    </li>
                                    <li class="list-group-item listnoback">
                                        <b>Class</b> <a class="pull-right text-aqua"><?php $result=DB::table('classes')->where('id',$row->class_id)->first();
                                        echo $result->class;
                                        ?></a>
                                    </li>
                                    <li class="list-group-item listnoback">
                                        <b>Batch</b> <a class="pull-right text-aqua"><?php $result=DB::table('batches')->where('id',$row->batch_id)->first();
                                        echo $result->batch;
                                        ?></a>
                                    </li>

                                    <li class="list-group-item listnoback">
                                        <b>Gender</b> <a class="pull-right text-aqua">{{$row->gender}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-9">

                        <div class="nav-tabs-custom theme-shadow">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab"
                                        aria-expanded="true">Profile</a></li>

                                <li class=""><a href="#fee" data-toggle="tab" aria-expanded="true">Purchased Courses</a>
                                </li>

                                <li class=""><a href="#documents" data-toggle="tab" aria-expanded="true">Documents</a>
                                </li>
                                @if($row->status==1)
                                <li class="pull-right">
                                    <a style="cursor: pointer;" onclick="enable_student({{$row->id}})" class="text-red"
                                        data-toggle="tooltip" data-placement="bottom" title="Disable">
                                        <i class="fa fa-thumbs-o-up"></i> </a>
                                </li>
                                @else

                                <li class="pull-right">
                                    <a style="cursor: pointer;" onclick="disable_student({{$row->id}})" class="text-red"
                                        data-toggle="tooltip" data-placement="bottom" title="Disable">
                                        <i class="fa fa-thumbs-o-down"></i> </a>
                                </li>


                                <li class="pull-right">
                                    <a href="#" class="schedule_modal text-green" data-toggle="tooltip"
                                        data-placement="bottom" title="Login Details"><i class="fa fa-key"></i>
                                    </a>
                                </li>


                                <li class="pull-right">
                                    <a href="{{url('student/edit')}}/{{$row->id}}" class="" data-toggle="tooltip"
                                        data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i>

                                    </a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <div class="tshadow mb25 bozero">
                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped tmb0">
                                                <tbody>
                                                <tr>
                                                        <td class="col-md-4">Admission Date</td>
                                                        <td class="col-md-5">{{date('d-m-Y',strtotime($row->cdate))}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Admission No</td>
                                                        <td class="col-md-5">{{$row->admission_no}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td>{{date('d-m-Y',strtotime($row->dob))}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Mobile Number</td>
                                                        <td>{{$row->mobileno}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$row->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Note</td>
                                                        <td>{{$row->note}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tshadow mb25 bozero">
                                        <h3 class="pagetitleh2">Address Detail</h3>
                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped tmb0">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Address</td>
                                                        <td class="col-md-5">{{$row->address}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pincode</td>
                                                        <td>{{$row->pincode}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <td><?php 
                                                        if($row->state_id){
                                                            $res=DB::select('select name from states where id='.$row->state_id);
                                                            echo $res[0]->name;
                                                        }
                                                       
                                                        
                                                        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>City</td>
                                                        <td><?php 
                                                        if($row->city_id){
                                                            $res=DB::select('select city from cities where id='.$row->city_id);
                                                            echo $res[0]->city;
                                                        }
                                                       
                                                        
                                                        ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tshadow mb25 bozero">
                                        <h3 class="pagetitleh2">Parent / Guardian Details </h3>
                                        <div class="table-responsive around10 pt10">
                                            <table class="table table-hover table-striped tmb0">
                                                <tr>
                                                    <td class="col-md-4">Father Name</td>
                                                    <td class="col-md-5">{{$row->father_name}}</td>

                                                </tr>
                                                <tr>
                                                    <td>Father Phone</td>
                                                    <td>{{$row->father_phone}}</td>
                                                </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tshadow mb25  bozero">
                                        <h3 class="pagetitleh2">Hostel Details</h3>

                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped tmb0">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Hostel</td>
                                                        <td class="col-md-5"><?php 
                                                        if($row->hostel_id!=''){
                                                            $res=DB::select('select hostel_name from hostel where id='.$row->hostel_id);
                                                            echo $res[0]->hostel_name;
                                                        }
                                                       
                                                        
                                                        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Room No</td>
                                                        <td class="col-md-5"><?php
                                                        if($row->hostel_room_id!=''){
                                                            $res=DB::select('select room_no,title,room_type_id from hostel_rooms where id='.$row->hostel_room_id);
                                                            echo $res[0]->room_no;
                                                        }
   
                                                        
                                                        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Room Type</td>
                                                        <td class="col-md-5"><?php 
                                                        if($res[0]->room_type_id!=''){
                                                            $ress=DB::select('select room_type,description from room_types where id='.$res[0]->room_type_id);
                                                            echo $ress[0]->room_type;
                                                        }
                                                        
                                                        
                                                        ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="fee">
                                    <div class="table-responsive">

                                        <table class="table table-hover table-striped">

                                            <thead>
                                                <tr>
                                                    <th>Course Title</th>
                                                    <th>Price</th>
                                                    <th>Purchased Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="dark-gray">
                                                    @foreach($course as $course_run)
<td>{{$course_run->title}}</td>
<td>{{number_format($course_run->amount,2)}}</td>
<td>{{date('d-m-Y',strtotime($course_run->cdate))}}</td>
@endforeach

                                                   
                                                </tr>


                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane" id="documents">
                                    <div class="timeline-header no-border">

                                        <div class="table-responsive" style="clear: both;">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Title </th>
                                                        <!-- <th>
                                                            Name </th> -->
                                                        <th class="mailbox-date">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <div class="row">
                                                    <tbody>
                                                        <?php if($row->first_title=='' && $row->second_title=='' && $row->third_title=='' && $row->fourth_title==''){
                                                            echo '                                <tr>
                                                            <td colspan="5" class="text-danger text-center">No Record
                                                                Found</td>
                                                        </tr>';
                                                        }else{?>
                                                        <tr>
                                                            <td>{{$row->first_title}}</td>
                                                            <!-- <td>{{$row->first_doc}}</td> -->
                                                            <td><a href="{{asset('')}}{{$row->first_doc}}"
                                                                    download>Download</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$row->second_title}}</td>
                                                            <!-- <td>{{$row->second_doc}}</td> -->
                                                            <td><a href="{{asset('')}}{{$row->second_doc}}"
                                                                    download>Download</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$row->third_title}}</td>
                                                            <!-- <td>{{$row->third_doc}}</td> -->
                                                            <td><a href="{{asset('')}}{{$row->third_doc}}"
                                                                    download>Download</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{$row->fourth_title}}</td>
                                                            <!-- <td>{{$row->fourth_doc}}</td> -->
                                                            <td><a href="{{asset('')}}{{$row->fourth_doc}}"
                                                                    download>Download</a></td>
                                                        </tr>
                                                        <?}?>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </table>
                                </div>




                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <div class="modal fade" id="myTimelineModal" role="dialog">
            <div class="modal-dialog modal-sm400">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title title transport_fees_title"></h4>
                    </div>
                    <div class="">
                        <div class="">
                            <form id="timelineform" name="timelineform" method="post" enctype="multipart/form-data">
                                <div class="modal-body pb0">
                                    <input type='hidden' name='ci_csrf_token' value='' />
                                    <div id='timeline_hide_show' class="row">
                                        <input type="hidden" name="student_id" value="224" id="student_id">

                                        <div class=" col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Title</label><small class="req">
                                                    *</small>
                                                <input id="timeline_title" name="timeline_title" placeholder=""
                                                    type="text" class="form-control" />
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Date</label><small class="req">
                                                    *</small>
                                                <input id="timeline_date" value="22.11.2022" name="timeline_date"
                                                    placeholder="" type="text" class="form-control" />
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Description</label>
                                                <textarea id="timeline_desc" name="timeline_desc" placeholder=""
                                                    class="form-control"></textarea>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Attach Document</label>
                                                <div class=""><input id="timeline_doc_id" name="timeline_doc"
                                                        placeholder="" type="file" class="filestyle form-control"
                                                        data-height="40" value="" />
                                                    <span class="text-danger"></span></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="labeltopmb0">Visible to this person</label>
                                                <input id="visible_check" checked="checked" name="visible_check"
                                                    value="yes" placeholder="" type="checkbox" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                    <button type="reset" id="reset" style="display: none"
                                        class="btn btn-info pull-right">Reset</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="scheduleModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title_logindetail">Login Details</h4>
                    </div>
                    <div class="modal-body_logindetail">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <p class="lead text text-center">{{$row->firstname}} {{$row->lastname}}</p>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User Type</th>
                                            <th class="text text-center">Username</th>
                                            <th class="text text-center">Password</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td><b>Parent</b></td><input type="hidden" name="userid" id="userid"
                                                value="439">
                                            <td class="text text-center">parent224</td>
                                            <td class="text text-center">n6ajhw</td>
                                        </tr> -->
                                        <tr>
                                            <td><b>Student</b></td><input type="hidden" name="userid" id="userid"
                                                value="438">
                                            <td class="text text-center">{{$row->email}}</td>
                                            <td class="text text-center">{{$row->plain_pass}}</td>
                                        </tr>
                                    </tbody>
                                </table><b class="lead text text-danger" style="font-size:14px;"> Login Url:
                                    {{url('userlogin')}}</b>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="disable_modal" tabindex="-1" role="dialog" aria-labelledby="evaluation"
            style="padding-left: 0 !important">
            <div class="modal-dialog " role="document">
                <div class="modal-content modal-media-content">
                    <div class="modal-header modal-media-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="box-title">Disable Student</h4>
                    </div>
                    <form role="form" id="disable_form" method="post" enctype="multipart/form-data"
                        action="{{url('student/disable')}}">

                        <div class="modal-body pt0 pb0">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 paddlr">
                                    <div class="row">
                                        @csrf

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd">Reason</label><small class="req"> *</small>
                                                <input type="hidden" name="student_id" value="{{$res->id}}"
                                                    id="disstudent_id">
                                                <select class="form-control" name="reason">
                                                    <option value="">Select</option>
                                                    @foreach($reason as $res)
                                                    <option value="{{$res->id}}">{{$res->reason}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd">Date</label>
                                                <input name="disable_date" class="form-control" type="date"
                                                    value="{{date('Y-m-d')}}" type="text" />

                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="pwd">Note</label>
                                                <textarea name="note" class="form-control"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <div class="pull-right paddA10">
                                <button class="btn btn-info pull-right"
                                    data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait"
                                    value="">Save</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function(e) {

        $("#timelineform").on('submit', (function(e) {
            var student_id = $("#student_id").val();

            e.preventDefault();
            $.ajax({
                url: "{{url('')}}/admin/timeline/add",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    if (data.status == "fail") {

                        var message = "";
                        $.each(data.error, function(index, value) {

                            message += value;
                        });
                        errorMsg(message);
                    } else {

                        successMsg(data.message);
                        window.location.reload(true);
                    }

                },
                error: function(e) {
                    alert("Fail");
                    console.log(e);
                }
            });

        }));
    });

    function delete_timeline(id) {

        var student_id = $("#student_id").val();
        if (confirm('Delete Confirm?')) {

            $.ajax({
                url: '{{url('')}}/admin/timeline/delete_timeline/' + id,
                success: function(res) {
                    $.ajax({
                        url: '{{url('')}}/admin/timeline/student_timeline/' +
                            student_id,
                        success: function(res) {
                            $('#timeline_list').html(res);

                        },
                        error: function() {
                            alert("Fail")
                        }
                    });

                },
                error: function() {
                    alert("Fail")
                }
            });
        }
    }

    function disable_student(id) {

        if (confirm("Are you sure you want to disable this student.")) {
            $('#disstudent_id').val(id);
            $('#disable_modal').modal('show');
        }
    }

    function enable_student(id) {

        if (confirm("Are you sure you want to enable this student.")) {


            $.ajax({
                url: '{{url("student/disable_reason")}}',
                type: "GET",
                data: {
                    'studentid': id,
                    'type': 'enable'

                },
                success: function(data) {
                    if (data == 1) {
                        successMsg('Student Enabled now...');

                        window.location.reload(true);
                    } else {
                        errorMsg('Some error occured');
                    }

                }


            });

        }
    }
    $("#disable_form").on('submit', (function(e) {
        e.preventDefault();
        var id = $('#disstudent_id').val();
        var $this = $(this).find("button[type=submit]:focus");

        $.ajax({
            url: "{{url('student/disable_reason')}}",
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $this.button('loading');

            },
            success: function(res) {

                if (res == "fail") {

                    var message = "";
                    $.each(res.error, function(index, value) {

                        message += value;
                    });
                    errorMsg(message);

                } else {

                    successMsg('Student disabled now...');

                    window.location.reload(true);
                }
            },
            error: function(xhr) { // if error occured
                alert("Error occured.please try again");
                $this.button('reset');
            },
            complete: function() {
                $this.button('reset');
            }

        });
    }));







    // function send_password() {
    //     var base_url = '{{url('')}}/';
    //     var student_id = '224';
    //     var username = 'std224';
    //     var password = '9okqmw';
    //     var contact_no = '9525437145';
    //     var email = '';

    //     $.ajax({
    //         type: "post",
    //         url: base_url + "student/sendpassword",
    //         data: {
    //             student_id: student_id,
    //             username: username,
    //             password: password,
    //             contact_no: contact_no,
    //             email: email
    //         },

    //         success: function(response) {
    //             successMsg('Message successfully sent');
    //         }
    //     });

    // }

    // function send_parent_password() {
    //     var base_url = '{{url('')}}/';
    //     var student_id = '224';
    //     var username = 'parent224';
    //     var password = 'n6ajhw';
    //     var contact_no = '0';
    //     var email = '';

    //     $.ajax({
    //         type: "post",
    //         url: base_url + "student/send_parent_password",
    //         data: {
    //             student_id: student_id,
    //             username: username,
    //             password: password,
    //             contact_no: contact_no,
    //             email: email
    //         },

    //         success: function(response) {
    //             successMsg('Message successfully sent');
    //         }
    //     });
    // }


    $(document).on('click', '.schedule_modal', function() {
        $("#scheduleModal").modal('show');



    });

    function firstToUpperCase(str) {
        return str.substr(0, 1).toUpperCase() + str.substr(1);
    }
    </script>


    @include('admin.include.footer')