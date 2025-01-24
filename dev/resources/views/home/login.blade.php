<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>Login : Easy Way Global</title>
    <link href="{{asset('public/uploads/school_content/admin_small_logo/1.png')}}" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css')}}">
    <style type="text/css">
        .top-content {
            position: relative;
        }

        body {
            background: #fff;
        }

        .inner-bg {
            border: 1px solid #ccc;
        }

        .form-top-left {
            padding: 20px;
        }

        .logowidth img {
            height: 80px;
        }

        .nav-tabs.nav-justified>.active>a,
        .nav-tabs.nav-justified>.active>a:focus,
        .nav-tabs.nav-justified>.active>a:hover {
            border: 1px solid #ddd;
            background: #c72016;
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Top content -->
    <div class="top-content">
        <div class="inner-bg">
            <div class="container">
                <div class="row">

                    <div class="bgoffsetbg">


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
                        <div class="col-lg-4 col-md-4 col-sm-12 nopadding  ">
                            <div class="loginbg loginradius login390">
                                <div class="form-top">
                                    <div class="form-top-left logowidth">
                                        <img src="{{asset('')}}<?=$res[0]->admin_logo?>">
                                    </div>
                                    <!-- <div class="form-top-right"><i class="fa fa-key"></i></div> -->
                                </div>

                                <div class="form-bottom">
                                    <h3 class="font-white bolds">Admin Login</h3>
                                    <form action="{{url('admin/login')}}" method="post">
                                        @csrf
                                        <div class="form-group has-feedback">
                                            <input type="text" name="username" placeholder="Username" value="" class="form-username form-control" id="form-username">
                                            <span class="fa fa-envelope form-control-feedback"></span>
                                            <span class="text-danger">@error('username'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="password" value="" name="password" placeholder="Password" class="form-password form-control" id="form-password">
                                            <span class="fa fa-lock form-control-feedback"></span>
                                            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                                        </div>
                                        <button type="submit" class="btn">Sign In</button>
                                    </form>
                                    <a href="forgotpassword" class="forgot"><i class="fa fa-key"></i> Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-1 col-sm-1"><div class="separatline"></div></div>  -->
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <h3 class="h3">What's new in Easy Way Global</h3>
                            <div class="loginright mCustomScrollbar _mCS_1 mCS_no_scrollbar">
                                <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0">
                                    <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                                        <div class="messages">


                                            <h4>Offline New Batch ( 12th Batch) Starting from 04 April-2022</h4>

                                            <p>The 12th&nbsp;Batch of Easyway Coaching is starting from
                                                04&nbsp;April-2022.&nbsp;In this... <a class="more" href="{{url('')}}/read/offline-new-batch-12th-batch-starting-from-04-april-2022" target="_blank">Read More </a></p>
                                            <div class="logdivider"></div>
                                            <h4>Easyway Online CLass Available For Electrician, Fitter, Wireman, Turner,
                                                Machinist, Copa</h4>

                                            <p>For More Details Click Here

                                                Easyway&nbsp;कोचिंग के Career Expert टीम... <a class="more" href="{{url('')}}/read/easyway-online-class-available-for-electrician-fitter-wireman-turner-machinist-copa" target="_blank">Read More </a></p>
                                            <div class="logdivider"></div>





                                        </div>
                                    </div>
                                    <!-- <img src="{{url('')}}/backend/usertemplate/assets/img/backgrounds/bg3.jpg" class="img-responsive" style="border-radius:4px;" /> -->
                                </div>
                                <!--./col-lg-6-->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Javascript -->
            <script src="{{asset('public/backend/usertemplate/assets/js/jquery-1.11.1.min.js')}}"></script>

            <script src="{{asset('public/backend/usertemplate/assets/bootstrap/js/bootstrap.min.js')}}"></script>

            <script src="{{asset('public/backend/usertemplate/assets/js/jquery.backstretch.min.js')}}"></script>

            <script src="{{asset('public/backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js')}}"></script>

            <script src="{{asset('public/backend/usertemplate/assets/js/jquery.mousewheel.min.js')}}"></script>


            <script type="text/javascript">
                $(document).ready(function() {
                    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea')
                        .on('focus', function() {
                            $(this).removeClass('input-error');
                        });
                    $('.login-form').on('submit', function(e) {
                        $(this).find('input[type="text"], input[type="password"], textarea').each(
                            function() {
                                if ($(this).val() == "") {
                                    e.preventDefault();
                                    $(this).addClass('input-error');
                                } else {
                                    $(this).removeClass('input-error');
                                }
                            });
                    });
                });
            </script>
            <script type="text/javascript">
                function refreshCaptcha() {
                    $.ajax({
                        type: "POST",
                        url: "{{url('')}}/site/refreshCaptcha",
                        data: {},
                        success: function(captcha) {
                            $("#captcha_image").html(captcha);
                        }
                    });
                }
            </script>
</body>

</html>