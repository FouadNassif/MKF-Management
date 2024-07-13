<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\WaiterController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\dashboardController;

Route::get('/', [ItemController::class, 'homePage'])->name('restaurant.homePage');

// Show the registration Form and Check the registration
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'userRegister']);

// Show the login Form and Check the login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function () {
    // User routes
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/user/deleteAddress/{address}', [UserController::class, 'deleteAddress'])->name('user.deleteAddress');
});

// Category routes
Route::get('/categories', [ItemCategoryController::class, "index"])->name("categories.index");
Route::get('/categories/create', [ItemCategoryController::class, "create"])->name("categories.create");
Route::get('/categories/{category}', [ItemCategoryController::class, "show"])->name("categories.show");
Route::get('/categories/{category}/edit', [ItemCategoryController::class, "edit"])->name("categories.edit");
Route::post('/categories', [ItemCategoryController::class, "store"])->name("categories.store");
Route::delete('/categories/{category}', [ItemCategoryController::class, "destroy"])->name("categories.destroy");
Route::put('/categories/{category}', [ItemCategoryController::class, "update"])->name("categories.update");

// Item routes
Route::get('/items', [ItemController::class, "index"])->name("items.index");
Route::get('/categories/{category}/item/create', [ItemController::class, "create"])->name("categories.items.create");
Route::get('/items/{item}', [ItemController::class, "show"])->name("items.show");
Route::get('/items/{item}/edit', [ItemController::class, "edit"])->name("items.edit");
Route::post('/categories/{category}/items', [ItemController::class, "store"])->name("categories.items.store");
Route::delete('/items/{item}', [ItemController::class, "destroy"])->name("items.destroy");
Route::put('/items/{item}', [ItemController::class, "update"])->name("items.update");

Route::middleware("roles:admin,cashier,waiter")->group(function () {
    // POS routes
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/order', [PosController::class, 'order'])->name('pos.order');
    Route::get('/pos/payment', [PosController::class, 'payment'])->name('pos.payment.index');
    Route::post('/pos/payment', [PosController::class, 'paymentStore'])->name('pos.payment.store');
});


//ADMIN routes
Route::get('/admin', [dashboardController::class,'index'])->name('admin.dashboard');
Route::get('/admin/customer', [CustomerController::class,'index'])->name('pages.admin.customer');
Route::delete('/admin/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
Route::get('/admin/driver', [DriverController::class,'index'])->name('pages.admin.driver');
Route::delete('/admin/driver/{id}', [DriverController::class, 'destroy'])->name('driver.destroy');
Route::get('/admin/waiter', [WaiterController::class,'index'])->name('pages.admin.waiter');
Route::delete('/admin/waiter/{id}', [WaiterController::class, 'destroy'])->name('waiter.destroy');

