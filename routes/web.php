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
    return view('index');
});
Route::get('/create', 'QuackController@create')->name('create');
Route::get('/index', 'QuackController@index')->name('index');
Route::get('/update', 'QuackController@update')->name('update');
Route::get('/delete', 'QuackController@delete')->name('delete');
//
//Route::resource('/quacks', 'QuackController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
