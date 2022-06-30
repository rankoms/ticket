<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ScannerController;
use App\Models\Ticket;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function checkin(Request $request)
    {
        request()->validate([
            'ticket_type' => [new ExceptSymbol()],
            'barcode_no' => [new ExceptSymbol()],
            'gate' => ['required', 'in:checkin,checkout']
        ]);
        $now = date('Y-m-d H:i:s');
        $gate = $request->gate;

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->first();
        if (!$ticket) {
            return ResponseFormatter::error(null, 'Ticket Not Found', 400);
        }
        if ($ticket->ticket_type != $request->ticket_type) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }

        $ticket->checkout = $gate == 'checkout' ? $now : null;
        if ($ticket->checkin && $gate == 'checkin') {
            return ResponseFormatter::error(null, 'Ticket Sudah Digunakan', 400);
        }
        $ticket->checkin = $gate == 'checkin' ? $now : null;



        if ($ticket->save()) {
            $section_selected = $this->count_gate($ticket->event_id, $ticket->ticket_type)->getData();
            return ResponseFormatter::success($section_selected->data, 'Anda Boleh Masuk');
        } else {
            return ResponseFormatter::error(null, 'Terjadi kesalahan');
        }
    }
    private function count_gate($event_id, $type)
    {
        $type = $type;
        $ticket = Ticket::where('event_id', $event_id);
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
    public function checkout(Request $request)
    {
        request()->validate([
            'ticket_type' => [new ExceptSymbol()],
            'barcode_no' => [new ExceptSymbol()]
        ]);
        $now = date('Y-m-d H:i:s');

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->first();
        if (!$ticket) {
            return ResponseFormatter::error(null, 'Ticket Not Found', 400);
        }
        if ($ticket->ticket_type != $request->ticket_type) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }
        if ($ticket->checkout) {
            if ($ticket->save()) {
                return ResponseFormatter::success(null, 'Anda Boleh Masuk');
            } else {
                return ResponseFormatter::error(null, 'Terjadi kesalahan');
            }
        }
        $ticket->checkout = $now;
        if ($ticket->save()) {
            return ResponseFormatter::success(null, 'Anda Berhasil Checkout');
        } else {
            return ResponseFormatter::error(null, 'Terjadi kesalahan');
        }
    }

    public function checkin_bulk(Request $request)
    {
        $request = $request->json()->all();
        $data = [];
        $rules = [
            'barcode_no' => ['required'],
            'ticket_type' => ['required']
        ];

        $validator = Validator::make($request, $rules);

        if ($validator->passes()) {
            $now = date('Y-m-d H:i:s');

            $ticket = Ticket::where('barcode_no', $request['barcode_no'])
                ->first();
            if (!$ticket) {
                return ResponseFormatter::error(null, 'Ticket Not Found', 400);
            }
            if ($ticket->ticket_type != $request['ticket_type']) {
                return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
            }
            if ($ticket->checkout) {
                $ticket->checkin = $now;
                if ($ticket->save()) {
                    return ResponseFormatter::success(null, 'Anda Boleh Masuk');
                } else {
                    return ResponseFormatter::error(null, 'Terjadi kesalahan');
                }
            }
            if ($ticket->checkin) {
                return ResponseFormatter::error(null, 'Ticket Sudah Digunakan', 400);
            }

            $ticket->checkin = $now;
            if ($ticket->save()) {
                return ResponseFormatter::success(null, 'Anda Boleh Masuk');
            }
        } else {
            //TODO Handle your error
            return ResponseFormatter::error(null, $validator->errors()->all(), 400);
        }
    }
}
