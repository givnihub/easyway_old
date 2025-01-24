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
                                <h3 class="box-title titlefix">Live Videos List</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <a href="{{url('admin/page/create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add</a>

                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">Page List</div>
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
                                                    <th>CourseId</th>
                                                    <th>Title</th>
                                                    <th>Video</th>
                                                    <th>live Date</th>

                                                    <th class="text-right">
                                                        Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($list as $row)
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><a href="{{url('admin/viewcontents')}}/{{$row->course_id}}">{{$row->course_id}}</a></td>
                                                    <td><?= $row->title ?></td>
                                                    <td>
                                                    <button class="btn btn-primary youtubevideo" data-video_id="{{$row->video_id}}">View Video</button>    
                                                    </td>
                                                    <td><?= date('d-m-Y h:i:s A',strtotime($row->live_date)) ?></td>
                                                    <td><a href="{{url('admin/addcontent')}}/{{$row->course_id}}?videoid={{$row->id}}"><i class="fa fa-pencil"></i></a></td>
                                                    
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
  <!-- Modal -->
  <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog pup100" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title modal-media-title" id="myModalLabel">Play Video</h4>
                </div>
                <div class="modal-body modal-media-body pupscroll">
                    <div class="show_video"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
        <script>
              $(document).on('click', '.youtubevideo', function(event) {
            $("#mediaModal").modal('toggle', $(this));
            let video_id = $(this).attr("data-video_id");
            $('.show_video').html(`<iframe width="100%" height="800"
                    src="https://www.youtube.com/embed/${video_id}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1"
                     frameborder="0" title=" YouTube video player">
                </iframe>
                
                <div class="overlay--fullscreen"></div>
                `);

        });
        </script>
        @include('admin.include.footer');