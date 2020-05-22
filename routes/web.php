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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/spin', 'SpinController@index')->name('spin');

Route::get('/test/{id}', 'RouletteController@view');
Route::get('/test', 'RouletteController@index');

Route::post('/rust/genetics', 'RustController@genetics_post');
Route::get('/rust/genetics', 'RustController@genetics');
Route::get('/rust', 'RustController@index');