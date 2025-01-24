@include('admin.include.head');

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
        <?php $urls = Request::segment('2'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-user-plus"></i> Student Information <small></small></h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-search"></i> Select Criteria</h3>
                            </div>
                            <div class="box-body">
                                <form role="form" action="{{url('student/')}}/{{$urls}}" method="POST" class="class_search_form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                @csrf
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Class</label> <small class="req"> *</small>
                                                        <select autofocus="" id="class_id" name="class_id" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($class as $row)
                                                            <option value="<?= $row->id ?>" @if($row->id==$_POST['class_id']) selected @endif>{{$row->class}} </option>
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

                                <form role="form" action="{{url('student/')}}/{{$urls}}" method="POST" class="class_search_form">
                                    @csrf
                                    <!--./col-md-6-->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Search By Keyword</label>
                                                    <input type="text" name="search_text" id="search_text" class="form-control" value="<?= $_POST['search_text'] ?>" placeholder="Search By Student Name,Admission No.,MobileNo,EmailId" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> Search</button>
                                                </div>
                                            </div>
                                </form>
                            </div>
                        </div>
                        <!--./col-md-6-->
                    </div>
                    <!--./row-->
                </div>

                <div class="nav-tabs-custom border0 navnoshadow">
                    <div class="box-header ptbnull"></div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> List View</a></li>
                        <!-- <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper-o"></i> Details View</a></li> -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active table-responsive no-padding" id="tab_1">

                            <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Roll No.</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Father Name</th>
                                        <th>Date of Admission</th>
                                        <th>Gender</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>

                                        <th class="text-right noExport">Action</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($rows as $run)
                                    <tr role="row" class="odd">
                                        <td>{{$i++}}</td>
                                        <td class="sorting_1">{{$run->roll_no}}</td>
                                        <td><a href="{{url('student/view/')}}/{{$run->id}}">{{$run->firstname}}
                                                {{$run->lastname}}</a></td>
                                        <td>

                                            <?php
                                            $batchRow = DB::select('select batch from batches where id=' . $run->batch_id);
                                            $classRow = DB::select('select class from classes where id=' . $run->class_id);

                                            ?>
                                            {{ $classRow[0]->class}} ({{ $batchRow[0]->batch; }})
                                        </td>
                                        <td>{{$run->father_name}}</td>
                                        <td>{{$run->admission_date}}</td>
                                        <td>{{$run->gender}}</td>

                                        <td>{{$run->mobileno}}</td>
                                        <td>{{$run->email}}</td>
                                        <td>
                                            @if($can_view>0)
                                            <a href="{{url('student/view/')}}/{{$run->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" title="Show"><i class="fa fa-reorder"></i></a>
                                           @endif
                                            @if($urls=='search')
                                            @if($can_edit>0)
                                            <a href="{{url('student/edit')}}/{{$run->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <!-- <a href="{{url('studentfee/addfee')}}/{{$run->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" title="Add Fees"><span>₹</span></a> -->
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                        <!-- <div class="tab-pane detail_view_tab" id="tab_2">
                            <div class="alert alert-info">No Record Found</div>
                        </div> -->
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

            //search value

            // $('#search').click(function() {
            //     let classid = $('#class_id').val();
            //     let batchid = $('#batch_id').val();
            //     if (classid == '' || batchid == '') {
            //         alert('Class and Batch both are required');
            //         exit;
            //     }
            //     $.ajax({
            //         url: '{{url("ajax/studentsearch")}}',
            //         type: "GET",
            //         data: {
            //             'classid': classid,
            //             'batchid': batchid,
            //         },
            //         success: function(data) {
            //             $('.searchVal').empty();
            //             $('.searchVal').append(data);

            //         }
            //     });
            // })
        });
    </script>


    @include('admin.include.footer')