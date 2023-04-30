<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Pos;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        return view('pos.index', compact('event'));
    }
    public function cetak($id)
    {
        $pos = Pos::find($id);
        $user_logo = Auth::user() ? Auth::user()->logo : '';
        $logo = '';
        if ($user_logo) {
            $logo = asset('/') . $user_logo;
        }
        return view('pos.cetak', compact('pos', 'logo'));
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
        request()->validate([
            'name' => ['required']
        ]);

        $event = $request->event;
        $name = $request->name;
        $email = $request->email;
        $category = $request->category;
        $club = $request->club;
        $jenis_kelamin = $request->jenis_kelamin;
        $golongan_darah = $request->golongan_darah;
        $no_hp = $request->no_hp;
        $alamat = $request->alamat;
        $type_motor = $request->type_motor;
        $pos = new Pos();
        $pos->event = $event;
        $pos->name = $name;
        $pos->email = $email;
        $pos->category = $category;
        $pos->jenis_kelamin = $jenis_kelamin;
        $pos->golongan_darah = $golongan_darah;
        $pos->no_hp = $no_hp;
        $pos->alamat = $alamat;
        $pos->type_motor = $type_motor;
        $pos->club = $club;
        $pos->user_id = Auth::user() ? Auth::user()->id : null;
        $pos->save();
        $pos->barcode_no = $this->generate_barcode($pos->id);
        $pos->undian = $pos->barcode_no;
        $pos->save();
        $ticket = new TicketController();
        $request->merge(['barcode_no' => $pos->barcode_no]);
        $ticket = $ticket->store($request);
        return ResponseFormatter::success($pos, 'Berhasil di input');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function show(Pos $pos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pos $pos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pos $pos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pos  $pos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pos $pos)
    {
        //
    }

    public function generate_barcode($id, $prefix = 'OTS', $digit = 8)
    {
        $init_awal_id = 1500;
        $id = $init_awal_id + $id;
        $len_prefix = strlen($prefix);
        $len_id = strlen($id);
        $barcode = $prefix;
        for ($i = 0; $i < $digit - $len_prefix - $len_id; $i++) {
            $barcode .= '0';
        }
        $barcode .= $id;


        return $barcode;
    }
}
