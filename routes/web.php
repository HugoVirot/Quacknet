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
Route::get('/home', 'QuackController@index')->name('home');

Auth::routes();                                                             //ensemble des routes de l'authentification

Route::resource('/quacks', 'QuackController')->except('index');

Route::get('user/account', 'User\UserController@index')->name('user.account');
Route::get('user/account/update', 'User\UserController@updatepage')->name('user.account.updatepage');
Route::put('user/account/update', 'User\UserController@updatevalidation')->name('user.account.updatevalidation');

//Route::get('/create', 'QuackController@create')->name('create');
//Route::get('/index', 'QuackController@index')->name('index');
//Route::get('/list', 'QuackController@list')->name('list');
//Route::get('/update', 'QuackController@update')->name('update');
//Route::get('/delete', 'QuackController@delete')->name('delete');

//Route::post('/modification-mot-de-passe', 'CompteController@modificationMotDePasse');

