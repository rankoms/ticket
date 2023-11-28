<?php

use Illuminate\Support\Facades\DB;

function areActiveRoutes(array $routes, $output = "active")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
    }
}

function format_hari_tanggal($waktu)
{
    $hari_array = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];
    $tanggal = date('j', strtotime($waktu));
    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );
    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date('H:i:s', strtotime($waktu));


    //untuk menampilkan hari, tanggal bulan tahun
    return "$hari, $tanggal $bulan $tahun $jam";
}

function formatter_number($value)
{
    return number_format(floatval($value));
}
function type_array_redeem()
{
    return ['redeem_only' => 'Redeem E-Voucher Only', 'redeem_with_voucher' => 'Redeem E-voucher With Print Ticket', 'redeem_with_inject' => 'Redeem E-voucher With Inject Ticket'];
}

function type_route_array_redeem($event, $category)
{
    return ['redeem_only' => route('redeem_voucher.barcode', ['event' => $event, 'category' => $category]), 'redeem_with_voucher' => route('redeem_voucher.ticket',  ['event' => $event, 'category' => $category]), 'redeem_with_inject' => route('redeem_voucher.inject',  ['event' => $event, 'category' => $category])];
}
