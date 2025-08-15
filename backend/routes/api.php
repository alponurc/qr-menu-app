<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\OnboardingController;

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('authApi')->group(function () {
    // GET Routes
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/slides', [SlideController::class, 'index']);
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/promocodes', [PromocodeController::class, 'index']);
    Route::get('/discount', [PromocodeController::class, 'getDiscount']);
    Route::get('/dishes/most-favorited', [DishController::class, 'mostFavoritedDish']);
    Route::get('/settings/show-most-favorited-dish', [SettingsController::class, 'showMostFavoritedDishSetting']);
   // Route::get('/products', [ApiProductController::class, 'index']);
    Route::get('/onboarding', [OnboardingController::class, 'index']);
    Route::post('/order/create', [OrderController::class, 'create']);
    Route::post('/auth/user/update', [AuthController::class, 'updateUser']);
    Route::post('/auth/user/create', [AuthController::class, 'createNewUser']);
    Route::post('/auth/user/exists', [AuthController::class, 'ifUserExists']);
    Route::post('/auth/email/exists', [AuthController::class, 'ifEmailExists']);
    Route::post('/dishes/{id}/favorite', [DishController::class, 'addFavorite']);
});

// Sanctum test route (genellikle frontend için)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
