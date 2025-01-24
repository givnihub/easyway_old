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
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-ioxhost"></i> Front Office</h1>
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
                                <h3 class="box-title">Add Complain</h3>
                            </div><!-- /.box-header -->

                            <form id="form1" action="{{url('admin/complaint')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" name="uid" value="{{$res->id}}">
                                        <label for="exampleInputEmail1">Complain Type</label>
                                        <select name="complaint" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($complaint_type as $row)
                                            <option value="{{$row->complaint_type}}" @if($row->complaint_type==$res->complaint_type) selected @endif>{{$row->complaint_type}}</option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger"></span>

                                    </div>

                                    <div class="form-group">

                                        <label for="pwd">Source</label>
                                        <select name="source" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($source as $row)
                                            <option value="{{$row->source}}" @if($row->source==$res->source) selected @endif>{{$row->source}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Complain By</label> <small class="req"> *</small>
                                        <input type="text" class="form-control" value="{{$res->name}}" name="name">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Phone</label>
                                        <input type="text" class="form-control" value="{{$res->contact}}" name="contact">
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="form-group">
                                            <label for="pwd">Date</label>
                                            <input type="date" class="form-control" value="{{$res->date}}" name="date" id="date">
                                            <span class="text-danger"></span>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="pwd">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{$res->description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Action Taken</label>
                                        <input type="text" class="form-control" value="{{$res->action_taken}}" name="action_taken">
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Assigned</label>
                                        <select name="assigned" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($staff as $row)
                                            <option value="{{$row->id}}" @if($row->id==$res->staff_id) selected @endif>{{$row->name}} {{$row->surname}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Note</label>
                                        <textarea class="form-control" id="description" name="note" name="note" rows="3">{{$res->note}}</textarea>
                                        <span class="text-danger"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Attach Document</label>
                                        <div><input class="filestyle form-control" type='file' name='file' />
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    @if($res->image)
                                    <img src="{{asset('public/uploads/gallery/')}}/{{$res->image}}" style="height:50px;">
                                    @endif
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
                                <h3 class="box-title titlefix">Complain List</h3>
                                <div class="box-tools pull-right">
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="download_label">Complain List</div>
                                <div class="mailbox-messages table-responsive">
                                    <table class="table table-hover table-striped table-bordered example">
                                        <thead>
                                            <tr>
                                                <th>Complain # </th>
                                                <th>Complain Type</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Date</th>
                                                <th>Assigned To</th>
                                                <th>Action Taken</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $row)
                                            <?php $rs = DB::table("staff")->where("id", $row->staff_id)->first(['name', 'surname']);

                                            $assigned_to = $rs->name . ' ' . $rs->surname;
                                            $reply = DB::table("complaint_reply")->where("complaint_id", $row->id)->orderBy("id", "desc")->first();


                                            ?>
                                            <tr>
                                                <td class="mailbox-name">{{$row->id}}</td>
                                                <td class="mailbox-name">{{$row->complaint_type}}</td>
                                                <td class="mailbox-name">{{$row->name}} </td>
                                                <td class="mailbox-name"> {{$row->contact}}</td>
                                                <td class="mailbox-name"> {{date('d-m-Y h:i:s',strtotime($row->cdate))}}</td>
                                                <td class="mailbox-name">
                                                    {{$assigned_to}}
                                                </td>
                                                <td>{{$row->action_taken}}</td>
                                                <td class="mailbox-date pull-right white-space-nowrap">
                                                    @if($can_view>0)
                                                    <a data-placement="left" onclick="getRecord('{{$row->id}}','{{$row->complaint_type}}','{{$row->source}}','{{$row->name}}','{{$row->contact}}','{{$row->description}}','{{$row->action_taken}}','{{$assigned_to}}','{{$row->note}}','{{date('d-m-Y H:i:s',strtotime($row->cdate))}}','{{$reply->reply}}','{{date('d-m-Y H:i:s',strtotime($reply->cdate))}}')" class="btn btn-default btn-xs" data-target="#complaintdetails" title="View" data-toggle="modal" data-original-title="View"><i class="fa fa-reorder"></i></a>
                                                    @endif
                                                    @if($can_view>0)
                                                    <a data-placement="left" href="{{asset('public/uploads/gallery/')}}/{{$row->image}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Download" download>
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    @endif
                                                    @if($can_edit>0)
                                                    <a data-placement="left" href="{{url('admin/complaint?uid=')}}{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit" data-original-title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    @endif
                                                    @if($can_delete>0)
                                                    <a data-placement="left" href="{{url('admin/complaint?delid=')}}{{$row->id}}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm('Delete Confirm?');" data-original-title="Delete">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                    @endif
                                                </td>


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
        <div id="complaintdetails" class="modal fade" role="dialog">
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
        function getRecord(id, complaint_type, source, name, contact, description, action_taken, assinged_to, note, cdate, reply, reply_date) {
            $('#getdetails').html(`<table class="table table-striped">
        <tbody><tr>
        <th class="border0">Complain #</th>
        <td class="border0">${id}</td>
        <th class="border0">Complain Type</th>
        <td class="border0">${complaint_type} </td>
    </tr>
    <tr>
        <th>Source</th>
        <td>${source}</td>
        <th>Name</th>
        <td>${name}</td>
    </tr>

    <tr>
        <th>Phone</th>
        <td>${contact}</td>
        <th>Date</th>
        <td>${cdate}</td>
    </tr>
    <tr>
        <th>Description</th>
        <td>${description}</td>
        <th>Action Taken</th>
        <td>${action_taken}</td>
    </tr>
    <tr>
        <th>Assigned</th>
        <td>${assinged_to}</td>
        <th>Note</th>
        <td>${note}</td>
       
    </tr>
    <tr>
        <th>Reply Date</th>
        <td>${reply_date}</td>
        <th>Reply</th>
        <td>${reply}</td>
       
    </tr>
</tbody>
</table>`);
        }
    </script>

    @include('admin.include.footer')