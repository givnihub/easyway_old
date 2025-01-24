<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>Easy Way Global</title>
    <link rel="stylesheet" href="{{asset('public/backend/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/dist/css/style-main.css')}}">
    <style type="text/css">
    .table2 tr.border_bottom td {
        box-shadow: none;
        border-radius: 0;
        border-bottom: 1px solid #e6e6e6;
    }

    .table2 td {
        padding-bottom: 3px;
        padding-top: 6px;
    }

    .title {
        color: #0084B4;
        font-weight: 600 !important;
        font-size: 15px !important;
        ;
        display: inline;

    }

    .product-description {
        display: block;
        color: #999;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .text-fine {
        color: #bf4f4d;
    }
    </style>
</head>

<body style="background: #ededed;">
    <div class="container">
        <div class="row">
            <div class="paddtop20">
                <div class="col-md-8 col-md-offset-2 text-center">

                    <img src="{{asset('')}}<?= $setting->admin_logo ?>" style="height:100px;">

                </div>
                <div class="col-md-6 col-md-offset-3 mt20">
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
                    <div class="paymentbg">
                        <div class="invtext">Payment Details </div>
                        <div class="padd2 paddtzero">
                           
                                <table class="table2" width="100%">
                                    <tr>
                                        <th>Title</th>
                                        <th class="text-right"><?php $res=DB::table("courses")->where("id",$payment->course_id)->first();
                                        echo $res->title
                                        ?></th>
                                    </tr>

                                     
                                    <tr class="bordertoplightgray">
                                        <td>Amount </td>
                                        <td colspan="2" class="text-right"> ₹{{$payment->amount}}</td>
                                    </tr>
                                    <tr class="bordertoplightgray">
                                    <td>Transaction Id </td>
                                        <td colspan="2" class="text-right"><?=$_GET['razorpay_payment_id'];?></td>
                                    </tr>
                                    <tr class="bordertoplightgray">
                                        <td>Status</td>
                                        <td colspan="2" class="text-right"><?=$payment->status?></td>
                                    </tr>
                                    <tr class="bordertoplightgray">
                                        <td>Payment Date</td>
                                        <td colspan="2" class="text-right"><?=date('d-m-Y H:i:s',strtotime($payment->cdate));?></td>
                                    </tr>
                                    <tr class="bordertoplightgray">
                                        
                                    <td colspan="2"  ><a href="{{url('user/studentcourse')}}"><button   
                                                class="btn btn-info"><i class="fa fa fa-chevron-left"></i> Go To Courses
                                            </button> </a></td>

                                       
                                    </tr>
                                </table>
                              
                       
                            
                        </div>
           
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>