<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\v1\Auth\Admin\AdminController;
use App\Http\Controllers\v1\Auth\User\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    
    //User unprotected routes
    Route::post('/login', [UserController::class, 'userLogin']);
    Route::post('/create', [UserController::class, 'createUser']);
    
    //Admin unprotected routes
    Route::post('admin/login', [AdminController::class, 'adminLogin']);
    Route::post('admin/create', [AdminController::class, 'createAdmin']);
    
    Route::middleware(['check-request-token'])->group(function () {

        Route::get('/products', [ProductController::class, 'index']);


        Route::post('/logout', [UserController::class, 'userLogout']);


        Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
            Route::get('/products', [ProductController::class, 'index']);


            Route::post('/logout', [AdminController::class, 'adminLogout']);
        });

    });

    //Products

    
});    
