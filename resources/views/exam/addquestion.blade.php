@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <style>
            @media print {
                .noprint {
                    visibility: hidden;
                }
            }
        </style>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary" id="route">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix pt5"> Add Questions</h3>
                                <!-- <button class="btn btn-primary btn-sm pull-right question-btn" data-recordid="0"><i class="fa fa-plus"></i> Add Exam</button> -->
                            </div>
                            <div class="box-body">
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div>
                                </div>
                                <form action="{{url('exam/addquestion')}}}" id="form" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body add_question_body">

                                        @csrf
                                        <input type="hidden" name="uid" value="{{$res->id}}">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="tradegroup">Trade Group</label><small class="req">*</small>
                                                <select class="form-control" name="tradegroup" id="tradegroup" required>
                                                    <option value="">Select</option>
                                                    @foreach($list as $row)
                                                    <option value="{{$row->id}}" @if($res->tradegroup==$row->id) selected @endif>{{$row->name}}</option>

                                                    @endforeach
                                                </select>
                                                <span class="text text-danger subject_id_error"></span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="trade">Trade</label><small class="req"> *</small>
                                                <select class="form-control" name="trade" id="trade" required>
                                                    <option value="">Select</option>
                                                    @if($res->id!='')
                                                    <?php

                                                    $run = DB::table('trade')->where('id', $res->trade)->first();

                                                    ?>
                                                    <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                    @endif
                                                </select>
                                                <span class="text text-danger class_id_error"></span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="subject">Subject</label>
                                                <select id="subject" name="subject" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @if($res->id!='')
                                                    <?php

                                                    $run = DB::table('subject')->where('id', $res->subject)->get()->first();

                                                    ?>
                                                    <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                    @endif
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="chapter">Chapter</label><small class="req"> *</small>
                                                <select class="form-control" name="chapter" id="chapter" required>
                                                    <option value="">Select</option>
                                                    @if($res->id!='')
                                                    <?php

                                                    $run = DB::table('chapter')->where('id', $res->chapter)->get()->first();

                                                    ?>
                                                    <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                    @endif
                                                </select>
                                                <span class="text text-danger subject_id_error"></span>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="topic">Topic</label><small class="req"> *</small>
                                                <select class="form-control" name="topic" id="topic" required>
                                                    <option value="">Select</option>
                                                    @if($res->id!='')
                                                    <?php

                                                    $run = DB::table('topics')->where('id', $res->topic)->get()->first();

                                                    ?>
                                                    <option value="{{$run->id}}" selected>{{$run->name}}</option>
                                                    @endif
                                                </select>
                                                <span class="text text-danger subject_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">

                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Question</label>
                                                <div class="form-group">
                                                    <textarea id="editor1" name="question" placeholder="" class="form-control ss" required>
                                                    {{$res->question}}
                                                    </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Option A</label>
                                                <div class="form-group">
                                                    <textarea id="editor2" name="option_a" placeholder="" class="form-control ss" required>
                                                    {{$res->opt_a}}
                                                    </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Option B</label>
                                                <div class="form-group">
                                                    <textarea id="editor3" name="option_b" placeholder="" class="form-control ss" required>
                                                    {{$res->opt_b}} </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Option C</label>
                                                <div class="form-group">
                                                    <textarea id="editor4" name="option_c" placeholder="" class="form-control ss" required>
                                                    {{$res->opt_c}} </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Option D</label>
                                                <div class="form-group">
                                                    <textarea id="editor5" name="option_d" placeholder="" " class=" form-control ss" required>
                                                    {{$res->opt_d}} </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Option E</label>
                                                <div class="form-group">
                                                    <textarea id="editor6" name="option_e" placeholder="" class="form-control ss" required>
                                                    {{$res->opt_e}} </textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Answer</label>
                                                <div class="form-group">
                                                    <select name="answer" id="answer" class="form-control">
                                                     <option value="">Select Answer</option>
                                                        <option value="opt_a" @if($res->correct=='opt_a') selected @endif>A</option>
                                                        <option value="opt_b" @if($res->correct=='opt_b') selected @endif>B</option>
                                                        <option value="opt_c" @if($res->correct=='opt_c') selected @endif>C</option>
                                                        <option value="opt_d" @if($res->correct=='opt_d') selected @endif>D</option>
                                                        <option value="opt_e" @if($res->correct=='opt_e') selected @endif>E</option>
                                                    </select>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="exampleInputEmail1">Explanation</label>
                                                <div class="form-group">
                                                    <textarea id="editor7" name="explanation" placeholder="" class="form-control" required>
                                                    {{$res->explanation}}</textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <span class="text text-danger question_error"></span>
                                                <span id="message"></span>
                                            </div>

                                            <div class="option_list">
                                                <div class="form-group">
                                                    @if($view!='view')
                                                    <div class="modal-footer">

                                                        <button type="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Save</button>
                                                        <button type="reset" class="btn btn-danger" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Saving...">Reset</button>
                                                    </div>
                                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tradegroup').change(function() {
                let groupid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/trade")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,

                    },

                    success: function(data) {
                        $('#trade').empty();
                        $('#trade').append(data);

                    },

                });
            });

            $('#trade').change(function() {
                let groupid = $('#tradegroup').val();

                let tradeid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/subject")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,
                        'tradeid': tradeid

                    },
                    success: function(data) {
                        $('#subject').empty();
                        $('#subject').append(data);

                    }
                });
            });

            $('#subject').change(function() {
                let groupid = $('#tradegroup').val();
                let tradeid = $('#trade').val();
                let subjectid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/chapter")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,
                        'tradeid': tradeid,
                        'subjectid': subjectid,

                    },

                    success: function(data) {
                        $('#chapter').empty();
                        $('#chapter').append(data);

                    }

                });
            });
            $('#chapter').change(function() {
                let chapterid = $(this).val();
                let groupid = $('#tradegroup').val();
                let tradeid = $('#trade').val();
                let subjectid = $('#subject').val();
                $.ajax({
                    url: '{{url("ajax/topic")}}',
                    type: "GET",
                    data: {
                        'chapterid': chapterid,
                        'groupid': groupid,
                        'tradeid': tradeid,
                        'subjectid': subjectid,

                    },

                    success: function(data) {
                        $('#topic').empty();
                        $('#topic').append(data);

                    }

                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('editor1', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor2', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor3', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor4', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor5', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor6', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
            CKEDITOR.replace('editor7', {
                allowedContent: true,
                filebrowserUploadUrl: "../../upload.php"
            });
        });
    </script>
    @if($view!='view')
    <script>
        $("#form").on('submit', (function(e) {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            e.preventDefault();
            if (CKEDITOR.instances.editor1.getData() == '' || CKEDITOR.instances.editor2.getData() == '' || CKEDITOR.instances.editor3.getData() == '' || CKEDITOR.instances.editor4.getData() == '' || CKEDITOR.instances.editor5.getData() == '') {
                alert('Question and options are required....');
                exit;
            }
            let uid = '{{$res->id}}';
            $.ajax({
                url: "{{url('exam/addquestion')}}",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#message").html('<div class="alert alert-warning" role="alert">Processing.Please wait....</div>').fadeOut();
                },
                success: function(data) {
                    CKEDITOR.instances.editor1.setData('');
                    CKEDITOR.instances.editor2.setData('');
                    CKEDITOR.instances.editor3.setData('');
                    CKEDITOR.instances.editor4.setData('');
                    CKEDITOR.instances.editor5.setData('');
                    CKEDITOR.instances.editor6.setData('');
                    CKEDITOR.instances.editor7.setData('');
                    if (uid != '') {
                        $('#message').html('<div class="alert alert-success" role="alert">Question updated succesfully...</div>').fadeIn();
                        window.history.go();
                    }
                    $('#message').html(data).fadeIn();

                },
                error: function(e) {
                    $("#message").html(e).fadeIn();
                }
            });
        }));
    </script>

    @endif

    @include('admin.include.footer')