<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\SeatingChair;
use App\Models\Ticket;
use App\Rules\ExceptSymbol;
use Illuminate\Http\Request;

class SeatingChairController extends Controller
{
    public function index(Request $request)
    {
        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        return view('seating', compact('event'));
    }

    public function get_seating_tree(Request $request)
    {
        $request->validate([
            'event' => ['required', new ExceptSymbol()],
            'category' => ['required', new ExceptSymbol()]
        ]);
        $event = $request->event;
        $category = $request->category;

        $seating_column = SeatingChair::orderBy('sort_row', 'asc')->orderBy('sort_column', 'asc');
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
            'barcode_no' => ['required']
        ]);
        $barcode_no = $request->barcode_no;
        $seating = SeatingChair::where('barcode_no', $barcode_no)->update(['is_seating' => 1]);
        return $seating;
    }
    public function get_category(Request $request)
    {
        request()->validate([
            'event' => ['required']
        ]);
        $event = $request->event;

        $category = Ticket::select('category')->where('event', $event)->groupBy('category', 'event')->get();
        return ResponseFormatter::success($category);
        return $category;
    }
}
