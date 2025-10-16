<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::Create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Register Berhasil',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . Auth::user()->id,
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::find(Auth::user()->id);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'message' => 'Update profile berhasil',
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}

