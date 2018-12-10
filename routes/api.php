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

//Api

Route::middleware('auth:api')->get('users/me','UserControllerAPI@myProfile'); //antes de ele apanhar o id

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('logout','LoginControllerAPI@logout');



//User

Route::put('users/updateProfile/{id}','UserControllerAPI@update'); //antes de ele apanhar o id updatePass createUser

Route::post('users/updateProfilePic/{id}','UserControllerAPI@updatePic');

Route::put('users/updatePassword/{id}','UserControllerAPI@updatePass'); 
Route::put('users/updateShift/{id}','UserControllerAPI@updateShift'); 
Route::post('users/createUser','UserControllerAPI@createUser'); 

//Menu Items
Route::get('menu', 'ItemsControllerAPI@index');

//Meal
Route::get('meal', 'MealControllerAPI@getMeals');

Route::put('meal/update/{id}', 'MealControllerAPI@update');
Route::post('meal/createMeal', 'MealControllerAPI@createMeal');

//Order
Route::get('order', 'OrderControllerAPI@getOrders');

Route::post('order/update/{id}', 'OrderControllerAPI@update');

//Table
Route::get('table', 'Restaurant_tablesControllerAPI@getTables');

//Login
Route::post('login', 'LoginControllerAPI@login')->name('login');


/*

Route::middleware('auth:api')->get('teste', function () {
    return response()->json(['msg'=>'Só um teste'], 200);
});
*/