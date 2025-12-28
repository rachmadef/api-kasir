<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $auth) {}

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required'
        ]);


        $result = $this->auth->login(
            $request->email,
            $request->password,
            $request->role ?? null
        );

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil',
            'data'    => $result
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
