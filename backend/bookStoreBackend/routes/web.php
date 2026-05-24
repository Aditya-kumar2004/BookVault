<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

use App\Http\Controllers\RazorpayController;

Route::get('/payment', [RazorpayController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/callback', [RazorpayController::class, 'paymentCallback'])->name('payment.callback');

