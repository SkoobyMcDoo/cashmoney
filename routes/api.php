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

Route::post('login', 'API\AppController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/transactions', 'API\AppController@getTransactions');
Route::middleware('auth:api')->get('/vendors', 'API\AppController@getVendors');
Route::middleware('auth:api')->post('/create', 'API\AppController@createTransaction');
Route::middleware('auth:api')->post('/calculate', 'API\AppController@calculateTransactions');
