@if($viewtype=='viewcontent')
<script type="text/javascript">
$(document).ready(function() {
    function slideout() {
        setTimeout(function() {
            $("#response").slideUp("slow", function() {});
        }, 2000);
    }

    $("#response").hide();
    $(function() {

        $("#list ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("#response").html(theResponse);
                    $("#response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });

        $("#refresh_video ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("#response").html(theResponse);
                    $("#response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });
        $("#refresh_doc ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("#response").html(theResponse);
                    $("#response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });
    });

});
</script>
@endif
<div id="dynamic_folder">

    <input type="hidden" value="{{$folderid}}" id="folderid">
    <input type="hidden" value="{{$coursid}}" id="coursid">
    <?php if (sizeof($folder)==0 && sizeof($videos)==0 && sizeof($document)==0 && sizeof($exam)==0 ) {
                                    echo "<h3>       You haven't uploaded any content yet.
                                        Select the content from the right panel to start adding here</h3>";
                                } ?>
    <?php 
                                    if($folderid!='0'){
                                        $backid=DB::select("select parent_folder_id from folders where folder_id=".$folderid);
                                        ?>
    <div class="row text-left " style="padding-bottom: 10px; font-size:20px; margin-left:22px;">
        <a href="javascript:void()" class="go_back btn btn-success" data-id="{{$backid[0]->parent_folder_id}}">

            Go Back
        </a>

    </div>
    <?}?>


</div>

<div id="list">
    <div id="response"> </div>
    @if($viewtype!='details')
    @if($folderid>0)
    <!--./row-->
    <div class="row">
        <div class="col-md-3">
            <h4 class="session-head" style="text-align: left;"> <label id="showHideVideo"
                    class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add Video </label></h4>

        </div>
        <div class="col-md-3">
            <h4 class="session-head" style="text-align: left;"><label id="showHideDocument"
                    class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add Documents </label></h4>
        </div>



        <div class="col-lg-3">
            <a href="{{url('exam/addexam')}}/{{$coursid}}?folderid={{$folderid}}" target="_blank">
                <h4 class="session-head" style="text-align: left;"> <label id="" class="btn btn-xs btn-primary"><i
                            class="fa fa-plus"></i> Add Test Series </label></h4>
            </a>
        </div>

<div class="col-lg-3">
            <a href="{{url('admin/importcontents')}}/{{$coursid}}?folderid={{$folderid}}" target="_blank">
                <h4 class="session-head" style="text-align: left;"> <label id="" class="btn btn-xs btn-primary"><i
                            class="fa fa-plus"></i> Import Folders </label></h4>
            </a>
        </div>


    </div>


    <div class="row">



        <!--./col-md-12-->
        <form role="form" id="schsetting_form" action="#" class="" method="post" enctype="multipart/form-data">
            @csrf
            <h4 class="session-head" style="text-align: left;">Add Videos </h4>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Title<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="video_folder_id" id="video_folder_id" class="form-control"
                            value="{{$folderid}}" required>
                        <input type="text" name="title" id="title" class="form-control" value="{{$video->title}}"
                            placeholder="Enter video title" required>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Video<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                        <input type="text" name="video_id" id="video_id" class="form-control"
                            value="{{$video->video_id}}" placeholder="Enter youtube id (Ex - J3Q-QQfUkOY)" required>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Desc.<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                        <textarea type="text" name="description" id="description" class="form-control" value=""
                            placeholder="Enter description" required>{{$video->description}}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Is Live.<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                   <select type="text" name="is_live" id="is_live" class="form-control"  required>
                                                        <option value="no" @if($video->is_live=='no') selected @endif>No</option>
                                                        <option value="yes" @if($video->is_live=='yes') selected @endif>Yes</option>

                                                        </select>
                    </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Live Date.<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                   <input  type="datetime-local" name="liveDate" id="liveDate" class="form-control" >
                                                        
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-primary submit_schsetting pull-right add_video"
                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                    Save</button>
            </div>
        </form>
    </div>
    <!-- add documentss -->
    <!--./row-->
    <div class="row">
        <div class="col-md-12">
            <div id="message"></div>

        </div>
        <!--./col-md-12-->
        <form id="add_documents" action="{{url('admin/adddocument')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h4 class="session-head" style="text-align: left;">Add Documents </h4>
            <input type="hidden" value="{{$folderid}}" name="folder_id">
            <input type="hidden" value="{{$coursid}}" name="course_id">

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Name<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                        <input type="text" name="doc_name" class="form-control" value="{{$doc->doc_name}}" required>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Doc.<small class="req"> *</small></label>
                    <div class="col-sm-10">
                        <input autofocus="" id="document" type="file" class="form-control files" name="document[]"
                            multiple required><span class="text-danger"></span>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-2">Desc.<small class="req">
                            *</small></label>
                    <div class="col-sm-10">
                        <textarea type="text" name="description" class="form-control">{{$doc->description}}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" id="submit_doc" class="btn btn-primary submit_schsetting pull-right edit_setting"
                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">
                    Save</button>
            </div>
        </form>
    </div>
    @endif
    @endif
    <ul>
        @foreach($folder as $rowss)
        <?php 
        
    $parent_folder=DB::table("folders")->where("parent_folder_id",$rowss->folder_id)->get();
      $all_videos=DB::table("videos")->where("folder_id",$rowss->folder_id)->count();
          $testseries=DB::table("course_exam")->where("folder_id",$rowss->folder_id)->count();
      $all_document=DB::table("course_document")->where("folder_id",$rowss->folder_id)->count();
    foreach($parent_folder as $runs)
    {
       
     $all_videos +=  DB::table("videos")->where("folder_id",$runs->folder_id)->count();
     $all_document +=  DB::table("course_document")->where("folder_id",$runs->folder_id)->count();
     $testseries+=DB::table("course_exam")->where("folder_id",$runs->folder_id)->count();
     $subfolders=DB::table("folders")->where("parent_folder_id",$runs->folder_id)->get(['id','folder_id','parent_folder_id','course_id']);
     foreach($subfolders as $runs2){
        $all_videos +=  DB::table("videos")->where("folder_id",$runs2->folder_id)->count();
        $all_document +=  DB::table("course_document")->where("folder_id",$runs2->folder_id)->count();
        $testseries+=DB::table("course_exam")->where("folder_id",$runs2->folder_id)->count();

        $subfolders2=DB::table("folders")->where("parent_folder_id",$runs2->folder_id)->get(['id','folder_id','parent_folder_id','course_id']);
        foreach($subfolders2 as $run3){
            $all_videos +=  DB::table("videos")->where("folder_id",$runs3->folder_id)->count();
            $all_document +=  DB::table("course_document")->where("folder_id",$runs3->folder_id)->count();
            $testseries+=DB::table("course_exam")->where("folder_id",$runs3->folder_id)->count();
    
        }
        $subfolders3=DB::table("folders")->where("parent_folder_id",$runs3->folder_id)->get(['id','folder_id','parent_folder_id','course_id']);
        foreach($subfolders3 as $run4){
            $all_videos +=  DB::table("videos")->where("folder_id",$runs4->folder_id)->count();
            $all_document +=  DB::table("course_document")->where("folder_id",$runs4->folder_id)->count();
            $testseries+=DB::table("course_exam")->where("folder_id",$runs4->folder_id)->count();
    
        }
        $subfolders4=DB::table("folders")->where("parent_folder_id",$runs4->folder_id)->get(['id','folder_id','parent_folder_id','course_id']);
        foreach($subfolders4 as $run5){
            $all_videos +=  DB::table("videos")->where("folder_id",$runs5->folder_id)->count();
            $all_document +=  DB::table("course_document")->where("folder_id",$runs5->folder_id)->count();
            $testseries+=DB::table("course_exam")->where("folder_id",$runs5->folder_id)->count();
    
        }
    }
    
    }
   
?>
        <li id="arrayorder_{{$rowss->id}}">
            <div class="row text-left folder_design">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <a href=javascript:void(); class="view_folder" data-id="{{$rowss->folder_id}}">
                        <i class="fa fa-folder fa-4x" aria-hidden="true"></i>
                        &nbsp;&nbsp; {{$rowss->folders}}
                    </a>
                    <label> @if($all_videos>0) {{$all_videos}} (Videos) @endif</label>
                    &nbsp;<label>
                        @if($all_document>0) {{ $all_document}} (Files) @endif</label>
                    &nbsp;<label>
                        @if($testseries>0) {{ $testseries}} (Test Series) @endif</label>

                </div>

                <div class="col-lg-2">&nbsp;</div>
                @if($viewtype=='viewcontent')
                <div class="col-lg-2 col-md-6 col-sm-12 text-right">
                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?fid={{$rowss->id}}"
                        role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                        data-original-title="Edit Folder" target="_blank"><i class="fa fa-edit"></i></a>
@if($role_id==7)
                    <a data-placement="left" onclick="return confirm('Are you sure to delete this.?')"
                        href="{{url('admin/addcontent')}}/{{$coursid}}?delfolder={{$rowss->id}}&folder_id={{$rowss->folder_id}}"
                        role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                        data-original-title="Delete Folder"><i class="fa fa-trash"></i></a>
                        @endif
                </div>
                @endif

            </div>
        </li>
        @endforeach
    </ul>
</div>
<br />


@if($viewtype!='0')
<div id="view_exam">

    <ul>
        <table class="table table-striped table-bordered table-hover example">

            @foreach($exam as $row)
            <li>
                <div class="row folder_design">
                    <div class="col-md-2 text-left"">
               <p>{{$row->exam}}</p>
 
                </div> 

                <div class=" col-md-7 text-left">
                        <span>Duration : {{$row->duration}}</span>
                        <br />
                        <span>

                            <a data-placement="left" href="{{url('user/onlineexam/view/')}}/{{$row->id}}"
                                class="btn btn-xs btn-success" data-toggle="tooltip" title="View">
                                Start Exam
                            </a>
                        </span>
                    </div>
                </div>

            </li>
            @endforeach
            </tbody>

        </table>
    </ul>
</div>

<div id="refresh_video">

    <ul>

        @foreach($videos as $video)
        <li id="videoarrayorder_{{$video->id}}">
            
            <div class="row folder_design">
                <div class="col-md-2 text-left youtubevideo" data-video_id="{{$video->video_id}}">
                    <img src="http://i3.ytimg.com/vi/<?= $video->video_id ?>/0.jpg" style="height:100px">

                    
                </div>
                <div class="col-md-7 text-left">
                    <span>Title : {{$video->title}}

                    @if($video->is_live=='yes')
                    <span class="blink_me">Live</span>
                    @endif

                    </span>
                    <br />
                    <span>Description : {{$video->description}}</span>
                </div>
                @if($viewtype=='viewcontent')
                <div class="col-md-3 text-right">
                    @if($video->status=='1')
                    <i class="fa fa-unlock"></i> Unlocked
                    @else
                    <i class="fa fa-lock"></i> Locked
                    @endif
                    &nbsp;&nbsp;
                    <a data-placement="left" href="javascript:void()"
                        onclick="ajax_folder('{{$video->status}}','{{$video->id}}','video')"
                        class="btn btn-default btn-xs" data-toggle="tooltip" title="Unlock">
                        @if($video->status=='0')
                        <i class="fa fa-unlock"></i>
                        @else
                        <i class="fa fa-lock"></i>
                        @endif
                    </a>
                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?videoid={{$video->id}}"
                        class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit" target="_blank">
                        <i class="fa fa-pencil"></i>
                    </a>
                     @if($role_id==7)
                    <a data-placement="left" href=javascript:void();
                        onclick="ajax_folder('delete','{{$video->id}}','video')"
                        class="btn btn-default btn-xs delete_video" data-toggle="tooltip" title="Delete"
                        onclick="return confirm('Delete Confirm?');">
                        <i class="fa fa-remove"></i>
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
    @endif
</div>
<br />
@if($viewtype!='0')
<div id="refresh_doc">
    <ul>
        @foreach($document as $documents)
        <li id="documentarrayorder_{{$documents->id}}">
            <div class="row folder_design">
                <div class="col-md-2 text-left">
                    <a href="{{asset('').$documents->document}}" @if($documents->download_status=='1') download @else
                        target="_blank" @endif><i
                            class="fa fa-<?php if($documents->download_status=='1')echo 'download'; else echo 'picture-o';?> fa-4x"></i></a>
                </div>
                <div class="col-md-7 text-left">
                    <span>Title : {{$documents->doc_name}}</span>
                    <br />
                    <span>Description : {{$documents->description}}</span>
                </div>
                @if($viewtype=='viewcontent')
                <div class="col-md-3 text-right">
                    @if($documents->status=='1')
                    <i class="fa fa-unlock"></i> Unlocked
                    @else
                    <i class="fa fa-lock"></i> Locked
                    @endif
                    &nbsp;&nbsp;

                    <a data-placement="left" href="javascript:void()" data-status=""
                        onclick="ajax_folder('{{$documents->status}}','{{$documents->id}}','doc')"
                        class="btn btn-default btn-xs update_doc_status" data-toggle="tooltip" title="Unlock">
                        @if($documents->status=='0')
                        <i class="fa fa-unlock"></i>
                        @else
                        <i class="fa fa-lock"></i>
                        @endif
                    </a>
                    <!-- change download status -->
                    <a data-placement="left" href="javascript:void()" data-status=""
                        onclick="ajax_folder('{{$documents->download_status>0?0:1}}','{{$documents->id}}','download_status')"
                        class="btn btn-default btn-xs download_status" data-toggle="tooltip"
                        title="Change Download Status">
                        @if($documents->download_status=='0')
                        <i class="fa fa-picture-o"></i>
                        @else
                        <i class="fa fa-download"></i>
                        @endif
                    </a>
                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?docid={{$documents->id}}"
                        class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit" target="_blank">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a data-placement="left" href=javascript:void(); class="btn btn-default btn-xs delete_doc"
                        onclick="ajax_folder('delete','{{$documents->id}}','doc')" data-toggle="tooltip" title="Delete"
                        onclick="return confirm('Delete Confirm?');">
                        <i class="fa fa-remove"></i>
                    </a>
                </div>
                @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif
</div>