@include('admin.include.head')
    <body class="hold-transition skin-blue fixed sidebar-mini">


 
       <div class="wrapper">
 
           @include('admin.include.header')
           @include('admin.include.sidebar')
           
          
 
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-calendar"></i> Calendar</h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-9 col-sm-9">
                    <div class="box box-primary">
                        <div class="box-body">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="box box-primary">
                        <div class="box-header ptbnull">
                            <h3 class="box-title">To Do List</h3>
                            <div class="box-tools pull-right">
                                
                                    <button class="btn btn-primary btn-sm pull-right" onclick="add_task()"><i class="fa fa-plus"></i></button>
                                                            </div>
                        </div>
                        <div class="">
                                                        <div class="todopagination"></div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>


<div id="newTask" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title" >Add To Do</h4>
            </div>
            <div class="modal-body pb0">

                <div class="row">
                    <form role="form"  id="addtodo_form" method="post" enctype="multipart/form-data" action="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Title<small class="req"> *</small></label>
                            <input class="form-control" name="task_title"  id="task-title"> 
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Date<small class="req"> *</small></label>
                            <input class="form-control" type="text" autocomplete="off"  name="task_date" placeholder="Date" id="task-date">
                            <input class="form-control" type="hidden" name="eventid" id="taskid">
                        </div>
                        <div class="row">
                            <div class="box-footer clearboth" id="permission">
                                    <input type="submit" class="btn btn-primary submit_addtask pull-right" value="Save">
                                                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>  

<div id="newEventModal" class="modal fade " role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Event</h4>
            </div>
            <div class="modal-body pb0"> 

                <div class="row"> 
                    <form role="form" id="addevent_form" method="post" enctype="multipart/form-data" action="">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Title <small class="req"> *</small></label>
                            <input class="form-control" name="title" id="input-field"> 
                            <span class="text-danger"></span>

                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Description</label>
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
                                                    <div class="row">
                                <div class="box-footer clearboth"> 
                                    <input type="submit" class="btn btn-primary submit_addevent pull-right" value="Save"></div>
                            </div>  
                                            </form>
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
                <h4 class="modal-title">View Event</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <form role="form"   method="post" id="updateevent_form"  enctype="multipart/form-data" action="" >
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Title <small class="req"> *</small></label>
                            <input class="form-control" name="title" placeholder="Event Title" id="event_title"> 
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Description</label>
                            <textarea name="description" class="form-control" placeholder="Event Description" id="event_desc"></textarea>
                        </div>
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
                            <label for="exampleInputEmail1">Event Color</label>
                            <input type="hidden" name="eventcolor" autocomplete="off" placeholder="Event Color" id="event_color" class="form-control">
                        </div>
                        <div class="form-group col-md-12">

                            <div class="cpicker-wrapper selectevent"><div id=03a9f4 class='calendar-cpicker cpicker cpicker-big' data-color='#03a9f4' style='background:#03a9f4;border:1px solid #03a9f4; border-radius:100px'></div><div id=c53da9 class='calendar-cpicker cpicker cpicker-small' data-color='#c53da9' style='background:#c53da9;border:1px solid #c53da9; border-radius:100px'></div><div id=757575 class='calendar-cpicker cpicker cpicker-small' data-color='#757575' style='background:#757575;border:1px solid #757575; border-radius:100px'></div><div id=8e24aa class='calendar-cpicker cpicker cpicker-small' data-color='#8e24aa' style='background:#8e24aa;border:1px solid #8e24aa; border-radius:100px'></div><div id=d81b60 class='calendar-cpicker cpicker cpicker-small' data-color='#d81b60' style='background:#d81b60;border:1px solid #d81b60; border-radius:100px'></div><div id=7cb342 class='calendar-cpicker cpicker cpicker-small' data-color='#7cb342' style='background:#7cb342;border:1px solid #7cb342; border-radius:100px'></div><div id=fb8c00 class='calendar-cpicker cpicker cpicker-small' data-color='#fb8c00' style='background:#fb8c00;border:1px solid #fb8c00; border-radius:100px'></div><div id=fb3b3b class='calendar-cpicker cpicker cpicker-small' data-color='#fb3b3b' style='background:#fb3b3b;border:1px solid #fb3b3b; border-radius:100px'></div></div>                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Event Type</label><br/>
                            <label class="radio-inline">

                                <input type="radio" name="eventtype" value="public" id="public">Public                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="eventtype" value="private" id="private">Private                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="eventtype" value="sameforall" id="public">All Super Admin                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="eventtype" value="protected" id="public">Protected 
                            </label>
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
<!-- Page specific script -->
<script>
    $(document).ready(function () {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var date_format = 'dd.mm.yyyy';

        $('#task-date').datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true,
             weekStart : start_week
        }).datepicker('setDate', today);
    });

    function add_task() {
        $("#modal-title").html("Add Task");
        $("#task-title").val('');
        $("#taskid").val('');
        $('#newTask').modal('show');
        $('#task-date').datepicker('setDate', today);
    }

    function edit_todo_task(eventid) {
        $.ajax({
            url: "{{url('')}}/admin/calendar/gettaskbyid/" + eventid,
            type: "POST",
            data: {eventid: eventid},
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (res)
            {
                $("#modal-title").html("Edit Task");
                $("#task-title").val(res.event_title);
                $("#taskid").val(eventid);
                dt = new Date(res.start_date)
                var dat = new Date(dt.getFullYear(), dt.getMonth(), dt.getDate());
                $("#task-date").datepicker('update', dat);
                $('#newTask').modal('show');
                $('#permission').html('<input type="submit" class="btn btn-primary submit_addtask pull-right" value="Save">');

                            }
                        });
                    }

                    $(document).ready(function (e) {
                        $("#addtodo_form").on('submit', (function (e) {
                            e.preventDefault();
                            $.ajax({
                                url: "{{url('')}}/admin/calendar/addtodo",
                                type: "POST",
                                data: new FormData(this),
                                dataType: 'json',
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (res)
                                {
                                    if (res.status == "fail") {
                                        var message = "";
                                        $.each(res.error, function (index, value) {
                                            message += value;
                                        });
                                        errorMsg(message);
                                    } else {
                                        successMsg(res.message);
                                        window.location.reload(true);
                                    }
                                }
                            });

                        }));
                    });

                    function complete_event(id, status) {
                        $.ajax({
                            url: "{{url('')}}/admin/calendar/markcomplete/" + id,
                            type: "POST",
                            data: {id: id, active: status},
                            dataType: 'json',
                            success: function (res)
                            {
                                if (res.status == "fail") {
                                    var message = "";
                                    $.each(res.error, function (index, value) {
                                        message += value;
                                    });
                                    errorMsg(message);
                                } else {
                                    successMsg(res.message);
                                    window.location.reload(true);
                                }
                            }
                        });
                    }

                    function markcomplete(id) {
                        $('#check' + id).change(function () {
                            if (this.checked) {
                                complete_event(id, 'yes');
                            } else {
                                complete_event(id, 'no');
                            }
                        });
                    }
</script>
@include('admin.include.footer')