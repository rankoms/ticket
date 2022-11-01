<?php

namespace App\Http\Controllers;

use App\Models\RedeemVoucher;
use Illuminate\Http\Request;

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
