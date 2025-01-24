@include('home.include.head')

<body>


    @include('home.include.header')
    @include('home.include.menu')

  
    <div class="toper">
        <div class="post-list spaceb50" id="postList">

            <img src="{{$list->image}}" style="width:100%;" />
            <div class="container">
            <div class="row">

            <?php $images=explode(",",$list->gallery_images);
            for($i=0;$i<count($images);$i++){
                $image=DB::table('front_cms_media_gallery')->where("id",$images[$i])->first();
               ?>
               <div class="col-lg-4" style="margin-top: 20px;">
               <img src="{{asset('public')}}/{{$image->dir_path}}{{$image->img_name}}" style="height:300px; width:100%" class="img img-responsive">
               </div>
               
            <?}
            ?>
            </div>
           
            </div>

        
           
 
        </div>
    </div>

    @include('home.include.footer')