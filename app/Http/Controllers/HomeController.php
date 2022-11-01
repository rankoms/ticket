<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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
}
