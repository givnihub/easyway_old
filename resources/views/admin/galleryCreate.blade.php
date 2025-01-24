@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
   
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
                    <?php
                    if ($_GET['id'] != '') {
                        $id = $_GET['id'];
                    }
                    ?>
            
                    <form id="form1" action="create" enctype="multipart/form-data" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="col-md-9">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Gallery</h3>

                                </div><!-- /.box-header -->
                                <!-- form start -->
<input type="hidden" name="uid" value="<?=$id?>">
                                <div class="box-body">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title</label><small class="req"> *</small>
                                        <input id="title" name="title" placeholder="" type="text" class="form-control" value="<?= $row[0]->title ?>" required />
                                        <span class="text-danger"></span>
                                    </div>


                                    <div class="dividerhr"></div>


                                    <div class="formgroup10 form-group mb10">
                                        <label for="exampleInputEmail1">Description</label><small class="req"> *</small>
                                        <button type="button" class="btn btn-primary btn-sm pull-right" id="media_images" data-toggle="modal" data-target="#mediaModal"><i class="fa fa-plus"></i>
                                            Add Media </button>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="editor1" name="description" placeholder="" type="text" class="form-control ss"><?= $row[0]->description ?></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="dividerhr"></div>

                                    <div class="formgroup10">
                                        <label>Gallery Images</label>
                                        <button type="button" class="btn btn-primary btn-sm gallery_image pull-right" id="gallery_images"><i class="fa fa-plus"></i> Add Images</button>
                                        <div class="mediarow">
                                            <div class="row">
                                                <div class="gallery_content">
                    <?php if($id!=''){
                        $imgId=explode(',',$row[0]->gallery_images);
                        for($i=0;$i<count($imgId);$i++){
                          
                        $imgs=DB::select('select * from front_cms_media_gallery where id='.$imgId[$i]);
                        $imgname=$imgs[0]->img_name;
                        echo ' <div class="col-sm-3 col-md-2 col-xs-6 img_div_modal gallery_img div_record_'.$imgs[0]->id.'">
                         <div class="fadeoverlay"><img class="img-responsive" data-fid="'.$imgs[0]->id.'" 
                         data-content_name="'.$imgs[0]->img_name.'" data-is_image="1" data-img="'.$imgs[0]->img_name.'" src="'.asset("public/uploads/gallery/media/$imgname").'">
                         <input type="hidden" value="'.$imgs[0]->id.'" name="gallery_images[]">
                         <i class="fa fa-picture-o videoicon"></i><div class="overlay3">
                         <a href="#" class="uploadclosebtn delete_gallery_img" data-record_id="'.$imgs[0]->id.'" data-toggle="modal" data-target="#confirm-delete">
                         <i class=" fa fa-trash-o"></i></a><p class="processing">Processing...</p>
                         </div><p class="">'.$imgs[0]->img_name.'</p></div></div>';
                     
                        }
                        
                        ?>
                                               
                                      <?}?>
                                            </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-header -->
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
                                        <input id="meta_title" name="meta_title" value="<?=$row[0]->meta_title?>" placeholder="" type="text" class="form-control" value="" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Keyword</label>
                                        <input id="meta_keywords" name="meta_keywords" value="<?=$row[0]->meta_keywords?>" placeholder="" type="text" class="form-control" value="" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <textarea id="editor1" name="meta_description"  placeholder="" type="text" class="form-control"><?=$row[0]->meta_description?></textarea>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.col (right) -->
                        <!-- left column -->
                        <div class="col-md-3 col-sm-12">
                            <div class="uploadbarfixes">

                                <!-- page image -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Featured Image</h3>
                                        <div class="box-tools pull-right">
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-placement="left" title="Collapse"><i class="fa fa-minus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->

                                    <div class="box-body">

                                        <div class="form-group">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control iframe-btn" placeholder="Select Image" value="<?=$row[0]->image?>" type="text" name="image" id="image" required>
                                                <span class="input-group-btn">
                                                    <a href="#" class="btn cfees feature_image_btn" id="feature_image" data-toggle="tooltip" data-title="Select Image" type="button"><i class="fa fa-folder-open"></i></a>
                                                    <a href="#" class="btn removegraybtn delete_media" id="image" data-toggle="tooltip" data-title="Delete" type="button"><i class="fa fa-trash"></i></a>

                                                </span>
                                            </div>
                                            <div id="image_preview" class="thumbnail" <?php if(empty($id)){
                                                echo 'style="margin-top: 10px; display: none"';
                                            }else{
                                                echo 'style="margin-top: 10px;"';
                                            }?>
                                              
                                                >
                                                <img src="<?=$row[0]->image;?>" class="img-responsive feature_image_url">
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                <div class="box box-primary">
                                    <div class="box-body">

                                        <button type="submit" class="btn cfees btn-block"><i class="fa fa-save"></i>
                                            Save</button>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                                <!-- page image -->

                            </div>
                        </div><!-- /.col-md-4 -->

                    </form>
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
     
        <script>
            $(document).ready(function() {
                $(document).on('click', '.pagination a', function(event) {

event.preventDefault();
var page = $(this).attr('href').split('page=')[1];

fetch_data(page);
});

function fetch_data(page) {
$.ajax({
    url: "<?=url("ajax/getmedia")?>?page="+page,
    method: 'GET',
    success: function(data) {
        $('.modal-media-body').empty(data);
        $('.modal-media-body').append(data);
    }
});
}
                var popup_target = 'media_images';

                CKEDITOR.replace('editor1', {
                    allowedContent: true
                });

                $('#mediaModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: false
                });
                $(document).on('click', '.feature_image_btn', function(event) {
                    $("#mediaModal").modal('toggle', $(this));
                });

                $(document).on('click', '.gallery_image', function(event) {
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

                $(document).on('click', '.add_media', function(event) {
                    var content_html = $('div.image_div').find('.fadeoverlay.active').find('img').data(
                        'img');
                    var content_id = $('div.image_div').find('.fadeoverlay.active').find('img').data('fid');
                    var is_image = $('div.image_div').find('.fadeoverlay.active').find('img').data(
                        'is_image');
                    var content_type = $('div.image_div').find('.fadeoverlay.active').find('img').data(
                        'content_type');
                    var content_name = $('div.image_div').find('.fadeoverlay.active').find('img').data(
                        'content_name');

                    var vid_url = $('div.image_div').find('.fadeoverlay.active').find('img').data(
                        'vid_url');
                    var content = "";

                    if (popup_target === "media_images") {
                        if (typeof content_html !== "undefined") {
                            if (is_image === 1) {
                                content = '<img src="' + content_html + '">';
                            } else if (content_type == "video") {

                                var youtubeID = YouTubeGetID(vid_url);


                                content =
                                    '<iframe id="video" width="420" height="315" src="//www.youtube.com/embed/' +
                                    youtubeID + '?rel=0" frameborder="0" allowfullscreen></iframe>';

                            } else {
                                content = '<a href="' + content_html + '">' + content_name + '</a>';

                            }
                            InsertHTML(content);
                            $('#mediaModal').modal('hide');
                        }
                    } else if (popup_target === "feature_image") {
                        if (is_image === 1) {
                            addImage(content_html);
                        } else {
                            //error show  
                        }
                        $('#mediaModal').modal('hide');
                    } else if (popup_target === "gallery_images") {
                        if (content_type === "image/gif" || content_type === "image/jpeg" ||
                            content_type === "image/png" || content_type === "video" || content_type === "image/jpg") {

                            insert_gallery(content_html, content_id, content_name, is_image);
                        } else {
                            //error show  
                        }
                        $('#mediaModal').modal('hide');
                    }

                });

            });

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

            function insert_gallery(content_image, content_id, content_name, is_image) {

                var output = '';
                output += "<div class='col-sm-3 col-md-2 col-xs-6 img_div_modal gallery_img div_record_" + content_id +
                    "'>";
                output += "<div class='fadeoverlay'>";
                output += "<img class='img-responsive' data-fid='" + content_id + "' data-content_name='" + content_name +
                    "' data-is_image='" + is_image + "' data-img='" + content_image + "' src='" + content_image + "'>";
                output += "<input type='hidden' value='" + content_id + "' name='gallery_images[]'>";
                if (is_image == 1) {
                    output += "<i class='fa fa-picture-o videoicon'></i>";
                } else {
                    output += "<i class='fa fa-youtube-play videoicon'></i>";
                }
                output += "<div class='overlay3'>";
                output += "<a href='#' class='uploadclosebtn delete_gallery_img' data-record_id='" + content_id +
                    "' data-toggle='modal' data-target='#confirm-delete'><i class=' fa fa-trash-o'></i></a>";
                output += "<p class='processing'>Processing...</p>";
                output += "</div>";
                output += "<p class=''>" + content_name + "</p>";
                output += "</div>";
                output += "</div>";
                $(output).appendTo(".gallery_content");
            }

            $(document).on('click', '.delete_gallery_img', function() {
                $(this).closest('.gallery_img').remove();

            });
        </script>
        <!-- Modal -->
        <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pup100" role="document">
                <div class="modal-content modal-media-content">
                    <div class="modal-header modal-media-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title modal-media-title" id="myModalLabel">Media Manager</h4>
                    </div>

                    <input type="hidden" id="mediatype" value="">
                    @include('admin.include.search');
                    <div class="modal-body modal-media-body pupscroll">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary add_media">Add</button>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.include.footer');