
@include('home.include.head')

<body>

@if($viewType!='webview')
    @include('home.include.header')
    @include('home.include.menu')
    @endif

    </div>
    <div class="toper">
        <div class="post-list spaceb50" id="postList">

            <img src="{{$page->feature_image}}" style="width:100%;" />
            <div class="container">
              @if(Request::segment('1')=='contact-us')
                <div class="row">
                    
                    <h2>Send In Your Query</h2>
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
                    <p>&nbsp;</p>

                    <div class="col-md-12 col-sm-12">
                        <form action="{{url('contact-us-submit')}}" id="open" class="form-horizontal col-sm-12" autocomplete="on" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                           @csrf
                            <div class="form-group"><label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-9"><input type="text" name="name" value="" id="name" placeholder="Enter Your Name" validation="trim|required|xss_clean" class="form-control"> </div>
                            </div>
                            <div class="form-group"><label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-9"><input type="email" name="email" value="" id="email" placeholder="Enter Your Email" validation="trim|required|valid_email|xss_clean" class="form-control"> </div>
                            </div>
                            <div class="form-group"><label for="subject" class="col-sm-2 control-label">Subject</label>
                                <div class="col-sm-9"><input type="text" name="subject" value="" id="subject" placeholder="Enter Subject" validation="trim|required|xss_clean" class="form-control"> </div>
                            </div>
                            <div class="form-group"><label for="contact" class="col-sm-2 control-label">Contact</label>
                                <div class="col-sm-9"><input type="text" name="contact" value="" id="contact" placeholder="Enter Mobile Number" validation="trim|required|xss_clean" class="form-control"> </div>
                            </div>
                            <div class="form-group"><label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-9"><textarea name="description" cols="40" rows="10" id="description" placeholder="Enter Description" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group"><label for="submit" class="col-sm-2 control-label"></label>
                                <div class="col-sm-9"><input type="submit" name="submit" value="Submit" class="btn btn-primary pull-right"> </div>
                            </div>
                        </form>
                        <!--./row-->
                    </div>
                    <!--./col-md-12-->
                </div>
@endif

                {!! $page->description !!}
            </div>




        </div>
    </div>

   @if($viewType!='webview')
    @include('home.include.footer')
    @else
       @include('home.include.script')
    @endif