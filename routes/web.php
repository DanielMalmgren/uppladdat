<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwishController;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/swish/test',       'SwishController@test');

Route::get('/swish/test', [SwishController::class, 'test']);
Route::post('/swish/callback', [SwishController::class, 'callback']);
