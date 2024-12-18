<?php

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/users', function (Request $request) {
    return Response()->json("test");
});

Route::post('/users', function (Request $request) {
    return Response()->json("test");
});


