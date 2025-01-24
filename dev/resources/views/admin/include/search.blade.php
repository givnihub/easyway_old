<div class="col-lg-12">
    <div class="form-horizontal">
        <!-- left column -->
        <div class="col-sm-5" style="margin: 10px;">
            <div class="form-group">

                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control search_text" placeholder="Search By File Name" autocomplete="off">
                        <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5" style="margin: 10px;">
            <div class="form-group">
                <label for="new_name" class="col-sm-5 control-label">Filter By File Type</label>
                <div class="col-sm-7">
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
                url: "<?= url("ajax/getmedia") ?>?page=" + page,
                method: 'GET',
                success: function(data) {
                    $('.modal-media-body').empty(data);
                    $('.modal-media-body').append(data);
                }
            });
        }

        function load(page) {

            var keyword = $('.search_text').val();
            var file_type = $('.file_type').val();
            var is_gallery = 0;
            $.ajax({
                url: '{{url("ajax/getmedia")}}',
                method: "GET",
                data: {
                    'keyword': keyword,
                    'file_type': file_type,
                    'is_gallery': is_gallery
                },
                //dataType: "json",
                // beforeSend: function() {
                //     $('.modal-media-body').empty();
                // },

                success: function(data) {

                    $('.modal-media-body').empty();
                    $(".modal-media-body").append(data);

                },
                complete: function() {


                }
            });
        }
        $(".search_text").keyup(function() {

            load(1);
        });
        $(".file_type").change(function() {
            load(1);
        });
    });
</script>