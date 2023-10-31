<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\PayerController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/register', 'register')->name('auth.register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/me', 'me')->name('auth.me');
        Route::get('/logout', 'logout')->name('auth.logout');
    });
    Route::controller(BarcodeController::class)->prefix('/boleto')->group(function () {
        Route::delete('/delete/{barcode_id}', 'destroy')->name('barcode.destroy');
        Route::put('/update/{barcode_id}', 'update')->name('barcode.update');
        Route::get('/pagador/{pagador_id}', 'index')->name('barcode.payer');
        Route::post('/create', 'store')->name('barcode.store');
        Route::get('/me', 'index')->name('barcode.me');
    });
    Route::controller(PayerController::class)->prefix('pagador')->group(function () {
        Route::delete('/delete/{payer_id}', 'destroy')->name('payer.destroy');
        Route::get('/me', 'index')->name('payer.me');
        Route::post('/create', 'store')->name('payer.store');
        Route::put('/update/{payer_id}', 'update')->name('payer.update');
    });
});
