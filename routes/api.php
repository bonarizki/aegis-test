<?php

use App\Http\Controllers\UserController;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);

Route::post('/users',[UserController::class, 'create']);


