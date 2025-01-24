<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>{{$setting->title}}</title>
    <link href="{{asset($setting->small_logo)}}" rel="shortcut icon" type="image/x-icon">
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
    <div class="top-content">
        <div class="inner-bg">
            <div class="container">
                <div class="row">

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
                    <div class="col-md-12" style="border-bottom: 1px solid #ccc;">
                        <div class="form-top-left logowidth">
                            <a href="index.html"> <img src="{{asset($setting->admin_logo)}}" /></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="loginbg loginradius">
                            <div class="form-bottom">
                                <h3 class="font-white">Already Registered ? Login</h3>
                                <form action="{{url('userlogin')}}" method="post">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <input type="text" name="username" value="" placeholder="Username" class="form-username form-control" id="email" required>
                                        <span class="fa fa-envelope form-control-feedback"></span>
                                        <span class="text-danger">@error('username'){{$message}}@enderror</span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="password" name="password" value="" placeholder="Password" class="form-password form-control" id="password" required>
                                        <span class="fa fa-lock form-control-feedback"></span>
                                        <span class="text-danger">@error('password'){{$message}}@enderror</span>
                                    </div>
                                    <button type="submit" class="btn">Sign In</button>
                                </form>
                                <p><a href="ufpassword" class="forgot"> <i class="fa fa-key"></i> Forgot
                                        Password</a> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12" style="border-left: 1px solid #ccc;">
                        <h3 class="font-white">Don't Have Account ? Register Now </h3>
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="active"><a data-toggle="tab" href="userlogin.html#onlinecourses">For Online
                                    Courses </a></li>
                            <li><a data-toggle="tab" href="userlogin.html#offlinecourses">For Offline Courses </a></li>
                        </ul>
                        <div class="tab-content" style="border: 1px solid #ccc;border-top: none;">
                            <div class="tab-pane fade in active" id="onlinecourses" role="tabpanel" aria-labelledby="onlinecourses">

                                <style>
                                    .req {
                                        color: red;
                                    }
                                </style>
                                <form id="onlineclass" class="spaceb60 spacet60" action="{{url('registration')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-6">
                                            @csrf
                                            <input type="hidden" name="type" value="1">
                                            <div class="form-group">
                                                <select id="tradegroup" name="tradegroup" class="form-control" required>
                                                    <option value="">Select Course</option>
                                                    @foreach($tradegroup as $run)
                                                    <option value="{{$run->id}}">{{$run->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="text-danger">@error('tradegroup'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="rollno" id="rollno1" value="">
                                            <div class="form-group">
                                                <select id="trade" name="trade" class="form-control" required>
                                                    <option value="">Select Trade</option>
                                                </select>
                                                <span class="text-danger">@error('trade'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input id="firstname" name="firstname" placeholder="Name*" type="text" class="form-control" value="{{old('firstname')}}" required />
                                                <span class="text-danger">@error('firstname'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control mobileno" value="{{old('mobileno')}}" id="mobileno" name="mobileno" placeholder="Mobile Number *" maxlength="10" required />
                                                <span class="text-danger">@error('mobileno'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" placeholder="Email *" required />
                                                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="form-control" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                                            </div>
                                        </div>

                 
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" value="{{old('password')}}" id="password" name="password" placeholder="Password" required />
                                                <span class="text-danger">@error('password'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" value="{{old('confirm_password')}}" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                                                <span class="text-danger">@error('confirm_password'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="btn-lg btn btn-success">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="offlinecourses" role="tabpanel" aria-labelledby="offlinecourses">
                                <form id="offlineclass" class="spaceb60 spacet60" action="{{url('registration')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                    <div class="row" style="padding: 10px;">
                                        <div class="col-md-6">
                                            @csrf
                                            <input type="hidden" name="type" value="0">
                                            <input type="hidden" name="rollno" id="rollno" value="">
                                            <div class="form-group">
                                                <select id="class_id" name="class_id" class="form-control" required>
                                                    <option value="">Select Class</option>

                                                    @foreach($class as $run)
                                                    <option value="{{$run->id}}">{{$run->class}}</option>
                                                    @endforeach


                                                </select>
                                                <span class="text-danger">@error('class_id'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <select id="section_id" name="batch_id" class="form-control" required>
                                                    <option value="">Select Batch</option>
                                                </select>
                                                <span class="text-danger">@error('batch_id'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input id="firstname" name="firstname" placeholder="Name*" type="text" class="form-control" value="{{old('firstname')}}" required />
                                                <span class="text-danger">@error('firstname'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control mobileno" value="{{old('mobileno')}}" id="mobileno" name="mobileno" placeholder="Mobile Number *" maxlength='10' required />
                                                <span class="text-danger">@error('mobileno'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" placeholder="Email *" required />
                                                <span class="text-danger">@error('email'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="form-control" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" value="{{old('password')}}" id="password" name="password" placeholder="Password" required />
                                                <span class="text-danger">@error('password'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" value="{{old('confirm_password')}}" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                                                <span class="text-danger">@error('confirm_password'){{$message}}@enderror</span>
                                            </div>
                                        </div>
                                 
                                       
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="btn-lg btn btn-success">Register</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
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


            $('#class_id').change(function() {
                let classtext = $("#class_id option:selected").text().substring(0, 2);
                $('#rollno').val(classtext);
            });
            $('#tradegroup').change(function() {
                let classtext = $("#tradegroup option:selected").text().substring(0, 2);
                $('#rollno1').val(classtext);
            });

            $('.mobileno').on('keypress change', function() {
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, "");
                });
            });

            $(document).on('change', '#tradegroup', function(e) {
                var tradegroup = $('#tradegroup').val();
                $.ajax({
                    url: "{{url('ajax/gettrades')}}",
                    type: "GET",
                    data: {
                        tradegroup: tradegroup
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#trade').html(res);
                    }
                });
            });

            $(document).on('change', '#class_id', function(e) {
                var classid = $(this).val();
                $.ajax({
                    url: "{{url('ajax/class_batches')}}",
                    type: "GET",
                    data: {
                        classid: classid
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#section_id').empty();
                        $('#section_id').append(res);

                    }
                });
            });



        });
    </script>

</body>

</html>