<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SwishController;
use App\Http\Controllers\GuestChargeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\OwnerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/gc/checkstatus/{charging_session}', [GuestChargeController::class, 'checkstatus']);
Route::get('/gc/success', [GuestChargeController::class, 'success']);
Route::get('/gc/failure', [GuestChargeController::class, 'failure']);
Route::get('/gc/{charger}', [GuestChargeController::class, 'init']);

Route::get('/swish/pay', [SwishController::class, 'pay']);
Route::post('/swish/callback', [SwishController::class, 'callback'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/swish/refund', [SwishController::class, 'refund'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'index']);

Route::get('/admin/payments', [AdminController::class, 'payments']);

Route::get('/admin/chargers', [ChargerController::class, 'index']);
Route::get('/admin/chargers/{charger}/edit', [ChargerController::class, 'edit']);
Route::put('/admin/chargers/{charger}', [ChargerController::class, 'update']);

Route::get('/admin/owners', [OwnerController::class, 'index']);
Route::get('/admin/owners/{owner}/edit', [OwnerController::class, 'edit']);
Route::put('/admin/owners/{owner}', [OwnerController::class, 'update']);
