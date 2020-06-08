<?php

use Illuminate\Support\Facades\Route;

/* $1488.89 - $49847.89 (4984837)
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
\Illuminate\Support\Facades\DB::listen(function($query) {
//    var_dump($query->sql, $query->bindings);
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('wheelchairs/{search?}', 'WheelchairController@index')->where('search', '.*');
