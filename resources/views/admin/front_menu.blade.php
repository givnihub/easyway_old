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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS </h1>
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
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Menu</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form id="form1" action="{{url('admin/frontmenu')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                    <div class="box-body">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{$res->id}}">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Menu</label> <small class="req">*</small>
                                            <input autofocus="" id="menu" name="menu" placeholder="" value="{{$res->menu}}" type="text" class="form-control" value="" />
                                            <span class="text-danger"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <textarea class="form-control" id="description" name="description"  placeholder="" rows="3" placeholder="">{{$res->description}}</textarea>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div><!-- /.box-body -->
                                    @if($can_add>0)
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-info pull-right">Save</button>
                                    </div>
                                    @endif
                                </form>
                            </div>

                        </div>
                        <!--/.col (right) -->
                        <!-- left column -->
                        <div class="col-md-8">
                            <!-- general form elements -->
                            <div class="box box-primary" id="holist">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">Menu List</h3>

                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="mailbox-controls">
                                        <div class="pull-right">
                                        </div><!-- /.pull-right -->
                                    </div>
                                    <div class="table-responsive mailbox-messages">
                                        <div class="download_label">Menu List</div>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>

                                                    <th class="text-right no-print">
                                                        Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($list as $row)
                                                <tr id="1">

                                                    <td class="mailbox-name">
                                                        <a href="#" data-toggle="popover" class="detail_popover">{{$row->menu}}</a>

                                                        <div class="fee_detail_popover" style="display: none">
                                                            <p class="text text-info">{{$row->description}}</p>
                                                        </div>
                                                    </td>
                                                    <td class="mailbox-date pull-right no-print">
                                                  @if($can_edit>0)
                                                    <a href="{{url('admin/frontmenu')}}?uid={{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add Menu Item">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @endif
                                                        @if($can_add>0)
                                                        <a href="{{url('admin/addmenuitem')}}/{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add Menu Item">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                        @endif

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

                    </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

      
        @include('admin.include.footer')