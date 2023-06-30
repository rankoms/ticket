<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PosTicketController;
use App\Http\Controllers\RedeemVoucherController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\ScannerDesktopController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'register' => false
]);

Route::get('test', [HomeController::class, 'test']);

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('user_logout', [LoginController::class, 'logout'])->name('user.logout');

Route::group(['middleware' => ['auth', 'is_admin']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy-policy');
Route::post('/update_password', [HomeController::class, 'update_password'])->name('update_password');

Route::get('/auto_login_event', [HomeController::class, 'auto_login_event'])->name('auto_login_event');

Route::group(['middleware' => ['auth', 'is_client'], 'prefix' => 'admin'], function () {

    Route::group(['prefix' => 'import'], function () {
        Route::get('/ticket', [ImportController::class, 'get_ticket'])->name('import.get_ticket');
        Route::post('/ticket', [ImportController::class, 'ticket'])->name('import.ticket');
    });


    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard_redeem', [RedeemVoucherController::class, 'dashboard_redeem'])->name('redeem_voucher.dashboard');
    Route::get('/dashboard_ticket', [TicketController::class, 'dashboard_ticket'])->name('dashboard_ticket');
    /* START UNTUK MENAMBAHKAN VARIABLE DASHBOARD  */
    Route::get('/dashboard_ticket_current', [TicketController::class, 'dashboard_ticket_current'])->name('dashboard_ticket_current');
    /* END UNTUK MENAMBAHKAN VARIABLE DASHBOARD */
    Route::post('/dashboard_ticket', [TicketController::class, 'post_dashboard_ticket'])->name('post_dashboard_ticket');

    Route::get('/excel_ticket', [TicketController::class, 'excel_ticket'])->name('excel_ticket');
    Route::get('/excel_ticket_current', [TicketController::class, 'excel_ticket_current'])->name('excel_ticket_current');
    Route::get('/excel_redeem', [RedeemVoucherController::class, 'excel_redeem'])->name('excel_redeem');

    Route::get('/change_password', [HomeController::class, 'change_password'])->name('change_password');
});


Route::get('/home_new', [HomeController::class, 'home_new'])->name('home_new');

Route::group(['middleware' => ['is_admin']], function () {

    Route::group(['prefix' => 'pos'], function () {
        Route::get('/', [PosController::class, 'index'])->name('pos.index');
        Route::get('/cetak/{id}', [PosController::class, 'cetak'])->name('pos.cetak');
        Route::post('/store', [PosController::class, 'store'])->name('pos.store');
        Route::get('/dashboard_pos', [PosController::class,  'dashboard_pos'])->name('pos.dashboard_pos');
    });


    Route::group(['prefix' => 'pos_ticket'], function () {
        Route::get('/', [PosTicketController::class, 'index'])->name('pos_ticket.index');
        Route::get('/cetak/{id}', [PosTicketController::class, 'cetak'])->name('pos_ticket.cetak');
        Route::post('/store', [PosTicketController::class, 'store'])->name('pos_ticket.store');
        Route::get('/dashboard', [PosTicketController::class,  'dashboard'])->name('pos_ticket.dashboard');
        Route::post('/category_select', [PosTicketController::class, 'category_select'])->name('pos_ticket.category_select');
    });
    Route::group(['prefix' => 'scanner'], function () {
        Route::get('/store_pilih_event', [ScannerController::class, 'store_pilih_event'])->name('scanner.store_pilih_event');
        Route::get('/pilih_event', [ScannerController::class, 'pilih_event'])->name('scanner.pilih_event');

        Route::get('/checkin', [ScannerController::class, 'checkin'])->name('scanner.checkin');
        Route::get('/checkout', [ScannerController::class, 'checkout'])->name('scanner.checkout');


        Route::group(['prefix' => 'desktop'], function () {
            Route::get('/checkin', [ScannerDesktopController::class, 'checkin'])->name('scanner.desktop.checkin');
            Route::get('/checkout', [ScannerDesktopController::class, 'checkout'])->name('scanner.desktop.checkout');
        });



        Route::post('/section_select', [ScannerController::class, 'section_select'])->name('scanner.section_select');
        Route::post('/section_selected', [ScannerController::class, 'section_selected'])->name('scanner.section_selected');


        Route::post('/ticket/checkin', [TicketController::class, 'checkin'])->name('ticket.checkin');
    });
});

Route::group(['middleware' => ['auth', 'is_admin'], 'prefix' => 'admin'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');
    Route::group(['prefix' => 'redeem_voucher'], function () {
        Route::get('/', [RedeemVoucherController::class, 'index'])->name('redeem_voucher.index');
        Route::get('/choose', [RedeemVoucherController::class, 'choose'])->name('redeem_voucher.choose');
        Route::get('/barcode', [RedeemVoucherController::class, 'barcode'])->name('redeem_voucher.barcode');
        Route::get('/v2', [RedeemVoucherController::class, 'index_v2'])->name('redeem_voucher.index_v2');

        Route::get('/ticket', [RedeemVoucherController::class, 'ticket'])->name('redeem_voucher.ticket');
        Route::get('/cetak_ticket/{id}', [RedeemVoucherController::class, 'cetak_ticket'])->name('redeem_voucher.cetak_ticket');
    });




    Route::get('/redeem_voucher/{kode}', [RedeemVoucherController::class, 'detail'])->name('redeem_voucher.detail');
    Route::get('/summary_redeem', [RedeemVoucherController::class, 'summary_redeem'])->name('redeem_voucher.summary_redeem');
    Route::post('/redeem_voucher_update', [RedeemVoucherController::class, 'redeem_voucher_update'])->name('redeem_voucher.redeem_voucher_update');
    Route::post('/redeem_voucher_update_v2', [RedeemVoucherController::class, 'redeem_voucher_update_v2'])->name('redeem_voucher.redeem_voucher_update_v2');
    Route::post('/redeem_voucher_update_ticket', [RedeemVoucherController::class, 'redeem_voucher_update_ticket'])->name('redeem_voucher.redeem_voucher_update_ticket');
    Route::post('/redeem_voucher_update_barcode', [RedeemVoucherController::class, 'redeem_voucher_update_barcode'])->name('redeem_voucher.redeem_voucher_update_barcode');
    Route::post('/cek_redeem_vouceher', [RedeemVoucherController::class, 'cek_redeem_voucher'])->name('redeem_voucher.cek_redeem_voucher');
    Route::resource('event', EventController::class);
    Route::resource('ticket', TicketController::class);
});
