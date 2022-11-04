<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\RedeemVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function cek_redeem_voucher(Request $request)
    {
        $voucher = $request->voucher;

        $redeem_voucher = RedeemVoucher::where('kode', $voucher)->first();
        if (!$redeem_voucher) {
            return ResponseFormatter::error(null, 'Kode tidak ditemukan');
        } else {
            if ($redeem_voucher->status == 1) {
                return ResponseFormatter::success($redeem_voucher, 'Data Sudah Digunakan');
            } else {
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
        $redeem_voucher->save();
        return ResponseFormatter::success(null, 'Berhasil di update');
    }

    public function detail($kode)
    {
        $redeem_voucher = RedeemVoucher::where('kode', $kode)->first();
        if (!$redeem_voucher) {
            return redirect()->route('redeem_voucher.index');
        }

        return view('redeem_detail', compact('redeem_voucher'));
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
