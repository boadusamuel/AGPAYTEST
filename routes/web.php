<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/countries/create', [CountryController::class, 'create']);
Route::post('/countries', [CountryController::class, 'store'])->name('countries');

Route::get('/currencies/create', [CurrencyController::class, 'create']);
Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies');

