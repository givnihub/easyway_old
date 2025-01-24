@include('admin.include.head')

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        @include('admin.include.header')
        @include('admin.include.sidebar')
        <script src="https://ilikenwf.github.io/jquery.mjs.nestedSortable.js"></script>
        <style type="text/css">
            ol {
                margin: 0;
                padding: 0;
                padding-left: 30px;
            }

            ol.sortable {
                margin: 0 0 0 0px;
                padding: 0;
                list-style-type: none;
            }

            ol.sortable ol {
                margin: 0 0 0 25px;
                padding: 0;
                list-style-type: none;
            }

            .sortable li {
                margin: 7px 0 0 0;
                padding: 0;
                position: relative;
            }




            .material-switch>input[type="checkbox"] {
                display: none;
            }

            .material-switch>label {
                cursor: pointer;
                height: 0px;
                position: relative;
                width: 40px;
            }

            .material-switch>label::before {
                background: rgb(0, 0, 0);
                box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
                border-radius: 8px;
                content: '';
                height: 16px;
                margin-top: -8px;
                position: absolute;
                opacity: 0.3;
                transition: all 0.4s ease-in-out;
                width: 40px;
            }

            .material-switch>label::after {
                background: rgb(255, 255, 255);
                border-radius: 16px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
                content: '';
                height: 24px;
                left: -4px;
                margin-top: -8px;
                position: absolute;
                top: -4px;
                transition: all 0.3s ease-in-out;
                width: 24px;
            }

            .material-switch>input[type="checkbox"]:checked+label::before {
                background: inherit;
                opacity: 0.5;
            }

            .material-switch>input[type="checkbox"]:checked+label::after {
                background: inherit;
                left: 20px;
            }

            .ui-sortable-handle a {
                color: #444;
            }

            .tooltip.top .tooltip-inner {
                background-color: #000;
                padding: 5px 20px;
                opacity: 100;
                border-radius: 2px;

            }

            .tooltip.top .tooltip-arrow {
                border-top-color: #000;
                opacity: 0.5;
            }
        </style>



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <i class="fa fa-empire"></i> Front CMS </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Menu Item</h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->

                            <form id="form1" action="{{url('admin/addmenuitem')}}/{{Request::segment('3')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    <input type="hidden" name="menu_id" value="{{Request::segment('3')}}">
                                    <input type="hidden" name="uid" value="{{$_GET['uid']}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Menu Item</label><small class="req"> *</small>
                                        <input autofocus="" id="menu" name="menu" value="{{$res->menu}}" placeholder="" type="text" class="form-control" value="" />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">External URL</label>
                                        <div class="material-switch">
                                            <input id="ext_url" name="ext_url" type="checkbox" @if($res->ext_url>0) checked @endif  class="ext_url_chk" value="1" />
                                            <label for="ext_url" class="label-success"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Open In New Tab</label>
                                        <div class="material-switch">
                                            <input id="open_new_tab" name="open_new_tab" type="checkbox" @if($res->open_new_tab>0) checked @endif class="chk" value="1" />
                                            <label for="open_new_tab" class="label-success"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">External URL Address</label>
                                        <input id="ext_url_link" name="ext_url_link" type="text" class="form-control" value="{{$res->ext_url_link}}" disabled />
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pages</label>
                                        <select id="page_id" name="page_id" class="form-control">
                                            <option value="">Select</option>
                                            @foreach($pages as $runs)
                                            <option value="{{$runs->url}}" @if($runs->url==$res->page_id) selected @endif>{{$runs->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger"></span>
                                    </div>

                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!--/.col (right) -->
                    <!-- left column -->
                    <div class="col-md-4">
                        <!-- general form elements -->
                        <div class="box box-primary" id="holist">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix">Menu Item List</h3>
                            </div><!-- /.box-header -->
                            <form id="form1" action="{{url('admin/front/menus/update')}}" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                                <div class="box-body">
                                    <div class="mailbox-controls">
                                        <div class="pull-right">
                                        </div><!-- /.pull-right -->
                                    </div>
                                    <div class="table-responsive mailbox-messages">
                                        <div class="download_label">Menu Item List</div>

                                        <div class="menu-box">
                                            <ol class="sortable">


                                                @foreach($menu as $rows)

                                                <li id="list_{{$rows->id}}">
                                                    <div>
                                                        {{$rows->menu}}

                                                        <span class="pull-right">
                                                            <a href="{{url('admin/addmenuitem')}}/{{Request::segment('3')}}?uid={{$rows->id}}" class="btn btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-xs" title="Delete" data-id="{{$rows->id}}" id="deleteItem" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-remove"></i></a>
                                                        </span>

                                                    </div>

                                                    <ol class="submenu-list">
                                                        <?php
                                                        $rows2 = DB::table("front_cms_menu_items")->where("parent_id", $rows->id)->orderBy('weight')->get();
                                                        ?>
                                                        @foreach($rows2 as $submenu)
                                                        <li id="list_{{$submenu->id}}">
                                                            <div class="ui-sortable-handle">
                                                                {{$submenu->menu}}
                                                                <span class="pull-right">
                                                                    <a href="{{url('admin/addmenuitem')}}/{{Request::segment('3')}}?uid={{$submenu->id}}" class="btn btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                                                                    <a href="#" class="btn btn-xs" title="Delete" data-id="{{$submenu->id}}" id="deleteItem" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-remove"></i></a>
                                                                </span>

                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                </li>


                                                @endforeach


                                            </ol>
                                        </div>
                                    </div><!-- /.mail-box-messages -->
                                </div><!-- /.box-body -->

                            </form>
                        </div>
                    </div>
                    <!--/.col (left) -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                    </div>
                    <!--/.col (right) -->
                </div> <!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <script type="text/javascript">
            $(document).ready(function() {
                $('.ext_url_chk').change(function() {
                    var c = this.checked ? 1 : 0;
                    if (c) {
                        $('#ext_url_link').prop("disabled", false);
                    } else {
                        $('#ext_url_link').prop("disabled", true);

                    }
                });
                $('ol.sortable').nestedSortable({
                    disableNesting: 'no-nest',
                    forcePlaceholderSize: true,
                    handle: 'div',
                    helper: 'clone',
                    items: 'li',
                    maxLevels: 2,
                    opacity: .6,
                    tabSize: 25,
                    tolerance: 'pointer',
                    toleranceElement: '> div',
                    update: function() {
                        var list = $(this).nestedSortable('toHierarchy');
                        var urls = "{{url('admin/front/menus/updateMenu')}}";
                        $.ajax({
                            url: urls,
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                order: list
                            },

                            dataType: "html",
                            success: function(response) {

                            },
                            beforeSend: function() {

                            },
                            complete: function() {


                            }
                        });
                    }
                });
            });
        </script>
        <div class="delmodal modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                    </div>

                    <div class="modal-body">

                        <p>Are you sure want to delete item, this action is irreversible!</p>
                        <p>Do you want to proceed?</p>
                        <p class="debug-url"></p>
                        <input type="hidden" name="del_menuid" class="del_menuid" value="">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>


        <script>
             $(document).ready(function () {
        $('.delmodal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        })
            $('#confirm-delete').on('show.bs.modal', function(e) {
                var data = $(e.relatedTarget).data();
                $('.del_menuid', this).val("");
                $('.del_menuid', this).val(data.id);
            });


            $('#confirm-delete').on('click', '.btn-ok', function(e) {
                var $modalDiv = $(e.delegateTarget);
                var id = $('.del_menuid').val();
 

                $.ajax({
                    type: "post",
                    url: '{{"admin/front/menus/deleteMenuItem"}}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // dataType: 'JSON',
                    data: {
                        'id': id
                    },
                    beforeSend: function() {
                        $modalDiv.addClass('modalloading');
                    },
                    success: function(data) {
                        if (data == 1) {
                            successMsg('Menu delete successfully');
                            location.reload(true);

                        } else {
                            errorMsg('Some error occured');
                        }
                    },
                    complete: function() {

                        $modalDiv.removeClass('modalloading');

                    }
                });


            });
             });
        </script>
        @include('admin.include.footer')