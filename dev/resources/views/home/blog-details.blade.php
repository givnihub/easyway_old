@include('home.include.head')
<body>
    @include('home.include.header')
    @include('home.include.menu')
 
    <div class="toper">
        <div class="post-list spaceb50" id="postList">

            <img src="{{$page->image}}" style="width:100%;" />
            <div class="container">
                <h2>{{$page->title}}</h2>
                {!! $page->description !!}
            </div>
        </div>
    </div>

    @include('home.include.footer')