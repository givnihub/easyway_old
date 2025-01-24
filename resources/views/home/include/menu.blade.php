<?php

$menus=DB::table('front_cms_menu_items')->where('parent_id',0)->where('menu_id',1)->orderBy('weight')->get();


?>

<div class="header_menu">
    <div class="container">
        <div class="row">
            <nav class="navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse-3">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse-3">
                    <ul class="nav navbar-nav">

                    @foreach($menus as $run_menu)
                    <?php $count=DB::table('front_cms_menu_items')->where('parent_id',$run_menu->id)->count();
                    $link=$run_menu->page_id;
                    if($run_menu->ext_url>0){
                        $link=$run_menu->ext_url_link;
                    }
                    ?>
                    <li class="@if($count>0) dropdown  @endif">
                            <a href="{{url($link)}}" @if($count>0) class="dropdown-toggle" data-toggle="dropdown" @endif>{{$run_menu->menu}} @if($count>0) <b class="caret"></b>  @endif </a>
                            <ul class="@if($count>0) dropdown-menu @endif">
                                <?php $submenu=DB::table('front_cms_menu_items')->where("parent_id",$run_menu->id)->where('menu_id',1)->orderBy('weight')->get();

                                  foreach($submenu as $run_sub_menu){
                                     $link=$run_sub_menu->page_id;
                                    if($run_sub_menu->ext_url>0){
                                        $link=$run_sub_menu->ext_url_link;
                                    }

                               ?>


                                <li><a href="{{url($link)}}">{{$run_sub_menu->menu}}</a></li>
<?}?>
                            </ul>
                        </li>
                    @endforeach

                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav><!-- /.navbar -->
        </div>
    </div>
</div>
</div>

<!--
mobile menu     -->


<div class="container mt80" style="border-top: 1px solid #ccc;">
    <div class="row">
        <div class="mobileonly">
            <ul class="mob-extra-menu">
                <li class="nav-item active text-center ">
                    <a href="{{url('all-courses')}}" style="color:#c82319"><i class="fad fa-video fa-2x"></i>
                        <p>All Courses</p>
                    </a>
                </li>
                <li class="nav-item active text-center ">
                    <a href="{{url('study-material')}}" style="color:#c82319"><i class="fad fa-book-open fa-2x"></i>
                        <p>Study Material</p>
                    </a>
                </li>
                <li class="nav-item active text-center ">
                    <a href="{{url('career')}}" style="color:#c82319"><i
                            class="fad fa-chalkboard-teacher fa-2x"></i>
                        <p>Career</p>
                    </a>
                </li>
                <li class="nav-item active text-center ">
                    <a href="{{url('quiz')}}" style="color:#c82319"><i class="fad fa-keyboard fa-2x"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                <li class="nav-item active text-center ">
                    <a href="{{url('live-test')}}" style="color:#c82319"><i class="fad fa-computer-speaker fa-2x"></i>
                        <p>Live Test</p>
                    </a>
                </li>
                <li class="nav-item active text-center ">
                    <a href="{{url('userlogin')}}" style="color:#c82319"><i class="fad fa-user fa-2x"></i>
                        <p>Login / Register</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
