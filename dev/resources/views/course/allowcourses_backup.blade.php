@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header');

        @include('admin.include.sidebar');

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <?php if ($_GET['id'] != '') {
                $id = $_GET['id'];
            } ?>
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
                    <form id="form1" action="" enctype="multipart/form-data" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">

                        @csrf
                        <div class="col-md-9">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Allow Course </h3>
                                    <div class="box-tools pull-right">
                                        <a href="{{url('admin/allowed-courses-list')}}" class="btn btn-sm btn-primary"><i class="fa fa-list-alt"></i> View Allowed Courses List</a>

                                    </div>
                                </div><!-- /.box-header -->
                                <!-- form start -->


                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Student</label><small class="req"> *</small>
                                        <select id="student_id" name="student" class="form-control" required />
                                        <option value="">Select Student</option>
                                        @foreach($students as $row)

                                        <option value="{{$row->id}}">{{$row->firstname}} {{$row->lastname}} ({{$row->roll_no}} , {{$row->email}} , {{$row->mobileno}})</option>
                                        @endforeach
                                        </select>
                                        <span class="text-danger">@error('student'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Course</label><small class="req"> *</small>
                                        <select id="course" name="course" class="form-control" required>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $run)
                                            <option value="{{$run->id}}">{{$run->title}} (Rs. {{$run->price-($run->price*($run->discount/100))}})</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger">@error('course'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount</label><small class="req"> *</small>
                                        <input type="number" min="0" id="amount" name="amount" class="form-control" placeholder="Enter amount" required/>
                                          
                                        <span class="text-danger">@error('course'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn cfees btn-block"><i class="fa fa-save"></i> Enroll Now</button>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>

                    </form>
                </div>

            </section><!-- /.content -->
        </div>
        @include('admin.include.footer');