<!DOCTYPE html>
@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        <div class="content-wrapper" style="min-height: 393px;">
            <section class="content-header">
                <h1><i class="fa fa-sitemap"></i> Human Resource</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="box-title">Staff Details</h3>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="btn-group pull-right">
                                            <a href="{{url('admin/payroll')}}" type="button" class="btn btn-primary btn-xs">
                                                <i class="fa fa-arrow-left"></i> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--./box-header-->
                            <div class="box-body" style="padding-top:0;">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="sfborder">
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <img width="115" height="115" class="round5" src="{{asset('')}}<?=$res[0]->image?>" alt="No Image">
                                                </div>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="row">
                                                    <table class="table mb0 font13">
                                                        <tbody>
                                                            <tr>
                                                                <th class="bozero">Name</th>
                                                                <td class="bozero" style="text-transform:capitalize;"><?=$res[0]->name?> <?=$res[0]->surname?></td>
                                                                <th class="bozero">Staff ID</th>
                                                                <td class="bozero"><?=$res[0]->employee_id?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone</th>
                                                                <td><?=$res[0]->contact_no?></td>
                                                                <th>Email</th>
                                                                <td><?=$res[0]->email?> </td>
                                                            </tr>
                                                            <tr>
                                                                <th>EPF No</th>
                                                                <td><?=$res[0]->epf_no?></td>
                                                                <th>Role</th>
                                                                <td><?php $row=DB::select('select name from roles where id='.$res[0]->role); echo $row[0]->name?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Department</th>
                                                                <td><?php $row=DB::select('select department from department where id='.$res[0]->department); echo $row[0]->department?></td>
                                                                <th>Designation</th>
                                                                <td><?php $row=DB::select('select designation from staff_designation where id='.$res[0]->designation); echo $row[0]->designation?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--./col-md-8-->
                                    <div class="col-md-4 col-sm-12">

                                        <div class="sfborder relative overvisible">
                                            <div class="letest">
                                                <div class="rotatetest">Attendance</div>
                                            </div>
                                            <div class="padd-en-rtl33">
                                                <table class="table mb0 font13">
                                                    <tr>
                                                        <th class="bozero">Month</th>
                                                        <th class="bozero"><span data-toggle="tooltip" title="Present">P</span></th>
                                                        <th class="bozero"><span data-toggle="tooltip" title="Late">L</span></th>
                                                        <th class="bozero"><span data-toggle="tooltip" title="Absent">A</span></th>
                                                        <th class="bozero"><span data-toggle="tooltip" title="Half Day">F</span></th>
                                                        <th class="bozero"><span data-toggle="tooltip" title="Holiday">H</span></th>

                                                        <th class="bozero"><span data-toggle="tooltip" title="Approved Leave">V</span></th>
                                                    </tr>
                                                    <tr>
                                                        <td>October</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>September</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>August</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>


                                                    </tr>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <!--./col-md-8-->
                                    <div class="col-md-12">
                                        <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <form class="form-horizontal" action="{{url('admin/payroll/payslip')}}" method="post" id="employeeform">
                            @csrf   
                            <div class="box-header">
           
                                    <div class="row display-flex">
                                        <div class="col-md-4 col-sm-4">
                                            <h3 class="box-title">Earning</h3>
                                            <button type="button" onclick="add_more()" class="plusign"><i class="fa fa-plus"></i></button>
                                            <div class="sameheight">
                                                <div class="feebox">
                                                    <table class="table3" id="tableID">
                                                        <tr id="row0">
                                                            <td><input type="text" class="form-control" id="allowance_type" name="allowance_type[]" placeholder="Type"></td>
                                                            <td><input type="text" id="allowance_amount" name="allowance_amount[]" class="form-control" value="0"></td>

                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-md-4-->
                                        <div class="col-md-4 col-sm-4">

                                            <h3 class="box-title">Deduction</h3>
                                            <button type="button" onclick="add_more_deduction()" class="plusign"><i class="fa fa-plus"></i></button>
                                            <div class="sameheight">
                                                <div class="feebox">
                                                    <table class="table3" id="tableID2">
                                                        <tr id="deduction_row0">
                                                            <td><input type="text" id="deduction_type" name="deduction_type[]" class="form-control" placeholder="Type"></td>
                                                            <td><input type="text" id="deduction_amount" name="deduction_amount[]" class="form-control" value="0"></td>

                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-md-4-->
                                        <div class="col-md-4 col-sm-4">

                                            <h3 class="box-title">Payroll Summary(₹)</h3>
                                            <button type="button" onclick="add_allowance()" class="plusign"><i class="fa fa-calculator"></i> Calculate</button>
                                            <div class="sameheight">
                                                <div class="payrollbox feebox">
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Basic Salary</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" name="basic" value="<?=$res[0]->basic_salary?>" id="basic" type="text" />
                                                        </div>
                                                    </div>
                                                    <!--./form-group-->
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Earning</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" name="total_allowance" id="total_allowance" type="text" />
                                                        </div>
                                                    </div>
                                                    <!--./form-group-->
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Deduction</label>
                                                        <div class="col-sm-8 deductiondred">
                                                            <input class="form-control" name="total_deduction" id="total_deduction" type="text" style="color:#f50000" />
                                                        </div>
                                                    </div>
                                                    <!--./form-group-->

                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Gross Salary</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" name="gross_salary" id="gross_salary" value="0" type="text" />
                                                        </div>
                                                    </div>
                                                    <!--./form-group-->
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Tax</label>
                                                        <div class="col-sm-8 deductiondred">
                                                            <input class="form-control" name="tax" id="tax" value="0" type="text" />
                                                        </div>
                                                    </div>
                                                    <!--./form-group-->

                                                    <hr />
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Net Salary</label>
                                                        <div class="col-sm-8 net_green">
                                                            <input class="form-control greentest" name="net_salary" id="net_salary" type="text" />
                                                            <span class="text-danger" id="err"></span>

                                                          
                                                            <input class="form-control" name="month" value="{{ request()->segment(4) }}" type="hidden" />
                                                            <input class="form-control" name="year" value="{{ request()->segment(5) }}" type="hidden" />
                                                            <input type="hidden" name="staff_id" value="{{ request()->segment(6) }}">
                                                            <input class="form-control" name="status" value="generated" type="hidden" />

                                                        </div>
                                                    </div>
                                                    <!--./form-group-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-md-4-->
                                        <div class="col-md-12 col-sm-12">

                                            <button type="submit" id="contact_submit" class="btn btn-info pull-right">Save</button>
                                        </div>
                                        <!--./col-md-12-->
                            </form>
                        </div>
                        <!--./row-->
                    </div>
                    <!--./box-header-->
                </div>
        </div>
        <!--/.col (left) -->
    </div>
    </section>
    </div>

    <script type="text/javascript">
        function add_allowance() {

            var basic_pay = $("#basic").val();
            var allowance_type = document.getElementsByName('allowance_type[]');
            var allowance_amount = document.getElementsByName('allowance_amount[]');
            //var leave_deduction = $("#leave_deduction").val();
            var tax = $("#tax").val();
            if (tax == '') {
                var tax = 0;
            }

            var total_allowance = 0;

            var deduction_type = document.getElementsByName('deduction_type[]');
            var deduction_amount = document.getElementsByName('deduction_amount[]');

            var total_deduction = 0;

            for (var i = 0; i < allowance_amount.length; i++) {

                var inp = allowance_amount[i];

                if (inp.value == '') {

                    var inpvalue = 0;
                } else {
                    var inpvalue = inp.value;
                }

                total_allowance += parseFloat(inpvalue);

            }

            for (var j = 0; j < deduction_amount.length; j++) {


                var inpd = deduction_amount[j];

                if (inpd.value == '') {

                    var inpdvalue = 0;

                } else {

                    var inpdvalue = inpd.value;
                }
                total_deduction += parseFloat(inpdvalue);
            }


            //total_deduction += parseInt(leave_deduction) ;

            var gross_salary = parseFloat(basic_pay) + parseFloat(total_allowance) - parseFloat(total_deduction);

            var net_salary = parseFloat(basic_pay) + parseFloat(total_allowance) - parseFloat(total_deduction) - parseFloat(tax);

            $("#total_allowance").val(total_allowance.toFixed(2));
            $("#total_deduction").val(total_deduction.toFixed(2));
            $("#total_allow").html(total_allowance.toFixed(2));
            $("#total_deduc").html(total_deduction.toFixed(2));
            $("#gross_salary").val(gross_salary.toFixed(2));
            $("#net_salary").val(net_salary.toFixed(2));

        }

        function add_more() {

            var table = document.getElementById("tableID");
            var table_len = (table.rows.length);
            var id = parseInt(table_len);
            var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td><input type='text' class='form-control' id='allowance_type' name='allowance_type[]' placeholder='Type'></td><td><input type='text' class='form-control' id='allowance_amount' name='allowance_amount[]'  value='0'></td><td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";
        }

        function delete_row(id) {


            var table = document.getElementById("tableID");
            var rowCount = table.rows.length;
            $("#row" + id).html("");
            //table.deleteRow(id);
        }


        function add_more_deduction() {

            var table = document.getElementById("tableID2");
            var table_len = (table.rows.length);
            var id = parseInt(table_len);
            var row = table.insertRow(table_len).outerHTML = "<tr id='deduction_row" + id + "'><td><input type='text' class='form-control' id='deduction_type' name='deduction_type[]' placeholder='Type'></td><td><input type='text' id='deduction_amount' name='deduction_amount[]' class='form-control' value='0'></td><td><button type='button' onclick='delete_deduction_row(" + id + ")' class='closebtn'><i class='fa fa-remove'></i></button></td></tr>";

        }

        function delete_deduction_row(id) {


            var table = document.getElementById("tableID2");
            var rowCount = table.rows.length;
            $("#deduction_row" + id).html("");
            //table.deleteRow(id);
        }



        $("#contact_submit").click(function(event) {

            var net = $("#net_salary").val();
            if (net == "") {

                $("#err").html("Net Salary should not be empty");
                $("#net_salary").focus();
                return false;
                event.preventDefault();
            } else {
                $("#err").html("");
            }
        });
    </script>
    @include('admin.include.footer');