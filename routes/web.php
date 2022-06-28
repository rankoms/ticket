<?php

use App\Http\Controllers\AuthController;
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

Route::group(['prefix' => 'scanner'], function () {
    Route::get('/checkin', [ScannerController::class, 'checkin'])->name('scanner.checkin');
    Route::get('/checkout', [ScannerController::class, 'checkout'])->name('scanner.checkout');
});


Route::group(['middleware' => ['auth']], function () {

    // /**
    //  * PENERIMAAN UNTUK PIC
    //  * 
    //  */
    // Route::group(['middleware' => ['is_pic'], 'prefix' => 'pic'], function () {
    //     Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('pic.penerimaan.index');
    //     Route::get('/scaner/penerimaan', [PenerimaanController::class, 'scanner_penerimaan'])->name('pic.penerimaan.scanner');
    //     Route::post('/scanner/simpan_scanner', [PenerimaanController::class, 'simpan_scanner'])->name('pic.penerimaan.simpan_scanner');
    //     Route::get('/penerimaan/{id}', [PenerimaanController::class, 'penerimaan'])->name('pic.penerimaan.penerimaan');
    //     Route::get('/penerimaan_success/{id}', [PenerimaanController::class, 'penerimaan_success'])->name('pic.penerimaan.penerimaan_success');
    //     Route::get('/input_penerimaan/{id}', [PenerimaanController::class, 'input_penerimaan'])->name('pic.penerimaan.input_penerimaan');

    //     Route::post('/penerimaan/store_stock_move', [PenerimaanController::class, 'store_stock_move'])->name('pic.penerimaan.store_stock_move');

    //     Route::post('/penerimaan/store_penerimaan', [PenerimaanController::class, 'store_penerimaan'])->name('pic.penerimaan.store_penerimaan');
    //     Route::post('/penerimaan/store_product_user', [PenerimaanController::class, 'store_product_user'])->name('pic.penerimaan.store_product_user');
    //     Route::post('/penerimaan/search_product_user', [PenerimaanController::class, 'search_product_user'])->name('pic.penerimaan.search_product_user');
    // });


    // Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // Route::get('/notification', [HomeController::class, 'notification'])->name('notification');
    // Route::get('/user/logout', [AuthController::class, 'auth_logout'])->name('auth.auth_logout');

    // /** START ROUTING KHUSUS ADMIN */
    // Route::group(['prefix' => 'fpb', 'middleware' => ['is_admin']], function () {
    //     Route::get('/', [FPBController::class, 'index'])->name('fpb.index');
    //     Route::get('/scanner', [FPBController::class, 'scanner'])->name('fpb.scanner');
    //     Route::post('/simpan_scanner', [FPBController::class, 'simpan_scanner'])->name('fpb.simpan_scanner');
    //     Route::get('/scanner/rakbin/{id}', [PenyimpananController::class, 'scanner_rakbin'])->name('fpb.scanner_rakbin');
    // });

    // Route::group(['prefix' => 'penyimpanan', 'middleware' => ['is_admin']], function () {
    //     Route::get('/rekomendasi_penyimpanan', [PenyimpananController::class, 'rekomendasi_penyimpanan'])->name('penyimpanan.rekomendasi_penyimpanan');
    //     Route::get('/{id}', [PenyimpananController::class, 'penyimpanan'])->name('penyimpanan');
    //     Route::get('/confirm/{id}', [PenyimpananController::class, 'penyimpanan_confirm'])->name('penyimpanan.confirm');
    //     Route::get('/success/{id}', [PenyimpananController::class, 'penyimpanan_success'])->name('penyimpanan.success');
    //     Route::get('/store_penyimpanan_confirm/{id}', [PenyimpananController::class, 'store_penyimpanan_confirm'])->name('penyimpanan.store_penyimpanan_confirm');
    //     Route::post('/simpan_scanner', [PenyimpananController::class, 'simpan_scanner'])->name('penyimpanan.simpan_scanner');
    //     Route::post('/store_stock_move', [PenyimpananController::class, 'store_stock_move'])->name('penyimpanan.store_stock_move');
    //     Route::post('/store_all_stock_move', [PenyimpananController::class, 'store_all_stock_move'])->name('penyimpanan.store_all_stock_move');
    // });

    // Route::group(['prefix' => 'spesifikasi'], function () {
    //     Route::post('/product_penelusuran', [ProductController::class, 'product_penelusuran'])->name('spesifikasi.product_penelusuran');
    //     Route::post('/product', [ProductController::class, 'product'])->name('spesifikasi.product');
    //     Route::post('/spectec_fpb_detail', [ProductController::class, 'spectec_fpb_detail'])->name('spesifikasi.spectec_fpb_detail');
    // });
    // /** END ROUTING KHUSUS ADMIN */


    // Route::group(['prefix' => 'pendistribusian'], function () {
    //     Route::get('/', [PendistribusianController::class, 'index'])->name('pendistribusian.index');
    //     Route::get('/input_pendistribusian', [PendistribusianController::class, 'input_pendistribusian'])->name('pendistribusian.input_pendistribusian');
    //     Route::get('/{id}', [PendistribusianController::class, 'pendistribusian'])->name('pendistribusian.pendistribusian');
    // });

    // Route::group(['prefix' => 'penelusuran'], function () {
    //     Route::get('/', [PenelusuranController::class, 'index'])->name('penelusuran.index');
    //     Route::get('/scanner', [PenelusuranController::class, 'scanner'])->name('penelusuran.scanner');
    //     Route::post('/scanner/check', [PenelusuranController::class, 'scanner_check'])->name('penelusuran.scanner.check');
    // });


    // Route::group(['prefix' => 'profile'], function () {
    //     Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    //     Route::post('/update_profile', [ProfileController::class, 'update_profile'])->name('profile.update_profile');
    // });
});
