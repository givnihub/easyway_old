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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Offline Payment for online students</h3>
                                @if($can_view>0)
                                <div class="box-tools pull-right">
                                    <a href="{{url('admin/allowed-courses-list')}}" class="btn btn-sm btn-primary"><i class="fa fa-list-alt"></i> View Allowed Courses List</a>

                                </div>
                                @endif
                            </div>

                            <div class="box-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Trade Group</label><small class="req"> *</small>
                                            <select id="tradegroup" name="tradegroup" class="form-control" required>
                                                <option value="">Select Trade Group</option>
                                                <option value="all">All Students</option>
                                                @foreach($tradegroup as $run)
                                                <option value="{{$run->id}}">{{$run->name}}</option>
                                                @endforeach


                                            </select>
                                            <span class="text-danger" id="error_class_id"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Trade</label><small class="req"> *</small>
                                            <select id="trade" name="trade" class="form-control" required>
                                                <option value="">Select Trade</option>
                                            </select>
                                            <span class="text-danger" id="error_section_id"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Student</label><small class="req"> *</small>
                                            <select id="student_id" name="student_id" class="form-control select2">
                                                <option value="">Select</option>
                                            </select>
                                            <span class="text-danger" id="error_student_id"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="button" id="search" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <div class="download_label">Offline Payment </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example">
                                            <input type="hidden" name="student_id" value="">
                                            <thead>
                                                <tr>
                                                    <th>Course</th>
                                                    <th>TradeGroup</th>
                                                    <th>Trade</th>
                                                    <th>Price (₹)</th>
                                                    <th>Current Price (₹)</th>
                                                    <th class="text-right noExport">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fetchCourse">
                                                @foreach($courses as $row)
                                                <tr>
                                                    <td>{{$row->title}}</td>
                                                    <td><?php $res = DB::select('select name from tradegroup where id=' . $row->tradegroup_id);
                                                        echo $coursename = $res[0]->name;
                                                        ?></td>
                                                    <td><?php
                                                    $res=DB::table('trade')->where('id',$row->trade_id)->first(['name']);
                                                     echo $res->name
                                                        ?></td>
                                                    <td>{{number_format($row->price,2)}}</td>
                                                    <td> {{number_format($row->price-($row->price*(intval($row->discount)/100)),2)}}</td>
                                                    <td class="dt-body-right">
                                                        @if($can_add>0)


                                                        <button data-backdrop="static" data-price="{{number_format($price,2)}}" data-id="{{$row->id}}" data-coursetitle="{{$row->title}}" data-trade="{{$trade}}" data-toggle="modal" class="btn-success pull-right btn-xs paid_btn" data-original-title="" title="" autocomplete="off"><i class="fa fa-money"></i> Pay</button>
                                                        @else
                                                        <button class="btn-success pull-right btn-xs " data-original-title="" title="" autocomplete="off"><i class="fa fa-money"></i> Pay</button>
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
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <div class="clearfix"></div>
        </div>

        <div id="payment_modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Online Course Fee</h4>
                    </div>
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="paymentform" action="" method="post" class="ptt10">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paymentdata">
                                                @csrf
                                                <input type="hidden" name="courseid" id="courseid" value="">
                                                <input type="hidden" name="student_id" id="studentid" value="">
                                                <div class="col-lg-12">
                                                    <div class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Course Name:</label>
                                                            <div class="col-sm-9">
                                                                <label class="control-label" id="coursetitle"></label>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-sm-3 control-label">Date <small class="req"> *</small></label>
                                                            <div class="col-sm-9">
                                                                <input type="date" name="collected_date" class="form-control" autocomplete="off">
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Pay Amount <small class="req"> *</small></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" step="any" name="amount" class="form-control" autocomplete="off" required>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Discount <small class="req"> *</small></label>
                                                            <div class="col-sm-9">
                                                                <input type="number" step="any" name="discount" class="form-control" autocomplete="off">
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
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <span class="pull-right">
                                                            <h3>Total Pay</h3>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span class="pull-right">
                                                            <h3 id="totalprice"></h3>
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
        <script>
            $(document).ready(function() {
                emptyDatatable('all-list', 'data');
                $('.select2').select2();
            });
        </script>
        <script>
            //unpaid specific course
            $(document).on('click', '.unpaid_btn', function(e) {
                let student_id = $('#student_id').val();
                if (student_id == '') {
                    alert('Please select student first');
                    exit;
                }
                let course_id = $(this).attr("data-id");

            });
            //pay specific course
            $(document).on('click', '.paid_btn', function(e) {
                let student_id = $('#student_id').val();
                if (student_id == '') {
                    alert('Please select student first');
                    exit;
                }
                let course_id = $(this).attr("data-id");
                let coursetitle = $(this).attr("data-coursetitle");
                let price = $(this).attr("data-price");
                $('#courseid').val(course_id);
                $('#studentid').val(student_id);
                $('#totalprice').html(price)
                $('#coursetitle').html(coursetitle)
                $('#payment_modal').modal('show');
            });

            $(document).on('change', '#tradegroup', function(e) {
                var tradegroup = $('#tradegroup').val();
                if (tradegroup == 'all') {
                    let type = 'online';
                    $.ajax({
                        url: "{{url('ajax/students')}}",
                        type: "GET",
                        data: {
                            tradegroup_id: tradegroup,

                            type: type,
                        },
                        dataType: 'html',
                        success: function(res) {
                            $('#student_id').empty();
                            $('#student_id').append(res);

                        }
                    });
                    exit;
                }
                $.ajax({
                    url: "{{url('ajax/gettrades')}}",
                    type: "GET",
                    data: {
                        tradegroup: tradegroup
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#trade').html(res);
                    }
                });
            });
            $(document).on('change', '#trade', function(e) {
                let trade_id = $(this).val();

                let tradegroup_id = $('#tradegroup').val();
                let type = 'online';

                $.ajax({
                    url: "{{url('ajax/students')}}",
                    type: "GET",
                    data: {
                        tradegroup_id: tradegroup_id,
                        trade_id: trade_id,
                        type: type,
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#student_id').empty();
                        $('#student_id').append(res);

                    }
                });
            });
        </script>
        <script>
            //search course

            $('#search').click(function() {
                let student_id = $('#student_id').val();
                if (student_id == '') {
                    alert('Please select student first');
                    exit;
                }
                $.ajax({
                    url: "{{url('ajax/search_courses')}}",
                    type: "GET",
                    data: {
                        student_id: student_id
                    },
                    dataType: 'html',
                    success: function(res) {
                        console.log(res);
                        $('#fetchCourse').empty();
                        $('#fetchCourse').append(res);

                    }
                });

            });
        </script>
        @include('admin.include.footer')