<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupsControllerApi;
use App\Http\Controllers\UsersControllerApi;
use App\Http\Controllers\PostInGroupsControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/groups', [GroupsControllerApi::class, 'index']);
Route::get('/groups/{id}', [GroupsControllerApi::class, 'show']);

Route::get('/users', [UsersControllerApi::class, 'index']);
Route::get('/users/{id}', [UsersControllerApi::class, 'show']);

Route::get('/post-in-groups', [PostInGroupsControllerApi::class, 'index']);
Route::get('/post-in-groups/{id}', [PostInGroupsControllerApi::class, 'show']);