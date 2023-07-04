<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Helpers\ResponseFormatter;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

        if ($request->report == 'redeem_voucher_list') {
            return redirect()->route('redeem_voucher.dashboard_redeem_list');
        }
        if ($request->report == 'pos') {
            return redirect()->route('pos_ticket.dashboard');
        }
        return view('admin.dashboard', compact('event'));
    }

    public function change_password(Request $request)
    {
        $user = User::get();
        return view('change_password', compact('user'));
    }

    public function update_password(Request $request)
    {
        $password = $request->password;
        if (!$request->user) {
            $user = User::find(Auth::user()->id);
        } else {
            $user = User::find($request->user);
        }
        $user->password = Hash::make($password);
        $user->save();
        return ResponseFormatter::success(null, 'Your Password successfully updated');
    }
    public function test(Request $request)
    {
        $ticket_history = TicketHistory::select(DB::raw('count(id)'), DB::raw("date_part('hour', created_at)"))->groupBy(DB::raw("date_part('hour', created_at)"))->get();
        dd($ticket_history);
    }

    public function privacy()
    {
        $privacyPolicyFile = file_get_contents(resource_path('docs/privacy.md'));
        $converter = new CommonMarkConverter();
        $privacyPolicyHtml = $converter->convertToHtml($privacyPolicyFile);

        return view('privacy', ['privacy' => $privacyPolicyHtml]);
    }

    public function auto_login_event(Request $request)
    {
        $event = $request->event;
        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials))
            return redirect()->route('login');
        else {
            if ($event) {
                return redirect()->route('dashboard_ticket', ['event' => $event]);
            }
        }
    }
}
