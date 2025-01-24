<?php

namespace App\Http\Controllers;
use App\Models\Interviews;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index(Request $req)
    {
        $data['bucket'] = DB::table("bucket")->get();
        $data['balls'] = DB::table("bolls_tb")->first();
        return view('interview.index', $data);
    }

    public function bucket_size(Request $req)
    {

        for ($i = 0; $i < count($req->input('bucket_size')); $i++) {
            $data = array(
                'title' => 'bucket_' . $i,
                'size' => $req->input('bucket_size')[$i],
            );
            $insert =  DB::table('bucket')->insert($data);
        }




        if ($insert == 1) {
            $req->session()->flash('success', 'Bucket Size added...');
            return redirect('interview');
        } else {
            $req->session()->flash('Warning', 'Some error occured...');
            return redirect('interview');
        }
    }
    public function balls_size(Request $req)
    {

        $data = array(
            'pink' => trim($req->input('pink')),
            'red' => trim($req->input('red')),
            'blue' => trim($req->input('blue')),
            'orange' => trim($req->input('orange')),
            'green' => trim($req->input('green')),
        );

        $insert =  DB::table('bolls_tb')->insert($data);
        if ($insert == 1) {
            $req->session()->flash('success', 'Balls Size added...');
            return redirect('interview');
        } else {
            $req->session()->flash('Warning', 'Some error occured...');
            return redirect('interview');
        }
    }
    public function ball_in_bucket(Request $req)
    {


        $ballsize = DB::table("bolls_tb")->first();

        $pink = $req->input('pink') * $ballsize->pink;
        $red = $req->input('red') * $ballsize->red;
        $blue = $req->input('blue') * $ballsize->blue;
        $orange = $req->input('orange') * $ballsize->orange;
        $green = $req->input('green') * $ballsize->green;

            $sumofballs = $pink + $red + $blue + $orange + $green;
 
        $bucket_size_desc = DB::table('bucket')->where("balls","=<","size")->orderBy('size', 'desc')->get();
        foreach ($bucket_size_desc as $run) {
          
             $bucket_id = $run->id;
            $bucket_size = $run->size;
              $bucket_balls = $run->balls;
            if (($sumofballs >= $bucket_size && $bucket_size > 0)  || ($sumofballs <= $bucket_balls)) {
                
                $data = array(
                    'balls' => $bucket_size,
                );
                 $sumofballs = $sumofballs - $bucket_size;

                DB::table("bucket")->where("id", $bucket_id)->update($data);
            }
        }

        $bucket_size_desc = DB::table('bucket')->where("balls",">=","size")->orderBy('size', 'asc')->get();
        foreach ($bucket_size_desc as $run) {
          
               $bucket_id = $run->id;
          
            $bucket_size = $run->size;
            $bucket_balls = $run->balls;
            if ($sumofballs > 0) {
 
                if (($sumofballs <= $bucket_size && $bucket_size > 0)  || ($sumofballs <= $bucket_balls)) {
                    $data = array(
                        'balls' => $sumofballs,
                    );
                  DB::table("bucket")->where("id", $bucket_id)->update($data);
                     $sumofballs = $sumofballs - $bucket_size;
                }
            }
        }
        $req->session()->flash('success', 'Ball added in bucket...');
        return redirect('interview');
    }
}







 
