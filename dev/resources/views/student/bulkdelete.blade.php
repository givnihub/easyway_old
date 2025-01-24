@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header')
        @include('admin.include.sidebar')



        <div class="content-wrapper" style="min-height: 1126px;">
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
                    <!-- left column -->
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <form action="{{url('student/bulkdelete')}}" method="post" accept-charset="utf-8">
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



                            <div class="box-body table-responsive">
                                <div class="mailbox-messages">
<form method="post" action="{{url('student/bulkdelete')}}">
@csrf
                                <div class="checkbox">
                                            <label><input type="checkbox" name="checkAll" autocomplete="off"> <b>Select All</b> </label>
                                        </div>
                                    <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th>#</th>

                                                <th style="width:5%">Reference No</th>
                                                <th>Roll No</th>
                                                <th>Admission No</th>
                                                <th>Student Name</th>
                                                <th>Class</th>
                                                <th>Father Name</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>

                                                <th style="width:10%">Student Mobile Number</th>
                                        
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach($rows as $run)
                                            <tr role="row" class="odd">
                                                <td><input type="checkbox" name="studentid[]" value="{{$run->id}}"></td>
                                                <td>{{$run->refrence_no}}</td>
                                                <td>{{$run->roll_no}}</td>
                                                <td>{{$run->admission_no}}</td>
                                                <td>{{$run->firstname}} {{$run->lastname}}</td>
                                                <td>

                                                    <?php
                                                    $batchRow = DB::select('select batch from batches where id=' . $run->batch_id);
                                                    $classRow = DB::select('select class from classes where id=' . $run->class_id);

                                                    ?>
                                                    {{ $classRow[0]->class}} ({{ $batchRow[0]->batch; }})
                                                </td>
                                                <td>{{$run->father_name}}</td>
                                                <td>{{date('d/m/Y',strtotime($run->dob))}}</td>
                                                <td>{{$run->gender}}</td>

                                                <td>{{$run->mobileno}}</td>
                                              
                                               
                                            </tr>
                                            @endforeach


                                        </tbody>
                                        
                                    </table>
                                    <button type="submit" name="delete" value="bulkdelete" class="btn btn-primary pull-right btn-sm mt10" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please wait..." autocomplete="off"> Delete</button>
</form>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </section>

            <!-- /.content -->
            <div class="clearfix"></div>
        </div>
 
   
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
            $("input[name='checkAll']").click(function () {
        $("input[name='studentid[]']").not(this).prop('checked', this.checked);
    });
        });

        </script>
        @include('admin.include.footer')