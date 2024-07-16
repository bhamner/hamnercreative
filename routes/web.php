<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/

//Home
Route::view('/','welcome')->name('welcome');

//Authentication
Route::get('/auth/google','\App\Http\Controllers\AuthController@redirectToProvider')->middleware(['guest', 'throttle:60,1'])->name('login');
Route::get('/auth/callback','\App\Http\Controllers\AuthController@handleProviderResponse');
Route::any('/logout', '\App\Http\Controllers\AuthController@logout')->name('logout');

//Admin
Route::get('/dashboard', '\App\Http\Controllers\AdminController@showUserDashboard');

//User Account
Route::get('/user', '\App\Http\Controllers\UserController@show');
Route::post('/user/delete/{user}', '\App\Http\Controllers\UserController@delete');
 

//legal
Route::view('/privacy','legal.privacy');
Route::view('/terms','legal.terms');
Route::view('/cookies','legal.cookies');

