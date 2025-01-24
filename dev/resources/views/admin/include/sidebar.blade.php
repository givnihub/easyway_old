<aside class="main-sidebar" id="alert2">
    @php $userInfo = session()->get('userInfo');@endphp
    @php  $role_id=$userInfo['role']; @endphp

    <section class="sidebar" id="sibe-box">
        <ul class="sessionul fixedmenu">
            <li class="removehover">
                <a data-toggle="modal" data-target="#sessionModal"><span>Current Session: 2023-24</span><i class="fa fa-pencil pull-right"></i></a>
            </li>
            <?php

            if ($role_id == 'student') {

                $menu = DB::table("menu")->where("student", "1")->where("id", "15")->count();
            } else {

                $is_superadmin = DB::table("roles")->where("id", $role_id)->where("is_superadmin", "1")->count();
                if ($is_superadmin ?? '' > 0) {
                    $menu = 1;
                } else {
                    $menu = DB::table("menu")->where("id", "!=", "15")->where("system", "1")->count();
                }
            }
            ?>
            @if($menu>0)
            <li class="dropdown">

                <a class="dropdown-toggle drop5" data-toggle="dropdown" href="#" aria-expanded="false">
                    <span>Quick Links</span> <i class="fa fa-th pull-right ftlayer"></i>
                </a>

                <ul class="dropdown-menu verticalmenu" style="min-width:194px;font-size:10pt;left:3px;">
                    @php
                    $quicklink=DB::table("submenu")->where("menu_id","15")->get();
                    @endphp
                    @foreach($quicklink as $run_quicklinks)
                    <?php
                    if ($is_superadmin ?? '' == '0') {
                        $check_permission = DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $run_sub_menu->id ?? '')->where("can_view", "1")->count();
                    }
                    ?>
                    @if($is_superadmin ?? ''>0)
                    <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="{{url('')}}/{{$run_quicklinks->link}}"><i class="{{$run_quicklinks->icon}}"></i>{{$run_quicklinks->title}}</a></li>

                    @elseif($check_permission>0)
                    <li role="presentation"><a style="color:#282828; font-family: 'Roboto-Bold';padding:6px 20px;" role="menuitem" tabindex="-1" href="{{url('')}}/{{$run_quicklinks->link}}"><i class="{{$run_quicklinks->icon}}"></i>{{$run_quicklinks->title}}</a></li>
                    @endif
                    @endforeach

                </ul>
            </li>
            @endif
        </ul>

        <ul class="sidebar-menu verttop">

            <?php
            $active_link = Request::path();
            $menu_id = DB::table("submenu")->where("link", $active_link)->first();

            if ($role_id == 'student') {
                $menu = DB::table("menu")->where("student", "1")->get();
            } else {

                $menu = DB::table("menu")->where("id", "!=", "15")->get();
            }

            ?>
            @if($role_id == 'student')
            <li class="treeview">
                <a href="{{url('user/profile')}}">
                    <i class="fa fa-user-plus ftlayer"></i>
                    My Profile<i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            @endif
            @foreach($menu as $run_menu)

            <li class="treeview @if($menu_id->menu_id==$run_menu->id) active @endif">
                <a href="#">
                    <i class="{{$run_menu->icon}}"></i> <span>{{$run_menu->title}}</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @php
                    $submenu=DB::table("submenu")->where("menu_id",$run_menu->id)->get();

                    @endphp
                    @foreach($submenu as $run_sub_menu)
                    <?php
                    $check_permission = DB::table("roles_permissions")->where("role_id", $role_id)->where("perm_cat_id", $run_sub_menu->id)->where("can_view", "1")->count();

                    ?>
                    @if($is_superadmin ?? ''>0)
                    <li class="{{$run_sub_menu->icon}} @if($active_link==$run_sub_menu->link) active @endif"><a href="{{url('')}}/{{$run_sub_menu->link}}"><i class="fa fa-angle-double-right"></i> {{$run_sub_menu->title}} </a></li>
                    @elseif($check_permission>0)
                    <li class="{{$run_sub_menu->icon}} @if($active_link==$run_sub_menu->link) active @endif"><a href="{{url('')}}/{{$run_sub_menu->link}}"><i class="fa fa-angle-double-right"></i> {{$run_sub_menu->title}} </a></li>
                    @endif
                    @endforeach


                </ul>
            </li>
            @endforeach
        </ul>
    </section>
</aside>