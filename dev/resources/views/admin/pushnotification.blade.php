@include('admin.include.head');
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');


        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Tutorial </h1>
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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Send Pushnotification</h3>
                              
                            
                            </div><!-- /.box-header -->
                            <div class="box-body">
                             <form method="post" action="{{url('pushnotificaiotn')}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                        <input type="text" name="title" placeholder="Notification Title" class="form-control">
                                        </div>
                                        <div class="col-lg-6">
                                        <input type="text" name="title" placeholder="Notification Title" class="form-control">
                                        </div>
                                       
                                    </div>
                                </div>
                           
                             </form>
                              
                                
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('admin.include.footer');