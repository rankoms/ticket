<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScannerController extends Controller
{
    //
    public function checkin(Request $request)
    {
        return view('scanner.checkin');
    }
    public function checkout(Request $request)
    {
        return view('scanner.checkout');
    }
}
