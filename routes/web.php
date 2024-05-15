<?php

use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/categories', [ItemCategoryController::class, "index"])->name("categories.index");
Route::get('/categories/create', [ItemCategoryController::class, "create"])->name("categories.create");
Route::get('/categories/{category}', [ItemCategoryController::class, "show"])->name("categories.show");
Route::get('/categories/{category}/edit', [ItemCategoryController::class, "edit"])->name("categories.edit");
Route::post('/categories', [ItemCategoryController::class, "store"])->name("categories.store");
Route::delete('/categories/{category}', [ItemCategoryController::class, "destroy"])->name("categories.destroy");
Route::put('/categories/{category}', [ItemCategoryController::class, "update"])->name("categories.update");

Route::get('/categories/{category}/items', [ItemController::class, "index"])->name("categories.items.index");
Route::get('/categories/{category}/item/create', [ItemController::class, "create"])->name("categories.items.create");
Route::get('/items/{item}', [ItemController::class, "show"])->name("items.show");
Route::get('/items/{item}/edit', [ItemController::class, "edit"])->name("items.edit");
Route::post('/categories/{category}/items', [ItemController::class, "store"])->name("categories.items.store");
Route::delete('/items/{item}', [ItemController::class, "destroy"])->name("items.destroy");
Route::put('/items/{item}', [ItemController::class, "update"])->name("items.update");
