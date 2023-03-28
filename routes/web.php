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

Route::get('/', function () {
    return view('welcome');
});

Route::post('api', 'App\Http\Controllers\ApiController@getData')
    ->name('api');
Route::post('parse', 'App\Http\Controllers\ApiController@parseData')
    ->name('parse');    
