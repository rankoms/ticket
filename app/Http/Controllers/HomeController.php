<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Helpers\ResponseFormatter;
use App\Models\Ticket;
use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('home');
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
        if ($request->report == 'redeem_voucher') {
            return redirect()->route('redeem_voucher.dashboard');
        }
        return view('admin.dashboard', compact('event'));
    }

    public function test(Request $request)
    {

        return Excel::download(new TicketExport($request), 'Laporan Ticket.xlsx');
    }

    public function privacy()
    {
        $privacyPolicyFile = file_get_contents(resource_path('docs/privacy.md'));
        $converter = new CommonMarkConverter();
        $privacyPolicyHtml = $converter->convertToHtml($privacyPolicyFile);

        return view('privacy', ['privacy' => $privacyPolicyHtml]);
    }
}
