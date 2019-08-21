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
Route::get('/softdelete', 'QuackController@softDelete')->name('quacks.softdelete');

Auth::routes();                                                             //ensemble des routes de l'authentification

Route::resource('/quacks', 'QuackController')->except('index');

Route::resource('/commentaires', 'CommentaireController')->except('index');

Route::get('user/profil/{id}', 'User\UserController@profil')->name('user.profil');
Route::get('user/account', 'User\UserController@index')->name('user.account');
Route::get('user/account/edit', 'User\UserController@edit')->name('user.account.edit');
Route::put('user/account/update', 'User\UserController@update')->name('user.account.update');



