@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border pb0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <h3 class="box-title header_tab_style">Add Exam</h3>
                                    </div>
                                </div>

                                <form id="examadd" method="post" action="" class="ptt10">
                                    @csrf
                                    <input type="hidden" name="add_courseexam_id" id="add_courseexam_id" value="{{Request::segment('3')}}">
                                    <input type="hidden" name="folderid" id="folderid" value="{{$_GET['folderid']}}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <table class="table table-striped table-bordered table-hover examlist">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: left;">Name</th>
                                                            <th style="text-align: left;">Type</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($list as $run)

                                                        <?php $count = DB::table("course_exam")->where("folder_id", $folderid)->where("exam_id", $run->id)->count(); ?>
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                <label for="exam10">
                                                                    <input type="checkbox" name="exam[]" value="{{$run->id}}" id="exam{{$run->id}}" @if($count>0) checked @endif/>
                                                                    {{$run->exam}}
                                                                </label>
                                                            </td>
                                                            <td style="text-align: left;">
                                                                {{$run->is_quiz?'Online Exam':'Live Quize'}} </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info pull-right" value="Save">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            (function($) {
                'use strict';
                $(document).ready(function() {
                    $('.examlist').DataTable({
                        paging: false
                    });
                });
            }(jQuery));
        </script>

        @include('admin.include.footer')