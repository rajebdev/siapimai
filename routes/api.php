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


// Protected routes with sanctum
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route Users
    Route::post('/logout', [UserController::class, 'logout']);
    
    // Route User Data
    Route::group(['prefix' => 'users'], function () {
        Route::get('/my', [UserController::class, 'my']);
    });

    // Route Attende Data
    Route::group(['prefix' => 'attendes'], function () {
        Route::get('/my', [AttendeController::class, 'my']);
    });
    
    // Route Permission Data
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/my', [PermissionController::class, 'my']);
    });

});


// Protected routes with sanctum and role
Route::group(['middleware' => ['auth:sanctum', 'roleNotEmployee']], function () {
    
    // Route User Data
    Route::group(['prefix' => 'users'], function () {
        Route::get('/all', [UserController::class, 'all']);
    });
    Route::resource('users', UserController::class);

    // Route Attende Data
    Route::group(['prefix' => 'attendes'], function () {
        Route::get('/all', [AttendeController::class, 'all']);
    });
    Route::resource('attendes', AttendeController::class);
    
    // Route Permission Data
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/all', [PermissionController::class, 'all']);
        Route::post('/approve/{permissions}',  [PermissionController::class, 'approve']);
    });
    Route::resource('permissions', PermissionController::class);
});

