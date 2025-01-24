@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
<style>
    .w-5{
      display: none;
  }
    </style>
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
                    <i class="fa fa-empire"></i> Front CMS </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title titlefix">Banner Images</h3>
                                @if($can_add>0)
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-primary btn-sm gallery_image"
                                        id="gallery_images"><i class="fa fa-plus"></i> Add Images </button>
                                </div>
                                @endif
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <div class="box-body">
                                <div class="mediarow">
                                    <div class="row">
                                        <div class="gallery_content">
                             @foreach($list as $row)
                                            <div
                                                class='col-sm-3 col-md-2 col-xs-6 img_div_modal gallery_img div_record_195'>
                                                <div class='fadeoverlay'>
                                                    <img class='img-responsive' data-fid='<?=$row->imageid?>'
                                                        data-content_name='<?=$row->image?>'
                                                        data-img='<?=$row->image?>'
                                                        src="{{asset('public/uploads/gallery/media/'.$row->image)}}">
                                                        @if($can_delete>0)
                                                    <div class='overlay3'>
                                                        <a href='#' class='uploadclosebtn delete_gallery_img'
                                                            data-record_id='<?=$row->imageid?>' data-toggle='modal'
                                                            data-target='#confirm-delete'><i
                                                                class=' fa fa-trash-o'></i></a>
                                                        <p class='processing'>Processing...</p>
                                                    </div>
                                                    @endif
                                                    <p class=''>
                                                    <?=$row->image?>
                                                    </p>
                                                </div>
                                            </div>
@endforeach

                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (right) -->
                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <script>
        $(document).ready(function() {
            var popup_target = 'gallery_image';

            $('#mediaModal').modal({
                backdrop: 'static',
                keyboard: false,
                show: false
            });

            $(document).on('click', '.gallery_image', function(event) {
                $("#mediaModal").modal('toggle', $(this));
            });

            $('#mediaModal').on('show.bs.modal', function(event) {
                var a = $(event.relatedTarget) // Button that triggered the modal
                popup_target = a[0].id;
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
                var content = "";
                if (popup_target === "gallery_images") {
                    if (content_type === "image/gif" || content_type === "image/jpeg" ||
                        content_type === "image/png" || content_type === "image/jpg") {
                        $.ajax({
                            type: "GET",
                            url: "{{url('admin/banneraction')}}",
                            // dataType: 'json',
                            data: {
                                'content_id': content_id,
                                'content_name': content_name
                            },
                            beforeSend: function() {


                            },
                            success: function(data) {
                                if (data == '1') {
                                    insert_gallery(content_html, content_id, content_name,
                                        is_image);
                                    successMsg('Banner inserted successfully');
                                }
                            },
                            error: function(xhr) { // if error occured

                            },
                            complete: function() {
                                $('#mediaModal').modal('hide');

                            },
                        });


                    }


                }

            });

        });



        function insert_gallery(content_image, content_id, content_name, is_image) {
            var output = '';
            output += "<div class='col-sm-2 col-md-2 col-xs-2 gallery_img div_record_" + content_id + "'>";
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

        $(document).on('click', '.delete_gallery_img', function(e) {
            var content_id = $(this).data('record_id');
            var result = confirm("Delete Confirm?");

            if (result == true) {
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/banneraction')}}",
                    dataType: 'json',
                    data: {
                        'content_id': content_id,
                        'type': 'delete'
                    },
                    beforeSend: function() {},
                    success: function(data) {

                        if (data == 1) {
                            $(e.target).closest('.gallery_img').remove();
                            successMsg('Banner removed successfully.');
                        } else {
                            errorMsg('Some error occured.');
                        }
                    },
                    error: function(xhr) { // if error occured

                    },
                    complete: function() {

                    },
                });
            }
        });
        </script>



        <!-- Modal -->
        <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog pup100" role="document">
                <div class="modal-content modal-media-content">
                    <div class="modal-header modal-media-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title modal-media-title" id="myModalLabel">Media Manager</h4>
                    </div>
                    <div class="modal-body modal-media-body pupscroll">

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
});
</script>
        @include('admin.include.footer');