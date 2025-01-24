@include('home.include.head')

<body>
  @include('home.include.header')
  @include('home.include.menu')
  <div class="toper">
    <section class="bredcrumb" style="background:url({{asset('public/uploads/gallery/media/online-admission-easyway-iti-coaching-iti-course-iti-online-class-iti-college-iti-admission-ncvt-dgt-iti-job-iti-government-job.jpeg')}});background-size: 100% 100%;">

    </section>
    <div class="container">
      <div class="row">
        <div id="myModal" class="modal fade in" role="dialog" tabindex="-1">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header modal-header-small">
                <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
                <h4>Online Admission Terms & Conditions</h4>
              </div>
              <form action="" method="post" class="onlineform" id="checkstatusform">
                <div class="modal-body">
                  <p>&nbsp;Please enter your institution online admission terms &amp; conditions here.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="modalclosebtn btn  mdbtn" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>
        </div>



        @if(session('success'))
        <div class="alert alert-success">
          <strong>Success!</strong> <?= @session('success') ?>.
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
          <strong>Error!</strong> <?= @session('error') ?>.
        </div>
        @endif <div id="divtoprint" class="spaceb40">
          <div class="row" id="printheader">
            <img src="{{asset('uploads/print_headerfooter/online_admission_receipt/header_image.jpg')}}" style="height: 100px;width: 100%;" />
          </div>
          <div class="printcontent">
            <div class="row">
              <div class="container">
                <h4 class="pagetitleh2">Basic Details</h4>
                <table class="table table-bordered">
                  <tr>
                    <th>Reference No<span> : <?=$res[0]->refrence_no?></span></th>
                    <th> Form Status : <span class="text-danger">@if($res[0]->form_status==1) Submitted @else No Submitted @endif</span>
                    </th>
                   
                    <th> Payment Status : <span class="text-danger">
                    @if($res[0]->type!='1')    
                    @if($res[0]->pay_status==1) Paid @else Unpaid @endif
                    @else
                    Free For Online Students
                  @endif
                  </span>
                    </th>
                   
                    <th>
                  
                        <div class="statusright">
                          @if(Request::segment('2')=='')
                          <a href="{{url('editonlineadmission')}}"  id="editbtn"><button type="button" class="btn printbtndrakgray btn-sm"><i class="fa fa-edit"></i></button></a>
                @endif
                          <button type="button" id="printbtn" class="btn printbtndrakgray btn-sm" onclick="printDiv('divtoprint')"><i class="fa fa-print"></i></button>

                        </div>
                 
                    </th>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <th><?=$res[0]->firstname?> <?=$res[0]->lastname?></th>
                    <th>Course</th>
                    <th><?php $course=DB::select('select class from classes where id='.$res[0]->class_id);
                    echo $course[0]->class;
                    ?></th>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <th><?=$res[0]->gender?></th>
                    <th>Date Of Birth</th>
                    <th><?=$res[0]->dob?></th>
                  </tr>
                  <tr>
                    <th>Mobile</th>
                    <th><?=$res[0]->mobileno?></th>
                    <th>Email</th>
                    <th><?=$res[0]->email?></th>
                  </tr>
                  <tr>
                    <th colspan="4">

                      <form id="paymentform" action="{{url('payment/checkout')}}" method="post">
                    @csrf
                        <input type="hidden" name="admission_id" value="<?=$res[0]->admission_no?>">
                        <input type="hidden" name="studentid" value="<?=$res[0]->id?>">
                        <input type="hidden" name="reference_no" value="<?=$res[0]->refrence_no?>">


                        <div class="row btnprint">
                          <div class="col-md-12">
                            <div class="form-group">

                              <label><input type="checkbox" id="checkterm" name="checkterm" > I agree to the <a href="#myModal" data-toggle="modal" data-target="#myModal" style="width:100%">terms and conditions</a></label>

                              <span class="text-danger" id="termerror"></span>
                              @if($res[0]->type!='1')
                              <button type="submit" id="paybtn" class="btn btn-warning btn-lg pull-right"> Pay ₹100</button>
                            @endif
                            </div>
                          </div>
                        </div>
                      </form>
                    </th>
                  </tr>
                </table>
              </div>
            </div>
          </div>

        </div>

 
    </div>
    <script type="text/javascript">
//(function ($) {
 $(document).ready(function () {
$("#printheadid").css('display','none');

$("#printheader").css('display','none');
$("#printfooter").css('display','none');
$("#completeformdiv").css('display','none');
     

    });

 
</script>
   <script>
 

        function printDiv(){
 
          $("#printbtn").css('display','none');
          $("#editbtn").css('display','none');
          $(".btnprint").css('display','none');
          $("#headid").css('display','none');
           $("#printheadid").css('display','block');
           $("#printheader").css('display','block');
           $("#printfooter").css('display','block');
        
             var printContents=document.getElementById('divtoprint').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents; 
            window.print();
            document.body.innerHTML = originalContents;
            
            $("#headid").css('display','block');
            $("#printbtn").removeAttr('style');
            $("#editbtn").removeAttr('style');
            $(".btnprint").css('display','block');
            $("#printheadid").css('display','none');
             $("#printheader").css('display','none');
             $("#printfooter").css('display','none');
        }
 
    </script>

 
<script>
 
  $(document).ready(function() {
  
    if($('#checkterm').prop("checked")==true){
       $("#paybtn").prop('disabled',false);
       $("#submitbtn").prop('disabled',false);
       
    }else{
      $("#paybtn").prop('disabled',true);
      $("#submitbtn").prop('disabled',true);
    }

    $('#checkterm').change(function() {
        if(this.checked) {
          $("#paybtn").prop('disabled',false);
          $("#submitbtn").prop('disabled',false);
        }else{
          $("#paybtn").prop('disabled',true);
           $("#submitbtn").prop('disabled',true);
        }
       
    });
});
 

</script>
  </div>
  </div>
  @include('home.include.footer')