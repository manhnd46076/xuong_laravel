<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\PaymentController;

Route::get('/payments/start', [PaymentController::class, 'startTransaction'])->name('payments.start');
Route::post('/payments/store', [PaymentController::class, 'storeTransaction'])->name('payments.store');

Route::get('/payments/confirm', [PaymentController::class, 'confirmTransaction'])->name('payments.confirm');
Route::post('/payments/process', [PaymentController::class, 'processTransaction'])->name('payments.process');

Route::get('/payments/complete', [PaymentController::class, 'completeTransaction'])->name('payments.complete');
Route::post('/payments/cancel', [PaymentController::class, 'cancelTransaction'])->name('payments.cancel');
