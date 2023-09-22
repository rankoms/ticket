<?php

namespace App\Http\Controllers;

use App\Exports\TicketCurrentExport;
use App\Exports\TicketExport;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ScannerController;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{

    public function dashboard_ticket(Request $request)
    {
        $ticket = $this->get_ticket($request)['ticket'];
        $ticket_not_valid = $this->get_ticket($request)['ticket_not_valid'];
        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        $jumlah_pending = $this->ticket($ticket)['jumlah_pending'];
        $jumlah_checkin = $this->ticket($ticket)['jumlah_checkin'];
        $jumlah_checkout = $this->ticket($ticket)['jumlah_checkout'];
        $kategory_aset = $this->ticket($ticket)['kategory_aset'];
        $jenis_tiket = $this->ticket($ticket)['jenis_tiket'];
        $gate_aset = $this->ticket($ticket)['gate_aset'];

        // dd($gate_aset);
        $ticket_history = TicketHistory::select(DB::raw('count(id) as jumlah'), DB::raw("date_part('hour', created_at) as hour"))->groupBy(DB::raw("date_part('hour', created_at)"))->orderBy('hour', 'asc')->get();
        $data_ticket_history = '';
        $label_ticket_history = '';

        foreach ($ticket_history as $key => $value) :
            $data_ticket_history .= $value->jumlah . ',';
            $label_ticket_history .= '"' . $value->hour . '",';
        endforeach;
        $data_ticket_history = substr($data_ticket_history, 0, -1);
        $label_ticket_history = substr($label_ticket_history, 0, -1);

        $tanggal = format_hari_tanggal(date('Y-m-d H:i:s'));

        return view('admin.dashboard_ticket', compact('kategory_aset', 'jumlah_pending', 'jumlah_checkin', 'jumlah_checkout', 'ticket', 'event', 'request', 'ticket_not_valid', 'data_ticket_history', 'label_ticket_history', 'tanggal', 'gate_aset', 'jenis_tiket'));
    }

    public function dashboard_ticket_current(Request $request)
    {
        $percent_report_current = config('scanner.percent_report_current');
        $is_current = true;
        $ticket = $this->get_ticket($request)['ticket'];
        $ticket_not_valid = $this->get_ticket($request)['ticket_not_valid'];
        /* START JUMLAH VARIABLE TICKET */
        $jumlah_ticket = count($ticket);
        $max_ticket = $jumlah_ticket * $percent_report_current / 100;
        // dd((int) floor($max_ticket));
        /* START JUMLAH VARIABLE TICKET */

        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        $jumlah_pending = $this->ticket($ticket)['jumlah_pending'];
        $jumlah_checkin = $this->ticket($ticket)['jumlah_checkin'];
        $jumlah_checkout = $this->ticket($ticket)['jumlah_checkout'];
        $kategory_aset = $this->ticket($ticket)['kategory_aset'];
        $jenis_tiket = $this->ticket($ticket)['jenis_tiket'];
        $gate_aset = $this->ticket($ticket)['gate_aset'];


        $ticket_history = TicketHistory::select(DB::raw('count(id) as jumlah'), DB::raw("date_part('hour', created_at) as hour"))->groupBy(DB::raw("date_part('hour', created_at)"))->orderBy('hour', 'asc')->get();
        $data_ticket_history = '';
        $label_ticket_history = '';

        /* START JUMLAH VARIABLE TICKET */
        $jumlah_ticket_history = count($ticket_history);
        $max_ticket_history = $jumlah_ticket_history * $percent_report_current / 100;
        /* START JUMLAH VARIABLE TICKET */
        foreach ($ticket_history as $key => $value) :
            if ($key >= $max_ticket_history) {
                break;
            }
            $data_ticket_history .= $value->jumlah . ',';
            $label_ticket_history .= '"' . $value->hour . '",';
        endforeach;
        $data_ticket_history = substr($data_ticket_history, 0, -1);
        $label_ticket_history = substr($label_ticket_history, 0, -1);

        $tanggal = format_hari_tanggal(date('Y-m-d H:i:s'));

        $kategory_aset = $this->current_kategori_aset($kategory_aset, $percent_report_current);
        $gate_aset = $this->current_gate_aset($gate_aset, $percent_report_current);
        $jenis_tiket = $this->current_jenis_tiket($jenis_tiket, $percent_report_current);

        $jumlah_pending = (int) floor($jumlah_pending * $percent_report_current / 100);
        $jumlah_checkin = (int) floor($jumlah_checkin * $percent_report_current / 100);
        $jumlah_checkout = (int) floor($jumlah_checkout * $percent_report_current / 100);

        return view('admin.dashboard_ticket', compact('kategory_aset', 'jumlah_pending', 'jumlah_checkin', 'jumlah_checkout', 'ticket', 'event', 'request', 'ticket_not_valid', 'data_ticket_history', 'label_ticket_history', 'tanggal', 'is_current', 'gate_aset', 'jenis_tiket', 'percent_report_current'));
    }

    public function table_kategori_aset(Request $request)
    {

        $ticket = $this->get_ticket($request)['ticket'];
        $kategory_aset = (array) $this->ticket($ticket)['kategory_aset'];
        $json_data = array(
            "draw"            => intval($request->draw),
            // "recordsTotal"    => intval($dataCount->count()),
            // "recordsFiltered" => intval($dataCount->count()),
            "data"            => json_encode($kategory_aset)
        );

        return $json_data;
    }
    private function get_ticket($request)
    {

        $ticket = Ticket::orderBy('category', 'asc');
        $ticket_not_valid = 0;
        if ($request->event) {
            $ticket = $ticket->where('event', $request->event);
            $ticket_not_valid = TicketHistory::where('event', $request->event)->where('is_valid', 0)->get();
            $ticket_not_valid = count($ticket_not_valid);
        }
        $ticket = $ticket->get();
        return ['ticket' => $ticket, 'ticket_not_valid' => $ticket_not_valid];
    }

    private function ticket($ticket)
    {
        $jumlah_pending = 0;
        $jumlah_checkin = 0;
        $jumlah_checkout = 0;
        $kategory_aset = [];
        $jenis_tiket = [];
        $gate_aset = [];
        foreach ($ticket as $key => $value) :
            if ($value->checkin == null && $value->checkout == null) :
                $jumlah_pending++;
                isset($kategory_aset[$value->category]['pending']) ? $kategory_aset[$value->category]['pending']++ : $kategory_aset[$value->category]['pending'] = 1;
                isset($jenis_tiket[$value->jenis_tiket]['pending']) ? $jenis_tiket[$value->jenis_tiket]['pending']++ : $jenis_tiket[$value->jenis_tiket]['pending'] = 1;
            endif;
            if ($value->checkin && $value->checkout == null) :
                $jumlah_checkin++;
                isset($kategory_aset[$value->category]['checkin']) ? $kategory_aset[$value->category]['checkin']++ : $kategory_aset[$value->category]['checkin'] = 1;
                isset($jenis_tiket[$value->jenis_tiket]['checkin']) ? $jenis_tiket[$value->jenis_tiket]['checkin']++ : $jenis_tiket[$value->jenis_tiket]['checkin'] = 1;
                isset($gate_aset[$value->gate_pintu_checkin]['checkin']) ? $gate_aset[$value->gate_pintu_checkin]['checkin']++ : $gate_aset[$value->gate_pintu_checkin]['checkin'] = 1;
            endif;
            if ($value->checkout) :
                $jumlah_checkout++;
                isset($kategory_aset[$value->category]['checkout']) ? $kategory_aset[$value->category]['checkout']++ : $kategory_aset[$value->category]['checkout'] = 1;
                isset($jenis_tiket[$value->jenis_tiket]['checkout']) ? $jenis_tiket[$value->jenis_tiket]['checkout']++ : $jenis_tiket[$value->jenis_tiket]['checkout'] = 1;
                isset($gate_aset[$value->gate_pintu_checkout]['checkout']) ? $gate_aset[$value->gate_pintu_checkout]['checkout']++ : $gate_aset[$value->gate_pintu_checkout]['checkout'] = 1;
            endif;
        endforeach;
        return [
            'jumlah_pending' => $jumlah_pending,
            'jumlah_checkin' => $jumlah_checkin,
            'jumlah_checkout' => $jumlah_checkout,
            'kategory_aset' => $kategory_aset,
            'jenis_tiket' => $jenis_tiket,
            'gate_aset' => $gate_aset
        ];
    }

    private function current_kategori_aset($kategory_aset2, $percent_report_current)
    {
        foreach ($kategory_aset2 as $key => $value) :
            $hasil['pending'] = isset($value['pending']) ? (int) floor($value['pending'] * $percent_report_current / 100) : 0;
            $hasil['checkin'] = isset($value['checkin']) ? (int) floor($value['checkin'] * $percent_report_current / 100) : 0;
            $hasil['checkout'] = isset($value['checkout']) ? (int) floor($value['checkout'] * $percent_report_current / 100) : 0;
            $kategory_aset[$key] = $hasil;
        endforeach;
        return $kategory_aset;
    }

    private function current_gate_aset($gate_aset2, $percent_report_current)
    {
        foreach ($gate_aset2 as $key => $value) :
            $hasil['checkin'] = isset($value['checkin']) ? (int) floor($value['checkin'] * $percent_report_current / 100) : 0;
            $hasil['checkout'] = isset($value['checkout']) ? (int) floor($value['checkout'] * $percent_report_current / 100) : 0;
            $gate_aset[$key] = $hasil;
        endforeach;
        return $gate_aset;
    }

    private function current_jenis_tiket($jenis_tiket2, $percent_report_current)
    {
        foreach ($jenis_tiket2 as $key => $value) :

            $hasil['pending'] = isset($value['pending']) ? (int) floor($value['pending'] * $percent_report_current / 100) : 0;
            $hasil['checkin'] = isset($value['checkin']) ? (int) floor($value['checkin'] * $percent_report_current / 100) : 0;
            $hasil['checkout'] = isset($value['checkout']) ? (int) floor($value['checkout'] * $percent_report_current / 100) : 0;

            $jenis_tiket[$key] = $hasil;
        endforeach;
        return $jenis_tiket;
    }

    public function post_dashboard_ticket(Request $request)
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
        $jumlah_pending = $this->ticket($ticket)['jumlah_pending'];
        $jumlah_checkin = $this->ticket($ticket)['jumlah_checkin'];
        $jumlah_checkout = $this->ticket($ticket)['jumlah_checkout'];
        $kategory_aset = $this->ticket($ticket)['kategory_aset'];
        $jenis_tiket = $this->ticket($ticket)['jenis_tiket'];
        $gate_aset = $this->ticket($ticket)['gate_aset'];
        $ticket_history = TicketHistory::select(DB::raw('count(id) as jumlah'), DB::raw("date_part('hour', created_at) as hour"))->groupBy(DB::raw("date_part('hour', created_at)"))->orderBy('hour', 'asc')->get();
        $data_ticket_history = [];
        $label_ticket_history = [];

        foreach ($ticket_history as $key => $value) :
            array_push($data_ticket_history, $value->jumlah);
            array_push($label_ticket_history, $value->hour);
        endforeach;
        $tanggal = format_hari_tanggal(date('Y-m-d H:i:s'));
        $percent_report_current = $request->percent_report_current;
        if ($percent_report_current) {

            $kategory_aset = $this->current_kategori_aset($kategory_aset, $percent_report_current);
            $gate_aset = $this->current_gate_aset($gate_aset, $percent_report_current);
            $jenis_tiket = $this->current_jenis_tiket($jenis_tiket, $percent_report_current);

            $jumlah_pending = (int) floor($jumlah_pending * $percent_report_current / 100);
            $jumlah_checkin = (int) floor($jumlah_checkin * $percent_report_current / 100);
            $jumlah_checkout = (int) floor($jumlah_checkout * $percent_report_current / 100);
        }

        $data_return['jumlah_pending'] = $jumlah_pending;
        $data_return['jumlah_checkin'] = $jumlah_checkin;
        $data_return['jumlah_checkout'] = $jumlah_checkout;
        $data_return['tanggal'] = $tanggal;
        $data_return['label_ticket_history'] = $label_ticket_history;
        $data_return['data_ticket_history'] = $data_ticket_history;
        return ResponseFormatter::success($data_return);
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

        return Excel::download(new TicketExport($request), 'Laporan Ticket ' . date('Y-m-d H_i') . '.xlsx');
    }
    public function excel_ticket_current(Request $request)
    {

        return Excel::download(new TicketCurrentExport($request), 'Laporan Ticket Current' . date('Y-m-d H_i') . '.xlsx');
    }

    public function store(Request $request)
    {
        $event = $request->event;
        $name = $request->name;
        $email = $request->email;
        $category = $request->category;
        $barcode_no = $request->barcode_no;
        $ticket = new Ticket();
        $ticket->event = $event;
        $ticket->name = $name;
        $ticket->email = $email;
        $ticket->category = $category;
        $ticket->barcode_no = $barcode_no;
        $ticket->save();
        return ResponseFormatter::success($ticket);
    }
}
