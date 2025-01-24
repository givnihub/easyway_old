@include('admin.include.head');
    <body class="hold-transition skin-blue fixed sidebar-mini">


       <div class="wrapper">

            @include('admin.include.header');
            @include('admin.include.sidebar');
     

 
<style type="text/css">
    .borderwhite{border-top-color: #fff !important;}
    .box-header>.box-tools {display: none;}
    .sidebar-collapse #barChart{height: 100% !important;}
    .sidebar-collapse #lineChart{height: 100% !important;}
</style>
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content">
        <div class="">

            
            
        </div>
        <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-money ftlayer"></i>Fees Awaiting Payment<span class="pull-right">0/0</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->

                    
                                <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-ioxhost ftlayer"></i> Converted Leads<span class="pull-right">0/0</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-red" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="topprograssstart">
                        <p class="text-uppercase mt5 clearfix"><i class="fa fa-calendar-check-o ftlayer"></i>Staff Present Today<span class="pull-right">0/20</span>
                        </p>
                        <div class="progress-group">
                            <div class="progress progress-minibar">
                                <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                            </div>
                        </div>
                    </div><!--./topprograssstart-->
                </div><!--./col-md-3-->
                

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="topprograssstart">
                            <p class="text-uppercase mt5 clearfix"><i class="fa fa-calendar-check-o ftlayer"></i>Student Present Today<span class="pull-right"> 0/3572</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->
                    </div><!--./col-md-3-->
                        </div><!--./row-->


        <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col60">

                        <div class="box box-primary borderwhite">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fees Collection & Expenses For November 2022</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="barChart" height="95"></canvas>
                                </div>
                            </div>

                        </div>

                    </div><!--./col-lg-7-->
                                                <div class="col-lg-5 col-md-5 col-sm-12 col40">

                        <div class="box box-primary borderwhite">
                            <div class="box-header with-border"><h3 class="box-title">Income - November 2022</h3></div>


                            <div class="box-body">
                                <div class="chart-responsive">
                                    <canvas id="doughnut-chart" class="" height="148"></canvas>
                                </div>
                            </div>

                        </div><!--./col-md-6-->

                    </div><!--./col-lg-5-->
            </div><!--./row-->

        <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col60">

                        <div class="box box-info borderwhite">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fees Collection & Expenses For Session 2021-22</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="lineChart" height="95"></canvas>
                                </div>
                            </div>

                            <!--  <div class="box-body">
                                 <div class="chart">
                                     <canvas id="lineChart" style="height: 233px; width: 100%; white-space: nowrap;"></canvas>
                                 </div>
                             </div> -->
                        </div>

                    </div><!--./col-lg-7-->
                                            <div class="col-lg-5 col-md-5 col-sm-12 col40">
                        <div class="box box-primary borderwhite">
                            <div class="box-header with-border"><h3 class="box-title">Expense - November 2022</h3>
                            </div><!--./info-box-->

                            <div class="box-body">
                                <div class="chart-responsive">
                                    <canvas id="doughnut-chart1" class="" height="148"></canvas>
                                </div>
                            </div>
                         <!--  <div class="full-width-chart"><canvas id="doughnut-chart1" style="height: 340px; width: 100%; white-space: nowrap;"></canvas></div> -->

                        </div>
                    </div><!--./col-lg-5-->
            </div><!--./row-->




        <div class="row">


                    <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10">Fees Overview</h5>
                            <p class="text-uppercase mt10 clearfix">0 Unpaid<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Partial<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Paid<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-aqua" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->
                            <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10"> Enquiry Overview</h5>
                            <p class="text-uppercase mt10 clearfix">0 Active<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-red" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Won<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Passive<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Lost<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>
                            <p class="text-uppercase mt10 clearfix">0 Dead<span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->

        

                    <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10"> Library Overview</h5>
                            <p class="text-uppercase mt10 clearfix">0 Due For Return<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Returned<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix"> Issued out of <span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix">0 Available out of <span class="pull-right">0%</span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar progress-bar-green" style="width: 0%"></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->


                            <div class="col-md-3 col-sm-6">

                        <div class="topprograssstart">
                            <h5 class="pro-border pb10"> Student Today Attendance</h5>

                            <p class="text-uppercase mt10 clearfix"> Present<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>

                            <p class="text-uppercase mt10 clearfix"> Late<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                            <p class="text-uppercase mt10 clearfix"> Absent<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                            <p class="text-uppercase mt10 clearfix"> Half Day<span class="pull-right"></span>
                            </p>
                            <div class="progress-group">
                                <div class="progress progress-minibar">
                                    <div class="progress-bar" style="width: "></div>
                                </div>
                            </div>
                        </div><!--./topprograssstart-->

                    </div><!--./col-md-3-->
                    

            <div class="row">

                <div class="col-lg-9 col-md-9 col-sm-12 col80">
                    <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="info-box">
                                        <a href="{{url('')}}/studentfee">
                                            <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Monthly Fees Collection</span>
                                                <span class="info-box-number">₹0</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
    
                                <div class="col-md-4 col-sm-6">
                                    <div class="info-box">
                                        <a href="{{url('')}}/admin/expense">
                                            <span class="info-box-icon bg-red"><i class="fa fa-credit-card"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Monthly Expenses</span>
                                                <span class="info-box-number">₹0</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
    

                            <div class="col-md-4 col-sm-6">
                                <div class="info-box">
                                    <a href="{{url('')}}/student/search">
                                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Student</span>
                                            <span class="info-box-number">3572</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                    </div>


                        <div class="box box-primary borderwhite">
                            <div class="box-body">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /. box -->
                    
                </div><!--./col-lg-9-->

                    <div class="col-lg-3 col-md-3 col-sm-12 col20">

                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Admin</span>
                                        <span class="info-box-number">1</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Teacher</span>
                                        <span class="info-box-number">8</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Accountant</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Librarian</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Counsellor</span>
                                        <span class="info-box-number">1</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Super Admin</span>
                                        <span class="info-box-number">3</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Student</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Affliate</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">DEO</span>
                                        <span class="info-box-number">5</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Online Counsellor</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </a>
                            </div>
                                <div class="info-box">
                                <a href="#">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Blogger</span>
                                        <span class="info-box-number">2</span>
                                    </div>
                                </a>
                            </div>
    


                    </div><!--./col-lg-3-->
            </div><!--./row-->








        </div><!--./row-->


</div>
<div id="newEventModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Event</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"  id="addevent_form" method="post" enctype="multipart/form-data" action="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Title</label><small class="req"> *</small>
                            <input class="form-control" name="title" id="input-field">
                            <span class="text-danger"></span>

                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" class="form-control" id="desc-field"></textarea></div>
                     <div class="row">

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Event From</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="event_from" class="form-control pull-right event_from">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Event To</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="event_to" class="form-control pull-right event_to">
                            </div>
                        </div>
                            </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Color</label>
                            <input type="hidden" name="eventcolor" autocomplete="off" id="eventcolor" class="form-control">
                        </div>
                        <div class="form-group col-md-12">

                            <div class="cpicker-wrapper"><div class='calendar-cpicker cpicker cpicker-big' data-color='#03a9f4' style='background:#03a9f4;border:1px solid #03a9f4; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#c53da9' style='background:#c53da9;border:1px solid #c53da9; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#757575' style='background:#757575;border:1px solid #757575; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#8e24aa' style='background:#8e24aa;border:1px solid #8e24aa; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#d81b60' style='background:#d81b60;border:1px solid #d81b60; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#7cb342' style='background:#7cb342;border:1px solid #7cb342; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#fb8c00' style='background:#fb8c00;border:1px solid #fb8c00; border-radius:100px'></div><div class='calendar-cpicker cpicker cpicker-small' data-color='#fb3b3b' style='background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px'></div></div>                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Type</label>
                            <br/>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="public" id="public">Public                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="private" checked id="private">Private                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="sameforall" id="public">All Super Admin                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="event_type" value="protected" id="public">Protected                            </label> </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input type="submit" class="btn btn-primary submit_addevent pull-right" value="Save"></div> </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="viewEventModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Event</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"   method="post" id="updateevent_form"  enctype="multipart/form-data" action="" >
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">EventTitle</label>
                            <input class="form-control" name="title" placeholder="" id="event_title">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" class="form-control" placeholder="" id="event_desc"></textarea></div>
                      <div class="row">

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Event From</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="event_from" class="form-control pull-right event_from">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Event To</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" autocomplete="off" name="event_to" class="form-control pull-right event_to">
                            </div>
                        </div>
                            </div>
                        <input type="hidden" name="eventid" id="eventid">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">EventColor</label>
                            <input type="hidden" name="eventcolor" autocomplete="off" placeholder="Event Color" id="event_color" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            
                            <div class="cpicker-wrapper selectevent"><div id=03a9f4 class='calendar-cpicker cpicker cpicker-big' data-color='#03a9f4' style='background:#03a9f4;border:1px solid #03a9f4; border-radius:100px'></div><div id=c53da9 class='calendar-cpicker cpicker cpicker-small' data-color='#c53da9' style='background:#c53da9;border:1px solid #c53da9; border-radius:100px'></div><div id=757575 class='calendar-cpicker cpicker cpicker-small' data-color='#757575' style='background:#757575;border:1px solid #757575; border-radius:100px'></div><div id=8e24aa class='calendar-cpicker cpicker cpicker-small' data-color='#8e24aa' style='background:#8e24aa;border:1px solid #8e24aa; border-radius:100px'></div><div id=d81b60 class='calendar-cpicker cpicker cpicker-small' data-color='#d81b60' style='background:#d81b60;border:1px solid #d81b60; border-radius:100px'></div><div id=7cb342 class='calendar-cpicker cpicker cpicker-small' data-color='#7cb342' style='background:#7cb342;border:1px solid #7cb342; border-radius:100px'></div><div id=fb8c00 class='calendar-cpicker cpicker cpicker-small' data-color='#fb8c00' style='background:#fb8c00;border:1px solid #fb8c00; border-radius:100px'></div><div id=fb3b3b class='calendar-cpicker cpicker cpicker-small' data-color='#fb3b3b' style='background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px'></div></div>                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">EventType</label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="public" id="public">Public                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="private" id="private">Private                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="sameforall" id="public">All Super Admin                            </label>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="protected" id="public">Protected                            </label>
                        </div>

                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">

                            <input type="submit" class="btn btn-primary submit_update pull-right" value="Save">
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                <input type="button" id="delete_event" class="btn btn-primary submit_delete pull-right" value="Delete">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- <script src="{{url('')}}/backend/js/Chart.min.js"></script>
<script src="{{url('')}}/backend/js/utils.js"></script> -->
<script type="text/javascript">
     new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
            data: {
            labels: [ ],
                    datasets: [
                    {
                    label: "Income",
                            backgroundColor: [ ],
                            data: []
                    }
                    ]
            },
            options: {
            responsive: true,
                    circumference: Math.PI,
                    rotation: - Math.PI,
                    legend: {
                    position: 'top',
                    },
                    title: {
                    display: true,
                    },
                    animation: {
                    animateScale: true,
                            animateRotate: true
                    }
            }
    });
        new Chart(document.getElementById("doughnut-chart1"), {
    type: 'doughnut',
            data: {
            labels: [],
                    datasets: [
                    {
                    label: "Population (millions)",
                            backgroundColor: [],
                            data: []
                    }
                    ]
            },
            options: {
            responsive: true,
                    circumference: Math.PI,
                    rotation: - Math.PI,
                    legend: {
                    position: 'top',
                    },
                    title: {
                    display: true,
                    },
                    animation: {
                    animateScale: true,
                            animateRotate: true
                    }
            }
    });
        $(function () {
        var areaChartOptions = {
        showScale: true,
                scaleShowGridLines: false,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                bezierCurve: true,
                bezierCurveTension: 0.3,
                pointDot: false,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                maintainAspectRatio: true,
                responsive: true
        };
        var bar_chart = "1";
        var line_chart = "1";
                 if (line_chart) {


        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        var yearly_collection_array = ["0.00","0.00","0.00","0.00",500,"0.00",6370,"0.00",195660,26630,96600,92600];
        var yearly_expense_array = [0,0,0,0,0,0,0,0,0,4200,42000,0];
        var total_month = ["Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar"];
        var areaChartData_expense_Income = {
        labels: total_month,
                datasets: [
                {
                label: "Expense",
                        fillColor: "rgba(215, 44, 44, 0.7)",
                        strokeColor: "rgba(215, 44, 44, 0.7)",
                        pointColor: "rgba(233, 30, 99, 0.9)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: yearly_expense_array
                },
                {
                label: "Collection",
                        fillColor: "rgba(102, 170, 24, 0.6)",
                        strokeColor: "rgba(102, 170, 24, 0.6)",
                        pointColor: "rgba(102, 170, 24, 0.9)",
                        pointStrokeColor: "rgba(102, 170, 24, 0.6)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: yearly_collection_array
                }
                ]
        };
        lineChart.Line(areaChartData_expense_Income, lineChartOptions);
        }

        var current_month_days = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30"];
        var days_collection = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        var days_expense = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        var areaChartData_classAttendence = {
        labels: current_month_days,
                datasets: [
                {
                label: "Electronics",
                        fillColor: "rgba(102, 170, 24, 0.6)",
                        strokeColor: "rgba(102, 170, 24, 0.6)",
                        pointColor: "rgba(102, 170, 24, 0.6)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: days_collection
                },
                {
                label: "Digital Goods",
                        fillColor: "rgba(233, 30, 99, 0.9)",
                        strokeColor: "rgba(233, 30, 99, 0.9)",
                        pointColor: "rgba(233, 30, 99, 0.9)",
                        pointStrokeColor: "rgba(233, 30, 99, 0.9)",
                        pointHighlightFill: "rgba(233, 30, 99, 0.9)",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: days_expense
                }
                ]
        };
                 if (bar_chart) {
             var current_month_days = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30"];
        var days_collection = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        var days_expense = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        var areaChartData_classAttendence = {
        labels: current_month_days,
                datasets: [
                {
                label: "Electronics",
                        fillColor: "rgba(102, 170, 24, 0.6)",
                        strokeColor: "rgba(102, 170, 24, 0.6)",
                        pointColor: "rgba(102, 170, 24, 0.6)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: days_collection
                },
                {
                label: "Digital Goods",
                        fillColor: "rgba(233, 30, 99, 0.9)",
                        strokeColor: "rgba(233, 30, 99, 0.9)",
                        pointColor: "rgba(233, 30, 99, 0.9)",
                        pointStrokeColor: "rgba(233, 30, 99, 0.9)",
                        pointHighlightFill: "rgba(233, 30, 99, 0.9)",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: days_expense
                }
                ]
        };
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData_classAttendence;
        barChartData.datasets[1].fillColor = "rgba(233, 30, 99, 0.9)";
        barChartData.datasets[1].strokeColor = "rgba(233, 30, 99, 0.9)";
        barChartData.datasets[1].pointColor = "rgba(233, 30, 99, 0.9)";
        var barChartOptions = {
        scaleBeginAtZero: true,
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: false,
                scaleShowVerticalLines: false,
                barShowStroke: true,
                barStrokeWidth: 2,
                barValueSpacing: 5,
                barDatasetSpacing: 1,
                responsive: true,
                maintainAspectRatio: true
        };
        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
        }
                 });
    

    $(document).ready(function () {

    $(document).on('click', '.close_notice', function () {
    var data = $(this).data();
    $.ajax({
    type: "POST",
            url: base_url + "admin/notification/read",
            data: {'notice': data.noticeid},
            dataType: "json",
            success: function (data) {
            if (data.status == "fail") {

            errorMsg(data.msg);
            } else {
            successMsg(data.msg);
            }

            }
    });
    });
    });
</script>
@include('admin.include.footer');