<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
use app\Services\encryptionRoom;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class apiAuthController extends Controller
{
    //register user
    public function register(Request $request, encryptionRoom $aes)
    {
        try {
            // 1️⃣ Dekripsi input dari client (jika terenkripsi)
            $decrypted = [
                'name' => $aes->decrypt($request->input('name')),
                'email' => $aes->decrypt($request->input('email')),
                'password' => $aes->decrypt($request->input('password')),
            ];
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Decryption failed or invalid ciphertext',
                'message' => $e->getMessage(),
            ], 400);
        }

        // 2️⃣ Validasi input yang sudah didekripsi
        $validated = validator($decrypted, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ])->validate();

        // 3️⃣ Buat user baru (password tetap di-hash sebelum disimpan)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // 4️⃣ Buat token JWT
        $token = JWTAuth::fromUser($user);

        // 5️⃣ (Opsional) Enkripsi ulang token sebelum dikirim ke client
        $encryptedToken = $aes->encrypt($token);

        // 6️⃣ Kirim response
        return response()->json([
            'pesan' => 'Berhasil mendaftar',
            'token' => $encryptedToken, // bisa kirim plain token jika diinginkan
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 201);
    }

    // public function register(Request $request){
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password'])
    //     ]);

    //     $token = JWTAuth::fromUser($user);

    //     return response()->json([
    //         'pesan' => 'berhasil mendaftar',
    //         'token' => $token,
    //         'user' => $user,
    //     ], 201);
    // }

    //login user

    public function login(Request $request, encryptionRoom $aes)
    {
        try {
            // 1️⃣ Dekripsi data yang dikirim dari client
            $email = $aes->decrypt($request->input('email'));
            $password = $aes->decrypt($request->input('password'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Decryption failed',
                'message' => $e->getMessage(),
            ], 400);
        }

        // 2️⃣ Siapkan kredensial hasil dekripsi
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        // 3️⃣ Lakukan autentikasi dengan JWTAuth
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Email atau password salah',
            ], 401);
        }

        // 4️⃣ Dapatkan user yang sedang login
        $user = Auth::user();

        // 5️⃣ (Opsional) Enkripsi token JWT sebelum dikirim ke client
        $encryptedToken = $aes->encrypt($token);

        // 6️⃣ Kirim respons
        return response()->json([
            'pesan' => 'Login berhasil',
            'token' => $encryptedToken, // bisa kirim token asli jika mau
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    // public function login(Request $request) {
    //     $credentials = $request->only('email', 'password');

    //     if(!$token = JWTAuth::attempt($credentials)) {
    //         return response() -> json(['error' => 'email atau password salah'], 401);
    //     }
    //     return response()->json([
    //         'pesan' => 'login berhasil',
    //         'token' => $token,
    //         'user'=> Auth::user(),
    //     ]);
    // }

    //tampil user
    public function profile() {
        $user = Auth::user();
        return response() -> json([
            'pesan' => 'pengguna berhasil ditampilkan',
            'user' => $user,
        ]);
    }
}