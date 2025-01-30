<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SensorDataController;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return response()->json(['message' => 'All caches cleared successfully.']);
})->name('clear.cache')->middleware('auth');

Route::redirect('/', '/home');

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
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::resource('devices', DeviceController::class);
    Route::resource('sensors', SensorController::class);

    Route::get('/my-profile', [AuthController::class, 'showProfile'])->name('profile.view');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');
    Route::get('/account/settings', [AuthController::class, 'accountSettings'])->name('account.settings');


    Route::get('/my-sensors/{deviceId}', [SensorDataController::class, 'getSensors']);
    Route::get('/sensor-data/show', [SensorDataController::class, 'showData'])->name('data.show');
    Route::get('/sensor-data', [SensorDataController::class, 'index'])->name('data.index');
    Route::post('/sensor-data', [SensorDataController::class, 'store'])->name('data.store');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin', function () {
        return 'Super Admin Dashboard';
    });
});




