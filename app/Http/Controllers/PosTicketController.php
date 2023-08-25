<?php

namespace App\Http\Controllers;

use App\Exports\TicketPosExport;
use App\Helpers\ResponseFormatter;
use App\Models\EventCategory;
use App\Models\PosTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PosTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event = EventCategory::select('event')->groupBy('event')->first();
        $event = $event ? $event->event : '';
        $category = EventCategory::groupBy('category', 'harga_satuan')->select('category', 'harga_satuan')->orderBy('category')->get();
        return view('pos_ticket.index', compact('category', 'event'));
    }
    public function name_pt()
    {
        $event = EventCategory::select('event', 'category')->groupBy('event', 'category')->first();
        $event = $event ? $event->event : '';
        return view('pos_ticket.name_pt', compact('event'));
    }

    public function dashboard(Request $request)
    {
        request()->validate([
            'user_id' => ['numeric', 'nullable'],
            'start_date' => ['date_format:Y-m-d', 'nullable'],
            'end_date' => ['date_format:Y-m-d', 'nullable']
        ]);
        $user_id = $request->user_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $pos = PosTicket::with('user')->select('name', 'event', 'category', 'email', 'no_telp', 'payment_code', 'total_harga', 'quantity', 'user_id', 'payment_method', 'date', DB::raw("DATE_TRUNC('minute', created_at) as date_minutes"))->groupBy('payment_code', 'email', 'name', 'event', 'category', 'no_telp', 'total_harga', 'quantity', 'user_id', 'payment_method', 'date', 'date_minutes')->orderBy('date_minutes', 'desc');

        $user = $pos;
        foreach ($user->get() as $key => $value) :
            $data_user[$value->user_id] = $value;
        endforeach;
        if ($user_id) {
            $pos = $pos->where('user_id', $user_id);
        }
        $tanggal = '';
        if ($start_date && $end_date) {
            $tanggal = $start_date . ' s/d ' . $end_date;
            $pos = $pos->whereBetween('date', [$start_date, $end_date]);
        }

        $pos = $pos->get();

        // dd($pos[0]);
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
        return view('pos_ticket.dashboard', compact('pos', 'request', 'total_revenue', 'tiket_sold', 'tiket_sold_day', 'data_user', 'tanggal'));
    }


    public function category_select(Request $request)
    {
        request()->validate([
            'event' => ['required']
        ]);
        $event = $request->event;

        $category = EventCategory::select('category', 'harga_satuan')->where('event', $event)->groupBy('category', 'harga_satuan')->get();
        return ResponseFormatter::success($category);
    }


    public function cetak($id)
    {
        $pos_ticket = PosTicket::where('payment_code', $id)->get();
        $user_logo = Auth::user() ? Auth::user()->logo : '';
        $logo = '';
        if ($user_logo) {
            $logo = asset('/') . $user_logo;
        }
        return view('pos_ticket.cetak', compact('pos_ticket', 'logo'));
    }

    public function cetak_name_pt($id)
    {
        $pos_ticket = PosTicket::where('payment_code', $id)->get();
        $user_logo = Auth::user() ? Auth::user()->logo : '';
        $logo = '';
        if ($user_logo) {
            $logo = asset('/') . $user_logo;
        }
        return view('pos_ticket.cetak_name_pt', compact('pos_ticket', 'logo'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'event' => ['required'],
            'fullname' => ['required'],
            'email' => ['required'],
            'category' => ['required'],
            'phone' => ['required'],
            'quantity' => ['required', 'numeric'],
        ]);
        $event = $request->event;
        $fullname = $request->fullname;
        $email = $request->email;
        $category = $request->category;
        $phone = $request->phone;
        $quantity = $request->quantity;
        $payment_method = $request->payment_method;
        $event_category = EventCategory::where('event', $event)->where('category', $category)->first();
        if (!$event_category) {
            return ResponseFormatter::error(null, __('Not Found !'));
        }
        $harga_satuan = $event_category->harga_satuan;
        $total_harga = $harga_satuan * (int)$quantity;
        $user_id = Auth::user()->id;
        $payment_code = $this->generate_payment();
        for ($i = 0; $i < $quantity; $i++) :
            $pos_ticket = new PosTicket();
            $pos_ticket->event = $event;
            $pos_ticket->name = $fullname;
            $pos_ticket->email = $email;
            $pos_ticket->category = $category;
            $pos_ticket->no_telp = $phone;
            $pos_ticket->quantity = $quantity;
            $pos_ticket->harga_satuan = $harga_satuan;
            $pos_ticket->total_harga = $total_harga;
            $pos_ticket->payment_method = $payment_method;
            $pos_ticket->user_id = $user_id;
            $pos_ticket->date = date('Y-m-d');
            $pos_ticket->vanue = $event_category->vanue;
            $pos_ticket->barcode_no = $this->generate_barcode();
            $pos_ticket->payment_code = $payment_code;
            $pos_ticket->save();

            $ticket = new TicketController();
            $request->merge(['barcode_no' => $pos_ticket->barcode_no]);
            $ticket = $ticket->store($request);
        endfor;
        return ResponseFormatter::success($pos_ticket, __('Success'));
    }
    public function store_name_pt(Request $request)
    {
        $event = $request->event;
        $perusahaan = $request->perusahaan;
        $name = $request->fullname;
        $email = $request->email;
        $industry = $request->industry;
        $title = $request->title;
        if ($industry == 'Other') {
            $industry = $request->industry_other;
        }
        $experience = $request->experience;
        $user_id = Auth::user()->id;
        $date = date('Y-m-d');
        $pos_ticket = new PosTicket();
        $pos_ticket->event = $event;
        $pos_ticket->name = $name;
        $pos_ticket->email = $email;
        $pos_ticket->title = $title;
        $pos_ticket->experience = $experience;
        $pos_ticket->industry = $industry;
        $pos_ticket->no_telp = '-';
        $pos_ticket->vanue = '-';
        $pos_ticket->quantity = 1;
        $pos_ticket->harga_satuan = 1;
        $pos_ticket->total_harga = 1;
        $pos_ticket->barcode_no = 1;
        $pos_ticket->payment_code = $this->generate_payment();
        $pos_ticket->category = $perusahaan;
        $pos_ticket->user_id = $user_id;
        $pos_ticket->date = $date;
        $pos_ticket->save();
        return ResponseFormatter::success($pos_ticket, __('Success'));
    }

    public function generate_barcode($prefix = 'T', $length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // daftar karakter yang diizinkan
        $characters_length = strlen($characters);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, $characters_length - 1)];
        }
        $result = $prefix . $result;
        if (PosTicket::where('barcode_no', $result)->first()) {
            $this->generate_barcode();
        }
        return $result;
    }

    public function generate_payment($prefix = 'P', $length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // daftar karakter yang diizinkan
        $characters_length = strlen($characters);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, $characters_length - 1)];
        }
        $result = $prefix . $result;
        if (PosTicket::where('payment_code', $result)->first()) {
            $this->generate_barcode();
        }
        return $result;
    }


    public function excel_pos(Request $request)
    {
        return Excel::download(new TicketPosExport($request), 'Laporan Ticket POS ' . date('Y-m-d H_i') . '.xlsx');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosTicket  $posTicket
     * @return \Illuminate\Http\Response
     */
    public function show(PosTicket $posTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PosTicket  $posTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(PosTicket $posTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PosTicket  $posTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosTicket $posTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PosTicket  $posTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(PosTicket $posTicket)
    {
        //
    }
}
