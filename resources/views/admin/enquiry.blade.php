@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?=@session('success')?>.
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?=@session('error')?>.
                    </div>
                    @endif
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Enquiry List</h3>
                                <div class="box-tools pull-right">
                                  

                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">Event List</div>
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                                <tr>
                                                <th>S.No</th>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th>Subject</th>
                                                            <th>Enquiry Date</th>
                                                            <th>Desc</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($list as $row)
                                                <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$row->name}}</td>
                                                            <td>{{$row->contact}}</td>
                                                            <td>{{$row->email}}</td>
                                                            <td>{{$row->subject}}</td>
                                                            <td>{{$row->cdate}}</td>
                                                            <td>{{$row->description}}</td>

                                                        </tr>
                                                @endforeach
                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <!--/.col (right) -->
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('admin.include.footer');