<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TeamController;

 
Route::middleware([Cors::class])->group(function () {
    Route::post('/create_user', [UserController::class, 'create']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::get('/check', [AuthenticationController::class, 'check'])->middleware('auth:sanctum');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/all_teams', [TeamController::class, 'getAllTeams']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
