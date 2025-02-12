<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


 Route::get('/page/{page_id}', [HomeApiController::class,'page_detail']);
 Route::get('/pageDetail/{id}', [HomeApiController::class,'page_detail_by_id']);
 Route::get('/serviceSchedule', [HomeApiController::class,'serviceSchedule']);
 Route::get('/serviceScheduleDetail/{service_name}', [HomeApiController::class,'serviceScheduleDetail']);
 Route::get('/teamMember/{member}', [HomeApiController::class,'teamMember']);


