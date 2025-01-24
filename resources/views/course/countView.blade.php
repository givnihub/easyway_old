@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    @include('admin.include.header')
    @include('admin.include.sidebar')

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box removeboxmius">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> Course View Details for : - <?= $list[0]->title ?> </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">

                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>

                                            <th>Course</th>
                                            <th>View</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>View Date</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $row)
                                        <?php
                                        $checkPurchased = DB::table('course_payment')->where('course_id', $row->courseid)->where('email', $row->email)->count();

                                        $countView = DB::table('courseViewCount')->where('userid', $row->studentid)->where('courseid', $row->courseid)->count();

                                        ?>
                                        @if($checkPurchased>0)
                                        @continue;
                                        @endif
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->title}}</td>
                                            <td>{{$countView}}</td>
                                            <td><a href="{{url('student/view')}}/{{$row->studentid}}">{{$row->firstname}} {{$row->lastname}}</td>
                                            <td>{{$row->email}}</td>
                                            <td>{{$row->mobileno}}</td>
                                            <td>{{date('d-m-Y H:i:s',strtotime($row->cdate))}}</td>


                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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



    @include('admin.include.footer')