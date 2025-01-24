<!DOCTYPE html>
<html dir="ltr" lang="en">
 @php   $default=DB::table("general_setting")->first(['title','small_logo']); @endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=macintosh">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$page->title?$page->title:$default->title}}</title>
    <meta name="title" content="{{$page->meta_title?$page->meta_title:$default->title}}">
    <meta name="keywords" content="{{$page->meta_keywords?$page->meta_keywords:$default->title}}">
    <meta name="description" content="{{$page->meta_description?$page->meta_description:$default->title}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset($default->small_logo)}}"
        type="image/x-icon">
    <link href="{{asset('public/backend/themes/yellow/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/themes/yellow/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/themes/yellow/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/themes/yellow/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/backend/dist/css/course_addon.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/backend/themes/yellow/datepicker/bootstrap-datepicker3.css')}}" />
    <script src="{{asset('public/backend/themes/yellow/js/jquery.min.js')}}"></script>
 

    <style type="text/css">
    .header-top-right {
        text-align: right;
        margin-top: 3px;
    }

    .header-top-right ul li {
        float: left;
        position: relative;
        list-style: none;
        font-size: 16px;
        padding-right: 0;
        display: inline-block;
    }

    .bredcrumb {
        padding: 100px;
        background-size: 100% 100%;
    }

    .toper {
        margin-top: 70px;
    }

    .mob-extra-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .mob-extra-menu li {
        display: inline-block;
        width: 32%;
        padding: 0;
    }

    .mob-extra-menu .img-fluid {
        height: 40px;
        width: 60px;
    }

    @media(max-width: 767px) {
        .bredcrumb {
            padding: 40px;
            background-size: 100% 100%;
        }

        .toparea {
            display: none;
        }

        .toper {
            margin-top: 0px;
        }
    }

    .minpad .btn {
        padding: 5px 11px;
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