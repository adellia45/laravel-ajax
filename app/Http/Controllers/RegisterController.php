<?php

namespace App\Http\Controllers;

use App\Models\User; // ✅ Ganti dari App\User ke App\Models\User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan form register.
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Simpan data user ke database.
     */
    public function store(Request $request)
    {
        //Validasi input dulu
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
        ]);

        // Simpan data user
        $user = User::create([
            'name'     => $request->input('nama_lengkap'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Beri response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register berhasil!',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register gagal!',
            ], 500);
        }
    }
}