<ul class="list-group" id="contact-list">   
@foreach($stafflist as $run)
<?php $role=DB::table("roles")->where("id",$run->role)->first();

?>            
<li class="list-group-item" data-user-type="{{$role->name}}" data-user-id="{{$run->id}}">
            <div class="col-xs-2 col-sm-1">
                
                <img src="{{asset('')}}{{$run->image}}" alt="{{$run->name}}" class="img-responsive">
            </div>
            <div class="col-xs-10 col-sm-9">
                <span class="name"> {{$run->name}}  {{$run->surname}}                      
                    </span>
                <br>

                <span>
                   
                ({{$role->name}})    
                </span>
            </div>
            <div class="clearfix"></div>
        </li>

        @endforeach
        @foreach($student as $run)

<li class="list-group-item" data-user-type="Student" data-user-id="{{$run->id}}">
            <div class="col-xs-2 col-sm-1">
                
                <img src="{{asset('')}}{{$run->photo}}" alt="{{$run->firstname}}" class="img-responsive">
            </div>
            <div class="col-xs-10 col-sm-9">
                <span class="name"> {{$run->firstname}}  {{$run->lastname}}                      
                    </span>
                <br>

                <span>
                            
                (Student)    
                </span>
            </div>
            <div class="clearfix"></div>
        </li>

        @endforeach
</ul>