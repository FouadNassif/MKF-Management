<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\WaiterController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\DriverController as ControllersDriverController;
use App\Http\Controllers\WaitersController;


Route::get('/', [ItemController::class, 'homePage'])->name('restaurant.homePage');

// Show the registration Form and Check the registration
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'userRegister']);

// Show the login Form and Check the login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/item/search', [ItemController::class, 'search'])->name('item.search');
Route::post('/item/category', [ItemController::class, 'getItemsByCategory'])->name('item.category');

Route::post('/getItems', [ItemController::class, 'getItems'])->name('item.getItemById');
Route::post('/user/cart/placeOrder', [UserController::class, 'placeOrder'])->name('user.cart.placeOrder');

Route::middleware('auth')->group(function () {
    // User routes
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/updateProfile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
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
Route::post('/item/creates', [ItemController::class, "store"])->name("categories.items.store");
Route::delete('/items/{item}', [ItemController::class, "destroy"])->name("items.destroy");
Route::put('/items/{item}', [ItemController::class, "update"])->name("items.update");

Route::middleware("roles:cashier,waiter")->group(function () {
    // POS routes
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/order', [PosController::class, 'order'])->name('pos.order');
    Route::put('/pos/order', [PosController::class, 'updateOrder'])->name('pos.order.update');
});

Route::middleware("roles:waiter")->group(function () {
    Route::get('/waiters', [WaitersController::class, 'getAllOrder'])->name('waiter.index');
    Route::get('/waiters/createOrder', [WaitersController::class, 'createOrder'])->name('waiter.order.create');
    Route::post('/waiters/getAllOrder', [WaitersController::class, 'getAllOrderJS'])->name('waiters.allOrders');
    Route::post('/waiter/getOrderById', [WaitersController::class, "getOrderById"])->name('waiters.getOrderById');
    Route::post('/waiter/saveEditedOrder', [WaitersController::class, "saveEditedOrder"])->name('waiters.saveEditedOrder');
    Route::post('/waiter/deleteItem', [WaitersController::class, "deleteItem"])->name('waiters.deleteItem');
});

Route::middleware("roles:driver")->group(function () {
    Route::get('/driver', [ControllersDriverController::class, 'index'])->name('driver.index');
    Route::get('/driver/checkout/{order}', [ControllersDriverController::class, 'goToCheckout'])->name('driver.checkout');
    Route::get('/driver/deliver/{order}', [ControllersDriverController::class, 'deliverOrder'])->name('driver.deliver');
});

Route::post('/waiter/to-pos', [WaitersController::class, 'waiterToPos'])->name('waiter.toPos');

Route::get('/pos/payment', [PosController::class, 'payment'])->name('pos.payment.index');
Route::post('/pos/payment', [PosController::class, 'paymentStore'])->name('pos.payment.store');

//ADMIN routes
Route::middleware("roles:admin")->group(function () {

    Route::get('/admin', [dashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/customer', [dashboardController::class, 'getCustomers'])->name('pages.admin.customer');
    Route::delete('/admin/customer/{id}', [dashboardController::class, 'destroyCustomers'])->name('customer.destroy');
    Route::get('/admin/driver', [dashboardController::class, 'getDrivers'])->name('pages.admin.driver');
    Route::delete('/admin/driver/{id}', [dashboardController::class, 'destroyDrivers'])->name('driver.destroy');
    Route::get('/admin/waiter', [dashboardController::class, 'getWaiters'])->name('pages.admin.waiter');
    Route::delete('/admin/waiter/{id}', [dashboardController::class, 'destroyWaiters'])->name('waiter.destroy');
    Route::get('/admin/orders', [dashboardController::class, 'getOrders'])->name('pages.admin.orders');
    Route::get('/admin/menuItems', [dashboardController::class, 'getMenuItems'])->name('pages.admin.menuItems');
});
