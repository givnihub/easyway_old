<script type="text/javascript">
$(document).ready(function() {
    function slideout() {
        setTimeout(function() {
            $("javascript:void()response").slideUp("slow", function() {});
        }, 2000);
    }

    $("javascript:void()response").hide();
    $(function() {

        $("javascript:void()list ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("javascript:void()response").html(theResponse);
                    $("javascript:void()response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });

        $("javascript:void()refresh_video ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("javascript:void()response").html(theResponse);
                    $("javascript:void()response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });
        $("javascript:void()refresh_doc ul").sortable({
            opacity: 0.8,
            cursor: 'move',
            update: function() {

                var order = $(this).sortable("serialize") + '&update=update';
                $.get("{{url('ajax/update_order')}}", order, function(theResponse) {
                    $("javascript:void()response").html(theResponse);
                    $("javascript:void()response").slideDown('slow');
                    slideout();
                });
            }
            //video orders


        });
    });

});
</script>
<div id="dynamic_folder">

    <input type="hidden" value="{{$coursid}}" id="coursid">
            <?php
            if($showType>0){
            if (sizeof($folder)==0 && sizeof($videos)==0 && sizeof($document)==0 && sizeof($exam)==0) {
            echo "<h3>  You haven't uploaded any content yet.
            Select the content from the right panel to start adding here</h3>";
            } 
        }
            ?>
    <?php 
                                    if($folderid>0){
                                        $backid=DB::select("select parent_folder_id from folders where folder_id=".$folderid);
                                        ?>
    <div class="row text-left " style="padding-bottom: 10px; font-size:20px; margin-left:22px;">
        <a href="javascript:void()" class="view_folder btn-primary btn-sm" data-id="{{$backid[0]->parent_folder_id}}" data-courseid="{{$coursid}}">
            Go Back
        </a>

    </div>
    <?}else{?>

        <div class="row text-left " style="padding-bottom: 10px; font-size:20px; margin-left:22px;">
        <a href="{{ url()->previous() }}" class="btn-primary btn-sm">
            Go Back
        </a>

    </div> 
<?}?>

</div>

<div id="list">
    <div id="response"> </div>
    <ul>
            @foreach($courses as $run)
            <?php 
           
           
                      
                     ?>
<li>
<div class="row text-left folder_design">
                <div class="col-lg-12 col-md-12 col-sm-12">
            
                    <div class="row">
                    <a href="javascript:void()" class="view_folder" data-id="0" data-courseid={{$run->id}}>
                    <div class="col-lg-12 col-md-12 col-sm-12">  
                        <img src="{{asset('')}}{{$run->course_thumbnail}}" style="height:80px; width:120px;">
                        <span style="margin-left:10px;">{{$run->title}}</span> 
                    </div>
                   
                </a>
                    </div>
                
                </div>

           
                 
            </div>
</li>
            @endforeach

        @foreach($folder as $rowss)
        <?php 
          $all_videos=DB::table("videos")->where("folder_id",$rowss->folder_id)->count();
          $testseries=DB::table("course_exam")->where("folder_id",$rowss->folder_id)->count();
      $all_document=DB::table("course_document")->where("folder_id",$rowss->folder_id)->count();
        ?>
        <li id="arrayorder_{{$rowss->id}}">
            <div class="row text-left folder_design">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 text-left">   
                            <input type="checkbox" name="folderid[]" value="{{$rowss->folder_id}}" > </div>
                        <div class="col-lg-11 col-md-11 col-sm-11">    <a href="javascript:void()" class="view_folder" data-id="{{$rowss->folder_id}}" data-courseid="{{$rowss->course_id}}">
                        <i class="fa fa-folder fa-4x" aria-hidden="true"></i>
                        &nbsp;&nbsp; {{$rowss->folders}} <?php $course_name=DB::table("courses")->where("id",$rowss->course_id)->first('title'); ?>
                                             
                    </a>
                    <label>@if($all_videos>0) {{$all_videos}} (Videos) @endif</label>
                    &nbsp;<label>
                      @if($all_document>0) {{ $all_document}} (Files) @endif</label>
                        @if($testseries>0) {{ $testseries}} (Test Series) @endif</label>
                </div>
                    </div>

                </div>

                <div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-2 col-md-6 col-sm-12 text-right">
                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?fid={{$rowss->id}}"
                        role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                        data-original-title="Edit Folder" target="_blank"><i class="fa fa-edit"></i></a>

                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?delfolder={{$rowss->id}}"
                        role="button" class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                        data-original-title="Delete Folder"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<br />
<div id="view_exam">
    <ul>
        <table class="table table-striped table-bordered table-hover example">
            @foreach($exam as $row)
            <li>
                <div class="row folder_design"> 
                    <div class="col-md-2 text-left"">
               <p>  <input type="checkbox" name="examid[]" value="{{$row->id}}"> &nbsp;{{$row->exam}}</p>
 
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

           
                <div class="col-md-2 text-left">
                   <div class="row">
                       <div class="col-lg-2 col-md-2 col-sm-6">
                       <input type="checkbox" name="videoids[]" value="{{$video->id}}">
                       </div>
                       <div class="col-lg-10 col-md-10 col-sm-6">
                    
                       <div class="col-md-2 text-left youtubevideo" data-video_id="{{$video->video_id}}">
                    <img src="http://i3.ytimg.com/vi/<?= $video->video_id ?>/0.jpg" style="height:100px">

                    
                </div>
   
                       </div>
                   </div>
                 
                </div>
                <div class="col-md-7 text-left padd15">
                    <span>Title : {{$video->title}}</span>
                    <br />
                    <span>Description : {{$video->description}}</span>
                </div>
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
                    <a data-placement="left" href="javascript:void()"
                        onclick="ajax_folder('delete','{{$video->id}}','video')"
                        class="btn btn-default btn-xs delete_video" data-toggle="tooltip" title="Delete"
                        onclick="return confirm('Delete Confirm?');">
                        <i class="fa fa-remove"></i>
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<br />
<div id="refresh_doc">
    <ul>
        @foreach($document as $documents)
        <li id="documentarrayorder_{{$documents->id}}">
            <div class="row folder_design">
                <div class="col-md-2 text-left">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6">
                            <input type="checkbox" name="docids[]" value="{{$documents->id}}">
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6">
                        <a href="{{asset('').$documents->document}}" download><i class="fa fa-download fa-4x"></i></a>
                        </div>
                    </div>
                  
                </div>
                <div class="col-md-7 text-left">
                    <span>Title : {{$documents->doc_name}}</span>
                    <br />
                    <span>Description : {{$documents->description}}</span>
                </div>
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
                    <a data-placement="left" href="{{url('admin/addcontent')}}/{{$coursid}}?docid={{$documents->id}}"
                        class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit" target="_blank">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a data-placement="left" href="javascript:void()" class="btn btn-default btn-xs delete_doc"
                        onclick="ajax_folder('delete','{{$documents->id}}','doc')" data-toggle="tooltip" title="Delete"
                        onclick="return confirm('Delete Confirm?');">
                        <i class="fa fa-remove"></i>
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
</div>