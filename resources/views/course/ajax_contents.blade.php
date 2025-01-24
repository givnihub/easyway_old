 <div id="dynamic_folder">
     <input type="hidden" value="{{$folderid}}" id="folderid">
     <input type="hidden" value="{{$coursid}}" id="coursid">
     <?php if (sizeof($folder) == 0 && sizeof($videos) == 0 && sizeof($document) == 0  && sizeof($exam) == 0) {
            echo "<h3>       You haven't uploaded any content yet.
                                        Select the content from the right panel to start adding here</h3>";
        } ?>
     <?php
        if ($folderid != '0') {
            $backid = DB::select("select parent_folder_id from folders where folder_id=" . $folderid);
        ?>
         <div class="row text-left " style="padding-bottom: 10px; font-size:20px; margin-left:22px;">
             <a href="javascript:void()" class="go_back btn btn-success" data-id="{{$backid[0]->parent_folder_id}}">

                 Go Back
             </a>

         </div>
     <? } ?>


 </div>

 <div id="list">
     <div id="response"> </div>

     <ul>
         @foreach($folder as $rowss)
         <?php
            $parent_folder = DB::table("folders")->where("parent_folder_id", $rowss->folder_id)->get();
            $all_videos = DB::table("videos")->where("folder_id", $rowss->folder_id)->count();
            $all_document = DB::table("course_document")->where("folder_id", $rowss->folder_id)->count();
            $testseries = DB::table("course_exam")->where("folder_id", $rowss->folder_id)->count();
            foreach ($parent_folder as $runs) {
                $all_videos +=  DB::table("videos")->where("folder_id", $runs->folder_id)->count();
                $all_document +=  DB::table("course_document")->where("folder_id", $runs->folder_id)->count();
                $testseries += DB::table("course_exam")->where("folder_id", $runs->folder_id)->count();
                $subfolders = DB::table("folders")->where("parent_folder_id", $runs->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                foreach ($subfolders as $runs2) {
                    $all_videos +=  DB::table("videos")->where("folder_id", $runs2->folder_id)->count();
                    $all_document +=  DB::table("course_document")->where("folder_id", $runs2->folder_id)->count();
                    $testseries += DB::table("course_exam")->where("folder_id", $runs2->folder_id)->count();

                    $subfolders2 = DB::table("folders")->where("parent_folder_id", $runs2->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders2 as $run3) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs3->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs3->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs3->folder_id)->count();
                    }
                    $subfolders3 = DB::table("folders")->where("parent_folder_id", $runs3->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders3 as $run4) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs4->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs4->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs4->folder_id)->count();
                    }
                    $subfolders4 = DB::table("folders")->where("parent_folder_id", $runs4->folder_id)->get(['id', 'folder_id', 'parent_folder_id', 'course_id']);
                    foreach ($subfolders4 as $run5) {
                        $all_videos +=  DB::table("videos")->where("folder_id", $runs5->folder_id)->count();
                        $all_document +=  DB::table("course_document")->where("folder_id", $runs5->folder_id)->count();
                        $testseries += DB::table("course_exam")->where("folder_id", $runs5->folder_id)->count();
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
           <p>{{$row->exam}}</p>

            </div> 

            <div class=" col-md-7 text-left">
                         <span>Duration : {{$row->duration}}</span>
                         <br />
                         <span>
                            
                             @if($pay_status=='paid')
                             <a data-placement="left" href="{{url('user/onlineexam/view/')}}/{{$row->id}}" class="btn btn-xs btn-success" data-toggle="tooltip" title="View">
                                 Start Exam
                             </a>
                             @endif
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
                 <div class="col-md-2 text-left @if($pay_status!='paid') @if($video->status=='1') youtubevideo  @endif @else youtubevideo @endif" @if($pay_status!='paid' ) @if($video->status=='1') data-video_id="{{$video->video_id}}" @endif @else data-video_id="{{$video->video_id}}" @endif>
                     <img src="http://i3.ytimg.com/vi/<?= $video->video_id ?>/0.jpg" style="height:100px">

                     <div class="overlay--fullscreen-small"></div>
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
                 @if($pay_status!='paid')
                 <div class="col-md-3 text-right">

                     @if($video->status=='0')
                     <i class="fa fa-lock"></i> Locked
                     @else
                     <i class="fa fa-unlock"></i> Unlocked
                     @endif
                 </div>
                 @endif
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
                     @if($pay_status!='paid')
                     @if($documents->status=='1')
                     <a href="{{asset('').$documents->document}}" @if($documents->download_status=='1') download @else
                         target="_blank" @endif><i class="fa fa-<?php if ($documents->download_status == '1') echo 'download';
                                                                else echo 'picture-o'; ?> fa-4x"></i></a>
                     @else
                     <a href="javascript:void()"><i class="fa fa-<?php if ($documents->download_status == '1') echo 'download';
                                                                    else echo 'picture-o'; ?> fa-4x"></i></a>
                     @endif

                     @else
                     <a href="{{asset('').$documents->document}}" @if($documents->download_status=='1') download @else
                         target="_blank" @endif><i class="fa fa-<?php if ($documents->download_status == '1') echo 'download';
                                                                else echo 'picture-o'; ?> fa-4x"></i></a>
                     @endif
                 </div>
                 <div class="col-md-7 text-left">
                     <span>Title : {{$documents->doc_name}}</span>
                     <br />
                     <span>Description : {{$documents->description}}</span>
                 </div>
                 <div class="col-md-3 text-right">
                     @if($pay_status!='paid')
                     @if($documents->status=='0')
                     <i class="fa fa-lock"></i> Locked
                     @else
                     <i class="fa fa-unlock"></i> Unlocked
                     @endif
                     @endif
                 </div>
             </div>
         </li>
         @endforeach
     </ul>
 </div>

 </div>