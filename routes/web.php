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

// page de connexion
Route::get('/', 'HomeController@index')->name('index'); 

// accueil / liste des quacks
Route::get('/home', 'HomeController@home')->name('home');

//ensemble des routes de l'authentification
Auth::routes();  

// rechercher un quack
Route::get('/quacks/search', 'QuackController@search')->name('quacks.search'); 

// routes crud quack
Route::resource('/quacks', 'QuackController')->except('index'); 

// routes crud commentaires
Route::resource('/comments', 'CommentController')->except('index'); 

// profil utilisateur : afficher / modifier / valider modif / supprimer le compte
Route::get('users/{user}', 'User\UserController@profil')->name('user.profil');
Route::get('settings/account', 'User\UserController@index')->name('user.account');
Route::get('settings/account/edit', 'User\UserController@edit')->name('user.account.edit');
Route::put('settings/account/update', 'User\UserController@update')->name('user.account.update');
Route::put('settings/password/update', 'User\UserController@updatePassword')->name('user.password.update');
Route::delete('users/{user}/destroy', 'User\UserController@destroy')->name('user.destroy');

// envoyer image en post
Route::post('/home', 'HomeController@home')->name('home'); 

// valider l'upload d'une image
Route::post('image-upload', 'ImageUploadController@imageUploadPost')->name('image.upload.post');