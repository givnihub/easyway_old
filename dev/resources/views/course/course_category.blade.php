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
                    <i class="fa fa-empire"></i> Course Category </h1>
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
                    <?php if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                    } ?>

                    <form id="form1" action="{{url('admin/course-category')}}" enctype="multipart/form-data" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <input type="hidden" name="uid" value="<?= $id ?>">
                        <div class="col-md-9">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Course Category</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title</label><small class="req"> *</small>
                                        <input id="title" name="title" placeholder="" required type="text" class="form-control" value="<?= $row[0]->type; ?>" />
                                        <span class="text-danger">@error('title'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">URL</label><small class="req"> *</small>
                                        <input id="url" name="url" placeholder="" required type="text" class="form-control" value="<?= $row[0]->url; ?>" />
                                        <span class="text-danger"></span>
                                    </div>


                                    <div class="formgroup10 mb10">
                                        <label for="exampleInputEmail1">Description</label><small style="color:red;">
                                            *</small>
                                        <button type="button" class="btn btn-primary btn-sm pull-right" id="media_images" data-toggle="modal" data-target="#mediaModal"><i class="fa fa-plus"></i>
                                            Add Media </button>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="editor1" name="description" placeholder="" type="text" class="form-control ss" required>
                                            <?= $row[0]->description; ?>

                                                                    </textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                            <div class="panel box box-primary collapsed-box">
                                <div class="box-header with-border">
                                    <a class="btn boxplus" data-widget="collapse" data-original-title="Collapse">SEO
                                        Detail<i class="fa fa-plus"></i>
                                    </a>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Title</label>
                                        <input id="meta_title" name="meta_title" placeholder="" type="text" class="form-control" value="<?= $row[0]->meta_title; ?>" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Keyword</label>
                                        <input id="meta_keywords" name="meta_keywords" placeholder="" type="text" class="form-control" value="<?= $row[0]->meta_keywords; ?>" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <textarea id="" name="meta_description" placeholder="" type="text" class="form-control"><?= $row[0]->meta_description; ?></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary" id="holist">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix">Course type</h3>

                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="download_label">Course Type List</div>
                                    <span id="message"></span>
                                    <div class="mailbox-controls">
                                        <div class="pull-right">
                                        </div><!-- /.pull-right -->
                                    </div>
                                    <div class="mailbox-messages">
                                        <div class="table-responsive">

                                            <table class="table table-striped table-bordered table-hover example">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Type</th>
                                                        <th>Url</th>
                                                        <th>Feature Image</th>
                                                        <th>Position</th>
                                                        <th class="text-right">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach($list as $runss)
                                                    <tr>
                                                        <td>{{$runss->id}}</td>
                                                        <td>{{$runss->type}}</td>
                                                        <td>{{$runss->url}}</td>
                                                        <td><img src="{{$runss->feature_image}}" class="img-responsive" style="height:100px;width:100px;"></td>
                                                        <td><input type="number" value="{{$runss->position}}" data-id="{{$runss->id}}" class="position" min="0" @if($can_edit!='1') disabled @endif ></td>
                                                        <td class="mailbox-date pull-right">
                                                            @if($can_edit>0)
                                                            <a data-placement="left" href="{{url('admin/course-category')}}?id=<?= $runss->id ?>&type=edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Edit">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                           
                                                            

                                                            <a data-placement="left" href="{{url('admin/course-category')}}?uid=<?= $runss->id ?>&status={{$runss->status}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Update Status">
                                                                @if($runss->status==1)
                                                                <i class="fa fa-check"></i>
                                                                @else
                                                                <i class="fa fa-remove"></i>
                                                                @endif
                                                            </a>
                                                            @endif
                                                            @if($can_delete>0)
                                                            <a data-placement="left" href="{{url('admin/course-category')}}?delid=<?= $runss->id ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete category" data-original-title="Delete" onclick="return confirm('Are you sure...?')">
                                                                <i class="fa fa-trash"></i>
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
                        <!--/.col (right) -->
                        <!-- left column -->
                        <div class="col-md-3 col-sm-12 uploadbarfixes">
                            <div class="">
                                <!-- page settings -->
                                <!-- page image -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Featured Image</h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-placement="left" title="Collapse"><i class="fa fa-minus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control iframe-btn" placeholder="Select Image" type="text" name="image" id="image" value="<?= $row[0]->feature_image; ?>" required>
                                                <span class="input-group-btn">
                                                    <a href="#" class="btn cfees feture_image_btn" id="feture_image" data-toggle="tooltip" data-title="Select Image" type="button"><i class="fa fa-folder-open"></i></a>
                                                    <a href="#" class="btn removegraybtn delete_media" id="image" data-toggle="tooltip" data-title="Delete" type="button"><i class="fa fa-trash"></i></a>

                                                </span>
                                            </div>
                                            <div id="image_preview" class="thumbnail" <?php if (empty($id)) {
                                                                                            echo 'style="margin-top: 10px; display: none"';
                                                                                        } else {
                                                                                            echo 'style="margin-top: 10px;"';
                                                                                        } ?>>
                                                <img src="<?= $row[0]->feature_image; ?>" class="img-responsive feature_image_url">
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                <!-- Save button -->
                                @if($can_add>0)
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <button type="submit" class="btn cfees btn-block"><i class="fa fa-save"></i>
                                            Save</button>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                @endif
                            </div>
                        </div><!-- /.col-md-4 -->

                    </form>

                </div>

            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!-- Modal -->
        <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pup100" role="document">
                <div class="modal-content modal-media-content">
                    <div class="modal-header modal-media-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title modal-media-title" id="myModalLabel">Media Manager</h4>
                    </div>
                    @include('admin.include.search');
                    <input type="hidden" id="mediatype" value="">
                    <div class="modal-body modal-media-body pupscroll">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary add_media">Add</button>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.include.footer');
        <script>
            $(document).ready(function() {
                $(document).on('click', '.pagination a', function(event) {

                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];

                    fetch_data(page);
                });

                function fetch_data(page) {
                    $.ajax({
                        url: "<?= url("ajax/getmedia") ?>?page=" + page,
                        method: 'GET',
                        success: function(data) {
                            $('.modal-media-body').empty(data);
                            $('.modal-media-body').append(data);
                        }
                    });
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                var popup_target = 'media_images';
                CKEDITOR.replace('editor1', {
                    allowedContent: true
                });

                $('#mediaModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: false
                });
                $(document).on('click', '.feture_image_btn', function(event) {

                    $("#mediaModal").modal('toggle', $(this));

                });

                $('#mediaModal').on('show.bs.modal', function(event) {

                    var a = $(event.relatedTarget) // Button that triggered the modal

                    popup_target = a[0].id;
                    $('#mediatype').val(popup_target);
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var $modalDiv = $(event.delegateTarget);
                    $('.modal-media-body').html("");
                    $.ajax({
                        type: "GET",
                        url: "{{url('ajax/getmedia')}}",
                        //dataType: 'text',
                        data: {},
                        beforeSend: function() {

                            $modalDiv.addClass('modal_loading');
                        },
                        success: function(data) {

                            $('.modal-media-body').html(data);
                        },
                        error: function(xhr) { // if error occured
                            $modalDiv.removeClass('modal_loading');
                        },
                        complete: function() {
                            $modalDiv.removeClass('modal_loading');
                        },
                    });
                });

                $('.detail_popover').popover({
                    placement: 'right',
                    trigger: 'hover',
                    container: 'body',
                    html: true,
                    content: function() {
                        return $(this).closest('td').find('.fee_detail_popover').html();
                    }
                });

                $(document).on('click', '.img_div_modal', function(event) {
                    $('.img_div_modal div.fadeoverlay').removeClass('active');
                    $(this).closest('.img_div_modal').find('.fadeoverlay').addClass('active');

                });


            });
            $(document).on('click', '.add_media', function(event) {
                var content_html = $('div.image_div').find('.fadeoverlay.active').find('img').data('img');

                var is_image = $('div.image_div').find('.fadeoverlay.active').find('img').data('is_image');

                var content_name = $('div.image_div').find('.fadeoverlay.active').find('img').data('content_name');

                var content_type = $('div.image_div').find('.fadeoverlay.active').find('img').data('content_type');

                var vid_url = $('div.image_div').find('.fadeoverlay.active').find('img').data('vid_url');
                //$('#mediaModal').modal('hide');
                var content = "";
                let popup_target = $('#mediatype').val();
                if (popup_target === "media_images") {
                    if (typeof content_html !== "undefined") {
                        if (is_image === 1) {
                            content = '<img src="' + content_html + '">';
                        } else if (content_type == "video") {

                            var youtubeID = YouTubeGetID(vid_url);


                            content = '<iframe id="video" width="420" height="315" src="//www.youtube.com/embed/' +
                                youtubeID + '?rel=0" frameborder="0" allowfullscreen></iframe>';

                        } else {
                            content = '<a href="' + content_html + '">' + content_name + '</a>';

                        }
                        InsertHTML(content);
                        $('#mediaModal').modal('hide');
                    }
                } else {
                    if (is_image === 1) {


                        addImage(content_html);
                    } else {
                        //error show  
                    }
                    $('#mediaModal').modal('hide');
                }
            });

            function addImage(content_html) {
                $('.feature_image_url').attr('src', content_html);
                $('#image').val(content_html);
                $('#image_preview').css("display", "block");
            }
            $(document).on('click', '.delete_media', function() {
                $('.feature_image_url').attr('src', '');
                $('#image').val('');
                $('#image_preview').css("display", "none");
            });

            function InsertHTML(content_html) {
                // Get the editor instance that we want to interact with.
                var editor = CKEDITOR.instances.editor1;


                // Check the active editing mode.
                if (editor.mode == 'wysiwyg') {
                    editor.insertHtml(content_html);
                } else
                    alert('You must be in WYSIWYG mode!');
            }
            $('#title').keyup(function() {
                let vals = $(this).val();
                let url = (vals.replace(/[' ','/','&','*','(',')','@']/g, "-")).toLowerCase();
                $('#url').val(url);
            });
            $('.position').on('change', function() {
                let id = $(this).attr('data-id');
                let position = $(this).val();
                let table = 'course_type';
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/position')}}",
                    data: {
                        id: id,
                        position: position,
                        table: table
                    },
                    success: function(data) {
                        $('#message').html(data);
                    },

                });
            });
        </script>