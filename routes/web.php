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

Route::get('/', 'HomeController@index')->name('index');
Route::get('/index', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@home')->name('home');

Auth::routes();                                                             //ensemble des routes de l'authentification

Route::resource('/quacks', 'QuackController');

Route::get('logout', 'Auth\LoginController@logout'); //à transformer en post
Route::get('user/myaccount', 'User\UserController@index')->name('user.myaccount');
Route::get('user/updateaccount', 'User\UserController@updateaccount')->name('user.updateaccount');
Route::put('user/update', 'User\UserController@update')->name('user.update');

//Route::get('/create', 'QuackController@create')->name('create');
//Route::get('/index', 'QuackController@index')->name('index');
//Route::get('/list', 'QuackController@list')->name('list');
//Route::get('/update', 'QuackController@update')->name('update');
//Route::get('/delete', 'QuackController@delete')->name('delete');

//Route::post('/modification-mot-de-passe', 'CompteController@modificationMotDePasse');

