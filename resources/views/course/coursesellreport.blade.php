@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    @include('admin.include.header')
    @include('admin.include.sidebar')

    <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary border0 mb0 margesection">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> Online Course Report</h3>
                        </div>
                        <div class="">
                            <ul class="reportlists">
                                <li class="col-lg-4 col-md-4 col-sm-6 "><a href="{{url('admin/course/report')}}/coursepurchase"><i class="fa fa-file-text-o"></i>Student Course Purchase Report</a></li>
                                <li class="col-lg-4 col-md-4 col-sm-6 "><a href="{{url('admin/course/report')}}/coursesellreport"><i class="fa fa-file-text-o"></i>Course Sell Count Report</a></li>
                                <li class="col-lg-4 col-md-4 col-sm-6 "><a href="{{url('admin/course/report')}}/trendingreport"><i class="fa fa-file-text-o"></i>Course Trending Report</a></li>
                                <li class="col-lg-4 col-md-4 col-sm-6 "><a href="{{url('admin/course/report')}}/completereport"><i class="fa fa-file-text-o"></i>Course Complete Report</a></li>

                                <li class="col-lg-4 col-md-4 col-sm-6 "><a href="{{url('admin/course/report')}}/notpurchase"><i class="fa fa-file-text-o"></i>Not Purchased</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box removeboxmius">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> @if(Request::segment('4')=='trendingreport') Course Trending Report @elseif(Request::segment('4')=='notpurchase') Not Purchased @else Course Sell Count Report @endif </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        @if(Request::segment('4')!='notpurchase')
                                        <tr>
                                            <th>Course</th>
                                            <th>Trade Groupe</th>
                                            <th>Trade</th>

                                            <th> @if(Request::segment('4')=='trendingreport') View Count @else Sell Count @endif</th>
                                            <th>Assign Teacher</th>
                                            <th>Created By</th>
                                            @if(Request::segment('4')=='trendingreport')
                                            <th>Price</th>
                                            <th>Current Price</th>
                                            @endif
                                            @if(Request::segment('4')!='trendingreport')
                                            <th class="noExport">Action</th>
                                            @endif
                                        </tr>
                                        @else
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>MobileNo</th>
                                            <th>Registration Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                        @endif
                                    </thead>
                                    <tbody>
                                        @foreach($list as $row)
                                        @if(Request::segment('4')!='notpurchase')
                                        <tr>
                                            <td>{{$row->title}}</td>
                                            <td><?php $res = DB::table("tradegroup")->where("id", $row->tradegroup_id)->first(['name']);
                                                echo $res->name;
                                                ?></td>
                                            <td><?php
                                                $trade_id = explode(",", $row->trade_id);
                                                for ($i = 0; $i < count($trade_id); $i++) {
                                                    $res = DB::table("trade")->where("id", $trade_id[$i])->first(['name']);
                                                    echo $res->name . ", ";
                                                }

                                                ?></td>
                                            <td>
                                                @if(Request::segment('4')=='trendingreport')
                                                <a href="{{url('admin/course/countView')}}/{{$row->id}}">
                                                {{$row->view_count}}
                                                </a>
                                                @else
                                                {{DB::table("course_payment")->where("course_id",$row->id)->count()}}
                                                @endif
                                            </td>
                                            <td><?php
                                                $teacher = DB::table("course_teacher")->where("course_id", $row->id)->get();
                                                foreach ($teacher as $run) {
                                                    $statff = DB::table("staff")->where("id", $run->teacher_id)->first(['name', 'surname', 'employee_id']);
                                                    echo $statff->name . '&nbsp;' . $statff->surname . ' (' . $statff->employee_id . ')' . '<br/>';
                                                }
                                                ?></td>
                                            <td>{{$row->created_by==''?'Admin':$row->created_by}}</td>
                                            @if(Request::segment('4')=='trendingreport')
                                            <td>{{number_format($row->price,2)}}
                                            
                                       
                                            </td>
                                            <td> {{number_format($row->price-($row->price*($row->discount/100)),2)}}</td>
                                            @endif
                                            @if(Request::segment('4')!='trendingreport')
                                            <td class="dt-body-right">


  <button type="button" class="btn btn-default btn-xs"   data-original-title="View" autocomplete="off">
  <a href="{{url('admin/course/report/coursesellreport/view')}}/{{$row->id}}">   
  <i class="fa fa-reorder"></i> 
  </a>
                                            </button>
                                        
                                                <!-- <button type="button" class="btn btn-default btn-xs" course-data-id="{{$row->id}}" title="" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#sale_modal" onclick="loadcoursedetail({{$row->id}},'{{$row->title}}')" data-original-title="View" autocomplete="off"><i class="fa fa-reorder"></i> 
                                            </button> -->
                                        
                                        </td>
                                                    @endif
                                        </tr>
                                        @else
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td><a href="{{url('student/view/')}}/{{$row->id}}">{{$row->firstname}} {{$row->lastname}}</a></td>
                                            <td>{{$row->email}}</td>
                                            <td>{{$row->mobileno}}</td>
                                            <td>{{$row->cdate}}</td>
                                            <td>{{$row->type?'Online':'Offline'}}</td>
                                            <td>{{$row->status?'Disabled':'Active'}}</td>
                                        </tr>
                                        @endif
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

    <div class="modal fade" id="sale_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="box-title"><span id="coursename_model"></span></h4>
                </div>

                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" id="">
                                <div class="pb10 ptt10">
                                    <div class="download_label"></div>

                                    <div class="table-responsive mailbox-messages" id="sale_data">

                                    </div>

                                </div><!-- /.box-body -->
                            </div>
                            <!--./col-md-12-->
                        </div>
                        <!--./row-->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function loadcoursedetail(courseid, coursename) {
            $('#sale_data').html('');
            $('#coursename_model').html('');
            $.ajax({
                url: "{{url('ajax/selldata')}}",
                type: 'get',
                data: {
                    courseid: courseid,
                    coursename: coursename
                },
                success: function(data) {
                    $('#sale_data').html(data);
                    $('#coursename_model').html(coursename);
                }
            });
        }
    </script>

    @include('admin.include.footer')