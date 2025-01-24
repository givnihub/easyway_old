<?php

use App\Http\Controllers\HomeApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[HomeApi::class,'index']);
Route::post('/registration',[HomeApi::class,'registration']);
Route::post('/logout',[HomeApi::class,'logout']);
Route::get('/tradegroup',[HomeApi::class,'tradegroup']);
Route::get('/trade/{groupid}',[HomeApi::class,'trade']);
Route::get('/class',[HomeApi::class,'class']);
Route::get('/batches',[HomeApi::class,'batches']);
Route::get('/coursecategory',[HomeApi::class,'coursesCategory']);
Route::get('/popularcourse',[HomeApi::class,'popularcourse']);
Route::get('/coursebycategory/{id}',[HomeApi::class,'coursebycategory']);
Route::get('/filtercourse',[HomeApi::class,'filterCourse']);
Route::get('/demovideos/{course_id}',[HomeApi::class,'demovideos']);
Route::get('/parentfolder/{course_id}',[HomeApi::class,'parentfolder']);
Route::get('/subfolder/{course_id}/{folder_id}',[HomeApi::class,'subfolder']);
Route::get('/contents/{course_id}/{folder_id}',[HomeApi::class,'contents']);
Route::post('/coursepayment',[HomeApi::class,'coursePayment']);
Route::get('/mypurchased/{id}',[HomeApi::class,'myPurchased']);
Route::post('/AdmissionPayment',[HomeApi::class,'AdmissionPayment']);
Route::get('/userInfo/{id}',[HomeApi::class,'userInfo']);
Route::get('/staff',[HomeApi::class,'staff']);
Route::get('/chat_connections/{teacherid}/{studentid}',[HomeApi::class,'chat_connections']);
Route::post('/chat_messages',[HomeApi::class,'chat_messages']);
Route::get('/getMessages/{id}',[HomeApi::class,'get_messages']);
Route::get('/chatUpdate/{connectionId}/{senderid}',[HomeApi::class,'chatUpdate']);
Route::post('/sendLiveStreamMessage',[HomeApi::class,'sendLiveStreamMessage']);
Route::get('/chatLiveStreamMessage/{id}',[HomeApi::class,'chatLiveStreamMessage']);
Route::get('/menus',[HomeApi::class,'menus']);
Route::get('/pages/{title}',[HomeApi::class,'pages']);
Route::get('/related/{id}/{title}',[HomeApi::class,'related']);
Route::post('/courseViewCounts',[HomeApi::class,'courseViewCounts']);
Route::get('liveVideos/{email}',[HomeApi::class,'liveVideos']);
Route::post('/forgotPassword',[HomeApi::class,'forgotPassword']);
Route::post('/verifyPayment',[HomeApi::class,'verifyPayment']);
Route::post('paymentVerification',[HomeApi::class,'paymentVerification']);

