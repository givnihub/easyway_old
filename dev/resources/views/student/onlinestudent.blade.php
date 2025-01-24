@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();
        @endphp
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Student List</h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <div class="mailbox-messages">


                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th>S.No</th>

                                                <th style="width:5%">Reference No</th>
                                                <th>Roll No</th>
                                                <th>Admission No</th>
                                                <th>Student Name</th>
                                                <th>Class</th>
                                                <th>Father Name</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>

                                                <th style="width:10%">Student Mobile Number</th>

                                                <th>Form Status</th>

                                                @if($type=='offline')<th>Registration Fee</th>@endif

                                                <th>Enrolled</th>
                                                <th class="text-right noExport ">Action</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($list as $run)
                                            <tr role="row" class="odd">
                                                <td>{{$i++}}</td>

                                                <td>{{$run->refrence_no}}</td>
                                                <td>{{$run->roll_no}}</td>
                                                <td>{{$run->admission_no}}</td>
                                                <td>{{$run->firstname}} {{$run->lastname}}</td>
                                                <td>

                                                    <?php
                                                    $batchRow = DB::select('select batch from batches where id=' . $run->batch_id);
                                                    $classRow = DB::select('select class from classes where id=' . $run->class_id);

                                                    ?>
                                                    {{ $classRow[0]->class}} ({{ $batchRow[0]->batch; }})
                                                </td>
                                                <td>{{$run->father_name}}</td>
                                                <td>{{date('d/m/Y',strtotime($run->dob))}}</td>
                                                <td>{{$run->gender}}</td>

                                                <td>{{$run->mobileno}}</td>
                                                <td>
                                                    @if($run->form_status==1)
                                                    <span class="label label-success form_status">Submitted</span>
                                                    @else
                                                    <span class="label label-danger form_status">Not Submitted</span>
                                                    @endif

                                                </td>
                                                @if($type=='offline')<td>
                                                    @if($run->pay_status==1)
                                                    <span class="label label-success">Paid</span>
                                                    @else
                                                    <span class="label label-danger" onclick="return pay_status({{$run->id}})" >Unpaid</span>
                                                    @endif
                                                </td>
                                                @endif
                                                <td>
                                                    @if($run->enrolled_status==1)
                                                    <i class="fa fa-check"></i><span style="display:none">Yes</span>
                                                    @else
                                                    <i class="fa fa-minus-circle"></i><span style="display:none">No</span>
                                                    @endif



                                                </td>
                                                <td class=" dt-body-right">
                                                    @if($run->photo!='')
                                                    @if($can_view>0)
                                                    <a data-placement="left" href="{{asset('')}}{{$run->photo}}" class="btn btn-default btn-xs mt-5 pull-right" data-toggle="tooltip" title="Download" download>
                                                        <i class="fa fa-download"></i> </a>
                                                        @endif
                                                    @endif
@if($can_view>0)
                                                    <a data-placement="left" target="_blank" href="{{url('online_admission_review')}}/{{$run->refrence_no}}" class="btn btn-default btn-xs mt-5 pull-right" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>
@endif
@if($can_edit>0)
                                                    <a data-placement="left" class="btn btn-default btn-xs mt-5 pull-right" data-toggle="tooltip" title="Edit" onclick="return checkpaymentstatus({{$run->id}},{{$run->form_status}},{{$run->pay_status}})"><i class="fa fa-edit"></i></a>
@endif
@if($can_delete>0)
                                                    <a data-placement="left" href="{{url('student/onlinestudent?delid=')}}{{$run->id}}" class="btn btn-default btn-xs mt-5 pull-right" data-toggle="tooltip" title="Delete" onclick="return confirm(&quot;Delete Confirm?&quot;  )"><i class="fa fa-remove"></i></a>
@endif
                                                </td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->

                        </div>
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div id="payment_modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Online Admission Payment</h4>
                    </div>
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="paymentform" action="{{url('payment/online_admission')}}" method="post" class="ptt10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paymentdata">
                                                @csrf
                                               
                                                <input type="hidden" name="student_id" id="studentid" value="">
                                                <div class="col-lg-12">
                                                    <div class="form-horizontal">
                                                        
                                                    
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Pay Amount <small class="req"> *</small></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" step="any" name="amount" value="100" max="100" class="form-control" autocomplete="off" required>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-sm-3 control-label">Discount <small class="req"> *</small></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" step="any" name="discount" class="form-control" autocomplete="off" >
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label"> Payment Mode</label>
                                                            <div class="col-sm-9">
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="cash" checked="checked">Cash </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="cheque">Cheque</label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="dd">DD</label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="bank_transfer">Bank Transfer</label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="upi">UPI</label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="payment_mode_fee" value="card">Card</label>
                                                                <span class="text-danger" id="payment_mode_error"></span>
                                                            </div>
                                                            <span id="form_collection_payment_mode_fee_error" class="text text-danger"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Note</label>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control" rows="5" name="fee_note" id="description"></textarea>
                                                                <span id="form_fee_note_error" class="text text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <span class="pull-right">
                                                            <h3>Total Pay</h3>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span class="pull-right">
                                                            <h3 id="totalprice">100.00</h3>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing"><i class="fa fa-money"></i> Pay</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
                </div>
                <script>
                    function pay_status(id){
                        $('#studentid').val(id);
                        $('#payment_modal').modal('show');
                    }
                    function checkpaymentstatus(id, form_status, pay_status) {

                        if (form_status == 0 && pay_status == 0) {
                            let val = `Form Status  :  Not Submitted 
Payment Status  :  Unpaid

Do you still want to enroll it?
            `;
                            if (confirm(val)) {
                                window.location.href = "{{url('student/edit')}}/" + id;
                            } else {

                            }

                        } else {
                            window.location.href = "{{url('student/edit')}}/" + id;
                        }
                    }
                </script>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->


        @include('admin.include.footer')