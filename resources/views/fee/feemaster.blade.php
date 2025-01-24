@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')




        <style type="text/css">
            .liststyle1 {
                margin: 0;
                list-style: none;
                line-height: 28px;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content-header">
                <h1>
                    <i class="fa fa-money"></i> Fees Collection</h1>
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
                    <div class="col-md-4">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Fees Master </h3>
                            </div><!-- /.box-header -->
                            <form id="form1" action="{{url('master/feemaster')}}" id="feemasterform" name="feemasterform" method="post" accept-charset="utf-8">
                                <div class="box-body">

                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
<input type="hidden" name="uid" value="{{$_GET['uid']}}">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Fees Group</label> <small class="req">*</small>

                                                <select autofocus="" id="fee_groups_id" name="fee_groups_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($group as $rows)
                                                    <option value="{{$rows->id}}" @if($res->fee_groups_id==$rows->id) selected @endif>{{$rows->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Fees Type</label><small class="req">
                                                    *</small>

                                                <select id="feetype_id" name="feetype_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($feetype as $rows)
                                                    <option value="{{$rows->id}}" @if($res->feetype_id==$rows->id) selected @endif>{{$rows->type}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="text-danger"></span>
                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Due Date</label><small class="req" id="due_date_error"> </small>
                                                <input id="due_date" name="due_date" placeholder="" type="date" class="form-control" value="{{$res->due_date}}" />
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Amount</label><small class="req">
                                                    *</small>
                                                <input id="amount" name="amount" placeholder="" type="text" class="form-control" value="{{$res->amount}}" />
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="input-type">Fine Type</label>
                                                    <div id="input-type" class="row">
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">

                                                                <input name="account_type" class="finetype" id="input-type-student" value="none" type="radio" 
                                                                @if($_GET['uid']!='')
                                                                @if($res->account_type=='none')
                                                                        checked

                                                                @endif
                                                                @else
                                                                checked="checked" 
                                                                @endif
                                                                />None </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input name="account_type" class="finetype" id="input-type-student" value="percentage" type="radio" 
                                                                @if($res->account_type=='percentage')
                                                                        checked

                                                                @endif
                                                                
                                                                />Percentage </label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label class="radio-inline">
                                                                <input name="account_type" class="finetype" id="input-type-tutor" value="fix" type="radio" 
                                                                @if($res->account_type=='fix')
                                                                        checked

                                                                @endif
                                                                />
                                                                Fix Amount </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Percentage</label><small class="req">
                                                    *</small>
                                                <input id="fine_percentage" name="fine_percentage" placeholder="" type="text" class="form-control" value="{{$res->fine_percentage}}" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Fine Amount</label><small class="req">
                                                    *</small>
                                                <input id="fine_amount" name="fine_amount" placeholder="" type="text" class="form-control" value="{{$res->fine_amount}}" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>



                                    </div>



                                </div><!-- /.box-body -->

                                <div class="box-footer">

                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--/.col (right) -->
                    <!-- left column -->
                    <div class="col-md-8">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Fees Master List </h3>

                            </div><!-- /.box-header -->

                            <div class="box-body">
                                <div class="download_label">Fees Master List </div>
                                <div class="mailbox-messages">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                                <tr>
                                                    <th>Fees Group</th>
                                                    <th>Fees Code</th>

                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list as $row)
                                                <?php
                                                $group = DB::table("fee_groups")->where("id", $row->fee_groups_id)->get()->first();
                                                $type = DB::table("feetype")->where("id", $row->feetype_id)->get()->first();
                                                ?>
                                                <tr>
                                                    <td class="mailbox-name">
                                                        <a href="#" data-toggle="popover" class="detail_popover"> {{$group->name}}</a>


                                                    </td>

                                                    <td class="mailbox-name">
                                                        <ul class="liststyle1">
                                                            <li> <i class="fa fa-money"></i>
                                                                {{$type->code}} ₹{{number_format($row->amount,2)}} &nbsp;&nbsp;
                                                                <a href="{{url('master/feemaster?uid=')}}{{$row->id}}" data-toggle="tooltip" title="Edit">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>&nbsp;
                                                                <a href="{{url('master/feemaster?delid=')}}{{$row->id}}" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                                    <i class="fa fa-remove"></i>
                                                                </a>

                                                            </li>

                                                        </ul>
                                                    </td>

                                                    <td class="mailbox-date pull-right">
                                                        <a data-placement="left" href="{{url('master/feemaster/assign')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Assign / View Student">
                                                            <i class="fa fa-tag"></i>
                                                        </a>
                                                        <a data-placement="left" href="{{url('master/feemaster/deletegrp')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->


                            </form>
                        </div>

                    </div>
                    <!--/.col (right) -->
                    <!-- left column -->


                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->


        <script type="text/javascript">
            $(document).ready(function() {
                var account_type = "0";
                load_disable(account_type);


            });

            $(document).on('change', '.finetype', function() {

                calculatefine();
            });


            $(document).on('keyup', '#amount,#fine_percentage', function() {

                calculatefine();
            });


            function load_disable(account_type) {
                if (account_type === "percentage") {
                    $('#due_date_error').html(' *');
                    $('#fine_amount').prop('readonly', true);
                    $('#fine_percentage').prop('readonly', false);
                } else if (account_type === "fix") {
                    $('#due_date_error').html(' *');
                    $('#fine_amount').prop('readonly', false);
                    $('#fine_percentage').prop('readonly', true);
                } else {
                    $('#due_date_error').html('');
                    $('#fine_amount').prop('readonly', true);
                    $('#fine_percentage').prop('readonly', true);
                }
            }



            function calculatefine() {
                var amount = $('#amount').val();
                var fine_percentage = $('#fine_percentage').val();

                var finetype = $('input[name=account_type]:checked', '#form1').val();

                if (finetype === "percentage") {
                    $('#due_date_error').html(' *');
                    fine_amount = ((amount * fine_percentage) / 100).toFixed(2);
                    $('#fine_amount').val(fine_amount).prop('readonly', true);
                    $('#fine_percentage').prop('readonly', false);
                } else if (finetype === "fix") {
                    $('#due_date_error').html(' *');
                    $('#fine_amount').val("").prop('readonly', false);
                    $('#fine_percentage').val("").prop('readonly', true);
                } else {
                    $('#due_date_error').html('');
                    $('#fine_amount').val("");
                    $('#fine_percentage').val("");
                    $('#fine_amount').prop('readonly', true);
                    $('#fine_percentage').prop('readonly', true);
                }

            }

            $(document).ready(function() {
                $('.detail_popover').popover({
                    placement: 'right',
                    trigger: 'hover',
                    container: 'body',
                    html: true,
                    content: function() {
                        return $(this).closest('td').find('.fee_detail_popover').html();
                    }
                });


            });
        </script>
        @include('admin.include.footer')