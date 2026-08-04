<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientHomeRedirectController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.welcome')->name('welcome');

Route::get('/auth/google', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'handleProviderResponse']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/setup', [SetupController::class, 'gate']);
Route::post('/validate', [SetupController::class, 'validateCode']);

Route::get('/user', [UserController::class, 'show'])->name('user.show');
Route::post('/user/delete', [UserController::class, 'delete'])->name('user.delete');

Route::get('/clients/{client}/metrics', [AdminController::class, 'showUserDashboard'])->name('metrics.show');
Route::get('/clients/{client}/invoices', [OrderController::class, 'index'])->name('invoices.index');
Route::get('/clients/{client}/content', [ContentController::class, 'index'])->name('content.index');
Route::get('/clients/{client}/leads', [LeadsController::class, 'index'])->name('leads.index');

Route::get('/order/edit/{order?}', [OrderController::class, 'edit'])->name('orders.edit');
Route::post('/order/update', [OrderController::class, 'store'])->name('orders.store');
Route::post('/order/clone/{order}', [OrderController::class, 'clone'])->name('orders.clone');
Route::post('/order/pay/{order}', [OrderController::class, 'pay'])->name('orders.pay');
Route::post('/order/delete/{order}', [OrderController::class, 'delete'])->name('orders.delete');

Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoices.show');

Route::get('/content/{client}/edit/{content?}', [ContentController::class, 'edit'])->name('content.edit');
Route::post('/content/update', [ContentController::class, 'store'])->name('content.store');
Route::post('/content/delete/{content}', [ContentController::class, 'delete'])->name('content.delete');

Route::get('/dashboard', [ClientHomeRedirectController::class, 'metrics'])->name('dashboard');
Route::get('/orders', [ClientHomeRedirectController::class, 'invoices'])->name('orders.index');
Route::get('/content', [ClientHomeRedirectController::class, 'content']);
Route::get('/leads', [ClientHomeRedirectController::class, 'leads']);

Route::view('/privacy', 'legal.privacy');
Route::view('/terms', 'legal.terms');
Route::view('/cookies', 'legal.cookies');
