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
        <div class="content-wrapper" style="min-height: 946px;">
            <section class="content-header">
                <h1><i class="fa fa-sitemap"></i> Human Resource 
                @if($can_add>0)
                <small class="pull-right">
                        <a href="{{url('admin/staff/create')}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add Staff </a>
                    </small>
                    @endif
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                                <div class="box-tools pull-right">
                                    @if($can_add>0)
                                    <small class="pull-right">
                                        <a href="{{url('admin/staff/create')}}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus"></i> Add Staff </a> </small>
                                            @endif
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <form role="form" action="{{url('admin/staff')}}" method="post" class="">
                                               @csrf
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Role</label><small class="req"> *</small>
                                                        <select name="role" class="form-control">
                                                            <option value="">Select</option>
                                                           @foreach($role as $run)
                                                           <option value="<?=$run->id?>"><?=$run->name?></option>
                                                           @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <form role="form" action="{{url('admin/staff')}}" method="post" class="">

                                                @csrf
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Search By Keyword</label>
                                                        <input type="text" name="search_text" class="form-control" value="" placeholder="Search By Staff ID, Name, Role etc...">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <button type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-header ptbnull"></div>
                            <div class="nav-tabs-custom border0">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Card View</a></li>
                                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> List View</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="download_label">Staff Search</div>
                                    <div class="tab-pane table-responsive no-padding" id="tab_2">
                                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Staff ID</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Mobile Number</th>
                                                    <th>Commision</th>
                                                    <th>Discount</th>

                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($list as $row)

                                           
                                                <tr>
                                                    <td><?=$row->employee_id?></td>
                                                    <td>
                                                        <a href="{{url('admin/staff/profile?id=')}}<?=$row->id?>"><?=$row->name?> </a>
                                                    </td>

                                                    <td><?php $res=DB::select('select name from roles where id='.$row->role); echo $res[0]->name?>
                                                    
                                                
                                                </td>
                                                    <td><?php $res=DB::select('select department from department where id='.$row->department); echo $res[0]->department?></td>

                                                 
<td>
   <?php 
   if($row->designation!=''){

 
     $res=DB::table("staff_designation")->where("id",$row->designation)->first();
     echo $res->designation;
   }
   
     
  ?>
    
</td>
                                                    <td><?=$row->contact_no?></td>
                                                    <td><?=$row->commision?></td>
                                                    <td>

                                                    <?=$row->discount?></td>
                                                    <td class="pull-right">
                                                        @if($can_view>0)
                                                        <a data-placement="left" href="{{url('admin/staff/profile?id=')}}<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Show">
                                                            <i class="fa fa-reorder"></i>
                                                        </a>
                                                        @endif
                                                        @if($can_delete>0)
                                                        <a data-placement="left" href="{{url('admin/staff/create/?uid=')}}<?=$row->id?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                                @endforeach
                                                
                                         
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="mediarow">
                                            <div class="row">
                                                @foreach($list as $row)
                                                <!--./col-md-3-->
                                                <div class="col-lg-3 col-md-4 col-sm-6 img_div_modal">
                                                    <div class="staffinfo-box">
                                                        <div class="staffleft-box">
                                                            <img src="{{asset('')}}<?=$row->image?>" />
                                                        </div>
                                                        <div class="staffleft-content">
                                                            <h5><span data-toggle="tooltip" title="Name" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?=$row->name?></span></h5>
                                                            <p>
                                                                <font data-toggle="tooltip" title="Employee Id" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?=$row->employee_id?></font>
                                                            </p>
                                                            <p>
                                                                <font data-toggle="tooltip" title="Contact Number" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?=$row->contact_no?></font>
                                                            </p>
                                                            <p>
                                                                <font data-toggle="tooltip" title="Location" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"></font>
                                                                <font data-toggle="tooltip" title="Department" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php $res=DB::select('select department from department where id='.$row->department); echo $res[0]->department?>
 </font>
                                                            </p>
                                                            <p class="staffsub"><span data-toggle="tooltip" title="Role" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
  <?php 
   if($row->designation!=''){

 
     $res=DB::table("staff_designation")->where("id",$row->designation)->first();
     echo $res->designation;
   }
   
     
  ?>
                                                </span>  </p>
                                                        </div>
                                                        <div class="overlay3">
                                                            <div class="stafficons">
@if($can_view>0)
                                                                <a title="Show" href="{{url('admin/staff/profile?id=')}}<?=$row->id?>"><i class="fa fa-navicon"></i></a>
                                                                @endif
                                                                @if($can_edit>0)
                                                                <a title="Edit" href="{{url('admin/staff/create?uid=')}}<?=$row->id?>"><i class=" fa fa-pencil"></i></a>
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                             @endforeach

                                            </div>
                                            <!--./col-md-3-->
                                        </div>
                                        <!--./row-->
                                    </div>
                                    <!--./mediarow-->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>

    @include('admin.include.footer');