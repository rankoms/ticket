<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\EventCategory;
use App\Models\PosTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        $event = EventCategory::groupBy('event')->select('event')->orderBy('event')->get();
        return view('pos_ticket.index', compact('event'));
    }
    public function name_pt()
    {
        $event = EventCategory::select('event', 'category')->groupBy('event', 'category')->first();
        $event = $event ? $event->event : '';
        return view('pos_ticket.name_pt', compact('event'));
    }

    public function dashboard(Request $request)
    {
        $pos = PosTicket::select('name', 'event', 'category', 'email', DB::raw('count(*) as jumlah_ticket'), 'payment_code')->groupBy('payment_code', 'email', 'name', 'event', 'category')->get();
        return view('pos_ticket.dashboard', compact('pos', 'request'));
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
            'name' => ['required'],
            'email' => ['required'],
            'category' => ['required'],
            'no_telp' => ['required'],
            'quantity' => ['required', 'numeric'],
            'harga_satuan' => ['required'],
        ]);
        $event = $request->event;
        $name = $request->name;
        $email = $request->email;
        $category = $request->category;
        $no_telp = $request->no_telp;
        $quantity = $request->quantity;
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
            $pos_ticket->name = $name;
            $pos_ticket->email = $email;
            $pos_ticket->category = $category;
            $pos_ticket->no_telp = $no_telp;
            $pos_ticket->quantity = $quantity;
            $pos_ticket->harga_satuan = $harga_satuan;
            $pos_ticket->total_harga = $total_harga;
            $pos_ticket->user_id = $user_id;
            $pos_ticket->date = $event_category->date;
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
        $user_id = Auth::user()->id;
        $date = date('Y-m-d');
        $pos_ticket = new PosTicket();
        $pos_ticket->event = $event;
        $pos_ticket->name = $name;
        $pos_ticket->email = '-';
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
