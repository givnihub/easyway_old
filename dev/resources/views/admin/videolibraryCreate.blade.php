@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header');
        @include('admin.include.sidebar');



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS </h1>

            </section>
            <?php if ($_GET['id'] != '') {
                $id = $_GET['id'];
            } ?>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="row">
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
                        <form id="form1" action="{{url('master/videolibrary/create')}}" enctype="multipart/form-data"
                            id="employeeform" name="employeeform" method="post" accept-charset="utf-8">

                            @csrf
                            <input type="hidden" value="<?=$id?>" name="uid">
                            <div class="col-md-9">
                                <!-- Horizontal Form -->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Add Video Library</h3>
                                        <div class="box-tools pull-right">
                                            <a href="{{url('master/videolibrary')}}" class="btn btn-sm btn-primary"><i
                                                    class="fa fa-list-alt"></i> Video Library List</a>

                                        </div>
                                    </div>
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Video Title</label><small class="req">
                                                *</small>
                                            <input id="name" name="name" placeholder="Enter Video Title" type="text"
                                                value="<?= $res[0]->name; ?>" class="form-control" required />
                                            <span class="text-danger">@error('name'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Trade Group Name</label><small class="req">
                                                *</small>
                                            <select id="tradegroup" name="tradegroup"
                                                placeholder="Enter Trade Group Name" class="form-control" required />
                                            <option value="">Select Trade Group</option>
                                            @foreach($list as $row)

                                            <option value="<?= $row->id ?>" <?php if (!empty($id)) {
                                                                                if ($res[0]->tradegroup == $row->id) {
                                                                                    echo 'selected';
                                                                                }
                                                                            } ?>><?= $row->name ?> </option>
                                            @endforeach
                                            </select>
                                            <span class="text-danger">@error('tradegroup'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Trade </label><small class="req"> *</small>
                                            <select id="trade" name="trade" placeholder="Enter Trade Group Name"
                                                class="form-control" required />
                                            <option value="">Select Trade</option>
                                            @if(!empty($id))
                                            <option value="<?= $res[0]->trade ?>" selected><?php $trades = DB::select('select name from trade where id=' . $res[0]->trade);
                                                                                            echo $trades[0]->name; ?>
                                            </option>
                                            @endif
                                            </select>
                                            <span class="text-danger">@error('trade'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Subject </label><small class="req">
                                                *</small>
                                            <select id="subject" name="subject" placeholder="Enter Trade Group Name"
                                                class="form-control" required />
                                            <option value="">Select Subject</option>
                                            @if(!empty($id))
                                            <option value="<?= $res[0]->subject ?>" selected>
                                                <?php $subjects = DB::select('select name from subject where id=' . $res[0]->subject);
                                                                                                echo $subjects[0]->name; ?></option>
                                            @endif
                                            </select>
                                            <span class="text-danger">@error('subject'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chapter </label><small class="req">
                                                *</small>
                                            <select id="chapter" name="chapter" placeholder="Enter Trade Group Name"
                                                class="form-control" required />
                                            <option value="">Select Chapter</option>
                                            @if(!empty($id))
                                            <option value="<?= $res[0]->chapter ?>" selected>
                                                <?php $chapter = DB::select('select name from chapter where id=' . $res[0]->chapter);
                                                                                                echo $chapter[0]->name; ?></option>
                                            @endif
                                            </select>
                                            <span class="text-danger">@error('chapter'){{$message}}@enderror</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Topic </label><small class="req"> *</small>
                                            <select id="topic" name="topic" placeholder="Enter Trade Group Name"
                                                class="form-control" required />
                                            <option value="">Select topic</option>
                                            @if(!empty($id))
                                            <option value="<?= $res[0]->topic ?>" selected><?php $topic = DB::select('select name from topics where id=' . $res[0]->topic);
                                                                                            echo $topic[0]->name; ?>
                                            </option>
                                            @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Youtube Video ID</label><small class="req">
                                                *</small>
                                            <input id="vid" name="vid" placeholder="Enter Youtube Video ID" type="text"
                                                value="<?= $res[0]->vid; ?>" class="form-control" required />
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Upload Video</label><small class="req">
                                                *</small>
                                            <input id="uvid" name="uvid" type="file" class="filestyle form-control" />
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Duration</label>
                                            <input id="duration" name="duration" value="<?php if($res[0]->duration!=''){echo $res[0]->duration;}else{echo '00:00:00';} ?>"
                                                placeholder="Enter Video Duration" type="text" class="form-control"
                                                required />
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn cfees btn-block"><i class="fa fa-save"></i>
                                                Save</button>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>
                            </div>

                        </form>
                    </div>

            </section><!-- /.content -->
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

                    }


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
                let groupid = $('#tradegroup').val();
                let tradeid = $('#trade').val();
                let subjectid = $('#subject').val();
                let chapterid = $(this).val();
                $.ajax({
                    url: '{{url("ajax/topic")}}',
                    type: "GET",
                    data: {
                        'groupid': groupid,
                        'tradeid': tradeid,
                        'subjectid': subjectid,
                        'chapterid': chapterid

                    },
                    success: function(data) {
                        $('#topic').empty();
                        $('#topic').append(data);

                    }
                });
            });
        });
        </script>
        @include('admin.include.footer');