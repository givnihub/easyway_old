@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">

    <div class="wrapper">

        @include('admin.include.header')

        @include('admin.include.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                    <span id="message"></span>
                        <div class="box box-primary">
                            <div class="box-header with-border pb0">
                                <div class="row">
                                   
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <h3 class="box-title header_tab_style">Add Submenu</h3> &nbsp;

                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-4">
                                        <a href="{{url('admin/submenu')}}"><button class="btn btn-primary">Add Submenu</button></a>

                                    </div>
                                </div>


                                <form id="examadd" method="post" action="" class="ptt10">
                                    <input type="hidden" id="uid" name="uid" value="{{$res->id}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    <label>Menu</label>
                                                    <select name="menu_id" id="menu_id" class="form-control">
                                                        <option value="">Select Menu</option>
                                                        @foreach($menu as $runs)
                                                        <option value="{{$runs->id}}" @if($runs->id==$res->menu_id) selected @endif>{{$runs->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Title</label>
                                                    <input type="text" value="{{$res->title}}" id="title" name="title" class="form-control">
                                                </div>
                                                
                                                <div class="col-lg-3">
                                                    <label>Link</label>
                                                    <input type="text" name="link" id="link" value="{{$res->link}}" class="form-control">

                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Menu Icon</label>
                                                    <input type="text" name="icon" value="{{$res->icon}}" id="icon" class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <br />
                                                    
                                                    <button type="button" id="submit" class="btn btn-primary">Submit</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <table class="table table-striped table-bordered table-hover examlist">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Menu</th>
                                                        <th style="text-align: left;">Title</th>
                                                        <th style="text-align: left;">Icon</th>
                                                        <th style="text-align: left;">Link</th>
                                                        <th style="text-align: left;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($list as $run)

                                                    <tr>
                                                        <td style="text-align: left;">
                                                           @php $menu=DB::table("menu")->where("id",$run->menu_id)->first();
                                                              echo  $menu->title
                                                           @endphp

                                                        </td>
                                                        <td style="text-align: left;">
                                                            {{$run->title}}
                                                        </td>
                                                        <td style="text-align: left;">
                                                            {{$run->icon}} </td>
                                                        <td style="text-align: left;">
                                                            {{$run->link}} </td>
                                                        <td style="text-align: left;">
                                                            <a href="{{url('admin/submenu?id=')}}{{$run->id}}"><i class="fa fa-pencil"></i></a>
                                                               <a href="{{url('admin/submenu?delid=')}}{{$run->id}}" onclick="return confirm('Are you sure...?')"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


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
<script>
    $('#submit').on('click',function(){
        let menu_id=$('#menu_id').val();
        let title=$('#title').val();
        let icon=$('#icon').val();
        let link=$('#link').val();
        let uid=$('#uid').val();
        $.ajax({
                    url: '{{url("admin/submenu")}}',
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'menu_id': menu_id,
                        'title': title,
                        'icon': icon,
                        'link': link,
                        'uid':uid

                    },

                    success: function(data) {
                        $('#message').html(data);
                        $('#title').val('');
                        $('#link').val('');
                        $('#icon').val('');
                       
                     if(uid!=''){
                        location.replace("{{url('admin/submenu')}}");
                     }
                    },

                });
    });
    </script>
        @include('admin.include.footer')