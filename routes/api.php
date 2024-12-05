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

    Route::get('/all_teams', [TeamController::class, 'getAllTeams'])->middleware('auth:sanctum');
    Route::post('/select_team', [UserController::class, 'selectTeam'])->middleware('auth:sanctum');
    Route::get('/user_campaigns', [UserController::class, 'getUserCampaigns'])->middleware('auth:sanctum');
    Route::post('/user_team', [UserController::class, 'getTeam'])->middleware('auth:sanctum');
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
