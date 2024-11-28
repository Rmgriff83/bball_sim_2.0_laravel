<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;

Route::get('/', function () {
    return response()->json([
        "hi" => "wrld"
    ]);
})->middleware(Cors::class);
