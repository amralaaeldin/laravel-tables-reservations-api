<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
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


Route::get('tables/check-availability', [TableController::class, 'checkAvailability']);
Route::get('tables/available', [TableController::class, 'indexAvailable']);

Route::post('reservations', [ReservationController::class, 'store']);

Route::get('menu', [MealController::class, 'index']);

Route::post('orders', [OrderController::class, 'store']);

Route::get('reservations/{reservation}/checkout', [ReservationController::class, 'checkout']);
