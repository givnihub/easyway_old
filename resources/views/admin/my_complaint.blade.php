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


                    <!-- left column -->
                    <div class="col-md-12">
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
                                                    <a data-placement="left" onclick="getRecord('{{$row->id}}','{{date('d-m-Y H:i:s',strtotime($reply->cdate))}}','{{$reply->reply}}')" class="btn btn-default btn-xs" data-target="#complaintdetails" title="View" data-toggle="modal" data-original-title="View"><i class="fa fa-reorder"></i></a>
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
                        <h4 class="modal-title">Reply your complaint</h4>
                    </div>
                    <div class="modal-body" id="getdetails">
                        <form method="post" action="{{url('admin/my-complaints')}}" class="form-group">
                            @csrf
                            <input type="hidden" value="" name="complaint_id" id="complaint_id">
                            <label>Your Reply</label>
                            <textarea class="form-control" name="reply" rows="4" required></textarea>
                            <br />
                            <button type="submit" class="btn btn-primary">Submit</button>

                            <p>Reply Date : <span id="reply_date"></span></p>

                            <p>Reply : <span id="reply"></span></p>
                            </tr>
                            </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.content-wrapper -->
    <script type="text/javascript">
        function getRecord(id, reply_date, reply) {

            $('#complaint_id').val(id);
            $('#reply_date').html(reply_date);
            $('#reply').html(reply);
        }
    </script>

    @include('admin.include.footer')