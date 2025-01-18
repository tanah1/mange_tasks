<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(UserController::class)->group(function(){

    Route::post('user/register' , 'register');

    Route::post('user/login' , 'login');

    Route::post('user/logout', 'logout')->middleware('auth:sanctum');

    Route::get('user', 'getCurrentuser')->middleware('auth:sanctum');

    Route::get('user/{id}', 'getUserById')->middleware('auth:sanctum');

    Route::put('user', 'updateUser')->middleware('auth:sanctum');

});



Route::controller(TaskController::class)->group(function(){

    Route::get('/tasks', 'index');

    Route::get('/tasks/{id}', 'show');

    Route::get('/user/tasks', 'userTasks')->middleware('auth:sanctum');

    Route::get('/user/tasks/{id}', 'userTask')->middleware('auth:sanctum');

    Route::post('/tasks', 'store')->middleware("auth:sanctum");

    Route::put('/tasks/{id}', 'update')->middleware('auth:sanctum');
    
    Route::delete('/tasks/{id}' , 'destroy')->middleware('auth:sanctum');

});

