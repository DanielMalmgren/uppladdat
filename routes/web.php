<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\SwishController;
use App\Http\Controllers\GuestChargeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/gc/checkstatus/{charging_session}', [GuestChargeController::class, 'checkstatus']);
Route::get('/gc/success', [GuestChargeController::class, 'success']);
Route::get('/gc/failure', [GuestChargeController::class, 'failure']);
Route::get('/gc/{charger}', [GuestChargeController::class, 'init']);

Route::get('/swish/pay', [SwishController::class, 'pay']);
Route::post('/swish/callback', [SwishController::class, 'callback'])->withoutMiddleware([VerifyCsrfToken::class]);
