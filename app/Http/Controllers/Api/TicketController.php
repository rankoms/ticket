<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ScannerController;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function checkin(Request $request)
    {
        request()->validate([
            'barcode_no' => [new ExceptSymbol()],
            'event' => ['required'],
            'category' => ['required'],
        ]);
        $now = date('Y-m-d H:i:s');
        $event = $request->event;
        $category = $request->category;

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->where('event', $event)
            ->where('category', $category)
            ->first();

        if (!isset($ticket)) {
            return ResponseFormatter::error(null, 'This QR Code is Invalid', 400);
        }
        $ticket_history = $this->scan_history($request);
        if ($ticket->is_bypass == 1) {
            return ResponseFormatter::success(null, 'This QR Code is Valid');
        }
        if ($ticket->checkin_count >= $ticket->max_checkin) {
            return ResponseFormatter::error(null, 'This QR Code Already Used');
        }
        if ($ticket->category != $request->category) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }

        if ($ticket->checkin && $ticket->checkin_count > $ticket->max_checkin) {
            return ResponseFormatter::error(null, 'Ticket Sudah Digunakan', 400);
        }
        $ticket->checkin = $now;
        $ticket->checkin_count = $ticket->checkin_count + 1;
        if ($ticket->save()) {
            // $section_selected = $this->count_gate($ticket->event_id, $ticket->category)->getData();
            return ResponseFormatter::success($ticket, 'This QR Code is Valid');
        } else {
            return ResponseFormatter::error(null, 'Terjadi kesalahan');
        }
    }
    private function count_gate($event_id, $type)
    {
        $type = $type;
        $ticket = Ticket::where('event_id', $event_id);
        if ($type != 'all_section') :
            $ticket = $ticket->where('category', $type);
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
    public function checkout(Request $request)
    {
        request()->validate([
            'barcode_no' => [new ExceptSymbol()],
            'event' => ['required'],
            'category' => ['required'],
        ]);
        $now = date('Y-m-d H:i:s');
        $event = $request->event;
        $category = $request->category;

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->where('event', $event)
            ->where('category', $category)
            ->first();
        if (!$ticket) {
            return ResponseFormatter::error(null, 'This QR Code is Invalid', 400);
        }
        $ticket_history = $this->scan_history($request);
        if ($ticket->is_bypass == 1) {
            return ResponseFormatter::success(null, 'Anda Berhasil Checkout');
        }
        if ($ticket->category != $request->category) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }
        $ticket->checkout = $now;
        $ticket->checkin_count = $ticket->checkin_count  > 0 ? $ticket->checkin_count - 1 : $ticket->checkin_count;
        if ($ticket->save()) {
            return ResponseFormatter::success($ticket, 'Anda Berhasil Checkout');
        } else {
            return ResponseFormatter::error(null, 'Terjadi kesalahan');
        }
    }

    public function sync(Request $request)
    {
        $request = $request->json()->all();
        $data = [];
        $rules = [
            '*.barcode_no' => ['required'],
            '*.category' => ['required'],
            '*.event' => ['required'],
            '*.checkin' => ['nullable'],
            '*.checkout' => ['nullable'],
            '*.is_bypass' => ['nullable'],
            '*.max_checkin' => ['nullable'],
            '*.checkin_count' => ['nullable']
        ];

        $validator = Validator::make($request, $rules);

        // dd($request);
        // return $request;
        if ($validator->passes()) {
            $now = date('Y-m-d H:i:s');
            // return $request[0]['barcode_no'];
            foreach ($request as $key => $value) :
                // if (isset($value['barcode_no']) && isset($value['category']) && isset($value['event']) && isset($value['checkin']) && isset($value['checkout']) && isset($value['is_bypass']) && isset($value['max_checkin']) && isset($value['checkin_count'])) :
                $ticket = Ticket::where('barcode_no', $value['barcode_no'])
                    ->where('category', $value['category'])
                    ->where('event', $value['event'])
                    ->first();

                if ($ticket) {
                    $ticket->checkin = $value['checkin'];
                    $ticket->checkout = $value['checkout'];
                    $ticket->is_bypass = $value['is_bypass'];
                    $ticket->max_checkin = $value['max_checkin'];
                    $ticket->checkin_count = $value['checkin_count'];
                    $ticket->save();
                }
            // endif;
            endforeach;
            return $this->ticket();
        } else {
            //TODO Handle your error
            return ResponseFormatter::error(null, $validator->errors()->all(), 400);
        }
    }

    public function scan_history(Request $request)
    {
        $history = new TicketHistory();
        $history->barcode_no = $request->barcode_no;
        $history->scanned_by = Auth::user() ? Auth::user()->id : 1;
        $history->save();
    }

    public function event_category()
    {
        $tickets = Ticket::get();
        $event = [];
        $category = [];
        foreach ($tickets as $key => $value) :
            $category[$value->category]['name'] = $value->category;
            $category[$value->category]['event'] = $value->event;

            $event[$value->event]['name'] = $value->event;

        endforeach;
        $event_final = [];
        foreach ($event as $key => $value) :
            $event_final[] = $value;
        endforeach;

        $category_final = [];
        foreach ($category as $key => $value) :
            $category_final[] = $value;
        endforeach;


        $array = [
            "event" => $event_final,
            "category" => $category_final,
        ];
        return ResponseFormatter::success($array);
    }
    public function ticket()
    {
        $tickets = Ticket::get();
        $ticket = [];
        foreach ($tickets as $key => $value) :

            $ticket[$value->id]['barcode_no'] = $value->barcode_no;
            $ticket[$value->id]['category'] = $value->category;
            $ticket[$value->id]['event'] = $value->event;
            $ticket[$value->id]['max_checkin'] = $value->max_checkin;
            $ticket[$value->id]['checkin_count'] = $value->checkin_count;
            $ticket[$value->id]['is_bypass'] = $value->is_bypass;
            $ticket[$value->id]['checkin'] = $value->checkin;
            $ticket[$value->id]['checkout'] = $value->checkout;
        endforeach;

        $ticket_final = [];
        foreach ($ticket as $key => $value) :
            $ticket_final[] = $value;
        endforeach;

        $array = [
            "ticket" => $ticket_final
        ];
        return ResponseFormatter::success($array);
    }
}
