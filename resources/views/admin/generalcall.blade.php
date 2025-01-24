@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')


        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-ioxhost"></i> Front Office
            </section>
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
                    <div class="col-md-4">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Phone Call Log</h3>
                            </div><!-- /.box-header -->

                            <form id="form1" action="{{url('admin/generalcall')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$res->id}}" name="id">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" value="{{$res->name}}" name="name">

                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Phone</label><small class="req"> *</small>
                                        <input type="text" class="form-control" value="{{$res->contact}}" name="contact">
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Date</label>
                                        <input id="date" name="date" placeholder="" type="date" class="form-control" value="{{$res->date}}" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{$res->description}}</textarea>

                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="pwd">Next Follow Up Date</label> <input id="follow_up_date" name="follow_up_date" placeholder="" type="date" class="form-control" value="{{$res->follow_up_date}}" />
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Call Duration</label>
                                        <input type="text" class="form-control" value="{{$res->call_dureation}}" name="call_dureation">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Note</label>
                                        <textarea class="form-control" id="description" name="note" name="note" rows="3">{{$res->note}}</textarea>
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Call Type</label>

                                        <small class="req"> *</small>

                                        <label class="radio-inline"><input type="radio" name="call_type" value="Incoming" @if($res->call_type=='Incoming') checked @endif> Incoming</label>

                                        <label class="radio-inline"><input type="radio" name="call_type" value="Outgoing" @if($res->call_type=='Outgoing') checked @endif> Outgoing</label>


                                        <span class="text-danger"></span>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/.col (right) -->
                    <!-- left column -->
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Phone Call Log List</h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="mailbox-messages table-responsive">

                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th>Name </th>
                                                <th>Phone </th>
                                                <th>Date </th>
                                                <th>Next Follow Up Date</th>
                                                <th>Call Type </th>
                                                <th class="text-right noExport ">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <tr>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->contact}}</td>
                                                <td>{{$row->date}}</td>
                                                <td>{{$row->follow_up_date}}</td>
                                                <td>{{$row->call_type}}</td>
                                                <td class=" dt-body-right">
                                                    @php
                                                    $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
                                                    $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
                                                    $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
                                                    $can_delete= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_delete", "1")->count();

                                                    @endphp
                                                    @if($can_view>0) <a data-placement="left" onclick="getRecord('{{$row->name}}','{{$row->contact}}','{{$row->date}}','{{$row->follow_up_date}}','{{$row->call_duration}}','{{$row->description}}','{{$row->note}}','{{$row->call_type}}')" class="btn btn-default btn-xs" data-target="#calldetails" data-toggle="modal" title="" data-original-title="View"><i class="fa fa-reorder"></i></a>
                                                    @endif
                                                    @if($can_edit>0)
                                                    <a href="{{url('admin/generalcall?id=')}}{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    @endif
                                                    @if($can_delete>0)
                                                    <a onclick="return confirm('Delete Confirm ?')" href="{{url('admin/generalcall?delid=')}}{{$row->id}}" class="btn btn-default btn-xs" data-placement="left" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a></td>

                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!-- /.table -->

                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->

                    <!-- right column -->

                </div>

            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- new END -->
        <div id="calldetails" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog2 modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Details</h4>
                    </div>
                    <div class="modal-body" id="getdetails">


                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.content-wrapper -->

    <script type="text/javascript">
        function getRecord(name, contact, date, follow_date, duration, description, note, call_type) {

            $('#getdetails').html(` <table class="table table-striped">     
    <tbody><tr>
        <th class="border0">Name</th>
        <td class="border0">${name}</td>
        <th class="border0">Phone</th>
        <td class="border0"> ${contact}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>${date}</td>
        <th>Next Follow Up Date</th>
        <td>${follow_date}</td>
    </tr>
    <tr>
        <th>Call Duration</th>
        <td>${duration}</td>
        <th>Call Type</th>
        <td>${call_type}</td>
    </tr>       
    <tr>
        <th>Description</th>
        <td>${description}</td>
        <th>Note</th>
        <td>${note}</td>
    </tr>   
</tbody></table>`);

        }
    </script>

    @include('admin.include.footer');