<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ScannerController;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{

    public function dashboard_ticket(Request $request)
    {
        $ticket = Ticket::orderBy('category', 'asc');
        $ticket_not_valid = 0;
        if ($request->event) {
            $ticket = $ticket->where('event', $request->event);
            $ticket_not_valid = TicketHistory::where('event', $request->event)->where('is_valid', 0)->get();
            $ticket_not_valid = count($ticket_not_valid);
        }
        $ticket = $ticket->get();
        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        $jumlah_pending = 0;
        $jumlah_checkin = 0;
        $jumlah_checkout = 0;
        $kategory_aset = [];
        foreach ($ticket as $key => $value) :
            if ($value->checkin == null && $value->checkout == null) :
                $jumlah_pending++;
                isset($kategory_aset[$value->category]['pending']) ? $kategory_aset[$value->category]['pending']++ : $kategory_aset[$value->category]['pending'] = 1;
            endif;
            if ($value->checkin && $value->checkout == null) :
                $jumlah_checkin++;
                isset($kategory_aset[$value->category]['checkin']) ? $kategory_aset[$value->category]['checkin']++ : $kategory_aset[$value->category]['checkin'] = 1;
            endif;
            if ($value->checkout) :
                $jumlah_checkout++;
                isset($kategory_aset[$value->category]['checkout']) ? $kategory_aset[$value->category]['checkout']++ : $kategory_aset[$value->category]['checkout'] = 1;
            endif;
        endforeach;
        return view('admin.dashboard_ticket', compact('kategory_aset', 'jumlah_pending', 'jumlah_checkin', 'jumlah_checkout', 'ticket', 'event', 'request', 'ticket_not_valid'));
    }

    public function checkin(Request $request)
    {
        request()->validate([
            'category' => [new ExceptSymbol()],
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
        if ($ticket->category != $request->category) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }

        if ($ticket->checkin && $gate == 'checkin' && $ticket->checkout == null) {
            return ResponseFormatter::error(null, 'Ticket Sudah Digunakan', 400);
        }
        $ticket->checkout = $gate == 'checkout' ? $now : null;
        $ticket->checkin = $gate == 'checkin' ? $now : $ticket->checkin;



        if ($ticket->save()) {
            $section_selected = $this->count_gate($ticket->event_id, $ticket->category)->getData();
            if ($gate == 'checkin') :
                return ResponseFormatter::success($section_selected->data, $ticket->name ? $ticket->name . ' Boleh Masuk' : 'Pengunjung' . ' Boleh Masuk');
            else :
                return ResponseFormatter::success($section_selected->data, $ticket->name ? $ticket->name . ' Boleh Checkout' : 'Pengunjung' . ' Boleh Checkout');
            endif;
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
            'category' => [new ExceptSymbol()],
            'barcode_no' => [new ExceptSymbol()]
        ]);
        $now = date('Y-m-d H:i:s');

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->first();
        if (!$ticket) {
            return ResponseFormatter::error(null, 'Ticket Not Found', 400);
        }
        if ($ticket->category != $request->category) {
            return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        }
        if ($ticket->checkout) {
            if ($ticket->save()) {
                return ResponseFormatter::success(null, $ticket->name ? $ticket->name . ' Boleh Checkout' : 'Pengunjung' . ' Boleh Checkout');
            } else {
                return ResponseFormatter::error(null, 'Terjadi kesalahan');
            }
        }
        $ticket->checkout = $now;
        if ($ticket->save()) {
            return ResponseFormatter::success(null, $ticket->name ? $ticket->name . ' Berhasil Checkout' : 'Pengunjung' . ' Berhasil Checkout');
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
            'category' => ['required']
        ];

        $validator = Validator::make($request, $rules);

        if ($validator->passes()) {
            $now = date('Y-m-d H:i:s');

            $ticket = Ticket::where('barcode_no', $request['barcode_no'])
                ->first();
            if (!$ticket) {
                return ResponseFormatter::error(null, 'Ticket Not Found', 400);
            }
            if ($ticket->category != $request['category']) {
                return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
            }
            if ($ticket->checkout) {
                $ticket->checkin = $now;
                if ($ticket->save()) {
                    return ResponseFormatter::success(null, $ticket->name ? $ticket->name . ' Boleh Masuk' : 'Pengunjung' . ' Boleh Masuk');
                } else {
                    return ResponseFormatter::error(null, 'Terjadi kesalahan');
                }
            }
            if ($ticket->checkin) {
                return ResponseFormatter::error(null, 'Ticket Sudah Digunakan', 400);
            }

            $ticket->checkin = $now;
            if ($ticket->save()) {
                return ResponseFormatter::success(null, $ticket->name ? $ticket->name . ' Boleh Masuk' : 'Pengunjung' . ' Boleh Masuk');
            }
        } else {
            //TODO Handle your error
            return ResponseFormatter::error(null, $validator->errors()->all(), 400);
        }
    }

    public function excel_ticket(Request $request)
    {

        return Excel::download(new TicketExport($request), 'Laporan Ticket ' . date('Y-m-d H:i') . ' .xlsx');
    }
}
