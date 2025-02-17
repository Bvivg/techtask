<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/user', function (Request $request) {
    return auth()->user();
    // return $request->user();
})->middleware('auth:sanctum');

Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');