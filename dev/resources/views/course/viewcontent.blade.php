@include('admin.include.head');


<style>
    .folder_design {
        padding-bottom: 2px;
        font-size: 14px;
        border-radius: 10px;
        padding: 1px;
        border-bottom: 2px solid black;
    }

    ul {
        padding: 0px;
        margin: 0px;
    }

    #list li {
        margin: 0 0 3px;
        padding: 8px;
        list-style: none;

    }

    #refresh_doc li {
        margin: 0 0 3px;
        padding: 8px;
        list-style: none;

    }

    #refresh_video li {
        margin: 0 0 3px;
        padding: 8px;
        list-style: none;

    }

    #view_exam li {
        margin: 0 0 3px;
        padding: 8px;
        list-style: none;

    }

    .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .modal-content {
        height: auto;
        min-height: 100%;
        border-radius: 0;
    }

    .files {
        opacity: 1 !important;
        outline: 1 !important;
    }

    #add_documents {
        display: none;
    }

    #schsetting_form {
        display: none;
    }
    .blink_me {
                animation: blinker 1s linear infinite;
                color: red;
                font-weight: bold;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }
</style>

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
                    <div class="col-lg-1 col-md-6 col-sm-12">
                        <!-- general form elements -->

                    </div>
                    <div class="col-lg-10 col-md-6 col-sm-12 uploadsticky">

                        <div class="box box-primary">
                            <a href="{{url('admin/addcontent')}}/{{Request::segment('3')}}" class="btn btn-sm btn-primary" style="margin:10px;">Back To Course</a>
                            <div class="box-body text-center">
                                <label for="exampleInputFile">
                                    <h3>CONTENTS FOR {{strtoupper($list[0]->title)}}</h3>
                                </label>
                                <br>
                                <br>

                                <div id="dynamic_folder">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-12">
                        <!-- general form elements -->
                    </div>
                </div>
        </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog pup100" role="document">
            <div class="modal-content modal-media-content">

                <div class="modal-body modal-media-body">
                    <div class="show_video"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary closevideo" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->


    <script>
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
                    $("#message").html('<div class="alert alert-warning" role="alert">Processing.Please wait....</div>');
                },
                success: function(data) {
                    $('#message').html(`<div class="alert alert-success" role="alert">${data}</div>`).fadeIn();
                    let folderid = $('#folderid').val();
                    let coursid = $('#coursid').val();
                    let viewtype = "viewcontent";
                    $.ajax({
                        url: "{{url('ajax/dynamic_folder')}}",
                        type: "GET",
                        data: {
                            folderid: folderid,
                            coursid: coursid,
                            viewtype: viewtype
                        },
                        dataType: 'html',
                        success: function(res) {
                            $('#dynamic_folder').empty();
                            $('#dynamic_folder').append(res);
                        }
                    });

                },
                error: function(e) {
                    $("#message").html(e).fadeIn();
                }
            });

        });
        $(document).on('click', '.youtubevideo', function(event) {
            $("#mediaModal").modal({
                backdrop: 'static',
                keyboard: false
            }, 'toggle', $(this));
            let video_id = $(this).attr("data-video_id");

            $('.show_video').html(`<iframe width="100%" height="800"
                    src="https://www.youtube.com/embed/${video_id}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1"
                     frameborder="0" title=" YouTube video player">
                </iframe>
                <div class="overlay--fullscreen"></div>`);

        });
        $(document).on('click', '.closevideo', function(event) {
            $('.show_video').html(`<iframe width="100%" height="800"
                   src="" frameborder="0" title=" YouTube video player">
               </iframe>`);
        })
    </script>
    <script>
        $(document).ready(function() {

            let folderid = "0";
            let coursid = "{{$list[0]->id}}";
            let onload = 'onload';
            let viewtype = "viewcontent";
            $.ajax({
                url: "{{url('ajax/dynamic_folder')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    onload: onload,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
    </script>
    <script>
        function ajax_folder(status, id, type) {

            let folderid = $('#folderid').val();
            let coursid = $('#coursid').val();
            let viewtype = "viewcontent";
            $.ajax({
                url: "{{url('ajax/dynamic_folder')}}",
                type: "GET",
                data: {
                    id: id,
                    status: status,
                    folderid: folderid,
                    coursid: coursid,
                    type: type,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        }

        $(document).on('click', '.go_back', function(e) {
            let folderid = $(this).attr("data-id");
            let coursid = $('#coursid').val();
            let onload = 'onload';
            let viewtype = "viewcontent";
            $.ajax({
                url: "{{url('ajax/dynamic_folder')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    onload: onload,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
        $(document).on('click', '.view_folder', function(e) {
            let folderid = $(this).attr("data-id");
            let coursid = $('#coursid').val();
            let viewtype = "viewcontent";
            $.ajax({
                url: "{{url('ajax/dynamic_folder')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '#showHideVideo', function(e) {
            $('#schsetting_form').slideToggle()
        });
        $(document).on('click', '#showHideDocument', function(e) {
            $('#add_documents').slideToggle()
        });
        $(document).on('click', '.add_video', function(e) {
            let course_id = $('#coursid').val();
            let folder_id = $('#video_folder_id').val();
            let video_id = $('#video_id').val();
            let title = $('#title').val();
            let description = $('#description').val();
            let vid = $('#vid').val();
            let is_live = $('#is_live').val();
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
                    vid: vid,
                    is_live:is_live,
                    liveDate:liveDate
                },
                dataType: 'html',
                success: function(res) {
                    $('#video_id').val('');
                    $('#title').val('');
                    $('#description').val('');
                    $('#message').html(res);

                    let folderid = $('#folderid').val();
                    let coursid = $('#coursid').val();
                    let viewtype = "viewcontent";
                    $.ajax({
                        url: "{{url('ajax/dynamic_folder')}}",
                        type: "GET",
                        data: {
                            folderid: folderid,
                            coursid: coursid,
                            viewtype: viewtype
                        },
                        dataType: 'html',
                        success: function(res) {
                            $('#dynamic_folder').empty();
                            $('#dynamic_folder').append(res);
                        }
                    });

                }
            });
        });
    </script>

    @include('admin.include.footer');