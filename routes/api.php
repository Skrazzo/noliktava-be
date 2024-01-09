<?php

use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ShelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [UserController::class, 'login']); // login - [username, password]
Route::put('/logout', [UserController::class, 'logout']); // logout - []
//Route::get('/users', [UserController::class, 'index']); // show all users - []

// admin
Route::group([], function() {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']); // show all users - []
        Route::post('/', [UserController::class, 'store']); // register new user - [username, password, privilage - 0,1,2]
        Route::get('/{id}', [UserController::class, 'show']); // show specific user - []
        Route::put('/{id}', [UserController::class, 'update']); // edit specific users password or privilage information - [password, privilage - 0,1,2]
        Route::delete('/{id}', [UserController::class, 'destroy']); // delete user - [pass id in the link]
        
    });
});

Route::prefix('items')->group(function () {
    Route::get('/', [ItemsController::class, 'index']); // Retrieve all items
    Route::get('/{id}', [ItemsController::class, 'show']); // Retrieve a specific item by ID
    Route::post('/', [ItemsController::class, 'create']); // Create a new item
    Route::put('/{id}', [ItemsController::class, 'update']); // Update an existing item
    Route::delete('/{id}', [ItemsController::class, 'delete']); // Delete an item
});

// warehouse_worker
Route::middleware('')->group(function() {
    Route::prefix('shelf')->group(function () {
        Route::get('/', [ShelfController::class, 'index']); // Retrieve all items
        Route::get('/{id}', [ShelfController::class, 'list_shelf']); // Retrieve a specific item by ID
        Route::post('/', [ShelfController::class, 'create']); // Create a new item
        Route::put('/{id}', [ShelfController::class, 'update']); // Update an existing item
        Route::delete('/{id}', [ShelfController::class, 'delete']); // Delete an item
    });

});


