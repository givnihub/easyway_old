@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
<style>
  @media print{
   .noprint{
       display:none;
   }
}
</style>
        @include('admin.include.header');
        @include('admin.include.sidebar');
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Tutorial </h1>
            </section>
            <!-- Main content -->
            <section class="content">
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
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                            <?php $exam=DB::table("onlineexam")->where("id",$_GET['examid'])->get()->first();?>
                           
                                <h3 class="box-title titlefix">Online Exam Question List

                                 ({{$exam->exam}})
                                </h3>
                                
                            </div><!-- /.box-header -->
                            <div class="box-body">
                             
                            <div class="download_label">Online Exam Question List
                              

                                </div>
                                <div class="mailbox-controls">
                                    <div class="pull-right">
                                    </div><!-- /.pull-right -->
                                </div>
                                <div class="mailbox-messages">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                                <tr>
                                                    <th>QID</th>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th class="text-right noprint">
                                                        Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($list as $row)
                                                <?php $question=DB::table("questions")->where("id",$row->question_id)->first();
                                                             $correctAns= $question->correct;
                                                             
                                                ?>
                                                <tr>
                                                    <td>{{$row->id}} </td>
                                                   
                                                   <td>{{$question->question}}</td>
                                                   <td> {{ $question->$correctAns;}}</td>
                                                   <td><a href="{{url('exam/getExamQuestions')}}?examid={{$_GET['examid']}}&delid={{$row->id}}" onclick="return confirm('Are you sure..?')"><i class="fa fa-trash"></i></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div><!-- /.mail-box-messages -->
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>
       



        </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
     
    @include(' admin.include.footer');