@include('admin.include.head');
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
                                <h3 class="box-title titlefix">S3 Image Upload</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <a href="{{url('master/chapter/create')}}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-plus"></i> Add</a>

                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">S3 Image Upload</div>
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages">
                                    <form method="post" action="" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm">
                                                <input class="form-control iframe-btn" placeholder="Select Image"
                                                    type="file" name="s3image" id="image" value="" >
                                                    @csrf
                                                <span class="input-group-btn">
                                                    <a href="#" class="btn cfees feture_image_btn" id="feture_image"
                                                        data-toggle="tooltip" data-title="Select Image" type="button"><i
                                                            class="fa fa-folder-open"></i></a>
                                              

                                                </span>
                                            </div>
                                         <br/>
                                        <button type="submit">Submit</button>
                                    </form>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        @include('admin.include.footer');