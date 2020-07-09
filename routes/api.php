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

Route::group(['namespace' => 'Api'], function() {
    Route::post('login', 'AuthController@login');
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('me', 'AuthController@me');

        Route::group(['prefix' => 'categories'], function() {
            Route::get('', 'CategoryController@index');
            Route::post('', 'CategoryController@store');
            Route::get('{id}', 'CategoryController@show');
            Route::put('{id}', 'CategoryController@update');
            Route::delete('{id}', 'CategoryController@delete');
        });
    });
});
