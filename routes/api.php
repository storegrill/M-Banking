<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExchangeRateController;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/accounts', [AccountController::class, 'createAccount']);
    Route::get('/accounts', [AccountController::class, 'getAccounts']);
    Route::post('/transfer', [AccountController::class, 'transfer']);
    Route::post('/logout', [AuthController::class, 'logout']); // Adding logout route for completeness
});

// Exchange rate routes
Route::get('/exchange-rate/{baseCurrency}/{targetCurrency}', [ExchangeRateController::class, 'getExchangeRate']);
Route::post('/convert-currency', [ExchangeRateController::class, 'convertCurrency']);
