<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

/* Authentication */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

/* Logout */
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* Protected Routes */
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::resource('guests', GuestController::class);

    Route::get('/scan', [ScanController::class, 'index'])
        ->name('scan.index');
    Route::post('/scan/lookup', [ScanController::class, 'lookup'])
        ->name('scan.lookup');
    Route::post('/scan/check-in', [ScanController::class, 'checkIn'])
        ->name('scan.check-in');
});