<?php

use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaitersController;

use function PHPUnit\Framework\returnSelf;

Route::get('/', [ItemController::class, 'homePage'])->name('restaurant.homePage');

// Show the registration Form and Check the registration
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'userRegister']);

// Show the login Form and Check the login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/item/search', [ItemController::class, 'search'])->name('item.search');
Route::post('/item/category', [ItemController::class, 'getItemsByCategory'])->name('item.category');

Route::middleware('auth')->group(function () {
    // User routes
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::post('/getItems', [ItemController::class, 'getItems'])->name('item.getItemById');
    Route::get('/user/deleteAddress/{address}', [UserController::class, 'deleteAddress'])->name('user.deleteAddress');
    Route::get('/user/cart', [UserController::class, 'showCart'])->name('user.cart');
});

Route::post('/user/cart/placeOrder', [UserController::class, 'placeOrder'])->name('user.cart.placeOrder');

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
Route::post('/item/creates', [ItemController::class, "store"])->name("categories.items.store");
Route::delete('/items/{item}', [ItemController::class, "destroy"])->name("items.destroy");
Route::put('/items/{item}', [ItemController::class, "update"])->name("items.update");

// POS routes
Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/pos/order', [PosController::class, 'order'])->name('pos.order');
Route::get('/pos/payment', [PosController::class, 'payment'])->name('pos.payment.index');
Route::post('/pos/payment', [PosController::class, 'paymentStore'])->name('pos.payment.store');

Route::get('/waiters', [WaitersController::class, 'getAllOrder'])->name('waiters.homepage');
Route::post('/waiters/getAllOrder', [WaitersController::class, 'getAllOrderJS'])->name('waiters.allOrders');
Route::post('/waiter/getOrderById', [WaitersController::class, "getOrderById"])->name('waiters.getOrderById');
Route::post('/waiter/saveEditedOrder', [WaitersController::class, "saveEditedOrder"])->name('waiters.getOrderById');

Route::middleware("roles:admin,cashier,waiter")->group(function () {
    // POS routes
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/order', [PosController::class, 'order'])->name('pos.order');
    Route::get('/pos/payment', [PosController::class, 'payment'])->name('pos.payment.index');
    Route::post('/pos/payment', [PosController::class, 'paymentStore'])->name('pos.payment.store');
});
