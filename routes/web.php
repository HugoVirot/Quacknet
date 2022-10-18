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

// page de connexion
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index')->middleware('guest'); 

// accueil / liste des quacks
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home')->middleware('auth');

// envoyer image en post
Route::post('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home'); 

//ensemble des routes de l'authentification
Auth::routes();  

// rechercher un quack
Route::get('/quacks/search', [App\Http\Controllers\QuackController::class, 'search'])->name('quacks.search'); 

// routes crud quack
Route::resource('/quacks', App\Http\Controllers\QuackController::class)->except('index'); 

// routes crud commentaires
Route::resource('/comments', App\Http\Controllers\CommentController::class)->except('index'); 

// profil utilisateur : afficher / modifier / valider modif / supprimer le compte
Route::get('users/{user}', [App\Http\Controllers\User\UserController::class, 'profil'])->name('user.profil');
Route::get('settings/account', [App\Http\Controllers\User\UserController::class, 'index'])->name('user.account');
Route::get('settings/account/edit', [App\Http\Controllers\User\UserController::class, 'edit'])->name('user.account.edit');
Route::put('settings/account/update', [App\Http\Controllers\User\UserController::class, 'update'])->name('user.account.update');
Route::put('settings/password/update', [App\Http\Controllers\User\UserController::class, 'updatePassword'])->name('user.password.update');
Route::delete('users/{user}/destroy', [App\Http\Controllers\User\UserController::class, 'destroy'])->name('user.destroy');
