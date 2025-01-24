@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-gears"></i> Add Contents</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
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
                                <h3 class="box-title titlefix"><i class="fa fa-gear"></i> Add demo videos for
                                    <strong>{{$list[0]->title}}</strong></h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="">
                                <div class="box-body">


                                    <!--./row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="settinghr"></div>
                                            <h4 class="session-head">Add Video</h4>
                                            <span id="message"></span>
                                        </div>
                                        <!--./col-md-12-->
                                        <form role="form" action="" class="" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <input name="course_id" type="hidden" value="{{Request::segment('3')}}">
                                                <input type="hidden" name="uid" value="{{$res->id}}">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Title<small class="req"> *</small></label>
                                                        <input type="text" name="title" id="title" class="form-control" value="{{$res->title}}" placeholder="Enter video title" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label>Video<small class="req"> *</small></label>
                                                        <input type="text" name="video_id" id="video_id" class="form-control" value="{{$res->video_id}}" placeholder="Enter youtube id (Ex - J3Q-QQfUkOY)" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class=" row">
                                        <div class="col-md-12">


                                            <div class="form-group">
                                                <label>Description<small class="req"> *</small></label>
                                                <textarea id="editor1" placeholder="" name="description" type="text" class="form-control" required>{{$res->description}}</textarea>
                                                <span class="text-danger"></span>
                                            </div>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary submit_schsetting pull-right add_video" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                        Save</button>
                                </div>
                                </form>

                            </div>
                            <!--./row-->
                            <section class="content">


                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Demo video list</h3>
                                            <div class="table-responsive no-padding">
                                                <div class="download_label">Approve Leave Request</div>
                                                <table class="table table-striped table-bordered table-hover example">
                                                    <thead>
                                                        <th>Id</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Video</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th class="text-right no-print">Action</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($videos as $run)
                                                        <tr>
                                                            <td>{{$run->id}}</td>
                                                            <td>{{$run->title}}</td>
                                                            <td>{{substr($run->description,0,50)}}</td>
                                                            <td> <button class="btn btn-primary youtubevideo" data-video_id="{{$run->video_id}}">View Video</button></td>
                                                            <td>{{date('d-m-Y',strtotime($run->cdate))}}</td>
                                                            <td><a href="{{url('admin/demovideo/')}}/{{$run->course_id}}?id={{$run->id}}&status={{$run->status}}"><small class='label label-<?php if ($run->status == '1') {
                                                                                                                                                                                                echo 'success';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo 'warning';
                                                                                                                                                                                            } ?>'><?= $run->status ? 'Published' : 'Unpublished' ?></small></span></td>

                                                            <td> <a data-placement="left" href="{{url('admin/demovideo')}}/{{$run->course_id}}?uid={{$run->id}}" role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Add Content"><i class="fa fa-pencil"></i></a>


                                                                <a href="{{url('admin/demovideo')}}/{{$run->course_id}}?delid=<?= $run->id ?>" onclick="return confirm ('Are you sure...?')" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete"><i class="fa fa-remove"></i></a></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>
                </div>
        </div>
    </div>
    </div>
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
        (function($) {
            'use strict';
            $(document).ready(function() {
                emptyDatatable('course-list', 'data');
                CKEDITOR.replace('editor1', {
                    allowedContent: true
                });
            });

        }(jQuery));
    </script>

    @include('admin.include.footer');