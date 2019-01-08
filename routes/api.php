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



Route::get('/user', 'UserControllerAPI@getAllUsers')->middleware('auth:api', 'role:manager');
Route::put('users/updateProfile/{id}','UserControllerAPI@update')->middleware('auth:api', 'role:manager');; //antes de ele apanhar o id updatePass createUser

Route::put('users/update/user/{id}','UserControllerAPI@updateUser')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::post('users/updateProfilePic/{id}','UserControllerAPI@updatePic')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::put('users/updatePassword/{id}','UserControllerAPI@updatePass')->middleware('auth:api', 'role:cook,waiter,manager,cashier'); 
Route::put('users/updateShift/{id}','UserControllerAPI@updateShift')->middleware('auth:api', 'role:cook,waiter,manager,cashier'); 
Route::post('users/createUser','UserControllerAPI@createUser')->middleware('auth:api', 'role:manager'); 

Route::put('user/blockUser/{id}','UserControllerAPI@blockUser')->middleware('auth:api', 'role:manager');; 
Route::put('user/unblockUser/{id}','UserControllerAPI@unblockUser')->middleware('auth:api', 'role:manager');; 
Route::put('user/deleteUser/{id}','UserControllerAPI@deleteUser')->middleware('auth:api', 'role:manager');; 


//Menu Items
Route::get('menu', 'ItemsControllerAPI@index');

//Menu Items
Route::put('menu/update/{id}', 'ItemsControllerAPI@update')->middleware('auth:api', 'role:cook,waiter,manager,cashier');


Route::post('menu/update/pic/{id}', 'ItemsControllerAPI@updatePic')->middleware('auth:api','role:cook,waiter,manager,cashier');

Route::get('menu/drinks', 'ItemsControllerAPI@getDrink')->middleware('auth:api', 'role:cook,waiter,manager,cashier');
Route::get('menu/dishs', 'ItemsControllerAPI@getDish')->middleware('auth:api', 'role:cook,waiter,manager,cashier');


//Meal
Route::get('meal', 'MealControllerAPI@getMeals');//->middleware('auth:api', 'role:manager');//middleware(, 'waiter')->

Route::get('meal/getActiveMeal/{id}', 'MealControllerAPI@getActiveMeal')->middleware('auth:api', 'role:cook,waiter,manager,cashier');


Route::get('meal/with/orders/with/users/active/Terminated', 'MealControllerAPI@getMealslWithOrderslWithUsersActiveTerminated')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::get('meal/getActiveMealWithOpenOrder/{id}', 'MealControllerAPI@getActiveMealWithOpenOrder')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::get('meal/MealslWithOrderslWithUsers', 'MealControllerAPI@getMealslWithOrderslWithUsers')->middleware('auth:api', 'role:cook,waiter,manager,cashier');



Route::put('meal/update/{id}', 'MealControllerAPI@update')->middleware('auth:api', 'role:cook,waiter,manager,cashier');
Route::post('meal/createMeal', 'MealControllerAPI@createMeal')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

//Order
Route::get('order', 'OrderControllerAPI@getOrders')->middleware('auth:api', 'role:cook,waiter,manager,cashier'); //us9

//Orders Prepared   
Route::get('order/getPreparedOrders/{id}', 'OrderControllerAPI@getPreparedOrder')->middleware('auth:api', 'role:cook,waiter,manager,cashier');


Route::get('order/confirmed/inPreparation/cook/{id}', 'OrderControllerAPI@getConfirmedInPreprationCook')->middleware('auth:api', 'role:cook,waiter'); //Us9

Route::get('order/pending/confirmed/waiter/{id}', 'OrderControllerAPI@getPendingConfirmedWaiter')->middleware('auth:api', 'role:cook,waiter,manager,cashier'); //US14


Route::get('order/getPendingConfirmed/{id}', 'OrderControllerAPI@getPendingConfirmed')->middleware('auth:api', 'role:cook,waiter');;

Route::get('order/getOrderDetails/{id}/Meal/{Mealid}', 'OrderControllerAPI@getOrderDetails')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::post('order/createOrder', 'OrderControllerAPI@createOrder')->middleware('auth:api', 'role:cook,waiter');

Route::put('order/updateState/{id}', 'OrderControllerAPI@updateState')->middleware('auth:api', 'role:cook,waiter,cashier');;

Route::put('order/update/state/notDeliverd/{id}', 'OrderControllerAPI@updateStateToNotDelivers')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

Route::delete('order/delete/{id}', 'OrderControllerAPI@delete')->middleware('auth:api', 'role:cook,waiter');

//Invoices
Route::get('invoice', 'InvoiceControllerAPI@getAllInvoices')->middleware('auth:api', 'role:waiter,manager,cashier');

Route::put('invoice/update/{id}', 'InvoiceControllerAPI@update')->middleware('auth:api', 'role:waiter,manager,cashier');

Route::post('invoice/create', 'InvoiceControllerAPI@createInvoice')->middleware('auth:api', 'role:cook,waiter');;

Route::get('invoice/pending', 'InvoiceControllerAPI@getPendingInvoices')->middleware('auth:api', 'role:waiter,manager,cashier');

Route::get('invoice/invoiceInfo', 'InvoiceControllerAPI@getDetailInfoAboutInvoices')->middleware('auth:api', 'role:manager,cashier');


Route::get('invoice/invoiceInfo/manager', 'InvoiceControllerAPI@getAllInvoicesInfoManager')->middleware('auth:api', 'role:manager');

Route::get('invoice/meal/{id}', 'InvoiceControllerAPI@getMealInvoice')->middleware('auth:api', 'role:waiter,manager,cashier');

Route::get('invoice/paid', 'InvoiceControllerAPI@getPaidInvoices')->middleware('auth:api', 'role:manager,cashier');

Route::get('pdf/{id}', 'PDFControllerApi@getPdf')->middleware('auth:api', 'role:cashier');;


Route::get('manager/pdf/{id}', 'PDFControllerApi@getPdfManager')->middleware('auth:api', 'role:manager');
//Invoice Item
Route::get('invoiceItem', 'InvoiceItemControllerAPI@getAllinvoiceItems')->middleware('auth:api', 'role:waiter,manager,cashier');

Route::post('invoiceItem/create/{id}', 'InvoiceItemControllerAPI@createInvoiceItems')->middleware('auth:api', 'role:waiter,manager,cashier');

//Table
Route::get('table', 'Restaurant_tablesControllerAPI@getTablesFree')->middleware('auth:api', 'role:cook,waiter,manager,cashier');

//Login
Route::post('login', 'LoginControllerAPI@login')->name('login');

/*

Route::middleware('auth:api')->get('teste', function () {
    return response()->json(['msg'=>'Só um teste'], 200);
});
*/
