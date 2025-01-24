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
        <link rel="stylesheet" type="text/css" href="{{asset('public/backend/dist/css/course_addon.css')}}">
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <span id="message"></span>
                        <div class="box box-primary">
                            <div class="box-header with-border pb0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <h3 class="box-title header_tab_style">Students List</h3>
                                    </div>
                         
                                </div>
                            </div>
                            <div id="course_detail_tab" class="tabcontent">
                                <section class="content">


                                    <div class="box-body">
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
                                                <div class="tab-pane active table-responsive no-padding">



                                                    <table class="table table-striped table-bordered table-hover example">
                                                        <thead>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Purchased Date</th>
                                                            <th>Method</th>
                                                            <th>Status</th>
                                                           
                                                        </thead>
                                                        <tbody>
                                                            @foreach($list as $run)
                                                            
                                                            <tr>
                                                                <td><?= $run->id ?></span>
                                                                </td>
                                                                <td><?= $run->firstname ?> </td>
                                                                
                                                                <td><?= date('d-m-Y H:i:s',strtotime($run->cdate)) ?> </td>
                                                                <td><?= $run->method ?> </td>
                                                                <td><?= $run->status ?> </td>
                                                               
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!--./col-lg-3-->

                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.position').on('change', function() {
                let id = $(this).attr('data-id');
                let position = $(this).val();
                let table = 'courses';
                $.ajax({
                    type: "GET",
                    url: "{{url('admin/position')}}",
                    data: {
                        id: id,
                        position: position,
                        table: table
                    },
                    success: function(data) {
                        $('#message').html(data);
                    },

                });
            });
            $('#course_detail_tab').show();

        });
    </script>

    @include('admin.include.footer');