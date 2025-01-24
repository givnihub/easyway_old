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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Video Gallery List</h3>
                          
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <form id="form1" action=""  method="post" enctype="multipart/form-data">
                                    @csrf   
                                    <input type="hidden" value="{{$res->id}}" name="updateid">
                                    <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Video Title</label><small class="req"> *</small>
                                                <input id="title" name="title" placeholder="" required type="text" class="form-control" value="<?= $res->title; ?>" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Video</label><small class="req"> *</small>
                                                <input id="video_id" name="video_id" placeholder="Enter youtube video id" required type="text" class="form-control" value="<?= $res->video_id; ?>" />
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <button type="submit" class="btn btn-primary" style="margin: 5px;">Submit</button>
                                            <span class="text-danger"></span>
                                        </div>

                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class>
                                        <div class="mailbox-controls">
                                            <div class="pull-right">
                                            </div><!-- /.pull-right -->
                                        </div>
                                        <div class="mailbox-messages">
                                            <div class="download_label"> Gallery List</div>
                                            <table class="table table-striped table-bordered table-hover example">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Video Id</th>
                                                        <th>Created Date</th>
                                                        <th class="text-right no-print">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($list as $row)
                                                    <tr id="12">

                                                        <td class="mailbox-name">
                                                            <a href="#"><?= $row->title ?></a>


                                                        </td>
                                                        <td class="mailbox-name"> {{$row->video_id}}</a>
                                                        </td>
                                                        <td class="mailbox-name"> {{$row->cdate}}</a>
                                                        </td>
                                                        <td class="mailbox-date pull-right no-print">
                                                            <a data-placement="left" href="{{url('admin/video-gallery')}}?uid=<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a data-placement="left" href="{{url('admin/video-gallery')}}?delid=<?= $row->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table><!-- /.table -->
                                        </div><!-- /.mail-box-messages -->
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('admin.include.footer');