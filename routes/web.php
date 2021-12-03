<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\AttendeController;
use App\Http\Controllers\WEB\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', [UserController::class, 'login'])->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::get('/register', [UserController::class, 'register'])->middleware('guest');


// Protected routes with sanctum
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    // Route User Data
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
    });

    // Route Attende Data
    Route::group(['prefix' => 'attendes'], function () {
        Route::get('/', [AttendeController::class, 'index']);
    });
    
    // Route Permission Data
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index']);
    });
});



// Protected routes with sanctum and role
Route::group(['middleware' => ['auth:sanctum', 'roleNotEmployee']], function () {
    
    // Route User Data
    Route::group(['prefix' => 'users'], function () {
        Route::get('/show', [UserController::class, 'show']);
        Route::get('/edit', [UserController::class, 'edit']);
        Route::get('/all', [UserController::class, 'all']);
    });

    // Route Attende Data
    Route::group(['prefix' => 'attendes'], function () {
        Route::get('/show', [AttendeController::class, 'show']);
        Route::get('/edit', [AttendeController::class, 'edit']);
        Route::get('/all', [AttendeController::class, 'all']);
    });
    
    // Route Permission Data
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/show', [PermissionController::class, 'show']);
        Route::get('/edit', [PermissionController::class, 'edit']);
        Route::get('/all', [PermissionController::class, 'all']);
        Route::get('/approve/{permissions}',  [PermissionController::class, 'approve']);
    });
});

