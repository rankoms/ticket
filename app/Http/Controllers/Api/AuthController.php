<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}
