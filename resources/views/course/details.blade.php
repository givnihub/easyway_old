@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <style>
        .folder_design {
            padding-bottom: 2px;
            font-size: 14px;
            border-radius: 10px;
            padding: 1px;
            border-bottom: 2px solid black;
        }
        ul {
            padding: 0px;
            margin: 0px;
        }

        #list li {
            margin: 0 0 3px;
            padding: 8px;
            list-style: none;

        }

        #refresh_doc li {
            margin: 0 0 3px;
            padding: 8px;
            list-style: none;

        }

        #refresh_video li {
            margin: 0 0 3px;
            padding: 8px;
            list-style: none;

        }

        #view_exam li {
            margin: 0 0 3px;
            padding: 8px;
            list-style: none;

        }

        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }

        .blink_me {
            animation: blinker 1s linear infinite;
            color: red;
            font-weight: bold;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');

        <div class="content-wrapper">
            <section class="content-header">
                <h1><i class="fa fa-gears"></i> Add Contents</h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="modal-body paddbtop">
                            <div class="row">
                                <div id="course_preview">
                                    <div class="flex-row row">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="whatyou coursebox-body mbDM15">
                                                <div class="coursebox mb0">
                                                    <div class="coursebox-img">
                                                        <img src="{{asset('')}}{{$res->course_thumbnail}}" class="img-responsive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-lg-7-->
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="whatyou coursebox-body relative">
                                                <div class="author-block-center text-center">

                                                    <span class="authornamebig">{{$res->title}}</span>
                                                    <span class="descriptionbig">Published Date
                                                        <span>{{date('d-m-Y H:i:s',strtotime($res->updated_date))}}</span></span>
                                                </div>
                                                <ul class="lessonsblock ptt10 ">

                                                    <li><i class="fa fa-list-alt"></i>Trade - <?php

                                                                                                $trade_id = explode(",", $res->trade_id);

                                                                                                for ($i = 0; $i < count($trade_id); $i++) {
                                                                                                    $trade = DB::table('trade')->where("id", $trade_id[$i])->first();
                                                                                                    echo $trade->name . ', ';
                                                                                                }
                                                                                                ?></li>
                                                    <li>
                                                        <i class="fa fa-play-circle"></i>Course Duration:
                                                        <?= $res->validity > 0 ? $res->validity . ' (Months)' : $res->expiry; ?>
                                                    </li>


                                                    <li>
                                                        <i class="fa fa-rupee"></i>

                                                         
                              ₹ Price :<del style="color:red">{{number_format($res->price,2)}}</del>
                              {{number_format($res->price-($res->price*(intval($res->discount)/100)),2)}} ({{$res->discount}} % Off)
                            
 
                                                        

                                                    </li>

                                                </ul>
                                                @if($role_id==7 || $role_id==1)
                                                <div class="coursebtn">
                                                   
                                                    <a href="{{url('admin/course/?id=')}}{{$res->id}}&status={{$res->status}}" class="btn btn-<?php if ($res->status == '1') {
                                                                                                                                                    echo 'success';
                                                                                                                                                } else {
                                                                                                                                                    echo 'warning';
                                                                                                                                                } ?>" style="width:100%">

         
 

                                                            <?= $res->status ? 'Published' : 'Unpublished' ?>
                                                        </a>
                                                      

                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!--./col-lg-5-->

                                    </div>
                                    <!--./detailmodalbg-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="imgbottomtext">
                                                <h3 class="modal-title pb3 fontmedium">Description</h3>
                                                <p></p>
                                                <p>{!!$res->description!!}</p>.<p></p>
                                            </div>
                                        </div>
                                        <!--./col-lg-9-->

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="coursecard whatyou">
                                                <h3 class="fontmedium">Course Preview</h3>
                                                <iframe width="100%" height="500" src="https://www.youtube.com/embed/<?= $res->course_url ?>?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1" frameborder="0">
                                                </iframe>

                                                <div class="overlay--fullscreen"></div>
                                            </div>
                                            <!--./coursecard-->
                                            <div class="coursecard ptt10">

                                                <div class="panel-group faq mb10" id="accordionplus">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordionplus" data-target="#0" aria-expanded="true">
                                                            <h4 class="panelh3 accordion-togglelpus"><b>Free Related
                                                                    Videos<span class="mr0"><i class="fa fa-play-circle"></i>
                                                                        Videos</span></b></h4><b>
                                                            </b>
                                                        </div><b>
                                                            <div id="0" class="panel-collapse collapse in" aria-expanded="true">
                                                                <div class="row container">
                                                                    @foreach($demovideos as $row)
                                                                    <div class="col-lg-6">
                                                                        <h4>{{$row->title}}</h4>
                                                                        <iframe width="100%" height="250" src="https://www.youtube.com/embed/<?= $row->video_id ?>?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1" frameborder="0" title=" YouTube video player">
                                                                        </iframe>
                                                                        <div class="overlay--bottom"></div>
                                                                        <div class="overlay--fullscreen"></div>
                                                                        <p>{{$row->title}}</p>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <!-- Contents -->
                                            <div class="coursecard ptt10">

                                                <div class="panel-group faq mb10" id="accordionplus1">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordionplus1" data-target="#1" aria-expanded="true">
                                                            <h4 class="panelh3 accordion-togglelpus"><b>Contents</b>
                                                            </h4>
                                                        </div><b>
                                                            <div id="1" class="panel-collapse collapse in" aria-expanded="true">
                                                                <div class="row container">
                                                                    <div id="dynamic_folder">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!--./row-->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog pup100" role="document">
            <div class="modal-content modal-media-content">

                <div class="modal-body modal-media-body">
                    <div class="show_video"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary closevideo" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <script>
        $(document).on('click', '.youtubevideo', function(event) {
            $("#mediaModal").modal({
                backdrop: 'static',
                keyboard: false
            }, 'toggle', $(this));

            let video_id = $(this).attr("data-video_id");

            $('.show_video').html(`<iframe width="100%" height="800"
src="https://www.youtube.com/embed/${video_id}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1"
title=" YouTube video player">
</iframe>
<div class="overlay--fullscreen"></div>`);

        });
        $(document).on('click', '.closevideo', function(event) {
            $('.show_video').html(`<iframe width="100%" height="800"
src="" frameborder="0" title=" YouTube video player">
</iframe>`);
        })
    </script>
    <script>
        $(document).ready(function() {

            let folderid = "0";
            let coursid = "{{$res->id}}";
            let onload = 'onload';
            let viewtype = "details";

            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    onload: onload,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
    </script>
    <script>
        function ajax_folder(status, id, type) {
            let folderid = $('#folderid').val();
            let coursid = $('#coursid').val();
            let viewtype = "details";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
                type: "GET",
                data: {
                    id: id,
                    status: status,
                    folderid: folderid,
                    coursid: coursid,
                    type: type,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        }

        $(document).on('click', '.go_back', function(e) {
            let folderid = $(this).attr("data-id");
            let coursid = $('#coursid').val();
            let onload = 'onload';
            let viewtype = "details";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    onload: onload,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
        $(document).on('click', '.view_folder', function(e) {
            let folderid = $(this).attr("data-id");
            let coursid = $('#coursid').val();
            let viewtype = "details";
            $.ajax({
                url: "{{url('ajax/dynamic_contents')}}",
                type: "GET",
                data: {
                    folderid: folderid,
                    coursid: coursid,
                    viewtype: viewtype
                },
                dataType: 'html',
                success: function(res) {
                    $('#dynamic_folder').empty();
                    $('#dynamic_folder').append(res);
                }
            });
        });
    </script>
    @include('admin.include.footer')