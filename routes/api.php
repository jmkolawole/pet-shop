<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\v1\Auth\Admin\AdminController;
use App\Http\Controllers\v1\Auth\User\UserController;
use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\BrandController;
use App\Http\Controllers\v1\OrderController;
use App\Http\Controllers\v1\OrderStatusController;

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

    //Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/{uuid}', [CategoryController::class, 'showCategory']);

    //Brands
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brand/{uuid}', [BrandController::class, 'showBrand']);


    //User unprotected routes
    Route::post('/user/login', [UserController::class, 'userLogin']);
    Route::post('/user/create', [UserController::class, 'createUser']);
    Route::post('/user/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/user/reset-password-token', [UserController::class, 'resetPassword']);

    //Admin unprotected routes
    Route::post('admin/login', [AdminController::class, 'adminLogin']);
    Route::post('admin/create', [AdminController::class, 'createAdmin']);

    Route::middleware(['check-request-token'])->group(function () {
        //Routes only opened for authenticated users

        Route::group(['as' => 'users.'], function () {





            Route::get('/products', [ProductController::class, 'index']);
            Route::get('/user', [UserController::class, 'userInfo']);
            Route::delete('/user', [UserController::class, 'userDelete']);


            Route::get('/logout', [UserController::class, 'userLogout']);
        });


        Route::group(['as' => 'admin.'], function () {
            //Routes opened for only admins

            //Categories
            Route::prefix('category')->group(function () {
                Route::post('/create', [CategoryController::class, 'createCategory']);
                Route::put('/{uuid}', [CategoryController::class, 'editCategory']);
                Route::delete('/{uuid}', [CategoryController::class, 'deleteCategory']);
            });

            //Brands
            Route::prefix('brand')->group(function () {
                Route::post('/create', [BrandController::class, 'createBrand']);
                Route::put('/{uuid}', [BrandController::class, 'editBrand']);
                Route::delete('/{uuid}', [BrandController::class, 'deleteBrand']);
            });

            //Order Status
            Route::get('order-statuses', [OrderStatusController::class, 'orderStatuses']);
            Route::prefix('order-status')->group(function () {
                Route::post('/create', [OrderStatusController::class, 'createOrderStatus']);
                Route::put('/{uuid}', [OrderStatusController::class, 'editOrderStatus']);
                Route::get('/{uuid}', [OrderStatusController::class, 'getOrderStatus']);
                Route::delete('/{uuid}', [OrderStatusController::class, 'deleteOrderStatus']);
            });

            Route::prefix('admin')->group(function () {
                Route::get('/user-listing', [AdminController::class, 'userListing']);
                Route::put('/user-edit/{uuid}', [AdminController::class, 'userEdit']);
                Route::delete('/user-delete/{uuid}', [AdminController::class, 'userDelete']);
                Route::get('/logout', [AdminController::class, 'adminLogout']);
            });
        });
    });

    //Products


});
