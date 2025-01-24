@include('admin.include.head')

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
        <style type="text/css">
            .checked {
                color: orange;
            }
        </style>
        <div class="content-wrapper" style="min-height: 946px;">
            <section class="content-header">
                <h1>
                    <i class="fa fa-user-secret"></i> Teachers</h1>
            </section>
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
                    </div>
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"> Teachers Reviews</h3>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive mailbox-messages">
                                    <div class="download_label">Teachers Reviews</div>

                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th>Teacher Name</th>
                                                
                                                <th>Email</th>
                                                <th>Comment</th>

                                                <th class="text-right">My Rating</th>
                                                <th class="text-center">Rate</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                             @foreach($list as $run)
                                             @php  
                                             
                                             $rating=DB::table("staff_rating")->where('staff_id',$run->id)->where("user_id",$student_id)->first();
                                             
                                         
                                             @endphp
                                            <tr>
                                                <td class="mailbox-name" style="text-transform: uppercase;">{{$run->name}} {{$run->surname}} ({{$run->employee_id}}) <span class="label label-success bolds">Teacher</span></td>
                                                
                                                <td class="mailbox-name">{{$run->email}}</td>
                                                <td>{{$rating->comment}}</td>
                                                <td>
                                                    <center>
                                                        @for($i=0;$i<$rating->rate;$i++)

                                                        
                                                        <span class="fa fa-star" style="color:orange;"></span>
                                                        @endfor
                                                        </h3>
                                                    </center>



                                                </td>

                                                <td class="text-right">
                                             
                                                    @if($rating->rate<=0)
                                                    @if($can_add>0)
                                                <a class="btn btn-default btn-xs" onclick="rating('{{$run->id}}')" data-placement="left" data-toggle="tooltip" title="" data-original-title="Add"><i class="fa fa-plus"></i></a>
                                           @endif
                                                @endif    
                                            </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="mailbox-controls">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="myModal" class="modal fade in" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog2">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Rate</h4>
                    </div>
                    <form id="sendform" action="" name="employeeform" class="" method="post" accept-charset="utf-8">
                        <div class="modal-body">
@csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="pwd">Rating<small class="req"> *</small></label>
                                        <span onclick="rate('1')" id='rate1' class="fa fa-star"></span>
                                        <span onclick="rate('2')" id='rate2' class="fa fa-star"></span>
                                        <span onclick="rate('3')" id='rate3' class="fa fa-star"></span>
                                        <span onclick="rate('4')" id='rate4' class="fa fa-star"></span>
                                        <span onclick="rate('5')" id='rate5' class="fa fa-star"></span>



                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="pwd">Comment<small class="req"> *</small></label>
                                        <input type="text" autocomplete="off" class="form-control" value="" name="comment">
                                        <input type="hidden" autocomplete="off" class="form-control" id="rate" name="rate">
                                        <input type="hidden" autocomplete="off" class="form-control" value="student" name="role">
                                        <input type="hidden" autocomplete="off" class="form-control" value="student" id="staff_id" name="staff_id">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info pull-right">Save</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $('#rate1').hover(
            function() {
                $("#rate1").attr("style", "color:#f1b624f0;");
            }
        );
        $('#rate2').hover(
            function() {
                $("#rate2").attr("style", "color:#f1b624f0;");
            }
        );
        $('#rate3').hover(
            function() {
                $("#rate3").attr("style", "color:#f1b624f0;");
            }
        );
        $('#rate4').hover(
            function() {
                $("#rate4").attr("style", "color:#f1b624f0;");
            }
        );
        $('#rate5').hover(
            function() {
                $("#rate5").attr("style", "color:#f1b624f0;");
            }
        );

        function rating(id) {
            for (i = 1; i <= 5; i++) {
                $("#rate" + i).attr("style", "color:none;");
            }
            $('#myModal').modal('show');
            $('#staff_id').val(id);
        }

        function rate(val) {

            $('#rate').val(val);

            for (i = 1; i <= 5; i++) {
                $("#rate" + i).attr("style", "color:none;");
            }

            for (i = 1; i <= val; i++) {
                $("#rate" + i).attr("style", "color:#f1b624f0;");
            }

        }

        // $(document).ready(function(e) {
        //     $("#sendform").on('submit', (function(e) {
        //         e.preventDefault();
        //         $.ajax({
        //             url: '{{url("user/teacher/rating")}}',
        //             type: "POST",
        //             data: new FormData(this),
        //             dataType: 'json',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success: function(data) {
        //                 if (data.status == "fail") {
        //                     var message = "";
        //                     $.each(data.error, function(index, value) {
        //                         message += value;
        //                     });
        //                     errorMsg(message);
        //                 } else {
        //                     successMsg(data.message);
        //                     window.location.reload(true);
        //                 }
        //             },
        //             error: function() {

        //             }
        //         });
        //     }));
        // });
    </script>

    @include('admin.include.footer')