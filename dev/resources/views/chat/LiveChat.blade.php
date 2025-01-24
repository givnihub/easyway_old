<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset('public/backend/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/jquery.mCustomScrollbar.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/style-main.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/themes/default/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/themes/default/ss-main.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/ionicons.min.css')}}">
    <!--language css-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('public/backend/dist/css/bootstrap-select.min.css')}}">
    <script src="{{asset('public/backend/custom/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('public/backend/dist/js/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/backend/dist/css/course_addon.css')}}">
    <style>
        .chatcontent {
            width: 100% !important;
           
        }

        .chatInput {
            border: none;
            width: 100%;
            padding: 2px 20px;
            color: #32465a;
            border-radius: 30px;
        }
       #frame .chatcontent .messages {
           padding-top:200px !important;
       }
    </style>
</head>

<script>
    function collapseSidebar() {

        if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
            sessionStorage.setItem('sidebar-toggle-collapsed', '');
        } else {
            sessionStorage.setItem('sidebar-toggle-collapsed', '1');
        }

    }
</script>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="">

        <!-- Content Wrapper. Contains page content -->
        <div class="">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content" style="position: relative;">
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div id="frame">
                            <div class="chatloader"></div>

                            <div class="chatcontent">

                                <div class="messages">
                                    <ul>

                                    </ul>
                                </div>
                                <div class="message-input ">
                                    <div class="wrap relative">
                                        <input type="hidden" value="{{$users->firstname}}" id="studentname" name="last_chat_id">
                                        <input type="hidden" id="userId" value="{{$userId}}">
                                        <input type="hidden" id="videoId" value="{{$videoId}}">
                                        <textarea type="text" id="message" placeholder="Write your message..." class="chatInput"></textarea>
                                        <button class="submit input_submit" disabled="disabled"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                </div><!-- /.box-header -->
            </section>
        </div><!-- /.box-body -->
    </div>
    </div>
    <!--/.col (left) -->
    <!-- right column -->
    </div>
    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <script>
        $(document).ready(function() {
            allMessage();
            clearInterval(interval);
                interval = setInterval(getChatsUpdates, 2000);
            $('.chatloader').css({
                display: 'none'
            });
           
        });
        var timestamp = '1671168242';
        var date_time_temp = "";
        
        function updateTime() {
            date_time_temp = new Date().toLocaleString();
            timestamp++;
        }

        $(document).on('input', '.chatInput', function() {

            if ($.trim($(this).val()) == '') {

                $('.input_submit').prop('disabled', true);
            } else {

                $('.input_submit').prop('disabled', false);

            }
        });

        $(document).on('click', '.input_submit', function(e) {

            let message = $("#message").val();
            let userId = $("#userId").val();
            let videoId = $("#videoId").val();

            if ($.trim(message) == '') {
                return false;
            }
            newChatMessage();
            e.preventDefault(); // To prevent the default
        });

        $(function() {
            setInterval(updateTime, 1000);

        });
        $(".messages").animate({
                scrollTop: $(document).height()
            },
            "fast"
        );
        var interval;
        var intervalchat;
        var intervalchatnew;




        $(document).on('keydown', '.chatInput', function(e) {
            switch (e.which) {
                case 13:
                    newChatMessage();
                    break;
            }
        });

        function htmlEncode(str) {
            return String(str).replace(/[^\w. ]/gi, function(c) {
                return '&#' + c.charCodeAt(0) + ';';
            });
        }

        function newChatMessage() {
            let message = $("#message").val();
            let userId = $("#userId").val();
            let videoId = $("#videoId").val();
            let studentName=$("#studentname").val();
             
            $('.input_submit').prop('disabled', true);
            if ($.trim(message) == '') {
                return false;
            }

            if (videoId != '' && userId > 0) {

                $.ajax({
                    type: "POST",
                    url: "{{url('chat/newLiveMessage')}}",
                    data: {
                        'userId': userId,
                        'message': message,
                        'videoId': videoId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(data) {
                        var last_chat_id = $("input[name='last_chat_id']").val(data.last_insert_id);
                        $('<li class="replies"><p>' + message + '</p> <span class="time_date_send"> ' +
                        date_time_temp + '</span></li>').appendTo($('.messages ul'));
                        $('.chatInput').val(null);
                        $('.contact.active .preview').html('<span>You: </span>' + message);
                        $('.messages').animate({
                            scrollTop: $('.messages')[0].scrollHeight
                        }, "slow");

                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    },
                    complete: function(data) {

                    }
                })
            }

        };
        function allMessage() {
         
          var end_reach = false;
          var videoId = $("#videoId").val();
          var userId = $("#userId").val();
          
          $.ajax({
              type: "POST",
              url: "{{url('chat/allLiveStreamMessage')}}",
              data: {
                  'videoId': videoId,
                  'userId': userId,
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              // dataType: "JSON",
              beforeSend: function() {

              },
              success: function(data) {
                  var scrollTop = $('.messages').scrollTop();
                  if (scrollTop + $('.messages').innerHeight() >= $('.messages')[0].scrollHeight) {
                      end_reach = true;
                  }
                  // $("input[name='last_chat_id']").val(data.user_last_chat.id);
                  $('.messages ul').append(data);
                  if (end_reach) {
                      $('.messages').animate({
                          scrollTop: $('.messages')[0].scrollHeight
                      }, "slow");

                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {

              },
              complete: function(data) {

              }
          })
      }

        function getChatsUpdates() {
          
            var end_reach = false;
            var videoId = $("#videoId").val();
            var userId = $("#userId").val();
            
            $.ajax({
                type: "POST",
                url: "{{url('chat/chatLiveStreamMessage')}}",
                data: {
                    'videoId': videoId,
                    'userId': userId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // dataType: "JSON",
                beforeSend: function() {

                },
                success: function(data) {
                    var scrollTop = $('.messages').scrollTop();
                    if (scrollTop + $('.messages').innerHeight() >= $('.messages')[0].scrollHeight) {
                        end_reach = true;
                    }
                    // $("input[name='last_chat_id']").val(data.user_last_chat.id);
                    $('.messages ul').append(data);
                    if (end_reach) {
                        $('.messages').animate({
                            scrollTop: $('.messages')[0].scrollHeight
                        }, "slow");

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                },
                complete: function(data) {

                }
            })
        }
    </script>



    </div>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <link href="{{asset('public/backend/toast-alert/toastr.css')}}" rel="stylesheet" />
    <script src="{{asset('public/backend/toast-alert/toastr.js')}}"></script>
    <script src="{{asset('public/backend/bootstrap/js/bootstrap.min.js')}}"></script>
     
    
    <script src="{{asset('public/backend/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
   
    <script src="{{asset('public/backend/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('public/backend/dist/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

    <!--language js-->
 

</body>

</html>
 