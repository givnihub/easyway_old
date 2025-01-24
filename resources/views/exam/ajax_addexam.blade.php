<div class="modal-body">
                    <input type="hidden" name="uid" value="{{$res->id}}">
                 <div>
                     <div class="row">
                    <div class="col-sm-12">
                       
                    <div class="form-group">
                  <label class="checkbox-inline"><input type="checkbox" class="is_quiz" value="1" name="is_quiz" @if($res->is_quiz==1) checked @endif>Quiz</label>
                  <label class="checkbox-inline"><input type="checkbox" class="is_live" value="1" name="is_live" @if($res->is_live==1) checked @endif>Live</label>
                  <label class="checkbox-inline"><input type="checkbox" class="onlinetest" value="1" name="onlinetest" @if($res->onlinetest==1) checked @endif>Online Test</label>
                  <span class="help-block">In quiz result will be display to student immediately just after exam submission (descriptive question type will be disabled).</span>
                 </div>
                  
   
                     </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="exam">Exam Title</label><small class="req"> *</small>
                            <input type="text" class="form-control" id="exam" name="exam" value="{{$res->exam}}">
                            <span class="text text-danger exam_error"></span>
                        </div>
                     </div>

                    </div>
                    <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exam_from">Exam From</label><small class="req"> *</small>
                            <div class="input-group">
                            <input class="form-control" name="exam_from" type="datetime-local" id="exam_from" name="exam_from" value="{{$res->exam_from}}">
                            <span class="input-group-addon" id="basic-addon2">
                                <i class="fa fa-calendar">
                                </i>
                            </span>

                        </div>
                        <span class="text text-danger exam_from_error"></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exam_to">Exam To</label><small class="req"> *</small>

                     <div class="input-group">
                            <input class="form-control " name="exam_to" type="datetime-local" id="exam_to" name="exam_to" value="{{$res->exam_to}}">
                            <span class="input-group-addon" id="basic-addon2">
                                <i class="fa fa-calendar">
                                </i>
                            </span>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exam_to"> Auto Result Publish Date</label>
                          <div class="input-group">
                            <input class="form-control " name="auto_publish_date" value="{{$res->auto_publish_date}}" type="datetime-local" id="auto_publish_date" name="auto_publish_date">
                            <span class="input-group-addon" id="basic-addon2">
                                <i class="fa fa-calendar">
                                </i>
                            </span>
                        </div>
                       
                    </div>
                </div>
                    </div>
                    <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="duration">Time Duration</label><small class="req"> *</small>
                        <input type="text" class="form-control" value="{{$res->duration}}" placeholder="Use 00:00:00 formate" step="0.001" id="duration" name="duration">
                        <!-- <span class="text text-primary">Use 00:00:00 for no time limit</span> -->
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="attempt">Attempt</label><small class="req"> *</small>
                        <input type="number" min="1" class="form-control" id="attempt" name="attempt" value="{{$res->attempt}}">
                        <span class="text text-danger attempt_error"></span>
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="attempt">Passing Percentage</label><small class="req"> *</small>
                        <input type="number" min="1" max="100" class="form-control" id="passing_percentage" value="{{$res->passing_percentage}}" name="passing_percentage">
                        <span class="text text-danger passing_percentage_error"></span>
                    </div>

              
                </div>
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="attempt">Marks</label><small class="req"> *</small>
                        <input type="number" min="1" class="form-control" id="marks" name="marks" value="{{$res->marks}}">
                        <span class="text text-danger attempt_error"></span>
                    </div>
                </div>
                <div class="col-sm-4">
                      <div class="form-group">
                        <label for="attempt">Negative Marks</label><small class="req"> *</small>
                        <input type="number"  max="100" step="any" class="form-control" id="negative_marks" value="{{$res->negative_marks}}" name="negative_marks">
                        <span class="text text-danger passing_percentage_error"></span>
                    </div>
                    </div>
                <div class="row">
                   <div class="form-group col-sm-12">
        
                                     <label class="checkbox-inline">
<input type="checkbox" class="is_active" name="is_active" value="1" @if($res->is_active==1) checked @endif>
                                            Publish Exam                                        </label>

                                     <label class="checkbox-inline">
<input type="checkbox" class="publish_result" name="publish_result" value="1" @if($res->publish_result==1) checked @endif>
                                           Publish Result                                        </label>
               
       
                                     <label class="checkbox-inline">
<input type="checkbox" class="is_neg_marking" name="is_neg_marking" value="1" @if($res->is_neg_marking==1) checked @endif>
                                           Negative Marking                                        </label>

                                      <label class="checkbox-inline">
<input type="checkbox" class="is_marks_display" name="is_marks_display" value="1" @if($res->is_marks_display==1) checked @endif>
                                          Display marks in Exam                                        </label>
                 
                                      <label class="checkbox-inline">
<input type="checkbox" class="is_random_question" name="is_random_question" value="1" @if($res->is_random_question==1) checked @endif>
                                         Random Question Order                                        </label>  

                </div>

                </div>
                <div class="row">
                    
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="description">Description</label><small class="req"> *</small>
                        <textarea class="form-control" id="description" name="description">{{$res->description}}</textarea>
                        <span class="text text-danger description_error"></span>
                    </div>
                </div>
                </div>


                  </div>
                </div>