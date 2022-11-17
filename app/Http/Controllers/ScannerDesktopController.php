<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScannerDesktopController extends Controller
{
    public function checkin(Request $request)
    {
        return view('scanner.desktop.checkin');
    }
    public function checkout(Request $request)
    {
        return view('scanner.desktop.checkout');
    }
}
