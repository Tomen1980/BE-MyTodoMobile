<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/registrasi', [AuthController::class, 'registrasi']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::apiResource('todos', TodoController::class);
    Route::delete('/logout', [AuthController::class, 'logout']);
});
Route::apiResource('/todolist',TodoController::class);
Route::put('/todolist/{id}/change',[TodoController::class, 'change']);