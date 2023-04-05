<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/check','App\Http\Controllers\DataController@check');  

Route::get('/','App\Http\Controllers\DataController@welcome');  
Route::get('/{range}','App\Http\Controllers\DataController@welcome')
    ->whereAlpha('range')
    ->name('welcome');
Route::get('update/storage', 'App\Http\Controllers\ApiController@updateStorage')
    ->name('update.storage');
Route::post('update/realizations', 'App\Http\Controllers\ApiController@updateRealizations')
    ->name('update.realizations');
Route::post('update/sales', 'App\Http\Controllers\ApiController@updateSales')
    ->name('update.sales');          
Route::post('update/orders', 'App\Http\Controllers\ApiController@updateOrders')
    ->name('update.orders');