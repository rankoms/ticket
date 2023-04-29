<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PosController as ControllersPosController;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function store(Request $request)
    {
        // return 'kesini';
        $pos = new ControllersPosController;
        $pos = $pos->store($request);
        return $pos;
    }
}
