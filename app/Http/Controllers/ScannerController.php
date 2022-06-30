<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Event;
use App\Models\EventGate;
use App\Models\Ticket;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    //
    public function checkin(Request $request)
    {
        $events = Event::where('is_active', 1)->get();

        return view('scanner.checkin', compact('events'));
    }
    public function checkout(Request $request)
    {
        return view('scanner.checkout');
    }

    public function section_select(Request $request)
    {
        request()->validate([
            'id' => ['required', 'numeric']
        ]);

        $event_id = $request->id;
        $event_gate = EventGate::select('type', 'name')
            ->where('event_id', $event_id)
            ->get();

        $ticket = Ticket::where('event_id', $event_id)
            ->get();
        $pending = 0;
        $checkin = 0;
        $total_ticket = 0;
        foreach ($ticket as $key => $value) {
            $total_ticket++;
            if ($value->checkin) {
                $checkin++;
            } else {
                $pending++;
            }
        }
        $data['event_gate'] = $event_gate;
        $data['pending'] = $pending;
        $data['checkin'] = $checkin;
        $data['total_ticket'] = $total_ticket;
        return ResponseFormatter::success($data);
    }

    public function section_selected(Request $request)
    {
        request()->validate([
            'id' => ['required', 'numeric'],
            'type' => ['required', new ExceptSymbol()]
        ]);
        $type = $request->type;
        $ticket = Ticket::where('event_id', $request->id);
        if ($type != 'all_section') :
            $ticket = $ticket->where('ticket_type', $type);
        endif;
        $ticket = $ticket->get();
        $pending = 0;
        $checkin = 0;
        foreach ($ticket as $key => $value) {
            if ($value->checkin) {
                $checkin++;
            } else {
                $pending++;
            }
        }
        $data['pending'] = $pending;
        $data['checkin'] = $checkin;
        return ResponseFormatter::success($data);
    }
}
