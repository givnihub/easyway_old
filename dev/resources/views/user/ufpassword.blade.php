<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>{{$setting->title}}</title>
    <!--favican-->
    <link href="{{asset($setting->small_logo)}}" rel="shortcut icon" type="image/x-icon">
    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/usertemplate/assets/css/style.css')}}">

    <style type="text/css">
        body {
            background: linear-gradient(to right, #676767 0, #dadada 100%);
        }

        .nopadding {
            border-right: 0px solid #ddd;
        }
    </style>
</head>

<body>
    <!-- Top content -->
    <div class="top-content">
        <div class="inner-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 nopadding col-md-offset-4">
                        <div class="bgoffsetbg">

                            <div class="loginbg">
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
                                <div class="form-top">
                                    <div class="form-top-left logowidth">
                                        <img src="{{asset($setting->admin_logo)}}" />
                                    </div>

                                </div>
                                <div class="form-bottom">
                                    @if($pin!='')
                                    <h3 class="font-white bolds">Reset Password</h3>
                                    <form class="" action="" method="post">
                                        @csrf
                                        <div class="form-group has-feedback">
                                            <label class="sr-only" for="form-username">Username</label>
                                            <input type="hidden" name="email"  value="{{$email}}" placeholder="Email" class="form-username form-control" id="form-username">
                                            <input type="password" name="password"   placeholder="New Password" class="form-username form-control" id="form-username">
                                            <br/>
                                            <input type="password" name="confirm_password"   placeholder="Confirm password" class="form-username form-control" id="form-username">
                                            <span class="text-danger">@error('confirm_password'){{$message}}@enderror</span>
                                            <span class="text-danger"></span>
                                        </div>

                                        <button type="submit" class="btn">Reset password</button>
                                    </form>
                                    @else
                                    <h3 class="font-white bolds">Forgot Password</h3>
                                    <form class="" action="{{url('ufpassword')}}" method="post">
                                        @csrf
                                        <div class="form-group has-feedback">
                                            <label class="sr-only" for="form-username">Username</label>
                                            <input type="text" name="username" placeholder="Email" class="form-username form-control" id="form-username">
                                            <span class="fa fa-envelope form-control-feedback"></span>
                                            <span class="text-danger"></span>
                                        </div>

                                        <button type="submit" class="btn">Submit</button>
                                    </form>
                                    @endif
                                    <a href="{{url('userlogin')}}" class="forgot"><i class="fa fa-key"></i> User Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
    <script src="{{asset('public/backend/usertemplate/assets/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('public/backend/usertemplate/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/backend/usertemplate/assets/js/jquery.backstretch.min.js')}}"></script>
</body>

</html>