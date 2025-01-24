<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover example">
        <thead>
            <tr>
                <th><input type="checkbox" id="mastercheck"></th>
                <th>Q.ID</th>
                <th>Question</th>
 
            </tr>
        </thead>
        <tbody>
            <div class="ajax_questions">
   
                @foreach($list as $row)
                <?php $count=DB::table("onlineexam_questions")->where("examid",$examid)->where("question_id",$row->id)->count();?>
                <tr>
                    <td> <input type="checkbox" value="{{$row->id}}" class="checkboxids" name="checkboxid[]" @if($count>0) checked @endif></td>
                    <td>{{$row->id}}</td>
                   
                    <td>{{$row->question}}....</td>
                    
                </tr>
                @endforeach
            </div>
        </tbody>
 
    </table><!-- /.table -->
    <div align="right" id="pagination_link">
        <ul class="pagination">{{$list->links()}} 

        </ul>
    </div>
</div>
</div>