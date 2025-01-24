<div style="position:fixed;top: 0;z-index: 999999;width: 100%;">
    <style type="text/css">
        h2 {
            font-size: 18px;
        }

        @media(max-width: 767px) {
            h2 {
                font-size: 12px;
            }
        }

        .mobileonly,
        .mobtab {
            display: none;
        }

        .bredcrumb {
            height: 300px;
        }

        .mt80 {
            margin-top: 70px;
        }

        .newscontent {
            padding: 5px;
        }


        @media(max-width: 767px) {
            .mt80 {
                margin-top: 85px;
            }

            iframe {
                width: 100%;
                height: 200px;
            }

            .mobileonly {
                display: block;
                border: 2px solid #000;
                border-right: none;
                border-left: none;
                padding: 10px;
            }

            .bredcrumb {
                height: 150px;
            }

            .mobtab {
                display: inline-block;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .mobtab li {
                margin-top: 5px;
            }

            .mobtab li .btn {
                padding: 3px;
            }

            .sticky-top .col-md-3,
            .sticky-top .col-md-9 {
                padding: 0 5px;
            }
        }

        .newsticker a p {
            color: blue;
        }
    </style>
    <?php $setting = DB::select('select email,phone,whatsapp,admin_logo from general_setting'); ?>
    <header class="sticky-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-5">

                    <a class="logo" href="{{url('/')}}"><img src="{{asset('')}}<?= $setting[0]->admin_logo ?>" alt="" style="max-width: 100%;"></a>
                </div>
                <!--./col-md-4-->
                <div class="col-md-9 col-sm-12 col-xs-7">
                    <ul class="header-extras">
                        <li><a href="{{url('live-test')}}" class="btn btn-outline-success "><img src="https://www.madeeasy.in/images/blink-im.gif" alt="Live Classes" class="img-fluid"> <i class="fa fa-computer-speaker"></i> Live Test</a></li>
                        <li> <a href="{{url('all-courses')}}" class="btn btn-outline-primary "><i class="fa fa-video" aria-hidden="true"></i> All Courses </a></li>
                        <li> <a href="{{url('study-material')}}" class="btn btn-outline-danger "><i class="fa fa-book-reader" aria-hidden="true"></i> Study Material </a></li>
                        <li> <a href="{{url('career')}}" class="btn btn-outline-warning "><i class="fa fa-chalkboard-teacher" aria-hidden="true"></i> Career</a>
                        </li>
                        <li><a href="{{url('userlogin')}}" class="btn btn-outline-success "><i class="fa fa-lock" aria-hidden="true"></i> Login / Register</a></li>
                    </ul>
                    <ul class="header-extras minpad">

                        <li><a href="{{url('liveclass')}}" class="btn btn-outline-success "><img src="https://www.madeeasy.in/images/blink-im.gif" alt="Live Classes" class="img-fluid"> Live Classes</a></li>
                        <li><a href="{{url('quize')}}" class="btn btn-outline-success "> <i class="fa fa-keyboard"></i>
                                Quiz</a></li>
                        <li><a href="tel:<?= $setting[0]->phone ?>" class="btn btn-outline-success "><i class="fa fa-phone-alt" aria-hidden="true"></i>+91-<?= $setting[0]->phone ?></a>
                        </li>
                        <li> <a href="tel:<?= $setting[0]->whatsapp ?>" class="btn btn-outline-success "><i class="fa fa-phone-alt" aria-hidden="true"></i> + 91 - <?= $setting[0]->whatsapp ?>
                            </a></li>
                        <li> <a href="mailto:<?= $setting[0]->email ?>" class="btn btn-outline-success "><i class="fa fa-at" aria-hidden="true"></i> <?= $setting[0]->email ?></a></li>


                    </ul>
                    <ul class="minpad mobtab">
                        <li style="margin-left:20px;"><a href="frontend.html#" target="_blank" class="btn btn-outline-success "><img src="https://www.madeeasy.in/images/blink-im.gif" alt="Live Classes" class="img-fluid"> Live Classes</a></li>
                        <li><a href="tel:<?= $setting[0]->phone ?>" class="btn btn-outline-success "><i class="fa fa-phone-alt" aria-hidden="true"></i> <?= $setting[0]->phone ?> / <?= $setting[0]->whatsapp ?></a></li>



                    </ul>


                </div>
                <!--./col-md-8-->
            </div>
            <!--./row-->
        </div>
        <!--./container-->
    </header>