<?php

namespace App\Exports;

use App\Models\HRDepartment;
use App\Models\MasterKontrak;
use App\Models\ProductUser;
use App\Models\RedeemHistory;
use App\Models\RedeemVoucher;
use App\Models\Ticket;
use App\Models\TicketHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class VoucherRedeemExport implements FromView
{
    use Exportable;
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $date_range = '';
        if ($start_date && $end_date) {
            $date_range = $start_date . ' s/d ' . $end_date;
        }
        $redeem_voucher = RedeemVoucher::orderBy('kategory', 'asc');

        $redeem_not_valid = RedeemHistory::where('is_valid', 0);
        if ($date_range) {
            $redeem_voucher = $redeem_voucher->whereBetween('updated_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
            $redeem_not_valid = $redeem_not_valid->whereBetween('updated_at', [$start_date . " 00:00:00", $end_date . " 23:59:59"]);
        }

        $redeem_not_valid = $redeem_not_valid->get()->count();
        $redeem_voucher = $redeem_voucher->get();
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


        return view('excel.voucher_redeem', [
            'kategory_aset' => $kategory_aset,
            'jumlah_belum' => $jumlah_belum,
            'jumlah_sudah' => $jumlah_sudah,
            'redeem_voucher' => $redeem_voucher,
            'redeem_not_valid' => $redeem_not_valid
        ]);
    }
}
