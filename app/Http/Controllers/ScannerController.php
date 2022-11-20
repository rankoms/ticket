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
        $event = Ticket::select('event', 'category')->where('category', $request->section)->first();
        if (!$event) {
            return redirect()->route('scanner.pilih_event');
        }
        $events = Ticket::where('category', $request->section)->get();

        $total_pending = 0;
        $total_checkin = 0;
        foreach ($events as $key => $value) :
            if ($value->checkin == null) {
                $total_pending++;
            } else {
                $total_checkin++;
            }
        endforeach;


        return view('scanner.checkin', compact('event', 'total_pending', 'total_checkin'));
    }

    public function pilih_event(Request $request)
    {
        $events = Ticket::select('event')->groupBy('event')->get();
        return view('scanner.pilih_event', compact('events'));
    }
    public function store_pilih_event(Request $request)
    {
        if ($request->gate == 'checkin') {
            return redirect()->route('scanner.checkin', ['section' => $request->section]);
        } else {
            return redirect()->route('scanner.checkout', ['section' => $request->section]);
        }
    }
    public function checkout(Request $request)
    {
        $event = Ticket::select('event', 'category')->where('category', $request->section)->first();
        if (!$event) {
            return redirect()->route('scanner.pilih_event');
        }
        $events = Ticket::where('category', $request->section)->get();

        $total_checkin = 0;
        $total_checkout = 0;
        foreach ($events as $key => $value) :
            if ($value->checkin && $value->checkout == null) {
                $total_checkin++;
            }

            if ($value->checkout) {
                $total_checkout++;
            }
        endforeach;


        return view('scanner.checkout', compact('event', 'total_checkin', 'total_checkout'));
    }

    public function section_select(Request $request)
    {
        request()->validate([
            'event' => ['required']
        ]);

        $event = $request->event;
        $category = Ticket::select('category')->where('event', $event)->groupBy('category')->get();

        $ticket = Ticket::where('event', $event)
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
        $data['event_gate'] = $category;
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
