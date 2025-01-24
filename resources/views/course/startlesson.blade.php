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
                            <div class="box-body text-center">
                                <label for="exampleInputFile">
                                    <h3>CONTENTS FOR {{strtoupper($list->title)}}</h3>
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
    <div class="modal fade" id="mediaModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">

                <div class="modal-body modal-media-body">
                    <div class="show_video"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script>
        $(document).on('click', '.youtubevideo', function(event) {
            $("#mediaModal").modal('toggle', $(this));
            let video_id = $(this).attr("data-video_id");
            $('.show_video').html(`<iframe width="100%" height="750" class="videos"
                    src="https://www.youtube.com/embed/${video_id}?modestbranding=1&autoplay=0&mute=0&rel=0&enablejsapi=1&showinfo=0&loop=1&controls=1"
                     frameborder="0" title=" YouTube video player">
                </iframe>
                
                <div class="overlay--fullscreen"></div>
                <div class="overlay--bottom"></div>
                   <div class="overlay--youtube"></div>
                `);

        });
        $('.closeModal').click(function() {
            $('.show_video').html('');
            $("#mediaModal").modal('toggle');
        });
        $(document).ready(function() {

            let folderid = "0";
            let coursid = "{{$list->id}}";
            let onload = 'onload';
            let viewtype = "paid";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
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
            let viewtype = "paid";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
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
            let viewtype = "paid";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
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
            let viewtype = "paid";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
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

    @include('admin.include.footer');