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
                    <span id="message"></span>
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Notice List</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <a href="{{url('admin/notice/create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>

                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">notice List</div>
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
                                                    <th>Title</th>
                                                    <th>StartDate</th>
                                                    <th>ShortDesc</th>
                                                    <th>Type</th>
                                                    <th>Position</th>
                                                    <th class="text-right">
                                                        Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($list as $row)
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row->title ?></td>
                                                    <td><?= $row->start_date ?></td>
                                                    <td><?= $row->short_description ?></td>
                                                   
                                                   <td><?php if($row->news=='1'){echo 'News';} 
                                                    if($row->notice=='1'){echo ', Notice';} 
                                                    if($row->blog=='1'){echo ', Blog';} 
                                                    if($row->syllabus=='1'){echo ', Syllabus';} 
                                                    if($row->privatejob=='1'){echo ', Privatejob';} 
                                                    if($row->govtjob=='1'){echo ', Govtjob';} 
                                                    if($row->importantlinks=='1'){echo ', Importantlink';} 
                                                    if($row->testimonials=='1'){echo ', Testimonial';} 
                                                    if($row->news=='apprenticeship'){echo ', Apprenticeship';}  ?></td>
                                                      <td>
                                                          @if($can_edit>0)
                                                          <input type="number" value="{{$row->position}}" data-id="{{$row->id}}" class="position" min="0" style="width:70px;">
                                                        @endif
                                                        </td>
                                                    <td class="mailbox-date pull-right">
                                                        @if($can_edit>0)
                                                        <a data-placement="left" href="notice/create?id=<?=$row->id?>&type=edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @endif
                                                        @if($can_delete>0)
                                                        <a data-placement="left" href="notice?id=<?=$row->id?>&type=delete" class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="return confirm('Delete Confirm?');" data-original-title="Delete">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                        @endif
                                                    </td>
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
        <script>
             $('.position').on('change',function(){
               let id=$(this).attr('data-id');
                let position=$(this).val();
                let table='notice_tb';
                $.ajax({
                        type: "GET",
                        url: "{{url('admin/position')}}",
                        data: {id:id,position:position,table:table},
                        success: function(data) {
                           $('#message').html(data);
                        },
                         
                    });
            });
        </script>
        @include('admin.include.footer');