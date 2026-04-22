<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupsControllerApi;
use App\Http\Controllers\UsersControllerApi;
use App\Http\Controllers\PostInGroupsControllerApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', [UsersControllerApi::class, 'index']);
    Route::get('/users/{id}', [UsersControllerApi::class, 'show']);
    Route::get('/users_total', [UsersControllerApi::class, 'total']);

    Route::post('/user', [UsersControllerApi::class, 'store']);
    
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/groups', [GroupsControllerApi::class, 'index']);   
    Route::get('/groups/{id}', [GroupsControllerApi::class, 'show']);
    Route::get('/groups_total', [GroupsControllerApi::class, 'total']);

    Route::post('/group', [GroupsControllerApi::class, 'store']);

    Route::get('/post-in-groups', [PostInGroupsControllerApi::class, 'index']);
    Route::get('/post-in-groups/{id}', [PostInGroupsControllerApi::class, 'show']);
});