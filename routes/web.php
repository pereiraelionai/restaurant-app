<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=> false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function() {

    Route::get('/cashier/getTable', 'Cashier\CashierController@getTables');
    Route::get('/cashier/getSaleDetailsByTable/{table_id}', 'Cashier\CashierController@getSaleDetailsByTable');
    Route::post('/cashier/orderFood', 'Cashier\CashierController@orderFood');
    Route::post('/cashier/confirmOrderStatus', 'Cashier\CashierController@confirmOrderStatus');
    Route::get('/cashier', 'Cashier\CashierController@index');
    Route::get('/cashier/getMenuByCategory/{category_id}', 'Cashier\CashierController@getMenuByCategory');
    Route::post('/cashier/deleteSaleDetail', 'Cashier\CashierController@deleteSaleDetail');
    Route::post('/cashier/increase-quantity', 'Cashier\CashierController@increaseQuantity');
    Route::post('/cashier/decrease-quantity', 'Cashier\CashierController@decreaseQuantity');
    Route::post('/cashier/savePayment', 'Cashier\CashierController@savePayment');
    Route::get('/cashier/showReceipt/{sale_id}', 'Cashier\CashierController@showReceipt');
});

Route::middleware(['auth', 'verifyAdmin'])->group(function() {

    Route::get('/management', function() {
        return view('management.index');
    });
    
    Route::resource('management/category', 'Management\CategoryController');
    Route::resource('management/menu', 'Management\MenuController');
    Route::resource('management/table', 'Management\TableController');
    Route::resource('management/user', 'Management\UserController');
    
    Route::get('/report', 'Report\ReportController@index');
    Route::get('/report/show', 'Report\ReportController@show');
    Route::get('/report/show/export', 'Report\ReportController@export');
});