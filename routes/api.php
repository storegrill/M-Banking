<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\GeolocationController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\MobileRechargeController;
use App\Http\Controllers\MultiLanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TransactionController;

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

// Geolocation routes
Route::post('/geolocation/coordinates', [GeolocationController::class, 'getCoordinates']);
Route::post('/geolocation/reverse-geocode', [GeolocationController::class, 'reverseGeocode']);

// Investment routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/investments', [InvestmentController::class, 'index']);
    Route::get('/investments/{id}', [InvestmentController::class, 'show']);
    Route::post('/investments', [InvestmentController::class, 'store']);
    Route::put('/investments/{id}', [InvestmentController::class, 'update']);
    Route::delete('/investments/{id}', [InvestmentController::class, 'destroy']);
});

// Mobile Recharge routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mobile-recharges', [MobileRechargeController::class, 'index']);
    Route::post('/mobile-recharges', [MobileRechargeController::class, 'store']);
    Route::get('/mobile-recharges/{id}', [MobileRechargeController::class, 'show']);
    Route::put('/mobile-recharges/{id}', [MobileRechargeController::class, 'update']);
    Route::delete('/mobile-recharges/{id}', [MobileRechargeController::class, 'destroy']);
});

// Multi Language routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/set-language', [MultiLanguageController::class, 'setLanguage']);
    Route::get('/get-language', [MultiLanguageController::class, 'getLanguage']);
});

// Notification routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});


// Stripe routes
Route::post('/stripe/charge', [StripeController::class, 'createCharge'])->middleware('auth:sanctum');
Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);


// Transaction routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
});
