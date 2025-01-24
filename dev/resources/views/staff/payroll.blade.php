@include('admin.include.head');
<style>
    @media print {
        .moprintblack {
            display: none;
        }
        .content{
            display: none;
        }
      .modal-header{
        display: none;
      }
    }
    </style>
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
        <div class="content-wrapper" style="min-height: 946px;">
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
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <form id='form1' action="{{url('admin/payroll')}}" method="get" accept-charset="utf-8">
                                <div class="box-body">
                                    <div class="row">
                             
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">
                                                    Role </label>
                                                <select autofocus="" id="role" name="role" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($roles as $run)
                                                    <option value="<?= $run->id ?>" <?php if ($role == $run->id) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                                        <?= $run->name ?></option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Month</label>

                                                <select autofocus="" id="class_id" name="month" class="form-control">
                                                    <option value="select">Select</option>
                                                    <option value="January" <?php if ($month == 'January') {
                                                                                echo 'selected';
                                                                            } ?>>January
                                                    </option>
                                                    <option value="February" <?php if ($month == 'February') {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                        February</option>
                                                    <option value="March" <?php if ($month == 'March') {
                                                                                echo 'selected';
                                                                            } ?>>March
                                                    </option>
                                                    <option value="April" <?php if ($month == 'April') {
                                                                                echo 'selected';
                                                                            } ?>>April
                                                    </option>
                                                    <option value="May" <?php if ($month == 'May') {
                                                                            echo 'selected';
                                                                        } ?>>May
                                                    </option>
                                                    <option value="June" <?php if ($month == 'June') {
                                                                                echo 'selected';
                                                                            } ?>>June
                                                    </option>
                                                    <option value="July" <?php if ($month == 'July') {
                                                                                echo 'selected';
                                                                            } ?>>July
                                                    </option>
                                                    <option value="August" <?php if ($month == 'August') {
                                                                                echo 'selected';
                                                                            } ?>>August
                                                    </option>
                                                    <option value="September" <?php if ($month == 'September') {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                        September</option>
                                                    <option value="October" <?php if ($month == 'October') {
                                                                                echo 'selected';
                                                                            } ?>>October
                                                    </option>
                                                    <option value="November" <?php if ($month == 'November') {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                        November</option>
                                                    <option value="December" <?php if ($month == 'December') {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                        December</option>

                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Year</label>

                                                <select autofocus="" id="class_id" name="year" class="form-control">
                                                    <option value="select">Select</option>
                                                    <option value="2021" <?php if ($year == '2021') {
                                                                                echo 'selected';
                                                                            } ?>>2021
                                                    </option>
                                                    <option value="2022" <?php if ($year == '2022') {
                                                                                echo 'selected';
                                                                            } ?>>2022
                                                    </option>
                                                    <option value="2023" <?php if ($year == '2023') {
                                                                                echo 'selected';
                                                                            } ?>>2023
                                                    </option>
                                                </select>

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

                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"><i class="fa fa-users"></i> Staff List </i></h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body table-responsive">

                                <div class="download_label">Staff List</div>
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>

                                        <tr>
                                            <th>Staff ID</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th class="text-right no-print">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($list as $row)
                                        <?php $res = DB::select('select status,id,net_salary,gross_salary from staff_payslip where month="' . $month . '" and staff_id=' . $row->id . ' and year=' . $year);
                                        $status = $res[0]->status;
                                        $net_salary = $res[0]->net_salary;
                                        $payslipId = $res[0]->id;
                                        ?>
                                        <tr>
                                            <td><?= $row->employee_id ?></td>
                                            <td><?= $row->name ?></td>
                                            <td><?php $res = DB::select('select name from roles where id=' . $row->role);
                                                echo $res[0]->name ?> </td>
                                            <td><?php $res = DB::select('select department from department where id=' . $row->department);
                                                echo $res[0]->department ?></td>
                                            <td><?php $res = DB::select('select designation from staff_designation where id=' . $row->designation);
                                                echo $res[0]->designation ?>
                                            </td>
                                            <td><?= $row->contact_no ?></td>
                                            <td>
                                                @if($status!='')
                                                <small class='label label-<?php if ($status == 'Paid') {
                                                                                echo 'success';
                                                                            } else {
                                                                                echo 'warning';
                                                                            } ?>'>

                                                    <?= $status ?>

                                                </small>
                                                @endif
                                            </td>
                                            </td>
                                            </td>


                                            <td class="pull-right no-print">
                                                @if($status!='')
                                                <a href="{{url('admin/payroll/revert')}}/<?= $month ?>/<?= $year ?>/<?= $payslipId ?>?status=<?= $status ?>&staff_id=<?= $row->id ?>&role=<?=$_GET['role']?>" class="btn btn-default btn-xs" onclick="return confirm('Are you sure you want to revert this record')" title="Revert">
                                                    <i class="fa fa-undo"> </i>
                                                </a>
                                                @endif
                                                @if($status=='generated')
                                                @if($can_edit>0)
                                                <a href="#" onclick="getRecord(<?= $row->id ?>, <?= $year ?>,'<?= $month ?>',<?= $payslipId ?>,'<?= $row->name ?>','<?= $row->surname ?>','<?= $row->employee_id ?>',<?= $net_salary ?>)" role="button" class="btn btn-primary btn-xs checkbox-toggle edit_setting" data-toggle="tooltip" title="Proceed To Pay" data-original-title="">Proceed To Pay</a>
                                               @endif
                                                @elseif($status=='Paid')
                                                @if($can_view>0)
                                                <a href="#" onclick="getPayslip(<?= $payslipId ?>)" role="button" class="btn btn-primary btn-xs checkbox-toggle edit_setting" data-toggle="tooltip" title="View Payslip" data-original-title="">View Payslip</a>
                                                @endif
                                                @else
                                                @if($can_add>0)
                                                <a class="btn btn-primary btn-xs checkbox-toggle" role="button" href="{{url('admin/payroll/create')}}/<?= $month ?>/<?= $year ?>/<?= $row->id ?>">
                                                    Generate Payroll
                                                </a>
                                                @endif
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

            </section>
        </div>

        <div id="payslipview" class="modal fade" role="dialog">

            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Details <span id="print1"></span></h4>
                    </div>
                    <div class="modal-body" id="testdata">


                    </div>

                </div>
            </div>
        </div>


        <div id="proceedtopay" class="modal fade " role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Proceed To Pay</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <form role="form" method="post" id="schsetting_form" action="{{url('admin/payroll/paymentSuccess')}}">
                                @csrf
                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">
                                        Staff </label>
                                    <input type="text" name="emp_name" readonly class="form-control" id="emp_name">

                                </div>
                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">Payment Amount</label>
                                    <input type="text" name="amount" readonly class="form-control" id="amount">
                                </div>

                                <div class="form-group  col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">
                                        Month Year</label>
                                    <input id="monthid" name="month" readonly placeholder="" type="text" class="form-control" />
                                    <input name="paymentmonth" placeholder="" type="hidden" class="form-control" />
                                    <input name="paymentyear" placeholder="" type="hidden" class="form-control" />
                                    <input name="paymentid" placeholder="" type="hidden" class="form-control" />
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">Payment Mode</label><small class="req">
                                        *</small><br /><span id="remark">
                                    </span>
                                    <select name="payment_mode" id="payment_mode" class="form-control">
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="online">Transfer to Bank Account</option>

                                    </select>
                                    <span class="text-danger"></span>
                                </div>

                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">Payment Date</label><br /><span id="remark"> </span>
                                    <input type="date" name="payment_date" id="payment_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                </div>

                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="exampleInputEmail1">Note</label><br /><span id="remark"> </span>
                                    <textarea name="remarks" class="form-control"></textarea>
                                </div>

                                <div class="clearfix"></div>



                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <button type="button" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                        Save</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function getRecord(id, year, month, payslipid, name, surname, employee_id, net_salary) {
                $('input[name="amount"]').val(net_salary);
                $('input[name="emp_name"]').val(name + ' ' + surname + ' (' + employee_id + ')');
                $('input[name="paymentid"]').val(payslipid);
                $('input[name="paymentmonth"]').val(month);
                $('input[name="paymentyear"]').val(year);
                $('#monthid').val(month + '-' + year);


                $('#proceedtopay').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });

            };

             
            function getPayslip(id) {
                $.ajax({
                    url: '{{url("admin/payroll/payslipView")}}',
                    type: 'GET',
                    data: {
                        payslipid: id
                    },
                    success: function(result) {
                        $("#print1").html(
                            "<a href='#'  class='pull-right modal-title moprintblack'  onclick='printData("+id+")'  title='Print' ><i class='fa fa-print'></i></a>");
                        $("#testdata").html(result);
                    }
                });

                $('#payslipview').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });

            };

            function printData(id) {
                console.log('yes');
                $("#testdata").show();
    window.print();
            }


            $(document).on('click', '.submit_schsetting', function(e) {
                var $this = $(this);
                $this.button('loading');
               //let redirectUrl='{{url("admin/payroll/")}}'+$('#redirectUrl').val();
                
                $.ajax({
                    url: '{{url("admin/payroll/paymentSuccess")}}',
                    type: 'post',
                    data: $('#schsetting_form').serialize(),
                    success: function(data) {
                        if (data == 'success') {
                            successMsg('Payment successfull....');
                            window.location.reload(true);
                        } else {
                            errorMsg('Payment failed');
                            window.location.reload(true);
                        }
                        $this.button('reset');
                    }
                });
            });
        </script>
        @include('admin.include.footer');