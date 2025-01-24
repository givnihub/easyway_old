@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <?php $urls = Request::segment('2'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-user-plus"></i> Student Information <small></small></h1>
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
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <div class="box-body">
                                <form role="form" action="" method="POST" class="class_search_form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @csrf
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Class</label> <small class="req"> *</small>
                                                        <select autofocus="" id="class_id" name="class_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($class as $row)
                                                            <option value="<?= $row->id ?>" @if($row->
                                                                id==$_POST['class_id']) selected @endif>{{$row->class}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger" id="error_class_id"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Batch</label>
                                                        <select id="batch_id" name="batch_id" class="form-control" required>
                                                            <option value="">Select Batch</option>
                                                            <option value="<?= $_POST['batch_id'] ?>" selected>
                                                                <?php $batchname = DB::table('batches')->where('id', $_POST['batch_id'])->first();
                                                                echo $batchname->batch;

                                                                ?>
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <button type="submit" name="search" id="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>



                                <!--./col-md-6-->
                            </div>
                            <!--./row-->
                        </div>

                        <div class="nav-tabs-custom border0 navnoshadow">
                            <div class="box-header ptbnull"></div>

                            <div class="">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-users"></i> Assign Fees Group </h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="">


                                            <div class="col-md-4">

                                                <div class="table-responsive">
                                                    <h4>
                                                        <?php $name = DB::select('select name from fee_groups where id=' . $fees->fee_groups_id);
                                                        echo $name[0]->name;

                                                        ?></h4>
                                                    <table class="table">
                                                        <tbody>

                                                            <tr class="mailbox-name">
                                                                <input type="hidden" name="feemaster_id" value="{{$fees->id}}">
                                                                <td>
                                                                    <?php $rs = DB::select('select code from feetype where id=' . $fees->feetype_id);
                                                                    echo $rs[0]->code;

                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    ₹{{$fees->amount}} </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <form method="post" action="">
                                                    @csrf
                                                    <input type="hidden" name="feegroup_id" value="{{$fees->id}}">
                                                    <input type="hidden" name="amount" value="{{$fees->amount}}">
                                                    <div class=" table-responsive">

                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <th><input type="checkbox" id="select_all"> All</th>
                                                                    <th>Roll No</th>
                                                                    <th>Admission No</th>
                                                                    <th>Student Name</th>
                                                                    <th>Class</th>
                                                                    <th>Father Name</th>
                                                                </tr>
                                                                @foreach($rows as $run)
                                                                <?php $check = DB::select('select id from student_fees_master where student_id=' . $run->id . ' and fee_group_id=' . $fees->id);


                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <input class="checkbox" type="checkbox" name="student_id[]" value="{{$run->id}}" @if($check[0]!='' ) checked @endif>
                                                                    </td>
                                                                    <td>{{$run->roll_no}}</td>

                                                                    <td>{{$run->admission_no}}</td>
                                                                    <td>{{$run->firstname}} {{$run->lastname}}</td>
                                                                    <td>

                                                                        <?php
                                                                        $batchRow = DB::select('select batch from batches where id=' . $run->batch_id);
                                                                        $classRow = DB::select('select class from classes where id=' . $run->class_id);

                                                                        ?>
                                                                        {{ $classRow[0]->class}}
                                                                        ({{ $batchRow[0]->batch; }})
                                                                    </td>
                                                                    <td>{{$run->father_name}}</td>

                                                                    <td>{{$run->roll_no}}</td>


                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <button type="submit" class="allot-fees pull-right btn btn-primary btn-sm " name="save" value="save" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait..">Save
                                                    </button>
                                                </form>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--./box box-primary -->
                </div>
        </div>
        </section>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#class_id').change(function() {
                let classid = $(this).val();

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
            //select all checkboxes
            $("#select_all").change(function() { //"select all" change 
                $(".checkbox").prop('checked', $(this).prop(
                    "checked")); //change all ".checkbox" checked status
            });

            //".checkbox" change 
            $('.checkbox').change(function() {
                //uncheck "select all", if one of the listed checkbox item is unchecked
                if (false == $(this).prop("checked")) { //if this item is unchecked
                    $("#select_all").prop('checked', false); //change "select all" checked status to false
                }
                //check "select all" if all checkbox items are checked
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $("#select_all").prop('checked', true);
                }
            });

        });
    </script>


    @include('admin.include.footer')