<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class apiAuthController extends Controller
{
    //register user
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'pesan' => 'berhasil mendaftar',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    //login user

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if(!$token = JWTAuth::attempt($credentials)) {
            return response() -> json(['error' => 'email atau password salah'], 401);
        }
        return response()->json([
            'pesan' => 'login berhasil',
            'token' => $token,
            'user'=> Auth::user(),
        ]);
    }

    //tampil user
    public function profile() {
        $user = Auth::user();
        return response() -> json([
            'pesan' => 'pengguna berhasil ditampilkan',
            'user' => $user,
        ]);
    }
}