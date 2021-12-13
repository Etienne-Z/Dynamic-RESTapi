<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\maincontroller;
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

//main controller
Route::get('/{model}','App\Http\Controllers\maincontroller@getAll');
Route::get('/{model}/{id}','App\Http\Controllers\maincontroller@getOne');
Route::put('/{model}/{id}','App\Http\Controllers\maincontroller@update');
Route::delete('/{model}/{id}','App\Http\Controllers\maincontroller@delete');
Route::post('/{model}','App\Http\Controllers\maincontroller@save');



// )->middleware('auth');