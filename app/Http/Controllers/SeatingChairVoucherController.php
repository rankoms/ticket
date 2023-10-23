<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\RedeemVoucher;
use App\Models\SeatingChairVoucher;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;

class SeatingChairVoucherController extends Controller
{
    public function index(Request $request)
    {
        $event = RedeemVoucher::groupBy('event')->select('event')->orderBy('event')->get();
        return view('seating_voucher', compact('event'));
    }

    public function get_seating_tree(Request $request)
    {
        $request->validate([
            'event' => ['required', new ExceptSymbol()],
            'category' => ['required', new ExceptSymbol()]
        ]);
        $event = $request->event;
        $category = $request->category;

        $seating_column = SeatingChairVoucher::orderBy('sort_row', 'asc')->orderBy('sort_column', 'asc');
        if ($event) {
            $seating_column = $seating_column->where('event', $event);
        }
        if ($category) {
            $seating_column = $seating_column->where('category', $category);
        }
        $seating_column = $seating_column->get();
        $hasil_column = [];
        $data_selected = 0;
        $data_total = 0;
        foreach ($seating_column as $key => $value) :
            $hasil_column[$value->sort_row][] = $value;
            $data_total++;
            if ($value->is_seating == 1) {
                $data_selected++;
            }
        endforeach;
        $result_final = [];
        foreach ($hasil_column as $key => $value) :
            array_push($result_final, ['columns' => $value]);
        endforeach;
        $data = ['data_seating' => $result_final, 'data_selected' => $data_selected, 'data_total' => $data_total];
        return ResponseFormatter::success($data);
    }

    public function update_seating(Request $request)
    {
        request()->validate([
            'kode' => ['required']
        ]);
        $kode = $request->kode;
        $seating = SeatingChairVoucher::where('kode', $kode)->update(['is_seating' => 1]);
        return $seating;
    }
    public function get_category(Request $request)
    {
        request()->validate([
            'event' => ['required']
        ]);
        $event = $request->event;

        $category = RedeemVoucher::select('kategory')->where('event', $event)->groupBy('kategory', 'event')->get();
        return ResponseFormatter::success($category);
        return $category;
    }

    public function update_seating_by_id(Request $request)
    {
        request()->validate([
            'id' => ['required', 'numeric']
        ]);
        $id = $request->id;
        $seating_chair = SeatingChairVoucher::find($id);
        if (!$seating_chair) {
            return ResponseFormatter::error(null, __('Not Found'));
        }
        $seating_chair->is_seating = 1;
        $seating_chair->save();
        return ResponseFormatter::success($seating_chair, __('Success'));
    }
}
