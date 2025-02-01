<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FaceRecognitionController extends Controller
{
    // Register with face descriptor
    public function registerWithFace(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'face_descriptor' => 'required|json', // Pastikan data face descriptor dikirim sebagai JSON
        ]);

        // Log untuk memeriksa face_descriptor yang diterima
        Log::info('Received face descriptor:', ['face_descriptor' => $request->input('face_descriptor')]);

        try {
            // Simpan user baru
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Password di-hash
            $user->face_descriptor = json_encode($request->face_descriptor); // Simpan sebagai JSON
            $user->save();

            // Log untuk debug
            Log::info('User registered with face descriptor:', ['user_id' => $user->id]);

            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            Log::error('Error during user registration', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // Login menggunakan face descriptor
    public function loginWithFace(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'face_descriptor' => 'required|json',  // Pastikan face_descriptor dikirim dalam format JSON
    ]);

    // Cek apakah user ada di database berdasarkan email
    $user = User::where('email', $request->email)->first();

    if ($user && json_decode($user->face_descriptor) == json_decode($request->face_descriptor)) {
        // Jika face descriptor cocok
        Auth::login($user);
        return response()->json(['message' => 'User logged in successfully'], 200);
    } else {
        return response()->json(['error' => 'Invalid credentials or face mismatch'], 401);
    }
}
    

}
