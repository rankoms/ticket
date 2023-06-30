<?php

namespace App\Http\Controllers;

use App\Exports\VoucherRedeemExport;
use App\Helpers\ResponseFormatter;
use App\Models\Event;
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
    public function index()
    {
        return view('redeem_voucher');
    }
    public function choose()
    {
        return view('redeem_voucher_choose');
    }
    public function barcode()
    {
        return view('redeem_voucher_barcode');
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
        $redeem_voucher = RedeemVoucher::orderBy('kategory', 'asc')->get();

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
        return view('admin.dashboard_redeem', compact('kategory_aset', 'jumlah_belum', 'jumlah_sudah', 'redeem_voucher', 'redeem_not_valid'));
    }
    public function dashboard_redeem_list(Request $request)
    {
        $redeem_voucher = RedeemVoucher::orderBy('kategory', 'asc')->get();

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
        return view('admin.dashboard_redeem_list', compact('kategory_aset', 'jumlah_belum', 'jumlah_sudah', 'redeem_voucher', 'redeem_not_valid'));
    }

    public function cek_redeem_voucher(Request $request)
    {
        $voucher = $request->voucher;

        $redeem_voucher = RedeemVoucher::where('kode', $voucher)->first();

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
        $redeem_voucher->save();

        return ResponseFormatter::success($redeem_voucher, 'Redeem E-Ticket Berhasil');
    }

    public function redeem_voucher_update_barcode(Request $request)
    {
        $redeem_voucher_update = $this->redeem_voucher_update($request)->getData()->data;

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
