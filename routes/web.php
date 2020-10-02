<?php

use Illuminate\Support\Facades\Route;

// use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
// WebSocketsRouter::webSocket('/test/app/{appKey}', \App\WebSockets\PrivateWebSocketHandler::class);


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/contacts', [App\Http\Controllers\FriendController::class, 'index']);
Route::get('/messages/{id}', [App\Http\Controllers\MessageController::class, 'index']);
Route::post('/messages/{id}', [App\Http\Controllers\MessageController::class, 'send']);

Route::post('/message/{id}/read', [App\Http\Controllers\MessageController::class, 'read']);


Route::post('/friends/add', [App\Http\Controllers\FriendRequestController::class, 'add']);
Route::get('/friends/requests', [App\Http\Controllers\FriendRequestController::class, 'index']);
Route::post('/friends/requests/{id}/accept', [App\Http\Controllers\FriendRequestController::class, 'accept']);
Route::post('/friends/requests/{id}/reject', [App\Http\Controllers\FriendRequestController::class, 'reject']);
Route::post('/friends/requests/{id}/cancel', [App\Http\Controllers\FriendRequestController::class, 'cancel']);
