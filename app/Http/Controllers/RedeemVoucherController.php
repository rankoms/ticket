<?php

namespace App\Http\Controllers;

use App\Exports\VoucherRedeemExport;
use App\Helpers\ResponseFormatter;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\RedeemHistory;
use App\Models\RedeemVoucher;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RedeemVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $event = $request->event;
        $category = $request->category;
        return view('redeem_voucher', compact('category', 'event'));
    }
    public function choose()
    {
        return view('redeem_voucher_choose');
    }
    public function choose_event_category(Request $request, $type)
    {
        $request->merge(['type' => $type]);
        request()->validate([
            'type' => ['required', 'in:redeem_with_inject,redeem_with_voucher,redeem_only']
        ]);

        if ($request->event && $request->category) {
            $type_route = type_route_array_redeem($request->event, $request->category)[$type];
            return redirect($type_route);
        }

        $event = RedeemVoucher::groupBy('event')->select('event')->orderBy('event')->get();
        return view('redeem_voucher_choose_event_category', compact('event', 'type'));
    }
    public function barcode(Request $request)
    {
        $event = $request->event;
        $category = $request->category;
        return view('redeem_voucher_barcode', compact('category', 'event'));
    }
    public function inject(Request $request)
    {
        $event = $request->event;
        $category = $request->category;

        return view('redeem_voucher_inject', compact('category', 'event'));
    }
    public function checkin_desktop()
    {
        $event = EventCategory::groupBy('event')->select('event')->first()->event;
        $category = 'All Category';
        return view('checkin_desktop', compact('event', 'category'));
    }

    public function index_v2()
    {
        return view('redeem_voucher_v2');
    }

    public function ticket()
    {
        return view('redeem_voucher_ticket');
    }
    public function summary_redeem()
    {
        $redeem_voucher = RedeemVoucher::orderBy('kategory', 'asc')->get();
        $jumlah_belum = 0;
        $jumlah_sudah = 0;
        foreach ($redeem_voucher as $key => $value) :
            if ($value->status == 0) :
                $jumlah_belum++;
                isset($kategory_aset[$value->kategory]['belum']) ? $kategory_aset[$value->kategory]['belum']++ : $kategory_aset[$value->kategory]['belum'] = 1;
            else :
                $jumlah_sudah++;
                isset($kategory_aset[$value->kategory]['sudah']) ? $kategory_aset[$value->kategory]['sudah']++ : $kategory_aset[$value->kategory]['sudah'] = 1;
            endif;
        endforeach;
        return view('summary_redeem', compact('kategory_aset', 'jumlah_belum', 'jumlah_sudah', 'redeem_voucher'));
    }

    public function dashboard_redeem(Request $request)
    {
        $redeem_voucher = RedeemVoucher::orderBy('kategory', 'asc');

        $redeem_not_valid = RedeemHistory::where('is_valid', 0);
        $jumlah_belum = 0;
        $jumlah_sudah = 0;
        $kategory_aset = [];
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $date_range = '';
        if ($start_date && $end_date) {
            $date_range = $start_date . ' s/d ' . $end_date;
        }
        if ($date_range) {
            $redeem_voucher = $redeem_voucher->whereBetween('updated_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
            $redeem_not_valid = $redeem_not_valid->whereBetween('updated_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        }

        $redeem_not_valid = $redeem_not_valid->get()->count();
        $redeem_voucher = $redeem_voucher->get();
        foreach ($redeem_voucher as $key => $value) :
            if ($value->status == 0) :
                $jumlah_belum++;
                isset($kategory_aset[$value->kategory]['belum']) ? $kategory_aset[$value->kategory]['belum']++ : $kategory_aset[$value->kategory]['belum'] = 1;
            else :
                $jumlah_sudah++;
                isset($kategory_aset[$value->kategory]['sudah']) ? $kategory_aset[$value->kategory]['sudah']++ : $kategory_aset[$value->kategory]['sudah'] = 1;
            endif;
        endforeach;
        return view('admin.dashboard_redeem', compact('kategory_aset', 'jumlah_belum', 'jumlah_sudah', 'redeem_voucher', 'redeem_not_valid', 'start_date', 'end_date', 'date_range', 'request'));
    }
    public function dashboard_redeem_list(Request $request)
    {
        $redeem_voucher = RedeemVoucher::orderBy('redeem_date', 'desc');
        $redeem_voucher_success = RedeemVoucher::orderBy('redeem_date', 'desc')->where('status', 1);
        $redeem_voucher_success = $redeem_voucher_success->get();
        $redeem_voucher = $redeem_voucher->get();

        $redeem_not_valid = RedeemHistory::where('is_valid', 0)->get()->count();
        $jumlah_belum = 0;
        $jumlah_sudah = 0;
        $kategory_aset = [];
        foreach ($redeem_voucher as $key => $value) :
            if ($value->status == 0) :
                $jumlah_belum++;
                isset($kategory_aset[$value->kategory]['belum']) ? $kategory_aset[$value->kategory]['belum']++ : $kategory_aset[$value->kategory]['belum'] = 1;
            else :
                $jumlah_sudah++;
                isset($kategory_aset[$value->kategory]['sudah']) ? $kategory_aset[$value->kategory]['sudah']++ : $kategory_aset[$value->kategory]['sudah'] = 1;
            endif;
        endforeach;
        return view('admin.dashboard_redeem_list', compact('kategory_aset', 'jumlah_belum', 'jumlah_sudah', 'redeem_voucher', 'redeem_not_valid', 'redeem_voucher_success'));
    }

    public function cek_redeem_voucher(Request $request)
    {
        $voucher = $request->voucher;
        $category = $request->category;
        $event = $request->event;
        $redeem_voucher = RedeemVoucher::where('kode', $voucher);
        if ($event) {
            $redeem_voucher = $redeem_voucher->where('event', $event);
        }
        if ($category && $category != 'All Category') {
            $redeem_voucher = $redeem_voucher->where('kategory', $category);
        }

        $redeem_voucher = $redeem_voucher->first();

        $redeem_history = new RedeemHistory();
        $redeem_history->redeem_by = Auth::user()->id;
        $redeem_history->kode = $redeem_voucher ? $redeem_voucher->kode : $voucher;
        $redeem_history->is_valid = $redeem_voucher ? 1 : 0;
        $redeem_history->save();
        if (!$redeem_voucher) {
            return ResponseFormatter::error(null, '');
        } else {
            if ($redeem_voucher->status == 1) {
                $redeem_voucher->barcode_image = "" . QrCode::size(110)->generate($redeem_voucher->kode) . "";
                return ResponseFormatter::success($redeem_voucher, 'Data Sudah Digunakan');
            } else {
                $redeem_voucher->barcode_no = $redeem_voucher->kode;
                $redeem_voucher->barcode_image = "" . QrCode::size(110)->generate($redeem_voucher->kode) . "";

                return ResponseFormatter::success($redeem_voucher, 'Data Berhasil ada');
            }
        }
    }

    public function redeem_voucher_update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric']
        ]);

        $redeem_voucher = RedeemVoucher::find($request->id);
        $redeem_voucher->redeem_by = Auth::user()->id;
        $redeem_voucher->redeem_date = date('Y-m-d H:i:s');
        $redeem_voucher->status = 1;
        $redeem_voucher->barcode_no = $request->barcode_no;
        $redeem_voucher->seat_number = $request->seat_number;
        $redeem_voucher->save();


        /*
        START UPDATE SEATING CHAIR
        */
        $request->merge(['kode' => $redeem_voucher->kode, 'seat_number' => $redeem_voucher->seat_number, 'category' => $redeem_voucher->kategory]);
        $seating_chair = new SeatingChairVoucherController();
        $seating_chair = $seating_chair->update_seating($request);
        /* END UPDATE SEATING CHAIR */

        return ResponseFormatter::success($redeem_voucher, 'Redeem E-Ticket Berhasil');
    }

    public function redeem_voucher_update_barcode(Request $request)
    {
        $redeem_voucher_update = $this->redeem_voucher_update($request)->getData()->data;

        return ResponseFormatter::success($redeem_voucher_update, 'Redeem E-Ticket Berhasil');
    }
    public function redeem_voucher_inject_ticket(Request $request)
    {
        $redeem_voucher_update = $this->redeem_voucher_update($request)->getData()->data;
        $request->merge([
            'event' => $redeem_voucher_update->event,
            'name' => $redeem_voucher_update->name,
            'email' => $redeem_voucher_update->email,
            'category' => $redeem_voucher_update->kategory,
            'barcode_no' => $request->barcode_no,
        ]);
        $ticket = new TicketController();
        $ticket = $ticket->store($request);
        return ResponseFormatter::success($redeem_voucher_update, 'Redeem E-Ticket Berhasil');
    }
    public function redeem_voucher_update_ticket(Request $request)
    {
        $barcode_no = $this->generate_barcode();
        $request->merge(['barcode_no' => $barcode_no]);
        $redeem_voucher_update = $this->redeem_voucher_update($request)->getData()->data;


        $ticket = new TicketController();

        $request->merge([
            'event' => $redeem_voucher_update->event,
            'name' => $redeem_voucher_update->name,
            'category' => $redeem_voucher_update->kategory,
            'email' => $redeem_voucher_update->email,


        ]);
        $ticket = $ticket->store($request);
        return ResponseFormatter::success(null, 'Redeem E-Ticket Berhasil');
    }


    public function redeem_voucher_update_v2(Request $request)
    {
        $request->validate([
            'id' => ['required', 'numeric']
        ]);

        $img = $request->image;
        $folderPath = "uploads/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file, $image_base64);

        $redeem_voucher = RedeemVoucher::find($request->id);
        $redeem_voucher->foto_ktp = $fileName;
        $redeem_voucher->redeem_by = Auth::user()->id;
        $redeem_voucher->redeem_date = date('Y-m-d H:i:s');
        $redeem_voucher->status = 1;
        $redeem_voucher->save();

        return ResponseFormatter::success(null, 'Redeem E-Ticket Berhasil');
    }

    public function detail($kode)
    {
        $redeem_voucher = RedeemVoucher::where('kode', $kode)->first();
        if (!$redeem_voucher) {
            return redirect()->route('redeem_voucher.index');
        }

        return view('redeem_detail', compact('redeem_voucher'));
    }

    public function cetak_ticket($id)
    {
        $redeem_voucher = RedeemVoucher::find($id);
        $user_logo = Auth::user() ? Auth::user()->logo : '';
        $logo = '';
        if ($user_logo) {
            $logo = asset('/') . $user_logo;
        }
        if (!$redeem_voucher) {
            return view('404');
        }
        return view('redeem_voucher.cetak_ticket', compact('redeem_voucher', 'logo'));
    }

    public function excel_redeem(Request $request)
    {

        return Excel::download(new VoucherRedeemExport($request), 'Laporan Voucher Redeem ' . date('Y-m-d H_i') . '.xlsx');
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
        if (Ticket::where('barcode_no', $result)->first()) {
            $this->generate_barcode();
        }
        return $result;
    }


    public function category_select(Request $request)
    {
        request()->validate([
            'event' => ['required']
        ]);
        $event = $request->event;

        $category = RedeemVoucher::select('kategory')->where('event', $event)->groupBy('kategory')->get();
        return ResponseFormatter::success($category);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(RedeemVoucher $redeemVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(RedeemVoucher $redeemVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RedeemVoucher $redeemVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RedeemVoucher  $redeemVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(RedeemVoucher $redeemVoucher)
    {
        //
    }
}
