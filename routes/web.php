<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RedeemVoucherController;
use App\Http\Controllers\ScannerController;
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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::group(['prefix' => 'scanner'], function () {
    Route::get('/checkin', [ScannerController::class, 'checkin'])->name('scanner.checkin');
    Route::get('/checkout', [ScannerController::class, 'checkout'])->name('scanner.checkout');

    Route::post('/section_select', [ScannerController::class, 'section_select'])->name('scanner.section_select');
    Route::post('/section_selected', [ScannerController::class, 'section_selected'])->name('scanner.section_selected');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/redeem_voucher', [RedeemVoucherController::class, 'index'])->name('redeem_voucher.index');
    Route::get('/summary_redeem', [RedeemVoucherController::class, 'summary_redeem'])->name('redeem_voucher.summary_redeem');
    Route::post('/redeem_voucher_update', [RedeemVoucherController::class, 'redeem_voucher_update'])->name('redeem_voucher.redeem_voucher_update');
    Route::post('/cek_redeem_vouceher', [RedeemVoucherController::class, 'cek_redeem_voucher'])->name('redeem_voucher.cek_redeem_voucher');
});

Route::get('/redeem_voucher/{kode}', [RedeemVoucherController::class, 'detail'])->name('redeem_voucher.detail');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [RedeemVoucherController::class, 'dashboard'])->name('redeem_voucher.dashboard');
    Route::resource('event', EventController::class);
    Route::resource('ticket', TicketController::class);
});
Auth::routes([
    'register' => false
]);
Route::get('user_logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');
