<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ScannerController;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $request->merge(['gate' => 'Check In']);
        $now = date('Y-m-d H:i:s');
        $event = $request->event;
        $category = $request->category;

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->where('event', $event);
        if ($category != 'All Category') :
            $ticket = $ticket->where('category', $category);
        endif;
        $ticket = $ticket->first();

        $ticket_history = $this->scan_history($request, $ticket);
        if (!isset($ticket)) {
            return ResponseFormatter::error(null, 'This QR Code is Invalid', 400);
        }
        if ($ticket->is_bypass == 1) {
            return ResponseFormatter::success($ticket, 'This QR Code is Valid');
        }
        if ($ticket->checkin_count >= $ticket->max_checkin) {
            return ResponseFormatter::error($ticket, 'This QR Code Already Used');
        }
        if ($ticket->category != $request->category && $category != 'All Category') {
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
        $request->merge(['gate' => 'Check Out']);
        $now = date('Y-m-d H:i:s');
        $event = $request->event;
        $category = $request->category;

        $ticket = Ticket::where('barcode_no', $request->barcode_no)
            ->where('event', $event);
        // if ($ticket != 'All Category') :
        //     $ticket = $ticket->where('category', $category);
        // endif;
        $ticket = $ticket->first();
        $ticket_history = $this->scan_history($request, $ticket);
        if (!$ticket) {
            return ResponseFormatter::error(null, 'This QR Code is Invalid', 400);
        }
        if ($ticket->is_bypass == 1) {
            return ResponseFormatter::success($ticket, 'Anda Berhasil Checkout');
        }
        // if ($ticket->category != $request->category) {
        //     return ResponseFormatter::error(null, 'Ticket Salah Pintu', 400);
        // }
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
        $rules = [];
        // $rules = [
        //     'tickets.*.barcode_no' => ['required'],
        //     'tickets.*.category' => ['required'],
        //     'tickets.*.event' => ['required'],
        //     'tickets.*.checkin' => ['nullable'],
        //     'tickets.*.checkout' => ['nullable'],
        //     'tickets.*.is_bypass' => ['nullable'],
        //     'tickets.*.max_checkin' => ['nullable'],
        //     'tickets.*.checkin_count' => ['nullable'],
        //     'ticket_histories.*.barcode_no' => ['required'],
        //     'ticket_histories.*.scanned_by' => ['required'],
        //     'ticket_histories.*.event' => ['required'],
        //     'ticket_histories.*.category' => ['required'],
        //     'ticket_histories.*.gate' => ['required'],
        //     'ticket_histories.*.status' => ['required'],
        //     'ticket_histories.*.created_at' => ['required'],
        // ];

        $validator = Validator::make($request, $rules);

        // return (count($request['tickets']));

        if ($validator->passes()) {
            $now = date('Y-m-d H:i:s');

            $chunkSize = 1000; // jumlah rekaman yang diproses dalam satu waktu
            $totalData = count($request['tickets']); // jumlah total data yang akan disinkronkan
            $pageCount = ceil($totalData / $chunkSize); // jumlah halaman yang dibutuhkan untuk memproses seluruh data
            $offset = 0;
            $data_offset = [];
            for ($i = 0; $i <= $pageCount; $i++) {
                $data = DB::table('tickets')->offset($offset)->limit($chunkSize)->orderBy('id', 'asc')->get(); // ambil data dengan offset dan limit
                // lakukan proses sinkronisasi pada data saat ini


                array_push($data_offset, $data);
                $offset = ($i + 1) * $chunkSize; // hitung offset untuk halaman saat ini
            }
            $i = 0;
            foreach ($data_offset as $data) :
                foreach ($data as $row) {
                    if (isset($request['tickets'][$i])) {
                        if ($request['tickets'][$i]['status'] == true) :
                            $ticket = Ticket::where('barcode_no', strval($request['tickets'][$i]['barcode_no']))
                                ->where('category', trim($request['tickets'][$i]['category']))
                                ->where('event', trim($request['tickets'][$i]['event']))
                                // ->where('status', 1)
                                ->first(); // temukan model dengan id yang cocok


                            if ($ticket) {
                                $ticket->checkin = $request['tickets'][$i]['checkin'];
                                $ticket->checkout = $request['tickets'][$i]['checkout'];
                                $ticket->is_bypass = $request['tickets'][$i]['is_bypass'];
                                $ticket->max_checkin = $request['tickets'][$i]['max_checkin'];
                                $ticket->checkin_count = $request['tickets'][$i]['checkin_count'];
                                $ticket->status = false;
                                $ticket->save();
                            }
                        endif;
                    }
                    $i++;
                }
            endforeach;

            if (isset($request['ticket_histories'])) :
                foreach ($request['ticket_histories'] as $key => $value) :
                    $ticket_history = new TicketHistory();
                    $ticket_history->barcode_no = $value['barcode_no'];
                    $ticket_history->scanned_by = $value['scanned_by'];
                    $ticket_history->event = $value['event'];
                    $ticket_history->category = $value['category'];
                    $ticket_history->gate = $value['gate'];
                    $ticket_history->is_valid = $value['is_valid'];
                    $ticket_history->created_at = $value['created_at'];
                    $ticket_history->save();
                endforeach;
            endif;
            return $this->ticket();
        } else {
            //TODO Handle your error
            return ResponseFormatter::error(null, $validator->errors()->all(), 400);
        }
    }

    public function scan_history(Request $request, $ticket)
    {
        $history = new TicketHistory();
        $history->barcode_no = $request->barcode_no;
        $history->scanned_by = Auth::user() ? Auth::user()->id : 1;
        $history->is_valid = $ticket ? 1 : 0;
        $history->event = $request->event;
        $history->category = $request->category;
        $history->gate = $request->gate;
        $history->status = $request->status;
        $history->save();
    }

    public function event_category()
    {
        $tickets = Ticket::orderBy('id', 'asc')->get();
        $event = [];
        $category = [];
        foreach ($tickets as $key => $value) :
            $category[$value->category][$value->event]['name'] = $value->category;
            $category[$value->category][$value->event]['event'] = $value->event;

            $event[$value->event]['name'] = $value->event;

        endforeach;
        // return $category;
        $event_final = [];
        $category_final = [];
        foreach ($event as $key => $value) :
            $event_final[] = $value;
            $category_final[] = ['name' => 'All Category', 'event' => $value['name']];
        endforeach;

        foreach ($category as $key => $value) :
            foreach ($value as $key2 => $value2) :
                $category_final[] = $value2;
            endforeach;
        endforeach;


        $array = [
            "event" => $event_final,
            "category" => $category_final,
        ];
        return ResponseFormatter::success($array);
    }
    public function ticket()
    {
        $ticket = [];
        $data = DB::table('tickets')->orderBy('id')->chunk(1000, function ($rows) use (&$response) {
            foreach ($rows as $row) {
                $response[] = $row;
            }
        });
        $array = [
            "ticket" => $response
        ];
        return ResponseFormatter::success($array);

        // $tickets = DB::table('tickets')->orderBy('id')->chunk(1000, function ($rows) use ($ticket) {
        //     return $rows;
        //     foreach ($rows as $key => $value) {
        //         $ticket[$value->id]['barcode_no'] = $value->barcode_no;
        //         $ticket[$value->id]['name'] = $value->name;
        //         $ticket[$value->id]['category'] = $value->category;
        //         $ticket[$value->id]['event'] = $value->event;
        //         $ticket[$value->id]['max_checkin'] = $value->max_checkin;
        //         $ticket[$value->id]['checkin_count'] = $value->checkin_count;
        //         $ticket[$value->id]['is_bypass'] = $value->is_bypass;
        //         $ticket[$value->id]['checkin'] = $value->checkin;
        //         $ticket[$value->id]['checkout'] = $value->checkout;
        //     }
        // });


        // $ticket_final = [];
        // foreach ($ticket as $key => $value) :
        //     $ticket_final[] = $value;
        // endforeach;

    }

    public function logo(Request $request)
    {
        request()->validate([
            'user_id' => ['numeric', 'required']
        ]);
        // $logo = asset('/') . \config('logo.logo');
        // $logo = Ticket::groupBy('event', 'logo')->select('event', DB::raw("CONCAT('" . asset('/') . "',logo) AS logo"))->orderBy('event')->get();
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $logo = '';
        if ($user) {
            $logo = asset('/') . $user->logo;
        }

        return ResponseFormatter::success($logo);
    }

    public function dashboard_ticket(Request $request)
    {

        $ticket = Ticket::orderBy('category', 'asc');
        $event_name = $request->event;
        if ($request->event) {
            $ticket = $ticket->where('event', $request->event);
        } else {
            $event_name = 'All Event';
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
        $data = ['event' => $event_name, 'jumlah_checkin' => $jumlah_checkin, 'jumlah_checkout' => $jumlah_checkout, 'jumlah_pending' => $jumlah_pending];
        return ResponseFormatter::success($data);
    }
}
