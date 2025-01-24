@include('home.include.head')

<body>


    @include('home.include.header')
    @include('home.include.menu')
 
   
  
    <div class="toper">
        <div class="post-list spaceb50" id="postList">

            <img src="{{$list->image}}" style="width:100%;" />
            <div class="container">
            <div class="row">

            @foreach($video as $run)
               <div class="col-lg-4 youtubevideo" style="margin-top: 20px;"  data-video_id="{{$run->vid}}">
               <iframe width="100%" height="300px;"
                    src="https://www.youtube.com/embed/{{$run->vid}}?modestbranding=1&autoplay=0&mute=0&rel=1&showinfo=0&loop=1&controls=1"
                     frameborder="0" title="{{$run->title}}">
                </iframe>
                <div class="overlay--fullscreen"></div>
                <label>{{$run->name}}</label>
               </div>
               @endforeach
            
            </div>
           
            </div>

 
        </div>
    </div>
 
    @include('home.include.footer')