@include('admin.include.head');
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();
        @endphp

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Tutorial </h1>
            </section>
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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Send Pushnotification</h3>
                              
                            
                            </div><!-- /.box-header -->
                            <div class="box-body">
                             <form method="post" action="{{url('sendnotifications')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Trade Group</label><small class="req"> *</small>
                                            <select id="tradegroup" name="tradegroup" class="form-control" required>
                                                <option value="">Select Trade Group</option>
                                                <option value="all">All Students</option>
                                                @foreach($tradegroup as $run)
                                                <option value="{{$run->id}}">{{$run->name}}</option>
                                                @endforeach


                                            </select>
                                            <span class="text-danger" id="error_class_id"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Trade</label><small class="req"> *</small>
                                            <select id="trade" name="trade" class="form-control" >
                                                <option value="">Select Trade</option>
                                            </select>
                                            <span class="text-danger" id="error_section_id"></span>
                                        </div>
                                    </div>
                                        
                                        <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Title</label><small class="req"> *</small>
                                        <input type="text" name="title" placeholder="Notification Title" class="form-control">
                                        </div>
                                        </div>
                                        <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Message Body</label><small class="req"> *</small>
                                        <textarea type="text" name="message" placeholder="Notification message" class="form-control">
                                        </textarea>
                                        </div>   
                                    </div>
                                        <!-- <div class="col-lg-6">
                                        <input type="file" name="files" placeholder="select image" class="form-control">
                                        </div> -->
                                        <div class="col-lg-4" style="margin-top: 10px;">
                                        <button type="submit" class="btn btn-success">Send Notification</button>
                                        </div>
                                    </div>
                                </div>
                              
                             </form>
                              
                                
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
<script>
      $(document).on('change', '#tradegroup', function(e) {
                var tradegroup = $('#tradegroup').val();
                if (tradegroup == 'all') {
                    let type = 'online';
                    $.ajax({
                        url: "{{url('ajax/students')}}",
                        type: "GET",
                        data: {
                            tradegroup_id: tradegroup,

                            type: type,
                        },
                        dataType: 'html',
                        success: function(res) {
                            $('#student_id').empty();
                            $('#student_id').append(res);

                        }
                    });
                    exit;
                }
                $.ajax({
                    url: "{{url('ajax/gettrades')}}",
                    type: "GET",
                    data: {
                        tradegroup: tradegroup
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#trade').html(res);
                    }
                });
            });
</script>
        @include('admin.include.footer');