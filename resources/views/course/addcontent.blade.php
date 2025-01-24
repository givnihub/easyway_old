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
                    <div class="col-lg-4 col-md-6 col-sm-12 uploadsticky">
                        <div class="box box-primary">
                            <div class="box-body text-center">
                                <label for="exampleInputFile">Contents</label>
                                <br>
                                <?php if ($folder[0]->id == '') {
                                    echo "<h3>       You haven't uploaded any content yet.
                                        Select the content from the right panel to start adding here</h3>";
                                } ?>

                                <div>
                                    <a href="{{url('admin/viewcontents')}}/{{$list[0]->id}}" class="btn btn-success">View Contents And Folders</a>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="box box-primary">
                            <div class="box-body text-center">
                                <label for="exampleInputFile">Import Contents</label>
                                <br>


                                <div>

                                    <a href="{{url('admin/importcontents')}}/{{$list[0]->id}}" class="btn btn-success">Import Contents</a>

                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="box box-primary">
                            <div class="box-body text-center">
                                <label for="exampleInputFile">Add Demo Video</label>
                                <br>


                                <div>

                                    <a href="{{url('admin/demovideo')}}/{{$list[0]->id}}" class="btn btn-success">Add Demo Video</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12">
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
                                <h3 class="box-title titlefix"><i class="fa fa-gear"></i> Create Folder For
                                    <strong>{{$list[0]->title}}</strong></h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <form role="form" id="schsetting_form" action="{{url('admin/createfolder')}}" class="" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-2">Create Folder<small class="req">
                                                        *</small></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="folder" value="{{$ress->folders}}" name="folder"> <span class="text-danger"></span>
                                                    <input type="hidden" name="folderid" value="{{$ress->id}}">
                                                    <input type="hidden" name="id" id="course_id" value="{{$list[0]->id}}">
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary submit_schsetting pull-right edit_setting" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                                    Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="settinghr"></div>
                                            <h4 class="session-head">Sub Folders</h4>

                                        </div>
                                        <!--./col-md-12-->
                                        <form role="form" method="post" id="" action="{{url('admin/subfolder')}}" class="" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{$list[0]->id}}">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Parent<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <select name="parent_folder_id" id="parent_folder_id" class="form-control" value="" required>
                                                            <option value="">Select Folder</option>
                                                            @foreach($folder as $row2)
                                                            <option value="{{$row2->folder_id}}" style="text-transform: uppercase;">{{$row2->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $row2->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}">
                                                                &nbsp;&nbsp;{{$subFolders->folders}}</option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Child<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="folder_id" id="folder_id" class="form-control" value="" placeholder="Enter your child folder name" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary submit_schsetting pull-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                                    Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--./row-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="settinghr"></div>
                                            <h4 class="session-head">Add Video</h4>
                                            <span id="message"></span>
                                        </div>
                                        <!--./col-md-12-->
                                        <form role="form" id="schsetting_form" action="#" class="" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Folder<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="vid" value="{{$video->id}}" id="vid">
                                                        <select type="text" name="video_folder_id" id="video_folder_id" class="form-control" value="" required>
                                                            <option value="">Select Folder</option>
                                                            @foreach($folder as $row2)
                                                            <option value="{{$row2->folder_id}}" style="text-transform: uppercase;" @if($video->folder_id==$row2->folder_id) selected @endif>{{$row2->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $row2->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($video->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;{{$subFolders->folders}}</option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($video->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($video->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($video->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($video->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Title<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="title" id="title" class="form-control" value="{{$video->title}}" placeholder="Enter video title" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Video<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="video_id" id="video_id" class="form-control" value="{{$video->video_id}}" placeholder="Enter youtube id (Ex - J3Q-QQfUkOY)" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Desc.<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <textarea type="text" name="description" id="description" class="form-control" value="" placeholder="Enter description" required>{{$video->description}}</textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Is Live.<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <select type="text" name="is_live" id="is_live" class="form-control"  required>
                                                        <option value="no" @if($video->is_live=='no') selected @endif>No</option>
                                                        <option value="yes" @if($video->is_live=='yes') selected @endif>Yes</option>

                                                        </select>
                                                        
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Live Date</label>
                                                    <div class="col-sm-10">
                                                     <input type="datetime-local" value="{{$video->live_date}}" name="liveDate" id="liveDate" class="form-control" >


                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="button" class="btn btn-primary submit_schsetting pull-right add_video" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                                    Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--./row-->
                                    <div class="row">
                                        <div id="message"></div>
                                        <div class="col-md-12">
                                            <div class="settinghr"></div>
                                            <h4 class="session-head">Add Documents</h4>
                                        </div>
                                        <!--./col-md-12-->
                                        <form role="form" id="add_documents" action="{{url('admin/adddocument')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{$list[0]->id}}">
                                            <input type="hidden" name="docid" value="{{$doc->id}}">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Folder<small class="req">
                                                            *</small></label>

                                                    <div class="col-sm-10">
  
                                                        <select type="text" name="folder_id" id="folder_id" class="form-control" value="" required>
                                                            <option value="">Select Folder</option>
                                                            @foreach($folder as $row2)
                                                            
                                                            <option value="{{$row2->folder_id}}" style="text-transform: uppercase;" @if($doc->folder_id==$row2->folder_id) selected @endif>{{$row2->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $row2->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($doc->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;{{$subFolders->folders}}</option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($doc->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($doc->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($doc->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            <?php $subFolder = DB::select("select * from folders where parent_folder_id=" . $subFolders->folder_id); ?>
                                                            @foreach($subFolder as $subFolders)
                                                            <option value="{{$subFolders->folder_id}}" @if($doc->folder_id==$subFolders->folder_id) selected @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$subFolders->folders}}
                                                            </option>
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Name<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="doc_name" class="form-control" value="{{$doc->doc_name}}" required>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Doc.<small class="req"> *</small></label>
                                                    <div class="col-sm-10">
                                                        <input autofocus="" id="document" @if($doc->id=='') name="document[]" multiple @else name="document" @endif
                                                        placeholder="" type="file" class="filestyle form-control"
                                                        /><span class="text-danger"></span>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-2">Desc.<small class="req">
                                                            *</small></label>
                                                    <div class="col-sm-10">
                                                        <textarea type="text" name="description" class="form-control">{{$doc->description}}</textarea>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="button" id="submit_doc" class="btn btn-primary submit_schsetting pull-right edit_setting" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                                                    Save</button>
                                            </div>
                                        </form>
                                    </div>
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
                    <h4 class="modal-title modal-media-title" id="myModalLabel">Import Contents</h4>
                </div>
                <div class="modal-body modal-media-body pupscroll">
                    <input type="text" name="courseid" value="">
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary add_media">Add</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.importcontent', function(event) {
                $("#mediaModal").modal('toggle', $(this));
                let coursid = $(this).attr("data-courseid");

            });
            $(document).on('click', '.add_video', function(e) {
                let course_id = $('#course_id').val();
                let folder_id = $('#video_folder_id').val();
                let video_id = $('#video_id').val();
                let title = $('#title').val();
                let description = $('#description').val();
                let is_live = $('#is_live').val();
                let vid = $('#vid').val();
                let liveDate = $('#liveDate').val();
                if (video_id == '' && folder_id == '' && title == '') {
                    $('#message').html(`<div class="alert alert-warning" role="alert">
  Title,Folder and videoid is required.
</div>`);
                }
                $.ajax({
                    url: "{{url('ajax/addvideo')}}",
                    type: "GET",
                    data: {
                        course_id: course_id,
                        folder_id: folder_id,
                        video_id: video_id,
                        title: title,
                        description: description,
                        is_live:is_live,
                        vid: vid,
                        liveDate: liveDate
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#video_id').val('');
                        $('#title').val('');
                        $('#description').val('');
                        $('#message').html(res);
                    }
                });
            });
            //add documents
            $(document).on('click', '#submit_doc', function(event) {
            var form_data = new FormData(document.getElementById("add_documents"));
      
            $.ajax({
                url: "{{url('admin/adddocument')}}",
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#message").html('<div class="alert alert-warning" role="alert">Processing.Please wait....</div>').fadeOut();
                },
                success: function(data) {
                    $('#message').html(`<div class="alert alert-success" role="alert">${data}</div>`).fadeIn();

                },
                error: function(e) {
                    $("#message").html(e).fadeIn();
                }
            });

        });
        });
    </script>
    @include('admin.include.footer');