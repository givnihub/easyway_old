@include('admin.include.head')
<body class="hold-transition skin-blue fixed sidebar-mini">
    @include('admin.include.header')
    @include('admin.include.sidebar')
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-bus"></i> Question</h1>
        </section>
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-primary" id="route">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix">Question Bank</h3>
                        </div>
                        <div class="box-body">

                            <div class="mailbox-messages">
                                <div class="row mb10">

                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <b> Trade Group</b> : <?php

                                                                $run = DB::table('tradegroup')->where('id', $res->tradegroup)->first(['name']);
                                                                echo $run->name;
                                                                ?> </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <b> Trade </b> :<?php

                                                        $run = DB::table('trade')->where('id', $res->trade)->first(['name']);
                                                        echo $run->name;
                                                        ?> </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <b> Subject </b> :<?php
                                                            $run = DB::table('subject')->where('id', $res->subject)->first();
                                                            echo $run->name;
                                                            ?> </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <b>Chapter </b> :<?php

                                                            $run = DB::table('chapter')->where('id', $res->chapter)->first();
                                                            echo $run->name;
                                                            ?> </div>

                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <b>Topic </b> :<?php

                                                        $run = DB::table('topics')->where('id', $res->topic)->first();
                                                        echo $run->name;
                                                        ?> </div>
                                    <!--lcol-lg-6-->
                                </div>
                                <div class="questiondetail"><b>Question:</b>
                                    {!!$res->question!!} </div>

                                <div class="@if($res->correct=='opt_a') active @endif quesanslist">
                                    Option A :&nbsp; {!!$res->opt_a!!} </div>
                                <div class="@if($res->correct=='opt_b') active @endif quesanslist">
                                    Option B :&nbsp; {!!$res->opt_b!!} </div>
                                <div class="@if($res->correct=='opt_c') active @endif quesanslist">
                                    Option C :&nbsp; {!!$res->opt_c!!} </div>
                                <div class="@if($res->correct=='opt_d') active @endif quesanslist">
                                    Option D :&nbsp;{!!$res->opt_d!!} </div>
                                <div class="@if($res->correct=='opt_e') active @endif quesanslist">
                                    Option E :&nbsp;{!!$res->opt_e!!} </div>
                                <h3>Explanation</h3>
                                {!!$res->explanation!!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    </div>

    @include('admin.include.footer')