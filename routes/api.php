<?php

use App\Http\Controllers\DomainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', function () {
        return auth()->user();
    });
    Route::prefix('domains')->group(function () {
        Route::post('/check', [DomainController::class, 'checkDomains']);
        Route::post('/check/whois', [DomainController::class, 'checkDomainsWhois']);
    });
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');