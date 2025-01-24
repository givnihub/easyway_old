@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')


        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-gears"></i> System Settings</h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Assign Permission ({{$role->name}}) </h3>
                            </div>
                            <form id="form1" action="" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                @csrf
                                <div class="box-body">

                                    <?php
                                      $role_id = $_GET['id'];
                                    $check_role = DB::table("roles")->where("id", $role_id)->first(['name']);

                                    
                                    if ($check_role->name == "Student") {
                                        $role_id = 'student';
                                    }
                                    
                                    ?>
                                    <input type="hidden" name="role_id" value="{{$role_id}}" />
                                    <div class="table-responsive">
                                        <table class="table table-stripped">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th>Feature</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i=1; @endphp
                                                @foreach($module as $row)
                                                <?php

                                                $feature = DB::table("submenu")->where("menu_id", $row->id)->get();

                                                ?>

                                                <tr>
                                                    <th>{{$row->title}}</th>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @foreach($feature as $run)
                                                <?php
                                                $check_status = DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $run->id)->first();

                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td>

                                                        <input type="hidden" name="per_cat[]" value="{{$i}}" />
                                                        <input type="hidden" name="roles_permissions_id_{{$i}}" value="{{$run->id}}" />
                                                        {{$run->title}}</td>
                                                    <td>
                                                        <label class="">
                                                            <input type="checkbox" name="can_view-perm_{{$i}}" value="1" @if($check_status->can_view==1) checked @endif>
                                                        </label>


                                                    </td>
                                                    <td>
                                                        <label class="">
                                                            <input type="checkbox" name="can_add-perm_{{$i}}" value="1" @if($check_status->can_add==1) checked @endif>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="">
                                                            <input type="checkbox" name="can_edit-perm_{{$i}}" value="1" @if($check_status->can_edit==1) checked @endif>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="">
                                                            <input type="checkbox" name="can_delete-perm_{{$i}}" value="1" @if($check_status->can_delete==1) checked @endif>
                                                        </label>
                                                    </td>

                                                </tr>
                                                <?php $i++; ?>
                                                @endforeach


                                                @endforeach



                                            </tbody>

                                        </table>
                                    </div>
                                    <!--./table-responsive-->


                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </section>
        </div>
        @include('admin.include.footer')