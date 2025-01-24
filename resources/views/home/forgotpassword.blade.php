<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>forgotpassword : Easy Way Global</title>
    <link href="{{asset('public/uploads/school_content/admin_small_logo/1.png')}}" rel="shortcut icon"
        type="image/x-icon">
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
<div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <!-- <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <img src="{{url('')}}/backend/images/s_logo.png" class="logowidth">
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 nopadding col-md-offset-4">
                            <div class="bgoffsetbg">
                                <div class="loginbg">
                                    <div class="form-top">
                                        <div class="form-top-left logowidth">
                                            <img src="{{url('')}}/uploads/school_content/admin_logo/1.png">
                                        </div>
                                        <!-- <div class="form-top-right"><i class="fa fa-key"></i></div> -->
                                    </div>

                                    <div class="form-bottom">
                                        <h3 class="font-white bolds">Forgot Password</h3>
                                                                                <form action="{{url('')}}/site/forgotpassword" method="post">
<input type="hidden" name="ci_csrf_token" value="">                                            <div class="form-group has-feedback">
                                                <label class="sr-only" for="form-username">Email</label>
                                                <input type="text" name="email" placeholder="Email" class="form-username form-control" id="form-username">
                                                <span class="fa fa-envelope form-control-feedback"></span>
                                                <span class="text-danger"></span>
                                            </div>
                                            <button type="submit" class="btn">Submit</button>
                                        </form>
                                        <a href="login" class="forgot"><i class="fa fa-key"></i> Admin Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{asset('public/backend/usertemplate/assets/js/jquery-1.11.1.min.js')}}"></script>

    <script src="{{asset('public/backend/usertemplate/assets/bootstrap/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('public/backend/usertemplate/assets/js/jquery.backstretch.min.js')}}"></script>

    <script src="{{asset('public/backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js')}}"></script>

    <script src="{{asset('public/backend/usertemplate/assets/js/jquery.mousewheel.min.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {

        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on(
            'focus',
            function() {

                $(this).removeClass('input-error');

            });

        $('.login-form').on('submit', function(e) {

            $(this).find('input[type="text"], input[type="password"], textarea').each(function() {

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
    var base_url = "{{url('')}}/";
    $(document).ready(function() {

        var class_id = $('#class_id').val();
        var section_id = '0';

        getSectionByClass(class_id, section_id);

        $(document).on('change', '#class_id', function(e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            getSectionByClass(class_id, 0);
        });
        $(document).on('change', '#tradegroup', function(e) {
            var tradegroup = $('#tradegroup').val();
            $.ajax({
                url: "{{url('')}}/welcome/gettrades",
                type: "POST",
                data: {
                    tradegroup: tradegroup
                },
                dataType: 'html',
                success: function(res) {
                    $('#trade').html(res);
                }
            });
        });





        function getSectionByClass(class_id, section_id) {

            if (class_id !== "") {
                $('#section_id').html("");

                var div_data = '';
                var url = "";

                $.ajax({
                    type: "POST",
                    url: base_url + "welcome/getSections",
                    data: {
                        'class_id': class_id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#section_id').addClass('dropdownloading');
                    },
                    success: function(data) {
                        $.each(data, function(i, obj) {
                            var sel = "";
                            if (section_id === obj.section_id) {
                                sel = "selected";
                            }
                            div_data += "<option value=" + obj.id + " " + sel + ">" + obj
                                .section + "</option>";
                        });
                        $('#section_id').append(div_data);
                    },
                    complete: function() {
                        $('#section_id').removeClass('dropdownloading');
                    }
                });
            }
        }

    });
    </script>

</body>

</html>