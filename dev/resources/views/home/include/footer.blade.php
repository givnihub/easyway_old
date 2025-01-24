<?php $rs = DB::table("general_setting")->first();

$menus = DB::table('front_cms_menu_items')->where('parent_id', 0)->where('menu_id', 2)->orderBy('weight')->get();
?>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <h3 class="fo-title">Links</h3>
                <ul class="f1-list">
                    <li> <a href="{{url('private-job')}}"> Private Jobs </a></li>
                    <li> <a href="{{url('govt-jobs')}}"> Govt. Jobs </a></li>
                    <li> <a href="{{url('latest-news')}}"> News</a></li>
                    <li> <a href="{{url('blogs')}}"> Blogs </a></li>
                    <li> <a href="{{url('faq')}}"> FAQ's </a></li>
                    <li> <a href="{{url('syllabus')}}"> Syllabus </a></li>

                    @foreach($menus as $run_menu)
                    <?php
                    $link = $run_menu->page_id;
                    if ($run_menu->ext_url > 0) {
                        $link = $run_menu->ext_url_link;
                    }
                    ?>
                    <li class="">

                        <a href="{{url($link)}}">{{$run_menu->menu}}</a>
                    </li>
                    @endforeach


                </ul>
            </div>
            <!--./col-md-3-->

            <div class="col-md-4 col-sm-6">
                <h3 class="fo-title">Follow Us</h3>
                <ul class="social ">

                    <li><a href="{{$rs->facebook}}" target="_blank" class="btn btn-primary " style="padding:5px"><i class="fab fa-facebook"></i></a></li>

                    <li><a href="{{$rs->twitter}}" target="_blank" class="btn btn-info " style="padding:5px"><i class="fab fa-twitter"></i></a></li>

                    <li><a href="{{$rs->youtube}}" target="_blank" class="btn btn-danger " style="padding:5px"><i class="fab fa-youtube"></i></a></li>

                    <li><a href="{{$rs->instagram}}" target="_blank" class="btn btn-info " style="padding:5px"><i class="fab fa-instagram"></i></a></li>

                    <li><a href="{{$rs->telgram}}" target="_blank" class="btn btn-info " style="padding:5px"><i class="fab fa-telegram"></i></a></li>

                </ul>

            </div>
            <!--./col-md-3-->
            <div class="col-md-4 col-sm-6">
                <h3 class="fo-title">Contact</h3>
                <ul class="co-list">
                    <li><i class="fa fa-envelope"></i>
                        <a href="mailto:{{$rs->email}}">{{$rs->email}}</a></li>
                    <li><i class="fa fa-phone"></i>{{$rs->phone}}</li>
                    <li><i class="fa fa-map-marker"></i>{{$rs->address}}</li>
                </ul>
            </div>
            <!--./col-md-3-->
            <div class="col-md-3 col-sm-6">
                <a class="twitter-timeline" data-tweet-limit="1" href="frontend.html#"></a>
            </div>
            <!--./col-md-3-->
        </div>
        <!--./row-->
    </div>
    <!--./container-->

    <div class="copy-right">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <p>All Right Reserved Easyway Global</p>
                </div>
            </div>
            <!--./row-->
        </div>
        <!--./container-->
    </div>
    <!--./copy-right-->
    <a class="scrollToTop" href="frontend.html#"><i class="fa fa-angle-double-up"></i></a>
</footer>

<script src="{{asset('public/backend/themes/yellow/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/themes/yellow/js/jquery.waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/themes/yellow/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('public/backend/themes/yellow/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/backend/themes/yellow/js/ss-lightbox.js')}}"></script>
<script src="{{asset('public/backend/themes/yellow/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backend/themes/yellow/datepicker/bootstrap-datepicker.min.js')}}">
</script>

</body>

</html>