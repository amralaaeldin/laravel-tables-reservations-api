<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\WaitingListController;
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

Route::apiResource('tables', TableController::class);
Route::get('tables/check-availability', [TableController::class, 'checkAvailability']);
Route::get('tables/available', [TableController::class, 'indexAvailable']);

Route::apiResource('reservations', ReservationController::class);
Route::get('reservations/{reservation}/checkout', [ReservationController::class, 'checkout']);

Route::apiResource('waiting-list', WaitingListController::class)
  ->only(['index', 'show']);

Route::apiResource('orders', OrderController::class);

Route::post('order-details/{order}', [OrderDetailController::class, 'store']);
Route::apiResource('order-details', OrderDetailController::class)
  ->only(['update', 'destroy']);

Route::apiResource('meals', MealController::class);
