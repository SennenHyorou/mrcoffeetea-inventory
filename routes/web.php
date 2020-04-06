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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});
Auth::routes();
Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth' ], function(){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('supplier', 'SupplierController');
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
    Route::resource('expense', 'ExpenseController');
    Route::get('expense-today', 'ExpenseController@today_expense')->name('expense.today');
    Route::get('expense-month/{month?}', 'ExpenseController@month_expense')->name('expense.month');
    Route::get('expense-yearly/{year?}', 'ExpenseController@yearly_expense')->name('expense.yearly');
});
