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
                            <h3 class="box-title"><i class="fa fa-search"></i> Course sell data for : - <?=$list[0]->title?> </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">

                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Admission No</th>
                                            <th>Purchase Date</th>
                                            <th>Price</th>
                                            <th>Mobile</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($list as $row)

                                        <tr>
                                            <td><a href="{{url('student/view')}}/{{$row->studentid}}">{{$row->firstname}} {{$row->lastname}}</td>
                                            <td>{{$row->admission_no}}</td>

                                            <td>{{date('d-m-Y',strtotime($row->cdate))}}</td>
                                            <td>{{number_format($row->amount-($row->discount),2)}}</td>
                                            <td>{{$row->mobileno}}</td>
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