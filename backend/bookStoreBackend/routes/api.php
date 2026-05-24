<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\RazorpayController;

Route::get('/auth/google', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// OTP routes (no auth needed — used during registration)
Route::post('/otp/send',   [OtpController::class, 'sendOtp']);
Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
Route::post('/newsletter/subscribe', [OtpController::class, 'subscribeNewsletter']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/authors', [AuthorController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
    Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);
    Route::post('/razorpay/order', [RazorpayController::class, 'apiCreateOrder']);
    Route::post('/razorpay/verify', [RazorpayController::class, 'apiVerifyPayment']);
    Route::middleware('admin')->group(function () {
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
        Route::get('/users', [AuthController::class, 'index']);
        Route::put('/users/{id}/toggle-status', [AuthController::class, 'toggleStatus']);
        Route::apiResource('/coupons', CouponController::class);
        Route::apiResource('/authors', AuthorController::class)->except(['index']);
    });
});
