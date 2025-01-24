
<html lang="en">
    <head>
        <title>Print Questions</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
        <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style type="text/css">

@media print {

  body{line-height: 24px;font-family:'Roboto', arial;}
  .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
    float: left;
  }
  .col-md-12 {
    width: 100%;
  }
  .col-md-11 {
    width: 91.66666667%;
  }
  .col-md-10 {
    width: 83.33333333%;
  }
  .col-md-9 {
    width: 75%;
  }
  .col-md-8 {
    width: 66.66666667%;
  }
  .col-md-7 {
    width: 58.33333333%;
  }
  .col-md-6 {
    width: 50%;
  }
  .col-md-5 {
    width: 41.66666667%;
  }
  .col-md-4 {
    width: 33.33333333%;
  }
  .col-md-3 {
    width: 25%;
  }
  .col-md-2 {
    width: 16.66666667%;
  }
  .col-md-1 {
    width: 8.33333333%;
  }
  
  .clear{clear: both;}
  .row {
    margin-right: -5px;
    margin-left: -5px;
}
  .pb10{padding-bottom: 10px;}
  .mb10{margin-bottom: 10px !important;}
  .hrexam {margin-top: 5px;margin-bottom: 5px;border: 0;border-top: 1px solid #eee; width: 100%; clear: both;}
  .qulist_circle{margin: 0; padding: 0; list-style: none;}
  .qulist_circle li{display: block;}
  .qulist_circle li i{padding-right: 5px;}
  .font-weight-bold{font-weight: bold;}
  .text-center{text-align: center;}
  .section-box i {
    font-size: 18px;
    vertical-align: middle; padding-left: 2px;
}
}
.font-weight-bold{
font-weight: bold;}
</style>
    </head>
    <body>       
        <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-header ptbnull">
                  <h3 class="titlefix"> 
              
                  {{$examTitle->exam}}
                  
                      <button class="btn btn-success float-right" onclick="printwith();">Print With Answer</button>
                  <button class="btn btn-warning" onclick="printwithout();">Print Without Answer</button>
                  </h3>
               </div>
               <div class="">
                        <?php $i=1;?>
                     @foreach($list as $run)             
                        <?php $question=DB::table("questions")->where("id",$run->question_id)->first();?>
                 <p class="font-weight-bold">Question {{$i++}}: 
                {!!str_replace('<p>','',$question->question)!!} </p>             
                 <p class="font-weight-bold">Options: </p>
                 <p>A. {!!str_replace('<p>','',$question->opt_a)!!}</p>
                 <p>B. {!!str_replace('<p>','',$question->opt_b)!!}</p>
                 <p>C. {!!str_replace('<p>','',$question->opt_c)!!}</p>
                 <p>D. {!!str_replace('<p>','',$question->opt_d)!!}</p>  
                 @if($question->opt_e!='')
                 <p>
                 E. {!!str_replace('<p>','',$question->opt_e)!!}  
                 </p>
                 @endif             
                 <p class="font-weight-bold cranswer text-success">Correct Answer:  
                  
                  {{strtoupper(substr($question->correct,4))}}
                </p>
                <div class="exp">
                {!!str_replace('<p>','',$question->explanation)!!}
                 </div>                
@endforeach
                             
             
               </div>
            </div>
         </div>
      </div>

            <div class="clearfix"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
function printwith() {
    $('.btn').hide();
    window.print();
    $('.btn').show();
}
function printwithout() {
    $('.btn').hide();
    $('.cranswer').hide();
    $('.exp').hide();
    window.print();
    $('.btn').show();
    $('.cranswer').show();
    $('.exp').show();
}
</script>
    </body>
</html>
