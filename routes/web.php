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
Route::view('/','home.welcome')->name('welcome');

//Authentication
Route::get('/auth/google','\App\Http\Controllers\AuthController@redirectToProvider')->name('login');
Route::get('/auth/callback','\App\Http\Controllers\AuthController@handleProviderResponse');
Route::any('/logout', '\App\Http\Controllers\AuthController@logout')->name('logout');

//Setup
Route::get('/setup','\App\Http\Controllers\SetupController@gate');
Route::post('/validate','\App\Http\Controllers\SetupController@validateCode');

//Admin
Route::get('/dashboard', '\App\Http\Controllers\AdminController@showUserDashboard');

//User Account
Route::get('/user', '\App\Http\Controllers\UserController@show');
Route::post('/user/delete/{user}', '\App\Http\Controllers\UserController@delete');
 
//Orders
Route::get('/orders', '\App\Http\Controllers\OrderController@index');
Route::get('/order/clone/{order}','\App\Http\Controllers\OrderController@clone');
Route::get('/order/pay/{order}','\App\Http\Controllers\OrderController@pay');
Route::get('/order/edit/{order?}','\App\Http\Controllers\OrderController@edit');
Route::post('/order/update','\App\Http\Controllers\OrderController@store');
Route::get('/order/delete/{order}','\App\Http\Controllers\OrderController@delete');

//Invoices
Route::get('/invoice/{order}', '\App\Http\Controllers\InvoiceController@show');

//Content
Route::get('/content', '\App\Http\Controllers\ContentController@index');
Route::get('/content/{client}/edit/{content?}','\App\Http\Controllers\ContentController@edit');
Route::post('/content/update','\App\Http\Controllers\ContentController@store');
Route::get('/content/delete/{content}','\App\Http\Controllers\ContentController@delete');

//Form Generated Leads
Route::get('/leads', '\App\Http\Controllers\LeadsController@index');

//legal
Route::view('/privacy','legal.privacy');
Route::view('/terms','legal.terms');
Route::view('/cookies','legal.cookies');

