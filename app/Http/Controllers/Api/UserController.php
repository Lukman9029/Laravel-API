<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !='admin') {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk halaman ini!'
            ],403);
        }

        $user = User::all();

        return response()->json([
            'message' => 'Data berhasil diambil.',
            'users' => $user
        ],200);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !='admin') {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk halaman ini!'
            ],403);
        }

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
        
        return response()->json([
            'message' => 'User berhasil dibuat',
            'user' => $user
        ], 201);
    }

    public function show($id)
    {
        if (Auth::user()->role !='admin') {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk halaman ini!'
            ],403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ],404);
        }

        return response()->json([
            'message' => 'Data berhasil diambil',
            'user' => $user
        ],200);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !='admin') {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk halaman ini!'
            ],403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ],404);
        }

        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

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

    public function destroy($id)
    {
        if (Auth::user()->role !='admin') {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk halaman ini!'
            ],403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $user->delete();
        
        return response()->json([
            'message' => 'Data berhasil dihapus',
        ],200);
    }
}

