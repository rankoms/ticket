<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Imports\TicketImport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //

    public function get_ticket(Request $request)
    {
        return view('import.ticket');
    }

    public function ticket(Request $request)
    {

        try {
            $hasil = Excel::import(new TicketImport, $request->file('file'));
            return ResponseFormatter::success($hasil, __("Success"));
        } catch (ValidationException $e) {
            return ResponseFormatter::error(null, $e->errors());
        }
    }
}
