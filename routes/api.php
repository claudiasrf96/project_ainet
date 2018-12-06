<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('users/me','UserControllerAPI@index'); //antes de ele apanhar o id
Route::put('users/updateProfile/{id}','UserControllerAPI@update'); //antes de ele apanhar o id updatePass createUser
Route::put('users/updatePassword/{id}','UserControllerAPI@updatePass'); 
Route::post('users/createUser','UserControllerAPI@createUser'); 

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::middleware('auth:api')->post('logout','LoginControllerAPI@logout');


/*Route::get('teste', function () {
    return response()->json(['msg'=>'Só um teste'], 200);
});*/

Route::middleware('auth:api')->get('teste', function () {
    return response()->json(['msg'=>'Só um teste'], 200);
});

Route::get('menu', 'ItemsControllerAPI@index');
