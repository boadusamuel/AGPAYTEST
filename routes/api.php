<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1.0')->group(function (){
    Route::ApiResource('countries', CountryController::class);
    Route::ApiResource('currencies', CurrencyController::class);
});
