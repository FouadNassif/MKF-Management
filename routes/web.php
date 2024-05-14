<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('pages.Restaurant.home');
});

// Show the registration Form and Check the registration
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'userRegister']);

// Show the login Form and Check the login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
}); 