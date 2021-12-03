<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AttendeController;
use App\Http\Controllers\API\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public routes
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route Users
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [UserController::class, 'logout']);
    
    // Route User Data
    Route::resource('users', UserController::class);

    // Route Attende Data
    Route::resource('attendes', AttendeController::class);
    
    // Route Permission Data
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/all', [PermissionController::class, 'all']);
        Route::post('/approve',  [PermissionController::class, 'approve']);
    });
    Route::resource('permissions', PermissionController::class);
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/all', [PermissionController::class, 'all']);
        // Route::post('/approve/{permission}',  [PermissionController::class, 'approve']);
    });
});

