<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FaceRecognitionController extends Controller
{
    // Register dengan face descriptor
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
            // Memastikan face_descriptor dalam format JSON yang valid
            $faceDescriptor = json_decode($request->input('face_descriptor'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid face descriptor format');
            }
    
            // Simpan user baru
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Password di-hash
    
            // Simpan face descriptor dalam bentuk array atau objek, tanpa encoding JSON
            $user->face_descriptor = $faceDescriptor;  // Simpan langsung sebagai array atau objek
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

        try {
            // Cek apakah user ada di database berdasarkan email
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Decode face descriptor dari database dan request
                $storedFaceDescriptor = json_decode($user->face_descriptor);
                $requestFaceDescriptor = json_decode($request->input('face_descriptor'));

                // Lakukan perbandingan face descriptor (mungkin dengan algoritma lain untuk kecocokan wajah)
                if ($storedFaceDescriptor && $requestFaceDescriptor) {
                    $similarity = $this->compareFaceDescriptors($storedFaceDescriptor, $requestFaceDescriptor);
                    
                    // Toleransi kecocokan, misalnya 0.6 (60%) cocok
                    if ($similarity >= 0.6) {
                        Auth::login($user);
                        return response()->json(['message' => 'User logged in successfully'], 200);
                    }
                }
            }

            return response()->json(['error' => 'Invalid credentials or face mismatch'], 401);
        } catch (\Exception $e) {
            Log::error('Error during user login', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // Fungsi untuk membandingkan face descriptor
    private function compareFaceDescriptors($stored, $input)
    {
        // Implementasi algoritma perbandingan wajah, misalnya dengan cosine similarity
        return $this->cosineSimilarity($stored, $input);
    }

    // Fungsi cosine similarity untuk perbandingan descriptor
    private function cosineSimilarity($a, $b)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        // Menghitung dot product dan magnitudo
        for ($i = 0; $i < count($a); $i++) {
            $dotProduct += $a[$i] * $b[$i];
            $magnitudeA += $a[$i] * $a[$i];
            $magnitudeB += $b[$i] * $b[$i];
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        // Cosine similarity
        return $dotProduct / ($magnitudeA * $magnitudeB);
    }
}
