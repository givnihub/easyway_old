@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header')
        @include('admin.include.sidebar')

        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();
        @endphp

        <div class="content-wrapper" style="min-height: 1126px;">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <form action="{{url('student/multiclass')}}" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Class</label><small class="req">
                                                    *</small>
                                                <select autofocus="" id="class_id" name="class_id" class="form-control"
                                                    required>

                                                    <option value="">Select</option>
                                                    @foreach($class as $row)
                                                    <option value="<?= $row->id ?>" @if($row->id==$_POST['class_id']) selected @endif>{{$row->class}} </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Batch</label><small class="req">
                                                    *</small>
                                                <select id="batch_id" name="batch_id" class="form-control" required>
                                                    <option value="">Select Batch</option>
                                                    <option value="<?=$_POST['batch_id']?>" selected>
                                                    <?php $batchname=DB::table('batches')->where('id',$_POST['batch_id'])->first();
                                                                                echo $batchname->batch;
                                                                                
                                                                                ?>
                                                
                                                </option>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">

                                            <button type="submit" class="btn btn-primary btn-sm pull-right"><i
                                                    class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>



                            <div class="ptt10">
                                <div class="bordertop">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                                    </div>

                                    <div class="box-body">
                                        <div class="row">
                                            @foreach($rows as $run)
                                            <form action="{{url('student/savemulticlass')}}" method="POST"
                                                class="update">
                                                @csrf

                                                <div class="col-md-6">
                                                    <div class="panel panel-info">
                                                        <div class="panel-body panelheight">

                                                            {{$run->firstname}} {{$run->lastname}}
                                                            ({{$run->admission_no}}) <input type="hidden"
                                                                value="{{$run->id}}" name="student_id">
                                                            <input type="hidden" value="1" name="nxt_row"
                                                                class="nxt_row">

                                                            <div class="row">
                                                                <div class="text-center">

                                                                    <div
                                                                        class="col-xs-12 col-xs-offset-0 col-sm-3 col-sm-offset-9">
                                                                        <button type="button"
                                                                            class="btn btn-default btn-sm pull-right addrow addrow-mb2010">
                                                                            <i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="append_row pluscolmn">
                                                                <?php $multiClass=DB::table("multi_class_students")->where('student_id',$run->id)->get();
                                                                        foreach($multiClass as $multclassrow){?>
                                                                <div class="row">
                                                                    <input type="hidden" name="row_count[]" value="1">
                                                                    <div class="col-sm-5 col-lg-5 col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="email">Class</label>
                                                                            <select name="class_id[]"
                                                                                class="form-control class_id">
                                                                                <option value="">Select</option>
                                                                                @foreach($class as $row)
                                                                                <option value="<?= $row->id ?>" @if($multclassrow->class_id==$row->id) selected @endif>
                                                                                    {{$row->class}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-5 col-lg-5 col-md-4">
                                                                        <label for="email">Batch</label>
                                                                        <div class="form-group">
                                                                            <select name="batch_id[]"
                                                                                class="form-control batch_id">
                                                                                <option value="">Select Batch</option>
                                                                                <option value="{{$multclassrow->batch_id}}" selected><?php $batchname=DB::table('batches')->where('id',$multclassrow->batch_id)->first();
                                                                                echo $batchname->batch;
                                                                                
                                                                                ?></option>
                                                                            </select>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-2 col-lg-2 col-md-4">
                                                                        <div class="form-group"><label for="email"
                                                                                style="opacity: 0;">Action</label>
                                                                            <button
                                                                                class="btn btn-sm btn-danger rmv_row"
                                                                                type="button">Remove</button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <?}?>
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer panel-fo">
                                                            <div class="row text-center">

                                                                <div
                                                                    class="col-xs-12 col-xs-offset-0 col-sm-3 col-sm-offset-9">
                                                                    <button type="submit"
                                                                        class="btn btn-default btn-sm pull-right"
                                                                        data-loading-text="<i class='fa fa-spinner fa-spin '></i> Updating...">
                                                                        Update </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>

                                            @endforeach
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </section>

            <!-- /.content -->
            <div class="clearfix"></div>
        </div>


        <script type="text/javascript">
        // this is the id of the form

        $(document).on('submit', '.update', function(e) {
            var submit_btn = $(this).find("button[type=submit]");
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                dataType: "json",
                beforeSend: function() {
                    submit_btn.button('loading');
                },
                success: function(data) {

                    if (data == 1) {

                        successMsg("Multiple class added successfully....");
                    } else {
                        errorMsg('Some error occured...');
                    }
                    submit_btn.button('reset');
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");

                },
                complete: function() {
                    submit_btn.button('reset');
                }
            });


        });
        </script>
        <script type="text/javascript">
        $(document).on('click', '.rmv_row', function(e) {
            $(this).closest("div.row").remove();
        });


        $(document).on('change', '.class_id', function(e) {
            var class_id = $(this).val();

            var target_dropdown = $(this).closest("div.row").find('select.batch_id');

            target_dropdown.html("");
            var div_data = '';
            $.ajax({
                type: "GET",
                url: '{{url("ajax/class_batches")}}',
                data: {
                    'classid': class_id
                },
                // dataType: "json",
                beforeSend: function() {
                    target_dropdown.html("").addClass('dropdownloading');
                },
                success: function(data) {
                    div_data += data;

                    target_dropdown.append(div_data);
                },
                complete: function() {
                    target_dropdown.removeClass('dropdownloading');
                }
            });
        });



        $(document).on('click', '.addrow', function() {
            var container = $(this).closest(".panel-body").find('.append_row');
            var nxt_row = $(this).closest(".panel-body").find('.nxt_row').val();
            var new_class_dropdown = $('#class_dropdown').html().replace("class_id", "class_id");

            var new_section_dropdown = $('#section_dropdown').html().replace("batch_id", "batch_id");
            var $newDiv = $('<div>').addClass('row').append(
                $('<input>', {
                    type: 'hidden',
                    name: 'row_count[]',
                    val: parseInt(nxt_row)
                })).append(
                $('<div>').addClass('col-sm-5 col-lg-5 col-md-4').append($('<div>').addClass('form-group')
                    .append($('<label>').html('Class')).append(new_class_dropdown))
            ).append(
                $('<div>').addClass('col-sm-5 col-lg-5 col-md-4').append($('<div>').addClass('form-group')
                    .append($('<label>').html('Batch')).append(new_section_dropdown))
            ).append(
                $('<div>').addClass('col-sm-2 col-lg-2 col-md-4').append($('<div>').addClass('form-group')
                    .append($('<label>', {
                        css: {
                            'opacity': 0
                        }
                    }).html('Action')).append(


                        $('<button>').html('Remove').addClass('btn btn-sm btn-danger rmv_row')
                    )));

            $(this).closest(".panel-body").find('.nxt_row').val(parseInt(nxt_row) + 1);
            $newDiv.appendTo(container);

        });
        </script>
        <script type="text/template" id="class_dropdown">

            <select name="class_id[]" class="form-control class_id">
    <option value="">Select</option>
    @foreach($class as $row)
                                                            <option value="<?= $row->id ?>">{{$row->class}} </option>
                                                            @endforeach
            </select>
</script>
        <script type="text/template" id="section_dropdown">

            <select name="batch_id[]" class="form-control batch_id" autocomplete="off">
    <option value="">Select Batch</option>
    </select>
</script>
        <script>
        $(document).ready(function() {
            $('#class_id').change(function() {
                let classid = $(this).val();
                let classtext = $("#class_id option:selected").text().substring(0, 2);
                $('#admission_no').val(classtext);
                $.ajax({
                    url: '{{url("ajax/class_batches")}}',
                    type: "GET",
                    data: {
                        'classid': classid,
                    },
                    success: function(data) {
                        $('#batch_id').empty();
                        $('#batch_id').append(data);

                    }
                });
            });
        });
        </script>
        @include('admin.include.footer')