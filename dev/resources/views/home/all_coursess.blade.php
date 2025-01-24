@include('home.include.head')

<body>
  @include('home.include.header')
  @include('home.include.menu')

  <div class="toper">
  
    <section>
      <div class="container">
        <div class="row mt-5">
          @foreach($list as $row)
 
          
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="coursebox">
              <div class="coursebox-img">
                <img src="{{asset('')}}{{$row->course_thumbnail}}">
              </div>
              <div class="coursebox-body">
                <h4>{{$row->title}} :</h4>
                <div class="course-caption">
                  <span style="box-sizing: border-box; font-weight: 700;">{!!$row->description!!}

                </div>
                <div class="classstats">
                  <i class="fa fa-list-alt"></i>Trade Group - {{$row->tradegroup}} </div>
                <div class="classstats">
                  <i class="fa fa-list-alt"></i>Trade - {{$row->trade}}</div>
                <div class="classstats">
                  <i class="fa fa-list-alt"></i>Course Duration - {{$row->validity}} Months
                </div>
                <div class="classstats">
                  ₹ <del style="color:red">{{number_format($row->price,2)}}</del>

 
                  {{number_format($row->price-($row->price*(intval($row->discount)/100)),2)}} ({{$row->discount}} % Off)
                </div>

              </div>
              <div class="coursebtn">
                <a href="{{url('course/details/')}}/{{$row->id}}" class="btn btn-add" target="_blank">Course
                  Detail</a>
                <a href="{{url('course_payment/payment')}}/{{$row->id}}" class="btn btn-buygreen">Buy Now</a>
              </div>
            </div>
          </div>
          @endforeach
         
        </div>
        {{ $list->links() }}
      </div>
    </section>
  </div>
  </div>
  @include('home.include.footer')