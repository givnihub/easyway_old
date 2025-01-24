@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <style>
            @media print {
                .noprint {
                    visibility: hidden;
                }
            }

            .w-5 {
                display: none;
            }

            .dataTables_paginate {
                display: none;
            }
        </style>
        <?php
        $tradegroup = $_GET['tradegroup'];
        $trade = $_GET['trade'];
        $subject = $_GET['subject'];
        $chapter = $_GET['chapter'];
        $topic = $_GET['topic'];
         $examid=Request::segment('4');
       
        ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary" id="route">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix pt5"> Online Exam Question</h3>

                                <a class="btn btn-primary btn-sm pull-right " href="{{url('admin/onlineexam')}}"><i class="fa fa-bars"></i> Exam
                                    List</a>
                            </div>
                            <div class="box-body">
                                <form method="get" action="">

                                    <div class="row">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Search by keyword</label>
                                                <input type="text" class="form-control" name="keyword" id="keyword">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="tradegroup">Trade Group</label><small class="req">*</small>
                                            <select class="form-control" name="tradegroup" id="tradegroup" required>
                                                <option value="">Select</option>
                                                @foreach($list as $row)
                                                <option value="{{$row->id}}" @if($row->id==$tradegroup) selected
                                                    @endif>{{$row->name}}</option>

                                                @endforeach
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="trade">Trade</label><small class="req"> *</small>
                                            <select class="form-control" name="trade" id="trade" required>
                                                <option value="">Select</option>
                                                @if($trade!='')
                                                <?php

                                                $run = DB::table('trade')->where('id', $trade)->get()->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger class_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subject">Subject</label>
                                            <select id="subject" name="subject" class="form-control" required>
                                                <option value="">Select</option>
                                                @if($subject!='')
                                                <?php

                                                $run = DB::table('subject')->where('id', $subject)->get()->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="chapter">Chapter</label><small class="req"> *</small>
                                            <select class="form-control" name="chapter" id="chapter" required>
                                                <option value="">Select</option>
                                                @if($chapter!='')
                                                <?php
                                                $run = DB::table('chapter')->where('id', $chapter)->get()->first();
                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="topic">Topic</label><small class="req"> *</small>
                                            <select class="form-control" name="topic" id="topic" required>
                                                <option value="">Select</option>
                                                @if($topic!='')
                                                <?php

                                                $run = DB::table('topics')->where('id', $topic)->get()->first();

                                                ?>
                                                <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                @endif
                                            </select>
                                            <span class="text text-danger subject_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label style="display: block; visibility:hidden;">Search</label>
                                        <button type="submit" class="btn btn-info btn-sm post_search_submit pull-right">Search</button>
                                </form>

                              
                            </div>
                        </div><!-- ./row -->
                        <span id="message"></span>
                        <form method="post" action="{{url('exam/addExamQuestion')}}" id="form">
                                    @csrf
                                    <input type="hidden" name="examid" value="{{$examid}}">
                                    <input type="submit" name="" value="Save Questions" id="submitform" class="btn btn-success post_search_submit" style="margin: 10px;">
                        <div class="mailbox-messages" id="tag_container">

                        </div>

                        </form>
                    </div>
                </div>
        </div>
    </div>
    </section>
    </div>

    <script type="text/javascript">
        $(document).on('click', '#mastercheck', function() {

            if ($(this).prop("checked")) {

                $(".checkboxids").prop("checked", true);

            } else {

                $(".checkboxids").prop("checked", false);

            }

        });
    </script>
    <script>
        $(document).ready(function() {
            var page = 1;
            let examid='{{$examid}}';
      
            let chapter = $('#chapter').val();
            let topic = $('#topic').val();
            let tradegroup = $('#tradegroup').val();
            let trade = $('#trade').val();
            let subject = $('#subject').val();
            if (chapter != '' && topic != '' && tradegroup != '' && trade != '' && subject != '') {
                fetch_data2(page, chapter, topic, tradegroup, trade, subject,examid);
            } else {
                fetch_data(page,examid);
            }

            $('#keyword').keyup(function() {

                let keywords = $(this).val();
                $.ajax({
                    url: "{{url('exam/examquestion')}}?keywords=" + keywords+"&examid="+examid,
                    success: function(data) {
                        $('#tag_container').empty().html(data);
                        location.hash = page;
                    }
                });

            });

            $(window).on('hashchange', function() {
                if (window.location.hash) {
                    var page = window.location.hash.replace('#', '');
                    if (page == Number.NaN || page <= 0) {
                        return false;
                    } else {
                        if (chapter != '' && topic != '' && tradegroup != '' && trade != '' && subject != '') {

                            fetch_data2(page, chapter, topic, tradegroup, trade, subject,examid);
                        } else {
                            fetch_data(page,examid);
                        }
                    }
                }
            });

            $(document).on('click', '.pagination a', function(event) {

                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var url = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                if (chapter != '' && topic != '' && tradegroup != '' && trade != '' && subject != '') {

                    fetch_data2(page, chapter, topic, tradegroup, trade, subject,examid);
                } else {
                    fetch_data(page,examid);
                }
            });
        });

        function fetch_data(page,examid) {

            $.ajax({
                url: "{{url('exam/examquestion')}}?page=" + page+"&examid="+examid,
                success: function(data) {
                    $('#tag_container').empty().html(data);
                    location.hash = page;
                }
            });
        }

        function fetch_data2(page, chapter, topic, tradegroup, trade, subject,examid) {

            $.ajax({
                url: "{{url('exam/examquestion')}}?page=" + page + "&tradegroup=" + tradegroup + "&trade=" + trade + "&subject=" + subject + "&chapter=" + chapter + "&topic=" + topic+"&examid="+examid,
                success: function(data) {
                    $('#tag_container').empty().html(data);
                    location.hash = page;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#tradegroup').change(function() {
                let groupid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/trade")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,

                    },

                    success: function(data) {
                        $('#trade').empty();
                        $('#trade').append(data);

                    },

                });
            });

            $('#trade').change(function() {
                let groupid = $('#tradegroup').val();

                let tradeid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/subject")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,
                        'tradeid': tradeid

                    },
                    success: function(data) {
                        $('#subject').empty();
                        $('#subject').append(data);

                    }
                });
            });

            $('#subject').change(function() {
                let groupid = $('#tradegroup').val();
                let tradeid = $('#trade').val();
                let subjectid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/chapter")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,
                        'tradeid': tradeid,
                        'subjectid': subjectid,

                    },

                    success: function(data) {
                        $('#chapter').empty();
                        $('#chapter').append(data);

                    }

                });
            });
            $('#chapter').change(function() {
                let chapterid = $(this).val();
                let groupid = $('#tradegroup').val();
                let tradeid = $('#trade').val();
                let subjectid = $('#subject').val();
                $.ajax({
                    url: '{{url("ajax/topic")}}',
                    type: "GET",
                    data: {
                        'chapterid': chapterid,
                        'groupid': groupid,
                        'tradeid': tradeid,
                        'subjectid': subjectid,

                    },

                    success: function(data) {
                        $('#topic').empty();
                        $('#topic').append(data);

                    }

                });
            });
        });
    </script>
<script>
        $("#form").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{url('exam/addExamQuestion')}}",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#message").html('<div class="alert alert-warning" role="alert">Processing.Please wait....</div>').fadeOut();
                },
                success: function(data) {
                    
                     
                    $('#message').html(data).fadeIn();

                },
                error: function(e) {
                    $("#message").html(e).fadeIn();
                }
            });
        }));
    </script>

    @include('admin.include.footer')