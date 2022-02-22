<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SwishController;
use App\Http\Controllers\GuestChargeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/gc/checkstatus/{charging_session}', [GuestChargeController::class, 'checkstatus']);
Route::get('/gc/success', [GuestChargeController::class, 'success']);
Route::get('/gc/failure', [GuestChargeController::class, 'failure']);
Route::get('/gc/{charger}', [GuestChargeController::class, 'init']);

Route::get('/swish/pay', [SwishController::class, 'pay']);
Route::post('/swish/pay/callback', [SwishController::class, 'pay_callback'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/swish/refund', [SwishController::class, 'refund'])->middleware('auth');
Route::post('/swish/refund/callback', [SwishController::class, 'refund_callback'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/admin', [AdminController::class, 'index']);

Route::get('/admin/payments', [PaymentController::class, 'index']);

Route::get('/admin/chargers', [ChargerController::class, 'index']);
Route::get('/admin/chargers/{charger}/edit', [ChargerController::class, 'edit']);
Route::put('/admin/chargers/{charger}', [ChargerController::class, 'update']);

Route::get('/admin/owners', [OwnerController::class, 'index']);
Route::get('/admin/owners/{owner}/edit', [OwnerController::class, 'edit']);
Route::put('/admin/owners/{owner}', [OwnerController::class, 'update']);
