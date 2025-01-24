@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12 box box-primary">
                        <div class="box-header ptbnull noborder">
                            <h4 class="box-title titlefix"> Add Course</h4>
                        </div>
                        <div class="modal-body pt0 pb0">
                            <form id="add_course_form_ID" method="post" action="{{url('admin/addcourse')}}" class="ptt10" enctype="multipart/form-data">
                                <div class="">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$res->id}}">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <label>Course Name<small class="req"> *</small></label>
                                                <input autofocus="" name="title" placeholder="" value="{{$res->title}}" type="text" class="form-control" required /><span class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                                <label>Description<small class="req"> *</small></label>
                                                <textarea id="editor1" placeholder="" name="description" type="text" class="form-control" required>{{$res->description}}</textarea>
                                                <span class="text-danger"></span>
                                            </div>
                                                @if($res->id)
                                            <img src="{{asset('')}}{{$res->course_thumbnail}}" style="height:100px">
                                            @endif
                                        </div>
                                        <!--./col-lg-8-->
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Inline Preview Image <small class="req">
                                                        *</small></label>
                                                <input autofocus="" id="course_thumbnail" name="course_thumbnail" placeholder="" type="file" class="filestyle form-control" @if($res->id=='') required @endif/><span class="text-danger"></span>

                                            </div>

                                            <div class="form-group">
                                                <label>Trade Group<small class="req"> *</small></label>
                                                <select autofocus="" id="tradegroup_id" name="tradegroup_id" class="form-control tradegroup-list" required>
                                                    <option value="">Select</option>
                                                    @foreach($tradegroup as $row)
                                                    <option value="{{$row->id}}" @if($res->tradegroup_id==$row->id) selected @endif>{{$row->name}}</option>
                                                    @endforeach

                                                </select>
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="form-group">
                                            
                                                <label>Trade<small class="req"> *</small></label>
                                                <select autofocus="" id="trade_id" name="trade_id[]" multiple class="form-control select2" required>
                                                    <option value="">Select Trade</option>
                                                    @if($res->trade_id!='')
                                                    <?php 
                                                  $trade_id=explode(",",$res->trade_id);
                                                  for($i=0;$i<count($trade_id);$i++){?>
                                                     
                                                 
                                                    <option value="{{$trade_id[$i]}}" selected><?php $run = DB::table("trade")->where('id', $trade_id[$i])->get()->first();
                                                                                                echo $run->name;
                                                                                                ?></option>

<?}
                                                  ?>
                                                    @endif
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Course Type<small class="req"> *</small></label>
                                                <select autofocus="" id="course_type" name="course_type" class="form-control" required>
                                                    <option value="">Select Course Type</option>
                                                    @foreach($course_type as $runss)
                                                    <option value="{{$runss->id}}" @if($runss->id==$res->course_type) selected @endif>{{$runss->type}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Tag<small class="req"> *</small></label>
                                                <select autofocus="" id="tag" name="tag" class="form-control" required>
                                                    <option value="">Select Tag </option>
                                                 
                                                    <option value="online" @if($res->tag=='online') selected @endif>Online</option>

                                                    <option value="offline" @if($res->tag=='offline') selected @endif>Offline</option>
                                                     
                                                    <option value="both" @if($res->tag=='both') selected @endif>Both</option>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Course Validity ( In Month )<small class="req"> *</small></label>
                                                <input type="number" name="validity" value="{{$res->validity}}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>(Or) Set Expiry </label>
                                                <input type="date" name="expiry" value="{{$res->expiry}}" class="form-control">
                                            </div>

                                            @if($is_superadmin==1)

                                            <div class="form-group">
                                                <label>Assign Teacher<small class="req"> *</small></label>
                                                <select type="text" name="teacher[]" multiple class="form-control select2" required>
                                                    <option value="">Select Teacher</option>
                                                    @foreach($staff as $run_staff)
                                                    <?php $role = DB::table("roles")->where("id", $run_staff->role)->first(['name', 'is_superadmin']);
                                                    $count = DB::table("course_teacher")->where("teacher_id", $run_staff->id)->where("course_id", $res->id)->count();
                                                    ?>
                                                    <option value="{{$run_staff->id}}" @if($count>0) selected @endif>{{$run_staff->name}} {{$run_staff->surname}} ({{$role->name}})</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            @else
                                            <select name="teacher[]" multiple class="form-control" required style="display: none;">
                                                <option value="{{$teacher_id}}" selected>{{$teacher_id}}</option>
                                            </select>
                                            @endif
                                            <div class="form-group">
                                                <label>Live Classes<small class="req"> *</small></label>
                                                <select type="text" name="liveclass" class="form-control" required>
                                                    <option value="">Select</option>
                                                    <option value="yes" @if($res->liveclass=='yes') selected @endif>Yes</option>
                                                    <option value="no" @if($res->liveclass=='no') selected @endif>No</option>
                                                </select>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12"><label>Course Preview URL</label></div>
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <select id="course_provider" onclick="checkCourseProvider()" name="course_provider" class="form-control" required>
                                                            <option value="youtube">Youtube</option>
                                                            <option value="html5">Html5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 " id="course_url_div">
                                                    <div class="form-group">
                                                        <input autofocus="" id="course_url" name="course_url" value="{{$res->course_url}}" placeholder="" type="text" class="form-control" required />

                                                    </div>
                                                </div>

                                            </div>
                                            <!--./row-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Price<small class="req"> *</small></label>
                                                        <input autofocus="" id="course_price" name="course_price" value="{{$res->price}}" placeholder="" type="text" class="form-control" required /><span class="text-danger"></span>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Discount (%)</label>
                                                        <input autofocus="" id="course_discount" name="course_discount" value="{{$res->discount}}" placeholder="" type="text" class="form-control" /><span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Free Course</label>
                                                        <div class="checkbox mt4">
                                                            <label><input type="checkbox" value="1" @if($res->free_course==1) cheked @endif name="free_course" autocomplete="off" class="form-check-input"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--./row-->
                                        </div>
                                        <!--/.col (left) -->
                                    </div>
                                    <!--./row-->
                                </div>
                                <!--./scroll-area-->
                                <div class="row">
                                    <div class="box-footer row">
                                        <div class="pull-right">
                                            <button type="submit" id="add_course_btn" class="btn btn-info"><span id="loader_btn"></span>
                                                Add Content</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        <script>
            (function($) {
                'use strict';
                $(document).ready(function() {
                    $('.select2').select2();
                    emptyDatatable('course-list', 'data');
                    CKEDITOR.replace('editor1', {
                        allowedContent: true
                    });
                });

            }(jQuery));
            $(document).on('change', '#tradegroup_id', function(e) {
                var tradegroup = $('#tradegroup_id').val();
                $.ajax({
                    url: "{{url('ajax/gettrades')}}",
                    type: "GET",
                    data: {
                        tradegroup: tradegroup
                    },
                    dataType: 'html',
                    success: function(res) {
                        $('#trade_id').html(res);
                    }
                });
            });
        </script>
        @include('admin.include.footer')