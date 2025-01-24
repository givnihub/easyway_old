<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Purchase Details</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('')}}/backend/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('')}}/backend/dist/css/style-main.css">
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

    .razorpay-payment-button {
        background-color: green;
        color: white,
        
    }
    </style>

</head>
 
<body style="background: #ededed;">
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 col-md-offset-2 text-center pb-3">

                        <img src="{{asset('')}}<?= $setting->admin_logo ?>" style="height:100px;">

                    </div>

                    <div class="col-md-6 offset-3 col-md-offset-6">
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

                        <div class="card card-default paymentbg">

                            <div class="invtext">Course Purchase Details</div>

                            <div class="padd2 paddtzero">
                                <div class="card-body text-center">
                                    <form action="{{ route('razorpay.payment.store') }}" method="POST">
                                        <table class="table2" width="100%">
                                            <tr class="text-left">
                                                <th>Description</th>
                                                <th class="text-right">Amount</th>
                                            </tr>

                                            <tr class="border_bottom text-left">
                                                <td>
                                                    <span class="title">Title</span></td>
                                                <td class="text-right">{{$res->title}}</td>
                                            </tr>
                                            <!-- <tr class="border_bottom text-left">
                                                <td>
                                                    <span class="title">Description</span></td>
                                                <td class="text-right">{{$res->description}}</td>
                                            </tr> -->
                                            <tr class=" text-left">
                                                <td>
                                                    <span class="title">Amount</span></td>
                                                <td class="text-right"> {{$price=$res->price-($res->price*($res->discount/100))}}</td>
                                            </tr>
                                          
                                        </table>
                                        <input type="hidden" name="courseid" value="<?=$res->id?>">
                                        @csrf
                                        
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{env('RAZORPAY_KEY')}}" data-amount="{{$price*100}}"
                                            data-buttontext="Pay Now"
                                            data-name="Easywayglobal"
                                            data-description="{{$res->title}}"
                                            data-image="{{asset('')}}<?=$setting->admin_logo?>"
                                            data-prefill.name="<?=$userinfo->firstname?>" data-prefill.email="<?=$userinfo->email?>"
                                            data-theme.color="#ff7529">
                                        </script>
                                      
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>