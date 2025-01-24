@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">

    @include('admin.include.head');

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
                    <i class="fa fa-building-o"></i> Hostel </h1>
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
                                <h3 class="box-title">Add Hostel Room</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form id="form1" action="{{url('admin/hostelroom')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <input type="hidden" name="uid" value="<?=$res[0]->id?>">   
                            <div class="box-body">
                                 @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Room Number / Name</label><small class="req"> *</small>
                                        <input autofocus="" id="amount" name="room_no" placeholder="" type="text" class="form-control" value="<?=$res[0]->room_no?>" required/>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Hostel</label><small class="req"> *</small>
                                        <select id="hostel_id" name="hostel_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($hostel as $run)
                                            <option value="<?=$run->id?>" <?php if($run->id==$res[0]->hostel_id){echo 'selected';}?>><?=$run->hostel_name?></option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Room Type</label><small class="req"> *</small>
                                        <select id="room_type_id" name="room_type_id" class="form-control" required>
                                            <option value="">Select</option>
                                                @foreach($room as $type)
                                            <option value="<?=$type->id?>" <?php if($type->id==$res[0]->room_type_id){echo 'selected';}?>><?=$type->room_type?></option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Number Of Bed</label><small class="req"> *</small>
                                        <input id="amount" name="no_of_bed" placeholder="" type="number" class="form-control" value="<?=$res[0]->no_of_bed?>" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cost Per Bed</label><small class="req"> *</small>
                                        <input id="amount" name="cost_per_bed" placeholder="" type="any" class="form-control" value="<?=$res[0]->cost_per_bed?>" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="" rows="3" placeholder=""><?=$res[0]->description?></textarea>
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
                        <div class="box box-primary" id="hroom">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Hostel Room List</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages table-responsive">
                                    <div class="download_label">Hostel Room List</div>
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th>Room Number / Name</th>
                                                <th>Hostel</th>
                                                <th>Room Type</th>
                                                <th>Number Of Bed</th>
                                                <th>Cost Per Bed</th>
                                                <th class="text-right no-print">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                           
                                          @foreach($list as $row)
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?=$row->room_no?></a>
                                                    <div class="fee_detail_popover" style="display: none">
                                                        <p class="text text-danger"><?=$row->description?></p>
                                                    </div>
                                                </td>
                                                <td class="mailbox-name"> <?php $rn=DB::select('select hostel_name from hostel where id='.$row->hostel_id); echo $rn[0]->hostel_name;?></td>
                                                <td class="mailbox-name"> <?php $rn=DB::select('select room_type from room_types where id='.$row->room_type_id); echo $rn[0]->room_type;?></td>
                                                <td class="mailbox-name"> <?=$row->no_of_bed?></td>
                                                <td class="mailbox-name"> ₹<?=$row->cost_per_bed?></td>
                                                <td class="mailbox-date pull-right no-print">
                                                    @if($can_edit>0)
                                                    <a data-placement="left" href="{{url('admin/hostelroom?uid=')}}<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    @endif
                                                    @if($can_delete>0)
                                                    <a data-placement="left" href="{{url('admin/hostelroom?delid=')}}<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                        <i class="fa fa-remove"></i>
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
                    <!-- right column -->

                </div>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <!--/.col (right) -->
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->



        @include('admin.include.footer');