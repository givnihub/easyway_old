@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/dist/css/course_addon.css')}}">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <span id="message"></span>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i>View Allowed Courses List</h3>

                                <div class="box-tools pull-right">
                                    <a href="{{url('admin/allow-courses')}}" class="btn btn-sm btn-primary"><i class="fa fa-list-alt"></i> Allow Courses Offline</a>
                                    <a href="{{url('admin/allow-courses-online')}}" class="btn btn-sm btn-primary"><i class="fa fa-list-alt"></i> Allow Courses Online</a>
                                </div>
                            </div>
                            <div id="course_detail_tab" class="tabcontent">
                                <section class="content">


                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                                <div class="tab-pane active table-responsive no-padding">
                                                    <div class="download_label">Approve Leave Request</div>
                                                    <table class="table table-striped table-bordered table-hover example">
                                                        <thead>
                                                            <th>Id</th>
                                                            <th>Course</th>
                                                            <th>Trade Group</th>
                                                            <th>Trade</th>
                                                            <th>Email</th>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th>Discount</th>
                                                            <th>Paid Amount</th>
                                                            <th>Rest Amount</th>
                                                            <th>Date</th>


                                                            <th class="text-right no-print">Action</th>
                                                        </thead>
                                                        <tbody>
 
                                                            @foreach($list as $row)
                                                            <?php
 
                                                            $course = DB::table("courses")->where("id", $row->course_id)->first(['title']);
                                                            $payment = DB::table("offline_course_payment")->where("course_payment_id", $row->id)->get();

                                                            ?>
                                                            <tr>
                                                                <td><?= $row->id ?></span>
                                                                </td>
                                                                <td><?= $course->title ?> </td>
                                                                <td><?php $res = DB::select('select name from tradegroup where id=' . $row->tradegroup_id);
                                                                    echo $res[0]->name;
                                                                    ?></td>
                                                                <td><?php $res = DB::select('select name from trade where id=' . $row->trade_id);
                                                                    echo $res[0]->name;
                                                                    ?></td>

                                                                <td><?= $row->email ?></td>
                                                                <td><?php $user=DB::table("students")->where("email",$row->email)->first(['firstname','lastname']);
                                                                echo $user->firstname; echo '&nbsp'.$user->lastname;
                                                                
                                                                ?></td>
                                                                <td>{{number_format($row->amount,2)}}
                                                                </td>
                                                                <td>{{number_format($row->discount,2)}}</td>
                                                                <td>
                                                                    <?php $pay_amount = 0; ?>
                                                                    @foreach($payment as $run_pay)

                                                                    <?php $pay_amount += $run_pay->amount ?>
                                                                    @endforeach
                                                                    {{number_format($pay_amount,2)}}
                                                                </td>
                                                                <td>
                                                                    <?php  $price = $row->amount - $pay_amount;
                                                                     echo  number_format($price - (int)$row->discount, 2);
                                                                    ?>
                                                                </td>
                                                                <td><?= date('d/m/Y H:i:s', strtotime($row->cdate)); ?>
                                                                </td>
                                                                <td class=" dt-body-right">
                                                                    <button data-backdrop="static" data-id="{{$row->id}}" data-toggle="modal" class="btn-primary pull-right btn-xs transactionHistory"><i class="fa fa-eye"></i> History</button>
                                                                    <button data-backdrop="static" data-id="{{$row->id}}" data-payamount="{{$price - (int)$row->discount}}" data-discount="{{number_format($row->discount,2)}}" data-toggle="modal" class="btn-success pull-right btn-xs paynow" data-original-title="" title="" autocomplete="off">
                                                                        <i class="fa fa-money"></i> Pay</button>


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
                            <!--./col-lg-3-->

                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pay Now</h4>
                </div>
                <form method="post" action="{{url('admin/allowed-courses-list')}}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="course_payment_id" id="course_payment_id" value="">
                        <div class="col-lg-12">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Pay Amount <small class="req"> *</small></label>
                                    <div class="col-sm-9">
                                        <input type="number" step="any" name="amount" id="pay_amount" class="form-control" autocomplete="off" required />
                                        <span class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Discount <small class="req"> *</small></label>
                                    <div class="col-sm-9">
                                        <input type="number" step="any" name="discount" id="discount" class="form-control" autocomplete="off">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
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

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin '></i>Processing"><i class="fa fa-money"></i> Pay</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- Transaction history Modal -->
    <div class="modal fade" id="transactionHistory" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pay History</h4>
                </div>

                <div class="modal-body">
                    <div class="showHistory"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary close">Close</button>
                </div>

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.paynow').on("click", function() {
                let course_payment_id = $(this).attr("data-id");
                let pay_amount=$(this).attr("data-payamount");
               
                $('#pay_amount').val(pay_amount);
                $('#course_payment_id').val(course_payment_id);
                let discount=$(this).attr("data-discount");
                if(discount>0){
                    $("#discount").attr({
            "readonly" : 'readonly',
            });
                }
                $("#pay_amount").attr({
            "max" : pay_amount,
            });
                $('#myModal').modal({
                    show: 'true'
                });
            });
            //view transaction history
            $('.transactionHistory').on("click", function() {
                let course_payment_id = $(this).attr("data-id");

                $.ajax({
                    url: "{{url('ajax/trasnsactionHistory')}}",
                    type: "GET",
                    data: {
                        course_payment_id: course_payment_id,
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('.showHistory').empty();
                        $('.showHistory').append(res);
                    }
                });
                $('#transactionHistory').modal({
                    show: 'true'
                });
            });



            $('#course_detail_tab').show();

        });
    </script>

    @include('admin.include.footer');