<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/accounts', [AccountController::class, 'createAccount']);
    Route::get('/accounts', [AccountController::class, 'getAccounts']);
    Route::post('/transfer', [AccountController::class, 'transfer']);
});
