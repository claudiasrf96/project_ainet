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



Route::middleware('auth:api')->post('logout','LoginControllerAPI@logout');



//User
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/user', 'UserControllerAPI@getAllUsers');
Route::put('users/updateProfile/{id}','UserControllerAPI@update'); //antes de ele apanhar o id updatePass createUser

Route::post('users/updateProfilePic/{id}','UserControllerAPI@updatePic');

Route::put('users/updatePassword/{id}','UserControllerAPI@updatePass'); 
Route::put('users/updateShift/{id}','UserControllerAPI@updateShift'); 
Route::post('users/createUser','UserControllerAPI@createUser'); 

//Menu Items
Route::get('menu', 'ItemsControllerAPI@index');

//Menu Items
Route::get('menu/update/{id}', 'ItemsControllerAPI@update');

//Meal
Route::get('meal', 'MealControllerAPI@getMeals');

Route::get('meal/getActiveMeal/{id}', 'MealControllerAPI@getActiveMeal');


Route::get('meal/getActiveMealWithOpenOrder/{id}', 'MealControllerAPI@getActiveMealWithOpenOrder');


Route::put('meal/update/{id}', 'MealControllerAPI@update');
Route::post('meal/createMeal', 'MealControllerAPI@createMeal');

//Order
Route::get('order', 'OrderControllerAPI@getOrders');

//Orders Prepared   
Route::get('order/getPreparedOrders/{id}', 'OrderControllerAPI@getPreparedOrder');

Route::get('order/getPendingConfirmed/{id}', 'OrderControllerAPI@getPendingConfirmed');

Route::get('order/getOrderDetails/{id}/Meal/{Mealid}', 'OrderControllerAPI@getOrderDetails');

Route::post('order/createOrder', 'OrderControllerAPI@createOrder');

Route::put('order/updateState/{id}', 'OrderControllerAPI@updateState');

Route::delete('order/delete/{id}', 'OrderControllerAPI@delete');

//Invoices
Route::get('invoice', 'InvoiceControllerAPI@getAllInvoices'); 

Route::put('invoice/update/{id}', 'InvoiceControllerAPI@update');

Route::get('invoice/pending', 'InvoiceControllerAPI@getPendingInvoices');

Route::get('invoice/invoiceInfo', 'InvoiceControllerAPI@getDetailInfoAboutInvoices'); 

//Invoice Item
Route::get('invoiceItem', 'InvoiceItemControllerAPI@getAllinvoiceItems');

//Table
Route::get('table', 'Restaurant_tablesControllerAPI@getTables');

//Login
Route::post('login', 'LoginControllerAPI@login')->name('login');


/*

Route::middleware('auth:api')->get('teste', function () {
    return response()->json(['msg'=>'Só um teste'], 200);
});
*/