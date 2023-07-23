<?php

namespace App\Exports;

use App\Models\HRDepartment;
use App\Models\MasterKontrak;
use App\Models\ProductUser;
use App\Models\Ticket;
use App\Models\TicketHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TicketCurrentExport implements FromView
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
        $percent_report_current = config('scanner.percent_report_current');
        $ticket = Ticket::orderBy('category', 'asc');
        $ticket_not_valid = 0;
        if ($request->event) {
            $ticket = $ticket->where('event', $request->event);
            $ticket_not_valid = TicketHistory::where('event', $request->event)->where('is_valid', 0)->get();
            $ticket_not_valid = count($ticket_not_valid);
        }
        $ticket = $ticket->get();
        /* START JUMLAH VARIABLE TICKET */
        $jumlah_ticket = count($ticket);
        $max_ticket = $jumlah_ticket * $percent_report_current / 100;
        /* START JUMLAH VARIABLE TICKET */
        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        $jumlah_pending = 0;
        $jumlah_checkin = 0;
        $jumlah_checkout = 0;
        $kategory_aset = [];
        $gate_aset = [];
        foreach ($ticket as $key => $value) :
            if ($key >= $max_ticket) {
                break;
            }
            if ($value->checkin == null && $value->checkout == null) :
                $jumlah_pending++;
                isset($kategory_aset[$value->category]['pending']) ? $kategory_aset[$value->category]['pending']++ : $kategory_aset[$value->category]['pending'] = 1;
            endif;
            if ($value->checkin && $value->checkout == null) :
                $jumlah_checkin++;
                isset($kategory_aset[$value->category]['checkin']) ? $kategory_aset[$value->category]['checkin']++ : $kategory_aset[$value->category]['checkin'] = 1;
                isset($gate_aset[$value->gate_pintu_checkin]['checkin']) ? $gate_aset[$value->gate_pintu_checkin]['checkin']++ : $gate_aset[$value->gate_pintu_checkin]['checkin'] = 1;
            endif;
            if ($value->checkout) :
                $jumlah_checkout++;
                isset($kategory_aset[$value->category]['checkout']) ? $kategory_aset[$value->category]['checkout']++ : $kategory_aset[$value->category]['checkout'] = 1;
                isset($gate_aset[$value->gate_pintu_checkout]['checkout']) ? $gate_aset[$value->gate_pintu_checkout]['checkout']++ : $gate_aset[$value->gate_pintu_checkout]['checkout'] = 1;
            endif;
        endforeach;


        return view('excel.ticket', [
            'kategory_aset' => $kategory_aset,
            'ticket_not_valid' => $ticket_not_valid,
            'event' => $request->event,
            'jumlah_pending' => $jumlah_pending,
            'jumlah_checkin' => $jumlah_checkin,
            'jumlah_checkout' => $jumlah_checkout,
            'gate_aset' => $gate_aset

        ]);
    }
}
