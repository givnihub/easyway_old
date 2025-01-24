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
                   <?php  if(!empty($_GET['id'])){
                       $id=$_GET['id'];
                   }?>
                     
                     <form id="form1" action="{{url('admin/coupons')}}" enctype="multipart/form-data"
                        id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <input type="hidden" name="uid" value="<?=$id?>">
                        <div class="col-md-12">
                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Add Coupons</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                @csrf
                                <div class="box-body">
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Course</label><small class="req"> *</small>
                                        <select id="" name="course[]" multiple placeholder="" required 
                                            class="form-control select2">
                                            <option value="">Selecte Course</option>
                                            <option value="all">All Courses</option>
                                            @foreach($courses as $row)
                   <option value="{{$row->id}}">{{$row->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Title</label><small class="req"> *</small>
                                        <input type="text" id="title" name="title"  placeholder="Enter title" required 
                                            class="form-control">
                                           
                                    </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Code</label><small class="req"> *</small>
                                        <input class="form-control" id="couponCode" name="couponCode"
                                                                type="text" placeholder="Enter coupon code" />
                                           
                                    </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Off (In %)</label><small class="req"> *</small>
                                        <input class="form-control" id="off" min="1" name="off"
                                                                type="number" placeholder="off in (%)" />
                                           
                                    </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Valid from</label><small class="req"> *</small>
                                        <input class="form-control" id="validFrom" name="validFrom"
                                                                type="datetime-local" placeholder="Valid from " required="required" />
                                           
                                    </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Valid Till</label><small class="req"> *</small>
                                        <input class="form-control" id="validFrom" name="validTill"
                                                                type="datetime-local" placeholder="Valid from " required="required" />
                                           
                                    </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Limit Of Use</label><small class="req"> *</small>
                                        <input type="number" class="form-control" id="limitOfUse" name="limitOfUse"
                                                                type="number" minlength="1" placeholder="Enter limit of use" required="required" />
                                           
                                    </div>
                                    </div>

                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label><small class="req"> *</small>
                                        <select class="form-control" id="status" name="status"
                                                                required="required" />
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">InActive</option>

                                                            </select>
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                                <label class="col-sm-2"></label>
                                                <div class="col-sm-10">
                                                    <input type="submit" name="AddCoupons" class="btn btn-primary m-b-0" value="Add Coupons">
                                                </div>
                                            </div>
                                  
                                            <div class="mailbox-messages">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered table-hover example">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Course</th>
                                                            <th>CouponCode</th>
                                                            <th>Off(%)</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Limit</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($courses as $row)

                                                <?php 
                                                    $coupon=DB::table('coupon')->where('couponCode',$row->couponCode)->first();
                                                ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row->title ?></td>
                                                    <td><?= $coupon->couponCode ?></td>
                                                    <td><?= $coupon->off ?></td>
                                                    <td><?= $coupon->validFrom ?></td>
                                                    <td><?= $coupon->validTill ?></td>
                                                    <td><?= $coupon->limitOfUse ?></td>
                                                    <td><?= $row->status ? 'Active' : 'InActive' ?></td>
                                                    <td><a href="{{url('admin/coupons')}}?delid=<?=$row->id?>"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table><!-- /.table -->
                                    </div>
                                </div>
                                  
                                        </div>
                                   
                                    
                        </div>
                        
                        <!--/.col (right) -->
                        <!-- left column -->
                       

                    </form>
              
              
                
              
                </div>

            </section><!-- /.content -->
            
        </div><!-- /.content-wrapper -->
        <!-- Modal -->
       <script>
           
            (function($) {
                'use strict';
                $(document).ready(function() {
                    $('.select2').select2();
                  
                });

            }(jQuery));
       </script>
        @include('admin.include.footer');
         