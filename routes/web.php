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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contacts', [App\Http\Controllers\FriendController::class, 'index']);
Route::get('/messages/{id}', [App\Http\Controllers\MessageController::class, 'index']);
Route::post('/messages/{id}', [App\Http\Controllers\MessageController::class, 'send']);

Route::post('/message/{id}/read', [App\Http\Controllers\MessageController::class, 'read']);
