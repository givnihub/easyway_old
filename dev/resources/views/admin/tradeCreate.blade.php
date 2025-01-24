@include('admin.include.head');
    <body class="hold-transition skin-blue fixed sidebar-mini">
 
       <div class="wrapper">

            @include('admin.include.header');

            @include('admin.include.sidebar');
            
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 
 <?php if($_GET['id']!=''){
     $id=$_GET['id'];
 }?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
        @if(session('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> <?=@session('success')?>.
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?=@session('error')?>.
                    </div>
                    @endif
            <form id="form1" action="{{url('master/trade/create')}}" enctype="multipart/form-data" id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
               
            @csrf
            <div class="col-md-9">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Trade </h3>
                            <div class="box-tools pull-right">
                                <a href="{{url('master/trade')}}" class="btn btn-sm btn-primary"><i class="fa fa-list-alt"></i> Trade List</a>

                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
 
  
                        <div class="box-body">
                        <div class="form-group">
                                <label for="exampleInputEmail1">Trade Group Name</label><small class="req"> *</small>
                                <select id="tradegroup" name="tradegroup" placeholder="Enter Trade Group Name"  class="form-control"   required/>
                               @foreach($list as $row)
                               
                                <option value="<?=$row->id?>" <?php if($res[0]->tradegroup==$row->id){echo 'selected';}?>><?=$row->name?> </option>
                                @endforeach
</select>
<span class="text-danger">@error('tradegroup'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trade  Name</label><small class="req"> *</small>
                                <input id="name" name="name" placeholder="Enter Trade Group Name" type="text" class="form-control"  value="<?=$res[0]->name?>" required/>
                                <span class="text-danger">@error('name'){{$message}}@enderror</span>
                            </div>
                            <input type="hidden" name="uid" value="<?=$id?>">
                            <div class="form-group">
                                <button type="submit" class="btn cfees btn-block"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div><!-- /.box-body -->
                    </div>   
                </div>

            </form>
        </div>

    </section><!-- /.content -->
</div>
@include('admin.include.footer');