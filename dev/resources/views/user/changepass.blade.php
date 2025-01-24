@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    @include('admin.include.header')
    @include('admin.include.sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-key"></i> Change Password<small></small> </h1>
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
                <div class="col-md-12">
                    <div class="box box-primary">
                        <br />
                        <form action="" id="passwordform" name="passwordform" method="post" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

                           @csrf
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Password<span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input name="current_pass" required="required" class="form-control col-md-7 col-xs-12" type="password" value="">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Password<span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input required="required" class="form-control col-md-7 col-xs-12" name="new_pass" placeholder="" type="password" value="">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Confirm Password<span class="required"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="confirm_pass" name="confirm_pass" placeholder="" type="password" value="" class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger">@error('confirm_pass'){{$message}}@enderror</span>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-info">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.include.footer')