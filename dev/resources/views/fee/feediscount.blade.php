@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
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
                                <h3 class="box-title">Add Fees Discount</h3>
                            </div><!-- /.box-header -->
                            <form id="form1" action="{{url('master/feediscount')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$res->id}}">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label> <small class="req">*</small>
                                        <input autofocus="" id="name" name="name" type="text" class="form-control" value="{{$res->name}}" required/>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Discount Code</label> <small class="req">*</small>
                                        <input id="code" name="code" type="text" class="form-control" value="{{$res->code}}" required/>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount</label> <small class="req">*</small>
                                        <input id="amount" name="amount" type="number" class="form-control" value="{{$res->amount}}" step="any" required/>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{$res->description}}</textarea>
                                        <span class="text-danger"></span>
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
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Fees Discount List</h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">Fees Discount List</div>
                                <div class="mailbox-messages table-responsive">
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th>Name </th>
                                                <th>Fees Code</th>
                                                <th>Amount</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover">{{$row->name}}</a>

                                         
                                                </td>
                                                <td class="mailbox-name">
                                                    {{$row->code}} </td>
                                                    <td class="mailbox-name">
                                                    {{$row->amount}} </td>
                                                <td class="mailbox-date pull-right white-space-nowrap">
                                                   
                                                <a data-placement="left" href="{{url('master/feediscount/assign/')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Assign / View Student">
                                                        <i class="fa fa-tag"></i>
                                                    </a>
                                                <a data-placement="left" href="{{url('master/feediscount?uid=')}}{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a data-placement="left" href="{{url('master/feediscount?delid=')}}{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table><!-- /.table -->



                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->

                </div>
                <div class="row">
                    <!-- left column -->

                    <!-- right column -->
                    <div class="col-md-12">

                    </div>
                    <!--/.col (right) -->
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <script>
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