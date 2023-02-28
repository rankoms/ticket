<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return ResponseFormatter::error(null, 'User tidak ditemukan', 400);
        }
        if (!Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error(null, 'Password salah', 400);
        }

        $token = $user->createToken('login')->plainTextToken;
        return ResponseFormatter::success(['user' => $user, 'token' => $token], 'Berhasil');
    }

    public function sign(Request $request)
    {

        $rules = [
            'email' => ['required'],
            'password' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            if (Auth::Attempt($data)) {
                $cekValid = User::where('email', $request->input('email'))->first();
                if (!$cekValid->email_verified_at) {
                    return redirect()->route('verify');
                } else {
                    Session::forget('token');
                    $data_token['token'] = $cekValid->createToken('login')->plainTextToken;
                    Session::put('token', $data_token);
                    return redirect()->back();
                }
            } else {
                return back()->withInput($request->input())->with('message', 'Username/Password Invalid');
            }
        } else {
            return back()->withInput($request->input())->withErrors($validator);
        }
    }
}
