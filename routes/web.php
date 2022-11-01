<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
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

// Route::get('/', [HomeController::class, 'splash_screen'])->name('splash_screen');

// Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');

// Route::group(['middleware' => ['is_logged']], function () {
//     Route::get('/login', [AuthController::class, 'index'])->name('login');
//     Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
//     Route::post('/user/login', [AuthController::class, 'auth_login'])->name('auth.auth_login');
//     Route::get('/forgot_password', [AuthController::class, 'forgot_password'])->name('auth.forgot_password');
//     Route::get('/change_password', [AuthController::class, 'change_password'])->name('auth.change_password');
// });
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::group(['prefix' => 'scanner'], function () {
    Route::get('/checkin', [ScannerController::class, 'checkin'])->name('scanner.checkin');
    Route::get('/checkout', [ScannerController::class, 'checkout'])->name('scanner.checkout');

    Route::post('/section_select', [ScannerController::class, 'section_select'])->name('scanner.section_select');
    Route::post('/section_selected', [ScannerController::class, 'section_selected'])->name('scanner.section_selected');
});


Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::resource('event', EventController::class);
    Route::resource('ticket', TicketController::class);
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
