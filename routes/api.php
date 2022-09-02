<?php

use App\Http\Controllers\Api\UserController;
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

Route::get('/user',[UserController::class,'userData']);
Route::post('/user/add',[UserController::class,'addUser']);
Route::post('user/multiple/add',[UserController::class,'multipeUserAdd']);
Route::put('user/update/{id}',[UserController::class,'userUpdate']);
Route::delete('user/delete/{id}',[UserController::class,'user_destroy']);
