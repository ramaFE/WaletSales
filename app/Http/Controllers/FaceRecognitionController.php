<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FaceRecognitionController extends Controller
{
    // Register User with Face Descriptor
    public function registerWithFace(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'face_descriptor' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'face_descriptor' => $request->face_descriptor,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    // Login User using Face Descriptor
    public function loginWithFace(Request $request)
    {
        $request->validate([
            'face_descriptor' => 'required|array',
        ]);

        $users = User::all();
        $inputDescriptor = $request->face_descriptor;

        foreach ($users as $user) {
            $storedDescriptor = $user->face_descriptor;
            
            if ($storedDescriptor && $this->compareFaceDescriptors($storedDescriptor, $inputDescriptor)) {
                Auth::login($user);
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user,
                ]);
            }
        }

        return response()->json(['error' => 'Face not recognized'], 401);
    }

    // Function to Compare Face Descriptors (Euclidean Distance)
    private function compareFaceDescriptors(array $storedDescriptor, array $inputDescriptor, float $threshold = 0.6)
    {
        $distance = sqrt(array_sum(array_map(fn($s, $i) => ($s - $i) ** 2, $storedDescriptor, $inputDescriptor)));
        return $distance < $threshold;
    }
}
