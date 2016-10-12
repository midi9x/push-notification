<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::post('save_endpoint', 'HomeController@save_endpoint');
Route::get('browser_pn', 'HomeController@browser_pn');
Route::post('addJob', 'HomeController@addJob');
Route::post('pushNow', 'HomeController@pushNow');