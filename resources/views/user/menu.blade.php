@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        @php
        $can_view= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_view", "1")->count();
        $can_add= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_add", "1")->count();
        $can_edit= DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $perm_cat_id)->where("can_edit", "1")->count();
        @endphp
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border pb0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <h3 class="box-title header_tab_style">Add Menu</h3> &nbsp;

                                    </div>
                                    @if($can_add>0)
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <a href="{{url('admin/submenu')}}"><button class="btn btn-primary">Add Submenu</button></a>

                                    </div>
                                    @endif
                                </div>


                                <form id="examadd" method="post" action="" class="ptt10">
                                    <input type="hidden" name="uid" value="{{$res->id}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    <label>Menu Title</label>
                                                    <input type="text" value="{{$res->title}}" name="title" class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Menu Icon</label>
                                                    <input type="text" name="icon" value="{{$res->icon}}" class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Submenu</label>
                                                    <select type="text" name="submenu" class="form-control">
                                                        <option value="1" @if($res->submenu=='1') selected @endif>Yes</option>
                                                        <option value="0" @if($res->submenu=='0') selected @endif>No</option>
                                                    </select>
                                                </div>
                                                @if($can_add>0)
                                                <div class="col-lg-3">
                                                    <br />
                                                    <button type="submit" class="btn btn-primary">Submit</button>

                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <table class="table table-striped table-bordered table-hover examlist">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Title</th>
                                                        <th style="text-align: left;">Icon</th>
                                                        <th style="text-align: left;">Submenu</th>
                                                        <th style="text-align: left;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($list as $run)

                                                    <tr>
                                                        <td style="text-align: left;">


                                                            {{$run->title}}

                                                        </td>
                                                        <td style="text-align: left;">
                                                            {{$run->icon}} </td>
                                                        <td style="text-align: left;">
                                                            {{$run->submenu}} </td>
                                                        <td style="text-align: left;">
                                                        @if($can_edit>0)
                                                            <a href="{{url('admin/menu?id=')}}{{$run->id}}"><i class="fa fa-pencil"></i></a>
                                                            <!-- <a href="{{url('admin/menu?delid=')}}{{$run->id}}" onclick="return confirm('Are you sure...?')"><i class="fa fa-trash"></i></a> -->
                                                      @endif
                                                      
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            (function($) {
                'use strict';
                $(document).ready(function() {
                    $('.examlist').DataTable({
                        paging: false
                    });
                });
            }(jQuery));
        </script>

        @include('admin.include.footer')