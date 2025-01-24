@include('admin.include.head');

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header');
        @include('admin.include.sidebar');

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS </h1>

            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <form id="form1" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="employeeform" name="employeeform">
                        <div class="col-md-9">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-body">
                                    <h4><?= $res[0]->name ?></h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Trade Group</th>
                                            <td><?php
                                                $row = DB::select('select name from tradegroup where id=' . $res[0]->tradegroup);
                                                echo $row[0]->name;

                                                ?></td>
                                            <th>Trade</th>
                                            <td><?php
                                                $row = DB::select('select name from trade where id=' . $res[0]->trade);
                                                echo $row[0]->name;

                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th>Subject</th>
                                            <td>T<?php
                                                    $row = DB::select('select name from subject where id=' . $res[0]->subject);
                                                    echo $row[0]->name;

                                                    ?></td>
                                            <th>Chapter</th>
                                            <td><?php
                                                $row = DB::select('select name from chapter where id=' . $res[0]->chapter);
                                                echo $row[0]->name;

                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th>Topic</th>
                                            <td><?php
                                                $row = DB::select('select name from topics where id=' . $res[0]->topic);
                                                echo $row[0]->name;

                                                ?></td>
                                            <th></th>
                                            <td></td>
                                        </tr>
                                    </table>

                                
                                </div><!-- /.box-body -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <iframe width="100%" height="480" src="https://www.youtube.com/embed/<?= $res[0]->vid ?>?modestbranding=1&autoplay=1&mute=0&rel=1&showinfo=0&loop=1&controls=1" rel="0"
                                                    frameborder="0"" title="YouTube video player"></iframe>
                                                   
                                                <div class="overlay--fullscreen"></div>
                                                </div>
                                </div>
                            </div>
                        </div>
                </div>

            </section><!-- /.content -->
        </div>
        @include('admin.include.footer');