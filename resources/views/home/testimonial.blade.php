@include('home.include.head')
 <body>
@if($viewType!='webview')
    @include('home.include.header')
    @include('home.include.menu')
    @endif
    <div class="toper">
        <style type="text/css">
            .maincontent img.img-responsive {
                height: 400px;
                width: 100%;
            }

            .sidebar img.img-responsive {
                height: 100px;
                width: 100%;
            }

            .thumbnail a h2 {
                margin: 0;
                font-size: 21px;
            }

            h1 {
                font-size: 16px;
            }

            .modal {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 99999999;
                display: none;
                overflow: hidden;
                -webkit-overflow-scrolling: touch;
                outline: 0;
            }
        </style>
 

  
        <section>
            <div class="container" style="padding-top: 45px;">
                <div class="row">
                    <div class="col-md-8 col-xs-12 col-12 maincontent">
                     
@if(strpos($page->image,"easywayglobal.in")>0)
    <img src="{{$page->image}}" style="width:100%;" />
@else
    <img src="{{asset('')}}{{$page->image}}" style="width:100%;" />

@endif
                      
                       
                        <h1>{{$page->title}}</h1>
                        <?php
                        $match = array();
                        preg_match('/src="([^"]+)"/', $page->description, $match);
                        if (count($match) > 0) {
                            $url = $match[1];
                            $url = str_replace('https://www.youtube.com/watch?v=', '', $url);
                            $url = str_replace('https://www.youtube.com/embed/', '', $url);
                            $match = explode("?", $url);
                        }

                        ?>
                        <!-- @if($url!='')
                        <p><iframe width="100%" height="420" src="https://www.youtube.com/embed/{{$match[0]}}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1" title="YouTube video player"></iframe></p>
                        <div class="overlay--fullscreen"></div>
                        <p>{{$page->short_description}}</p>
                        @else
                        {!! $page->description !!}
                        @endif -->

                        <!-- @if($url!='')
                        <p><iframe width="100%" height="420" src="https://www.youtube.com/embed/{{$match[0]}}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1" title="YouTube video player"></iframe></p>
                        <div class="overlay--fullscreen"></div>

                        @endif -->
           <p>{{$page->short_description}}</p>
                        {!! $page->description !!}
                    </div>
                    @if($viewType!='webview')
                    <div class="col-md-4 col-xs-12 sidebar " style="padding:0">


                        @foreach($all as $run_all)

                        <div class="row" style="padding:0;margin: 0;margin-bottom: 10px;">
                            <a href="{{url('read')}}/{{$run_all->url}}">
                                <div class="col-md-4 col-xs-4" style="padding:0">
                                @if(strpos($run_all->image,"easywayglobal.in")>0)
                                <img src="{{$run_all->image}}" class="img-responsive feature_image_url">
                                @else
                                <img src="{{asset('')}}{{$run_all->image}}" class="img-responsive feature_image_url">
                                @endif
                                   
                                </div>
                                <div class="col-md-8 col-xs-8" style="padding:5px">
                                    <h4 style="margin:0;color:#c72117">{{$run_all->title}}</h4>
                                    <p>{{$run_all->short_description}}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach

                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
    </div>
@if($viewType!='webview')
    @include('home.include.footer')
    @else
       @include('home.include.script')
    @endif