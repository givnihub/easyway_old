@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')


        <style type="text/css">
            @media print {

                .no-print,
                .no-print * {
                    display: none !important;
                }
            }

            .option_grade {
                display: none;
            }
        </style>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-user-plus"></i> My Profile <small></small>
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="{{asset('')}}{{$res->photo}}" alt="User profile picture">
                                <h3 class="profile-username text-center">{{$res->firstname}} {{$res->lastname}}</h3>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Admission No</b> <a class="pull-right text-aqua">{{$res->admission_no}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Roll Number</b> <a class="pull-right text-aqua">{{$res->roll_no}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tradegroup</b> <a class="pull-right text-aqua">
                                    <?php $run=DB::table("tradegroup")->where("id",$res->tradegroup)->first();
                                    echo $run->name;
                                    ?>        
                                    
                                    </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Trade</b> <a class="pull-right text-aqua">
                                    <?php $run=DB::table("trade")->where("id",$res->trade)->first();
                                    echo $run->name;
                                    ?>        
                                    
                                    </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Batch</b> <a class="pull-right text-aqua">
                                    <?php $run=DB::table("batches")->where("id",$res->batch_id)->first();
                                    echo $run->batch;
                                    ?>        
                                    
                                    </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Class</b> <a class="pull-right text-aqua"><?php $run=DB::table("classes")->where("id",$res->class_id)->first();
                                    echo $run->class;
                                    ?> </a>
                                    </li>
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="nav-tabs-custom theme-shadow">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Profile</a></li>
                                <!-- <li class=""><a href="#fee" data-toggle="tab" aria-expanded="true">Fees</a></li>
                                <li><a href="#exam" data-toggle="tab" aria-expanded="true">Exam</a></li> -->
                                <li class=""><a href="#documents" data-toggle="tab" aria-expanded="true">Documents</a></li>
                               
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    <div class="tshadow mb25 bozero">
                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Admission Date</td>
                                                        <td class="col-md-5">
                                                            {{date('d-m-Y',strtotime($res->admission_date))}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td>{{date('d-m-Y',strtotime($res->dob))}}</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>Mobile Number</td>
                                                        <td>{{$res->mobileno}}</td>
                                                    </tr>
                                                   
                                                    
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$res->email}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tshadow mb25 bozero">
                                        <h3 class="pagetitleh2">Address Detail</h3>
                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Address</td>
                                                        <td class="col-md-5">{{$res->address}}</td>
                                                    </tr>
                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tshadow mb25 bozero">
                                        <h3 class="pagetitleh2">Parent / Guardian Details </h3>
                                        <div class="table-responsive around10 pt0">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td class="col-md-4">Father Name</td>
                                                    <td class="col-md-5">{{$res->father_name}}</td>
                                                    
                                                </tr>
                                              
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane" id="fee">
                                    <div class="download_label">Fee Details</div>
                                    <div class="alert alert-danger">
                                        No Record Found </div>
                                </div>
                                
                                <div class="tab-pane" id="documents">
                                    <div class="download_label">Uploaded Documents</div>
                                    <div class="timeline-header no-border">
 
                                        <div class="table-responsive" style="clear: both;">
                                            <table class="table table-striped table-bordered table-hover ">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Title </th>
                                                       
                                                        <th class="mailbox-date text-right">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>{{$res->first_title}}</td>
                                                       
                                                        <td class="mailbox-date text-right">
                                                            <a data-placement="left" href="{{asset('')}}{{$res->first_doc}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$res->second_title}}</td>
                                                       
                                                        <td class="mailbox-date text-right">
                                                            <a data-placement="left" href="{{asset('')}}{{$res->second_doc}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$res->third_title}}</td>
                                                       
                                                        <td class="mailbox-date text-right">
                                                            <a data-placement="left" href="{{asset('')}}{{$res->third_doc}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$res->fourth_title}}</td>
                                                       
                                                        <td class="mailbox-date text-right">
                                                            <a data-placement="left" href="{{asset('')}}{{$res->fourth_doc}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="exam">
                                    <div class="download_label">
                                        Exam Result </div>
                                    <div class="alert alert-danger">
                                        No Record Found </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
        <div class="modal fade" id="myTransportFeesModal" role="dialog">
            <div class="modal-dialog modal-sm400">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title title text-center transport_fees_title"></h4>
                    </div>
                    <div class="modal-body pb0">
                        <form id="form11" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" id="transport_student_session_id" value="0" readonly="readonly" />
                            <input type='hidden' name='ci_csrf_token' value='' />
                            <div id='upload_documents_hide_show'>
                                <input type="hidden" name="student_id" value="330" id="student_id">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title <small class="req">*</small></label>
                                    <input id="first_title" name="first_title" placeholder="" type="text" class="form-control" value="" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Documents <small class="req">*</small></label>
                                    <div class="">
                                        <input name="first_doc" placeholder="" type="file" class="form-control filestyle" data-height="40" value="" />
                                        <span class="text-danger"></span></div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer" style="clear:both">
                        <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal"></button> -->
                        <button type="submit" class="btn btn-info pull-right">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
        @include('admin.include.footer')