<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::group(['prefix' => 'scanner'], function () {
    Route::post('/checkin', [TicketController::class, 'checkin']);
    Route::post('/checkout', [TicketController::class, 'checkout']);
});

Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
    Route::post('/event_category', [TicketController::class, 'event_category'])->name('event_category');
    Route::post('/ticket', [TicketController::class, 'ticket'])->name('ticket');
});
