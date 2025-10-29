<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello world!']);
});

Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
Route::get('/group/{id}', [GroupsController::class, 'show']);

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/user/{id}', [UsersController::class, 'show']);

Route::get('/user-groups/{id}', [UserGroupsController::class, 'show'])->name('user_groups.show');
Route::get('/group-users/{id}', [GroupUsersController::class, 'show'])->name('group_users.show');
