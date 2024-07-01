<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account-transactions/{accountId}', [DashboardController::class, 'accountTransactions'])->name('account.transactions');

    Route::get('/transaction-summary', [DashboardController::class, 'transactionSummary'])->name('transaction.summary');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/accounts', [AccountController::class, 'createAccount'])->name('accounts.create');
    Route::get('/accounts', [AccountController::class, 'getAccounts'])->name('accounts.index');
    Route::post('/accounts/transfer', [AccountController::class, 'transfer'])->name('accounts.transfer');
});


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

require __DIR__.'/auth.php';
