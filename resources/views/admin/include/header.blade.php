<style type="text/css">
    .table-sortable tbody tr {
        cursor: move;
    }

    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }
</style>
<?php $general_setting = DB::select('select * from general_setting');
$userInfo = session()->get('userInfo');
  $role = $userInfo['role'];


  $role_id = $userInfo['id'];

 
if ($role != 'student') {
    $roles = DB::table("roles")->where("id", $role)->first();
    $user = DB::table("staff")->where("id", $role_id)->first(['id', 'role', 'name', 'surname', 'qualification', 'designation', 'image']);
    $name = $user->name . " " . $user->surname;
    $type = $roles->name;
    $image = $user->image;
} else {
    $user = DB::table("students")->where("id", $role_id)->first(['id', 'roll_no', 'firstname', 'lastname', 'photo']);
    $name = $user->firstname;
    $type = 'student';
    $image = $user->photo;
}
?>
<header class="main-header" id="alert">
    <a href="{{url('admin/dashboard')}}" class="logo">
        <span class="logo-mini"><img src="{{asset('')}}<?= $general_setting[0]->small_logo; ?>" alt="{{$general_setting[0]->title}}" /></span>
        <span class="logo-lg"><img src="{{asset('')}}<?= $general_setting[0]->admin_logo; ?>" alt="{{$general_setting[0]->title}}" /></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a onclick="collapseSidebar()" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="col-lg-5 col-md-3 col-sm-2 col-xs-5">
            <span href="#" class="sidebar-session">
                {{$general_setting[0]->title}}</span>
        </div>
        <div class="col-lg-7 col-md-9 col-sm-10 col-xs-7">
            <div class="pull-right">
            @if($role==7 || $role==1)
                <form id="header_search_form" class="navbar-form navbar-left search-form" role="search" action="{{url('student/search')}}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" value="" name="search_text" id="search_text" class="form-control search-form search-form3" placeholder="Search By Student Name, Roll Number, Enroll Number, National Id, Local Id Etc.">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" onclick="getstudentlist()" style="" class="btn btn-flat topsidesearchbtn"><i class="fa fa-search"></i></button>
                        </span>
                    </div>

                </form>
                @endif
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav headertopmenu">
                        <li class="cal15"><a data-placement="bottom" data-toggle="tooltip" title="Calendar" href="{{url('master/calendar/events')}}"><i class="fa fa-calendar"></i></a>

                        </li>
                        <li class="cal15"><a data-placement="bottom" data-toggle="tooltip" title="" href="{{url('chat')}}" data-original-title="Chat" class="todoicon"><i class="fa fa-whatsapp"></i>
                                <!-- <span
                                    class="todo-indicator">9</span> -->

                            </a>
                        </li>
                        @if($role=='7')
                        <li class="cal15"><a data-placement="bottom" data-toggle="tooltip" title="" href="{{url('chat/all')}}" data-original-title="All Chats" class="todoicon"><i class="fa fa-whatsapp"></i>
                                <!-- <span
                                    class="todo-indicator">9</span> -->
                            </a></li>
                        @endif
                        <li class="dropdown user-menu">
                            <a class="dropdown-toggle" style="padding: 15px 13px;" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img src="@if($image!='') {{asset('')}}{{$image}} @else {{asset('public/uploads/staff_images/default_male.jpg')}} @endif" class="topuser-image" alt="User Image">
                            </a>
                            <ul class="dropdown-menu dropdown-user menuboxshadow">
                                <li>
                                    <div class="sstopuser">
                                        <div class="ssuserleft">
                                            <a href="{{url('admin/staff/profile?id=')}}{{$role_id}}"><img src="@if($image!='') {{asset('')}}{{$image}} @else {{asset('public/uploads/staff_images/default_male.jpg')}} @endif" alt="User Image"></a>
                                        </div>

                                        <div class="sstopuser-test">
                                            <h4 class="text-capitalize">{{$name}}</h4>
                                            <h5>{{$type}}</h5>

                                        </div>

                                        <div class="divider"></div>
                                        <div class="sspass">
                                            @if($type!='student')
                                            <a href="{{url('admin/staff/profile?id=')}}{{$role_id}}" data-toggle="tooltip" title="" data-original-title="My Profile"><i class="fa fa-user"></i>Profile </a>
                                            @endif
                                            <a class="pl25" href="{{url('changepass')}}" data-toggle="tooltip" title="" data-original-title="Change Password"><i class="fa fa-key"></i>Password</a> <a class="pull-right" href="{{url('admin/logout')}}"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                                        </div>
                                    </div>
                                    <!--./sstopuser-->
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>