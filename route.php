<?php

use App\Route;

Route::get('/', 'app');
Route::post('task/get');
Route::post('task/send');
Route::post('task/list');
Route::post('login', 'auth/login');
Route::get('logout', 'auth/logout');