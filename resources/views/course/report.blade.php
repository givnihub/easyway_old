@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    @include('admin.include.header')
    @include('admin.include.sidebar')

    <div class="content-wrapper">
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
            @if(Request::segment('4'))
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box removeboxmius">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-search"></i> Student Course Purchase Report</h3>
                        </div>

                        <form id="form1" action="" method="post">
                            <div class="box-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Search Type<small class="req"> *</small></label>
                                            <select class="form-control" id="search_type" name="search_type">

                                                <option value="">Select</option>
                                                <option value="today" @if($search_type=='today' ) selected @endif>Today</option>
                                                <option value="this_week" @if($search_type=='this_week' ) selected @endif>This Week</option>
                                                <option value="last_week" @if($search_type=='last_week' ) selected @endif>Last Week</option>
                                                <option value="this_month" @if($search_type=='this_month' ) selected @endif>This Month</option>
                                                <option value="last_month" @if($search_type=='last_month' ) selected @endif>Last Month</option>
                                                <option value="last_3_month" @if($search_type=='last_3_month' ) selected @endif>Last 3 Months</option>
                                                <option value="last_6_month" @if($search_type=='last_6_month' ) selected @endif>Last 6 Months</option>
                                                <option value="last_12_month" @if($search_type=='last_12_month' ) selected @endif>Last 12 Months</option>
                                                <option value="this_year" @if($search_type=='this_year' ) selected @endif>This Year</option>
                                                <option value="last_year" @if($search_type=='last_year' ) selected @endif>Last Year</option>
                                                <option value="period" @if($search_type=='period' ) selected @endif>Period</option>
                                            </select>
                                            <span class="text-danger" id="error_search_type"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Type<small class="req"> *</small></label>
                                            <select class="form-control" name="payment_type">

                                                <option value="all" @if($payment_type=='all' ) selected @endif>All</option>
                                                <option value="Online" @if($payment_type=='Online' ) selected @endif>Online</option>
                                                <option value="Offline" @if($payment_type=='Offline' ) selected @endif>Offline</option>
                                            </select>
                                            <span class="text-danger" id="error_payment_type"></span>
                                        </div>
                                    </div>
                                    <div id="date_result" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date From<small class="req"> *</small></label>
                                                <input type="date" class="form-control" value="{{$date_from}}" name="date_from">


                                                <span class="text-danger" id="error_payment_type"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date To<small class="req"> *</small></label>
                                                <input type="date" class="form-control"value="{{$date_to}}"  name="date_to">


                                                <span class="text-danger" id="error_payment_type"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="box-body">
                            <div class="row" style="overflow:scroll">
                                <div class="download_label">Student Course Purchase Report</div>
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>

                                            <th>Student</th>
                                            <th>Contact</th>
                                            <th>Date</th>
                                            <th>Course</th>
                                         
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Price (₹)</th>
                                            <th>Discount</th>
                                            <th>Commission (3%) (₹)</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_amount=0;
                                        $commission=0;
                                        ?>
                                        @foreach($student_course as $row)
                                        <tr>
                                            
                                            <td><a href="{{url('student/view')}}/{{$row->studentid}}">{{$row->firstname}} {{$row->lastname}} </a></td>
                                            <td>{{$row->contact}} </td>
                                            <td>{{date('d-m-Y',strtotime($row->cdate))}}</td>
                                            <td>{{$row->title}}</td>
                                        
                                            <td>Online</td>
                                            <td>{{$row->status}}</td>
                                            <td>{{number_format($row->amount,2)}}</td>
                                            <td>{{$row->discount}}</td>
                                            <td>{{$comm=(3/100)*($row->amount-$row->discount)}}</td>
                                                @php 
                                                    $total_amount+=($row->amount-$row->discount);
                                                    $commission+=$comm;
                                                @endphp

                                        </tr>
                                        @endforeach
                                    </tbody>

                                    
                                </table>
                                <p class="btn btn-danger">
                                    Total Income = {{$total_amount}}
                                    
                                </p>
                                <p class="btn btn-danger">Total Commission = {{$commission}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>
    <script>
        $(document).ready(function() {
            let type = $('#search_type').val();
            if (type == 'period') {
                $('#date_result').show();
            } else {
                $('#date_result').hide();
            }
        });
        $('#search_type').on('change', function() {
            let type = $(this).val();

            if (type == 'period') {
                $('#date_result').show();
            } else {
                $('#date_result').hide();
            }
        });
    </script>
    @include('admin.include.footer')