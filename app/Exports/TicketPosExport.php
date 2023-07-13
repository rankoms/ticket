<?php

namespace App\Exports;

use App\Models\HRDepartment;
use App\Models\MasterKontrak;
use App\Models\PosTicket;
use App\Models\ProductUser;
use App\Models\Ticket;
use App\Models\TicketHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TicketPosExport implements FromView
{
    use Exportable;
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $user_id = $request->user_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $pos = PosTicket::with('user')->orderBy('id', 'desc');

        if ($user_id) {
            $pos = $pos->where('user_id', $user_id);
        }
        $tanggal = '';
        if ($start_date && $end_date) {
            $tanggal = $start_date . ' s/d ' . $end_date;
            $pos = $pos->whereBetween('date', [$start_date, $end_date]);
        }

        $pos = $pos->get();

        $total_revenue = 0;
        $tiket_sold = 0;
        $tiket_sold_day = 0;
        foreach ($pos as $key => $value) :
            $total_revenue = $total_revenue + $value->total_harga;
            $tiket_sold = $tiket_sold + $value->quantity;
            if ($value->date == date('Y-m-d')) {
                $tiket_sold_day = $tiket_sold_day + $value->quantity;
            }
        endforeach;


        return view('excel.excel_pos', compact('pos', 'request', 'total_revenue', 'tiket_sold', 'tiket_sold_day', 'tanggal'));
    }
}
