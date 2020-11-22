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
Route::get('/home', 'HomeController@home')->name('home');

Auth::routes();                                                             //ensemble des routes de l'authentification

Route::get('/quacks/search', 'QuackController@search')->name('quacks.search');
Route::resource('/quacks', 'QuackController')->except('index');


Route::resource('/comments', 'CommentController')->except('index');

Route::get('users/{user}', 'User\UserController@profil')->name('user.profil');

Route::get('settings/account', 'User\UserController@index')->name('user.account');
Route::get('settings/account/edit', 'User\UserController@edit')->name('user.account.edit');
Route::put('settings/account/update', 'User\UserController@update')->name('user.account.update');
