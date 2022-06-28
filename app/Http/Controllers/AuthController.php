<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ResPartner;
use App\Models\ResUser;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Session;

class AuthController extends Controller
{

    use AuthenticatesUsers;
    public function index()
    {
        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        try {
            request()->validate([
                'email' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => 'required|recaptcha',
            ]);

            $curl = curl_init();
            $db = \config('odoo.odoo_database');
            $url = \config('odoo.odoo_base_url');
            $email = $request->email;
            $password = $request->password;

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url . '/web/session/authenticate/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HEADER => true,
                CURLOPT_POSTFIELDS => '{
                "jsonrpc": "2.0",
                "params":{
                    "login": "' . $email . '",
                    "password": "' . $password . '",
                    "db": "' . $db . '"
                }
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);
            /** START UNTUK MENAMBAHKAN HEADER CURL */
            $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $headerStr = substr($response, 0, $headerSize);
            $bodyStr = substr($response, $headerSize);
            $headers = headersToArray($headerStr);
            if (!isset($headers['Set-Cookie'])) {
                return redirect()->route('login')->with(['error' => 'Terjadi kesalahan server']);
            }
            $header = trim($headers['Set-Cookie']);
            $data = explode("=", $header);
            $data = explode(";", $data[1]);
            Session::forget('session_id');
            $session['session_id'] = $data[0];
            Session::push('session_id', $session);

            curl_close($curl);
            $response = json_decode($bodyStr);
            // dd($response);
            if (!isset($response->error)) {
                if (!isset($response->result)) {
                    return redirect()->route('login')->with(['error' => 'Kesalahan Login/Password 1']);
                }
                $result = $response->result;
                $res_user = ResUser::find($result->uid);
                auth()->login($res_user, true);
                return redirect()->route('dashboard');
            }
            return redirect()->route('login')->with(['error' => 'Kesalahan Login/Password 2']);
        } catch (Exception $error) {
            return redirect()->route('login')->with(['error' => 'Kesalahan Login/Password 3']);
        }
    }

    public function forgot_password()
    {
        return view('auth.forgot_password');
    }
    public function change_password()
    {
        return view('auth.change_password');
    }

    public function auth_logout()
    {
        Auth::logout();
        return redirect()->route('splash_screen');
    }
}
