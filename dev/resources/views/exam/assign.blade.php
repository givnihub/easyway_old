@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
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
                    <?php $onlineexam_id=Request::segment('4');?>
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            
                            <div class="box-body">
                                <form role="form" action="" method="post" class="row">
                                    @csrf
                                    <input type="hidden" name="onlineexam_id" value="{{$onlineexam_id}}">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Class</label> <small class="req"> *</small>
                                            <select autofocus="" id="class_id" name="class_id" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($list as $run)
                                                <option value="{{$run->id}}" @if($run->id==$class_id) selected @endif>{{$run->class}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Batch</label>
                                            <select id="batch_id" name="batch_id" class="form-control">
                                                <option value="">Select</option>
                                                @if($batch_id!='')
                                                <option value="{{$batch_id}}" selected><?php $res=DB::table("batches")->where("id",$batch_id)->get()->first(); 
                                                echo $res->batch;
                                                ?></option>
                                                @endif
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" name="search" value="search_filter"
                                                class="btn btn-primary pull-right btn-sm checkbox-toggle"><i
                                                    class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-users"></i> Assign Online Exam</h3>
                                    <div class="box-tools pull-right">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="table-responsive">

                                                <h4>
                                                    
                                                    <a href="#" data-toggle="popover" class="detail_popover"
                                                        data-original-title="" title="">{{$exam->exam}}</a>
                                                </h4>



                                            </div>
                                        </div>
                                        <form method="post" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="class_id" value="{{$class_id}}">
                                        <input type="hidden" name="batch_id" value="{{$batch_id}}">
                                        <input type="hidden" name="examid" value="{{$onlineexam_id}}">
                                        <input type="hidden" name="assign" value="assign">
                                        <input type="hidden" name="course_name" value="{{$exam->exam}}">
                                        @csrf
                                        <div class="col-md-8">
                                            <div class=" table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th><input style="vertical-align: text-top;" type="checkbox"
                                                                    id="select_all"> All</th>

                                                            <th>Admission No</th>
                                                            <th>Student Name</th>

                                                            <th>Class</th>
                                                            <th>Father Name</th>
                                                           
                                                            <th class="pull-right">Gender</th>

                                                        </tr>
                                                        
                                                        @foreach($students as $row)
                                                       <?php 
                                                        $count=DB::table("onlineexam_students")->where("onlineexam_id", $onlineexam_id)->where("class_id",$class_id)->where("batch_id",$batch_id)->where("student_id",$row->id)->count();
                                                       
                                                       ?>
                                                        <tr>

                                                            <td>
                                                                <input type="hidden" name="all_students[]" value="0">

                                                                <input class="checkbox" type="checkbox"
                                                                    name="students_id[]" value="{{$row->id}}" @if($count>0) checked @endif>


                                                            </td>

                                                            <td>{{$row->admission_no}}</td>

                                                            <td>{{$row->firstname}} {{$row->lastname}}</td>
                                                            <td><span class="classbatch"></span></td>
                                                            <td>{{$row->father_name}}</td>
                                                           
                                                            <td class="pull-right">{{$row->gender}}</td>

                                                        </tr>
                                                         @endforeach
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                            <button type="submit" class="allot-fees btn btn-primary btn-sm pull-right"
                                                id="load"
                                                data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait..">Save
                                            </button>
                                            <br>
                                            <br>
                                        </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <script>
        $(document).ready(function() {
            $("#select_all").change(function () {  //"select all" change
        $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });


    $('.checkbox').change(function () {
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if (false == $(this).prop("checked")) { //if this item is unchecked
            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }
       
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $("#select_all").prop('checked', true);
        }
    });
            let classtext=$('#class_id option:selected').text();
            let batchtext=$('#batch_id option:selected').text();
            let clasbatch=$('.classbatch').html(classtext+"("+batchtext+")");
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
        });
        </script>




        @include('admin.include.footer')