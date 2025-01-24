@include('admin.include.head');
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        @php
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
       
     @endphp

        <style type="text/css">
            .wrapper {
                overflow: visible;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <section class="content-header">
                <h1><i class="fa fa-gears"></i> System Settings</h1>
            </section>
            <form role="form" id="schsetting_form" action="{{url('admin/general_settings')}}" class="" method="post" enctype="multipart/form-data">
                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-lg-2 col-md-3 col-sm-12 uploadsticky">
                            <div class="box box-primary">
                                <div class="box-body text-center">
                                    <img src="{{asset('')}}<?= $res[0]->print_logo ?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
                                    <br />
                                    <br />
                                    <label for="exampleInputFile">Print logo</label>
                                    <div><input class="filestyle form-control" type='file' name='print_logo' size='20' />
                                    </div>
                                </div>

                            </div>

                            <div class="box box-primary">
                                <div class="box-body text-center">
                                    <img src="{{asset('')}}<?= $res[0]->admin_logo ?>" class="img-thumbnail" alt="" width="204" height="60">
                                    <br />
                                    <br />
                                    <label for="exampleInputFile">Admin logo</label>
                                    <div><input class="filestyle form-control" type='file' name='admin_logo' size='20' />
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body text-center">
                                    <img src="{{asset('')}}<?= $res[0]->small_logo ?>" class="" alt="Cinque Terre" width="" height="">
                                    <br />
                                    <br />
                                    <label for="exampleInputFile">Small logo</label>
                                    <div><input class="filestyle form-control" type='file' name='small_logo' size='20' />
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-12">


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
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix"><i class="fa fa-gear"></i> General Setting</h3>
                                    <div class="box-tools pull-right">

                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="">

                                    @csrf
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Title<small class="req"> *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="title" name="title" value="<?= $res[0]->title ?>"> <span class="text-danger"></span>
                                                        <input type="hidden" name="id" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Address<small class="req"> *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="address" name="address" value="<?= $res[0]->address ?>"> <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./row-->
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Phone<small class="req"> *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="phone" name="phone" value="8409938540"><span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">WhatsApp<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?= $res[0]->whatsapp ?>"><span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Email<small class="req"> *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="email" name="email" value="<?= $res[0]->email ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!--./row-->


                                        <!--./row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="settinghr"></div>
                                                <h4 class="session-head">Social Links</h4>
                                            </div>
                                            <!--./col-md-12-->


                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Facebook<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="facebook" class="form-control" value="<?= $res[0]->facebook ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Twitter<small class="req"> *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="twitter" class="form-control" value="<?= $res[0]->twitter ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Google<small class="req"> *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="google" class="form-control" value="<?= $res[0]->google ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Instagram<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="instagram" class="form-control" value="<?= $res[0]->instagram ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Linkedin<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="linkedin" class="form-control" value="<?= $res[0]->linkedin ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Youtube<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="youtube" class="form-control" value="<?= $res[0]->youtube ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!--./row-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="settinghr"></div>
                                                <h4 class="session-head">Student Admission No. Auto Generation</h4>
                                            </div>
                                            <!--./col-md-12-->


                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Admission No Prefix<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="adm_prefix" id="adm_prefix" class="form-control" value="<?= $res[0]->adm_prefix ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Admission No Digit<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <select id="adm_no_digit" name="adm_no_digit" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="1" <?php if ($res[0]->adm_no_digit == '1') {
                                                                                    echo 'selected';
                                                                                } ?>>1</option>
                                                            <option value="2" <?php if ($res[0]->adm_no_digit == '2') {
                                                                                    echo 'selected';
                                                                                } ?>>2</option>
                                                            <option value="3" <?php if ($res[0]->adm_no_digit == '3') {
                                                                                    echo 'selected';
                                                                                } ?>>3</option>
                                                            <option value="4" <?php if ($res[0]->adm_no_digit == '4') {
                                                                                    echo 'selected';
                                                                                } ?>>4</option>
                                                            <option value="5" <?php if ($res[0]->adm_no_digit == '5') {
                                                                                    echo 'selected';
                                                                                } ?>>5</option>
                                                            <option value="6" <?php if ($res[0]->adm_no_digit == '6') {
                                                                                    echo 'selected';
                                                                                } ?>>6</option>
                                                            <option value="7" <?php if ($res[0]->adm_no_digit == '7') {
                                                                                    echo 'selected';
                                                                                } ?>>7</option>
                                                            <option value="8" <?php if ($res[0]->adm_no_digit == '8') {
                                                                                    echo 'selected';
                                                                                } ?>>8</option>
                                                            <option value="9" <?php if ($res[0]->adm_no_digit == '9') {
                                                                                    echo 'selected';
                                                                                } ?>>9</option>
                                                            <option value="10" <?php if ($res[0]->adm_no_digit == '10') {
                                                                                    echo 'selected';
                                                                                } ?>>10</option>
                                                            <option value="11" <?php if ($res[0]->adm_no_digit == '11') {
                                                                                    echo 'selected';
                                                                                } ?>>11</option>
                                                            <option value="12" <?php if ($res[0]->adm_no_digit == '12') {
                                                                                    echo 'selected';
                                                                                } ?>>12</option>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-4">Admission Start From<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="adm_start_from" id="adm_start_from" class="form-control" value="<?= $res[0]->adm_start_from ?>">
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!--./row-->



                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="settinghr"></div>
                                                <h4 class="session-head">Staff ID Auto Generation</h4>
                                            </div>
                                            <!--./col-md-12-->

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4">Staff ID Prefix<small class="req">
                                                        *</small></label>
                                                <div class="col-sm-8">
                                                    <input id="staffid_prefix" value="<?= $res[0]->staffid_prefix ?>" name="staffid_prefix" placeholder="" type="text" class="form-control" />
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4">Staff No Digit<small class="req">
                                                        *</small></label>
                                                <div class="col-sm-8">
                                                    <select id="staffid_no_digit" name="staffid_no_digit" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" <?php if ($res[0]->staffid_no_digit == '1') {
                                                                                echo 'selected';
                                                                            } ?>>1</option>
                                                        <option value="2" <?php if ($res[0]->staffid_no_digit == '2') {
                                                                                echo 'selected';
                                                                            } ?>>2</option>
                                                        <option value="3" <?php if ($res[0]->staffid_no_digit == '3') {
                                                                                echo 'selected';
                                                                            } ?>>3</option>
                                                        <option value="4" <?php if ($res[0]->staffid_no_digit == '4') {
                                                                                echo 'selected';
                                                                            } ?>>4</option>
                                                        <option value="5" <?php if ($res[0]->staffid_no_digit == '5') {
                                                                                echo 'selected';
                                                                            } ?>>5</option>
                                                        <option value="6" <?php if ($res[0]->staffid_no_digit == '6') {
                                                                                echo 'selected';
                                                                            } ?>>6</option>
                                                        <option value="7" <?php if ($res[0]->staffid_no_digit == '7') {
                                                                                echo 'selected';
                                                                            } ?>>7</option>
                                                        <option value="8" <?php if ($res[0]->staffid_no_digit == '8') {
                                                                                echo 'selected';
                                                                            } ?>>8</option>
                                                        <option value="9" <?php if ($res[0]->staffid_no_digit == '9') {
                                                                                echo 'selected';
                                                                            } ?>>9</option>
                                                        <option value="10" <?php if ($res[0]->staffid_no_digit == '10') {
                                                                                echo 'selected';
                                                                            } ?>>10</option>
                                                        <option value="11" <?php if ($res[0]->staffid_no_digit == '11') {
                                                                                echo 'selected';
                                                                            } ?>>11</option>
                                                        <option value="12" <?php if ($res[0]->staffid_no_digit == '12') {
                                                                                echo 'selected';
                                                                            } ?>>12</option>
                                                    </select>
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-4">Staff ID Start From<small class="req">
                                                        *</small></label>
                                                <div class="col-sm-8">

                                                    <input id="staffid_start_from" value="<?= $res[0]->staffid_start_from ?>" name="staffid_start_from" placeholder="" type="text" class="form-control" />
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- /.box-body -->
                                @if($can_add>0)
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary submit_schsetting pull-right edit_setting" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                        Save</button>


                                </div>
                                @endif
            </form>
        </div><!-- /.box-body -->
    </div>
    </div>
    <!--/.col (left) -->
    <!-- right column -->

    </div>

    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->


    @include('admin.include.footer');