<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return response()->json(['message' => 'All caches cleared successfully.']);
})->name('clear.cache')->middleware('auth');

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::get('forgot', [AuthController::class, 'showForgot'])->name('forgot'); 
Route::post('register', [AuthController::class, 'postRegister'])->name('postRegister');
Route::post('login', [AuthController::class, 'postLogin'])->name('postLogin');

Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['authChecker'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/room', [HomeController::class, 'room'])->name('room');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});




