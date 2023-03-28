<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Ticket;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('redeem_voucher.index');
        return view('home_new');
    }

    public function home_new()
    {

        return view('home_new');
    }
    public function splash_screen()
    {
        return view('splash_screen');
    }
    public function welcome()
    {
        $asset[] = [
            'image' => asset('images/mobile/illustrations/multi-user.svg'),
            'title' => 'MULTIUSER',
            'subtitle' => "<p>Aplikasi mendukung <span>Multiuser</span> dengan hak akses yang berbeda-beda, menyesuaikan kebutuhan bisnis.</p>"
        ];
        $asset[] = [
            'image' => asset('images/mobile/illustrations/keamanan.svg'),
            'title' => 'KEAMANAN',
            'subtitle' => "<p>Didukung dengan tingkat keamanan yang tinggi terhadap data pengguna.</p>"
        ];
        $asset[] = [
            'image' => asset('images/mobile/illustrations/solusi.svg'),
            'title' => 'SOLUSI TEPAT',
            'subtitle' => "<p>Solusi tepat untuk berbagai kategori bisnis, dari skala kecil hingga besar.</p>"
        ];
        $asset[] = [
            'image' => asset('images/mobile/illustrations/get-started.svg'),
            'title' => 'Let’s Get Started',
            'subtitle' => "<p>Never a better time than now to start thinking about how you manage all your stuff with ease.</p>"
        ];
        return view('welcome', compact('asset'));
    }

    public function dashboard_new()
    {
        return view('home_new');
    }

    public function dashboard(Request $request)
    {
        $event = Ticket::groupBy('event')->select('event')->orderBy('event')->get();
        if ($request->report == 'ticket') {
            return redirect()->route('dashboard_ticket', ['event' => $request->event]);
        }
        return view('admin.dashboard', compact('event'));
    }

    public function test()
    {

        $tickets = Ticket::get();
        $event = [];
        $category = [];
        $ticket = [];
        foreach ($tickets as $key => $value) :
            $category[$value->category]['name'] = $value->category;
            $category[$value->category]['event'] = $value->event;

            $event[$value->event]['name'] = $value->event;

            $ticket[$value->id]['barcode'] = $value->barcode_no;
            $ticket[$value->id]['category'] = $value->category;
            $ticket[$value->id]['event'] = $value->event;
            $ticket[$value->id]['max_checkin'] = $value->max_checkin;
            $ticket[$value->id]['checkin_count'] = $value->checkin_count;
            $ticket[$value->id]['is_bypass'] = $value->is_bypass;
        endforeach;
        $event_final = [];
        foreach ($event as $key => $value) :
            $event_final[] = $value;
        endforeach;

        $category_final = [];
        foreach ($category as $key => $value) :
            $category_final[] = $value;
        endforeach;

        $ticket_final = [];
        foreach ($ticket as $key => $value) :
            $ticket_final[] = $value;
        endforeach;

        $array = [
            "event" => $event_final,
            "category" => $category_final,
            "ticket" => $ticket_final
        ];
        $array = ResponseFormatter::success($array);

        // dd($array);
        // dd(json_encode($array));
        // {
        //     "event":[
        //         {
        //             "name" : "sepak bola"
        //         }
        //         ],
        //     "category":[
        //         {
        //             "name": "Category 1",
        //             "event": "sepak bola"
        //         }],
        //     "ticket":[
        //             {
        //                 "barcode" : 123,
        //                 "category" : "Category 1",
        //                 "event": "sepak bola"
        //             }
        //         ,
        //             {
        //                 "barcode" : 1234,
        //                 "category" : "Category 1",
        //                 "event": "sepak bola"
        //             }
        //         ]
        // }
        dd($ticket);
    }

    public function privacy()
    {
        $privacyPolicyFile = file_get_contents(resource_path('docs/privacy.md'));
        $converter = new CommonMarkConverter();
        $privacyPolicyHtml = $converter->convertToHtml($privacyPolicyFile);

        return view('privacy', ['privacy' => $privacyPolicyHtml]);
    }
}
