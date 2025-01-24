@include('admin.include.head');


<style>
    .w-5 {
        display: none;
    }
</style>

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header');
        @include('admin.include.sidebar');

        <style type="text/css">
            .files {
                /* outline: 2px dashed #424242;
         outline-offset: -10px;*/
                -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                transition: outline-offset .15s ease-in-out, background-color .15s linear;
                padding: 0px 0px 0px 0;
                text-align: center !important;
                margin: 0;
                font-size: 1.2em;
                width: 100% !important;
            }

            .files label {
                display: block;
            }

            .files input:focus {
                /*outline: 2px dashed #92b0b3;  outline-offset: -10px;*/
                -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
                transition: outline-offset .15s ease-in-out, background-color .15s linear;
                border: 1px solid #92b0b3;
            }

            .files {
                position: relative;
                background-color: rgb(245, 245, 245);
                border: 1px solid rgba(0, 0, 0, 0.06);
            }

            .files:after {
                pointer-events: none;
                position: absolute;
                top: 14px;
                left: 20px;
                color: #767676;
                font-size: 36px;
                font-family: 'FontAwesome';
                /*width: 50px;
        right: 0;
        height: 50px;*/
                content: "\f0ee";
                /* background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);*/
                display: block;
                margin: 0 auto;
                background-size: 100%;
                background-repeat: no-repeat;
            }

            .color input {
                background-color: #f1f1f1;
            }

            .files:before {
                position: absolute;
                bottom: 27px;
                left: 0;
                pointer-events: none;
                width: 100%;
                right: 0;
                /* height: 90px; */
                content: "Choose a file or drag it here.";
                display: block;
                margin: 0 auto;
                color: #767676;

                text-align: center;
                transition: .3s;
            }

            .files:hover:before {
                color: #faa21c;
            }

            .files input[type=file] {
                opacity: 0;
                cursor: pointer;
                height: 70px;
            }

            .modal-lg {
                width: 1100px;
            }

            @media (max-width:767px) {
                .modal-lg {
                    width: 100%;
                }
            }

            .w-5 {
                display: none;
            }
        </style>
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
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Media Manager</h3>
                            </div>
                            <div class="box-body">
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

                                    <form method="post" action="media" id="fileupload" enctype="multipart/form-data">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="mailbox-controls">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Upload Your File</label>
                                                    <div class="files">
                                                        <input type="file" name="files[]" class="form-control" id="file" multiple="">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!--./col-md-6-->
                                        <div class="col-md-6 col-sm-6">

                                            <div class="form-group">
                                                <label for="video_url">Upload Youtube Video</label><small class="req">
                                                    *</small>
                                                <input type="text" class="form-control" name="video_url" id="video_url" placeholder="URL">
                                                <span class="text text-danger file_error"></span>
                                            </div>
                                            <button type="submit" class="btn btn-info pull-right video_submit" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading...">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--./box-body-->
                    </div>
                </div>
                <!--./col-md-12-->
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary" id="holist">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <form>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="name" class="control-label">Search By File Name</label>
                                                <input type="text" value='' class="form-control search_text" id="" placeholder="Enter Keyword...">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="name" class="control-label">Filter By File Type</label>
                                                <select class="form-control file_type">
                                                    <option value="">Select</option>
                                                    <option value="Image">Image</option>

                                                    <option value="Video">Video</option>

                                                    <option value="Text">Text</option>

                                                    <option value="Zip">Zip</option>

                                                    <option value="Rar">Rar</option>

                                                    <option value="Pdf">Pdf</option>

                                                    <option value="Word">Word</option>

                                                    <option value="Excel">Excel</option>

                                                    <option value="Other">Other</option>

                                                </select>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="mediarow">

                                    </div>
                                    <div class="row" id="media_div">


                                    </div>

                                </div>

                            </div>

                        </div><!-- /.box-body -->
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
        <script type="text/javascript">
            $(document).ready(function() {
                load(1);
                // $(document).on("click", ".pagination li a", function(event) {
                //     event.preventDefault();
                //     var page = $(this).data("ci-pagination-page");
                //     load(page);
                // });
                $(".search_text").keyup(function() {
                    load(1);
                });
                $(".file_type").change(function() {
                    load(1);
                });



                $("#confirm-delete").modal({
                    backdrop: false,
                    show: false

                });
                $('#confirm-delete').on('show.bs.modal', function(e) {

                    var record_id = $(e.relatedTarget).data('record_id');
                    $('#record_id').val(0).val(record_id);
                    $('.del_modal_title').html("Delete Confirmation");
                    $('.del_modal_body').html('<p>Are you sure to delete !</p>');
                });
                $('#detail').on('show.bs.modal', function(e) {
                    var data = $(e.relatedTarget).data();
                    if (data.media_type === 'image/png' || data.media_type === 'image/jpeg' || data
                        .media_type === 'image/jpeg' || data.media_type === 'image/jpeg' || data
                        .media_type === 'image/gif') {
                        var media_content_path = "<a href='" + data.image + "' target='_blank'>" + data
                            .image + "</a>";
                    } else {
                        var media_content_path = "<a href='" + data.source + "' target='_blank'>" + data
                            .source + "</a>";
                    }



                    $('#modal_media_name').text("").text(data.media_name);
                    $('#modal_media_path').html("").html(media_content_path);
                    $('#modal_media_type').text("").text(data.media_type);
                    $('#modal_media_size').text("").text(convertSize(data.media_size));
                    updateMediaDetailPopup(data.media_type, data.source, data.image);

                });

                function updateMediaDetailPopup(media_type, url, thumb_path) {
                    var content_popup = "";
                    if (media_type == "video") {
                        var youtubeID = YouTubeGetID(url);
                        content_popup = '<object data="https://www.youtube.com/embed/' + youtubeID +
                            '" width="100%" height="400"></object>';
                    } else {
                        content_popup = '<img src="' + thumb_path + '" class="img-responsive">';
                    }
                    $('.popup_image').html("").html(content_popup);


                }


                function YouTubeGetID(url) {
                    var ID = '';
                    url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
                    if (url[2] !== undefined) {
                        ID = url[2].split(/[^0-9a-z_\-]/i);
                        ID = ID[0];
                    } else {
                        ID = url;
                    }
                    return ID;
                }


                $("#video_form").submit(function(e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    var url = $(this).attr("action");
                    var $this = $('.video_submit');

                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: 'json',
                        data: $('#video_form').serialize(),
                        beforeSend: function() {
                            $this.button("Loading...");
                            $("[class$='_error']").html("");
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                load(1);
                            } else {
                                if (typeof data.error !== 'undefined') {
                                    $('.file_error').html(data.error.video_url)
                                } else {
                                    errorMsg(data.msg);
                                }
                            }

                        },
                        error: function(xhr) { // if error occured
                            $this.button('reset');
                        },
                        complete: function() {
                            $this.button('reset');
                        },
                    });


                });

            });

            function load(page) {

                var keyword = $('.search_text').val();
                var file_type = $('.file_type').val();
                var is_gallery = 0;
                $.ajax({
                    url: '{{url("ajax/media")}}',
                    method: "GET",
                    data: {
                        'keyword': keyword,
                        'file_type': file_type,
                        'is_gallery': is_gallery
                    },
                    //dataType: "json",
                    beforeSend: function() {
                        $('#media_div').empty();
                    },

                    success: function(data) {

                        $('#media_div').empty();
                        $("#media_div").append(data);

                    },
                    complete: function() {


                    }
                });
            }

            //========================

            $(function() {
                // Drop
                $('.upload-area').on('drop', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    console.log(fd);
                    return false;
                    var file = e.originalEvent.dataTransfer.files;
                    var fd = new FormData();
                    var ins = document.getElementById('file').files.length;
                    for (var x = 0; x < ins; x++) {
                        fd.append("files[]", document.getElementById('file').files[x]);
                    }

                    uploadData(fd);
                });

                // Open file selector on div click
                $("#files").click(function() {
                    $("#file").click();
                });

                // file selected

            });


            $(document).on('click', '.btn_delete', function() {
                var $this = $('.btn_delete');

                var record_id = $('#record_id').val();

                $.ajax({
                    url: '{{url("ajax/media")}}',
                    type: "GET",
                    data: {
                        'record_id': record_id,
                        'delete': 'true'
                    },
                    //dataType: 'Json',
                    beforeSend: function() {
                        $this.button("Loading...");
                    },
                    success: function(data) {
                        if (data === 1) {
                            successMsg('File deleted succesfully');
                            load(1);
                        } else {
                            errorMsg('File deleted succesfully');
                        }
                        $("#confirm-delete").modal('hide');
                    },

                    complete: function() {

                        $this.button('reset');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            });


            // Bytes conversion
            function convertSize(bytes, decimalPoint) {
                if (bytes == 0)
                    return '0 Bytes';
                var k = 1024,
                    dm = decimalPoint || 2,
                    sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
                    i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        </script>

        <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content fullshadow">
                    <button type="button" class="ukclose" data-dismiss="modal">&times;</button>
                    <div class="smcomment-header">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 popup_image">

                            </div>
                            <div class="col-md-4 col-sm-4 smcomment-title">
                                <dl class="mediaDL">
                                    <dt>Media Name</dt>
                                    <dd id="modal_media_name"></dd>
                                    <dt>Media Type</dt>
                                    <dd id="modal_media_type"></dd>
                                    <dt>Media Path</dt>
                                    <dd id="modal_media_path"></dd>
                                    <dt>Media Size</dt>
                                    <dd id="modal_media_size"></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <input type="hidden" id="record_id" name="record_id" value="0">
                    <div class="modal-header">
                        <h4 class="modal-title del_modal_title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body del_modal_body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn_delete btn-danger" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Loading...">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                $(document).on('click', '.pagination a', function(event) {

                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];

                    fetch_data(page);
                });

                function fetch_data(page) {

                    $.ajax({
                        url: "<?= url("ajax/media") ?>?page=" + page,
                        success: function(data) {
                            $('#media_div').empty(data);
                            $('#media_div').append(data);
                        }
                    });
                }

            });
        </script>
        @include('admin.include.footer');